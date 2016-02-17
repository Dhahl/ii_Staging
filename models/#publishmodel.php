
<?php
"WWWWWWWWWW";
echo "WWWWWWWWWW";
defined('DACCESS') or die ('access denied');
class Publishmodel extends Model {
 
    function __construct() {
        parent::__construct();
    }
    
    function validInput()	{
    	
		$_SESSION['title']		=	$_POST['title'];
		$_SESSION['genre']		=	$_POST['genre'];
		$_SESSION['author']		=	$_POST['author'];
		$_SESSION['publisher'] 	= 	$_POST['publisher'];
		$_SESSION['area']		=	$_POST['area'];
		$_SESSION['published']	= 	$_POST['published'];
		$_SESSION['synopsis']	=	$_POST['synopsis'];

	   	$err	=	array();
    	$ok		=	true;
    	
    	$title		=	"'".$_POST['title']."'";
    	if($title == "")	{
    		$ok				=	false;
    		$err[$msg[]]	=	"Please enter a Title";
    		$err[$field[]]	=	"title";
    	}
    	return $ok;
		$genre		=	"'".$_POST['genre']."'";
		$author		=	"'".$_POST['author']."'";
		$publisher 	= 	"'".$_POST['publisher']."'";
		$area		=	"'".$_POST['area']."'";
		$published	= 	"'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['published'])))."'";
		$synopsis	=	"'".$_POST['synopsis']."'";

		$this->upload_file();

		if(isset($_SESSION['image']))	{
			$image 		=	"'".$_SESSION['image']."'";	
		}
		else 	{	
			$image		=	"''";	
		}
		
		$_SESSION['$err']	=	$err;
    }
    
    function getTitles() {

		$rtn = $this->listTitles();
		return $rtn;
	}
	
	function save()	{
//		var_dump($_SESSION);
		$title		=	"'".$_POST['title']."'";
		$genre		=	"'".$_POST['genre']."'";
		$author		=	"'".$_POST['author']."'";
		$publisher 	= 	"'".$_POST['publisher']."'";
		$area		=	"'".$_POST['area']."'";
		$published	= 	"'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['published'])))."'";
		$synopsis	=	"'".$_POST['synopsis']."'";
		if(isset($_SESSION['image']))	{
			$image 		=	"'".$_SESSION['image']."'";	
		}
		else 		$image		=	"''";
//		var_dump($published);
//		var_dump($_POST);
		
		$query 	= 	'INSERT INTO publications (title, genre, author, publisher, area, synopsis, published, image)
					VALUES ('.$title.','.$genre.','.$author.','.$publisher.','.$area.','.$synopsis.','.$published.','.$image.')';
					
//		var_dump($query);
		$result = mysql_query($query, $this->db);
		if (!$result) { echo mysql_error(); }
		echo "Record added";
		session_unset();
//		var_dump($_SESSION);
	}
	 
	function upload_file()	{
	unset($_SESSION['image']);
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["image"]["name"]);
	$extension = end($temp);

	if ((($_FILES["image"]["type"] == "image/gif")
		|| ($_FILES["image"]["type"] == "image/jpeg")
		|| ($_FILES["image"]["type"] == "image/jpg")
		|| ($_FILES["image"]["type"] == "image/pjpeg")
		|| ($_FILES["image"]["type"] == "image/x-png")
		|| ($_FILES["image"]["type"] == "image/png"))
		&& ($_FILES["image"]["size"] < 20000)
		&& in_array($extension, $allowedExts)) {
  		if ($_FILES["image"]["error"] > 0) {
		    //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		    $rtn	=	"Return Code: " . $_FILES["file"]["error"] . "<br>";
  		} 
  		else {
		    if (file_exists("upload/" . $_FILES["image"]["name"])) {
		      // echo $_FILES["image"]["name"] . " already exists. Please Rename it or choose a different file";
		      unlink("upload/" .$_FILES["image"]["name"]);	//replace file
     		  move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);
			  $rtn	= "Stored in: " . "upload/" . $_FILES["image"]["name"];
			      
   			  $_SESSION['image'] =	"upload/".$_FILES["image"]["name"];
   				//die;
   			}
  		}
	} 
	else {
		 $rtn =	"Invalid file<br>";
		 $rtn .= $_FILES["image"]["type"];
		 $rtn .= $_FILES["image"]["size"];
		 //die;
		}
	return $rtn;
	}
	
	function listTitles()	{
		
		$sql = "SELECT * FROM publications WHERE publisher = '".$_SESSION['user']."' ORDER BY lastupdated DESC";
//		var_dump($sql);
        $this->database->query($sql);
        $rtn =	$this->database->loadObjectList();
 //       var_dump($rtn);
        return $rtn;
//        return $this->database->loadObjectList();
		
	}
}