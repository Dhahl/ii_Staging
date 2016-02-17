<?php
/*********************************************************************
 * 
 * 	return:
 *  	true - if any feeds are at Stage status, 
 *  	false  - if none are at Stage status.
 *  
 *  Stage status = true when a feed is in the input folder 
 *  	AND book records for this feed file are found 
 *  			in the Staging database
 *  
 ********************************************************************/
define('DACCESS',1);
include 'includes/defines.php';
include 'libraries/Database.php';
include 'classes/openITIreland/class.nielsen.php';

$db = new Database;
$files = getFeeds($db);
$rtn = 0;

foreach($files as $file=>$rcds){
	if($rcds !=0) $rtn=1;
}
echo $rtn;
function getFeeds($db) {
	$dir = '../ii_2/';
	$files = array();
	if ($dp = opendir($dir)) {
		while (($file = readdir($dp)) !== false) {
			$fileArr = explode('.',$file);
			$fileName = explode('_',$fileArr[0]);

			if ((end($fileArr) == 'xml') && (substr($fileArr[0],0,12) == '122370_47174')){
				$files[$file] = checkFeed($db,$file);
			}
		}
		closedir($dp);
	}
	return $files;
}
function checkFeed($db,$file) {
	$sql = 'select count(*) as rows, user_id from publications where user_id = "'.$file.'" group by user_id ';
	$db->query($sql);
	$res = $db->loadObject();
	if($res) $status = 1;
	else $status = 0;
	return $status;
}
?>