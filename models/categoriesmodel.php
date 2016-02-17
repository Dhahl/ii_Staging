<?php
defined('DACCESS') or die ('access denied');


class Categoriesmodel extends Model {
     function __construct() {
        parent::__construct();
     }
        public function getCategories() {
     	$where =	'';
		$query = 'SELECT * FROM categories order by Name' ;
	
		$this->database->query($query);
		$categories = 	$this->database->loadObjectList();
		return $categories;
    }
    public function getCategory() {
    	$query = 'SELECT * FROM categories where id = '.$_GET['id'];
		$this->database->query($query);
		$c	 = 	$this->database->loadObjectList();
		$category = $c[0];
    	$_SESSION['categoryId'] 					=	$category->id; 
    	$_SESSION['categoryName'] 					=	$category->Name; 
    	$_SESSION['categoryDescription'] 		=	$category->Description; 
    }
    public function reset() {
		$_SESSION['categoryId'] 					=	''; 
    	$_SESSION['categoryName'] 					=	''; 
    	$_SESSION['categoryDescription'] 		=	''; 
    	$_SESSION['mode']						=	'';
    }
    public function validateCategory() 	{
    	$status	=	array();
    	$error	= false;
		if($_SESSION['mode']	== 'editCategory'	)
				$_SESSION['categoryId']				=	$_GET->id;
				 
    	$_SESSION['categoryName'] 				=	$_POST['categoryname']; 
    	$_SESSION['categoryDescription'] 		=	$_POST['categorydescription']; 
  		
   		if($error	== false ) $this->saveCategory();
		else   		$_SESSION['msg']		=	$status['msg'];	
    }
    public function saveCategory() 	{
    	$status			=		array();
    	$name 			=		$this->database->getQuotedString($_POST['categoryname']);
    	$description 	=		$this->database->getQuotedString($_POST['categorydescription']);
    	$image		=	"";
    	
    	if($_SESSION['mode']	== 'editCategory'	)	{
    		
    		$sql 	=	 'UPDATE categories SET name = '.$name.', description = '.$description.
			' WHERE id = '.$_GET['id'];
    	}
    	else 	{			
    		/* new record
    		 * 
    		 * first check for refresh/back btn etc.
    		 */
    	$sql = 'Select * FROM categories WHERE name = '.$name.' AND description = '.$description; 
		
    	$this->database->query($sql);
		$result = $this->database->loadObjectList();
		
		if(count($result)	== 0) {
    		$sql = 'INSERT INTO categories(name, description)
					VALUES ('.$name.','.$description.')';
		  }
    	}
	
    	$this->database->query($sql);
    	
    		/* 
    		 * get last insert record Id for Image name	
    		 */
			if(($_SESSION['mode'] != 'editCategory'))	{
				$status['msg'][]	=	'Category '.$name. ' has been created.';
			}
			else {
				$status['msg'][] 	=	'Category'.$name.' has been updated';
			}
    $this->reset();
    $_SESSION['msg']	 = $status['msg'];
    }
	public function deleteCategory() {
		$status = array();
		$sql = 'DELETE from categories WHERE id = '. $_POST['delete'];
	   	$this->database->query($sql);
		$status['msg'][] = 'Category '. $_SESSION['categoryTitle']. ' was deleted';
		$_SESSION['msg']	= $status['msg'];
		$this->reset(); 
	}
}