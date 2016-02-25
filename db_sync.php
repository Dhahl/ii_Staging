<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
    <meta charset="http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <body>
    <?php
    define('DACCESS',1);
    include 'includes/defines.php';
    include 'libraries/Database.php';
    include 'classes/OpenITIreland/class.nielsen.php';
    
    $user='i561957_IIUser';
    $pass='Gingerman1';
    $host='localhost';
	$mySqlDumpExe 	= 'mysqldump ';
	$mySqlExe 	= 	'mysql ';
	
	$mySqlCred 	= 	'--user='.$user.
    				' --password='.$pass .
    				' --host='.$host;
	
	$mySqlSrcDB = ' i561957_irishinterest ';
	$mySqlTrgDB = ' i561957_development ';
	
	$mySqlTbl =  ' authors author_x_book categories publications publishers ';
	
	echo "<p>Copying Files ...";
	/*	mysqldump 	*/
	$cmd = $mySqlDumpExe.$mySqlCred.$mySqlSrcDB.$mySqlTbl. ' > temp.sql';
	exec($cmd, $output, $return);	
	
	/* Import	*/
	$cmd = $mySqlExe . $mySqlTrgDB . ' < temp.sql';
	exec($cmd, $output, $return);
	
    if ($return != 0) { //0 is ok
    	echo $cmd;
    	die('Error: ' . implode("\r\n", $output));
    }
    
    echo "Complete<br></p>";    
	echo 'Copied  '.$mySqlTbl.'from '.$mySqlSrcDB.' to '.$mySqlTrgDB.'<br>';

	/* Strip embedded '-' from Books ISBN13 field in staging database. */
	$db = new Database;
	echo "<p>Changing Tables ...</p>";
	$cmd = ' alter table '.trim($mySqlTrgDB).'.publications modify user_id VARCHAR(40)' ;
	$db->query($cmd);
	$cmd = ' alter table '.trim($mySqlTrgDB).'.authors modify createdby VARCHAR(40)' ;
	$db->query($cmd);
	
	$rpl = array('-',' ','.');
	$sql = 'select * from publications ';
	$db->query($sql);
	$books = $db->loadObjectList();
	foreach($books as $book){
		if(!$book->isbn13 == '') {
			echo '<br>'.$book->isbn13;
			$isbn13 = str_replace($rpl,'',$book->isbn13);
			$isbn13 = preg_replace('/[a-z]/i','',$isbn13);
			if($isbn13 != $book->isbn13) {
				echo ' -> '.$isbn13;
				$sql = 'update publications set isbn13	 = "'.$isbn13 . '" where id = '.$book->id;
				//echo '<br>'.$sql.'<br>';
				$db->query($sql);
			}
		}
	}
			
	?>
    </body>
</html>