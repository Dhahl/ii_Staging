<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
    <meta charset="http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {background-color:lightgrey;}
h1   {color:blue;}
p    {color:green;}
table, th, td {
    border-bottom: 1px solid green;
    border-collapse: collapse;
    padding:5px;
}
td {
	font-family: Tahoma;
	font-size: 12px;
	color: #000000;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
    <body>
    <?php
    define('DACCESS',1);
    include 'includes/defines.php';
    include 'libraries/Database.php';
    include 'classes/OpenITIreland/class.nielsen.php';
/* LIVE     
    $user='i561957_IIUser';
    $pass='Gingerman1';
    $mySqlDumpExe 	= 'mysqldump ';
	$mySqlExe 	= 	'mysql ';
	$mySqlSrcDB = ' i561957_irishinterest ';
	$mySqlTrgDB = ' i561957_development ';
*/
/* LOCAL */
    $user='';
    $pass='';
	$mySqlDumpExe 	= 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump ';
	$mySqlExe 	= 	' C:\wamp\bin\mysql\mysql5.6.17\bin\mysql ';
	$mySqlSrcDB = ' i561957_irishinterest ';
	$mySqlTrgDB = ' staging_irishinterest';
/*	<END>	*/	
	
    $host='localhost';
	$mySqlCred 	= 	'--user='.$user.
    				' --password='.$pass .
    				' --host='.$host;
	$mySqlTbl =  ' authors author_x_book categories publications publishers ';
	
	/*
	 * Move all files from Staging Folder to Web Root
	 */
	$stagingDir = 'nielsen_staged/';
	$rootDir = '';
	$files = glob($stagingDir.'*'); // get all file names
	$rtn = '';
	echo '<h1> Database Sync </h1> <h2>Pull Live database into Staging Area</h2>';
	echo count($files).' Staged files moved to root folder: ';
	foreach($files as $file){ // iterate files
		if(is_file($file)) {
			$file_ = ltrim($file,$stagingDir);
			$s = rename($file,$rootDir.$file_); // move file
			if($s) $rtn .= "<br>File ".$file." moved to ".$rootDir;
			$rtn .= "<br>File ".$file." moved to ".$rootDir;
		}
		else $rtn .= "<br>File ".$file." Not found";
	}
	echo $rtn;
	
	echo "<p>Copying Files: ";
	/*	mysqldump 	*/
	$cmd = $mySqlDumpExe.$mySqlCred.$mySqlSrcDB.$mySqlTbl. ' > temp.sql';
	exec($cmd, $output, $return);
	if($return == false) echo " export... ok,";
			else { echo 'Data dump - Failed';
			die;}
	/*
	 *  Import	
	 */
	echo ' import...';
	$cmd = $mySqlExe . $mySqlCred.$mySqlTrgDB . ' < temp.sql';
	exec($cmd, $output, $return);
	
    if ($return != 0) { //0 is ok
    	echo $cmd;
    	die('Error: ' . implode("\r\n", $output));
    }
    else echo 'ok. ';
    
    echo "Complete. ";    
	echo 'Copied  '.$mySqlTbl.'from '.$mySqlSrcDB.' to '.$mySqlTrgDB.'</p>';

	/* Strip embedded '-' from Books ISBN13 field in staging database. */
	echo "<p>Change User ID field length on Books and Authors</p>";
	$db = new Database;
	$cmd = ' alter table '.trim($mySqlTrgDB).'.publications modify user_id VARCHAR(40)' ;
	$db->query($cmd);
	$cmd = ' alter table '.trim($mySqlTrgDB).'.authors modify createdby VARCHAR(40)' ;
	$db->query($cmd);
	
	echo "<p>Clean up ISBN13 codes...<br></p>";
	$rpl = array('-',' ','.');
	$sql = 'select * from publications ';
	$db->query($sql);
	$books = $db->loadObjectList();
	foreach($books as $book){
		if(!$book->isbn13 == '') {
			$isbn13 = str_replace($rpl,'',$book->isbn13);
			$isbn13 = preg_replace('/[a-z]/i','',$isbn13);
			if($isbn13 != $book->isbn13) {
				echo '<br>'.$book->title.' - '.$book->isbn13.' -----> '.$isbn13;
				$sql = 'update publications set isbn13	 = "'.$isbn13 . '" where id = '.$book->id;
				//echo '<br>'.$sql.'<br>';
				$db->query($sql);
			}
		}
	}
	echo '<br>Done! ';//.count($books).' books imported '		
	?>
    </body>
</html>