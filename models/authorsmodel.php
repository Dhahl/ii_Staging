<?php
defined('DACCESS') or die ('access denied');
include "./classes/openitireland/class.upload.php";

class Authorsmodel extends Model {
     function __construct() {
        parent::__construct();
     }
        public function getAuthors() {
     	$where =	'';
//    	if($_SESSION['accessLevel']	!== '10') //	Not Admin
//		    		$where = "WHERE createdby = '". $_SESSION['id']."'";
		$query = 'SELECT * FROM authors '.$where. 'ORDER BY lastname,firstname asc' ;
	
		$this->database->query($query);
		$authors = 	$this->database->loadObjectList();
 		
		return $authors;
    }
    public function getAuthor() {
    	$query = 'SELECT * FROM authors where id = '.$_GET['id'];
		$this->database->query($query);
		$e		 = 	$this->database->loadObjectList();
		$author = $e[0];
    	$_SESSION['authorId'] 					=	$author->id; 
    	$_SESSION['authorFirstName'] 		=	$author->firstname; 
    	$_SESSION['authorLastName'] 		=	$author->lastname; 
    	$_SESSION['authorDOB']				=	$author->dob; 
    	$_SESSION['authorProfile'] 			=	$author->profile; 
    	$_SESSION['authorAltLink'] 			=	$author->altlink; 
    	$_SESSION['authorAddress'] 			=	$author->address;
    	$_SESSION['authorUrl'] 					=	$author->url; 
    	$_SESSION['authorImage'] 				=	$author->image; 
    	$_SESSION['authorCreatedBy'] 		=	$author->createdby;
    }
    public function reset() {
		$_SESSION['authorId'] 					=	''; 
    	$_SESSION['authorFirstName'] 		=	''; 
    	$_SESSION['authorLastName'] 		=	''; 
    	$_SESSION['authorDOB']				=	'';
    	$_SESSION['authorProfile']				=	''; 
    	$_SESSION['authorAltLink'] 			=	''; 
    	$_SESSION['authorAddress'] 			=	''; 
    	$_SESSION['authorUrl'] 					=	'';
    	$_SESSION['authorImage'] 				=	''; 
    	$_SESSION['authorCreatedBy'] 		=	''; 

    	$_SESSION['mode']						=	'';
    }
    public function validateAuthor() 	{
    	$status	=	array();
    	$error	= false;
		if($_SESSION['mode']	== 'editAuthor'	)
				$_SESSION['authorId']		=	$_GET->id;
				 
    	$_SESSION['authorFirstName']	=	$_POST['firstname']; 
    	$_SESSION['authorLastName'] 	=	$_POST['lastname']; 
    	 
    	$_SESSION['authorDOB'] 			=	$this->captureDate($_POST['day'],$_POST['month'],$_POST['year']); 
    	$_SESSION['dayFrom']				=	$_POST['dayfrom'];
    	$_SESSION['monthFrom']			=	$_POST['monthfrom'];
    	$_SESSION['yearFrom']				=	$_POST['yearfrom'];
     	
    	$_SESSION['authorProfile']			=	$_POST['profile'];
    	$_SESSION['authorAltLink'] 		=	$_POST['altlink']; 
    	$_SESSION['authorAddress'] 		= 	$_POST['address'];
    	$_SESSION['authorUrl'] 				= 	$_POST['url'];
   		$_SESSION['authorImage']			=	isset($_POST['image'])	?	$_POST['image']	:	$_SESSION['authorImage']; 
  		
   		$upload		=	new file_load;
   		$image 		=	$upload->upload_file();
   		unset($_SESSION['uploadedImage']);
   		if($image['ok']	===	 true)	{
   			$_SESSION['uploadedImage'] =	$image['file'];
   		}
   		else	{  			// error ...
   			$error 	= true;
    		$status['msg'][]	=	$image['msg'];
    		$status['field'][]	=	"image";
   		}
  		
   		if($error	== false ) $this->saveAuthor();
		else   		$_SESSION['msg']		=	$status['msg'];	
    }
    function captureDate($day, $month, $year) {
		if( (($day == '0') || ($day == ''))
			 && ($month == '') && 
			 (($year == '0')	||	$year == '') ) $returnDateTime = '';
			 
		else 	$returnDateTime	=	$day.'-'.$month.'-'.$year;
   		return $returnDateTime;
    }
    public function saveAuthor() 	{
    	$status		=		array();
    	$firstname =		$this->database->getQuotedString(ltrim($_POST['firstname']));
    	$lastname	=		$this->database->getQuotedString(ltrim($_POST['lastname']));
    	$dob			=		$_SESSION['authorDOB']	!=	'' ? $this->database->getQuotedString(date('Y-m-d H:i',strtotime($_SESSION['authorDOB']))) : null;
    	$profile		=		$this->database->getQuotedString($_POST['profile']);
    	$altLink		=		$this->database->getQuotedString($_POST['altlink']);
    	$address 	=		$this->database->getQuotedString($_POST['address']);
    	$url			=		$this->database->getQuotedString($_POST['url']); 

    	$image		=	"";
		if(isset($_SESSION['uploadedImage']))	{
			$tempImage 		=	$_SESSION['uploadedImage'];	
			$temp 				= 	explode(".", $tempImage);
			$extension 		= 	end($temp);
			$image				=	'author'.$_GET['id']. '.' .$extension	;
		}
		elseif(isset($_SESSION['authorImage'])) 	{
			$tempImage		=	"";
			$image				=	$_SESSION['authorImage'];
		}
		else 		$image	=	'placeholder.jpg';

		$DB_Image		=	$this->database->getQuotedString($image);
		
		$d = strtotime($_SESSION['authorDOB']);
		$dob  = $this->database->getQuotedString(date('Y-m-d H:i',$d));
				
    	if($_SESSION['mode']	== 'editAuthor'	)	{
    		
    		$sql 	=	 'UPDATE authors SET firstname = '.$firstname.', lastname =  '.$lastname;
    		if($_SESSION['authorDOB'] != '')	$sql	.= ', dob = '.$dob;
    		else $sql	.= ', dob = null';
    		$sql .=	', profile  = '.$profile.', image  = '.$DB_Image.
			', altlink= '.$altLink.', address= '.$address.', url = '. $url. 
			' WHERE id = '.$_GET['id'];
    	}
    	else 	{			
    		/* new record
    		 * 
    		 * first check for refresh/back btn etc.
    		 */
    	$sql = 'Select * FROM authors WHERE firstname = '.$firstname.' AND lastname = '.$lastname.
			' AND dob = '.$dob.' AND profile = '.$profile.' AND image  = '.$DB_Image.
			' AND altlink= '.$altLink.' AND address = '.$address.' AND  url = '. $url; 
		
    	$this->database->query($sql);
		$result = $this->database->loadObjectList();
		
		if(count($result)	== 0) {
    		$sql = 'INSERT INTO authors (firstname, lastname, '; 
			if($_SESSION['authorDOB'] != '')	$sql .= 'dob, ';
			$sql 	.=	'profile, image, altlink, address, url, createdby)
					VALUES ('.$firstname.','.$lastname.',';
			if($_SESSION['authorDOB'] != '')	$sql 	.=	$dob.',';
			$sql 	.=	$profile.','.$DB_Image.','.$altLink.','.$address.','.$url.','.$_SESSION['id'].')';
		  }
    	}
	
    	$this->database->query($sql);
    	
    		/* 
    		 * get last insert record Id for Image name	
    		 */
			if(($_SESSION['mode'] != 'editAuthor'))	{
				
				$status['msg'][]	=	'Author '.$firstname.' ' .$lastname. ' has been created.';
				
				if(isset($_SESSION['uploadedImage'])) {
					$sql	=	"SELECT LAST_INSERT_ID() as id";
					$this->database->query($sql);
					$result	=	$this->database->loadObjectList();
					$image	=	'author'.$result[0]->id;
					$image	.=	'.'.$extension;
					$sql =	'UPDATE authors SET image = "'.$image.'" WHERE id = LAST_INSERT_ID()';
					$this->database->query($sql);
				}
			}
			else {
				$status['msg'][] 	=	'Author '.$firstname.' '.$lastname.' has been updated';
			}
    	
    	
    	if(isset($_SESSION['uploadedImage']))		{
	    	if (file_exists("../upload/" . $image)) {
				unlink("../upload/" .$image);								// delete file if exists
			}

			rename($tempImage, "upload/".$image);				// move and rename the image
    	}
    $this->reset();
    $_SESSION['msg']	 = $status['msg'];
    }
	public function deleteAuthor() {
		$status = array();
		$sql = 'DELETE from authors WHERE id = '. $_POST['delete'];
	   	$this->database->query($sql);
		$status['msg'][] = 'Author  '. $_SESSION['firstname'].' '.$_SESSION['lasname']. ' was deleted';
		$_SESSION['msg']	= $status['msg'];
		$this->reset(); 
	}
}