<?php
defined('DACCESS') or die ('access denied');
include"./classes/access_user/access_user_class.php";

class Profilemodel extends Model {
     function __construct() {
        parent::__construct();
     }
        public function getProfile() {
/*      	var_dump($_POST);
    	var_dump($_GET);
    	die ('Profile Model');
    	
   		$where = "WHERE id = '". $_SESSION['id']."'";
		$query = 'SELECT * FROM users '.$where;
	
		$this->database->query($query);
		$profile = 	$this->database->loadObjectList();
 		
		return $profile;*/
    }
    	function getUser()	{
		//$sql = "SELECT * FROM users where email = '".$email."'";
		
		$where = "WHERE id = '". $_SESSION['id']."'";
		$query = 'SELECT * FROM users '.$where;
	
		$this->database->query($query);
		$profile = 	$this->database->loadObjectList();
		
        $this->setSessionUserEdit($profile[0]);
        return $profile;
	}
	function setSessionUserEdit($user)	{
		$_SESSION['origUser']				=	$user->id;
		$_SESSION['origUserFirstName']		=	$user->real_name;	
		$_SESSION['origUserLastName']		=	$user->lastname;
		$_SESSION['origPublisherName']		=	$user->publisher;
		$_SESSION['origTelephone']			=	$user->telephone;
		$_SESSION['origPosition']			=	$user->position;
		$_SESSION['origEmail']				=	$user->email;
		
		$_SESSION['userId']					=	$user->id;
		$_SESSION['firstname']				=	$user->real_name;	
		$_SESSION['lastname']				=	$user->lastname;
		$_SESSION['publishername']			=	$user->publisher;
		$_SESSION['telephone']				=	$user->telephone;
		$_SESSION['position']				=	$user->position;
		$_SESSION['email']					=	$user->email;
		$_SESSION['password']				=	$_SESSION['user_pw'];
		$_SESSION['passwordconfirm']		=	"";
		
		$_SESSION['err']		=	array();
	}
    function validateProfile()	{
    	$_SESSION['firstname']		=	$_POST['firstname'];
    	$_SESSION['lastname']		=	$_POST['lastname'];
    	//$_SESSION['publishername']	=	$_POST['publishername'];
    	$_SESSION['email']			=	$_POST['email'];
    	$_SESSION['telephone']		=	$_POST['telephone'];
    	$_SESSION['position']		=	$_POST['position'];
    	$_SESSION['password']		=	$_POST['password'];
    	$_SESSION['passwordconfirm']=	$_POST['passwordconfirm'];
    	$err		=	array();
    	$new_member = 	new Access_user;
		$firstname	=	$_POST['firstname'];
		$lastname	=	$_POST['lastname'];
		$publisher	=	$_SESSION['publishername'];
		$position	=	$_POST['position'];
		$telephone	=	$_POST['telephone'];
		$email		=	$_POST['email'];
    	$pwd		=	$_POST['password'];
		$confirm	=	$_POST['passwordconfirm'];
		$rtn =	true;
		if($firstname	==	"")	{
			$err['field'][]	=	"firstname";
			$err['msg'][]	=	"Please enter a First Name";
			$rtn =	false;
		}
		if($lastname	==	"")	{
			$err['field'][]	=	"lastname";
			$err['msg'][]	=	"Please enter a Last Name";
			$rtn =	false;
		}
/*		if($publisher	==	"")	{
			$err['field'][]	=	"publisher";
			$err['field'][]	=	"Enter a Publisher name";
			$rtn =	false;
		}*/
		if($position	==	"")	{
			$err['field'][]	=	"position";
			$err['msg'][]	=	"Please enter your Position";
			$rtn =	false;
		}
		
		$new_member->user_email	= 	$_SESSION['origEmail'];
		$new_member->id			=	$_SESSION['userId'];
		$new_member->user_pw	=	$_SESSION['user_pw'];
		$new_member->update_user($pwd, $confirm, $firstname, date("Y-m-d H:i:s"), $email, $publisher, $lastname, $telephone, $position );

    	$status = $new_member->msgNo; // error message
		$err['msg'][]	=	$new_member->the_msg;
		switch ($status)	{
			case 32:		//	password
				$err['field'][]	= "password";
				$rtn =	false;
				break;
			case	38:
				$err['field'][]	= "password";
				$rtn =	false;
				break;
			case	31:
				$err['field'][]	=	"email";
				$rtn =	false;
				break;
			case 	16:
				$err['field'][]	=	"email";
				$rtn =	false;
				break;
			case 30:							// success
				break;
			default:
			}
		$_SESSION['err']	= $err;
		$_SESSION['msg'] = $err['msg'];
		
		return $rtn;
    } 
    
}
?>