<?php
class nielsen_XML_Product {
	function __construct() {

	}
	function getByISBN13($db,$isbn13) {
		$sql = 'select * from publications where isbn13 = "'.$isbn13.'"';
		$db->query($sql);
		$this->book = $db->loadObject();
		if($this->book) return true;
		else return false;
	}
	function xmlToTitle ($product){
		$productTitle = $product->Title->TitleText; // Nielsen
		$productSubtitle = $product->Title->Subtitle; // Nielsen
		$editionStatement = $product->EditionStatement; // Nielsen
		$title	=  $productTitle;
		if($productSubtitle) 
			$title .= ': '.$productSubtitle;
		if($editionStatement) 
			$title .= '<br>'.$editionStatement;
		return $title;
	}
	function getAuthors ($db,$product) {
		$return=false;
		$this->authorCount				= 0;
		$this->authorsNotFound			= 0;
		$this->duplicate_authorNames	= 0;
		$this->authorsFound				= 0;
		
		foreach($product->Contributor as $key=>$contributor) {
			$contributorSequence = $contributor->SequenceNumber;
			$contributorRoleCode = $contributor->ContributorRole;
			$this->authorCount++;
			
			$sql = 'select * from nielsen_codelists where List_No = 17 and Code  = "'.$contributorRoleCode.'"';
			$db->query($sql);
			$code = $db->loadObject();
			$contributorRoleText = $code->Definition;
			$this->contributorRole[(string)$contributorSequence]= $contributorRoleText;

			// Search for existing author(s) by name.
			$sql = 'select * from authors where lastname = "'.$contributor->KeyNames.'" and firstname = "'.$contributor->NamesBeforeKey.'"';
			$db->query($sql);
			$authorsArr = $db->loadObjectList();
			if(count($authorsArr) > 1) $this->duplicate_authorNames++;
				
			$this->contributorSequence[(string)$contributorSequence] = $authorsArr;
			$this->contributorSequence[(string)$contributorSequence]['name'] = $contributor->KeyNames .', '.$contributor->NamesBeforeKey;
			$this->contributorSequence[(string)$contributorSequence]['firstName'] = (string)$contributor->NamesBeforeKey;
			$this->contributorSequence[(string)$contributorSequence]['lastName'] = (string)$contributor->KeyNames ;
//		echo 'author count = '.count($this->contributorSequence) .'<br>';
//		var_dump($this->contributorSequence);
			if (count($authorsArr) == 0) {
				$this->authorsNotFound++;
			}
			else { 
				$this->authorsFound++;
			}
			$return = true; /* at least one author provided in XML */
		}
	   return $return;
	}
	function formatAuthors () {		/* var_dump($this->contributorRole);var_dump($this->contributorSequence); */
		$authors = '';  
		foreach($this->contributorRole as $seq=>$role) {
			$name = $this->contributorSequence[$seq]['name'];
			$author =  $role.': '.$name;
			$count = count($this->contributorSequence[$seq]) -3; // no. of existing II authors matching this name
			if($count > 0) {
				$author = '<a href = "./?author='.$this->contributorSequence[$seq][0]->id.'"target="blank">'.$author.'</a>';
				if($count > 1) {
					$author .= '<span style="color:red"> ('.$count.')</span>';
				}
			}
			$author .= '<br>';
			$authors .= $author;
		}
		return $authors;
	}
	function createAuthors($db,$userId){ /*	var_dump($this->contributorRole); var_dump($this->contributorSequence); */
		$created = 0;
		$authorIDs = array(); /* for Author-Book xRef. */
		foreach($this->contributorRole as $seq=>$role) {
			if(!isset($this->contributorSequence[$seq][0])) {// no II author found for this name (when initially loaded)
				$id = $this->createAuthor(
					$this->contributorSequence[$seq]['firstName'],
					$this->contributorSequence[$seq]['lastName'],
					$db, $userId);
				$authorIDs[$seq] = $id;
//				$this->createAuthorXRef($db,$this->book->id, $id, $seq); /* author x-ref for author just created. */
				
				$sql = 'select * from authors where id = '. $id;
				$db->query($sql);
				$authorsArr = $db->loadObject();
				$this->contributorSequence[$seq][] = $authorsArr;	/* load author record for this "seq". (author duplicated/this book) */
				$created++;
			}
			else {		/*	Existing II Author	*/
				$authorIDs[$seq] = $this->contributorSequence[$seq][0]->id;
//				$this->createAuthorXRef($db,$this->book->id,$this->contributorSequence[$seq][0]->id,$seq);
			}
		}
		$this->authorIDs = $authorIDs;
		
		return $created;
	}
	function createAuthorXRef($db, $bookID,$authorID,$seq) {
			$sql = 'insert into author_x_book
				(authorid, bookid, sequence)
				values ('.$authorID.','.$bookID.','.$seq.')';
			$db->query($sql);
	}
	function createAuthor($firstName,$lastName,$db,$userId){
		// Create the Author Record. First check it hasnt just been created for this book.
		$sql = 'select * from authors where firstname = "'.$firstName.'" and lastname = "'.$lastName.'"';	
		$db->query($sql);
		$author = $db->loadObject();
		if ($author) {
			return $author->id;
		}
		else {
//			echo $userId.'<br>';
			$sql = 'insert into authors (firstname, lastname, createdby)
							values ("'.$firstName.'", "'.$lastName.'","'.$userId.'")';
			$db->query($sql);
			return $db->getLastId();
		}
	}
	function getImage($product) {
		$image = '';
		foreach($product->MediaFile as $key=>$resources) {
			if($resources->MediaFileTypeCode = '04') $image = $resources->MediaFileLink;
		}
		return $image;	
	}
	function getPublisher($product) {
		/* Publishers	*/
		$publishersArr = array();
		foreach($product->Publisher as $key=>$publishers) {
			$_publishersArr = array();
			foreach($publishers as $_key=>$publisherDetail) {
				if(count($publisherDetail->children()) == 0) $_publishersArr[$_key] = (string)$publisherDetail;
			}
		}
		$publishersArr[] = $_publishersArr;
		$publisherName = $publishersArr[0]['PublisherName'];
		return $publisherName;
	}
	function getTags($product) {
		/* Book "Tags"	("DescriptiveDetail->Subject")	 */
		$tags = '';
		foreach($product->Subject as $key=>$subject) {
				$tags .= $subject->SubjectHeadingText . '; ';
		}
		return $tags;
	}
	function getPages($product) {
		return $product->NumberOfPages ;
	}
	function getSynopsis ($product) {
		/*  Text / Synopsis ("Collateral Detail->TextContent") */
		$synopsis = '';
		foreach($product->OtherText as $key=>$content) {
			$synopsis .= (string) $content->Text.'<br>';
		}
		return $synopsis;
	}
	function checkPublisherExists($db,$publisherName){
		 // Lookup publisher / ** create if not found. **
		 $sql = 'select * from publishers where name = "'.$publisherName.'"';
		 $db->query($sql);
		 $publisherArr = $db->loadObject();
		 //var_dump($publisherArr);
		 if($publisherArr){
		 	$this->publisher_url = $publisherArr->url;
		 	$return = true;
		 }
		 else {  
		 	$this->publisher_url = '';
		 	$return = false;
		 }
		 return $return;
	}
	function createPublisher($db,$name) {
		$sql = 'insert into publishers (name) values("'.$name.'")';
		$db->query($sql);
	}
	function getPublishedDate($product) {
		$pubDate1 = date_parse($product->PublicationDate.'0101');
		$pubDate = $pubDate1['year'].'-'.$pubDate1['month'].'-'.$pubDate1['day'];
		return $pubDate;
	}
	function formatLanguages($db, $product) {
		/* Languages */
		$languages = '';
		foreach($product->Language as $language) {
			$languageCode = $language->LanguageCode;
			if($languageCode){
				$sql = 'select * from nielsen_codelists where List_No = 74 and Code  = "'.$languageCode.'"';
				$db->query($sql);
				$code = $db->loadObjectList();
				$languageCodeText = $code[0]->Definition;
		
				$languages .= $languageCodeText. ' ';
			}
		}
		return $languages;
	}
	function getProductForm ($product) {
		/* Product Form */
		$this->audio =  false;
		$this->hardback = false;
		$this->paperback =  false;
		$this->ebook = false;
		
		$productForm = (string) $product->ProductForm; //Nielsen
		if(substr($productForm,0,1) == 'A') $this->audio = true;
		elseif($productForm == 'BB') $this->hardback = true;
		elseif($productForm == 'BC') $this->paperback = true;
		elseif($productForm == 'DG') $this->ebook = true;
	}
	public function checkFeed($file) {
		$sql = 'select count(*) as rows, user_id from publications where user_id = "'.$file.'" group by user_id ';
		$this->database->query($sql);
		$res = $this->database->loadObject();
		if($res) return $res->rows;
	}
	
}