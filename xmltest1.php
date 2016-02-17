<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','5G');
$file = '/test1.xml';
$file = '/122370_47174_00_20160105_00.add.xml';
echo "Input XML File = ".(dirname(__FILE__).$file).' - ';
echo (is_file(dirname(__FILE__).$file))?"OK<br>":"Not Found<br>";
$xml = file_get_contents(dirname(__FILE__).$file);
//$xml = trim($xm,'﻿');
$divider = '<br>*************************************************************<br>';

echo $divider. '<br>Store the XML in array... <br>';
$xmlArray = xml2Array($xml);
echo 'done<br>';
echo $divider. '<br>Extract PRODUCT Keys & values ...<br>'.$divider	;
foreach($xmlArray["Product"] as $i=>$keys) {
	$xml_ISBN13 = $keys['RecordReference'][0];
	echo '<br>ISBN13: '. $xml_ISBN13.'<br>';
	$obj = new xml_converter($xml_ISBN13);
	
	$keysArray = array();
	$rtn = extractProductKeys($i,$keys, '', $keysArray,$obj);
/*	echo '<br> Subject tags... <br>';
	$subj = new xml_converter($xml_ISBN13);
	foreach($keys["Subject"] as $i=>$subject) {
		extractProductKeys($i,$subject, '', $keysArray,$subj);
		var_dump($subj);
	}
	*/
	echo $divider.'<br>';
	var_dump($obj);
	//var_dump($rtn);
	//die;	// one product
}


function extractProductKeys($idx,$xml,$path = '',$keysArray,$obj) {
//	echo '<br>*** Entry ***<br><BR>';
//	echo '[Key} = [' . $idx . ']<br>';
//	echo 'keysArray = ';
//	var_dump($keysArray);
//	echo 'Path = '.$path.'<br>';
//	var_dump($xml);
	if(is_array($xml)) {
		foreach($xml as $k=>$v) {
//			echo 'parsing XML key: '.$k.' ...<br>';
			$path2 = $path . $k;
			//			echo 'Path ...'.$path;
			if(is_array($v)) {
				foreach($v as $_k=>$_v) {
//					echo 'Recursing with: '.$k.'['.$_k.']<br>';
					$keysArray = extractProductKeys($_k, $v[$_k], $path2,$keysArray,$obj);
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
		$obj->xml_addkey($path,$xml);
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
	return sxiToArray($sxi);
}

function sxiToArray($sxi){
	$a = array();
	for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
		if(!array_key_exists($sxi->key(), $a)){
	//		echo $sxi->key(). '<br>';
			$a[$sxi->key()] = array();
		}
		if($sxi->hasChildren()){
			$a[$sxi->key()][]= sxiToArray($sxi->current());
		}
		else{
			$a[$sxi->key()][] = strval($sxi->current());
	
		}
	}
//	var_dump($a);
	return $a;
}
class xml_converter {
	function xml_converter($ISBN13) {
		$this->ISBN13 = $ISBN13;
	}
	function xml_addkey($key,$value){
		$this->$key = $value;
		
	}
}
