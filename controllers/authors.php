<?php
defined('DACCESS') or die ('access denied');
 if( (!isset($_SESSION['userEmail'])) || ($_SESSION['userEmail' == '']) )	{

	header( 'Location: ../') ;
}  

class Authors extends Controller {
 
    function __construct() {
        parent::__construct();
		$this->load->model('authorsmodel');        
    }
    public function index() {
/*      	var_dump($_POST);
    	var_dump($_GET);
    	die ('controller');
    	    	*/
  	

		if(isset($_POST['cancel']))	{
    		$_SESSION['mode'] 	=	'default'	;
    		$this->authorsmodel->reset();
    	    $data['authors'] = $this->authorsmodel->getAuthors();
	        $this->load->view('authors',$data);
    	}
    	elseif(isset($_POST['save']))	{
    		$this->authorsmodel->validateAuthor();
    	    $data['authors'] = $this->authorsmodel->getAuthors();
	        $this->load->view('authors',$data);
    	}
    	elseif(isset($_POST['delete']))		{
    		$this->authorsmodel->deleteAuthor();
   	    	$data['authors'] = $this->authorsmodel->getAuthors();
	        $this->load->view('authors',$data);
    		
    	}
    	elseif(isset($_GET['edit']))	{
			$_SESSION['mode']	=	"editAuthor";
	    	$this->authorsmodel->getAuthor();
    	    $data['authors'] = $this->authorsmodel->getAuthors();
	        $this->load->view('authors',$data);
    	}
     	else {
			$data['authors'] = $this->authorsmodel->getAuthors();	
    	    $this->load->view('authors',$data);
    	}
    }
}?>