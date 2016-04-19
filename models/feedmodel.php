<?php
defined('DACCESS') or die ('Access Denied!');
 //include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
include"./classes/access_user/access_user_class.php";
class Feedmodel extends Model {
     function __construct() {
        parent::__construct();
     }
	public function getFeeds() {
	/*
	 * Returns array of ['new'] & ['staged'] xml files matching User id '122370_47174'
	 * 	elements: key=file name, value=no. of staged records
	 * 
	 */
		$files = array();

		$dir = '../ii_staging/';
		$files['new'] = $this->getFormattedFileNames($dir);

		$dir = $dir.'nielsen_staged/';
		$files['staged'] = $this->getFormattedFileNames($dir);

		return $files;
	}
	function getFormattedFileNames($dir) {
		if ($dp = opendir($dir)) {
			while (($file = readdir($dp)) !== false) {
				$fileArr = explode('.',$file);
				$fileName = explode('_',$fileArr[0]);

				if ((end($fileArr) == 'xml') && (substr($fileArr[0],0,12) == '122370_47174')){
					$files[$file] = $this->checkFeed($file);
				}
			}
       		closedir($dp);
       	}
       	return $files;
    }
	
    public function checkFeed($file) {
		$sql = 'select count(*) as rows, user_id from publications where user_id = "'.$file.'" group by user_id ';
		$this->database->query($sql);
		$res = $this->database->loadObject();
		if($res) return $res->rows;
    }
    public function file2Button($file,$dir=''){
    	$style = '';
    	$feedDate = $this->parseFileName($file);
    	return '<button id="'.$file.'"'.' type="button" class="btn-default btn-xs" onclick="myCall(\''.$dir.$file.'\');" >'. $feedDate .$style.'</button>';
    
    }
    public function parseFileName($fileName) {
    	$fileParsed = explode('_',$fileName);
    	$date=date_parse($fileParsed[3]);
    	return $fileParsed[2].'-'.$date['year'].'-'.$date['month'].'-'.$date['day'].'-'.$fileParsed[4];
    }
    
}