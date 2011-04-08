<?php
function buildParams(&$params,$name, $value){    
    $params .= '&' . $name . '=' . $value;
}
function buildIndustryWhere($data){    
    if (isset($data['industry'])){ 
        $sql = '';              
        for ($i=0; $i<count($data['industry']); $i++){
            if ($sql == '') $sql = 'SectorId=' . intval($data['industry'][$i]);
            else $sql .= ' OR SectorId=' . intval($data['industry'][$i]); 
        }
        return ' AND c.IndustryID IN (SELECT IndustryID FROM industry WHERE '.$sql.')';
    }
    
}
function buildSeWhere($data){
    if (isset($data['se'])){
        $sql = '';
        if ($data['se'] == 1) $sql= ' AND (Bourse = "HOSE" OR Bourse="HOSTC")';        
		elseif ($data['se'] == 2) $sql = ' AND (Bourse="HASE" OR Bourse="HASTC")';
		elseif ($data['se'] == 3) $sql = ' AND Bourse="UPCOM"'; 
		return $sql;        
    }    
}

function company_user_main(){
    $data['view']=0;
    $data['pagingParams'] = '';
	if (isset($_GET['view']))$data['view']=intval($_GET['view']);
	    	    	
	if (isset($_GET['se'])){ 
	    $data['se'] = intval($_GET['se']);
	    buildParams($data['pagingParams'], 'se', $data['se']);	    
	}
	if (isset($_GET['industry'])){	    
	    $data['industry'] = explode(',',$_GET['industry']);	    
	    buildParams($data['pagingParams'], 'industry', $_GET['industry']);
	}
	$data['orderby'] = 'c.Symbol';
	if (isset($_GET['orderby'])){	    
	    $data['orderby'] = $_GET['orderby'];
	    buildParams($data['pagingParams'], 'orderby', $data['orderby']);
	}	
	$data['ordertype'] = 'ASC';
	if (isset($_GET['ordertype'])){	    
	    $data['ordertype'] = intval($_GET['ordertype']);
	    if ($data['ordertype'] == 0) $data['ordertype'] = 'ASC';
	    else $data['ordertype'] = 'DESC';	     
	    buildParams($data['pagingParams'], 'ordertype', $data['ordertype']);
	}
	$data['limit'] = 25;
	if (isset($_GET['limit'])){
	    $data['limit'] = intval($_GET['limit']);
	    if ($data['limit'] == 0) $data['limit'] = 25;
	    buildParams($data['pagingParams'], 'limit', $data['limit']);	    
	}
	$data['alphabet'] = '';
	if (isset($_GET['alphabet'])){
	    $data['alphabet'] = $_GET['alphabet'];
	    buildParams($data['pagingParams'], 'alphabet', $data['alphabet']);
	}	
	switch ($data['view']){
	    case 0: showTongquan($data);break;
	    case 1: showHomnay($data);break;
	    case 2: showBiendong($data);break;
	    case 3: showThongke($data);break;
	    case 4: showDinhgia($data);break;
	    case 5: showTangTruong($data);break;
	}	
	return $data;
}
function showTangTruong(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $_GET['view'] . $data['pagingParams'];
	$db=_db('stockbiz');	
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName, LFY, Year,Quarter,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,
    SalesGrowth_TTM*100 AS  SalesGrowth_TTM,SalesGrowth_LFY*100 AS SalesGrowth_LFY,ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,
    ProfitGrowth_TTM*100 AS ProfitGrowth_TTM, ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,
    DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM,DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%"'.$whereIndustry.$whereSe. '
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		
}
function showDinhgia(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $_GET['view'] . $data['pagingParams'];
	$db=_db('stockbiz');
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName, LFY, Year,Quarter,BasicPE_TTM,BasicPE_LFY,DilutedPE_TTM,
    DilutedPE_LFY,PS_TTM,PS_LFY,PB_MRQ
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%"'.$whereIndustry.$whereSe.'
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan
	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		
    
}
function showThongke(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $_GET['view'] . $data['pagingParams'];
	$db=_db('stockbiz');
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName, MarketCapitalization/1000000000 AS MarketCapitalization,
    Equity_MRQ/1000000000 AS Equity_MRQ, TotalAssets_MRQ/1000000000 AS TotalAssets_MRQ, ProfitAfterTax_TTM/1000000000 AS ProfitAfterTax_TTM,
    DilutedPE_TTM,ROE_TTM,ROA_TTM
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%"'.$whereIndustry.$whereSe.'
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan
	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		
    
}
function showBiendong(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $_GET['view'] . $data['pagingParams'];
	$db=_db('stockbiz');
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName,High52WkPrice/1000 AS High52WkPrice,Low52WkPrice/1000 AS Low52WkPrice,
    AvgVolume10d/1000 AS AvgVolume10d
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%" '.$whereIndustry.$whereSe.'
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan
	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		
    
}
function showHomnay(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $_GET['view'] . $data['pagingParams'];
	$db=_db('stockbiz');
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName,High52WkPrice/1000 AS High52WkPrice,Low52WkPrice/1000 AS Low52WkPrice,
    AvgVolume10d/1000 AS AvgVolume10d
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%" '.$whereIndustry.$whereSe.'
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan
	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		
    
}
function showTongquan(&$data){
    $result_per_page = $data['limit'];
    $whereIndustry = buildIndustryWhere($data);
    $whereSe = buildSeWhere($data);
    $paging = new Paging( 'p', $result_per_page, 0, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';
	$paging->sPageEllipsisClass = 'dotdot';
	$paging->customlink='/doanh-nghiep/cong-ty/index.html?view=' . $data['view'] . $data['pagingParams'];
	$db=_db('stockbiz');
    $db->prepare('SELECT SQL_CALC_FOUND_ROWS c.Symbol, CompanyName,LFY,Quarter,Year,MarketCapitalization/1000000000 AS MarketCapitalization,DilutedPE_TTM,
    DilutedPE_LFY
    FROM _prefix_companyinfo c, _prefix_lastestfinancialratios f    
    WHERE c.Symbol=f.Symbol AND c.Symbol LIKE ":ALPHABET%" '.$whereIndustry.$whereSe.'
    ORDER BY :ORDERBY :ORDERTYPE
    LIMIT :OFFSET, :TOTAL');
    $db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', $result_per_page, PARAM_INT );
	$db->bindValue( ':ALPHABET', $data['alphabet'], PARAM_NONE );
	$db->bindValue( ':ORDERBY', $data['orderby'], PARAM_NONE);
	$db->bindValue( ':ORDERTYPE', $data['ordertype'], PARAM_NONE);
	
	$db->execute();
	if ( $symbols = $db->fetchAll() ){
	    //Lay thong tin chung khoan
	    
		$data[ 'symbols' ] = $symbols;
		$paging->nTotalRow = $db->total_last_limit_query();
		$data[ 'paging' ] = $paging;
	}		

}
function company_user_mod_layout(){
	return 'user.layout.tpl';
}
?>