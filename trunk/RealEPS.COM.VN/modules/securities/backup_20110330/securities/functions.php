<?php
function get_hcm_security_filter($symbol, $fromDate, $toDate, $seId) {

	$db = _db('eps');
	$db->query('call sp_Main_Market_Info_Deal("'.$symbol.'","'.$fromDate.'","'.$toDate.'",'.$seId.')');
	//die('call sp_Main_Market_Info_Deal("'.$symbol.'","'.$fromDate.'","'.$toDate.'",'.$seId.')');
	$ret = $db->fetchAll();
	$db->connect();
	$return = $ret;
	
	if ($return){
		for($i=0; $i<count($ret); $i++){
			if ($ret[$i]['Last'] < 1000)
				$return[$i]['change'] = $ret[$i]['Last'] - $ret[$i]['OpenPriceOS'];
			else
				$return[$i]['change'] = ($ret[$i]['Last'] - $ret[$i]['OpenPriceOS']) / 1000;
			if($ret[$i]['OpenPriceOS']>0)
				$return[$i]['percentage_change'] = round(($ret[$i]['Last'] - $ret[$i]['OpenPriceOS']) / $ret[$i]['OpenPriceOS'] * 100, 2);         
		}
	}
	
	return $return;
}
function getTopFI5BVol($from_date, $to_date, $exchange){
    $db = _db('eps');
    $db->connect();
echo '<!---' ."SELECT StockSymbol, BDealVol from foreign_investment
	WHERE TradingDate>='$from_date' AND TradingDate<='$to_date' AND StockExchangeID=$exchange ORDER BY BDealVol desc limit 5". '-->';
    $db->query("SELECT StockSymbol, BDealVol from foreign_investment
	WHERE TradingDate>='$from_date' AND TradingDate<='$to_date' AND StockExchangeID=$exchange ORDER BY BDealVol desc limit 5");
    if ($result = $db->fetchAll()) return $result;
    return false;
}
function getTopFI5BVal($from_date, $to_date, $exchange){
    $db = _db('eps');


    $db->connect();
    $db->query("SELECT StockSymbol, BDealVal FROM foreign_investment
	WHERE TradingDate>='$from_date' AND TradingDate<='$to_date' AND StockExchangeID=$exchange ORDER BY BDealVal desc limit 5");
    if ($result = $db->fetchAll()) return $result;
    return false;
}
function getTopFI5SVol($from_date, $to_date, $exchange){
    $db = _db('eps');


    $db->connect();
    $db->query("SELECT StockSymbol, SDealVol FROM foreign_investment
	WHERE TradingDate>='$from_date' AND TradingDate<='$to_date' AND StockExchangeID=$exchange ORDER BY SDealVol desc limit 5");
    if ($result = $db->fetchAll()) return $result;
    return false;
}
function getTopFI5SVal($from_date, $to_date, $exchange){
    $db = _db('eps');


    $db->connect();
    $db->query("SELECT StockSymbol, SDealVal FROM foreign_investment
	WHERE TradingDate>='$from_date' and TradingDate<='$to_date' AND StockExchangeID=$exchange ORDER BY SDealVal desc limit 5");
    if ($result = $db->fetchAll()) return $result;
    return false;
}
function getForeignInvestment_sum($symbol, $from_date, $to_date, $exchange){
    $db = _db('eps');
    $db->connect();
    $db->query("call sp_getForeignInvestment_sum('$symbol','$from_date','$to_date',$exchange)");
    
    if ($result = $db->fetch()) return $result;
    $db->connect();
    return false;
}
function getForeignInvestment($symbol, $from_date, $to_date, $exchange){
    $db = _db('eps');
    $db->connect();
    $db->query("call sp_getForeignInvestment1('$symbol','$from_date','$to_date',$exchange)");
    if ($result = $db->fetchAll()) return $result;
    $db->connect();
    return false;
}
function getMarketInfo($date,$seId, &$data){
    $maxTradingDate = $date;
    $db = _db('eps');
    $db->connect();
    
    switch ($seId){
        case 2 : $db->query('call sp_HN_getCurrentMarketInfo("'.$date.'")');break;
        default : $db->query('call sp_GetTotalMarket("'.$date.'")');break;
    }
	if ($obj=$db->fetch()) $data['total_market'] = $obj;
	$db->connect();

	$db->query('call sp_getTopUp("'.$date.'",'.$seId.')');
	if ($objs=$db->fetchAll()) $data['top_gainers'] = $objs;
	$db->connect();
	
	$db->query('call sp_getTopDown("'.$date.'",'.$seId.')');
	if ($objs=$db->fetchAll()) $data['top_losers'] = $objs;
	$db->connect();
	
	$db->query('call sp_getTopActive("'.$date.'",'.$seId.')');
	
	if ($objs=$db->fetchAll()) $data['top_last_vol'] = $objs;
	$db->connect();
}
?>