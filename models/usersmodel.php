<?php
defined('DACCESS') or die ('Access Denied!');
 
class Usersmodel extends Model {
 
    function __construct() {
        parent::__construct();
    }
     
    public function getUsersList() {
        $sql = "SELECT * FROM #__users";
        $this->database->query($sql);
        return $this->database->loadObjectList();
    }
}