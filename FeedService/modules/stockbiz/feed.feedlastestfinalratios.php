<?php

function feedLastestFinalRatiosBySector($sectorId){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'sectorID' => $sectorId);
		
	if ($obj = _feed_stockbiz('GetLastestSectorFinancialRatios',$url,$params)){
		$obj = $obj['GetLastestSectorFinancialRatiosResult'];
		$db = _db('stockbiz');
		$db->query('DELETE FROM _prefix_lastestfinancialratios WHERE SectorID='. $obj['SectorID']);
		$sql=buildInsertSQL('_prefix_lastestfinancialratios', $obj);
		$db->query($sql);
	}	
}
function feedLastestFinalRatiosByIndustry($industryId){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'industryID' => $industryId);
		
	if ($obj = _feed_stockbiz('GetLastestIndustryFinancialRatios',$url,$params)){
		$obj = $obj['GetLastestIndustryFinancialRatiosResult'];
		$db = _db('stockbiz');
		$db->query('DELETE FROM _prefix_lastestfinancialratios WHERE IndustryID='. $obj['IndustryID']);
		$sql=buildInsertSQL('_prefix_lastestfinancialratios', $obj);
		$db->query($sql);
	}	
}
function feedLastestFinalRatiosBySymbol($symbol){	
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'symbol' => $symbol);	
	if ($obj = _feed_stockbiz('GetLastestFinancialRatios',$url,$params)){
		/*if ($symbol=='BBS'){
			var_dump($obj);
			die('dasdsa');
		}*/
		$obj = $obj['GetLastestFinancialRatiosResult'];
		$db = _db('stockbiz');
		$db->query('DELETE FROM _prefix_lastestfinancialratios WHERE Symbol=\''. $symbol . '\'');
		$obj['Symbol'] = $symbol;
		$sql=buildInsertSQL('_prefix_lastestfinancialratios', $obj);
		$db->query($sql);
		//echo $db->error();
	}	
}
function feedlastestfinalratios_feed_sector(){
	$db=_db('stockbiz');
	$db->query('SELECT SectorId FROM _prefix_sector');
	$objs = $db->fetchAll();
	for ($i=0; $i<count($objs);$i++) feedLastestFinalRatiosBySector($objs[$i]['SectorId']);
}
function feedlastestfinalratios_feed_industry(){
	$db=_db('stockbiz');
	$db->query('SELECT IndustryId FROM _prefix_industry');
	$objs = $db->fetchAll();
	for ($i=0; $i<count($objs);$i++) feedLastestFinalRatiosByIndustry($objs[$i]['IndustryId']);
}
function feedlastestfinalratios_feed_symbol(){
	$db=_db('stockbiz');
	$db->query('SELECT Symbol FROM symbol');
	$objs = $db->fetchAll();
	for ($i=0; $i<count($objs);$i++) feedLastestFinalRatiosBySymbol($objs[$i]['Symbol']);
}
?>