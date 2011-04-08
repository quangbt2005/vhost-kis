<?php
function get_hcm_putthrough($date, &$totalQty, &$totalVal){
	$totalQty = 0;
	$totalVal = 0;
	$db = _db('eps');
	$db->connect();
	$db->query('call sp_hcm_exec("'.$date.'")');
	if ($objs = $db->fetchAll()){
		for ($i=0; $i<count($objs); $i++){
			//$objs[$i]['Price'] /= 1000;
			$objs[$i]['TotalVal'] =  $objs[$i]['Vol'] * $objs[$i]['Price'];
			$totalQty += $objs[$i]['Vol'];
			$totalVal += $objs[$i]['TotalVal'];
		}
	}
	return $objs;
}
function get_hcm_putthrough_filter($symbol, $fromDate, $toDate, &$totalQty, &$totalVal){
	$totalQty = 0;
	$totalVal = 0;
	$db = _db('eps');
	$db->connect();
	$db->query('call sp_getPutExecInfo1("'.$symbol.'","'.$fromDate.'", "'.$toDate.'",0)');
	
	if ($objs = $db->fetchAll()){
		for ($i=0; $i<count($objs); $i++){
			$totalQty += $objs[$i]['Vol'];
			$totalVal += $objs[$i]['Value'];
		}
	}
	return $objs;
}
function get_hcm_security_filter($symbol, $fromDate, $toDate) {
	$db = _db('eps');
	$db->query('call sp_Main_Market_Info_Deal("'.$symbol.'","'.$fromDate.'","'.$toDate.'", 1)');
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
function get_hcm_security($date) {
	$session = currentSession($date);
	$db=_db('eps');
	$db->query('call sp_current_security("'.$date.'")');
	
	if ($result=$db->fetchAll()){
		$total_value=0;
		for($i=0; $i<count($result); $i++) {
			$total_value += $result[$i]["session_one_price"] * $result[$i]["session_one_vol"] 
					   + $result[$i]["session_two_price"] * $result[$i]["session_two_vol"] 
					   + $result[$i]["Last"] * ($result[$i]["LastVol"] *10 - $result[$i]["session_one_vol"] - $result[$i]["session_two_vol"]) ;
		}
		/*echo '3146795997.795688<br/>';
		echo $total_value;
		die();
		$total_value /=10;*/
		for($i=0; $i<count($result); $i++) {
	    	$result[$i]["session_one_price"] = $result[$i]["session_one_price"];
			$result[$i]["session_one_vol"] = $result[$i]["session_one_vol"] * 10;
			$result[$i]["session_two_price"] = $result[$i]["session_two_price"];
			$result[$i]["session_two_vol"] = $result[$i]["session_two_vol"] * 10;
			$result[$i]["session_three_vol"] = $result[$i]["LastVol"] *10 - $result[$i]["session_one_vol"] - $result[$i]["session_two_vol"];
			$result[$i]["LastVal"] = $result[$i]["session_one_price"] * $result[$i]["session_one_vol"] * 10
								   + $result[$i]["session_two_price"] * $result[$i]["session_two_vol"] *10
								   + $result[$i]["Last"] * $result[$i]["session_three_vol"] * 10;
	
			if ($result[$i]["PriorClosePrice"] != 0) {
				$result[$i]["percentage_change"] = round(($result[$i]["Last"] - $result[$i]["PriorClosePrice"] )/ $result[$i]["PriorClosePrice"] * 100, 2);
			} else {
				$result[$i]["percentage_change"] =0;
			}
			$result[$i]["PriorClosePrice"] = $result[$i]["PriorClosePrice"];
	
			switch($session) {
				case "1":
					// pre open price
					$result[$i]["last_price"] = $result[$i]["ProjectOpen"];
					if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
						$result[$i]["last_change"] = $result[$i]["ProjectOpen"] - $result[$i]["PriorClosePrice"];
					$result[$i]["last_volume"] = "";
					break;
				case "2":
					// open price + last price
					$result[$i]["last_price"] = $result[$i]["last"];
					if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
						$result[$i]["last_change"] = $result[$i]["Last"] - $result[$i]["PriorClosePrice"];
					$result[$i]["last_volume"] = $result[$i]["LastVol"] * 10;
					break;
				case "3":
					// pre close price
					$result[$i]["last_price"] = $result[$i]["ProjectOpen"];
					if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
						$result[$i]["last_change"] = $result[$i]["ProjectOpen"] - $result[$i]["PriorClosePrice"];
					$result[$i]["last_volume"] = "";
					break;
				case "0":
				case "4":
				case "5":
				default:
				// close price
				$result[$i]["last_price"] = $result[$i]["Last"];
				if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
					$result[$i]["last_change"] = $result[$i]["Last"] - $result[$i]["PriorClosePrice"];
				$result[$i]["last_volume"] = $result[$i]["LastVol"] * 10;
				break;
			}
			
			
			if ($total_value != 0 ) {
				$result[$i]["ratio"] = round(($result[$i]["LastVal"]/$total_value)*10000, 2);
			}
			$result[$i]["LastVol"] = $result[$i]["LastVol"] * 10;
			$result[$i]["change"] = $result[$i]["last_change"];
			$result[$i]["unmatch_bid"] = ($result[$i]["Best1BidVolume"] + $result[$i]["Best2BidVolume"] + $result[$i]["Best3BidVolume"]) * 10 ;
			$result[$i]["unmatch_offer"] = ($result[$i]["Best1OfferVolume"] + $result[$i]["Best2OfferVolume"] + $result[$i]["Best3OfferVolume"]) * 10  ;

		}
		$db->connect();
		return $result;
	}    
	$db->connect();
}    
//HASE
function get_hn_putthrough($date, &$totalQty, &$totalVal){
	$totalQty = 0;
	$totalVal = 0;
	$db = _db('eps');
	$db->connect();
	$db->query('call sp_HN_MatchedPutThrough ("'.$date.'")');
	if ($objs = $db->fetchAll()){
		for ($i=0; $i<count($objs); $i++){
			$totalQty += $objs[$i]['PtTotalTradedQtty'];
			$totalVal += $objs[$i]['PtTotalTradedValue'];
		}
	}
	return $objs;
}

function get_hn_security_filter($symbol, $fromDate, $toDate) {
	$db = _db('eps');
	$db->query('call sp_Main_Market_Info_Deal("'.$symbol.'","'.$fromDate.'","'.$toDate.'", 2)');
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
function get_hn_security($date) {
	$db=_db('eps');
	$db->connect();
	$db->query('call sp_HN_getCurrentStockInfo("'.$date.'")');
	$ret = $db->fetchAll();
	for ($i=0; $i<count($ret); $i++){
		
		$result[$i]["StockSymbol"] = $ret[$i]["StockCode"];
		$result[$i]["PriorClosePrice"] = $ret[$i]["BasicPrice"]/1000;
		$result[$i]["ceiling"] = $ret[$i]["CeilingPrice"]/1000;
		$result[$i]["floor"] = $ret[$i]["FloorPrice"]/1000;
		$result[$i]["best3bid"] = $ret[$i]["BOrdPrice3"]/1000;
		$result[$i]["best3bidvolume"] = $ret[$i]["BOrdQtty3"];
		$result[$i]["best2bid"] = $ret[$i]["BOrdPrice2"]/1000;
		$result[$i]["best2bidvolume"] = $ret[$i]["BOrdQtty2"];
		$result[$i]["best1bid"] = $ret[$i]["BOrdPrice1"]/1000;
		$result[$i]["best1bidvolume"] = $ret[$i]["BOrdQtty1"];
		$result[$i]["best3offer"] = $ret[$i]["SOrdPrice3"]/1000;
		$result[$i]["best3offervolume"] = $ret[$i]["SOrdQtty3"];
		$result[$i]["best3offer"] = $ret[$i]["SOrdPrice3"]/1000;
		$result[$i]["best3offervolume"] = $ret[$i]["SOrdQtty3"];
		$result[$i]["best3offer"] = $ret[$i]["SOrdPrice3"]/1000;
		$result[$i]["best3offervolume"] = $ret[$i]["SOrdQtty3"];
		$result[$i]["best2offer"] = $ret[$i]["SOrdPrice2"]/1000;
		$result[$i]["best2offervolume"] = $ret[$i]["SOrdQtty2"];
		$result[$i]["best1offer"] = $ret[$i]["SOrdPrice1"]/1000;
		$result[$i]["best1offervolume"] = $ret[$i]["SOrdQtty1"];
		$result[$i]["last_price"] = $ret[$i]["MatchPrice"]/1000;
		$result[$i]["last_volume"] = $ret[$i]["TotalTradingQtty"];
		$result[$i]["LastVal"] = $ret[$i]["TotalTradingValue"];
		$result[$i]["unmatch_bid"] = $result[$i]["best3bidvolume"] + $result[$i]["best2bidvolume"] + $result[$i]["best1bidvolume"];
		$result[$i]["unmatch_offer"] = $result[$i]["best3offervolume"] + $result[$i]["best2offervolume"] + $result[$i]["best1offervolume"];

		if ($result[$i]["last_price"] == 0)
			$result[$i]["last_change"] = $result[$i]["change"] = 0;                                                               
		else
			$result[$i]["last_change"] = $result[$i]["change"] = ($ret[$i]["MatchPrice"] - $ret[$i]["BasicPrice"])/1000;          
		$result[$i]["fbuy"] = $ret[$i]["FBuy"];
		$result[$i]["fsell"] = $ret[$i]["FSell"];
		$result[$i]["currentroom"] = $ret[$i]["RemainForeignQtty"];
		$result[$i]["securityname"] = $ret[$i]["SecurityName"];
		$result[$i]["totaltradingquantity"] = $ret[$i]["NmTotalTradedQtty"];
		$result[$i]["highestprice"] = $ret[$i]["HighestPrice"]/1000;
		$result[$i]["lowestprice"] = $ret[$i]["LowestPrice"]/1000;
		if ($ret[$i]["ClosePrice"] != 0 ) {
			$result[$i]["percentage_change"] = $ret[$i]["BasicPrice"] / $ret[$i]["ClosePrice"];
		} else {
			$result[$i]["percentage_change"] = 0;
		}
		/*if ($i == 3){
		var_dump($result[$i]);
		die();
		}*/
	}
	return $result;
	$db->connect();
}
?>