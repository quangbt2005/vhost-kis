<?php 
$fromDate=_db_date();
$toDate = _db_date();
$maxTradingDate = maxTradingDate();
if (!empty($_GET['fromdate']) && strtotime($_GET['fromdate'])) $fromDate=_db_date($_GET['fromdate']);
if (!empty($_GET['todate']) && strtotime(_db_date($_GET['todate']))) $toDate=_db_date($_GET['todate']);

$tmpFromDate=strtotime($fromDate);
$tmpToDate=strtotime($toDate);
$tmpMaxTradingDate = strtotime($maxTradingDate);

if ($tmpToDate < $tmpMaxTradingDate) $maxTradingDate=$toDate;
if ($tmpFromDate >  $tmpToDate) $fromDate=$toDate;
?>