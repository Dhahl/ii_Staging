<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','5G');
$file = '/test1.xml';
echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";
$xml = file_get_contents(dirname(__FILE__).$file);
//$xml = trim($xm,'﻿');
$divider = '<br>*************************************************************<br>';

echo $divider. '<br>Store the XML in array... <br>';
$xmlArray = xml2Array($xml);
echo 'done<br>';
die;
echo $divider. '<br>Extract PRODUCT Keys & values ...<br>'.$divider	;
foreach($xmlArray["Product"] as $i=>$keys) {
	$keysArray = array();
	$rtn = extractProductKeys_2($i,$keys, '', $keysArray);
	var_dump($rtn);
//	die;
}
function extractProductKeys_2($idx,$xml,$path = '',$keysArray) {
//	echo '<br>*** Entry ***<br><BR>';
	echo '[Key} = [' . $idx . ']<br>';
//	echo 'keysArray = ';
//	var_dump($keysArray);
	echo 'Path = '.$path.'<br>';
//	var_dump($xml);
	$path2 = $idx; 	
	if(is_array($xml)) {
		foreach($xml as $k=>$v) {
			//			echo 'parsing XML key: '.$k.' ...<br>';
			$path2 .= $path . $k;
			//			echo 'Path ...'.$path;
			if(is_array($v)) {
				foreach($v as $_k=>$_v) {
					echo '*** Recursing with: '.$k.'['.$_k.']<br>';
					$keysArray = extractProductKeys_2($_k, $v[$_k], $path2,$keysArray);
					//echo 'Return from Recursive call: path = '.$path.'<br>';
					echo 'Return from Recursive call: keysArray = ';
					var_dump($keysArray);
					//$path = '';
				}
			}
			else {
				$path = '';
				die ('****************');
			}
		}
	}
	if(!is_array($xml)) {
		echo 'Key: '.$path.'  = '.$xml.'<br>';
		$keysArray[$path][]= $xml;
		//var_dump($keysArray);
		$path = '';
		$path2 = '';
		return $keysArray;
		//		echo "path = ".$path.'!!!<br>';
		//var_dump($v);
	}
}

//print_r($xmlArray);
//var_dump($xmlArray);


function extractProductKeys($idx,$xml,$path = '',$keysArray) {
	echo '<br>*** Entry ***<br><BR>';
	echo '[Key} = [' . $idx . ']<br>';
	echo 'keysArray = ';
	var_dump($keysArray);
	echo 'Path = '.$path.'<br>';
	var_dump($xml);
	if(is_array($xml)) {
		foreach($xml as $k=>$v) {
//			echo 'parsing XML key: '.$k.' ...<br>';
			$path2 = $path . $k;
			//			echo 'Path ...'.$path;
			if(is_array($v)) {
				foreach($v as $_k=>$_v) {
//					echo 'Recursing with: '.$k.'['.$_k.']<br>';
					$keysArray = extractProductKeys($_k, $v[$_k], $path2,$keysArray);
//					echo 'Return from Recursive call: path = '.$path.'<br>';
//					echo 'Return from Recursive call: keysArray = ';
//					var_dump($keysArray);
					//$path = '';
				}
			}
			else {
				$path = ''; 
				die ('****************');
			}
		}
	}
	if(!is_array($xml)) {
		echo 'Key: '.$path.'  = '.$xml.'<br>';
		$keysArray[$path][]= $xml;
		//var_dump($keysArray);
		$path = '';
		return $keysArray;
//		echo "path = ".$path.'!!!<br>';
		//var_dump($v);
	}
}

//print_r($xmlArray);
//var_dump($xmlArray);
function xml2array($fname){
	$sxi = new SimpleXmlIterator($fname, null, false);
	foreach($sxi->Product as $i=>$prodXML) {
		$isbn =  (string) $prodXML->ProductIdentifier->IDValue;
		$product[] = sxiToArray($prodXML,$isbn) ;
	}
	var_dump($product);
	die;
	return sxiToArray($sxi);
}

function sxiToArray($sxi, $key){
//	var_dump($sxi);
	$a = array();
	if (!array_key_exists( $key, $a)) $a[$key] = array();
	var_dump($a);
	for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
			echo (string)$sxi->key(). '...<br>';
		if (!array_key_exists((string)$sxi->key(), $a[$key])){
//			$a[$sxi->key()] = array();
			$a[$key][$sxi->key()] =  array();
		}
		if($sxi->hasChildren()){
			$a[$key]= sxiToArray($sxi->current(), $sxi->key());
		}
		else{
			$a[$key][$sxi->key()] = strval($sxi->current());
	
		}
	}
	echo 'Exiting sxiToArray ... ';
	var_dump($a);
	return $a;
}

