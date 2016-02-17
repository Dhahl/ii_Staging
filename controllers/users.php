<?php
defined('DACCESS') or die ('Access Denied!');
 
class Users extends Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('usersmodel');
    }
     
    public function index() {
        $data['users'] = $this->usersmodel->getUsersList();
        $this->load->view('users',$data);
    }
}