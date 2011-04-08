<?php 
function feedsymbol_feed_main(){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass']);		
	if ($objs = _feed_stockbiz('GetSymbolList',$url,$params)){
		$db = _db('stockbiz');
		$objs = $objs['GetSymbolListResult']['SymbolItem'];
		$db->query('TRUNCATE TABLE _prefix_symbol');
		for ($i=0; $i<count($objs);$i++){
			$sql=buildInsertSQL('_prefix_symbol', $objs[$i]);
			$db->query($sql);
		}			
	}	
}
//{{{ COMPANY INFO
function feedCompanyInfo($symbol){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol);		
	if ($objs = _feed_stockbiz('GetCompanyInfo',$url,$params)){

		$db = _db('stockbiz');
		$objs = $objs['GetCompanyInfoResult'];
		$db->query('DELETE FROM _prefix_companyinfo WHERE Symbol="'.$symbol.'"');
		$sql=buildInsertSQL('_prefix_companyinfo', $objs);

		$db->query($sql);	
	}	
}
function feedsymbol_feed_companyinfo(){
	$db=_db('stockbiz');
	$db->query('SELECT Symbol FROM _prefix_symbol');
	$objs = $db->fetchAll();
	for ($i=0;$i<count($objs);$i++) feedCompanyInfo($objs[$i]['Symbol']);
}
//}}}
//{{{ BAN LANH DAO DOANH NGHIEP
function feedCompanyOfficer($symbol){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol);		
	
	if ($objs = _feed_stockbiz('GetCompanyOfficers',$url,$params)){
		if (!empty($objs['GetCompanyOfficersResult'])){
			$db=_db('stockbiz');
			$db->query('DELETE FROM _prefix_companyofficer WHERE Symbol="'.$symbol.'"');
			if (!isset($objs['GetCompanyOfficersResult']['CompanyOfficer'][0])){
				$objs['GetCompanyOfficersResult']['CompanyOfficer']['Symbol'] = $symbol;
				$sql=buildInsertSQL('_prefix_companyofficer', $objs['GetCompanyOfficersResult']['CompanyOfficer']);
				$db->query($sql);	
			}else{
				$objs = $objs['GetCompanyOfficersResult']['CompanyOfficer'];
				for ($i=0; $i<count($objs);$i++){
					$objs[$i]['Symbol'] = $symbol;
					$sql=buildInsertSQL('_prefix_companyofficer', $objs[$i]);
					$db->query($sql);	
				}	
			}
		}
	}
}
function feedsymbol_feed_companyofficer(){
	$db=_db('stockbiz');
	$db->query('SELECT Symbol FROM _prefix_symbol');
	$objs = $db->fetchAll();
	for ($i=0;$i<count($objs);$i++) feedCompanyOfficer($objs[$i]['Symbol']);
} 
//}}}
//{{{ CO DONG CHINH DOANH NGHIEP
function feedMajorHolder($symbol){
	global $_configs;
	$url = 'http://datafeed.stockbiz.vn/CompanyService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol);		
	if ($objs = _feed_stockbiz('GetMajorHolders',$url,$params)){	    
		if (!empty($objs['GetMajorHoldersResult'])){
			$db = _db('stockbiz');
			$db->query('DELETE FROM _prefix_majorholder WHERE Symbol="'.$symbol.'"');

			if (!isset($objs['GetMajorHoldersResult']['MajorHolder'][0])){
				$objs['GetMajorHoldersResult']['MajorHolder']['Symbol'] = $symbol;
				$sql=buildInsertSQL('_prefix_majorholder', $objs['GetMajorHoldersResult']['MajorHolder']);
				$db->query($sql);	
			}else{
				$objs = $objs['GetMajorHoldersResult']['MajorHolder'];
				for ($i=0; $i<count($objs);$i++){
					$objs[$i]['Symbol'] = $symbol;
					$sql=buildInsertSQL('_prefix_majorholder', $objs[$i]);
					$db->query($sql);	
				}	
			}
		}
	}else{
	    die();
	}
}
function feedsymbol_feed_majorholder(){
	$db=_db('stockbiz');
	$db->query('SELECT Symbol FROM _prefix_symbol');
	$objs = $db->fetchAll();
	for ($i=0;$i<count($objs);$i++){
		feedMajorHolder($objs[$i]['Symbol']);
	}
} 
//}}}
?>