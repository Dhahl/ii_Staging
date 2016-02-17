<?php 
$file = '/test.xml';
echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";
$xml = file_get_contents(dirname(__FILE__).$file);
$xml = simplexml_load_string($xml);

foreach($xml->Product as $key=>$product) {		// ***** start Product (Book) Loop
	$xmlarray = array(); // this will hold the flattened data
	echo '<br><h2>*** Book ***</h2><br>';
 /* Get the ISBN13 Code for this Book.*/
 
	foreach($product->ProductIdentifier as $key=>$identifiers) {
 		XMLToArrayFlat($identifiers, $xmlarray, '', true);
		$identifiersArr[] = $xmlarray;
 	}
 	$isbn13 = ''; $isbn=''; $asin='';
 	foreach($identifiersArr as $i=>$id){
 		if($id['/ProductIdentifier/ProductIDType[1]'] == '15') $isbn13 = $id['/ProductIdentifier/IDValue[1]'];
 		elseif($id['/ProductIdentifier/ProductIDType[1]'] == '02') $isbn = $id['/ProductIdentifier/IDValue[1]']; // O'Brien only  ???
 		elseif($id['/ProductIdentifier/ProductIDType[1]'] == '03') $asin = $id['/ProductIdentifier/IDValue[1]']; // O'Brien only  ???
 		else echo 'Unrecognised ProductIDType: '.$id['/ProductIdentifier/ProductIDType[1]']. ' = '.$id['/ProductIdentifier/IDValue[1]'];
 	}
 	echo '<b>ISBN-13: </b>'.$isbn13.' <b>ISBN: </b>'.$isbn. ' <b>ASIN:</b> '.$asin;
 	$isbn13s[$isbn13] = '';
 	
 	/* Product Form ** Different Locations for Nielsen & O'Brien ***/
 	
 	$productForm = (string) $product->ProductForm; //Nielsen
	if($productForm == '') $productForm = $product->DescriptiveDetail->ProductForm; // O'Brien
 	echo '<b> Form = </b>'. $productForm;
 	
 	/* Product Composition - O'Brien only ??? */
 	$productComposition = $product->DescriptiveDetail->ProductComposition;
 	echo '<b> Composition = </b>'. $productComposition;
 	
 	/* Measurements */
 	$measurementsArr = array();
 	foreach($product->DescriptiveDetail->Measure as $key=>$measures) {
 		$_measurementsArr = array();
 		foreach($measures as $_key=>$measure) {
 			$_measurementsArr[$_key] = (string)$measure; 
 		}
 		$measurementsArr[] = $_measurementsArr; 
 	}
 	echo '<b> Measurements: </b>';
 	foreach($measurementsArr as $key=>$measurements) {
 		echo '<';
 		foreach($measurements as $key=>$value){
 			echo $value.'-';
 		}
 		echo'>';
 	}
 	/* Title ("Title->TitleText")*/
 	$productTitle = $product->Title->TitleText; // Nielsen
 	$productSubtitle = $product->Title->Subtitle; // Nielsen
 	
 	if($productTitle == '') $productTitle = $product->DescriptiveDetail->TitleDetail->TitleElement->TitleText; 		// O'Brien
 	if($productSubtitle == '') $productSubtitle = $product->DescriptiveDetail->TitleDetail->TitleElement->Subtitle; 	// O'Brien
 	echo '<b> Title = </b>' . $productTitle;
 	echo ' <b>Subtitle = </b>'.$productSubtitle;
 	
 	/* Authors ("DescriptiveDetail->Contributors") */
 	echo '<h3>Contributors</h3>';
 	$authorsArr = array();
 	foreach($product->DescriptiveDetail->Contributor as $key=>$contributors) {		// O'Brien
 		$_authorsArr = array();
 		foreach($contributors as $_key=>$contributorDetail) {
 			if(count($contributorDetail->children())	== 0 ) $_authorsArr[$_key] = (string) $contributorDetail;
 		}
 		foreach($contributors->NameIdentifier as $nameIdentifier=>$identifier) {
 			$authorIDs = array();
 			foreach($identifier as $_key=>$value){ 
 				$authorIDs[$_key] = (string) $value;
 			}
 			$_authorsArr[$nameIdentifier][] = $authorIDs; 
 		}
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
  	echo '<br><h3>Tags</h3>';
  	/* Book "Tags"	("DescriptiveDetail->Subject")	 */
  	$subjectArr = array();
  	foreach($product->DescriptiveDetail->Subject as $key=>$subject) {		// O'Brien
  		$subjectArr[] = $subject->SubjectHeadingText;
  	}
  	foreach($subjectArr as $key=>$_subject) {
  		echo $_subject . '--';
  	}
  	
  	echo '<br><h3>Descriptive Text</h3>';
  	/*  Text / Synopsis ("Collateral Detail->TextContent") */
  	$contentArr = array();
  	foreach($product->CollateralDetail->TextContent as $key=>$content) {
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
  	foreach($product->CollateralDetail->SupportingResource as $key=>$resources) {
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
  	echo '<h3>Resources</h3>';
  	foreach($resourceArr as $i=>$values) {
  		foreach($values as $key=>$value) {
	  		echo ' <b>'.$key . '</b> = ' . $value;
  		}
  		echo'<br>';
  	}
  	/* Publishers	*/
  	$publishersArr = array();
  	foreach($product->PublishingDetail as $key=>$publishers) {
  		$_publishersArr = array();
  		//var_dump($publishers);
  		foreach($publishers as $_key=>$publisherDetail) {
  			if(count($publisherDetail->children()) == 0) $_publishersArr[$_key] = (string)$publisherDetail;
  		}
/*  			else {
  				foreach($publisherDetail as $_key=>$detail) {
  					$_publishersArr[$_key] = (string)$detail; 
  				}
  			}*/
  			//die;
  			foreach($publishers->PublishingDate as $_key=>$publishingDate) {
  			//var_dump($publishingDate);
  				$_publishingDates = array();
  				foreach ($publishingDate as $__key=>$value) {
  					$_publishingDates[][$__key] = (string) $value;
  				}
  				$publishingDates[] = $_publishingDates;
  			}
  			//var_dump($publishingDates);
  			//die;
  			$_publishersArr[$_key] = $publishingDates;
  			//var_dump($_publishersArr);
  		}
  		$publishersArr[] = $_publishersArr;
  	//var_dump($publishersArr);
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
  				//var_dump($value);
  			}
  		}
  		echo '<br>';
  	}
	echo'<br>';
} 		//			***		Next Product	***

echo '<br>Books processed: '.count($isbn13s);
var_dump($products);
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