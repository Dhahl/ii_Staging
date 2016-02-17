<?php
defined('DACCESS') or die ('access denied');
if(!isset($_SESSION['accessLevel'])) {
		header( 'Location: ../');
		die('not set'); 
}

if($_SESSION['accessLevel'] != '10') {
	header( 'Location: ../');
	die ('not admin');
}

class Categories extends Controller {
 
    function __construct() {
        parent::__construct();
		$this->load->model('categoriesmodel');        
    }
    public function index() {
/*      	var_dump($_POST);
    	var_dump($_GET);
    	die ('controller');
*/    	    	
  	

		if(isset($_POST['cancel']))	{
    		$_SESSION['mode'] 	=	'default'	;
    		$this->categoriesmodel->reset();
    	    $data['categories'] = $this->categoriesmodel->getCategories();
	        $this->load->view('categories',$data);
    	}
    	elseif(isset($_POST['save']))	{
    		$this->categoriesmodel->validateCategory();
    	    $data['categories'] = $this->categoriesmodel->getCategories();
	        $this->load->view('categories',$data);
    	}
    	elseif(isset($_POST['delete']))		{
    		$this->categoriesmodel->deleteCategory();
   	    	$data['categories'] = $this->categoriesmodel->getCategories();
	        $this->load->view('categories',$data);
    		
    	}
    	elseif(isset($_GET['edit']))	{
			$_SESSION['mode']	=	"editCategory";
	    	$this->categoriesmodel->getCategory();
    	    $data['categories'] = $this->categoriesmodel->getCategories();
	        $this->load->view('categories',$data);
    	}
     	else {
			$data['categories'] = $this->categoriesmodel->getCategories();	
    	    $this->load->view('categories',$data);
    	}
    }
}?>
