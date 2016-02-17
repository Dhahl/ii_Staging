<?php
defined('DACCESS') or die ('access denied');
include"./classes/access_user/access_user_class.php";

class Booklistmodel extends Model {
 
    function __construct() {
    	$_SESSION['pageSize']	=	isset($_SESSION['pageSize'])	?	$_SESSION['pageSize']	:	12;
		$_SESSION['startRRN']	=	isset($_SESSION['startRRN'])	?	$_SESSION['startRRN']	:	0;
    	
    	/* build array of Authors	*/
		$query = 'SET CHARACTER SET utf8';
		$this->database->query($query);
		$query = 'SELECT * FROM authors ORDER BY lastname,firstname asc';
        $this->database->query($query);
        $authors = 	$this->database->loadObjectList();
        $_SESSION['authors']		= array();
        $i = 0;
        foreach ($authors as $author)	 {
	 		$_SESSION['authors'][$i][0]= $author->lastname.', '.$author->firstname;
	 		$_SESSION['authors'][$i][1]= $author->id;
	 		$i++;
        }
        /* Build array of Categories */
    	$query = 'SELECT * FROM categories ORDER BY name';
        $this->database->query($query);
        $categories = 	$this->database->loadObjectList();
        $_SESSION['categories']		= array();
        foreach ($categories as $category)	 {
	 		$_SESSION['categories'][$category->id]		= $category->Name;
        }
        /* build array of Events	*/
    	$query = 'SELECT events.*,  events.id AS eventid, events.image as eventimage, 
    								authors.* , authors.id AS authorid, authors.image AS authorimage,
    								publications.id AS bookid, publications.title AS booktitle
    								 FROM events LEFT JOIN authors ON events.authorid =  authors.id
													      LEFT JOIN publications ON events.bookid = publications.id								 
				    		ORDER BY date_time_from';
        $this->database->query($query);
        $events = 	$this->database->loadObjectList();
        
        $_SESSION['events']		= array();
        foreach ($events as $event)	 {
	 		$_SESSION['events'][$event->eventid]		= $event;	//	array($event->Name,$event->date_time_from,$event->date_time_to);
        }
        /* Get Banners */
        $query= 'SELECT * FROM banner ';
        $this->database->query($query);
        $banners = 	$this->database->loadObjectList();
        
        $_SESSION['banners']		= array();
        foreach ($banners as $banner)	 {
	 		$_SESSION['banners'][]		= $banner;	//	array($event->Name,$event->date_time_from,$event->date_time_to);
        }
        parent::__construct();
    }
   function logout()	{
   	
		$this->my_access	=	new Access_user;
		$this->my_access->log_out();
	}
    public function getAuthor()	{
    	if(isset($_GET['author']))		{
    		$_SESSION['startRRN']	=	0;
			$_SESSION['search_author']	= $_GET['author'];    	
 	    	
			$_SESSION['searchString']	=	"";
 		   	$_SESSION['searchInput']	= "" ;
			$_SESSION['searchFax']	=	"";
 		   	
    		$_SESSION['pageSize']	=	12;
    		
 		   	//$query	=	"SELECT COUNT(*) as count  from publications WHERE authorid = ".$_SESSION['search_author'];
 		   	$query	=	"SELECT COUNT(*) as count  from author_x_book WHERE authorid = ".$_SESSION['search_author'];
 		   	
    		$this->database->query($query);
	    	$rtnCount = $this->database->loadObjectList();
   		 	$_SESSION['totalRecords']	= $rtnCount[0]->count;
    	
  		  	$query = "SELECT * FROM authors WHERE id = '".$_SESSION['search_author']."'";
    	
        	$this->database->query($query);
        	$_SESSION['author']	=	$this->database->loadObjectList();
   	}
    	
        
       // $query = 'SELECT * FROM publications WHERE authorid = ' .$_SESSION['search_author'].' LIMIT '.$_SESSION['startRRN'].','.$_SESSION['pageSize'];	
        $query = "SELECT author_x_book.*, publications.* 
        				FROM author_x_book 
						INNER JOIN publications ON author_x_book.bookid = publications.id  
						WHERE  author_x_book.authorid = '".$_SESSION['search_author'].
						"' LIMIT ".$_SESSION['startRRN'].','.$_SESSION['pageSize'];	
        
        $this->database->query($query);
        $books	=	$this->database->loadObjectList();
        foreach($books as $book) {
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	$rtn['books'][]	= $book;
        }
       // var_dump($rtn);
        return $rtn;
        
    }
    public function getCategoryBooks()	{
    	
    	if(isset($_GET['category']))	{
			$_SESSION['startRRN']	=	0;
    		$_SESSION['search_category']	= $_GET['category'];    	
 		  
			$_SESSION['searchString']	=	"";
    		$_SESSION['searchInput']	= "" ;
			$_SESSION['searchFax']	=	"";
    		
    		$_SESSION['pageSize']	=	12;
    		
    		$query	=	"SELECT COUNT(*) as count  from publications WHERE categoryid = ".$_SESSION['search_category'];
    		$this->database->query($query);
    		$rtnCount = $this->database->loadObjectList();
    		$_SESSION['totalRecords']	= $rtnCount[0]->count;
    		
    	}
    	
        $query = 'SELECT * FROM publications WHERE categoryid = ' .$_SESSION['search_category'].' LIMIT '.$_SESSION['startRRN'].','.$_SESSION['pageSize'];	
 
        $this->database->query($query);
        $books	=	$this->database->loadObjectList();
        foreach($books as $book) {
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	$rtn['books'][]	= $book;
        }
        return $rtn;
    }
    public function getEvent()	{
    	
    	if(isset($_GET['event']))	{
			$_SESSION['startRRN']	=	0;
    		$_SESSION['event']	= $_GET['event_id'];    	
 		  
			$_SESSION['searchString']	=	"";
    		$_SESSION['searchInput']	= "" ;
/*
    		$query	=	"SELECT COUNT(*) as count  from publications WHERE categoryid = ".$_SESSION['search_category'];
    		$this->database->query($query);
    		$rtnCount = $this->database->loadObjectList();
    		$_SESSION['totalRecords']	= $rtnCount[0]->count;
  */  		
    	}
    	
        $query = 'SELECT * FROM events WHERE id = ' .$_SESSION['event_id'];	
 
        $this->database->query($query);
        $rtn['event']	=	$this->database->loadObjectList();

        return $rtn;
    }
    public function contact()	{
 	   	$_SESSION['contactName']	=	$_GET['contactName'];
 	   	$_SESSION['contactemail']	=	$_GET['contactemail'];
 	   	$_SESSION['contactMessage']	=	$_GET['contactMessage'];
 	   	
    	$err	=	array();
    	$ok		=	true;
    	
    	if($_GET['contactName']	==	"")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter your Name";
    		$err['field'][]	=	"contactName";
    		
    	}
    	if($_GET['contactemail'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter your e-mail address";
    		$err['field'][]	=	"contactemail";
    	}
    	else	{
    		if(!$this->check_email($_GET['contactemail']))	{
	    		$ok				=	false;
   	 			$err['msg'][]	=	"Please enter a valid e-mail address";
   		 		$err['field'][]	=	"contactemail";
    		}
    	}
    	if($_GET['contactMessage'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter a Message";
    		$err['field'][]	=	"contactMessage";
    	}
    	
    	if($ok	==	true)	{
	 		$header = "From: \"".$_GET['contactName']."\" <".$_GET['contactemail'].">\r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Mailer: Irish Interest\r\n";
			$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
			$header .= "Content-Transfer-Encoding: 7bit\r\n";
			$mail_address	=	"administrator@irishinterest.ie";
			$subject	=	"Contact message from ".$_GET['contactName'];
			$body	=	$_GET['contactMessage'];
   		 	$sent=@mail($mail_address, $subject, $body, $header);
   		 	$_SESSION['contactReceived']	= true;
    		$_SESSION['contactReceivedMessage']	=	"Thank You!";
			$_SESSION['contactName']	=	'';
			$_SESSION['contactemail']	=	'';
			$_SESSION['contactMessage']	=	'';
    	}
    	
    	$_SESSION['err']	=	$err;
     	return $ok;
    } 
	function check_email($mail_address) {	//	Function Ripped from Access_User
		if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $mail_address)) {
			return true;
		} else {
			return false;
		}
	}
    
    public function getBookList() {
   	
    	if( ($_GET['reset']	== true)	|| (isset($_GET['home']) ) ){
			$_SESSION['searchFax']	=	"";		//facsimilie of search phrase
			$_SESSION['searchString']	=	"";
			$_SESSION['searchInput']	=	"";
			$_SESSION['mode']			=	'default';
			$_SESSION['startRRN']		= 	0;
			$_SESSION['pageSize']		= 	6;
		}
		
    	if( (isset($_GET['searchinput']) && ($_GET['searchinput'] != ""))	||	 (($_SESSION['mode']	==	"search") && (!$_SESSION['searchString'] == "") ) ) 	{
    		$_SESSION['pageSize']		= 12;
 			$rtn = $this->parseSearchInput($_GET['searchinput']);
		}
		elseif($_SESSION['mode']	!==	'default')	{
			$_SESSION['pageSize']	=	24;
			if($_SESSION['mode'] == 'published') $rtn = $this->listTitles('published');
			if($_SESSION['mode'] == 'future') $rtn = $this->listTitles('future');
			if($_SESSION['mode'] == 'top') $rtn = $this->listTitles('top');
			if($_SESSION['mode'] == 'editorschoice') $rtn = $this->listTitles('editorschoice');
			if($_SESSION['mode'] == 'favourites') $rtn = $this->listTitles('favourites');
		}	
		else	{
			$_SESSION['mode']	=	'default';
			$rtn = $this->listTitles();
		}
		return $rtn;
	}
	function addFavourite()	{
		if((isset($_SESSION['id']) && (!$_SESSION['id']	=='') )) {
			$sql ="INSERT INTO favourites (userid, bookid) values(".$_SESSION['id'].', '.$_GET['fav'].")";	
			$this->database->query($sql);
		}
	}
	function removeFavourite()	{
		if((isset($_SESSION['id']) && (!$_SESSION['id']	=='') )) {
			$sql ="DELETE FROM favourites WHERE userid = '".$_SESSION['id']."' AND  bookid = '".$_GET['unfav']."'";	
			$this->database->query($sql);
		}
	}
	
	function parseSearchInput($str)	{
//		var_dump($str);
		$str	= str_replace("'", "\'",$str);
		$str	= str_replace("\\'", "\'",$str);
		$str	= str_replace('"', '\"',$str);
		//		var_dump($str);
		//die;
		$tokes	=	array($this->tokenizeQuoted($str));
//		var_dump($tokes);
		//die;
		foreach($tokes[0][0] as $idx=>$val)	{
			$val	=	str_replace(' ',' +', $val);
			$val	=	' "+'.$val.'"';	
			for ($count=1; $count>0; str_replace('+ +','+', $val,$count)) {
				echo $count;
				//die;
			}
			$tokes[0][0][$idx]	= $val;
		}
//		var_dump($tokes);
		$against	=	implode(' ', $tokes[0][0]);
//		var_dump($against);
		$against	.=	 ' "'.implode(' ', $tokes[0][1]).'"';

		if($str != "")	{
/*			$_SESSION['searchString']	=
				'MATCH(title, author, genre, area, synopsis) AGAINST('.$against.'  IN BOOLEAN MODE) AS score
				from publications 
				WHERE MATCH(title, author, genre, area, synopsis) AGAINST('.$against.'  IN BOOLEAN MODE) ORDER BY score DESC
			';
			*/
			$_SESSION['searchString']	=
				'MATCH (title, author) against ('.$against .'   IN BOOLEAN MODE) * 5 + 
				 
				MATCH(title, author, genre, area, synopsis) AGAINST('.$against.'  IN BOOLEAN MODE) AS score
				from publications 
				
				WHERE MATCH(title, author, genre, area, synopsis) AGAINST('.$against.'  IN BOOLEAN MODE) ORDER BY score DESC
			';
			
			$_SESSION['searchInput']	=	 $str;
			$_SESSION['searchFax']	= 	$_GET['searchinput'];		// facsimilie
			$_SESSION['startRRN']	=	0;
		}
//	var_dump($_SESSION['searchString']);
//	die;
		$sql	=	"SELECT COUNT(*) as count, ".$_SESSION['searchString'];
		
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
        $_SESSION['totalRecords']	=	$rtn[0]->count;
		
		$sql	=	"SELECT *, ".$_SESSION['searchString'].' LIMIT '.$_SESSION['startRRN'].','.$_SESSION['pageSize'];
		
//			MATCH(title, author, genre, area, synopsis) AGAINST(".$against."  IN BOOLEAN MODE) AS score 
//			from publications 
//			WHERE MATCH(title, author, genre, area, synopsis) AGAINST(".$against."  IN BOOLEAN MODE)";
/*		var_dump($tokes);
	die;
	*/		
        /*
         * store search history
         */
		$first 			=	true;
		$bookfields 	=	'';
		$bookIds 		=	'';
		$sep 			=	'';
		
		$this->database->query($sql);
        $books =	$this->database->loadObjectList();
        foreach($books as $book)	{
        	/* history fields */
        	if($first == true) { 
	        	$bookId =	$this->database->getQuotedString($book->id);
	        	if($_SESSION['id'] == 0) 
	        		$userId = $this->database->getQuotedString(0);
	        	else 
	        		$userId = 	$this->database->getQuotedString($_SESSION['id']);
	        	$searchstring = $this->database->getQuotedString($_SESSION['searchFax']);
        		$first 	= false;
        	}
        	// get author ID's for the book
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	$books['search'][]	=	$book;
        }
		if(($first == false) && (!$_GET['searchinput']	==	'')) {
	        $sql2 = 'INSERT INTO search_history (userid, searchstring, bookid)  
	        	VALUES ('.$userId . ', ' . $searchstring . ', ' . $bookId.' )'; 
    	    $this->database->query($sql2);
    	    $sql2 = '';
		}
		$sql = 'select * from search_history limit 0,1';
		$this->database->query($sql);
    	
//        $_SESSION['totalRecords']	=	count($rtn);
/*        var_dump(count($rtn));
        die;
        var_dump($books);
        die;
*/	
        return $books;
//		return '';	
	}
	function tokenizeQuoted($string, $quotationMarks='"\'') {
    $tokens = array(array(),array());
    for ($nextToken=strtok($string, ' '); $nextToken!==false; $nextToken=strtok(' ')) {
        if (strpos($quotationMarks, $nextToken[0]) !== false) {
            if (strpos($quotationMarks, $nextToken[strlen($nextToken)-1]) !== false) {
                $tokens[0][] = substr($nextToken, 1, -1);
            } else {
                $tokens[0][] = substr($nextToken, 1) . ' ' . strtok($nextToken[0]);
            }
        } else {
            $tokens[1][] = $nextToken;
        }
    }
    return $tokens;
}
	function listTitles($view='default')	{
		
		$futureCount 	= 0;
		$recentCount = 0;
		//$tomorrow 	= date('Y-m-d',time());
		$tomorrowDt 	= new DateTime('tomorrow');
		$tomorrow 	= $tomorrowDt->format('Y-m-d');
		$today 			= date('Y-m-d', time());
		/*****************************************	
		 * 		get total record count
		 *****************************************/
		$query = 'SET CHARACTER SET utf8';
		$this->database->query($query);
		$sql 	=	'SELECT COUNT(*) as count FROM publications ';
		$this->database->query($sql);
		$rtn 	=	$this->database->loadObjectList();
		$_SESSION['totalRecords']	=	$rtn[0]->count;
		if($view == 'default')	$_SESSION['pageSize'] = 6;
		else $_SESSION['pageSize']	= 24;
		$pageSize	=	$_SESSION['pageSize'];
		$pageSize2 = $_SESSION['mode'] == 'default' ? 3 : 24;
		$startRRN	=	$_SESSION['startRRN'];
		$limit 		= ' LIMIT '.$startRRN.','.$pageSize;
		if($_SESSION['mode']	== 'default')
			$limit2 		= ' LIMIT 0 ,'.$pageSize2;
			else $limit2 = $limit;
		
		/*****************************************	
		 * 		get "recent" record count
		 *****************************************/
		$where	=	" WHERE published < '".$tomorrow."'";
		
		$sql 	=	'SELECT COUNT(*) as count FROM publications '.$where ;
		$this->database->query($sql);
		$rtn 	=	$this->database->loadObjectList();
		$_SESSION['recentCount']	= $rtn[0]->count;
		
        /*****************************************
         * 		get recent publications 
         *****************************************/
		$sql = 'SELECT * FROM publications '.$where. ' ORDER BY published DESC '.$limit;//LIMIT '.$startRRN.','.$pageSize;
		$this->database->query($sql);
        $books	=	$this->database->loadObjectList();

        foreach($books as $book)	{
        	// get author ID's for the book
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	$books['recent'][]	=	$book;
        	$recentCount++;
        }
        
 		/*****************************************
 		 * 	get "future" record count
		 *****************************************/
        $where	=	" WHERE published > '".$today."'";
		
		$sql 	=	'SELECT COUNT(*) as count FROM publications '.$where ;
		$this->database->query($sql);
		$rtn 	=	$this->database->loadObjectList();
		$_SESSION['futureCount']	= $rtn[0]->count;
		
        /*****************************************
         * 		get "future" publications 
         *****************************************/
        $sql = 'SELECT * FROM publications '.$where. ' ORDER BY published ASC '.$limit2;//LIMIT '.$startRRN.','.$pageSize;

		$this->database->query($sql);
        $futureBooks	=	$this->database->loadObjectList();
        foreach($futureBooks as $book)	{
        	
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	
        	
    	    		$books['future'][]	=	$book;
        			$futureCount ++;
	        	
        }
        
        /*****************************************
         * 		Top Searches Panel
         *****************************************/
        $_SESSION['topCount']	= 0;
        $sql = 'SELECT COUNT(*) AS `Rows` FROM `search_history` GROUP BY `bookid` ';
        $this->database->query($sql);
		$tops 	=	$this->database->loadObjectList();
		foreach($tops as $top) {	
			$_SESSION['topCount']++;
		}
        
        $sql = 'SELECT COUNT(*) AS `Rows`, `bookid` FROM `search_history` GROUP BY `bookid` ORDER BY `Rows` desc '.$limit2;// LIMIT '.$startRRN.','.$pageSize;
        $this->database->query($sql);
		$tops 	=	$this->database->loadObjectList();
		foreach($tops as $top) {
 			$sql2 	= "SELECT * FROM publications WHERE id =  '".$top->bookid."'";
			$result=$this->database->query($sql2);
			
			$topBooks 	=	$this->database->loadObjectList();
			 
			$book 			= $topBooks[0];
        	if($book!== null) {
				$book->authors = $this->getAuthorNames($book->id);
				$book->isFavourite = $this->getFavourite($book->id); 
				$books['top'][] =	$book;
        	}
		}
        /*		
         * 		Editors Choice
         */
        
        $sql = 'SELECT COUNT(*) AS `Rows` FROM `publications` where editorschoice = 1 ';
        $this->database->query($sql);
		$res 	=	$this->database->loadObjectList();
		$_SESSION['editorsChoiceCount']	= $res[0]->Rows;
		
		$sql = 'SELECT * FROM publications WHERE editorschoice = 1 '.$limit2;//LIMIT '.$startRRN.','.$pageSize;
        $this->database->query($sql);
        $editorschoices	=	 $this->database->loadObjectList();
        foreach($editorschoices as $book) {
        	$book->authors = $this->getAuthorNames($book->id);
			$book->isFavourite = $this->getFavourite($book->id); 
        	$books['editorschoice'][]	=	$book;
        }
        
        /*
         * 		Favourites
         */
        if(isset($_SESSION['id']) && (!$_SESSION['id'] == ''))	{
/*   	     	$sql = 'SELECT COUNT(*) AS `Rows`, bookid FROM `favourites` where userid = '.$_SESSION['id'].' GROUP BY `bookid`' ;
   	     	$this->database->query($sql);
			$favs 	=	$this->database->loadObjectList();
			$_SESSION['favouritesCount']	=count($favs);
			
			foreach($favs as $fav) {	
				$_SESSION['favouritesCount']	=	$fav->Rows;
				var_dump($fav);
			}
				die;
*/		        
	        $sql = "SELECT favourites.*, publications.* 
        			FROM favourites RIGHT JOIN publications 
        			ON  favourites.bookid = publications.id
        			WHERE favourites.userid = ".$_SESSION['id'].
        			' GROUP BY favourites.bookid'.$limit2; 
       
    	    $this->database->query($sql);
        	$favourites	=	 $this->database->loadObjectList();
        	foreach($favourites as $book) {
        		$book->authors = $this->getAuthorNames($book->id);
				$book->isFavourite = $this->getFavourite($book->id); 
        		$books['favourites'][]	=	$book;
        	}
        }
 	   $_SESSION['favouritesCount']	= count($books['favourites']);
       return $books;
		
	}
	function getFavourite($book)	{
		$sql = "SELECT COUNT(*) as favourite FROM favourites WHERE bookid = '".$book. "' AND userid = '".$_SESSION['id']."'";
		$this->database->query($sql);
		$favourites	=	 $this->database->loadObjectList();
		
		if($favourites[0]->favourite == 0)	return false;
		 else return true		;
	}
	function getAuthorNames($bookID) {
        $sql= "SELECT author_x_book.*, authors.* 
        			FROM author_x_book LEFT JOIN authors 
        			ON  author_x_book.authorid = authors.id
        			WHERE  author_x_book.bookid = ".$bookID;
       
        $this->database->query($sql);
        $authors = $this->database->loadObjectList();
        $arrAuthors = array();
        foreach($authors as $author) {
        	$arrAuthors[$author->id]	=	$author->firstname.' '.$author->lastname;
        } 
        return $arrAuthors;
	}
	function header() {
		echo '
		<div class="header"> Irish Interest</div><br><br><br> 
		';
			
	}
	function footer() {
		$back = '<a href="javascript:history.back()"> Back    </a>';
		echo '
					</td></tr>
					<tr><td><p class="footer">'.$back.'<a href="javascript:window.close()"> Close </a></p><p class="footer">This data is licensed to Irish Interest(Demo Site)<br />for use strictly within Terms and Conditions.<br />Copyright &copy;  - Irish Interest - www.irishinterest.ie<br />All Trademarks acknowledged</p>
				</table>
			</body>
		</html>';
	}
	
	function itemHeader() {
		echo '
				<table id="holder" cellspacing="0">
					<tr><td class="banner"><img src="/images/banner.gif" alt="banner" /></td></tr>
					<tr><td class="holder">SOME TEXT HERE</td>
						<td class="holder">SOME TEXT HERE</td>
					</tr>';
		
		$query = 'SELECT * FROM titles';
			
			$result = mysql_query($query, $this->db);
			
			if(mysql_num_rows($result) > 0) {
					$row = mysql_fetch_object($result);
								
					echo '
						<table id="manufacturer" cellspacing="0">
							<tr>
								<td><b>Product Id</b> '.$this->productId.'</td>
								<td><b>Manufacturer</b> '.$row->manufacturer.'</td>
								
							<tr>
						</table>
						<hr />
						<table id="summary" cellspacing="0">
							<tr>
								<td class="title"><b>Range</b></td>
								<td>'.$row->manufacturer_family.'</td>';
					
						//echo '
						//		<td rowspan="3"><img src="'.$this->getImagePath($this->image, $this->manufacturer).'" alt="" width="100" height="100" /></td>';
						echo '
							<td rowspan="3"><img src="'.$this->getImagePath().'" alt="" width="100" height="100" /></td>';					
					
					echo '
							</tr>
							<tr>
								<td class="title"><b>Part No.</b></td>
								<td>'.$row->partno.'</td>
							</tr>
							<tr>
								<td class="title"><b>Model</b></td>
								<td>'.$row->model.'</td>
							</tr>
						</table>';
					
					mysql_free_result($result);
				}	
			else {
				echo 'Invalid product';
				die();
			}
	}
	
	function searchBar() {
		$title		= 	'';
		$author 	=	'';
		$publisher 	=	'';
		$genre		=	'';
		$area		=	'';
		if(isset($_SESSION['searchTitle']))		$title		= 	$_SESSION['searchTitle'];
		if(isset($_SESSION['searchAuthor'])) 	$author 	=	$_SESSION['searchAuthor'];
		if(isset($_SESSION['searchPublisher'])) $publisher 	=	$_SESSION['searchPublisher'];
		if(isset($_SESSION['searchGenre'])) 	$genre		=	$_SESSION['searchGenre'];
		if(isset($_SESSION['searchArea'])) 		$area		=	$_SESSION['searchArea'];
		
		echo '
						<form method="post">
						<div>
						<hr class="buttons"/>
						<table>
							<tr><td /><td>Title</td><td>Author</td><td>Publisher</td><td>Genre</td><td>Geographic Area</td>
							<tr>
								<td>Enter values to Search: </td>
								<td><input name="searchTitle" id="searchTitle" value ="'.$title.'"</td>
								<td><input name="searchAuthor" id="searchAuthor" value ="'.$author.'"</td>
								<td><input name="searchPublisher" id="searchPublisher" value ="'.$publisher.'"</td>
								<td><input name="searchGenre" id="searchGenre" value ="'.$genre.'"</td>
								<td><input name="searchArea" id="searchArea" value ="'.$area.'"</td>
								<input name = "search" id="search" type="submit" value="Search">
								<input name = "reset" id="reset" type="submit" value="Reset">
								</tr>
						</table>
						<hr class="buttons"/></div></form>';
	}
	function reset()	{
	session_unset();
		
	}
	function search()	{
		$_SESSION['startRRN']			= 0;
		$_SESSION['searchTitle']		=	$_POST['searchTitle'];
		$_SESSION['searchAuthor']		=	$_POST['searchAuthor'];
		$_SESSION['searchPublisher']	=	$_POST['searchPublisher'];
		$_SESSION['searchGenre']		=	$_POST['searchGenre'];
		$_SESSION['searchArea']			=	$_POST['searchArea'];
		
		$sql_Where	=	"WHERE ";
		$sqlAnd		=	'';
		
		if($_SESSION['searchTitle'] <> '') {
			$sql_Where	.= 	'title LIKE "' . $_SESSION['searchTitle'].'%"';
			$sqlAnd		=	' AND ';
		}
		if($_SESSION['searchAuthor'] <> '')	{ 
			$sql_Where	.=	$sqlAnd . 'author = "' .$_SESSION['searchAuthor'].'"';
			$sqlAnd		=	' AND ';
		}
		if($_SESSION['searchPublisher'] <> '')	{ 
			$sql_Where	.=	$sqlAnd . ' publisher= "' .$_SESSION['searchPublisher'].'"';
			$sqlAnd		=	' AND ';
		}
		if($_SESSION['searchGenre'] <> '')	{ 
			$sql_Where	.=	$sqlAnd . ' genre= "' .$_SESSION['searchGenre'].'"';
			$sqlAnd		=	' AND ';
		}
		if($_SESSION['searchArea'] <> '')	{ 
			$sql_Where	.=	$sqlAnd . ' area = "' .$_SESSION['searchArea'].'"';
			$sqlAnd		=	' AND ';
		}
		if($sqlAnd == '') $sql_Where	=	'';
		
		$query =	"SELECT * FROM publications " . $sql_Where ." ORDER BY lastupdated DESC";
		$result = mysql_query($query, $this->db);
		if (!$result) { echo mysql_error().'<br />'.$query; }
		if(mysql_num_rows($result) > 0) {
			while($row = mysql_fetch_object($result))	{
			$image	=	$row->image;
					
			echo '
				<table>
					<tr><td class="holder"><img src="'.$image.'" width="100" height="160"></td>
						<td><table>
						<tr><td class="holder">Title: '.$row->title.'</td></tr>
						<tr><td class="holder">Author: '.$row->author.'</td></tr>
						<tr><td class="holder">Publisher: '.$row->publisher.'</td></tr>
						<tr><td class="holder">Date Published: '.$row->published.'</td></tr>
						<tr><td class="holder">Genre: '.$row->genre.'</td></tr>
						<tr><td class="holder">Geographic Area: '.$row->area.'</td></tr>
						<tr><td class="holder">'.$row->synopsis.'</td></tr>
						</table></td>
					</tr><hr /></table>';
			}
		}
	}
}