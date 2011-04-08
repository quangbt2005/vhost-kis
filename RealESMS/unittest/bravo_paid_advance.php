<?php
require_once('../includes.php');
$soap = &new Bravo();
$Note = "Thanh toan tien ung truoc";
$buyingstock = array(
	"TradingDate"     => '2011-02-08',
	"AccountNo"       => '057C001117',
	"Amount"          => '28000000',
	"Fee"             => '0',
	"Bank"            => '21',
	"Branch"          => 'HCM',
	"Type"            => '',
	"Note"            => $Note,
	"transactionType" => '2',
	"BankID"          => '15',
	"OrderBankBravoCode" => '21',);

$params["key"] = BRAVO_KEY;
$params["transactionID"]    = "";
$params["transactionType"]  = "M15.02";
$params["transactionDate"]  = "2011-02-08";
$params["customerCode"]     = '057C001117';
$params["destCustomerCode"] = "";
$params["amount"]           = '28000000';
$params["fee"]              = '0';
$params["notes"]            = 'Thanh toan tien ung truoc - So tien ung';
$params["nganhang"]         = '15';
$params["chinhanh"]         = 'HCM';
$params["transID_Rollback"] = "";
	
$ret = $soap->soap_client->NewTransaction($params);
$error_code = $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"]
if($error_code['table0']['Result']==1) $bravoerror = 0;
if($error_code['table0']['Result']==-2) $bravoerror = 23002;
if($error_code['table0']['Result']==-1) $bravoerror = 23003;
if($error_code['table0']['Result']==-13) $bravoerror = 23006;
if($error_code['table0']['Result']==-15) $bravoerror = 23005;
if($error_code['table0']['Result']==-16) $bravoerror = 23004;

echo "<br>Tien Ung: $bravoerror<br>";
?>
?>