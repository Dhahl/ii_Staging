<?php 
defined('DACCESS') or die ('Access Denied!');

/* 				========================
 * 				NB.	DEVELOPMENT VERSION
 * 				========================
 * 
 * 			Un-comment the code below for secure access on Live Version 
 * 
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
 */

class Login extends Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('loginmodel');
    }
     
    public function index() {
		if($_POST['register']	== 'save')	{
       		$_SESSION['ok']	=	$this->loginmodel->validUser();
       		$this->load->view('login',$data);
   	    }
   	    elseif(isset($_POST['update_password']))	{
   	    	$this->loginmodel->updatePassword();
       		$this->load->view('login',$data);
   	    }
   	    
    	elseif(isset($_GET['activate']))	{
    		$this->loginmodel->activate($_GET['activate'], $_GET['ident'] );
    		//header('Location: ./login');
    	}
    	elseif(isset($_GET['forgot_reset']))	{			// force entry of new password
    		$this->load->view('login',$data);
    	}
    	
    	elseif($_GET['register'] == 'register')	{
   	    	$this->loginmodel->loadPublishers();			// get list of defined companies in $ SESSION for Select
    		$data	=	array();
    		$data['login']	=	'register';
	   		$this->load->view('login',$data);
    	}
  		elseif($_GET['forgot']	==	'submit')	{
  			$_SESSION['ok']	=	$this->loginmodel->validForgot();

  			$this->load->view('login',$data);
  		}
  		elseif($_GET['forgot']	==	'password')	{
	  		$data	=	array();
  			$data['login']		=	'forgot';
  			$this->load->view('login',$data);
  		}
	   	else	{
			$data['login'] = $this->loginmodel->getLogin();
   	    	$this->load->view('login',$data);
   		}
  	}
  	public function forgotpassword()	{
  	}
}