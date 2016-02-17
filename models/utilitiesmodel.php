<?php
defined('DACCESS') or die ('access denied');
include"./classes/access_user/access_user_class.php";
include "./classes/openitireland/class.upload.php";
include "db_config.php"; 
class Utilitiesmodel extends Model {
 
    function __construct() {
        parent::__construct();
    }
function resetHistory() {
	$this->connect_db();
	$sql = "truncate search_history";
	$result = mysql_query($sql) ;
	if($result = true) {
		$status['msg'][] = 'Search History has been cleared';
		$_SESSION['msg']	= $status['msg'];
		
	}	
	}
	
	function listOptions() {
		
	}
	function connect_db() {
		$conn_str = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME); // if there are problems with the tablenames inside the config file use this row 
	}
	
}