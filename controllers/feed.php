<?php
defined('DACCESS') or die ('access denied');
if( (!isset($_SESSION['userEmail'])) || ($_SESSION['userEmail' == '']) )	{

	header( 'Location: ../') ;
}

class Feed extends Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('feedmodel');
	}
	public function index() {
		/*      	var_dump($_POST);
		 var_dump($_GET);
		 die ('controller');
		 */
		 

		if(isset($_POST['getFeed']))	{
			$_SESSION['mode'] 	=	'default'	;
			$this->feedmodel->reset();
			$data['feed'] = $this->feedmodel->getFeed();
			$this->load->view('feed',$data);
		}
		else {
			$data['feed'] = $this->feedmodel->getFeeds(); // default action, show feeds awaiting processing ? or something??
			$this->load->view('feed',$data);
		}
	}
}?>