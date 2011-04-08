<?php


function companydetail_ajax_clearhistory(){
    unset($_SESSION['history_symbol']);
    setcookie('history_symbol', null);
}
function trackSymbol($symbol){       
	
    $history = array();

    if (!empty($_COOKIE['history_symbol']))      
        $history = json_decode($_COOKIE['history_symbol']);
   
    if (!is_array($history)) $history = array();

    if (!in_array($symbol, $history)) $history[] = $symbol;
    
   
    if (!empty($history)){        
        $json = json_encode($history);
        setcookie('history_symbol', $json, time() + 60 * 60 * 24, '/');
        $_SESSION['history_symbol'] = $history;
    }

}
function companydetail_user_ratios(){ 
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName,IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    Quarter,Year,
    DilutedPE_TTM,High52WkDilutedPE,High52WkDilutedPEDate,Low52WkDilutedPE,BasicPE_TTM,High52WkBasicPEDate,High52WkBasicPE,  
    Low52WkBasicPEDate,Low52WkBasicPE,PB_MRQ,PS_TTM, 
    SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_MRQ2 * 100 AS SalesGrowth_MRQ2,SalesGrowth_TTM * 100 AS SalesGrowth_TTM,SalesGrowth_LFY*100 AS SalesGrowth_LFY,SalesGrowth_03Yr*100 AS SalesGrowth_03Yr,
    ProfitGrowth_MRQ * 100 AS ProfitGrowth_MRQ,ProfitGrowth_MRQ2 * 100 AS ProfitGrowth_MRQ2,ProfitGrowth_TTM * 100 AS ProfitGrowth_TTM,ProfitGrowth_LFY * 100 AS ProfitGrowth_LFY,ProfitGrowth_03Yr*100 AS ProfitGrowth_03Yr,
    BasicEPSGrowth_03Yr*100 AS BasicEPSGrowth_03Yr,
    BasicEPSGrowth_MRQ * 100 AS BasicEPSGrowth_MRQ,BasicEPSGrowth_MRQ2 * 100 AS BasicEPSGrowth_MRQ2,BasicEPSGrowth_TTM * 100 AS BasicEPSGrowth_TTM,BasicEPSGrowth_LFY * 100 AS BasicEPSGrowth_LFY,
    DilutedEPSGrowth_MRQ * 100 AS DilutedEPSGrowth_MRQ,DilutedEPSGrowth_MRQ2 * 100 AS DilutedEPSGrowth_MRQ2,DilutedEPSGrowth_TTM * 100 AS DilutedEPSGrowth_TTM,DilutedEPSGrowth_LFY * 100 AS DilutedEPSGrowth_LFY,DilutedEPSGrowth_03Yr * 100 AS DilutedEPSGrowth_03Yr,
    TotalAssetsGrowth_MRQ * 100 AS TotalAssetsGrowth_MRQ,TotalAssetsGrowth_MRQ2 * 100 AS TotalAssetsGrowth_MRQ2,TotalAssetsGrowth_TTM * 100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY * 100 AS TotalAssetsGrowth_LFY,
    DividendGrowth_MRQ * 100 AS DividendGrowth_MRQ,DividendGrowth_MRQ2 * 100 AS DividendGrowth_MRQ2,DividendGrowth_TTM * 100 AS DividendGrowth_TTM,DividendGrowth_LFY * 100 AS DividendGrowth_LFY,
    LTDebtOverEquity_MRQ,TotalDebtOverEquity_MRQ,InterestCoverageRatio_TTM,GrossMargin_TTM*100 AS GrossMargin_TTM, GrossMargin_LFY * 100 AS GrossMargin_LFY,GrossMargin_03Yr*100 AS GrossMargin_03Yr,
    EBITMargin_TTM*100 AS EBITMargin_TTM,EBITMargin_LFY * 100 AS EBITMargin_LFY,EBITMargin_03Yr * 100 AS EBITMargin_03Yr,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,OperatingMargin_03Yr*100 AS OperatingMargin_03Yr,
    s.Name AS SectorName, s.SectorId,
    PreTaxMargin_TTM*100 AS PreTaxMargin_TTM,PreTaxMargin_LFY*100 AS PreTaxMargin_LFY,PreTaxMargin_03Yr*100 AS PreTaxMargin_03Yr,
    ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY,ProfitMargin_03Yr*100 AS ProfitMargin_03Yr,
    ROA_TTM * 100 AS ROA_TTM, ROA_LFY * 100 AS ROA_LFY,ROA_03YrAvg * 100 AS ROA_03YrAvg,
    ROE_TTM * 100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY,ROE_03YrAvg * 100 AS ROE_03YrAvg,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM,AssetsTurnover_TTM        
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();
    
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $sectorId = $result['SectorId'];
        $industryId = $result['IndustryID'];
        $db->query('SELECT DilutedPE_TTM,High52WkDilutedPE,Low52WkDilutedPE,BasicPE_TTM,PS_TTM,
        High52WkBasicPEDate,High52WkBasicPE,Low52WkBasicPEDate,Low52WkBasicPE,PB_MRQ,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,
        SalesGrowth_MRQ2*100 AS SalesGrowth_MRQ2,SalesGrowth_TTM*100 AS SalesGrowth_TTM,SalesGrowth_LFY,SalesGrowth_03Yr,SalesGrowth_03Yr*100 AS SalesGrowth_03Yr,
        ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,ProfitGrowth_MRQ2*100 AS ProfitGrowth_MRQ2,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,ProfitGrowth_03Yr*100 AS ProfitGrowth_03Yr,ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,
        BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,BasicEPSGrowth_MRQ2*100 AS BasicEPSGrowth_MRQ2,BasicEPSGrowth_LFY*100 AS BasicEPSGrowth_LFY,BasicEPSGrowth_03Yr*100 AS BasicEPSGrowth_03Yr,BasicEPSGrowth_TTM*100 AS BasicEPSGrowth_TTM,
        DilutedEPSGrowth_MRQ*100 AS DilutedEPSGrowth_MRQ,DilutedEPSGrowth_MRQ2*100 AS DilutedEPSGrowth_MRQ2,DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY,DilutedEPSGrowth_03Yr*100 AS DilutedEPSGrowth_03Yr,DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM,
        QuickRatio_MRQ,CurrentRatio_MRQ,LTDebtOverEquity_MRQ,TotalDebtOverEquity_MRQ,InterestCoverageRatio_TTM,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,GrossMargin_03Yr*100 AS GrossMargin_03Yr,
        EBITMargin_TTM*100 AS EBITMargin_TTM,EBITMargin_LFY*100 AS EBITMargin_LFY,EBITMargin_03Yr * 100 AS EBITMargin_03Yr, OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,OperatingMargin_03Yr*100 AS OperatingMargin_03Yr,
        PreTaxMargin_TTM*100 AS PreTaxMargin_TTM,PreTaxMargin_LFY*100 AS PreTaxMargin_LFY,PreTaxMargin_03Yr*100 AS PreTaxMargin_03Yr,
        ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY,ProfitMargin_03Yr*100 AS ProfitMargin_03Yr,
        ROA_TTM * 100 AS ROA_TTM, ROA_LFY * 100 AS ROA_LFY,ROA_03YrAvg * 100 AS ROA_03YrAvg,
        ROE_TTM * 100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY,ROE_03YrAvg * 100 AS ROE_03YrAvg,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM,AssetsTurnover_TTM   
        FROM _prefix_lastestfinancialratios WHERE SectorID=' . $sectorId);
        $data['sector'] = $db->fetch();        
        $db->query('SELECT DilutedPE_TTM,High52WkDilutedPE,Low52WkDilutedPE,BasicPE_TTM,PS_TTM,
        High52WkBasicPEDate,High52WkBasicPE,Low52WkBasicPEDate,Low52WkBasicPE,PB_MRQ,SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,
        SalesGrowth_MRQ2*100 AS SalesGrowth_MRQ2,SalesGrowth_TTM*100 AS SalesGrowth_TTM,SalesGrowth_LFY,SalesGrowth_03Yr*100 AS SalesGrowth_03Yr,
        ProfitGrowth_MRQ*100 AS ProfitGrowth_MRQ,ProfitGrowth_MRQ2*100 AS ProfitGrowth_MRQ2,ProfitGrowth_LFY*100 AS ProfitGrowth_LFY,ProfitGrowth_03Yr*100 AS ProfitGrowth_03Yr,ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,
        BasicEPSGrowth_MRQ*100 AS BasicEPSGrowth_MRQ,BasicEPSGrowth_MRQ2*100 AS BasicEPSGrowth_MRQ2,BasicEPSGrowth_LFY*100 AS BasicEPSGrowth_LFY,BasicEPSGrowth_03Yr*100 AS BasicEPSGrowth_03Yr,BasicEPSGrowth_TTM*100 AS BasicEPSGrowth_TTM,
        DilutedEPSGrowth_MRQ*100 AS DilutedEPSGrowth_MRQ,DilutedEPSGrowth_MRQ2*100 AS DilutedEPSGrowth_MRQ2,DilutedEPSGrowth_LFY*100 AS DilutedEPSGrowth_LFY,DilutedEPSGrowth_03Yr*100 AS DilutedEPSGrowth_03Yr,DilutedEPSGrowth_TTM*100 AS DilutedEPSGrowth_TTM,
        QuickRatio_MRQ,CurrentRatio_MRQ,LTDebtOverEquity_MRQ,TotalDebtOverEquity_MRQ,InterestCoverageRatio_TTM,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,GrossMargin_03Yr*100 AS GrossMargin_03Yr,
        EBITMargin_TTM*100 AS EBITMargin_TTM,EBITMargin_LFY*100 AS EBITMargin_LFY,EBITMargin_03Yr * 100 AS EBITMargin_03Yr,OperatingMargin_TTM*100 AS OperatingMargin_TTM,OperatingMargin_LFY*100 AS OperatingMargin_LFY,OperatingMargin_03Yr*100 AS OperatingMargin_03Yr,  
        PreTaxMargin_TTM*100 AS PreTaxMargin_TTM,PreTaxMargin_LFY*100 AS PreTaxMargin_LFY,PreTaxMargin_03Yr*100 AS PreTaxMargin_03Yr,
        ProfitMargin_TTM*100 AS ProfitMargin_TTM,ProfitMargin_LFY*100 AS ProfitMargin_LFY,ProfitMargin_03Yr*100 AS ProfitMargin_03Yr,
        ROA_TTM * 100 AS ROA_TTM, ROA_LFY * 100 AS ROA_LFY,ROA_03YrAvg * 100 AS ROA_03YrAvg,
        ROE_TTM * 100 AS ROE_TTM, ROE_LFY * 100 AS ROE_LFY,ROE_03YrAvg * 100 AS ROE_03YrAvg,InventoryTurnover_TTM,ReceivablesTurnover_TTM,CurrentAssetsTurnover_TTM,AssetsTurnover_TTM  
        FROM _prefix_lastestfinancialratios WHERE IndustryID=' . $industryId);
        $data['industry'] = $db->fetch();        
        $data['company']=$result;      
          
        return $data;
    }      
   //_redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_keystatistics(){
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName,IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    SharesOutstanding / 1000000 AS SharesOutstanding, 
    TotalAssets_MRQ / 1000000000 AS TotalAssets_MRQ, TotalAssets_LFY / 1000000000 AS TotalAssets_LFY,
    Equity_MRQ / 1000000000 AS Equity_MRQ, Equity_LFY / 1000000000 AS Equity_LFY, 
    Sales_LFY / 1000000000 AS Sales_LFY, Sales_TTM / 1000000000 AS Sales_TTM,    
    ProfitAfterTax_LFY / 1000000000 AS ProfitAfterTax_LFY,ProfitAfterTax_TTM / 1000000000 AS ProfitAfterTax_TTM,    
    MarketCapitalization / 1000000000 AS MarketCapitalization,
    QuickRatio_MRQ,CurrentRatio_MRQ,
    TotalDebtOverEquity_TTM,TotalDebtOverEquity_MRQ,
    TotalDebtOverAssets_MRQ,
    DilutedPE_MRQ,DilutedPE_TTM, DilutedPE_LFY,
    PS_MRQ,PS_TTM,PS_LFY,
    BasicEPS_TTM, BasicEPS_LFY,
    GrossMargin_TTM * 100 AS GrossMargin_TTM, GrossMargin_LFY * 100 AS GrossMargin_LFY,
    OperatingMargin_TTM * 100 AS OperatingMargin_TTM, OperatingMargin_LFY * 100 AS OperatingMargin_LFY,
    EBITMargin_TTM * 100 AS EBITMargin_TTM, EBITMargin_LFY * 100 AS EBITMargin_LFY,
    ProfitMargin_TTM * 100 AS ProfitMargin_TTM, ProfitMargin_LFY * 100 AS ProfitMargin_LFY,
    ROA_TTM * 100 AS ROA_TTM, ROA_LFY * 100 AS ROA_LFY, ROE_LFY * 100 AS ROE_LFY, ROE_TTM * 100 AS ROE_TTM,    
    SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_MRQ2 * 100 AS SalesGrowth_MRQ2,SalesGrowth_TTM * 100 AS SalesGrowth_TTM,SalesGrowth_LFY*100 AS SalesGrowth_LFY,
    ProfitGrowth_MRQ * 100 AS ProfitGrowth_MRQ,ProfitGrowth_MRQ2 * 100 AS ProfitGrowth_MRQ2,ProfitGrowth_TTM * 100 AS ProfitGrowth_TTM,ProfitGrowth_LFY * 100 AS ProfitGrowth_LFY,
    BasicEPSGrowth_MRQ * 100 AS BasicEPSGrowth_MRQ,BasicEPSGrowth_MRQ2 * 100 AS BasicEPSGrowth_MRQ2,BasicEPSGrowth_TTM * 100 AS BasicEPSGrowth_TTM,BasicEPSGrowth_LFY * 100 AS BasicEPSGrowth_LFY,
    TotalAssetsGrowth_MRQ * 100 AS TotalAssetsGrowth_MRQ,TotalAssetsGrowth_MRQ2 * 100 AS TotalAssetsGrowth_MRQ2,TotalAssetsGrowth_TTM * 100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY * 100 AS TotalAssetsGrowth_LFY,
    PB_MRQ,DividendYield_LFY,PayoutRatio_LFY,AnnualDividend_LFY,AssetsTurnover_TTM,InventoryTurnover_TTM,ReceivablesTurnover_TTM,
    s.Name AS SectorName, s.SectorId    
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan		
        $data['company']=$result;        
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_financialhighlights(){ 
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName,IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    Quarter,Year,
    SalesGrowth_MRQ*100 AS SalesGrowth_MRQ,SalesGrowth_MRQ2 * 100 AS SalesGrowth_MRQ2,SalesGrowth_TTM * 100 AS SalesGrowth_TTM,SalesGrowth_LFY*100 AS SalesGrowth_LFY,
    ProfitGrowth_MRQ * 100 AS ProfitGrowth_MRQ,ProfitGrowth_MRQ2 * 100 AS ProfitGrowth_MRQ2,ProfitGrowth_TTM * 100 AS ProfitGrowth_TTM,ProfitGrowth_LFY * 100 AS ProfitGrowth_LFY,
    BasicEPSGrowth_MRQ * 100 AS BasicEPSGrowth_MRQ,BasicEPSGrowth_MRQ2 * 100 AS BasicEPSGrowth_MRQ2,BasicEPSGrowth_TTM * 100 AS BasicEPSGrowth_TTM,BasicEPSGrowth_LFY * 100 AS BasicEPSGrowth_LFY,
    DilutedEPSGrowth_MRQ * 100 AS DilutedEPSGrowth_MRQ,DilutedEPSGrowth_MRQ2 * 100 AS DilutedEPSGrowth_MRQ2,DilutedEPSGrowth_TTM * 100 AS DilutedEPSGrowth_TTM,DilutedEPSGrowth_LFY * 100 AS DilutedEPSGrowth_LFY,
    TotalAssetsGrowth_MRQ * 100 AS TotalAssetsGrowth_MRQ,TotalAssetsGrowth_MRQ2 * 100 AS TotalAssetsGrowth_MRQ2,TotalAssetsGrowth_TTM * 100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY * 100 AS TotalAssetsGrowth_LFY,
    DividendGrowth_MRQ * 100 AS DividendGrowth_MRQ,DividendGrowth_MRQ2 * 100 AS DividendGrowth_MRQ2,DividendGrowth_TTM * 100 AS DividendGrowth_TTM,DividendGrowth_LFY * 100 AS DividendGrowth_LFY,
    s.Name AS SectorName, s.SectorId    
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $db1 = _db();
        $db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=3 AND (news_title LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');
        
		if ($news = $db1->fetchAll()) $data['newsgroup3'] = $news;
		
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id<>3 AND (news_title LIKE "%' . $symbol .'%" OR content LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');
		
		if ($news = $db1->fetchAll()) $data['newsgroup'] = $news;
		
        $data['company']=$result; 
        $data['chart_today'] = date("Y-m-d");
        $data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime("now"))-6  , date("d",strtotime("now")), date("Y",strtotime("now"))));
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_companynews(){         
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName,IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    s.Name AS SectorName, s.SectorId
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $db1 = _db();
        $db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=3 AND (news_title LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');
        
		if ($news = $db1->fetchAll()) $data['newsgroup3'] = $news;
		
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id<>3 AND (news_title LIKE "%' . $symbol .'%" OR content LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');
		
		if ($news = $db1->fetchAll()) $data['newsgroup'] = $news;
		
        $data['company']=$result; 
        $data['chart_today'] = date("Y-m-d");
        $data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime("now"))-6  , date("d",strtotime("now")), date("Y",strtotime("now"))));
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_majorholder(){ 
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName,StateOwnership*100 AS StateOwnership,ForeignOwnership * 100 AS ForeignOwnership,OtherOwnership*100 AS OtherOwnership,   
    IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    s.Name AS SectorName, s.SectorId  
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $db->query('SELECT Name,Position,Shares,Ownership*100 AS Ownership,Reported FROM _prefix_majorholder WHERE Symbol="'.$symbol.'" ORDER BY Shares DESC');
        if ($officers = $db->fetchAll()) $data['officers'] = $officers;        
        $data['company']=$result;        
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_snapshot(){      
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName, Overview, HeadQuarters,WebAddress,Phone,Fax,Email,History,BusinessAreas,BusinessLicenseNumber,DateOfIssue,
    RegisteredCapital,TaxIDNumber,DateOfListing,ParValue,InitialListingPrice,ListingVolume,TotalListingValue,
    IF(Bourse="HASTC","HASE",Bourse) AS Bourse, c.IndustryID, i.Name AS IndustryName,
    s.Name AS SectorName, s.SectorId,Employees,Branches    
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $db->query('SELECT OfficerName, Position FROM _prefix_companyofficer WHERE Symbol="'.$symbol.'"');
        if ($officers = $db->fetchAll()) $data['officers'] = $officers;
        $data['company']=$result;        
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}
function companydetail_user_overview(){         
    $symbol = $_GET['symbol'];
    $db = _db('stockbiz');
    $db->prepare('SELECT c.Symbol, CompanyName, Overview, HeadQuarters,WebAddress,IF(Bourse="HASTC","HASE",Bourse) AS Bourse, IF(Bourse="HASTC",2,1) AS SeId, c.IndustryID, i.Name AS IndustryName,
    s.Name AS SectorName, s.SectorId,AvgVolume10d, MarketCapitalization /1000000000 AS MarketCapitalization, SharesOutstanding/1000000 AS SharesOutstanding,Employees,Branches,
    DilutedPE_LFY,DilutedPE_TTM,PS_TTM,PS_LFY,PS_MRQ,PB_MRQ,DilutedEPS_LFY,DilutedEPS_TTM,QuickRatio_MRQ,CurrentRatio_MRQ,TotalDebtOverEquity_MRQ,TotalDebtOverAssets_MRQ,
    AssetsTurnover_TTM,InventoryTurnover_TTM,GrossMargin_TTM*100 AS GrossMargin_TTM,GrossMargin_LFY*100 AS GrossMargin_LFY,OperatingMargin_TTM*100 AS OperatingMargin_TTM,
    OperatingMargin_LFY*100 AS OperatingMargin_LFY,EBITMargin_TTM*100 AS EBITMargin_TTM, EBITMargin_LFY*100 AS EBITMargin_LFY,ProfitMargin_TTM *100 AS ProfitMargin_TTM,
    ProfitMargin_LFY*100 AS ProfitMargin_LFY,ROA_TTM*100 AS ROA_TTM,ROA_LFY*100 AS ROA_LFY,ROE_LFY*100 AS ROE_LFY,ROE_TTM*100 AS ROE_TTM,
    BasicEPSGrowth_TTM*100 AS BasicEPSGrowth_TTM, BasicEPSGrowth_LFY*100 AS BasicEPSGrowth_LFY,SalesGrowth_TTM*100 AS SalesGrowth_TTM,SalesGrowth_LFY*100 AS SalesGrowth_LFY,
    ProfitGrowth_TTM*100 AS ProfitGrowth_TTM,TotalAssetsGrowth_TTM*100 AS TotalAssetsGrowth_TTM,TotalAssetsGrowth_LFY*100 AS TotalAssetsGrowth_LFY
    FROM _prefix_companyinfo c, _prefix_industry i, _prefix_sector s, _prefix_lastestfinancialratios f
    WHERE c.Symbol=:SYMBOL AND c.IndustryID=i.IndustryId AND s.SectorId=i.SectorId AND f.Symbol=c.Symbol');
    $db->bindValue(':SYMBOL', $symbol, PARAM_STR);
    $db->execute();

    //echo $db->error();
    if ($result=$db->fetch()){       
        //Lay cac tin tuc lien quan
        $db1 = _db();
        $db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id=4 AND (news_title LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');
        
		if ($news = $db1->fetchAll()) $data['newsgroup3'] = $news;
		
		$db1->query('SELECT SQL_CALC_FOUND_ROWS news_id, news_title, news_created FROM _prefix_news WHERE parent_id<>4 AND (news_title LIKE "%' . $symbol .'%" OR content LIKE "%' . $symbol .'%" OR symbol="'.$symbol.'") ORDER BY news_created DESC LIMIT 0,10');

		if ($news = $db1->fetchAll()) $data['newsgroup'] = $news;

        $data['company']=$result; 
        $data['chart_today'] = date("Y-m-d");
        $data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime("now"))-6  , date("d",strtotime("now")), date("Y",strtotime("now"))));
        
        
        $maxTradingDate = maxTradingDate();
        
        $db1 = _db('eps');
    	$db1->connect();
    	if ($result['Bourse'] == 'HOSE'){
    	    $db1->query('call tradingboard.sp_current_security("'.$maxTradingDate.'")');
        	if ($obj = $db1->fetch()){
        	    $data['quotes'] = $obj; 
        	}
    	}else{
    	    $db1->query('call tradingboard.sp_HN_getCurrentStockInfo("'.$maxTradingDate.'")');
        	if ($obj = $db1->fetch()){
        	    $data['quotes']['PriorClosePrice'] = $obj['BasicPrice']; 
        	    $data['quotes']['OpenPrice'] = $obj['OpenPrice'];
        	    $data['quotes']['LastVal'] = $obj['NmTotalTradedQtty'];  
        	}
    	}
    	
    	    	    
        trackSymbol($symbol);
        return $data;
    }      
   _redirect('/doanh-nghiep/cong-ty/index.html');
}

function companydetail_user_mod_layout(){
	return 'user.layout.companydetail.tpl';
}
?>