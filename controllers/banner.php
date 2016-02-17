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
class Banner extends Controller {
    function __construct() {
        parent::__construct();
		$this->load->model('bannermodel');        
    }
    public function index() {
		if(isset($_POST['cancel']))	{
    		$_SESSION['mode'] 	=	'default'	;
    		$this->bannermodel->reset();
    	    $data['banner'] = $this->bannermodel->getBanners();
	        $this->load->view('banner',$data);
    	}
    	elseif(isset($_POST['save']))	{
    		$this->bannermodel->validateBanner();
    	    $data['banner'] = $this->bannermodel->getBanners();
	        $this->load->view('banner',$data);
    	}
    	elseif(isset($_POST['delete']))		{
    		$this->bannermodel->deleteBanner();
   	    	$data['banner'] = $this->bannermodel->getBanners();
	        $this->load->view('banner',$data);
    	}
    	elseif(isset($_GET['edit']))	{
			$_SESSION['mode']	=	"editBanner";
	    	$this->bannermodel->getBanner();									// get selected
    	    $data['banner'] = $this->bannermodel->getBanners();			// get all
	        $this->load->view('banner',$data);
    	}
     	else {
			$data['banner'] = $this->bannermodel->getBanners();	
    	    $this->load->view('banner',$data);
    	}
    }
}?>
