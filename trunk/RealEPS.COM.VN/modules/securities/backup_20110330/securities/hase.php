<?php
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
	$db->connect();
	return $objs;
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
	}
	$db->connect();
	return $result;
}
?>