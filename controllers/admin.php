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
	
/*
*/
class Admin extends Controller {
 
    function __construct() {
       parent::__construct();
        $this->load->model('adminmodel');
    }
     
    public function index() {
/*
var_dump($_GET);
var_dump($_POST);
var_dump($_SESSION);
    	die;
*/
 		$_SESSION['mode']	=	'';
		
    	if(isset($_POST['save'])	&& ($_POST['save']	== "user"))	{		// Adding a User.
    		$_SESSION['entity']	=	'user';
			$_SESSION['ok']	=	$this->adminmodel->validUser();
		}
		elseif(isset($_POST['save'])	&& ($_POST['save']	== "company"))	{
    		$_SESSION['entity']	=	'company';
			$_SESSION['ok']	=	$this->adminmodel->validCompanyCreate();
		}
   	    $this->adminmodel->loadPublishers();			// get list of defined companies in $ SESSION for Select
		$data['admin'] = $this->adminmodel->listUsers();
    	$this->load->view('admin',$data);
  	}

	public function edit()	{
/*	var_dump($_POST);
	var_dump($_GET);
		die;
			*/
		$_SESSION['mode']	=	"edit";
		
		if(isset($_POST['delete']))	{
			$_SESSION['entity']	=	'user';
			$_SESSION['ok']	=	$this->adminmodel->deleteUser($_POST['delete']);
			header('location: ./');		// back to user list  
			die;
		}
   	 	elseif(isset($_POST['cancel']))	{
	   	 	$this->adminmodel->resetSession();
			$_SESSION['mode']	=	'';	
				header('location: ./');		// back to user list  
   	 	}
   	 	elseif(isset($_POST['deletecompany']))	{
   	 		$_SESSION['entity']	=	'company';
	   	 	$_SESSION['ok']	=	$this->adminmodel->deleteCompany();
	   	 	$this->adminmodel->resetSession();
			header('location: ./');		// back to user list  
			die;	
   	 	}
   	 	elseif(isset($_POST['save'])	&& ($_POST['save']	== "user"))	{
   	 		$_SESSION['entity']	=	'user';
			$_SESSION['ok']	=	$this->adminmodel->validUser();
			if($_SESSION['ok'])	{
				//$_SESSION['mode']	=	'';	
		   	 	$this->adminmodel->resetSession();
				header('location: ./');		// back to user list  
				die;
			}
		}
		elseif(isset($_POST['save'])	&& ($_POST['save']	== "company"))	{
			$_SESSION['entity']	=	'company';
			$_SESSION['ok']	=	$this->adminmodel->validCompanyEdit();
			if($_SESSION['ok'])	{
				//$_SESSION['mode']	=	'';	
				header('location: ./');		// back to user list  
				die;
			}
		}
		else	{													//	Default action - get selected edit 
			if(isset($_GET['user']))	{
				$_SESSION['entity']	=	"user";
				$data['admin'] = $this->adminmodel->getUser($_GET['user']);
			}
			else{
				$_SESSION['entity']	=	'company';
				$data['admin'] = $this->adminmodel->getCompany($_GET['company']);
			}
		}
		$data['admin'] = $this->adminmodel->listUsers();
		$this->load->view('admin',$data);
	}
    public function logout()	{
    	$this->adminmodel->logout();    	
    }
}
