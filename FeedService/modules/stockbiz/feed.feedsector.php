<?php 
function feedsector_feed_main(){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass']);		
	if ($objs = _feed_stockbiz('GetSectors',$url,$params)){
		$db = _db('stockbiz');
		$objs = $objs['GetSectorsResult']['Sector'];
		$db->query('TRUNCATE TABLE _prefix_sector');
		for ($i=0; $i<count($objs);$i++){
			$sql=buildInsertSQL('_prefix_sector', $objs[$i]);
			$db->query($sql);
		}			
	}	
}
?>