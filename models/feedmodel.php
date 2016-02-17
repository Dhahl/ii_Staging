<?php
defined('DACCESS') or die ('Access Denied!');
 //include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
include"./classes/access_user/access_user_class.php";
class Feedmodel extends Model {
     function __construct() {
        parent::__construct();
     }
	public function getFeeds() {
		$dir = '../ii_2/';
		$files = array();
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
}