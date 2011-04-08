<?php
class cTrading {
	var $trading_date; 	
	
	function cTrading($stock_exchange) {
		$current_date = date("Y-m-d"); 
		$current_time = date("H:i:s"); 
		// 1: hcm, 2: hn
		$conn = &new DB(); 

		if ($stock_exchange == 1) {
			// check condition before call store procedure
			$is_called = 0; 
			if ($_SESSION['hcm_trading_time'] == NULL || $_SESSION['hcm_trading_time'] == '')
				$is_called = 1; 
			else if ($_SESSION['hcm_trading_time'] < $current_date && $current_time > "08:04:00" && $current_time < "08:10:00")
				$is_called = 1; 
			else 
				$is_called = 0; 
			$is_called = 1; 
			if ($is_called == 1) {				
				$mdb2 = $conn->open_connection(DB_DNS); 
				$max_date_query = sprintf("call sp_getMaxTradingDate_Security(NULL)");
				$ret_1 = $mdb2->extended->getRow($max_date_query); 
				$conn->close_connection(); 
				
				$max_date = $ret_1["max_trading_date"];
	
				$mdb2 = $conn->open_connection(DB_DNS); 
				$last_max_date_query = sprintf("call sp_getMaxTradingDate_Security('%s')", $max_date); 																				
				$ret_2 = $mdb2->extended->getRow($last_max_date_query); 
				$conn->close_connection(); 
	
				$last_max_date = $ret_2["last_max_trading_date"];

				if (date("D") == "Sat" || date("D") == "Sun")
					$this->trading_date = $max_date; 
				elseif ($max_date != $current_date) 
					$this->trading_date = $max_date; 
				elseif ($current_time < "08:05:00") 
					$this->trading_date = $last_max_date; 
				else 
					$this->trading_date = $current_date; 					

				$_SESSION['hcm_trading_time'] = $this->trading_date;
			}
			else 
				$this->trading_date = $_SESSION['hcm_trading_time']; 
		}
		else {
			// check condition before call store procedure
			$is_called = 0; 
			if ($_SESSION['hn_trading_time'] == NULL || $_SESSION['hn_trading_time'] == '')
				$is_called = 1; 
			else if ($_SESSION['hn_trading_time'] < $current_date && $current_time > "08:04:00" && $current_time < "08:10:00")
				$is_called = 1; 
			else 
				$is_called = 0; 
				
			if ($is_called == 1) {				
				$mdb2 = $conn->open_connection(DB_DNS); 
				$max_date_query = sprintf("call sp_getMaxTradingDate_HNStockInfo(NULL)");
				$ret_1 = $mdb2->extended->getRow($max_date_query); 
				$conn->close_connection(); 
	
				$max_date = $ret_1["max_trading_date"];
				
				$mdb2 = $conn->open_connection(DB_DNS); 
				$last_max_date_query = sprintf("call sp_getMaxTradingDate_HNStockInfo('%s')", $max_date); 	
				$ret_2 = $mdb2->extended->getRow($last_max_date_query); 
				$conn->close_connection(); 
	
				$last_max_date = $ret_2["last_max_trading_date"];
				if ($max_date != $current_date) 
					$this->trading_date = $max_date; 
				elseif ($current_time < "08:10:00") 
					$this->trading_date = $last_max_date; 
				else 
					$this->trading_date = $current_date; 

				$_SESSION['hn_trading_time'] = $this->trading_date;
			}
			else 
				$this->trading_date = $_SESSION['hn_trading_time']; 
		}
	}
	
	function getTradingDate() {
		return $this->trading_date;
	}
	
	function get_hcm_security($pattern=NULL) {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		$current_time = strtotime(date("H:i:s"));
		$session = $this->get_hcm_trading_session(); 
		if ($pattern == NULL)
			$query = sprintf("call sp_current_security('%s')", $this->trading_date);			
		else 
			$query = sprintf("call sp_current_security_filter('%s', \"(%s)\");", $this->trading_date, $pattern); 
			
		$result = $mdb2->extended->getAll($query); 		
		$conn->close_connection(); 
		$size = sizeof($result); 
		for($i=0; $i<$size; $i++) {
			if ($this->trading_date < date("Y-m-d")) {
				// close price
				$result[$i]["last_price"] = $result[$i]["last"]; 
				if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
					$result[$i]["last_change"] = $result[$i]["last"] - $result[$i]["priorcloseprice"]; 
				$result[$i]["last_volume"] = $result[$i]["lastvol"]; 			 		
			}
			else {
				if ($session === "1") {
						// pre open price 
						$result[$i]["last_price"] = $result[$i]["projectopen"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["projectopen"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = ""; 				
				}
				else if ($session === "2") {
						// open price + last price
						$result[$i]["last_price"] = $result[$i]["last"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["last"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = $result[$i]["lastvol"]; 				
				}
				else if ($session === "3") {
						// pre close price
						$result[$i]["last_price"] = $result[$i]["projectopen"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["projectopen"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = ""; 							
				}
				else {				
						// close price
						$result[$i]["last_price"] = $result[$i]["last"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["last"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = $result[$i]["lastvol"]; 			 				
				}
				/*
				switch($session) {
					case "1": 
						// pre open price 
						$result[$i]["last_price"] = $result[$i]["projectopen"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["projectopen"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = ""; 
						break; 
					case "2": 
						// open price + last price
						$result[$i]["last_price"] = $result[$i]["last"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["last"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = $result[$i]["lastvol"]; 
						break; 
					case "3": 
						// pre close price
						$result[$i]["last_price"] = $result[$i]["projectopen"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["projectopen"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = ""; 			
						break; 
					case "0": 
					case "4": 
					case "5": 
					default:
						// close price
						$result[$i]["last_price"] = $result[$i]["last"]; 
						if ($result[$i]["last_price"] != NULL && $result[$i]["last_price"] != "" && $result[$i]["last_price"] != 0)
							$result[$i]["last_change"] = $result[$i]["last"] - $result[$i]["priorcloseprice"]; 
						$result[$i]["last_volume"] = $result[$i]["lastvol"]; 			 
						break;
				}	
				*/	
			}
			$result[$i]["change"] = $result[$i]["last_change"]; 
		}		
		return $result; 
	}
	
	function get_hcm_trading_time() {
		$trading_time = array();
		$trading_time["date"] = $this->trading_date;
		$trading_time["time"] = date("H:i:s"); 

		return $trading_time; 
	}
	
	function get_hcm_trading_session() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 

		$query = sprintf("call sp_getSession_MarketStat('%s')", $this->trading_date);
		$result = $mdb2->extended->getRow($query); 
		$conn->close_connection(); 
		
		return $result['session']; 
	}
	
	function get_hcm_put_ad() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		
		$query = sprintf("call sp_hcm_ad('%s');", $this->trading_date);
		$result = $mdb2->extended->getAll($query); 
		$conn->close_connection(); 
		
		return $result; 	
	}
	
	function get_hcm_put_exec() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		
		$query = sprintf("call sp_hcm_exec('%s');", $this->trading_date);
		$result = $mdb2->extended->getAll($query); 
		$conn->close_connection(); 
		
		return $result; 		
	}

	function get_hcm_total_market() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		
		$query = sprintf("call sp_GetTotalMarket('%s')", $this->trading_date);
		$result = $mdb2->extended->getRow($query); 
		$conn->close_connection(); 
		
		return $result; 
	}

	function get_hcm_stock_list() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		
		$query = sprintf("call sp_getStockSymbolList('%s', %u)", $this->trading_date, 1);
		$result = $mdb2->extended->getAll($query); 
 
		$conn->close_connection(); 
		
		return $result; 
	}
			
	function get_hn_stock_list() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		
		$query = sprintf("call sp_getStockSymbolList('%s', %u)", $this->trading_date, 2);
		$result = $mdb2->extended->getAll($query); 
		$conn->close_connection(); 
		
		return $result; 
	}

	function get_hn_security($pattern = NULL) {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		$current_time = strtotime(date("H:i:s"));

		if ($pattern == NULL)
			$query = sprintf("call sp_HN_getCurrentStockInfo('%s')", $this->trading_date);			
		else 
			$query = sprintf("call sp_HN_getCurrStockInfo_Filter('%s', \"(%s)\");", $this->trading_date, $pattern);			

		$ret = $mdb2->extended->getAll($query); 		
		$conn->close_connection(); 
		$size = sizeof($ret); 
		for ($i=0; $i<$size; $i++)	{
			/**
			 * get change value depend of session time -- Khop lenh lien tuc
			 * 
			 */
				$result[$i]["stocksymbol"] = $ret[$i]["stockcode"]; 
				$result[$i]["priorcloseprice"] = $ret[$i]["basicprice"]/1000; 
				$result[$i]["ceiling"] = $ret[$i]["ceilingprice"]/1000; 
				$result[$i]["floor"] = $ret[$i]["floorprice"]/1000; 
				$result[$i]["best3bid"] = $ret[$i]["bordprice3"]/1000; 
				$result[$i]["best3bidvolume"] = $ret[$i]["bordqtty3"]; 
				$result[$i]["best2bid"] = $ret[$i]["bordprice2"]/1000; 
				$result[$i]["best2bidvolume"] = $ret[$i]["bordqtty2"]; 
				$result[$i]["best1bid"] = $ret[$i]["bordprice1"]/1000; 
				$result[$i]["best1bidvolume"] = $ret[$i]["bordqtty1"]; 
				$result[$i]["best3offer"] = $ret[$i]["sordprice3"]/1000; 
				$result[$i]["best3offervolume"] = $ret[$i]["sordqtty3"]; 
				$result[$i]["best3offer"] = $ret[$i]["sordprice3"]/1000; 
				$result[$i]["best3offervolume"] = $ret[$i]["sordqtty3"]; 
				$result[$i]["best3offer"] = $ret[$i]["sordprice3"]/1000; 
				$result[$i]["best3offervolume"] = $ret[$i]["sordqtty3"]; 
				$result[$i]["best2offer"] = $ret[$i]["sordprice2"]/1000; 
				$result[$i]["best2offervolume"] = $ret[$i]["sordqtty2"]; 
				$result[$i]["best1offer"] = $ret[$i]["sordprice1"]/1000; 
				$result[$i]["best1offervolume"] = $ret[$i]["sordqtty1"]; 			
				$result[$i]["last_price"] = $ret[$i]["matchprice"]/1000; 
				$result[$i]["last_volume"] = $ret[$i]["matchqtty"];
				if ($result[$i]["last_price"] == 0)
					$result[$i]["last_change"] = $result[$i]["change"] = 0; 								
				else  
					$result[$i]["last_change"] = $result[$i]["change"] = ($ret[$i]["matchprice"] - $ret[$i]["basicprice"])/1000; 								
				$result[$i]["fbuy"] = $ret[$i]["fbuy"];
				$result[$i]["fsell"] = $ret[$i]["fsell"];
				$result[$i]["currentroom"] = $ret[$i]["remainforeignqtty"];
				$result[$i]["securityname"] = $ret[$i]["securityname"];
				$result[$i]["totaltradingquantity"] = $ret[$i]["nmtotaltradedqtty"];
				$result[$i]["highestprice"] = $ret[$i]["highestprice"]/1000;
				$result[$i]["lowestprice"] = $ret[$i]["lowestprice"]/1000;
		}

		return $result; 
	}
		
	function get_hn_total_market() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS); 
		$current_time = strtotime(date("H:i:s"));

		$query = sprintf("call sp_HN_getCurrentMarketInfo('%s')", $this->trading_date);
		$ret = $mdb2->extended->getRow($query); 		
		$conn->close_connection(); 

		return $ret; 	
	} 
}
?>
