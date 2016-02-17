<?php
defined('DACCESS') or die ('access denied');
 if( (!isset($_SESSION['userEmail'])) || ($_SESSION['userEmail' == '']) )	{

	header( 'Location: ../') ;
}  
/* 				========================
 * 				NB.	DEVELOPMENT VERSION
 * 				========================
 * 
 * 			Un-comment the code below for secure access on Live Version 
 * 
 */
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

class Profile extends Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('profilemodel');        
    }
    public function index() {
/*       	var_dump($_POST);
    	var_dump($_GET);
    	die ('Profile controller');
    	    	*/
		if(isset($_POST['save']))	{
       			$this->profilemodel->validateProfile();
				$this->load->view('profile',$data);
   		}
    	else {
			$data['profile'] = $this->profilemodel->getUser();	
    	    $this->load->view('profile',$data);
    	}
    }
}
?>