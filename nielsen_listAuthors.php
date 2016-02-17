<?php
define('DACCESS',1);
include 'includes/defines.php';
include 'libraries/Database.php';
$db = new Database;
//var_dump($db);
//$sql = 'SELECT * FROM nielsen_codelists';
//$db->query($sql);
//$codelist	=	$db->loadObjectList();
//var_dump($codelist);
//$file = '/120350_46840_00_20151102_00.add.xml';

$file 		= '/122370_47174_00_20160105_00.add.xml';
$imgFolder	= '122370_47174_00_20160105_00.img';

echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";

$xml = file_get_contents(dirname(__FILE__).$file);
$xml = simplexml_load_string($xml);
$authorsFound = 0;
$authorsNotFound = 0;
$totalBooks = 0;$booksFound=0; $booksNotFound=0;

foreach($xml->Product as $key=>$product) {		// ***** start Product (Book) Loop
	$totalBooks++;
	
	$isbn13 = $product->RecordReference;
	$bookFound=false;
	$sql = 'select * from publications where isbn13 = "'.$isbn13.'"';
	$db->query($sql);
	$book = $db->loadObjectList();
	if(count($book)) $bookFound = true;
	
	/* Title ("Title->TitleText")*/
	$productTitle = $product->Title->TitleText; // Nielsen
	$productSubtitle = $product->Title->Subtitle; // Nielsen

	echo '<h3> Title = ' . $productTitle.'</h3>';
	if($productSubtitle) echo '<b>Subtitle = </b>'.$productSubtitle.'<br>';
	
	if($bookFound) {
		echo 'EXISTS';
		$booksFound++;
	}
	else {
		echo 'New Book';
		$booksNotFound++;
	}
	echo '<br>';

	/* Authors ("->Contributor") */
	
	$authorIDs = array();
	foreach($product->Contributor as $key=>$contributors) {
		$contributorRoleCode=$contributors->ContributorRole;
		$sql = 'select * from nielsen_codelists where List_No = 17 and Code  = "'.$contributorRoleCode.'"';
		$db->query($sql);
		$code = $db->loadObjectList();
		$contributorRoleText = $code[0]->Definition;
		echo $contributorRoleText.' '.$contributors->NamesBeforeKey.' '.$contributors->KeyNames.'; ';
		// check if existing author name.
		$sql = 'select * from authors where 
				lastname = "'. $contributors->KeyNames . 
				'" and firstname = "'	. $contributors->NamesBeforeKey.'"';
		$db->query($sql);
		$authors= $db->loadObjectList();
		if (count($authors) == 0) {
			$authorsNotFound++;
			// Create the Author Record
			$sql = 'insert into authors (firstname, lastname, createdby) 
						values ("'.$contributors->NamesBeforeKey.'", "'.$contributors->KeyNames.'",9999999)';
			$db->query($sql);
			$authorIDs[] = $db->getLastId();
			echo 'created with ID:'.$db->getLastId().'<br>';
		}
		else {
			$authorsFound++;
			$authorIDs[] = $authors[0]->id;
			echo ' Id: '. $authors[0]->id.'<br>';
		}
	}
}

echo '<br>********************<h2>Summary</h2>'.'Total Books: '.$totalBooks.' - ';
echo $booksNotFound. ' New, ';
echo $booksFound.' Existing<br>';
echo 'Authors Found: '.$authorsFound.'<br>';
echo 'Authors not Found: '.$authorsNotFound.'<br>';
