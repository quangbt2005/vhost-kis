<?php 
function test_feed_main(){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/MarketDataService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => 'BBS',
					'startDate' => '2009-09-23T00:00:00',
					'endDate' => '2009-09-23T00:00:00');
	if ($objs = _feed_stockbiz('GetHistoricalQuotes',$url,$params)){
		var_dump($objs);
		die();
			
	}	
}
?>