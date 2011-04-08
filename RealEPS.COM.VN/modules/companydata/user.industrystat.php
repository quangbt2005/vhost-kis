<?php

function industrystat_user_main(){
	$data['view']=0;
	if (isset($_GET['view']) && $_GET['view'] >0) $data['view']=$_GET['view'];
	switch ($data['view']){
		case 0: showDinhgia($data);break;
		case 1: showSucmanh($data);break;
		case 2: showKhanang($data);break;	
		case 3: showSinhloi($data);break;	
		case 4: showHieuqua($data);break;
		case 5: showTangtruong($data);break;				
	}
	
	return $data;
}

function showTangtruong(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
					FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
    				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
    				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
    				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
    				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_TTM* 100 AS SalesGrowth_TTM, 
				SalesGrowth_LFY *100 AS SalesGrowth_LFY, ROA_LFY *100 AS ROA_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
				ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,TotalAssetsGrowth_MRQ *100 AS TotalAssetsGrowth_MRQ,
				TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
				DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM, DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	
	
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}

function showHieuqua(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
					FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,ROE_TTM*100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY, ROA_TTM *100 AS ROA_TTM, ROA_LFY *100 AS ROA_LFY
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	
	
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}

function showSinhloi(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY 
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY 
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY 
					FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY 
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
    				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
    				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY 
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,EBITMargin_TTM  * 100 AS EBITMargin_TTM ,
				EBITMargin_LFY*100 AS EBITMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,
				ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY  
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	
	
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}

function showKhanang(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
					FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	
	
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}

function showSucmanh(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
				TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
					TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
					TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
				TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
					TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,QuickRatio_MRQ,CurrentRatio_MRQ,InterestCoverageRatio_TTM,LTDebtOverEquity_MRQ,
				TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	echo $db->error();
	
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}


function showDinhgia(&$data){
	$db = _db('stockbiz');
	if (!empty($_GET['industryid'])){
		$industryid = intval($_GET['industryid']);
		//Lay cac nganh
		$db->query('SELECT s.SectorId,Name,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
				PS_TTM,PS_LFY,PB_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		
		if ($result = $db->fetchAll()){
			//Lay linh vuc ma nganh thuoc
			$db->query('SELECT SectorId FROM _prefix_industry WHERE IndustryId=' . $industryid);
			if ($result1 = $db->fetch()){
				//Xac dinh sector cua industry
				$sectorId = $result1['SectorId'];
				//Lay cac industry cua sector
				$db->query('SELECT i.IndustryId,Name,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
					PS_TTM,PS_LFY,PB_MRQ
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorId.'
					ORDER BY Name');
				if ($result2 = $db->fetchAll()){
					//Lay cac cong ty
					$db->query('SELECT CompanyName,c.Symbol,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
					PS_TTM,PS_LFY,PB_MRQ FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f
								WHERE f.Symbol=c.Symbol AND c.IndustryID=' . $industryid);
					if ($result3=$db->fetchAll()){
						//Xac dinh industry
						for ($i=0; $i<count($result2); $i++)
							if ($result2[$i]['IndustryId'] == $industryid)
								$result2[$i]['company']=$result3;
						//Gan industry vao trong sector
						for ($i=0; $i<count($result); $i++){
							if ($result[$i]['SectorId'] == $sectorId)
								$result[$i]['industry']=$result2;
						}
						$data['sector']=$result;
						return $data;
					}
				}
			}
		}
	}elseif (!empty($_GET['sectorid'])){
		$sectorid = intval($_GET['sectorid']);
		$db->query('SELECT s.SectorId,Name,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
				PS_TTM,PS_LFY,PB_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
		if ($result=$db->fetchAll()){
			for ($i=0; $i<count($result);$i++)
				if ($result[$i]['SectorId'] == $sectorid){
					$db->query('SELECT i.IndustryId,Name,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
					PS_TTM,PS_LFY,PB_MRQ
					FROM _prefix_industry i, _prefix_lastestfinancialratios f
					WHERE i. IndustryId = f.IndustryID AND i.SectorId='.$sectorid.'
					ORDER BY Name');
					if ($result1=$db->fetchAll()) $result[$i]['industry']=$result1;
				}
			$data['sector'] = $result;
			return $data;
		}

	}

	$db->query('SELECT s.SectorId,Name,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,DilutedPE_LFY,
				PS_TTM,PS_LFY,PB_MRQ
				FROM _prefix_sector s, _prefix_lastestfinancialratios f
				WHERE f.SectorID = s.SectorId
				ORDER BY Name');
	if ($result=$db->fetchAll()) $data['sector'] = $result;
	return $data;
}


function industrystat_user_mod_layout(){
	return 'user.layout.tpl';
}
?>