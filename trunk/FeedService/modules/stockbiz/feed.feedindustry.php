<?php 
function feedIndustryBySector($sectorId){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'sectorID' => $sectorId);
	if ($objs = _feed_stockbiz('GetIndustries',$url,$params)){
		$db = _db('stockbiz');
		$objs = $objs['GetIndustriesResult']['Industry'];
		//Xoa nhung industry co hien tai, de du lieu luon tuoi
		$db->query('DELETE FROM _prefix_industry WHERE SectorId='.$sectorId);
		for ($i=0; $i<count($objs);$i++){
			$sql=buildInsertSQL('_prefix_industry', $objs[$i]);
			$db->query($sql);
		}			
	}	
}
function feedindustry_feed_main(){
	$db=_db('stockbiz');
	$db->query('SELECT SectorId FROM _prefix_sector');
	$objs = $db->fetchAll();
	for ($i=0; $i<count($objs);$i++) feedIndustryBySector($objs[$i]['SectorId']);
}
?>