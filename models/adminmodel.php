<?php
defined('DACCESS') or die ('Access Denied!');
 //include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
include"./classes/access_user/access_user_class.php";

class Adminmodel extends Model {
 
    function __construct() {
        parent::__construct();
    }
    function listUsers()	{
		//$sql = 'SELECT * FROM users';
		$sql = 'SELECT  u.*
 ,      (       SELECT  COUNT(*)
                FROM    publications           p
                WHERE   p.user_id      = u.id
        )       AS      "books"
			FROM    users         u'; 
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
 //       var_dump($rtn);
        return $rtn;
//        return $this->database->loadObjectList();
    	
    }
    function getUser($id)	{
    	$_SESSION['id']				=	$_GET['id'];
		$sql = "SELECT * FROM users where id = '".$id."'";
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
        $this->setSessionEdit($rtn[0]);
        return $rtn;
    }
    function getCompany($name)	{
 		$sql 	= 'SELECT * FROM publishers where name = "'.base64_decode($name).'"';
 		
        $SQL_rtn = $this->database->query($sql);
        $rtn 	=	$this->database->loadObjectList();
        $this->setSessionEditCompany($rtn[0]);
        return $rtn;
    }
    function validUser()	{
    	$_SESSION['editfirstname']		=	$_POST['firstname'];
    	$_SESSION['editlastname']		=	$_POST['lastname'];
    	$_SESSION['editpublishername']	=	$_POST['publishername'];
    	$_SESSION['editemail']			=	$_POST['email'];
    	$_SESSION['edittelephone']		=	$_POST['telephone'];
    	$_SESSION['editposition']		=	$_POST['position'];
    	$_SESSION['editactive']			=	($_POST['active'] ==	"1" ? "y"	:	"n");
    	$_SESSION['editaccess']			=	$_POST['access'];							// ="1" or "10"
    	$_SESSION['editpassword']		=	$_POST['editpassword'];
		$conf_str	=	'no';
    	$new_member = new Access_user;
    	if(!$_SESSION['mode']	==	'edit')	{	//  NOT edit: Adding New user : Register
	    	$pwd	=	$_POST['editpassword'];
			$new_member->register_user($_POST['firstname'], $pwd, $pwd, $_POST['lastname'], date("Y-m-d H:i:s"),
			 $_POST['email'], $_POST['publishername'], $_POST['lastname'], $_POST['telephone'], $_POST['position'], $_POST['type']); 
			$ok = $new_member->msgNo; // error message
			if($ok	==	13)	{			// Registered=success. Get ID
        		$id		=	$new_member->id;
    			$_SESSION['id']	=	$id;
			}
//     	var_dump($_SESSION);
//     	var_dump(£new_member);
   	}
    	else	{		//	update record by Admin
//     	var_dump($_SESSION);
//     	var_dump(£new_member);
    		$pwd	=	$_POST['editpassword'];
    		$id		=	$_SESSION['id'];
    	}
/*    	var_dump($pwd);
    	die;
    	*/
    	if( ($ok	== 13)	||	($_SESSION['mode']	==	'edit') ) {			// registered=success or editing existing record
	    	$admin_update_member = new Admin_user;
 		   	$admin_update_member->update_user_by_admin($_POST['access'], $id, $pwd, $_POST['email'], 
    			$_SESSION['editactive'], $conf_str);
			
    		$ok = $admin_update_member->msgNo; // error message
    		if($ok == 0)	{
    			
/*			var_dump($admin_update_member);
	    	die;*/
    		
    		}
    		else	{
		    		$err['msg'][]		=	"The email address is already registered to another user";
	    			$err['field'][]		=	'email';
    		}
    	}
    	/*
var_dump($ok);
die;
*/
 		$rtn =	false;
   		if($_POST['firstname']	==	'')		{
    		$err['msg'][]	=	'Please enter User Name / ID';
    		$err['field'][]	=	'firstname';
    	}
 		if($_POST['lastname']	==	'')		{
    		$err['msg'][]	=	'Please enter Full Name';
    		$err['field'][]	=	'lastname';
    	}
    	if($_POST['publishername']	==	'')	{
    		$err['msg'][]		=	'please enter a Publishing Company';
    		$err['field'][]		=	'publisher';
    	}
    	if($_POST['position']	==	'')	{
    		$err['msg'][]		=	'please enter a Position';
    		$err['field'][]		=	'position';
    	}
    	if($_POST['email']	==	'')	{
    		$err['msg'][]		=	'please enter an email address';
    		$err['field'][]		=	'email';
    	}
    	if(($_POST['editpassword']	==	'') && (!$_SESSION['mode']	==	'edit'))	{
    		$err['msg'][]		=	'please enter a Password';
    		$err['field'][]		=	'password';
    	}
    	$err['msg'][]	=	$new_member->the_msg;
 		switch ($ok)	{
			case 1:		//	password
				$err['field'][]	= "password";
				break;
			case 0:
			case 13:
				$rtn 	=	true;			//	OK
				break;
			case 12:
			case 14:
			case 16:
			case 31:
				$err['field'][]	=	"email";
				break;
			case 3:		// database erro
				break;
			case 17:			// user name/login too short
				$err['field'][]	=	"username";
				break;
			case 32:
			case 38:
				$err['field'][]	=	"password";
				break;
			default:
			}
		$_SESSION['err']	= $err;
		/*
		var_dump($_SESSION);
		die;
		*/
		if($rtn		==	true)	{		// no error - update real_name & extra_info
			$firstName	=	$this->database->getQuotedString($_SESSION['editfirstname']);
			$lastName	=	$this->database->getQuotedString($_SESSION['editlastname']);
			$publisher	=	$this->database->getQuotedString($_SESSION['editpublishername']);
			$telephone	=	$this->database->getQuotedString($_SESSION['edittelephone']);
			$position	=	$this->database->getQuotedString($_SESSION['editposition']);
			
			$SQL	=	"UPDATE users SET real_name = ".$firstName.", ";
			$SQL	.=	"lastname = "	.	$lastName.", ";	
			$SQL	.=	"publisher = "	.	$publisher.", " ;
			$SQL	.=	"telephone = "	.	$telephone.", ";
			$SQL	.=	"position = "	.	$position." ";
			$SQL	.=	" WHERE id = ".$_SESSION['id'] ;
			
/*			$SQL	=	"UPDATE users SET real_name = '".$_SESSION['editfullname'] ."', ";
			$SQL	.=	"publisher = '". $_SESSION['editpublishername'] ."'";
			$SQL	.=	" WHERE id = ".$_SESSION['id'] ;
			var_dump($SQL);
			die;
*/			
			$result 	=	$this->database->query($SQL);
			if(!result)	{
				$rtn	= false;	
			}
		} 
			
		return $rtn;
    }
    function validCompanyEdit()	{
    	$name	=	$this->database->getQuotedString($_POST['companyname']);
    	$url	=	$this->database->getQuotedString($_POST['companyurl']);
    	$oldName=	$this->database->getQuotedString($_SESSION['companyname']);
    	if($name !== $oldName)	{	//	Change of name - check if new name already in the system
	    	$query =	 "SELECT * FROM publishers WHERE  name = ".$name;
    		$result	=	$this->database->query($query);
    		$rtn 	=	$this->database->loadObjectList();
    		$update = 	$this->database->getCountRows() == 0 ? true	: false;
    	}
    	else	{
    		$update	=	 true;
    	}
    	if($update	==	true)	{
       		$query	=	"UPDATE publishers SET	name = ".$name.", url = ".$url.
   						" WHERE name = ".$oldName;
   			$result	=	$this->database->query($query);
   			if(!$result)	$this->resetSession();
   			return true;
    	}
		else {
			$err['msg'][]		=	$name. " - That Company already exists";
	    	$err['field'][]		=	'companyname';
			$_SESSION['err']		=	$err;
			return false;
		}
    } 
    function validCompanyCreate()	{
    	$name	=	$this->database->getQuotedString($_POST['companyname']);
    	$url	=	$this->database->getQuotedString($_POST['companyurl']);
    	//	check if exists
    	$query =	 "SELECT * FROM publishers WHERE  name = ".$name;
    	$result	=	$this->database->query($query);
    	$rtn 	=	$this->database->loadObjectList();
    	
		if ($this->database->getCountRows() == 0)	{
	    	$query	=	"INSERT INTO publishers (name,url) VALUES(".$name.", ".$url.")";
	   		$res2	=	$this->database->query($query);
   			if(!$res2)	$this->resetSession();
   			return true;
		}
		else {
			$err['msg'][]		=	"That Company already exists";
	    	$err['field'][]		=	'companyname';
			$_SESSION['err']		=	$err;
			return false;
		}
    } 
    function setSessionEdit($user)	{
        $_SESSION['id']				=	$user->id;
        $_SESSION['editfirstname']		=	$user->real_name;
    	$_SESSION['editlastname']		=	$user->lastname;
    	$_SESSION['editpublishername']	=	$user->publisher;
    	$_SESSION['editemail']			=	$user->email;
    	$_SESSION['edittelephone']		=	$user->telephone;
    	$_SESSION['editposition']		=	$user->position;
    	$_SESSION['editaccess']			=	$user->access_level;
    	$_SESSION['editactive']			=	$user->active;
    	$_SESSION['editpassword']		=	null;
    	$_SESSION['editpasswordconfirm']=	null;
    	//$_SESSION['user_pw']			=	$user->pw;
    }
    function setSessionEditCompany($company)	{
        $_SESSION['companyname']	=	$company->name;
        $_SESSION['companyurl']		=	$company->url;
    }
    
    function resetSession()	{
        $_SESSION['editfirstname']		=	'';
    	$_SESSION['editlastname']		=	'';
    	$_SESSION['editpublishername']	=	'';
    	$_SESSION['editemail']			=	'';
    	$_SESSION['edittelephone']		=	'';
    	$_SESSION['editposition']		=	'';
    	$_SESSION['editaccess']			=	'';
    	$_SESSION['editactive']			=	'';
    	$_SESSION['editpassword']		=	'';
    	$_SESSION['editpasswordconfirm']=	'';
    	//$_SESSION['user_pw']			=	'';
        $_SESSION['companyname']			=	'';
        $_SESSION['companyurl']			=	'';
    	
    }
    function deleteUser($userId)	{
    	$sql	=	"DELETE FROM users WHERE id = '".$userId."'";
		$result 	=	$this->database->query($sql);
		if(!result)	{
			$rtn	= false;	
		}
		else	{
			$_SESSION['editfirstname']	=	$_POST['firstname'];
			$_SESSION['deleted']	= true;
			$rtn	= true;
		}
	return $rtn;
    }
    function deleteCompany()	{
    	$sql	=	"DELETE FROM publishers	 WHERE name = '".$_POST['companyname']."'";
		$result 	=	$this->database->query($sql);
		if(!result)	{
			$rtn	= false;	
		}
		else	{
			$_SESSION['deleted']	= true;
			$rtn	= true;
		}
	return $rtn;
    }
    function logout()	{
		$this->my_access	=	new Access_user;
		$this->my_access->log_out();
	}
    function loadPublishers()	{
    	$_SESSION['publisherNames']	= array();
		$sql = "SELECT * FROM publishers order by name";
        $this->database->query($sql);
        $publishers	= $this->database->loadObjectList();
        foreach($publishers as $idx=>$publisher){
        	$_SESSION['publisherNames'][]	=	$publisher->name;
        }
        return;
    	
    }
    
}
