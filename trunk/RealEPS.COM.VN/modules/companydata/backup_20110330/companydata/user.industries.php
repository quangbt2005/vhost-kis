<?php
function industries_user_main(){
	//Kiem tra co du lieu hay khong
	//Kiem tra trong database table log 
	//Neu het han cap nhap thi feed services
	$db=_db('stockbiz');
	$db->query('SELECT * FROM _prefix_sector');
	if ($result = $db->fetchAll()){
		for ($i=0; $i<count($result); $i++){
			//Lay cac linh vu thuoc nghanh
			$db->query('SELECT * FROM _prefix_industry WHERE SectorId=' . $result[$i]['SectorId']);
			$result[$i]['Industries'] = $db->fetchAll();
			if ($i < count($result) / 2)
				$data['sector_col1'][] = $result[$i];
			else
				$data['sector_col2'][] = $result[$i];
		}
		return $data;
	}
}

function industries_user_news(){
	$db=_db('stockbiz');
	$data = array();
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
		
		
		//{Lay cac tin doanh nghiep cua nganh
		$db1 = _db();
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND sectorid=' . $sectorId .' ORDER BY news_created DESC LIMIT 0,20');
		if ($result = $db1->fetchAll()){
			$data['newsgroup3'] = $result;
			$data['newsgroup3_totalpage'] = ceil($db1->total_last_limit_query()/20);
		}
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
		
		//{Lay thong tin tai chinh cua cac nganh nghe
		$db->query('SELECT * FROM _prefix_lastestfinancialratios WHERE IndustryId='.$industryId);
		if ($result=$db->fetch()) $data['obj_ratios'] = $result;
		//}
		
		//{Lay cac tin doanh nghiep cua nganh
		$db1 = _db();
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND industryid=' . $industryId .' ORDER BY news_created DESC LIMIT 0,20');
		if ($result = $db1->fetchAll()){
			$data['newsgroup3'] = $result;
			$data['newsgroup3_totalpage'] = ceil($db1->total_last_limit_query()/20);
		}
		//}
		
		$data['display'] = 'industry';
	}
	//{Lay cac tin thi truong cua nganh
	$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=6 AND is_category=0 ORDER BY news_created DESC LIMIT 0,20');
	if ($result = $db1->fetchAll()){
		$data['newsgroup5'] = $result;
		$data['newsgroup5_totalpage'] = ceil($db1->total_last_limit_query()/20);
	}
	//}
	//{Lay cac tin kinh te cua nganh
	$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=3 AND is_category=0 ORDER BY news_created DESC LIMIT 0,20');
	if ($result = $db1->fetchAll()){
		$data['newsgroup2'] = $result;
		$data['newsgroup2_totalpage'] = ceil($db1->total_last_limit_query()/20);
	}
	//}
	return $data;
}

function industries_user_overview(){
	$db=_db('stockbiz');
	$data = array();
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
		//{Lay thong tin tai chinh cua cac nganh nghe
		$db->query('SELECT * FROM lastestfinancialratios WHERE SectorID='.$sectorId);
		if ($result=$db->fetch()) $data['obj_ratios'] = $result;
		//}
		//{Lay cac tin doanh nghiep cua nganh
		$db1 = _db();
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND sectorid=' . $sectorId .' ORDER BY news_created DESC LIMIT 0,10');
		if ($result = $db1->fetchAll()){
			$data['newsgroup3'] = $result;
			$data['newsgroup3_totalpage'] = ceil($db1->total_last_limit_query()/10);
		}
		//}
		//{{{THONG TIN TAI CHINH
		$db->query('SELECT SQL_CALC_FOUND_ROWS 
		c.Symbol, CompanyName, 
		MarketCapitalization/1000000000 AS MarketCapitalization,
		Equity_MRQ/1000000000 AS Equity_MRQ,
		TotalAssets_MRQ/1000000000 AS TotalAssets_MRQ,
		BasicPE_TTM,PS_MRQ,PB_MRQ,Sales_TTM/1000000000 AS Sales_TTM,Sales_LFY / 1000000000 AS Sales_LFY,
		ProfitAfterTax_LFY/1000000000 AS ProfitAfterTax_LFY, ProfitAfterTax_TTM/1000000000 AS ProfitAfterTax_TTM  
		FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f WHERE c.Symbol=f.Symbol AND c.IndustryID IN
		(SELECT IndustryID FROM _prefix_industry WHERE SectorId='.$sectorId.') LIMIT 0,15');
		echo $db->error();
		if ($result = $db->fetchAll()){
			$data['company_totalpage'] = ceil($db->total_last_limit_query()/10);
			$data['company'] = $result;
		}
		//}}}
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
		//{Lay thong tin tai chinh cua cac nganh nghe
		$db->query('SELECT * FROM _prefix_lastestfinancialratios WHERE IndustryId='.$industryId);
		if ($result=$db->fetch()) $data['obj_ratios'] = $result;
		//}
		//{Lay cac tin doanh nghiep cua nganh
		$db1 = _db();
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND industryid=' . $industryId .' ORDER BY news_created DESC LIMIT 0,10');		
		if ($result = $db1->fetchAll()){
		 
			$data['newsgroup3'] = $result;
			$data['newsgroup3_totalpage'] = ceil($db1->total_last_limit_query()/10);
		}
		//}
		
		//{{{THONG TIN TAI CHINH
		$db->query('SELECT SQL_CALC_FOUND_ROWS 
		c.Symbol, CompanyName, 
		MarketCapitalization/1000000000 AS MarketCapitalization,
		Equity_MRQ/1000000000 AS Equity_MRQ,
		TotalAssets_MRQ/1000000000 AS TotalAssets_MRQ,
		BasicPE_TTM,PS_MRQ,PB_MRQ,Sales_TTM/1000000000 AS Sales_TTM,Sales_LFY / 1000000000 AS Sales_LFY,
		ProfitAfterTax_LFY/1000000000 AS ProfitAfterTax_LFY, ProfitAfterTax_TTM/1000000000 AS ProfitAfterTax_TTM  
		FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f WHERE c.Symbol=f.Symbol AND c.IndustryID=' . $industryId. ' LIMIT 0,15');
		
		if ($result = $db->fetchAll()){
			$data['company_totalpage'] = ceil($db->total_last_limit_query()/10);
			$data['company'] = $result;
		}
		//}}}
		
		$data['display'] = 'industry';
	}
	//{Lay cac tin thi truong cua nganh
	$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=6 AND is_category=0 ORDER BY news_created DESC LIMIT 0,10');
	if ($result = $db1->fetchAll()){
		$data['newsgroup5'] = $result;
		$data['newsgroup5_totalpage'] = ceil($db1->total_last_limit_query()/10);
	}
	//}
	//{Lay cac tin kinh te cua nganh
	$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=3 AND is_category=0 ORDER BY news_created DESC LIMIT 0,10');
	if ($result = $db1->fetchAll()){
		$data['newsgroup2'] = $result;
		$data['newsgroup2_totalpage'] = ceil($db1->total_last_limit_query()/10);
	}
	//}
	$data['chart_today'] = date("Y-m-d");
	$data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime("now"))-6  , date("d",strtotime("now")), date("Y",strtotime("now"))));
	return $data;
}
//{{{ TIN THI TRUONG
function industries_ajax_newsgroup5(){
	if (isset($_GET['p'])){
		$resultPerPage=10;
		if (isset($_GET['view']) && $_GET['view']=='news') $resultPerPage=20;
		$page = $_GET['p'];
		$start = $page * $resultPerPage;
		$db = _db();
		$db->prepare('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=6 AND is_category=0 ORDER BY news_created DESC LIMIT :OFFSET,'.$resultPerPage);
		$db->bindValue(':OFFSET', $start, PARAM_INT);
		$db->execute();
		
		if ($result = $db->fetchAll()){
			for ($i=0;$i <count($result);$i++) $result[$i]['news_created'] = _format_date($result[$i]['news_created']);
			return json_encode($result);
		}
	}
	return json_encode(false);
}
//}}}
//{{{ TIN DOANH NGHIEP
function industries_ajax_newsgroup3(){
	if (isset($_GET['p']) && (isset($_GET['sector']) || isset($_GET['industry']))){
		$resultPerPage=10;
		if (isset($_GET['view']) && $_GET['view']=='news') $resultPerPage=20;
		
		$page = $_GET['p'];
		$start = $page * $resultPerPage;

		$db = _db();
		if (isset($_GET['sector'])){
			$db->prepare('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND sectorid=:SECTORID ORDER BY news_created DESC LIMIT :OFFSET,'.$resultPerPage);
			$db->bindValue(':SECTORID', $_GET['sector'], PARAM_INT);
		}else{
			$db->prepare('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND industryid=:INDUSTRYID ORDER BY news_created DESC LIMIT :OFFSET,'.$resultPerPage);
			$db->bindValue(':INDUSTRYID', $_GET['industry'], PARAM_INT);
		}
		$db->bindValue(':OFFSET', $start, PARAM_INT);
		$db->execute();
		
		if ($result = $db->fetchAll()){
			for ($i=0;$i <count($result);$i++) $result[$i]['news_created'] = _format_date($result[$i]['news_created']);
			return json_encode($result);
		}
	}
	return json_encode(false);
}
//}}}
//{{{ TIN KINH TE
function industries_ajax_newsgroup2(){
	if (isset($_GET['p'])){
		$resultPerPage=10;
		if (isset($_GET['view']) && $_GET['view']=='news') $resultPerPage=20;
		$page = $_GET['p'];
		$start = $page * $resultPerPage;
		$db = _db();
		$db->prepare('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=3 AND is_category=0 ORDER BY news_created DESC LIMIT :OFFSET,'.$resultPerPage);
		$db->bindValue(':OFFSET', $start, PARAM_INT);
		$db->execute();
		
		if ($result = $db->fetchAll()){
			for ($i=0;$i <count($result);$i++) $result[$i]['news_created'] = _format_date($result[$i]['news_created']);
			return json_encode($result);
		}
	}
	return json_encode(false);
}
//}}}
//{{{ QUY MO

function industries_ajax_quymo(){
	if (isset($_GET['p']) && (isset($_GET['sector']) || isset($_GET['industry']))){
		$page = $_GET['p'];
		$start = $page * 10;
		$db = _db('stockbiz');
		if (isset($_GET['sector'])){
			$db->prepare('SELECT SQL_CALC_FOUND_ROWS Symbol, CompanyName FROM _prefix_companyinfo WHERE IndustryID IN
			(SELECT IndustryID FROM _prefix_industry WHERE SectorId=:SECTORID) LIMIT :OFFSET,15');
			$db->bindValue(':SECTORID', $_GET['sector'], PARAM_INT);
		}else{
			$db->prepare('SELECT SQL_CALC_FOUND_ROWS Symbol, CompanyName FROM _prefix_companyinfo WHERE IndustryID=:INDUSTRYID LIMIT :OFFSET,15');
			$db->bindValue(':INDUSTRYID', $_GET['industry'], PARAM_INT);
		}
		$db->bindValue(':OFFSET', $start, PARAM_INT);
		$db->execute();
		if ($result = $db->fetchAll()){
			
			for ($i=0;$i<count($result);$i++){
				$db->query('SELECT MarketCapitalization/1000000000 AS MarketCapitalization,
							Equity_MRQ/1000000000 AS Equity_MRQ,
							TotalAssets_MRQ/1000000000 AS TotalAssets_MRQ,
							BasicPE_TTM,PS_MRQ,PB_MRQ,Sales_TTM/1000000000 AS Sales_TTM,Sales_LFY / 1000000000 AS Sales_LFY,
							ProfitAfterTax_LFY/1000000000 AS ProfitAfterTax_LFY, ProfitAfterTax_TTM/1000000000 AS ProfitAfterTax_TTM
							FROM _prefix_lastestfinancialratios WHERE Symbol=\'' . $result[$i]['Symbol'] . '\'');
				if ($obj=$db->fetch()){
					foreach($obj as $key=>$item) $obj[$key]=_num_format($obj[$key]);
					$result[$i]['ratios'] = $obj; 
				}
			}
			return json_encode($result);
		}
	}
	return json_encode(false);
}
//}}}

function industries_user_mod_layout(){
	return 'user.layout.tpl';
}
?>