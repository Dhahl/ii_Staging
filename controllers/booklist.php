<?php


defined('DACCESS') or die ('access denied');
 
class Booklist extends Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('booklistmodel');
    }
     
    public function index() {
//echo $_SESSION['mode'];    	
if(($_SESSION['mode']	=='editBook') 
 || ($_SESSION['mode'] =='editEvent')
 || ($_SESSION['mode'] =='editCategory')
 || ($_SESSION['mode'] =='editBanner')
 || ($_SESSION['mode'] =='editAuthor')
 
 || ($_SESSION['mode'] == '')
	) 
		$_SESSION['mode'] = 'default';

    	if(isset($_GET['home']))	{
    		if($_SESSION['mode']	!== 'default')	$_SESSION['startRRN'] = 0;	
    		$_SESSION['mode'] 	= 'default';
    	}
    	if(isset($_GET['search'])) 	{ 
    		if($_SESSION['mode']	!== 'search')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode']	= 'search';
    	}
    	if(isset($_GET['author']))			{ 
    		if($_SESSION['mode']	!== 'author')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode'] = 'author';
    	}
    	if(isset($_GET['category']))	{
    		if($_SESSION['mode']	!== 'category')	$_SESSION['startRRN'] = 0;	 	
	    	$_SESSION['mode'] = 'category';
    	}
    	if(isset($_GET['published']))		{		
			if($_SESSION['mode']	!== 'published')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode']	=	'published';
    	}
    	if(isset($_GET['top']))		{		
    		if($_SESSION['mode']	!== 'top')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode']	=	'top';
    	}
    	if(isset($_GET['future']))		{			
			if($_SESSION['mode']	!== 'future')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode']	=	'future';
    	}
    	if(isset($_GET['editorschoice']))	{
    		if($_SESSION['mode']	!== 'editorschoice')	$_SESSION['startRRN'] = 0;
	    	$_SESSION['mode']	=	'editorschoice';
    	} 
    	if(isset($_GET['favourites']))		{ 
    		if($_SESSION['mode']	!== 'favourites')	$_SESSION['startRRN'] = 0;
    		$_SESSION['mode']	=	'favourites';
    	}
		if(($_SESSION['mode']	=='editBook') || ($_SESSION['mode'] == '')) $_SESSION['mode'] = 'default';
		
    	if((isset($_GET['page'])	&& $_GET['page']	== 'next'))	{
    		$_SESSION['startRRN']	=	$_SESSION['startRRN'] + $_SESSION['pageSize'];
    		if($_SESSION['startRRN']	>	$_SESSION['totalRecords'] +1)	{
    			$_SESSION['startRRN']	=	$_SESSION['startRRN']	- $_SESSION['pageSize'];
    		} 
    	}
    	if((isset($_GET['page'])	&& $_GET['page']	== 'prev'))	{
    		$_SESSION['startRRN']	=	$_SESSION['startRRN'] - $_SESSION['pageSize'];
    		if($_SESSION['startRRN'] 	<=	0) $_SESSION['startRRN']	=0;
    	}
    	if((isset($_GET['page'])	&& $_GET['page']	== 'page'))	{
    		$_SESSION['startRRN']	=	$_GET['current'] * $_SESSION['pageSize'] - $_SESSION['pageSize'];
    		if($_SESSION['startRRN'] 	<=	0) $_SESSION['startRRN']	=0;
    	}

    	if( (isset($_GET['contact']))	&& ($_GET['contact']	==	'contact') )	{
    		$_SESSION['ok']	=	$this->booklistmodel->contact();
    	}
    	if(isset($_GET['fav']))	{
    		$_SESSION['ok']	=	$this->booklistmodel->addFavourite();
    	}

    	if(isset($_GET['unfav']))	{
    		$_SESSION['ok']	=	$this->booklistmodel->removeFavourite();
    	}
    	if( (isset($_GET['author'])   )	|| (   ($_SESSION['mode'] == 'author') && (   !isset($_GET['search'])  )  ) ){
    		$data['booklist']	=	$this->booklistmodel->getAuthor();
    	}
    	elseif( (isset($_GET['category'])   )	|| (   ($_SESSION['mode'] == 'category') && (   !isset($_GET['search'])  )  ) ){
    		$data['booklist']	=	$this->booklistmodel->getCategoryBooks();
    	}
    	else {
 			$data['booklist'] = $this->booklistmodel->getBookList();			 
 			
//      	  var_dump($data);
		}
        $this->load->view('booklist',$data);
		
    }
    public function logout()	{
    	
    	$this->booklistmodel->logout();    	
    }
}
