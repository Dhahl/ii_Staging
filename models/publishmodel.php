<?php
defined('DACCESS') or die ('access denied');
include"./classes/access_user/access_user_class.php";
include "./classes/openitireland/class.upload.php";

class Publishmodel extends Model {
 
    function __construct() {
        parent::__construct();
    	$_SESSION['publisher_pageSize']	=	12;
		$_SESSION['publisher_startRRN']	=	isset($_SESSION['publisher_startRRN'])	?	$_SESSION['publisher_startRRN']	:	0;
    	/* build array of Authors	*/
		$query = 'SET CHARACTER SET utf8';
		$this->database->query($query);
    	$query = 'SELECT * FROM authors ORDER BY lastname, firstname';
        $this->database->query($query);
        $authors = 	$this->database->loadObjectList();
        $_SESSION['authors']		= array();
        $i = 0;
        foreach ($authors as $author)	 {
	 		$_SESSION['authors'][$i][0]= $author->lastname.', '.$author->firstname;
	 		$_SESSION['authors'][$i][1]= trim($author->id);
	 		//echo $_SESSION['authors'][$i][0].$_SESSION['authors'][$i][1].'<br>';
	 		$i++;
        }
		
    }
    
    function getTitles() {
		$this->loadPublishers();
		$this->loadCategories();
		$rtn = $this->listTitles();
		return $rtn;
	}
	function listTitles()	{
		$query = 'SET CHARACTER SET utf8';
		$this->database->query($query);
		$startRRN	=	$_SESSION['publisher_startRRN'];
		$pageSize	=	$_SESSION['publisher_pageSize'];
		
		$where	=	"";
		if($_SESSION['accessLevel'] == "1")	{	//	"Affiliated" Publisher
			$where	=	" WHERE publisher = '".$_SESSION['userPublisher']."'";
		}
		elseif($_SESSION['accessLevel']	== "2")	{
			$where	=	" WHERE user_id= '".$_SESSION['id']."'";
		}
		/*	
		 * 		get total record count
		 */
		$sql 	=	'SELECT COUNT(*) as count FROM publications '.$where;
		$this->database->query($sql);
		$rtn 	=	$this->database->loadObjectList();
		$_SESSION['totalRecords']	=	$rtn[0]->count;
		
		/*	
		 * 		get records 
		 */
		$sql = "SELECT * FROM publications".$where." ORDER BY published DESC LIMIT ".$startRRN.",".$pageSize;
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
        return $rtn;
		
	}
	function getTitle()	{
		$_SESSION['bookID']	=	$_GET['id'];
		$sql = "SELECT * FROM publications WHERE id = '".$_GET['id']."' LIMIT 1";
        $this->database->query($sql);
        $rtn	= $this->database->loadObjectList();
        $this->setSessionEdit($rtn[0]);
        return $rtn;
		
	}
	function setSessionEdit($book)	{
		$_SESSION['title']				=	$book->title;
		//$_SESSION['author']			=	$book->author;
		//$_SESSION['authorid']		= 	$book->authorid;
		$_SESSION['author'] 			= $this->getAuthorNames($book->id); 				//	key =id,	 value =	firstname.' '.lastname;
		$_SESSION['published']		= 	date('d-m-Y', strtotime($book->published));
		$_SESSION['genre']			=	$book->genre;
		$_SESSION['categoryid']	=	$book->categoryid;
		$_SESSION['area']				=	$book->area;
		$_SESSION['synopsis']		=	$book->synopsis;
		$_SESSION['hardback']		=	$book->hardback;
		$_SESSION['paperback']	=	$book->paperback;
		$_SESSION['ebook']			=	$book->ebook;
		$_SESSION['audio']			=	$book->audio;
		$_SESSION['language']		=	$book->language;
		$_SESSION['pages']			=	$book->pages;
		$_SESSION['isbn13']			=	$book->isbn13;
		$_SESSION['asin']				=	$book->asin;		
		$_SESSION['publisher'] 		= 	$book->publisher;	
		$_SESSION['publisherurl']	=	htmlentities($book->publisherurl);
		$_SESSION['image']			=	$book->image;
		$_SESSION['isbn']				=	htmlentities($book->isbn);
		$_SESSION['linktext']			=	$book->linktext;
		$_SESSION['linkurl']			=	htmlentities($book->linkurl);
		$_SESSION['vendor']			=	$book->vendor;
		$_SESSION['vendorurl']		=	htmlentities($book->vendorurl);
		$_SESSION['ebooksize'] 	=	$book->size;
		$_SESSION['editorschoice'] = $book->editorschoice;
		$_SESSION['editorschoicenarrative'] = $book->narrative;
		
		$_SESSION['err']		=	array();
		$_SESSION['ok']			=	true;
	
	}
		function getAuthorNames($bookID) {
        $sql= "SELECT author_x_book.*, authors.* 
        			FROM author_x_book LEFT JOIN authors 
        			ON  author_x_book.authorid = authors.id
        			WHERE  author_x_book.bookid = ".$bookID.
        			' ORDER BY sequence';
       
        $this->database->query($sql);
        $authors = $this->database->loadObjectList();
        $arrAuthors = array();
        foreach($authors as $author) {
        	$arrAuthors[$author->id]	=	$author->firstname.' '.$author->lastname;
        } 
        return $arrAuthors;
	}
	
	function validInput()	{
		$authfield = "auth";
		$hiddenfield ="authorHdnId";
		$gotAuthor = false;
		$this->authorNames = array();
		
		foreach($_POST as $fieldName => $value)	{
			if(substr($fieldName, 0, 11)	== $hiddenfield) {
				$number = substr($fieldName,11,1);
				
				if(!$value == '' ) {
					$gotAuthor = true;
					$this->authorNames[$_POST[$hiddenfield.$number]]	= $_POST[$authfield.$number];
				}
			}
		}
		$_SESSION['author'] = $this->authorNames;
		$_SESSION['title']				=	$_POST['title'];
//		$_SESSION['author']			=	$_POST['author'];
//		$_SESSION['authorid']		=	$_POST['authorid'];
		$_SESSION['synopsis']		=	$_POST['synopsis'];
		$_SESSION['area']				=	$_POST['area'];
		$_SESSION['genre']			=	$_POST['genre'];
		$_SESSION['categoryid']	=	$_POST['categoryid'];
		$_SESSION['language']		=	$_POST['language'];
		$_SESSION['pages']			=	$_POST['pages'];
		$_SESSION['hardback']		=	$_POST['hardback'];
		$_SESSION['paperback']	=	$_POST['paperback'];
		$_SESSION['ebook']			=	$_POST['ebook'];
		$_SESSION['audio']			=	$_POST['audio'];
		$_SESSION['isbn']				=	$_POST['isbn'];
		$_SESSION['asin']				=	$_POST['asin'];
		$_SESSION['isbn13']			=	$_POST['isbn13'];
		$_SESSION['publisher'] 		= 	$_POST['publisher'];	// admin user only ***
		$_SESSION['publisherurl']	=	$_POST['publisherurl'];
		$_SESSION['linktext']			=	$_POST['linktext'];
		$_SESSION['linkurl']			=	$_POST['linkurl'];
		$_SESSION['vendor']			=	$_POST['vendor'];
		$_SESSION['vendorurl']		=	$_POST['vendorurl'];
		$_SESSION['editorschoice']= $_POST['editorschoice'];

 	   	$err	=	array();
    	$ok		=	true;
    	
   		$today		=	new DateTime('now');
   		$nowYear	=	$today->format('Y');
   		$nowDay		=	$today->format('z');
		if($_POST['day']	==	"")	
			$day	=	$nowDay;
		else 
			$day	=	$_POST['day'];
		
		if($_POST['year']	==	"")
			$year	=	$nowYear;
		else
			$year	=	$_POST['year'];
		
    	$published		=	$day.'-'.$_POST['month'].'-'.$year;
    	$_SESSION['published']	=	$published; 
    		
   		$datePublished	=	new DateTime($published);
   		$pubYear	=	$datePublished->format('Y');
   		$pubDay		=	$datePublished->format('z');
   	
    	if($_POST['title'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter a Title";
    		$err['field'][]	=	"title";
    	}
    	//if($_POST['author'] == "")	{
    	if(count($this->authorNames) ==0 ) {
    		$ok				=	false;
    		$err['msg'][]	=	"Please select (an) Author(s)";
    		$err['field'][]	=	"author";
    	}
		if($_POST['genre'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter a Genre";
    		$err['field'][]	=	"genre";
    	}
    	if($_POST['area'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter an Area";
    		$err['field'][]	=	"area";
    	}
    	if($_POST['synopsis'] == "")	{
    		$ok				=	false;
    		$err['msg'][]	=	"Please enter a short description of the book";
    		$err['field'][]	=	"synopsis";
    	}
    	if(!$_POST['publisherurl']	== '')	{
			if(!filter_var($_POST['publisherurl'], FILTER_VALIDATE_URL))	{
    			$ok				=	false;
    			$err['msg'][]	=	'The url is invalid. Please include the "http://" part.';
    			$err['field'][]	=	"publisherurl";
			}
    	}
    	if(!$_POST['vendorurl']	== '')	{
			if(!filter_var($_POST['vendorurl'], FILTER_VALIDATE_URL))	{
    			$ok				=	false;
    			$err['msg'][]	=	'The url is invalid. Please include the "http://" part.';
    			$err['field'][]	=	"vendorurl";
			}
    	}
    	if(!$_POST['linkurl']	== '')	{
			if(!filter_var($_POST['linkurl'], FILTER_VALIDATE_URL))	{
    			$ok				=	false;
    			$err['msg'][]	=	'The url is invalid. Please include the "http://" part.';
    			$err['field'][]	=	"linkurl";
			}
    	}
    	
   		$upload		=	new file_load;
   		
   		$image 		=	$upload->upload_file();
   		unset($_SESSION['uploadedImage']);
   		if($image['ok']	===	 true)	{
   			$_SESSION['uploadedImage'] =	$image['file'];
   		}
   		else	{  			// error ...
   			$ok 	= false;
    		$status['msg'][]	=	$image['msg'];
    		
			$err['field'][]	=	'image';
    		$status['field'][]	=	"image";
    		$err['msg'][]	=	$image['msg'];
   		}
   		
 /*   	
		$loadImage		=	$this->upload_file();
		$err['msg'][]	=	$loadImage['msg'];
		
		if($loadImage['ok'] === false)	{
			$err['field'][]	=	'image';
			$ok = false;	
		}
*/		
		$_SESSION['err']	=	$err;
		if($ok == false)		$_SESSION['msg'][] = 'To save this book please fix the errors highlighted below';
     	return $ok;
}
	function save()	{
		$title		=	$this->database->getQuotedString($_POST['title']);
		//$author		=	$this->database->getQuotedString($_POST['author']);
		//$authorid	= 	(isset($_POST['authorid'])	 && ($_POST['authorid'] != ''))	?	$this->database->getQuotedString($_POST['authorid'])	: 	0;		//	hidden field
		//$authorXRef	= explode(',',$_POST['authorid'])	;
		$sep		=	'';
		$author = '';
		$authorid = $this->database->getQuotedString('');
		foreach($this->authorNames as $id => $name) {
			$author .= $sep. $name;
			$sep 	= ', ';
		}
		$author = $this->database->getQuotedString($author);
				
		$synopsis	=	$this->database->getQuotedString($_POST['synopsis']);
		$area		=	$this->database->getQuotedString($_POST['area']);
		$genre		=	$this->database->getQuotedString($_POST['genre']);
		$categoryid = (isset($_POST['categoryid'])	&& ($_POST['categoryid'] != ''))	?	$_POST['categoryid']	:	0;	//	hidden field
		$published	= 	'"'.date('Y-m-d',strtotime(str_replace("/","-",$_SESSION['published']))).'"';
		$language	=	$this->database->getQuotedString($_POST['language']);
		$pages		=	$this->database->getQuotedString($_POST['pages']);
		$hardback	=	isset($_POST['hardback']) ? $this->database->getQuotedString($_POST['hardback']) : 0;
		$paperback	=	isset($_POST['paperback']) ? $this->database->getQuotedString($_POST['paperback']) : 0;
		$ebook		=	isset($_POST['ebook']) ? $this->database->getQuotedString($_POST['ebook']) : 0;
		$audio		=	isset($_POST['hardback']) ? $this->database->getQuotedString($_POST['audio']) : 0;						
		$isbn		=	$this->database->getQuotedString($_POST['isbn']);
		$isbn13		=	$this->database->getQuotedString($_POST['isbn13']);
		$asin		=	$this->database->getQuotedString($_POST['asin']);
	//	$publisher 	= 	"'".$_POST['publisher']."'";
		$publisher 	= 	$this->database->getQuotedString($_POST['publisher']);
		$publisherurl=	"'".$_POST['publisherurl']."'";
		$linktext	=	$this->database->getQuotedString($_POST['linktext']);
		$linkurl	=	$this->database->getQuotedString($_POST['linkurl']);
		$vendor		=	$this->database->getQuotedString($_POST['vendor']);
		$vendorurl	=	$this->database->getQuotedString($_POST['vendorurl']);
		$size 		=	$this->database->getQuotedString($_POST['ebooksize']);
		$editorschoice = isset($_POST['editorschoice']) ? $_POST['editorschoice']	: '0';
		$narrative	= isset($_POST['editorschoicenarrative']) ? $_POST['editorschoicenarrative']	: '';
		$narrative	=	$this->database->getQuotedString($narrative);
		$image		=	"";
		if(isset($_SESSION['uploadedImage']))	{
			$tempImage 		=	$_SESSION['uploadedImage'];	
			$temp = explode(".", $tempImage);
			$extension = end($temp);
			$image	=	$_SESSION['bookID'].'.'.$extension;
		}
		else 	{
			$tempImage		=	"";
			$image			=	$_SESSION['image'];
		}
		$placeholder	=	"'placeholder.jpg'";
		
		if(!isset($_SESSION['bookID']) || ($_SESSION['bookID'] == ""))	{
		/* 
		 * NEW RECORD
		 * 		checking for F5/refresh/Back/Fwd browser buttons...
		 * 			if identical record exists, then do nothing 
		 */
			
		  $sql 	=	sprintf("Select * FROM publications WHERE title = %s
		  		AND genre = %s AND author = %s AND publisher = %s AND publisherurl = %s 
		  		AND area = %s AND synopsis = %s AND
		  		 
		  		hardback = %s AND paperback = %s AND ebook = %s AND audio =	%s AND
		  		pages = %s AND language = %s AND isbn13 = %s AND published = %s  
		  		AND isbn = %s AND linktext = %s AND linkurl = %s AND vendor = %s 
		  		AND vendorurl = %s", 
		  		$title, $genre, $author, $publisher, $publisherurl, $area, $synopsis, 
		  		$hardback, $paperback, $ebook, $audio, $pages, $language, $isbn13, $published, 
		  		$isbn, $linktext, $linkurl, $vendor, $vendorurl
		  		);

		  $this->database->query($sql);
		  $result = $this->database->loadObjectList();

		  if(count($result)	== 0) {
			  $sql 	= 	'INSERT INTO publications (title, genre, categoryid, author, authorid, publisher, publisherurl, 
						  	area, synopsis, hardback, paperback,ebook, audio, pages, language, isbn13, 
						  	asin, published,image, isbn, linktext, linkurl, vendor, vendorurl, user_id, size, editorschoice, narrative)
					VALUES ('.$title.','.$genre.','.$categoryid.','.$author.','.$authorid.','.$publisher.','.$publisherurl.
					','.$area.','.$synopsis.','.$hardback.','.$paperback.','.$ebook.','.$audio.
					','.$pages.','.$language.','.$isbn13.','.$asin.','.$published.','.$placeholder.','.$isbn.
					','.$linktext.','.$linkurl.','.$vendor.','.$vendorurl.','.$_SESSION['id'].','.$size.', '.$editorschoice.', '.$narrative.')';
		  }
		  else {
		  	$this->resetSession();
		  	return;
		  }
		}
		else	{													
		/* 
		 * EXISTING RECORD
		 */
			$sql	=	'UPDATE publications SET title = '.$title.', genre = '.$genre.', categoryid = '.$categoryid.
			', author = '.$author.',  authorid = '.$authorid.', publisher = '.$publisher.
			', language = '.$language.', pages = '.$pages.', hardback = '.$hardback.
			', paperback = '.$paperback.', ebook = '.$ebook.', audio = '. $audio.', isbn13 = '.$isbn13. 
			', publisherurl = '.$publisherurl.', area = '.$area.', asin = '.$asin.
			', synopsis = '.$synopsis.', published = '.$published.', image = "'.$image.
			'", isbn = '.$isbn.', linktext = '.$linktext.', linkurl = '.$linkurl.
			', vendor = '.$vendor.', vendorurl = '.$vendorurl.
			', size = '. $size.', editorschoice = '.$editorschoice.', narrative = '.$narrative.
			' WHERE id = '.$_SESSION['bookID'];
		}
/*		
		var_dump($_SESSION);
		die;
var_dump($_POST);
				var_dump($authorid);
		echo '<br>'.$sql;
*/	
	$rtn 	=	$this->database->query($sql);
	
		if(($_SESSION['mode'] != "editBook"))	{
			$sql	=	"SELECT LAST_INSERT_ID() as id";
			$this->database->query($sql);
			$result	=	$this->database->loadObjectList();
			$_SESSION['bookID'] = $result[0]->id;
		}
		if ($tempImage	!=	"")	{
			if(($_SESSION['mode'] != "editBook"))	{
				$image	=	$result[0]->id;
				$image	.=	'.'.$extension;
			}
			$sql =	'UPDATE publications SET image = "'.$image.'" WHERE id = LAST_INSERT_ID()';
			$this->database->query($sql);
				
			

			if (file_exists("upload/" . $image)) {
		   		unlink("upload/" .$image);	// delete file if exists
			}

			rename($tempImage, "upload/".$image);
		}
/*	var_dump($tempImage);
		var_dump($image);
		var_dump($_SESSION);
		die;
	*/
		$sql = 'DELETE FROM author_x_book WHERE bookid = '. $_SESSION['bookID'] ;
		$this->database->query($sql);
		$sequence = 0;
		foreach($this->authorNames  as $id=>$name)	{
			$sequence++;
			$sql = 'INSERT INTO author_x_book (authorid, bookid, sequence) VALUES ("'.$id . '",'.$_SESSION['bookID'].', '.$sequence .')';
			
			$this->database->query($sql);
		}		
		$msg	=	'Saved title <i>"'.$_SESSION['title'].'"</i>';
		if(($tempImage	==	"")	&& (!$_SESSION['mode'] =='editBook')) {
			$msg	.=	" (without an Image) ";
		}		
		$_SESSION['msg'][]	=	$msg; 
		$this->resetSession();
		$_SESSION['bookID']	=	'';
		$_SESSION['mode']	=	"";
		$_SESSION['saved']		=	true;
		$_SESSION['image']		=	"";		
	}
	
	function resetSession()	{
		unset($_SESSION['ok']);
		//$_SESSION['mode']	=	"";
		$_SESSION['title']				=	"";
		$_SESSION['author']			=	"";
		$_SESSION['authorid']		=	"";
		$_SESSION['published']		= 	"";
		$_SESSION['genre']			=	"";
		$_SESSION['categoryid'] 	=	"";
		$_SESSION['area']				=	"";
		$_SESSION['synopsis']		=	"";
		$_SESSION['hardback']		=	"";
		$_SESSION['paperback']	=	"";
		$_SESSION['ebook']			=	"";
		$_SESSION['audio']			=	"";
		$_SESSION['language']		=	"";
		$_SESSION['pages']			=	"";
		$_SESSION['isbn13']			=	"";
		$_SESSION['asin']				=	"";
		$_SESSION['publisher'] 		= 	"";	// admin user only ***
		$_SESSION['publisherurl']	=	"";
		$_SESSION['isbn']				=	"";
		$_SESSION['linktext']			=	"";
		$_SESSION['linkurl']			=	"";
		$_SESSION['vendor']			=	"";
		$_SESSION['vendorurl']		=	"";
		$_SESSION['ebooksize'] 	=	'';
		$_SESSION['editorschoice']	= '';
		$_SESSION['editorschoicenarrative']	= '';
//		$_SESSION['image']		=	"";
	}
/*	 
	function upload_file()	{

		$msg		=	array();
		$msg['ok']	=	true;

		unset($_SESSION['uploadedImage']);
		
		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG" );
		
		$temp = explode(".", $_FILES["image"]["name"]);
/*		var_dump($_FILES);
		die;
		*//*
		if($_FILES['image']['name']	!=	'')	{
 		  $extension = end($temp);

		  if ((($_FILES["image"]["type"] == "image/gif")
			|| ($_FILES["image"]["type"] == "image/jpeg")
			|| ($_FILES["image"]["type"] == "image/jpg")
			|| ($_FILES["image"]["type"] == "image/pjpeg")
			|| ($_FILES["image"]["type"] == "image/x-png")
			|| ($_FILES["image"]["type"] == "image/png"))
			&& ($_FILES["image"]["size"] < (5000 * 1024))
			&& in_array($extension, $allowedExts)) {
  			if ($_FILES["image"]["error"] > 0) {
			    //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			    $msg['ok'] 		=	false;
			    $msg['msg']		=	"File Upload Error - Return Code: " . $_FILES["file"]["error"] . "<br>";
  			} 	
 	 		else {
			    if (file_exists("upload/" . $_FILES["image"]["name"])) {

			    	unlink("upload/" .$_FILES["image"]["name"]);	// delete 
			    }
   		  			move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);
   		  		  
	   			  	$_SESSION['uploadedImage'] =	"upload/".$_FILES["image"]["name"];
  			}
		} 
		else {
			$msg['ok']	=	false;
			if($_FILES["image"]["size"]	>	(5000 * 1024) )	{
				$msg['msg'] =	"File ".$_FILES['image']['name']." is too big (".$_FILES["image"]["size"]." bytes). Maximum size allowed is 50Kb (". (50 * 1024) ." bytes)";
			}
			else	{					
				$msg['msg'] =	"Invalid Image file (" .$extension."). <p>Only files with extension of jpg, jpeg, png or gif, and that are valid Image files are allowed</p>" ;
			}
		}
		return $msg;
	}
	}
	*/
	function deleteTitle($rcdId)	{
/*		var_dump($_SESSION);
		var_dump($_POST);
		var_dump($_GET);
		die;
		*/
		$sql = "SELECT * FROM publications WHERE id = '".$rcdId."' LIMIT 1";
		$rtn	=	$this->database->query($sql);
		$rtn	= 	$this->database->loadObjectList();	// returns null if record not found
		if($rtn != null)	{
			$this->setSessionEdit($rtn[0]);
			$sql = "DELETE FROM author_x_book WHERE bookid = '".$rcdId."'";
			
			$rtn	=	$this->database->query($sql);
			$rtn	= 	$this->database->loadObjectList();
			$sql = "DELETE FROM publications WHERE id = '".$rcdId."' LIMIT 1";
			$rtn	=	$this->database->query($sql);
			$rtn	= 	$this->database->loadObjectList();
//		var_dump($rtn);
//		die;
			//$_SESSION['err']['msg'][]	=	$rtn;
			$_SESSION['msg'][]	= 'Title <i>'.	$_SESSION['title']. "</i> was deleted";

			$_SESSION['deleted']	= true;
		}
				
		$this->resetSession();
		$_SESSION['mode']	=	"";
		$_SESSION['image']	=	"";
		$_SESSION['bookID']	=	"";
	}

	function logout()	{
		$this->my_access	=	new Access_user;
		$this->my_access->log_out();
	}
	function getUser($email)	{
		$sql = "SELECT * FROM users where email = '".$email."'";
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
        $this->setSessionUserEdit($rtn[0]);
        return $rtn;
	}
	function setSessionUserEdit($user)	{
		$_SESSION['origUser']				=	$user->id;
		$_SESSION['origUserFirstName']		=	$user->real_name;	
		$_SESSION['origUserLastName']		=	$user->lastname;
		$_SESSION['origPublisherName']		=	$user->publisher;
		$_SESSION['origTelephone']			=	$user->telephone;
		$_SESSION['origPosition']			=	$user->position;
		$_SESSION['origEmail']				=	$user->email;
		
		$_SESSION['userId']					=	$user->id;
		$_SESSION['firstname']				=	$user->real_name;	
		$_SESSION['lastname']				=	$user->lastname;
		$_SESSION['publishername']			=	$user->publisher;
		$_SESSION['telephone']				=	$user->telephone;
		$_SESSION['position']				=	$user->position;
		$_SESSION['email']					=	$user->email;
		$_SESSION['password']				=	$_SESSION['user_pw'];
		$_SESSION['passwordconfirm']		=	"";
		
		$_SESSION['err']		=	array();
	}
    function validProfile()	{
    	$_SESSION['firstname']		=	$_POST['firstname'];
    	$_SESSION['lastname']		=	$_POST['lastname'];
    	//$_SESSION['publishername']	=	$_POST['publishername'];
    	$_SESSION['email']			=	$_POST['email'];
    	$_SESSION['telephone']		=	$_POST['telephone'];
    	$_SESSION['position']		=	$_POST['position'];
    	$_SESSION['password']		=	$_POST['password'];
    	$_SESSION['passwordconfirm']=	$_POST['passwordconfirm'];
    	$err		=	array();
    	$new_member = 	new Access_user;
		$firstname	=	$_POST['firstname'];
		$lastname	=	$_POST['lastname'];
		$publisher	=	$_SESSION['publishername'];
		$position	=	$_POST['position'];
		$telephone	=	$_POST['telephone'];
		$email		=	$_POST['email'];
    	$pwd		=	$_POST['password'];
		$confirm	=	$_POST['passwordconfirm'];
		$rtn =	true;
		if($firstname	==	"")	{
			$err['field'][]	=	"firstname";
			$err['msg'][]	=	"Please enter a First Name";
			$rtn =	false;
		}
		if($lastname	==	"")	{
			$err['field'][]	=	"lastname";
			$err['msg'][]	=	"Please enter a Last Name";
			$rtn =	false;
		}
/*		if($publisher	==	"")	{
			$err['field'][]	=	"publisher";
			$err['field'][]	=	"Enter a Publisher name";
			$rtn =	false;
		}*/
		if($position	==	"")	{
			$err['field'][]	=	"position";
			$err['msg'][]	=	"Please enter your Position";
			$rtn =	false;
		}
		
		$new_member->user_email	= 	$_SESSION['origEmail'];
		$new_member->id			=	$_SESSION['userId'];
		$new_member->user_pw	=	$_SESSION['user_pw'];
		$new_member->update_user($pwd, $confirm, $firstname, date("Y-m-d H:i:s"), $email, $publisher, $lastname, $telephone, $position );

    	$status = $new_member->msgNo; // error message
		$err['msg'][]	=	$new_member->the_msg;
		switch ($status)	{
			case 32:		//	password
				$err['field'][]	= "password";
				$rtn =	false;
				break;
			case	38:
				$err['field'][]	= "password";
				$rtn =	false;
				break;
			case	31:
				$err['field'][]	=	"email";
				$rtn =	false;
				break;
			case 	16:
				$err['field'][]	=	"email";
				$rtn =	false;
				break;
			case 30:							// success
				break;
			default:
			}
		$_SESSION['err']	= $err;
		return $rtn;
    } 

    function loadPublishers()	{				//publishing Companies array
    	$_SESSION['publisherNames']	= array();
		$query = 'SET CHARACTER SET latin1';
		$this->database->query($query);
    	$sql = "SELECT * FROM publishers order by name";
        $this->database->query($sql);
        $publishers	= $this->database->loadObjectList();
       
        foreach($publishers as $idx=>$arrPublisher){
        	$_SESSION[publishers][$arrPublisher->name]	=	$arrPublisher->url;
        }
        
        return;
    	
    }
    function loadCategories()	{				//	Categories array
		$_SESSION['categories']		= array();
		$sql = "SELECT * FROM categories order by Name";
        $this->database->query($sql);
        $categories	= $this->database->loadObjectList();
        foreach($categories as $idx=>$arrCategory){
        	$_SESSION['categories'][$arrCategory->Name]	=	$arrCategory->id;
        }
        return;
    	
    }
}