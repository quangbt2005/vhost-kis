<?php 
$maxTradingDate = maxTradingDate();
$fromDate = $maxTradingDate;
$toDate = $maxTradingDate;
$urlParam = '';
if (!empty($_GET['fromdate']) && strtotime($_GET['fromdate'])) {
    $urlParam .= '&fromdate=' . $_GET['fromdate']; 
    $fromDate=_db_date($_GET['fromdate']);
}

if (!empty($_GET['todate']) && strtotime(_db_date($_GET['todate']))){
    $urlParam .= '&todate=' . $_GET['todate'];
    $toDate=_db_date($_GET['todate']);
}
$tmpFromDate=strtotime($fromDate);
$tmpToDate=strtotime($toDate);
$tmpMaxTradingDate = strtotime($maxTradingDate);
?>