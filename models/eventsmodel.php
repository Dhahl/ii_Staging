<?php
defined('DACCESS') or die ('access denied');
include "./classes/openitireland/class.upload.php";

class Eventsmodel extends Model {
     function __construct() {
        parent::__construct();
     }
        public function getEvents() {
     	$where =	'';
    	if($_SESSION['accessLevel']	!== '10') //	Not Admin
		    		$where = "WHERE owner = '". $_SESSION['id']."'";
		$query = 'SELECT * FROM events '.$where.' ORDER BY date_time_from ' ;
	
		$this->database->query($query);
		$events = 	$this->database->loadObjectList();
 		
		return $events;
    }
    public function getEvent() {
    	$query = 'SELECT * FROM events where id = '.$_GET['id'];
		$this->database->query($query);
		$e		 = 	$this->database->loadObjectList();
		$event = $e[0];
    	$_SESSION['eventId'] 					=	$event->id; 
    	$_SESSION['eventTitle'] 					=	$event->title; 
    	$_SESSION['eventDescription'] 		=	$event->description; 
    	$_SESSION['eventLocation']			=	$event->location; 
    	$_SESSION['eventOrganiser'] 			=	$event->organiser; 
    	$_SESSION['eventBookId'] 				=	$event->bookid; 
    	$_SESSION['eventAuthorId'] 			=	$event->authorid; 
    	$_SESSION['eventDateTimeFrom'] 	=	$event->date_time_from; 
    	$_SESSION['eventDateTimeTo'] 		=	$event->date_time_to;
    	$_SESSION['eventImage'] 				=	$event->image; 
    	$_SESSION['eventUrl'] 					=	$event->link; 
    	$_SESSION['eventContactPhone'] 	=	$event->contactphone; 
    	$_SESSION['eventContactEmail'] 	= 	$event->contactemail;
    }
    public function reset() {
		$_SESSION['eventId'] 					=	''; 
    	$_SESSION['eventTitle'] 					=	''; 
    	$_SESSION['eventDescription'] 		=	''; 
    	$_SESSION['eventLocation']			=	''; 
    	$_SESSION['eventOrganiser'] 			=	''; 
    	$_SESSION['eventBookId'] 				=	''; 
    	$_SESSION['eventAuthorId'] 			=	''; 
    	$_SESSION['eventDateTimeFrom'] 	=	''; 
    	$_SESSION['eventDateTimeTo'] 		=	'';
    	$_SESSION['eventImage'] 				=	''; 
    	$_SESSION['eventUrl'] 					=	''; 
    	$_SESSION['eventContactPhone'] 	=	''; 
    	$_SESSION['eventContactEmail'] 	= 	'';
    	$_SESSION['mode']						=	'';
    }
    public function validateEvent() 	{
    	$status	=	array();
    	$error	= false;
		if($_SESSION['mode']	== 'editEvent'	)
				$_SESSION['eventId']				=	$_GET->id;
				 
    	$_SESSION['eventTitle'] 					=	$_POST['eventtitle']; 
    	$_SESSION['eventDescription'] 		=	$_POST['eventdescription']; 
    	$_SESSION['eventLocation']			=	$_POST['location']; 
    	 
  //  	$_SESSION['eventBookId'] 				=	$_POST['']; 
  //  	$_SESSION['eventAuthorId'] 			=	$_POST[''];
   
    	$_SESSION['eventDateTimeFrom'] 	=	$this->captureDate($_POST['dayfrom'],$_POST['monthfrom'],$_POST['yearfrom'], $_POST['hourfrom'],$_POST['minutesfrom']); 
    	$_SESSION['dayFrom']					=	$_POST['dayfrom'];
    	$_SESSION['monthFrom']				=	$_POST['monthfrom'];
    	$_SESSION['yearFrom']					=	$_POST['yearfrom'];
    	$_SESSION['hourFrom']					=	$_POST['hourfrom'];
    	$_SESSION['minutesfrom']				=	$_POST['minutesfrom'];
    	
    	$dayTo		=	$_POST['dayto']			==	'' 	?	$_SESSION['dayFrom'] 		:	$_POST['dayto']	;
		$monthTo 	=	$_POST['monthto']		== 	''	?	$_SESSION['monthFrom']	:	$_POST['monthto']	;
		$yearTo		=	$_POST['yearto']		== 	''	?	$_SESSION['yearFrom']		:	$_POST['yearto']; 
		$hourTo		=	$_POST['hourto']		== 	''	?	$_SESSION['hourFrom']		:	$_POST['hourto'];
		$minutesTo=	$_POST['minutesto'] 	==	''	?	$_SESSION['minutesfrom']	:	$_POST['minutesto'];
		$_SESSION['eventDateTimeTo'] 		=	$this->captureDate($dayTo, $monthTo, $yearTo, $hourTo, $minutesTo);
     	
    	$_SESSION['eventOrganiser'] 			=	$_POST['organiser'];
    	$_SESSION['eventContactPhone'] 	=	$_POST['telephone']; 
    	$_SESSION['eventContactEmail'] 	= 	$_POST['email'];
    	$_SESSION['eventUrl'] 					=	$_POST['eventurl']; 
   		$_SESSION['eventImage'] 				=	isset($_POST['image'])	?	$_POST['image']	:	$_SESSION['eventImage']; 
  		
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
  		
   		if($error	== false ) $this->saveEvent();
		else   		$_SESSION['msg']		=	$status['msg'];	
    }
    function captureDate($day, $month, $year, $hour, $minute) {
		
    	$returnDateTime	=	$day.'-'.$month.'-'.$year. ' '.str_pad($hour,2,'0',STR_PAD_LEFT) . ':' . str_pad($minute,2,'0',STR_PAD_LEFT);

   		return $returnDateTime;
    }
    public function saveEvent() 	{
    	$status			=		array();
    	$title 			=		$this->database->getQuotedString($_POST['eventtitle']);
    	$description 	=		$this->database->getQuotedString($_POST['eventdescription']);
    	$location 		=	 	$this->database->getQuotedString($_POST['location']);
    	$dateFrom		=		$this->database->getQuotedString(date('Y-m-d H:i',strtotime($_SESSION['eventDateTimeFrom'])));
    	$dateTo 		=		$this->database->getQuotedString($_SESSION['eventDateTimeTo']);
    	$organiser		=		$this->database->getQuotedString($_POST['organiser']);
    	$phone			=		$this->database->getQuotedString($_POST['telephone']);
    	$email 			=		$this->database->getQuotedString($_POST['email']);
    	$link				=		$this->database->getQuotedString($_POST['eventurl']); 

    	$image		=	"";
		if(isset($_SESSION['uploadedImage']))	{
			$tempImage 		=	$_SESSION['uploadedImage'];	
			$temp 				= 	explode(".", $tempImage);
			$extension 		= 	end($temp);
			$image				=	'event'.$_GET['id']. '.' .$extension	;
		}
		elseif(isset($_SESSION['eventImage'])) 	{
			$tempImage		=	"";
			$image				=	$_SESSION['eventImage'];
		}
		else 		$image	=	'placeholder.jpg';

		$DB_Image		=	$this->database->getQuotedString($image);
		
		$d = strtotime($_SESSION['eventDateTimeFrom']);
		$dateFrom = $this->database->getQuotedString(date('Y-m-d H:i',$d));
				
		$d = strtotime($_SESSION['eventDateTimeTo']);;    	
    	$dateTo = $this->database->getQuotedString(date('Y-m-d H:i',$d));
    	
    	if($_SESSION['mode']	== 'editEvent'	)	{
    		
    		$sql 	=	 'UPDATE events SET title = '.$title.', description = '.$description.
			', location= '.$location.', organiser = '.$organiser.
			', date_time_from = '.$dateFrom.', date_time_to  = '.$dateTo.', image  = '.$DB_Image.
			', contactphone= '.$phone.', contactemail = '.$email.', link= '. $link. 
			' WHERE id = '.$_GET['id'];
    	}
    	else 	{			
    		/* new record
    		 * 
    		 * first check for refresh/back btn etc.
    		 */
    	$sql = 'Select * FROM events WHERE title = '.$title.' AND description = '.$description.
			' AND location= '.$location.' AND organiser = '.$organiser.
			' AND date_time_from = '.$dateFrom.' AND date_time_to  = '.$dateTo.' AND image  = '.$DB_Image.
			' AND contactphone= '.$phone.' AND contactemail = '.$email.' AND  link= '. $link; 
		
    	$this->database->query($sql);
		$result = $this->database->loadObjectList();
		
		if(count($result)	== 0) {
    		$sql = 'INSERT INTO events (title, description, location, organiser, date_time_from, 
						  	date_time_to, image, contactphone, contactemail,link, owner)
					VALUES ('.$title.','.$description.','.$location.','.$organiser.','.$dateFrom.
					','.$dateTo.','.$DB_Image.','.$phone.','.$email.','.$link.','.$_SESSION['id'].')';
		  }
    	}
	
    	$this->database->query($sql);
    	
    		/* 
    		 * get last insert record Id for Image name	
    		 */
			if(($_SESSION['mode'] != 'editEvent'))	{
				
				$status['msg'][]	=	'Event '.$title. ' has been created.';
				
				if(isset($_SESSION['uploadedImage'])) {
					$sql	=	"SELECT LAST_INSERT_ID() as id";
					$this->database->query($sql);
					$result	=	$this->database->loadObjectList();
					$image	=	'event'.$result[0]->id;
					$image	.=	'.'.$extension;
					$sql =	'UPDATE events SET image = "'.$image.'" WHERE id = LAST_INSERT_ID()';
					$this->database->query($sql);
				}
			}
			else {
				$status['msg'][] 	=	'Event '.$title.' has been updated';
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
	public function deleteEvent() {
		$status = array();
		$sql = 'DELETE from events WHERE id = '. $_POST['delete'];
	   	$this->database->query($sql);
		$status['msg'][] = 'Event '. $_SESSION['eventTitle']. ' was deleted';
		$_SESSION['msg']	= $status['msg'];
		$this->reset(); 
	}
}