<?php
$file = '/test1.xml';
$file = '/122370_47174_00_20160105_00.add.xml';
echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";
$xml = file_get_contents(dirname(__FILE__).$file);
//$xml = trim($xm,'﻿');
$divider = '<br>*************************************************************<br>';

echo $divider. '<br>JUST THE PRODUCT TAGS '.$divider;
$xmlArray = xml2Array($xml);
//print_r($xmlArray);
//var_dump($xmlArray);
foreach($xmlArray['Product'] as $k=>$v) {
	echo $k;
	var_dump($v);
}
//die;
//parseArray($xmlArray);
//var_dump($xmlArray);

echo $divider. '<br>Parse Array '.$divider;
foreach($xmlArray["Product"] as $i=>$keys) {
	parseArray($keys);
}
function parseArray($arr) {
	if(is_array($arr)) {
		echo "is Array<br>";
		foreach($arr as $k=>$v) {
			echo '['.$k.']';
			var_dump($v);
			if(is_array($v)) {
				foreach($v as $_k=>$_v) {
					parseArray($_v);
				}
			}
			else {
				echo ' *** VALUE *** : '.$v.'<br>';
			}
		}
	}
	else
		echo ' Value: '.$arr.'<br>';

}


echo $divider. '<br>Extract Keys '.$divider;
foreach($xmlArray["Product"] as $i=>$keys) {
	extractProductKeys($keys);
}

function extractProductKeys($xml,$path = '') {
	var_dump($path);
	if(is_array($xml)) {
		foreach($xml as $k=>$v) {
		//	echo $k.'<br>';
			$path .= $k; 
//			echo 'Path ...'.$path;
			if(is_array($v)) {
				foreach($v as $_k=>$_v) {
					extractProductKeys($v[$_k], $path);
				//	$path = '';
				}
			}
			else { 
				$path = ''; }
		}
	}
	if(!is_array($xml)) {
		echo 'Path = '.$path.'='.$xml.'<br>';
		$path = '';
		echo "path = ".$path.'!!!';
		//var_dump($v);
	}
}

//print_r($xmlArray);
var_dump($xmlArray);
function xml2array($fname){
	$sxi = new SimpleXmlIterator($fname, null, false);
	return sxiToArray($sxi);
}

function sxiToArray($sxi){
	$a = array();
	for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
		if(!array_key_exists($sxi->key(), $a)){
			$a[$sxi->key()] = array();
		}
		if($sxi->hasChildren()){
			$a[$sxi->key()][] = sxiToArray($sxi->current());
		}
		else{
			$a[$sxi->key()][] = strval($sxi->current());
		}
	}
	return $a;
}

