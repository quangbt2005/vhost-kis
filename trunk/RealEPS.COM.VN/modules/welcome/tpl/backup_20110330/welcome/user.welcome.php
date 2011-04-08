<?php
function welcome_user_main(){       
	//HOSE		
	$db = _db('eps');
	$maxTradingDate = maxTradingDate();
	$db->query('call sp_GetTotalMarket("'.$maxTradingDate.'")');
	if ($obj=$db->fetch()) $data['hose_total_market'] = $obj;
	//HASE		
	$db->connect();
	$db->query('call sp_HN_getCurrentMarketInfo("'.$maxTradingDate.'")');
	if ($obj=$db->fetch()) $data['hase_total_market'] = $obj;
	//UPCOM		
	$db->connect();
	$db->query('call sp_upcom_getCurrentMarketInfo("'.$maxTradingDate.'")');
	if ($obj=$db->fetch()) $data['upcom_total_market'] = $obj;

	//sp_HN_getCurrentMarketInfo
	$data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m")-6  , date("d"), date("Y")));
	$data['chart_today'] = $maxTradingDate;
	return $data;
}
?>