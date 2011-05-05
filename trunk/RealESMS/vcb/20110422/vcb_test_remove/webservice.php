<?php
/**
	Generate data type for webservice
*/
function genStruct($arr_input){
	$arr_return = array();

	for($i=0; $i<count($arr_input); $i++) {
		$param = $arr_input[$i];
		$arr_return[$param] = 'string';
		if($param=='FileContent'){
			$arr_return[$param] = 'base64Binary';
		}		
	}
	return $arr_return;
}

?>