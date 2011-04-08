<?php
require('functions.php');
require('filters.php');

function put_through_user_main(){
	global $fromDate, $toDate, $tmpFromDate ,$tmpToDate,$maxTradingDate, $func;
	//HOSE		
	$db = _db('eps');
	$db->query('call sp_getStockSymbolList("'.$maxTradingDate.'",1)');
	$objs=$db->fetchAll();
	$db->connect();
	//Kiem tra symbol truyen vao ton tai hay khong
	$hasSymbol=false;
	$symbol='';
	if (!empty($_GET['symbol'])) $symbol=$_GET['symbol'];
	if ($objs){
		foreach ($objs as $item){
			$data['StockSymbols'][]=$item['StockSymbol'];
			
			if ($symbol == $item['StockSymbol']){
				$hasSymbol=true;
				$data['StockSymbol'] = $symbol;
				$data['SecurityName'] =$item['SecurityName'];   
			}
		}
	}
	if (!empty($data['StockSymbols'])) $data['StockSymbols'] = json_encode($data['StockSymbols']);
	//Neu co symbol thi filter theo symbol
	if ($hasSymbol){
		$data['put_through'] = get_hcm_putthrough_filter($symbol, $fromDate, $toDate, $data['put_through_qty'], $data['put_through_val']);
		$func = 'main.filter';
		$data['symbol'] = $symbol;
	}else{
		$db->connect();
		$data['maxtradingdate'] = $maxTradingDate;
		$db->query('call sp_GetTotalMarket("'.$maxTradingDate.'")');
		if ($obj=$db->fetch()) $data['hose_total_market'] = $obj;
		
		$db->connect();
		$db->query('call sp_getTopUp("'.$maxTradingDate.'",1)');
		if ($objs=$db->fetchAll()) $data['hose_top_gainers'] = $objs;
		
		$db->connect();
		$db->query('call sp_getTopDown("'.$maxTradingDate.'", 1)');
		if ($objs=$db->fetchAll()) $data['hose_top_losers'] = $objs;
	
		$db->connect();
		$db->query('call sp_getTopActive("'.$maxTradingDate.'",1)');
		if ($objs=$db->fetchAll()) $data['hose_top_last_vol'] = $objs;

		$data['put_through'] = get_hcm_putthrough($maxTradingDate, $data['put_through_qty'], $data['put_through_val']);
	}

	$data['from_date'] = $fromDate;
	$data['to_date'] = $toDate;
	
	$data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime($maxTradingDate))-6  , date("d",strtotime($maxTradingDate)), date("Y",strtotime($maxTradingDate))));
	$data['chart_today'] = $maxTradingDate;

	return $data;
}

function put_through_user_hase(){
	global $fromDate, $toDate, $tmpFromDate ,$tmpToDate,$maxTradingDate, $func;
	//HASE		
	$db = _db('eps');
	$db->query('call sp_getStockSymbolList("'.$maxTradingDate.'",2)');
	$objs=$db->fetchAll();
	$db->connect();
	//Kiem tra symbol truyen vao ton tai hay khong
	$hasSymbol=false;
	$symbol='';
	if (!empty($_GET['symbol'])) $symbol=$_GET['symbol'];
	if ($objs){
		foreach ($objs as $item){
			$data['StockSymbols'][]=$item['StockSymbol'];
			
			if ($symbol == $item['StockSymbol']){
				$hasSymbol=true;
				$data['StockSymbol'] = $symbol;
				$data['SecurityName'] =$item['SecurityName'];   
			}
		}
	}
	if (!empty($data['StockSymbols'])) $data['StockSymbols'] = json_encode($data['StockSymbols']);
	//Neu co symbol thi filter theo symbol
	/*if ($hasSymbol){
		$data['put_through'] = get_hcm_putthrough_filter($symbol, $fromDate, $toDate, $data['put_through_qty'], $data['put_through_val']);
		$func = 'main.filter';
		$data['symbol'] = $symbol;
	}else{*/
		$db->connect();
		$data['maxtradingdate'] = $maxTradingDate;
		$db->query('call sp_HN_getCurrentMarketInfo("'.$maxTradingDate.'")');
		if ($obj=$db->fetch()) $data['hase_total_market'] = $obj;
		
		$db->connect();
		$db->query('call sp_getTopUp("'.$maxTradingDate.'",2)');
		if ($objs=$db->fetchAll()) $data['hase_top_gainers'] = $objs;
		
		$db->connect();
		$db->query('call sp_getTopDown("'.$maxTradingDate.'", 2)');
		if ($objs=$db->fetchAll()) $data['hase_top_losers'] = $objs;
	
		$db->connect();
		$db->query('call sp_getTopActive("'.$maxTradingDate.'",2)');
		if ($objs=$db->fetchAll()) $data['hase_top_last_vol'] = $objs;

		$data['put_through'] = get_hn_putthrough($maxTradingDate, $data['put_through_qty'], $data['put_through_val']);
	/*}*/

	$data['from_date'] = $fromDate;
	$data['to_date'] = $toDate;
	
	$data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime($maxTradingDate))-6  , date("d",strtotime($maxTradingDate)), date("Y",strtotime($maxTradingDate))));
	$data['chart_today'] = $maxTradingDate;

	return $data;
}
function put_through_user_mod_layout(){
	return 'user.layout.tpl';
}
?>