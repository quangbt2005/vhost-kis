<?php
require('newsfuntion.php');
//{{{NEWS
function feednews_feed_main(){    
	global $_configs;
	setRangeDate($startDate, $endDate);	
	$url = 'http://datafeed.stockbiz.vn/NewsService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'startDate' => $startDate,
	'endDate' => $endDate);
	if ($objs = _feed_stockbiz('GetNews',$url,$params)){
		if (!empty($objs['GetNewsResult'])){
			$objs = $objs['GetNewsResult']['News'];
			for ($i=0; $i<count($objs);$i++){
				insertIntoNews($objs[$i]);
			}	
		}
	}	
}
//}}}
//{{{INDUSTRY
function feedNewsByIndustry($industryId, $startDate, $endDate){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/NewsService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'industryID' => $industryId,
	'startDate' => $startDate,
	'endDate' => $endDate);	
	if ($objs = _feed_stockbiz('GetIndustryNews',$url,$params)){
		if (!empty($objs['GetIndustryNewsResult'])){
			if (!isset($objs['GetIndustryNewsResult']['News'][0])){
				insertIntoNews($objs['GetIndustryNewsResult']['News'], array('IndustryId' => $industryId));
			}else{
				$objs = $objs['GetIndustryNewsResult']['News'];
				for ($i=0; $i<count($objs);$i++){
					insertIntoNews($objs[$i], array('IndustryId' => $industryId));
				}	
			}
		}
	}		
}
function feednews_feed_industry(){
	$db  = _db('stockbiz');
	$db->query('SELECT IndustryId FROM _prefix_industry');
	setRangeDate($startDate, $endDate);
 	if ($industrys = $db->fetchAll())	
		foreach ($industrys as $industry){
			feedNewsByIndustry($industry['IndustryId'], $startDate, $endDate);
		}
}
//}}}

//{{{ SECTOR
function feedNewsBySector($sectorId, $startDate, $endDate){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/NewsService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'sectorID' => $sectorId,
	'startDate' => $startDate,
	'endDate' => $endDate);
	if ($objs = _feed_stockbiz('GetSectorNews',$url,$params)){
		if (!empty($objs['GetSectorNewsResult'])){
			if (!isset($objs['GetSectorNewsResult']['News'][0])){
				insertIntoNews($objs['GetSectorNewsResult']['News'], array('IndustryId' => $sectorId));
			}else{
				$objs = $objs['GetSectorNewsResult']['News'];
				for ($i=0; $i<count($objs);$i++){
					insertIntoNews($objs[$i], array('SectorId' => $sectorId));
				}	
			}
		}
	}		
}
function feednews_feed_sector(){

	$db  = _db('stockbiz');
	$db->query('SELECT SectorId FROM _prefix_sector');
	setRangeDate($startDate, $endDate);
 	if ($sectors = $db->fetchAll())
		foreach ($sectors as $sector){
			feedNewsBySector($sector['SectorId'], $startDate, $endDate);
		}
}
//}}}

//{{{ SYMBOL
function feedNewsBySymbol($symbol, $startDate, $endDate){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/NewsService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
	'password' => $_configs['stockbiz_pass'],
	'symbol' => $symbol,
	'startDate' => $startDate,
	'endDate' => $endDate);
	
	if ($objs = _feed_stockbiz('GetCompanyNews',$url,$params)){		
		if (!empty($objs['GetCompanyNewsResult'])){
			if (!isset($objs['GetCompanyNewsResult']['News'][0])){
				insertIntoNews($objs['GetCompanyNewsResult']['News'], array('Symbol' => $symbol));
			}else{
				$objs = $objs['GetCompanyNewsResult']['News'];
				for ($i=0; $i<count($objs);$i++){
					insertIntoNews($objs[$i], array('Symbol' => $symbol));
				}	
			}
		}
	}		
}
function feednews_feed_symbol(){
	$db  = _db('stockbiz');

	$db->query('SELECT Symbol FROM _prefix_symbol');
	setRangeDate($startDate, $endDate);
 	if ($symbols = $db->fetchAll())

		foreach ($symbols as $symbol){
			feedNewsBySymbol($symbol['Symbol'], $startDate, $endDate);
		}
}
//}}}
?>