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
//    include 'classes/openITIreland/class.nielsen.php';
/*LIVE */
    $user='i561957_IIUser';
    $pass='Gingerman1';
    $mySqlDumpExe 	= 'mysqldump ';
	$mySqlExe 	= 	'mysql ';
	$mySqlSrcDB = ' i561957_irishinterest ';
	$mySqlTrgDB = ' i561957_development ';

/* LOCAL 
    $user='';
    $pass='';
	$mySqlDumpExe 	= 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump ';
	$mySqlExe 	= 	' C:\wamp\bin\mysql\mysql5.6.17\bin\mysql ';
	$mySqlSrcDB = ' staging_irishinterest ';
	$mySqlTrgDB = ' dev_irishinterest';
	
    $host='localhost';
	$mySqlCred 	= 	'--user='.$user.
    				' --password='.$pass .
    				' --host='.$host;
    $mySqlTbl =  ' authors author_x_book categories publications publishers ';
*/
	
	/*
	 * Move all files from Staging Folder to Committed 
	 */
    $stagingDir = 'nielsen_staged/';
    $committedDir = 'nielsen_committed/';
    $files = glob($stagingDir.'*'); // get all file names
    $rtn = '';
    echo '<h1>Commiting all Staged Files</h1><h2>Push Staging Area database to Irish Interest live site</h2>';
    foreach($files as $file){ // iterate files
    	if(is_file($file)) {
    		$file_ = ltrim($file,$stagingDir);
    		$s = rename($file,$committedDir.$file_); // move file
    		if($s) $rtn .= "<br>File ".$file." moved to ".$committedDir;
    	}
    	else $rtn .= "<br>File ".$file." Not found";
    }
    echo $rtn;
    echo '<p>'.count($files).' Staged file(s) moved to committed folder</p>';
    /* 
     * move all images from staging area to Live /uploads
     */
    $stagingDir = 'upload/';
    $liveDir 	= '../ii_2/';
    $files = glob($stagingDir.'*'); // get all file names
    $rtn = '';
    foreach($files as $file){ // iterate files
    	if(is_file($file)) {
    		$s = rename($file,$liveDir.$file); // move file
    		if($s) $rtn .= "<br>File ".$file." moved to ".$liveDir;
    	}
    	else $rtn .= "<br>File ".$file." Not found";
    }
    echo $rtn;
    echo '<p>'.count($files).' image(s) moved to Live site';

    echo "<p>Copying Files: ";
    /*	mysqldump 	*/
    $cmd = $mySqlDumpExe.$mySqlCred.$mySqlSrcDB.$mySqlTbl. ' > temp.sql';
    exec($cmd, $output, $return);

    /* Import	*/
    $cmd = $mySqlExe . $mySqlTrgDB . ' < temp.sql';
    exec($cmd, $output, $return);

    if ($return != 0) { //0 is ok
    die('Error: ' . implode("\r\n", $output));
}

echo 'Copied  '.$mySqlTbl.'from '.$mySqlSrcDB.' to '.$mySqlTrgDB.'</p>';
echo "Complete. ";
?>
</body>
</html>