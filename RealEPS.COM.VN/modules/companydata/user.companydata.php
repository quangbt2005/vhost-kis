<?php
function companydata_ajax_getsymbol(){
    if (!empty($_GET['q'])){
        $sql = 'SELECT Symbol, CompanyName FROM _prefix_companyinfo WHERE Symbol LIKE ":SYMBOL%"';        
        if (!empty($_GET['se'])){
            $se = intval($_GET['se']);
            $seName ='';            
            switch ($se){
                case 1: $seName='HOSE';break;
                case 2: $seName='HASTC';break;
                case 3: $seName='UPCOM';break;
            }
            if ($seName != '') $sql .= ' AND Bourse="' . $seName . '"';
        }
        if (!empty($_GET['industry'])){
            $sql .= ' AND IndustryID=' . intval($_GET['industry']);           
        }
        
        $db = _db('stockbiz');
        $db->prepare($sql);
        $db->bindValue(':SYMBOL', $_GET['q'], PARAM_NONE);        
        $db->execute();        
        if ($symbols = $db->fetchAll()){
            for ($i=0; $i < count($symbols); $i++) {            	
            	echo $symbols[$i]['Symbol'] . '|' . $symbols[$i]['CompanyName'] ."\n";
        	}
        }               
    }    
}
?>