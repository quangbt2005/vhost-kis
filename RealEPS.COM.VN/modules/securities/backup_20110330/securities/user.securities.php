<?php
require('functions.php');
require('filters.php');

function securities_ajax_getsymbol(){
    
    if (!empty($_GET['q']) && !empty($_GET['se'])){
       
        $se=$_GET['se'];
        $q = $_GET['q'];
        $db = _db('eps');
    	$db->query('call sp_getStockSymbolList("'.maxTradingDate().'",'.$se.')');
    	$symbols=$db->fetchAll();    	
    	$db->connect();    
    	for ($i=0; $i < count($symbols); $i++) {
        	if (strpos(strtolower($symbols[$i]['StockSymbol']), $q) !== false)
        		echo $symbols[$i]['StockSymbol'] . '|' . $symbols[$i]['SecurityName'] ."\n";
    	}
    }
}

function securities_user_main(){
    global $fromDate, $toDate, $tmpFromDate ,$tmpToDate,$maxTradingDate, $urlParam;

    $data['from_date'] = $fromDate;
    $data['to_date'] = $toDate;
    $data['url_param'] = $urlParam;
    $seId=1;
    //{ Xu ly khung info
    $data['se'] = 'hose';
    //{{Cau hinh rieng cho san HOSE
    if (!empty($_GET['seid']) && $_GET['seid'] == 2) {
        $data['se'] = 'hase';
        $seId = $_GET['seid'];
    }//}}
    
    //}
    
    $view=0;
    if (!empty($_GET['view'])) $view=$_GET['view'];
    $data['view'] = $view;
    //Khac giao dich trai phieu
    
    
    //{ Xu ly khung du lieu
    $data['type']='.';
    $symbol='';
    $validSymbol=false;
    
    if (!empty($_GET['symbol']) ){
        $symbol = $_GET['symbol'];
        if ($view != 3 ){
            $data['type']='.filter.';
            $data['se'] = 'company';
        }
        $data['url_param'] .= '&symbol=' . $symbol; 
        $db1 = _db('stockbiz');
        $db1->query('SELECT c.Symbol, c.CompanyName, i.Name AS IndustryName,Bourse, i.IndustryId
        FROM _prefix_companyinfo c, _prefix_industry i 
        WHERE i.IndustryId = c.IndustryID AND Symbol="'.$symbol.'"');
        if ($info = $db1->fetch()){
            $data['info'] = $info;  
            if ($info['Bourse'] == 'HOSE') $seId = 1;
            else $seId = 2;
            $validSymbol=true;
            $data['symbol'] = $symbol;
        }
    }
    $data['seid'] = $seId;  
    if ($seId == 1) require('hose.php');
    else require('hase.php');
    switch ($view){
        case 0:
            //Khong co loc
            if ($symbol == ''){
                if ($seId == 1) $data['hose_current_security'] = get_hcm_security($toDate);                 
                else $data['hase_current_security'] = get_hn_security($toDate);
            //Co loc
            }else{
                if ($validSymbol)
                    $data['current_security'] = get_hcm_security_filter($symbol, $fromDate, $toDate, $seId);
                   
            }
            break;
        case 1:
                if ($seId == 1){
                    $data['put_through'] = get_hcm_putthrough($symbol,$fromDate, $toDate);
                    $data['put_through_info'] = getPutExecInfo_sum($symbol,$fromDate, $toDate);
                   
                }else{
                    if ($symbol == '')
                        $data['put_through'] = get_hn_putthrough($toDate, $data['put_through_qty'], $data['put_through_val']);
                }
            
          
            break;
        case 2:
            $result_per_page = 20;
            $data['fi_sum'] = getForeignInvestment_sum($symbol, $fromDate, $toDate, $seId);

            $data['fi_top5bvol'] = getTopFI5BVol($fromDate, $toDate,$seId);
            $data['fi_top5bval'] = getTopFI5BVal($fromDate, $toDate,$seId);
            $data['fi_top5svol'] = getTopFI5SVol($fromDate, $toDate,$seId);
            $data['fi_top5sval'] = getTopFI5SVal($fromDate, $toDate,$seId);
            $data['fi'] = getForeignInvestment($symbol, $fromDate, $toDate, $seId);
            $paging = new Paging('p', $result_per_page,0,_display_page());
            $paging->sCurrentPageClass = 'current';
            $paging->sPageNextClass = 'next';
            $paging->sPostfix = '#detail';
            $paging->nTotalRow = count($data['fi']);
            
            $data['fi_offset'] = $paging->getResultRowStart();
            $data['fi_total'] = $data['fi_offset'] + $result_per_page;            
            $data['fi_paging'] = $paging;
            /*if ($seId == 1) $data[] = '';
            else $data[] = '';*/
            break;
        case 3:
            //Su dung ham trong hose
            if ($seId == 2) require('hose.php');
            $data['bond'] = get_hcm_putthrough($symbol,$fromDate, $toDate,1);
            $data['bond_info'] = getPutExecInfo_sum($symbol,$fromDate, $toDate,1);
            $data['se'] = 'hose';
            return $data;
            break;
        case 4:  
                  
            break;
    }
    
    if ($symbol == ''){
        $data['maxtradingdate'] = $toDate;
        getMarketInfo($toDate,$seId,$data);
    	$data['chart_startdate'] = date("Y-m-d",mktime(0, 0, 0, date("m", strtotime($toDate))-6  , date("d",strtotime($toDate)), date("Y",strtotime($toDate))));
    	$data['chart_today'] = $toDate;
    }
    return $data;
}    

function securities_user_mod_layout(){
    return 'user.layout.tpl';
}

?>