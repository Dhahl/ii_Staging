<?php
define('DACCESS',1);
include 'includes/defines.php';
include 'libraries/Database.php';
//var_dump(dirname(__FILE__));
//var_dump($_SERVER);
//echo dirname($_SERVER['PHP_SELF']).'<br>';
//die;
$db = new Database;
//var_dump($db);
//$sql = 'SELECT * FROM nielsen_codelists';
//$db->query($sql);
//$codelist	=	$db->loadObjectList();
//var_dump($codelist);
//$file = '/120350_46840_00_20151102_00.add.xml';

//$file 		= '/122370_47174_00_20160105_00.add.xml';
//$imgFolder	= '122370_47174_00_20160105_00.img';
$file = '/'.$_GET['file'];
$fileParsed = explode('_',$file);
$imgFolder = $fileParsed[0].'_'.$fileParsed[1].'_'.$fileParsed[2].'_'.$fileParsed[3].'_'.substr($fileParsed[4],0,2).'.img';
echo '<div class="col-md-12" style="position:fixed; z-index:1; background-color:white; top:0px; border:0px; margin:0px;">';
echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";
echo "Images folder: ". dirname(__FILE__).$imgFolder;
echo '</div>';
echo '<div class="col-md-12" style="height:100px; "></div>';
$BIC_Category_map = array('A'=>'Art','B'=>'Biography','C'=>'Language','D'=>'Literature','F'=>'Fiction',
						'H'=>'Humanities','J'=>'Society','K'=>'Business', 'L'=>'Law','M'=>'Medicine',
						'P'=>'Science','R'=>'Earth Sciences',
						'U'=>'Technology','V'=>'Lifestyle', 'W'=>'Lifestyle','Y'=>'Children');
foreach ($BIC_Category_map as $code=>$name){
	$sql = 'select * from categories where Name = "'. $name.'"';
	$db->query($sql);
	$category  = $db->loadobject();
	$categoryids[$code] =   $category->id;
}
//var_dump($categoryids);

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
	$title=  $productTitle;

	echo '<br>***<br><li><b>Title: <em>' . $productTitle.'</em></b> ISBN13: '.$isbn13;
	
	if($bookFound) {
		echo ' (existing book) '.$book[0]->id;
		$booksFound++;
	}
	else {
		echo ' (new book)';
		$booksNotFound++;
	}
	echo '<br>';
	if($productSubtitle) {
		echo '<b>Subtitle = </b>'.$productSubtitle.'<br>';
		$title .= ':'.$productSubtitle;
	}
	
	$editionStatement = $product->EditionStatement; // Nielsen
	if($editionStatement) {
		echo '<b>Edition Statement = </b>'.$editionStatement.'<br>';
		$title .= '<br>'.$editionStatement;
	}
	$title= $db->getQuotedString($title);
	/* Authors ("->Contributor") */
	
	$authorIDs = array(); // will contain the IDs of book's authors
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
			$authorIDs[$db->getLastId()] = $contributors->SequenceNumber;
			echo 'created with ID:'.$db->getLastId().' SequenceNo.: .'.$contributors->SequenceNumber.'<br>';
		}
		else {
			$authorsFound++;
			$authorIDs[$authors[0]->id] = $contributors->SequenceNumber;
			echo ' Id: '. $authors[0]->id.'<br>';
		}
	}
	
	/* Genre, Category ID */
	$BICCode = $product->BICMainSubject ;
	$cat1 = substr($BICCode,0,1);
	$categoryName = $BIC_Category_map[$cat1];
	$categoryID = $categoryids[$cat1];
	echo '<b>Category = </b>'.$categoryName.' ('.$categoryID.')';
	
	/* Languages */
	$languages = '';
	$languagesArr = array();
	foreach($product->Language as $language) {
		$languageCode = $language->LanguageCode;
		if($languageCode){
			$sql = 'select * from nielsen_codelists where List_No = 74 and Code  = "'.$languageCode.'"';
			$db->query($sql);
			$code = $db->loadObjectList();
			$languageCodeText = $code[0]->Definition;
	
			$languages .= $languageCodeText. ' ';
			$languagesArr[] = $languageCodeText;
		}
	}
	if ($product->Language) echo '<br><b>Languages: </b>'. $languages;
	
	/* Measurements */
	$measurementsArr = array();
	if($product->Measure) {
		foreach($product->Measure as $key=>$measures) {
			$_measurementsArr = array();
			foreach($measures as $_key=>$measure) {
				$_measurementsArr[$_key] = (string)$measure;
			}
			$measurementsArr[] = $_measurementsArr;
		}
		echo '<br><b> Measurements: </b>';
		foreach($measurementsArr as $key=>$measurements) {
			echo '<';
			foreach($measurements as $key=>$value){
				echo $value.'-';
			}
			echo'>';
		}
	}
	$pages=0;
	if($product->NumberOfPages) { 
		echo '<br><b>Number of Pages: </b>';
		$pages= $product->NumberOfPages;
		echo $pages;
	}
	if($product->IllustrationsNote) { 
		echo '<br><b>Illustrations Note: </b>';
		$illustrationsNote= $product->IllustrationsNote;
		echo $illustrationsNote;
	}
	
	/* Book "Tags"	("DescriptiveDetail->Subject")	 */
	$subjectArr = array();
	foreach($product->Subject as $key=>$subject) {		
		$subjectArr[] = $subject->SubjectHeadingText;
	}
	$tags = '';
	foreach($subjectArr as $key=>$_subject) {
		$tags .= $_subject . '; ';
	}
	echo '<br><b>Tags: </b>'.$tags;
			
	if($product->AudienceCode) {
		echo '<br><b>Audience Code: </b>';
		$audienceCode = $product->AudienceCode;
		$sql = 'select * from nielsen_codelists where List_No = 28 and Code  = "'.$audienceCode.'"';
		$db->query($sql);
		$code = $db->loadObjectList();
		$audienceCodeText = $code[0]->Definition;
	
		echo $audienceCode . ' - '.$audienceCodeText;
	}
	if($product->audienceDescription) {
		echo '<br><b>Audience Description:</b>';
		$audienceDescription= $product->AudienceDescription;
		echo $audienceDescription;
	}	
	/*  Text / Synopsis ("Collateral Detail->TextContent") */
	$contentArr = array();
	$synopsis = '';
	foreach($product->OtherText as $key=>$content) {
		//$synopsis .= (string) str_replace('"','',$content->Text).'<br>';
		$synopsis .= (string) $content->Text.'<br>';
		$_contentArr = array();
		foreach($content as $_key=>$_value) {
			$_contentArr[$_key] = (string) $_value;
		}
		$contentArr[] = $_contentArr;

	}
	if(!$synopsis == '') echo "<br><b>Synopsis:</b>".$synopsis;
	$synopsis = $db->getQuotedString($synopsis);
/*	foreach($contentArr as $key=>$content) {
		foreach($content as $_key=>$_value) {
			echo '<b>'.$_key.': </b>'.(string) $_value.'; ';
		}
		echo'<br><br>';
	}*/
	
	/* Images - Book & Author ("Collateral Detail->SupportingResources")   	 */
	$resourceArr = array();
	$image = '';
	foreach($product->MediaFile as $key=>$resources) {
		if($resources->MediaFileTypeCode = '04') $image = $resources->MediaFileLink;
		$_resourceArr = array();
		foreach($resources as $_key=>$resource) {
			if(count($resource->children()) == 0) $_resourceArr[$_key] = (string) $resource;
			else {
				foreach($resource as $_key=>$value) {
					if(count($value->children()) == 0) $_resourceArr[$_key] = (string) $value;
				}
			}
		}
		$resourceArr[] = $_resourceArr;
	}
	foreach($resourceArr as $i=>$values) {
		foreach($values as $key=>$value) {
		//	echo ' <b>'.$key . '</b> = ' . $value;
		}
		echo '<br><img src=".'.$imgFolder . '/' . $values['MediaFileLink'].'" style="height:100px;">';
		echo dirname(__FILE__).$imgFolder . '/' . $values['MediaFileLink'];
		echo'<br>';
	}
/*	echo '<br><b>Imprint:</b>';
	$imprintArr = array();
	foreach($product->Imprint as $key=>$imprint) {
		$_imprintArr = array();
		foreach($imprint as $_key=	>$imprintDetail) {
			if(count($imprintDetail->children()) == 0) $_imprintArr[$_key] = (string)$imprintDetail;
		}
	}
	$imprintArr = $_imprintArr;
	var_dump($imprintArr);
	*/
	/* Publishers	*/
	$publishersArr = array();
	foreach($product->Publisher as $key=>$publishers) {
		$_publishersArr = array();
		foreach($publishers as $_key=>$publisherDetail) {
			if(count($publisherDetail->children()) == 0) $_publishersArr[$_key] = (string)$publisherDetail;
		}
	}
	$publishersArr[] = $_publishersArr;
/*	echo '<h3>Publisher(s)</h3>';
	foreach($publishersArr as $key=>$publisher) {
		foreach($publisher as $_key=>$value) {
			if(!is_array($value)) echo '<b>'.$_key.'</b>' . ' = ' . (string)$value .'; ';
			else {
				foreach($value as $__key=>$_value) {
					foreach($_value as $___key=>$__value)
						foreach($__value as $____key=>$___value) {
							echo '<b>'.$____key . '</b>: '.$___value . '; ';
						}
				}
			}
		}
		echo '<br>';
	} */
	$publisherName = $publishersArr[0]['PublisherName'];
	echo '<br><b>Publisher Name:</b> '. $publisherName;	
	// Lookup publisher / ** create if not found. **
	$sql = 'select * from publishers where name = "'.$publisherName.'"';
	$db->query($sql);
	$publisherArr = $db->loadObject();
	//var_dump($publisherArr);
	if($publisherArr) $publisher_url = $publisherArr->url;
		else $publisher_url = '';
	

/*	echo '<br><b>Country Of Publication: </b>';
	$publishedCountry= $product->CountryOfPublication;
	echo $publishedCountry;
	
	echo '<br><b>Publishing Status:</b>';
	$publishingStatus= $product->PublishingStatus;
	echo $publishingStatus;
	*/
	echo '<br><b>Publication Date:</b>';
//	$publicationDate= $product->PublicationDate;

//	echo $product->PublicationDate;
	$pubDate1 = date_parse($product->PublicationDate.'0101');
//	var_dump($pubDate1);
	$pubDate = $pubDate1['year'].'-'.$pubDate1['month'].'-'.$pubDate1['day'];
//	var_dump($pubDate);
	$publicationDate = $pubDate;
	echo $publicationDate;
	
	/* Product Form */
	$audio =  false;
	$hardback = false;
	$paperback =  false;
	$ebook = false;
	
	$productForm = (string) $product->ProductForm; //Nielsen
	if(substr($productForm,0,1) == 'A') $audio = true;
	elseif($productForm == 'BB') $hardback = true;
	elseif($productForm == 'BC') $paperback = true;
	elseif($productForm == 'DG') $ebook = true;
	
	/* create Book */
	$sql = 'select * from nielsen_codelists where List_No = 7 and Code  = "'.$productForm.'"';
	$db->query($sql);
	$code = $db->loadObjectList();
	$productFormText = $code[0]->Definition;
	echo '<br><b> Form: </b>'. $productForm.' - '.$productFormText .'<br>';

	$lastupdated = date('Ymd');
	if ($bookFound == false ) {	/* create Book */
		$sql = 'insert into publications 
			(title, publisher, publisherurl, genre, categoryid, area, synopsis, lastupdated, published, image, hardback,
			paperback, ebook, audio, pages, isbn13, language, user_id )
			values ("'.$title.'","'.$publisherName.'","'.$publisher_url.'","'.$categoryName.'","'.$categoryID.'","'.$tags.'","'.$synopsis.'","'.$lastupdated.'","'.$publicationDate.
			'","'.$image.'","'.$hardback.'","'.$paperback.'","'.$ebook.'","'.$audio.'","'.$pages.'","'.$isbn13.'","'.$languages.'",999999)';
//		echo $sql;
		$db->query($sql);
		$bookid = $db->getLastId(); 
		foreach($authorIDs as $authorid=>$sequence) {
			$sql = 'insert into author_x_book
				(authorid, bookid, sequence)
				values ('.$authorid.','.$bookid.','.$sequence.')';
			$db->query($sql);
		}
		echo 'Book Created with ID: '.$bookid;
		if((!$image == '') && (file_exists(dirname(__FILE__). $imgFolder. '/'. $image) )) {
			$image_parse = explode('.',$image);
			$extension = end($image_parse);
			$image_src_location = dirname(__FILE__). $imgFolder. '/'. $image;
			$image_dest_location = 'upload/'. $bookid.'.'.$extension	;
			$copied = copy($image_src_location,$image_dest_location);
			echo '<br><b>Image:</b>' .$image_src_location;

			/* update the book with the image name*/
			$sql = 'update publications set image = "'.$bookid.'.'.$extension.'" where id = '. $bookid ;
			$db->query($sql);
		}
	}	
	
}

echo '<br>********************<h2>Summary</h2>'.'Total Books: '.$totalBooks.' - ';
echo $booksNotFound. ' New, ';
echo $booksFound.' Existing<br>';
echo 'Authors Found: '.$authorsFound.'<br>';
echo 'Authors not Found: '.$authorsNotFound.'<br>';
