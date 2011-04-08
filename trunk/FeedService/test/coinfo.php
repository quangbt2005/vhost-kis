<?php
require_once('../config.inc.php');

function feedCompanyInfo($symbol){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol);		

	$objs = _feed_stockbiz('GetCompanyInfo',$url,$params);
	
	print_r($objs);
}
?>