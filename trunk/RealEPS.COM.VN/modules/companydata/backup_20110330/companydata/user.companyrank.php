<?php
function companyrank_user_main(){
	$db=_db('stockbiz');
	$data = array();
	$view=0;
	if (!empty($_GET['view'])) $view=intval($_GET['view']);
	
	if (!empty($_GET['sectorid'])){
		$sectorId = intval($_GET['sectorid']);
		//{Lay thong tin nganh
		$db->query('SELECT * FROM _prefix_sector WHERE SectorId=' . $sectorId);
		if ($result = $db->fetch()){
			//{Lay cac linh vuc thuoc nganh
			$db->query('SELECT * FROM _prefix_industry WHERE SectorId=' . $sectorId);
			$result['Industries'] = $db->fetchAll();
			//}
			$data['sector'] = $result;
		}
		//}
		//{Lay cac cong ty thuoc linh vuc
		$db->query('SELECT c.Symbol,CompanyName,LFY,Quarter,Year,MarketCapitalization/1000000000 AS MarketCapitalization,DilutedPE_LFY,DilutedPE_TTM FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
		WHERE c.Symbol=f.Symbol AND c.IndustryID IN (SELECT IndustryID FROM _prefix_industry WHERE SectorId='.$sectorId.')' );
		if ($result = $db->fetchAll()) $data['company'] = $result;
		//}
		$data['display'] = 'sector';
		
	}elseif (!empty($_GET['industryid'])){
		$industryId = intval($_GET['industryid']);
		//{Lay thong tin nganh
		$db->query('SELECT * FROM _prefix_industry WHERE IndustryId=' . $industryId);

		if ($result = $db->fetch()){
			//{Lay cac linh vuc thuoc nganh
			$db->query('SELECT * FROM _prefix_sector WHERE SectorId=' . $result['SectorId']);
			$data['sector'] = $db->fetch();
			//}
			$data['industry'] = $result;
		}
		//}
		//{Lay cac cong ty thuoc nganh
		$db->query('SELECT c.Symbol,CompanyName,LFY,Quarter,Year,MarketCapitalization/1000000000 AS MarketCapitalization,DilutedPE_LFY,DilutedPE_TTM FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
		WHERE c.Symbol=f.Symbol AND c.IndustryID=' . $industryId );

		if ($result = $db->fetchAll()) $data['company'] = $result;
		//}
		$data['display'] = 'industry';
	}
	$data['view']=$view;
	return $data;
}

function companyrank_user_mod_layout(){
	return 'user.layout.tpl';
}
?>