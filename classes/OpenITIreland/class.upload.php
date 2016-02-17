<?php

class file_load {
   function __construct() {

    }
     public function upload_file($maxSize =5000, $resize=300)	{
		$rtn			=	array();
		/******************************************************************************************** 		
		 * 		$rtn['ok'] 		true / false 
		 * 		$rtn['msg] 		error message if ok = false
		 * 		$rtn['file'] 		file name if ok = true
		 * 
		 * 		*NB* FORM that loads the file must have: enctype="multipart/form-data"
		 *  
		 *********************************************************************************************/
		$rtn['ok']	=	true;
		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG" );
		
		$temp = explode(".", $_FILES["image"]["name"]);
		if($_FILES['image']['name']	!=	'')	{
			$extension = end($temp);
			if ((($_FILES["image"]["type"] == "image/gif")
				|| ($_FILES["image"]["type"] == "image/jpeg")
				|| ($_FILES["image"]["type"] == "image/jpg")
				|| ($_FILES["image"]["type"] == "image/pjpeg")
				|| ($_FILES["image"]["type"] == "image/x-png")
				|| ($_FILES["image"]["type"] == "image/png"))
				&& ($_FILES["image"]["size"] < ($maxSize * 1024))
				&& in_array($extension, $allowedExts)) {
  				if ($_FILES["image"]["error"] > 0) {
				    $rtn['ok'] 		=	false;
				    $rtn['msg']		=	"File Upload Error - Return Code: " . $_FILES["file"]["error"] . "<br>";
  				}
 	 			else {
				    if (file_exists("upload/" . $_FILES["image"]["name"])) {
			    		unlink("upload/" .$_FILES["image"]["name"]);	// delete 
					}
					if($resize == 0)	{
						move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);
					}
					else {
						$this->resizeImage($extension,$resize);
					}
					//
					$rtn['file'] =	"upload/".$_FILES["image"]["name"];
				/*						
 					var_dump($rtn);
					die;*/
	 			}
			} 
			else {
				$rtn['ok']	=	false;
				if($_FILES["image"]["size"]	>	(5000 * 1024) )	{
					$rtn['msg'] =	"File ".$_FILES['image']['name']." is too big (".$_FILES["image"]["size"]." bytes). Maximum size allowed is ".$maxSize."Kb (".($maxSize * 1024)." bytes)";
				}
				else	{					
					$rtn['msg'] =	"Invalid Image file (" .$extension."). <p>Only files with extension of jpg, jpeg, png or gif, and that are valid Image files are allowed</p>" ;
				}
			}
		}
			return $rtn;
	}
function reSizeImage($extension,$resize) {

	$uploadedfile = $_FILES['image']['tmp_name'];

	if($extension=="jpg" || $extension=="jpeg" )
	{
		$src = imagecreatefromjpeg($uploadedfile);
	}
	else if($extension=="png")
	{
		$src = imagecreatefrompng($uploadedfile);
	}
	else 
	{
		$src = imagecreatefromgif($uploadedfile);
	}
 
list($width,$height)=getimagesize($uploadedfile);

$newwidth=60;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

$newwidth1=$resize;
$newheight1=floor(($height/$width)*$newwidth1);
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

$filename =  'upload/60_'.$_FILES['image']['name'];

$filename1 = "upload/". $_FILES['image']['name'];
//imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}

	}

?>