<?php
defined('DACCESS') or die ('access denied');
 if( (!isset($_SESSION['userEmail'])) || ($_SESSION['userEmail' == '']) )	{

	header( 'Location: ../') ;
}  

class Events extends Controller {
 
    function __construct() {
        parent::__construct();
		$this->load->model('eventsmodel');        
    }
    public function index() {
/*      	var_dump($_POST);
    	var_dump($_GET);
    	die ('controller');
    	    	*/
  	

		if(isset($_POST['cancel']))	{
    		$_SESSION['mode'] 	=	'default'	;
    		$this->eventsmodel->reset();
    	    $data['events'] = $this->eventsmodel->getEvents();
	        $this->load->view('events',$data);
    	}
    	elseif(isset($_POST['save']))	{
    		$this->eventsmodel->validateEvent();
    	    $data['events'] = $this->eventsmodel->getEvents();
	        $this->load->view('events',$data);
    	}
    	elseif(isset($_POST['delete']))		{
    		$this->eventsmodel->deleteEvent();
   	    	$data['events'] = $this->eventsmodel->getEvents();
	        $this->load->view('events',$data);
    		
    	}
    	elseif(isset($_GET['edit']))	{
			$_SESSION['mode']	=	"editEvent";
	    	$this->eventsmodel->getEvent();
    	    $data['events'] = $this->eventsmodel->getEvents();
	        $this->load->view('events',$data);
    	}
     	else {
			$data['events'] = $this->eventsmodel->getEvents();	
    	    $this->load->view('events',$data);
    	}
    }
}?>