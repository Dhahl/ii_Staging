<?php
defined('DACCESS') or die ('access denied');
include "./classes/openitireland/class.upload.php";


class Bannermodel extends Model {
     function __construct() {
        parent::__construct();
     }
    public function getBanners() {
     	$where =	'';
		$query = 'SELECT * FROM banner ' ;
	
		$this->database->query($query);
		$banners = 	$this->database->loadObjectList();
		return $banners;
    }
    public function getBanner() {
    	$query = 'SELECT * FROM banner where id = '.$_GET['id'];
		$this->database->query($query);
		$c	 = 	$this->database->loadObjectList();
		$banner = $c[0];
    	$_SESSION['bannerId'] 					=	$banner->id; 
    	$_SESSION['bannerName'] 			=	$banner->name; 
    	$_SESSION['bannerDescription'] 	=	$banner->description; 
    	$_SESSION['bannerImage'] 			=	$banner->image; 
    }
    public function reset() {
		$_SESSION['bannerId'] 					=	''; 
    	$_SESSION['bannerName'] 			=	''; 
    	$_SESSION['bannerDescription'] 	=	''; 
    	$_SESSION['bannerImage'] 			=	'';	
    	$_SESSION['mode']						=	'';
    }
    public function validateBanner() 	{
    	$status	=	array();
    	$error	= false;
		if($_SESSION['mode']	== 'editBanner'	)
				$_SESSION['bannerId']				=	$_GET->id;
				 
    	$_SESSION['bannerName'] 				=	$_POST['bannername']; 
    	$_SESSION['bannerDescription'] 		=	$_POST['bannerdescription']; 
  		
   		$_SESSION['bannerImage'] 				=	isset($_POST['image'])	?	$_POST['image']	:	$_SESSION['bannerImage']; 
  		
   		$upload		=	new file_load;
   		$image 		=	$upload->upload_file(5000,0);
   		
   		unset($_SESSION['uploadedImage']);
   		if($image['ok']	===	 true)	{
   			$_SESSION['uploadedImage'] =	$image['file'];
   		}
   		else	{  			// error ...
   			$error 	= true;
    		$status['msg'][]	=	$image['msg'];
    		$status['field'][]	=	"image";
   		}
  		
    	if($error	== false ) $this->saveBanner();
		else   		$_SESSION['msg']		=	$status['msg'];	
    }
    public function saveBanner() 	{
    	$status			=		array();
    	$name 			=		$this->database->getQuotedString($_POST['bannername']);
    	$description 	=		$this->database->getQuotedString($_POST['bannerdescription']);
    	$image		=	"";
	   	if($_SESSION['mode']	== 'editBanner'	)	{
			if(isset($_SESSION['uploadedImage']))	{
				$tempImage 		=	$_SESSION['uploadedImage'];	
				$temp 				= 	explode(".", $tempImage);
				$extension 		= 	end($temp);
				$image				=	$_POST['bannername'].'.' .$extension	;
			}
			elseif(isset($_SESSION['bannerImage'])) 	{
				$tempImage		=	"";
				$image				=	$_SESSION['bannerImage'];
			}
			else 		$image	=	'placeholder.jpg';
 
			$DB_Image		=	$this->database->getQuotedString($image);
    	    	
			$sql 	=	 'UPDATE banner SET name = '.$name.', description = '.$description.', image = '.$DB_Image.
				' WHERE id = '.$_GET['id'];
    	}
    	else 	{			
    		/* new record
    		 * 
    		 * first check for refresh/back btn etc.
    		 */
    		$sql = 'Select * FROM banner WHERE name = '.$name.' AND description = '.$description; 
		
    		$this->database->query($sql);
			$result = $this->database->loadObjectList();
			
			if(count($result)	== 0) {
				if(isset($_SESSION['uploadedImage']))	{
					$tempImage 		=	$_SESSION['uploadedImage'];	
					$temp 				= 	explode(".", $tempImage);
					$extension 		= 	end($temp);
					$image 				=	$_POST['bannername'] .'.'.$extension	;
				}
				else 		$image	=	'placeholder.jpg';
				$DB_Image		=	$this->database->getQuotedString($image);
				
				$sql = 'INSERT INTO banner(name, description, image )
					VALUES ('.$name.','.$description.', '.$DB_Image.')';
			}
    	}
    		echo $sql;
	
    	$this->database->query($sql);
    	
    		/* 
    		 * get last insert record Id for Image name	
    		 */
			if(($_SESSION['mode'] != 'editBanner'))	{
				$status['msg'][]	=	'Banner '.$name. ' has been created.';
			}
			else {
				$status['msg'][] 	=	'Banner'.$name.' has been updated';
			}
        	if(isset($_SESSION['uploadedImage']))		{
/*		    	if (file_exists("../upload/" . $image)) {
					unlink("../upload/" .$image);								// delete file if exists - dont need this ??? causing lost images ???
				}
*/
				rename($tempImage,$image);				//  rename the image
    		}
			$this->reset();
    $_SESSION['msg']	 = $status['msg'];
    }
	public function deleteBanner() {
		$status = array();
		$sql = 'DELETE from banner WHERE id = '. $_POST['delete'];
	   	$this->database->query($sql);
		$status['msg'][] = 'Banner'. $_SESSION['bannerTitle']. ' was deleted';
		$_SESSION['msg']	= $status['msg'];
		$this->reset(); 
	}
}
