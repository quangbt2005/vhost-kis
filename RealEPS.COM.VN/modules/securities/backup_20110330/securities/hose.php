<?php
function getPutExecInfo_sum($symbol,$fromdate, $todate, $bond=0){
	$db = _db('eps');
	$db->connect();
	$db->query('call sp_getPutExecInfo_sum("'.$symbol.'","'.$fromdate.'","'.$todate.'",'.$bond.')');
	if ($obj = $db->fetch()){
	    return $obj;
	}
	
}
function get_hcm_putthrough($symbol,$fromdate, $todate, $bond=0){
	$db = _db('eps');
	$db->connect();
	$db->query('call sp_getPutExecInfo1("'.$symbol.'","'.$fromdate.'","'.$todate.'",'.$bond.')');
	
	if ($objs = $db->fetchAll()){
	    return $objs;
	}
	
}
function get_hcm_security($date) {
	$session = currentSession($date);
	$db=_db('eps');
	$db->connect();
	$db->query('call sp_current_security("'.$date.'")');
	
	if ($result=$db->fetchAll()){
	    $total_value = 0;
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
			$result[$i]["last_change"] = "";
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

?>