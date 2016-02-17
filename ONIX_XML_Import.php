<?php
$file = '/test.xml';
$file = '/122370_47174_00_20160105_00.add.xml';
echo (dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";

$xm = file_get_contents(dirname(__FILE__).$file);
$xm = trim($xm,'﻿');
$xml = new SimpleXMLIterator($xm);

$divider = '<br>*************************************************************<br>';

echo $divider.'Header->Sender->SenderName <br>';
echo $xml->Header->Sender->SenderName .'<br>';

echo $divider . 'Product[0]->RecordReference <br>';
echo $xml->Product[0]->RecordReference .'<br>';

echo $divider.'Product Parts & components<br>'.$divider;
foreach ($xml->Product as $product=>$parts) {
	xmlParse($product,$parts);
}
//die;
function xmlParse($_key,$_xml) {
	//echo $_key;
	//echo ' = '.$_xml;
	//echo ' ('.$_xml->count().')<br>';
	//var_dump($_xml);
	if($_xml->count() > 0) {
		foreach($_xml->children() as $key=>$value) {
			//var_dump($key);
			//var_dump($value);
			//die;
			if($value->count() > 0) {
				echo $key .'('.$value->count().')<br>';
				foreach($value as $_key=>$_value) {
					xmlParse($_key,$_value);
				}
			}
			else echo '[ROOT VALUE]'. $key.' = '.$value.'<br>';
		}
	}
	else {
		echo '[[ROOT VALUE]]'.$_key.' = '.$_xml.'<br>';
	}
}
	
	//echo ord($xml->hasChildren());// ? ' (has children)' : ' (No Children)';
	
	//echo is_object($parts) ? ' (is Object)' : ' (Not Object)';
	foreach($parts as $productPartKey=>$productPart) {
		echo '<br>>'.$productPartKey.' = '.$productPart;
		//echo ' has Children?';
		//echo $productPart->hasChildren() ? ' = Yes.' : ' = No.';
		//var_dump($productPart->hasChildren());
		//echo '<br> Is XML Itreator?';
		//echo is_a($productPart, 'SimpleXMLIterator').'<br>';
		//echo '   is Object?  ';
		//echo is_object($productPart) ? ' = Yes. ' : ' = No.';
		foreach($productPart as $partKey=>$partValue) {
			echo '<br>>>'.$partKey.' = '.$partValue;
			//echo '<br>'.$partValue->hasChildren() ? ' (bottom)' : ' (parent)';
			foreach($partValue as $subPartKey=>$subPartValue) {
				echo '<br>>>>'.$subPartKey.' = '.$subPartValue;
				//echo'<br>'.$subPartValue->hasChildren() ? ' (bottom)' : ' (parent)';
				//echo '<br>'. $subPartKey .' = '.$subPartValue.'<br>';
			}
			//echo '<br>';
		}
		//var_dump($productPart);
	}
	//var_dump($parts);
echo $divider.'Contributors<'.$divider;
	foreach($xml->Product->DescriptiveDetail as $descriptive ) {
		foreach($descriptive->Contributor as $contributor) {
			echo $contributor->KeyNames.'<br>';
		}
	}

echo $divider.'DUMP Product->DescriptiveDetail->Measure[0]->MeasureType<br>';

var_dump($xml->Product->DescriptiveDetail->Measure[0]->MeasureType);// .'<br>';

echo $divider.'All Components'.$divider;
foreach($xml as $k=>$v){
	if($xml->hasChildren()){
	$keys = parseXMLObject($k,$v);
	}
}
//var_dump($keys);
echo $divider.'end'.$divider;
var_dump($keys);
parseArray($keys);
//die("3");

function parseArray($arr) {
	foreach($arr as $k=>$v) {
		if(is_array($v))  {
			echo '+'.$k;
			parseArray($v) ;
		}
		else 
			echo $k.$v.'.';
	}
}
function parseXMLObject($key1, $obj,$indent ='', $key2='', $keyArray=array()){
//		$indent .= '.';
		$keyArray1 = $keyArray;
		$path = $key2.'['.(string)$key1.']';
		echo $path ." (entry) - $-PATH<br>";
	//	var_dump($obj);
	if(is_string((string)$obj) ) {
		$keyArray[$path] = $obj;
		var_dump($keyArray);
	//	die("1");
	}
	else {
		//$keyArray1= $keyArray;
		foreach($obj as $key=>$value){
			echo 'recursing with... '. $indent. $path.'['.(string)$key.'] = '.(string)$value . '<br>';
		//echo '++'.$key;
	//	var_dump($keyArray);
		$keyArray1[$path] = parseXMLObject($key,$value,$indent,$path,$keyArray);
		var_dump($keyArray1);
		//die("2");

		}
	}
//	var_dump($keyArray);
//	die("2A");
	return $keyArray1;
}
//die;
echo (string) $xml;
$xmlIterator = new SimpleXMLIterator($xml);
//var_dump($xmlIterator);
$xmlIterator->rewind();
//$el	= $xmlIterator->current();
//var_dump($el);
//die;

//foreach($el as )
while($xmlIterator->current()) {
	$el	= $xmlIterator->current();
//	var_dump($el);
	foreach($el as $key=>$value) {
		if($el->hasChildren()) {
			echo '+'.$key .'= <br>';
			$keys = array(parseXMLObject($key, $value));
		}
		else echo '.'.$key.' = '.(string)$value . '<br>';
	}
	$xmlIterator->next();
//die;
}
$sxe = new SimpleXMLElement($xml);

echo $sxe->getName() . "\n";

foreach ($sxe->children() as $child)
{
	echo $child->getName() . "\n";
}
var_dump($xml);
//echo $xml->book[0]->title . "<br>";
//echo $xml->book[1]->title;
?>