<?php
defined('DACCESS') or die ('Access Denied!');
if( (!isset($_SESSION['userEmail'])) || ($_SESSION['userEmail' == '']) )	{

	header( 'Location: ../') ;
}  
if($_SERVER["HTTPS"] == "on")
{
    header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

class Publish extends Controller {
 
    function __construct() {
    	parent::__construct();
         $this->load->model('publishmodel');
    }
     
    public function index() {
    	if((isset($_GET['page'])	&& $_GET['page']	== 'next'))	{
    		$_SESSION['publisher_startRRN']	=	$_SESSION['publisher_startRRN'] + $_SESSION['publisher_pageSize'];
    		if($_SESSION['publisher_startRRN']	>	$_SESSION['publisher_totalRecords'] +1)	{
    			$_SESSION['publisher_startRRN']	=	$_SESSION['publisher_startRRN']	- $_SESSION['publisher_pageSize'];
    		} 
    	}
    	if((isset($_GET['page'])	&& $_GET['page']	== 'prev'))	{
    		$_SESSION['publisher_startRRN']	=	$_SESSION['publisher_startRRN'] - $_SESSION['publisher_pageSize'];
    		if($_SESSION['publisher_startRRN'] 	<=	0) $_SESSION['publisher_startRRN']	=0;
    	}
    	if((isset($_GET['page'])	&& $_GET['page']	== 'page'))	{
    		$_SESSION['publisher_startRRN']	=	$_GET['current'] * $_SESSION['publisher_pageSize'] - $_SESSION['publisher_pageSize'];
    		if($_SESSION['publisher_startRRN'] 	<=	0) $_SESSION['publisher_startRRN']	=0;
    	}

    	if(isset($_POST['save']))	{
    	
    	 	if($_POST['save']	==	'profile')	{

       			$_SESSION['ok']	=	$this->publishmodel->validProfile();
				$this->load->view('publish',$data);
     		}
     		else	{
     			
       			$_SESSION['ok']	=	$this->publishmodel->validInput();
       			
        		if($_SESSION['ok']	===	true) { 
        			$this->publishmodel->save();
        		}
        		$data['publish'] = $this->publishmodel->getTitles();
  				$this->load->view('publish',$data);
     		}
     	}   	
   	 	elseif(isset($_POST['cancel']))	{
	    	$_SESSION['mode']	=	'';
   		 	$this->publishmodel->resetSession();
			$_SESSION['image']		=	"";
			$_SESSION['bookID']		=	"";
   	 		$data['publish'] = $this->publishmodel->getTitles();
			$this->load->view('publish',$data);
   	 	}
   	 	elseif($_POST['delete'])		{
   	 		$_SESSION['image']		=	"";
   	 		$this->publishmodel->deleteTitle($_POST['delete']);
       		$data['publish'] = $this->publishmodel->getTitles();
			$this->load->view('publish',$data);
	   	 }
   		 elseif( (isset($_GET['edit'])) && ($_GET['edit']	== 'profile') ){
				$data['publish'] = $this->publishmodel->getUser($_SESSION['userEmail']);
				$this->load->view('publish',$data);
		  }
		  elseif( (isset($_GET['edit']) && (!$_GET['id']== '')))	{ 
					
					$_SESSION['mode']	=	"editBook";
		    		$this->publishmodel->getTitle();
    		    	$data['publish'] = $this->publishmodel->getTitles();
	        		$this->load->view('publish',$data);
				
   	 	}
   	 	elseif(isset($_GET['delete']))	{
	   	 	$this->publishmodel->deleteTitle($_POST['titleId']);
    	   	$data['publish'] = $this->publishmodel->getTitles();
			$this->load->view('publish',$data);
   	 	}
   	 	else	{
   	 		$this->publishmodel->resetSession();
       		$data['publish'] = $this->publishmodel->getTitles();
			$this->load->view('publish',$data);
   	 	}
    }
    public function logout()	{
    	$this->publishmodel->logout();    	
    }
 }