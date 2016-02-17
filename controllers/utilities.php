<?php
defined('DACCESS') or die ('Access Denied!');

if(!isset($_SESSION['accessLevel'])) {
		header( 'Location: ../');
		die('not set'); 
}

if($_SESSION['accessLevel'] != '10') {
	header( 'Location: ../');
	die ('not admin');
}
class Utilities extends Controller {
 
    function __construct() {
      parent::__construct();
        $this->load->model('utilitiesmodel');
  }
     
    public function index() {
    	if(isset($_POST['resetHistory']))	{
    	    $this->utilitiesmodel->resetHistory();			// Display user options
    	}
 		$data['utilities'] = $this->utilitiesmodel->listOptions();
    	$this->load->view('utilities',$data);
  	}
}