<?php
require_once('../includes.php');
// define('BRAVO_KEY', '');

$soap = &new Bravo();
/*
$Note = "Thanh toan tien ung truoc";
$buyingstock = array(
	"TradingDate"     => '2011-02-08',
	"AccountNo"       => '057C001119',
	"Amount"          => '0',
	"Fee"             => '106500',
	"Bank"            => '21',
	"Branch"          => 'HCM',
	"Type"            => '',
	"Note"            => 'Ban ck ngay 2011-01-26 - Tien ban chung khoan',
	"transactionType" => '2',
	"BankID"          => '15',
	"OrderBankBravoCode" => '21',);
*/
$params["key"] = BRAVO_KEY;
$params["transactionID"]    = "";
$params["transactionType"]  = "M03.01";
$params["transactionDate"]  = "2011-02-08";
$params["customerCode"]     = '057C001119';
$params["destCustomerCode"] = "";
$params["amount"]           = '0';
$params["fee"]              = '106500';
$params["notes"]            = 'Ban ck ngay 2011-01-26 - Tien ban chung khoan';
$params["nganhang"]         = '21';
$params["chinhanh"]         = 'HCM';
$params["transID_Rollback"] = "";
	
/*$ret = $soap->soap_client->NewTransaction($params);
$error_code = $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"]
if($ret['table0']['Result']==1) $bravoerror = 0;
if($ret['table0']['Result']==-2) $bravoerror = 23002;
if($ret['table0']['Result']==-1) $bravoerror = 23003;
if($ret['table0']['Result']==-13) $bravoerror = 23006;
if($ret['table0']['Result']==-15) $bravoerror = 23005;
if($ret['table0']['Result']==-16) $bravoerror = 23004;

echo "<br>Phi Ban: $bravoerror<br>";
*/
echo BRAVO_KEY;
?>