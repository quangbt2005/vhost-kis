<?php
$year = date('Y');
if (!empty($_GET['year'])) $year=$_GET['year'];
//{{{ feed income statements by quater
function feedIncomeStatementsByQuater($symbol){
    global $_configs, $year;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol,
	                'year' => $year,	            
	                'count' => 1);	

	for ($i=1; $i<=4; $i++){
	    $params['quarter'] = $i;	  
    	if ($objs = _feed_stockbiz('GetLastestIncomeStatementsByQuarter',$url,$params)){       
    	      
    		if (!empty($objs['GetLastestIncomeStatementsByQuarterResult'])){
    			$db=_db('stockbiz');
    			$db->query('DELETE FROM _prefix_financialreport WHERE Symbol="'.$symbol.'" AND Quarter=' . $i . ' AND type=1');
    			echo $db->error();
    			if (!isset($objs['GetLastestIncomeStatementsByQuarterResult']['FinancialReport'][0])){
    			    $obj = 	$objs['GetLastestIncomeStatementsByQuarterResult']['FinancialReport'];    			    
    			    if ($i == $obj['Quarter']){		
    			        $obj['type'] = 1;
        				$sql=buildInsertSQL('_prefix_financialreport', $obj);			
        				$db->query($sql);    		
    			    }				
    			}else{
    				$objs = $objs['GetLastestIncomeStatementsByQuarterResult']['FinancialReport'];				
    				for ($j=0; $j<count($objs);$j++){
    				    if ($objs[$j]['Quarter'] == $i){	
    				        $objs[$j]['type'] = 0;			
        					$sql=buildInsertSQL('_prefix_financialreport', $objs[$j]);					
        					$db->query($sql);    
    				    }				
    				}					
    			}
    		}
    	}    	
	}
}
function feedfinancialreport_feed_incomestatementsbyquarter(){    
    $db=_db('stockbiz');
    $db->query('SELECT Symbol FROM _prefix_symbol');
    $objs = $db->fetchAll();    
    for ($i=0;$i<count($objs);$i++){             
        feedIncomeStatementsByQuater($objs[$i]['Symbol']);
    }
}
//}}}
function feedIncomeStatementsByYear($symbol){
    global $_configs, $year;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol,
	                'year' => $year,
	                'count' => 1);	

	if ($objs = _feed_stockbiz('GetLastestIncomeStatementsByYear',$url,$params)){	 	 
		if (!empty($objs['GetLastestIncomeStatementsByYearResult'])){
			$db=_db('stockbiz');
			$db->query('DELETE FROM _prefix_financialreport WHERE Symbol="'.$symbol.'" AND Quarter=0 AND type=1');
			if (!isset($objs['GetLastestIncomeStatementsByYearResult']['FinancialReport'][0])){
			    $obj = $objs['GetLastestIncomeStatementsByYearResult']['FinancialReport'];
			    $obj['type'] = 1;				
				$sql=buildInsertSQL('_prefix_financialreport', $obj);						
				$db->query($sql);										
			}else{
				$objs = $objs['GetLastestIncomeStatementsByYearResult']['FinancialReport'];				
				for ($i=0; $i<count($objs);$i++){	
				    $objs[$i]['type'] = 1;			
					$sql=buildInsertSQL('_prefix_financialreport', $objs[$i]);					
					$db->query($sql);	
				}					
			}
		}
	}	
	
}
function feedfinancialreport_feed_incomestatementsbyyear(){
    $db=_db('stockbiz');
    $db->query('SELECT Symbol FROM _prefix_symbol');
    $objs = $db->fetchAll();    
    for ($i=0;$i<count($objs);$i++){                    
        feedIncomeStatementsByYear($objs[$i]['Symbol']);
    }
}
//{{{ feed balance sheets by quater
function feedBalanceSheetByQuater($symbol){
    global $_configs, $year;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol,
	                'year' => $year,	            
	                'count' => 1);	

	for ($i=1; $i<=4; $i++){
	    $params['quarter'] = $i;	  
    	if ($objs = _feed_stockbiz('GetLastestBalanceSheetsByQuarter',$url,$params)){        	    
    		if (!empty($objs['GetLastestBalanceSheetsByQuarterResult'])){
    			$db=_db('stockbiz');
    			$db->query('DELETE FROM _prefix_financialreport WHERE Symbol="'.$symbol.'" AND Quarter=' . $i . ' AND type=0');
    			echo $db->error();
    			if (!isset($objs['GetLastestBalanceSheetsByQuarterResult']['FinancialReport'][0])){
    			    $obj = 	$objs['GetLastestBalanceSheetsByQuarterResult']['FinancialReport'];    			    
    			    if ($i == $obj['Quarter']){		
    			        $obj['type'] = 0;
        				$sql=buildInsertSQL('_prefix_financialreport', $obj);			
        				$db->query($sql);    		
    			    }				
    			}else{
    				$objs = $objs['GetLastestBalanceSheetsByQuarterResult']['FinancialReport'];				
    				for ($j=0; $j<count($objs);$j++){
    				    if ($objs[$j]['Quarter'] == $i){	
    				        $objs[$j]['type'] = 0;			
        					$sql=buildInsertSQL('_prefix_financialreport', $objs[$j]);					
        					$db->query($sql);    
    				    }				
    				}					
    			}
    		}
    	}    	
	}
}
function feedfinancialreport_feed_balancesheetsbyquarter(){    
    $db=_db('stockbiz');
    $db->query('SELECT Symbol FROM _prefix_symbol');
    $objs = $db->fetchAll();    
    for ($i=0;$i<count($objs);$i++){             
        feedBalanceSheetByQuater($objs[$i]['Symbol']);
    }
}
//}}}
//{{{ feed balance sheets by year
function feedBalanceSheetsByYear($symbol){
    global $_configs, $year;
	$url = 'http://datafeed.stockbiz.vn/FinanceService.asmx?WSDL';
	$params = array('userName' => $_configs['stockbiz_user'],
					'password' => $_configs['stockbiz_pass'],
					'symbol' => $symbol,
	                'year' => $year,
	                'count' => 1);	

	if ($objs = _feed_stockbiz('GetLastestBalanceSheetsByYear',$url,$params)){	    
		if (!empty($objs['GetLastestBalanceSheetsByYearResult'])){
			$db=_db('stockbiz');
			$db->query('DELETE FROM _prefix_financialreport WHERE Symbol="'.$symbol.'" AND Quarter=0 AND type=0');
			if (!isset($objs['GetLastestBalanceSheetsByYearResult']['FinancialReport'][0])){				
			    $obj = $objs['GetLastestBalanceSheetsByYearResult']['FinancialReport'];
			    $obj['type'] = 0;				    	  
				$sql=buildInsertSQL('_prefix_financialreport', $obj);				
				$db->query($sql);						
			}else{
				$objs = $objs['GetLastestBalanceSheetsByYearResult']['FinancialReport'];				
				for ($i=0; $i<count($objs);$i++){	
				    $objs[$i]['type'] = 0;			
					$sql=buildInsertSQL('_prefix_financialreport', $objs[$i]);					
					$db->query($sql);	
				}					
			}
		}
	}	
}
function feedfinancialreport_feed_balancesheetsbyyear(){    
    $db=_db('stockbiz');
    $db->query('SELECT Symbol FROM _prefix_symbol');
    $objs = $db->fetchAll();    
    for ($i=0;$i<count($objs);$i++){             
        feedBalanceSheetsByYear($objs[$i]['Symbol']);
    }
} 
//}}}
?>