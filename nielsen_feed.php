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

foreach($xml->Product as $key=>$product) {		// ***** start Product (Book) Loop
	$xmlarray = array(); // this will hold the flattened data
	echo '<br><h2>*** Book ***</h2><br>';
	/* Get the ISBN13 Code for this Book.*/

	$notificationType = (string) $product->NotificationType; //
	echo '<b>Notification Type: </b>'.$notificationType.' - ';
	$sql = 'select * from nielsen_codelists where List_No = 1 and Code  = '.$notificationType;
	$db->query($sql);
	$code = $db->loadObjectList();
	$notificationText = $code[0]->Definition;
	echo $notificationText.'<br>';
	
	foreach($product->ProductIdentifier as $key=>$identifiers) {
		XMLToArrayFlat($identifiers, $xmlarray, '', true);
		$identifiersArr[] = $xmlarray;
	}
	$isbn13 = '[not found]'; $isbn='[not found]'; $asin='[not found]';
	foreach($identifiersArr as $i=>$id){
		if($id['/ProductIdentifier/ProductIDType[1]'] == '15') $isbn13 = $id['/ProductIdentifier/IDValue[1]'];
		elseif($id['/ProductIdentifier/ProductIDType[1]'] == '02') $isbn = $id['/ProductIdentifier/IDValue[1]']; // O'Brien only  ???
		elseif($id['/ProductIdentifier/ProductIDType[1]'] == '03') $asin = $id['/ProductIdentifier/IDValue[1]']; // O'Brien only  ???
		else echo 'Unrecognised ProductIDType: '.$id['/ProductIdentifier/ProductIDType[1]']. ' = '.$id['/ProductIdentifier/IDValue[1]'];
	}
	echo '<b>ISBN-13: </b>'.$isbn13.' <b>ISBN: </b>'.$isbn. ' <b>ASIN:</b> '.$asin;
	$isbn13s[$isbn13] = '';

	/* Product Form */

	$productForm = (string) $product->ProductForm; //Nielsen
	$sql = 'select * from nielsen_codelists where List_No = 7 and Code  = "'.$productForm.'"';
	$db->query($sql);
	$code = $db->loadObjectList();
	$productFormText = $code[0]->Definition;
	echo '<br><b> Form: </b>'. $productForm.' - '.$productFormText .'<br>';

	/* Product Composition */
	$productComposition ='[not found]';
	if($product->DescriptiveDetail->ProductComposition){
		$productComposition = $product->DescriptiveDetail->ProductComposition;
		echo '<br><b> Composition = </b>'. $productComposition;
	}

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
	else {
		echo "<br><b>No Measurements</b>";
	}
	echo'<br>';
	/* Title ("Title->TitleText")*/
	$productTitle = $product->Title->TitleText; // Nielsen
	$productSubtitle = $product->Title->Subtitle; // Nielsen

	echo '<b> Title = ' . $productTitle.'</b>';
	echo '<br> <b>Subtitle = </b>'.$productSubtitle;

	/* Authors ("DescriptiveDetail->Contributors") */
	echo '<h3>Contributors</h3>';
	$authorsArr = array();
	foreach($product->Contributor as $key=>$contributors) {		
		$_authorsArr = array();
		foreach($contributors as $_key=>$contributorDetail) {
			if(count($contributorDetail->children())	== 0 ) $_authorsArr[$_key] = (string) $contributorDetail;
		}
		$contributorRoleCode=$contributors->ContributorRole;
		$sql = 'select * from nielsen_codelists where List_No = 17 and Code  = "'.$contributorRoleCode.'"';
		$db->query($sql);
		$code = $db->loadObjectList();
		$contributorRoleText = $code[0]->Definition;
		$_authorsArr['Contributor Role Description'] = $contributorRoleText;
		$authorsArr[] = $_authorsArr;
	}
	foreach($authorsArr as $key=>$author) {
		foreach($author as $_key=>$authorDetail) {
			if(is_array($authorDetail)) {
				foreach($authorDetail as $__key=>$_value) {
					if(!is_array($_value)) echo $__key.': '.$_value. ';';
					else {
						echo '<br>';
						foreach ($_value as $__key=>$__value) {
							echo '<b>'.$__key .';</b> '.$__value;
						}
					}
				}
				echo '<br>*********************************<br>';
			}
			else
				echo '<b>'.$_key .'</b> = ' . $authorDetail.'; ';
		}
		echo '<br>';
	}

	echo '<br><b>Number of Pages: </b>';
	$pages= $product->NumberOfPages;
	echo $pages;
	
	echo '<br><b>Illustrations Note: </b>';
	$illustrationsNote= $product->IllustrationsNote;
	echo $illustrationsNote;
	
	echo '<br><b>Tags: </b>';
	/* Book "Tags"	("DescriptiveDetail->Subject")	 */
	$subjectArr = array();
	foreach($product->Subject as $key=>$subject) {		// O'Brien
		$subjectArr[] = $subject->SubjectHeadingText;
	}
	foreach($subjectArr as $key=>$_subject) {
		echo $_subject . '--';
	}
	echo '<br><b>Audience Code: </b>';
	$audienceCode = $product->AudienceCode;
	$sql = 'select * from nielsen_codelists where List_No = 28 and Code  = "'.$audienceCode.'"';
	$db->query($sql);
	$code = $db->loadObjectList();
	$audienceCodeText = $code[0]->Definition;
	
	echo $audienceCode . ' - '.$audienceCodeText;
	
	echo '<br><b>Audience Description:</b>';
 	$audienceDescription= $product->AudienceDescription;
 	echo $audienceDescription;
	
	//die; 
	echo '<br><b>Descriptive Text:</b>';
	/*  Text / Synopsis ("Collateral Detail->TextContent") */
	$contentArr = array();
	foreach($product->OtherText as $key=>$content) {
		$_contentArr = array();
		foreach($content as $_key=>$_value) {
			$_contentArr[$_key] = (string) $_value;
		}
		$contentArr[] = $_contentArr;
	}
	foreach($contentArr as $key=>$content) {
		foreach($content as $_key=>$_value) {
			echo '<b>'.$_key.': </b>'.(string) $_value.'; ';
		}
		echo'<br><br>';
	}
	 
	/* Images - Book & Author ("Collateral Detail->SupportingResources")   	 */
	$resourceArr = array();
	foreach($product->MediaFile as $key=>$resources) {
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
	echo '<br><b>Media: </b>';
	foreach($resourceArr as $i=>$values) {
		foreach($values as $key=>$value) {
			echo ' <b>'.$key . '</b> = ' . $value;
		}
		echo '<br><img src="'.$imgFolder . '/' . $values['MediaFileLink'].'" style="height:100px;">';
		echo'<br>';
	}
	echo '<br><b>Imprint:</b>';
	$imprintArr = array();
	foreach($product->Imprint as $key=>$imprint) {
		$_imprintArr = array();
		foreach($imprint as $_key=>$imprintDetail) {
			if(count($imprintDetail->children()) == 0) $_imprintArr[$_key] = (string)$imprintDetail;
		}
	}
	$imprintArr = $_imprintArr;
	var_dump($imprintArr);
	
	/* Publishers	*/
	$publishersArr = array();
	foreach($product->Publisher as $key=>$publishers) {
		$_publishersArr = array();
		foreach($publishers as $_key=>$publisherDetail) {
			if(count($publisherDetail->children()) == 0) $_publishersArr[$_key] = (string)$publisherDetail;
		}
	}
	$publishersArr[] = $_publishersArr;
	echo '<h3>Publisher(s)</h3>';
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
	}
	echo '<br><b>Country Of Publication: </b>';
	$publishedCountry= $product->CountryOfPublication;
	echo $publishedCountry;
	
	echo '<br><b>Publishing Status:</b>';
	$publishingStatus= $product->PublishingStatus;
	echo $publishingStatus;
	
	echo '<br><b>Publication Date:</b>';
	$publicationDate= $product->PublicationDate;
	echo $publicationDate;
	
	echo'<br>';

} 		//			***		Next Product	***

echo '<br>Books processed: '.count($isbn13s);
//var_dump($products);
die;
foreach($products as $product) {
	echo '<br>**** Product ****<br><br>';
	foreach($product as $key=>$value) {
		echo $key . ' = ' . $value. '<br>';
	}
}
//var_dump($xmlarray);


function XMLToArrayFlat($xml, &$return, $path='', $root=false)
{
	$children = array();
	if ($xml instanceof SimpleXMLElement) {
		$children = $xml->children();
		if ($root){ // we're at root
			$path .= '/'.$xml->getName();
		}
	}
	if ( count($children) == 0 ){
		$return[$path] = (string)$xml;
		return ;
	}
	$seen=array();
	foreach ($children as $child => $value) {
		$childname = ($child instanceof SimpleXMLElement)?$child->getName():$child;
		if ( !isset($seen[$childname])){
			$seen[$childname]=0;
		}
		$seen[$childname]++;
		$a = XMLToArrayFlat($value, $return, $path.'/'.$child.'['.$seen[$childname].']');
	}
}
?>