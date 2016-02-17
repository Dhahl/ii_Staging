<?php defined('DACCESS') or die ('Access Denied!');
 //include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
include"./classes/access_user/access_user_class.php";

class Loginmodel extends Model {
 
    function __construct() {
        parent::__construct();
    }
    
    public function updatePassword()	{
    	$act_password 	=	 new Access_user;
		if (isset($_GET['forgot_reset']) && isset($_GET['id'])) { // this two variables are required for activating/updating the account/password
    		if ($act_password->check_activation_password($_GET['forgot_reset'], $_GET['id'])) { // the activation/validation method 
				$_SESSION['activation'] = $_GET['forgot_reset']; // put the activation string into a session or into a hdden field
				$_SESSION['id'] = $_GET['id']; // this id is the key where the record have to be updated with new pw

			if ($act_password->activate_new_password($_POST['password'], $_POST['confirm'], $_SESSION['activation'], $_SESSION['id'])) { // this will change the password
				unset($_SESSION['activation']);
				unset($_SESSION['id']); // inserts new password only ones!
			} 
		}
//	$act_password->user = $_POST['user']; // to hold the user name in this screen (new in version > 1.77)
	} 
	if($act_password->msgNo		==	30)	{
		$_SESSION['ok']	= true;
	}
	else	{
		$_SESSION['ok']					= 	false;
		$_SESSION['err']['field'][0]	=	'password';
		$_SESSION['err']['msg'][0]		=	$act_password->the_msg;
		}
/*
var_dump($error);
var_dump($_GET);
var_dump($_POST);
var_dump($_SESSION);
die;
*/	
    } 
    public function getLogin() {
    	//echo "GetLogin";
  			$this->my_access = new Access_user;
			$this->my_access->login_reader();
		if (isset($_POST['Submit'])) {
 			return $this->login();
 		}
 		else	{
			return "";
	 	}
    }
    public function login()	{
    	
		if (isset($_POST['Submit'])) {
			$this->my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; // use a cookie to remember the login
			$this->my_access->count_visit = true; // if this is true then the last visitdate is saved in the database
			
			/* 
			 * Get the user id / name for signing on .
			 */
			
			
			$this->my_access->login_user($_POST['login'], $_POST['password']); // call the login method
		} 
		$error = $this->my_access->the_msg;
		if($error=="")	{
			
			$this->my_access->get_user_info();
			$this->my_access->set_user();
			$_SESSION['userEmail']		=	$this->my_access->email;
			$_SESSION['userPublisher']	=	$this->my_access->publisher;
			$_SESSION['user_pw']		=	$_POST['password'];
			$user						=	$_POST['login'];
			if(($_GET['publisher'] == 1) && (($this->my_access->accessLevel < 3) || ($this->my_access->accessLevel == 10))) 
				header( 'Location: ../publish/?user='.$user ) ;
			else
			header( 'Location: ../?user='.$user ) ;
		}
		else 	{
			$_SESSION['ok']		= 	false;
			$_SESSION['err']['msg']	=	$error;
		}
		return $error;
    }
    public function validUser()	{
    	$_SESSION['firstname']			=	$_POST['firstname'];
    	$_SESSION['lastname']			=	$_POST['lastname'];
    	$_SESSION['publishername']	=	$_POST['publishername'];
    	$_SESSION['email']				=	$_POST['email'];
    	$_SESSION['confirmemail']		=	$_POST['confirmemail'];
    	$_SESSION['telephone']			=	$_POST['telephone'];
    	$_SESSION['position']			=	$_POST['position'];
    	$_SESSION['password']			=	$_POST['password'];
    	$_SESSION['confirm']				=	$_POST['confirm'];
    	$_SESSION['userType']			= 	$_POST['usertype'];
    	
		$rtn =	true;
/*		if($_GET['fullname']	==	"")	{
				$err['field'][]	=	'fullname';
				$err['msg'][]	=	'Please enter a Name';
				$rtn 			=	false;
		}
		if($_GET['publishername']	==	"")	{
				$err['field'][]	=	'publishername';
				$err['msg'][]	=	'Please enter a Publishing Company name';
				$rtn 			=	false;
		}
		*/
		if($_POST['email'] 	!= $_POST['confirmemail'])	{
			$err['field'][]	=	'email';
			$err['msg'][]	=	'e-mail and confirmation e-mail must be the same';
			$rtn 			=	false;
		}
    	$new_member = new Access_user;
//    	$pwd	=	'temporarypassword';

    	if($rtn		==	true)	{
			$new_member->register_user($_POST['firstname'], $_POST['password'], $_POST['confirm'], $_POST['firstname'], 
				date("Y-m-d H:i:s"), $_POST['email'], $_POST['publishername'], $_POST['lastname'], 
				$_POST['telephone'], $_POST['position'], $_POST['usertype']); 
			$ok = $new_member->msgNo; // error message
			$err['msg'][]	=	$new_member->the_msg;
/*			var_dump($err);
			die;
			*/
			switch ($ok)	{
				case 12:
					$err['field'][]	=	'email';
					$rtn 			=	false;
					break;
				case 17:
					$err['field'][]	=	'firstname';
					$err['field'][]	=	'email';
					$rtn 			=	false;
					break;
				case 13:
					$rtn 	=	true;
 			   		$_SESSION['firstname']	=	"";
   		 			$_SESSION['lastname']	=	"";
   		 			$_SESSION['publishername']	=	"";
   		 			$_SESSION['email']		=	"";
   		 			$_SESSION['position']	=	"";
   		 			$_SESSION['telephone']	=	"";
   		 			$_SESSION['password']	=	"";
   		 			$_SESSION['confirm']	=	"";
					break;
				case 14:
					$err['field'][]	=	'email';
					$rtn 			=	false;
					break;
				case 15:
					$err['field'][]	=	'email';
					$rtn 			=	false;
					break;
				case 16:
					$err['field'][]	=	'email';
					$rtn 			=	false;
					break;
				case 32:
				case 38:
					$err['field'][]	=	'password';
					$err['field'][]	=	'confirm';
					$rtn			=	false;
					break;
				default:
			}
    	}
		$_SESSION['err']	= $err;
/*
	var_dump($_SESSION);
		var_dump($rtn);
		die;
 */
		return $rtn;
    }
    function activate($key, $id)	{
/*echo "Application path = ".APPLICATION_PATH.'<br>';
echo "Class Path = ".CLASS_PATH.'<br>';
die;*/
    	$new_member	=	new Access_user();
    	$new_member->activate_account($key, $id);
    		unset($_SESSION['activated']);
    		unset($_SESSION['activateFail']);    		
    		unset($_SESSION['err']);
    	
    	if($new_member->msgNo	==	18)	{
    		$new_member->get_user_info_by_id($key, $id);	
    		$new_member->set_user();
    		$_SESSION['activated']	=	true;
			$_SESSION['ok']			=	true;
    	}
    	else	{
			$_SESSION['activateFail']	= 	true;
			$_SESSION['err']['msg'][0]		=	$new_member->the_msg;    		
    	}
/*    		var_dump($_SESSION);
    		var_dump($new_member);
    		die;
*/
/**********************************
 * 
 * 	LIVE Version	
 * 
 **********************************/
     	$nextPage	=	'login/';
    	
 /*********************************
  * 
  *	DEVELOPMENT Version
  *
    	$nextPage	=	CLASS_PATH.'login/';
 **********************************/   	
    	
 /* both / regardless...	*/   	
   		header( 'Location:'.$nextPage );
    }
    function validForgot()	{
    	$_SESSION['email']		=	$_GET['email'];
    	
    	$new_member = new Access_user;

		$new_member->forgot_password($_GET['email']); 
		$ok = $new_member->msgNo; // error message number
/*
 * 
var_dump($new_member);
die;
 */
		$rtn =	false;
		switch ($ok)	{
			case 23:
				$rtn 					=	true;						//Success! (sent email)
 				$err['msg'][]			=	$new_member->the_msg;
		   		$_SESSION['username']	=	"";
    			$_SESSION['email']		=	"";
				break;
			case 14:
				$err['msg'][]			=	$new_member->the_msg;
				$err['field'][]			=	"email";
				break;
			case 15:
 				$err['msg'][]			=	"We have no record of that email address. Please the Register option to get in touch";
				$err['field'][]			=	"email";
 				break;
			case 16:
			case 22:
				$err['field'][]			=	'email';
 				$err['msg'][]			=	$new_member->the_msg;
			default:
			}
		$_SESSION['err']	= $err;
		return $rtn;
    	
    }
    function loadPublishers()	{
    	$_SESSION['publisherNames']	= array();
		$sql = "SELECT * FROM publishers  order by name";
        $this->database->query($sql);
        $publishers	= $this->database->loadObjectList();
        foreach($publishers as $idx=>$publisher){
        	$_SESSION['publisherNames'][]	=	$publisher->name;
        }
        return;
    	
    }
    
}