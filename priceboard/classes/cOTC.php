<?php
class OTC {

	function list_otc() {
		$conn = &new DB(); 
		$mdb2 = $conn->open_connection(DB_DNS_OTC);
		
		$query = sprintf("call Sp_OTC_Ads_get(1)"); 
		
		$result = $mdb2->extended->getAll($query);
		
		return $result; 
	}
}
?>