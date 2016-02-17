<?php
define('DACCESS',1);
include 'includes/defines.php';
include 'libraries/Database.php';
include 'classes/openITIreland/class.nielsen.php';

$db = new Database;
$files = getFeeds($db);
foreach($files as $button){
	echo $button;
}
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
	if($res) $status = true;
	else $status = false;
	return file2Button($file,$status);
}
function file2Button($file,$status){
	$style = '';
	$feedDate = parseFileName($file);
	if($status) $style = ' <span class="glyphicon glyphicon-star" aria-hidden="true"></span> ';
	return '<button id="'.$file.'"'.' type="button" class="btn btn-default btn-sm" onclick="myCall(\''.$file.'\');" >'. $feedDate .$style.'</button>';
	
}
function parseFileName($fileName) {
	$fileParsed = explode('_',$fileName);
	$date=date_parse($fileParsed[3]);
	return $fileParsed[2].'-'.$date['year'].'-'.$date['month'].'-'.$date['day'].'-'.$fileParsed[4];
}
/*
$files = $feed;
$fileNames = array();
if ($files) {
	foreach ($files as $file=>$bookCount) {
		$fileNames[] = $file;		// for JS
		$feedDate = parseFileName($file);
		$style='';
		if($bookCount) $style = ' <span class="glyphicon glyphicon-star" aria-hidden="true"></span> ';
		echo '<button id="'.$file.'"'.' type="button" class="btn btn-default" onclick="myCall(\''.$file.'\');" >'. $feedDate .$style.'</button>';
	}
} else {
	exit('No files found.');
}

echo '
		<span class="glyphicon glyphicon-star" aria-hidden="true"></span> ';
		*/	
?>