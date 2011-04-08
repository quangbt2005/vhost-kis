<?php
require_once("common.php");
require_once("MDB2.php");

define("DB_HOST", "172.25.2.103");
define("DB_HOST_WRITE", "172.25.2.103");

define("DB_TYPE", "mysqli");
define("DB_NAME", "esms");
define("DB_USERNAME", "epsesms_read");
define("DB_PASSWORD", "root@epsesms_read");


define("DB_DNS", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST . "/" . DB_NAME);
define("DB_DNS_WRITE", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST_WRITE . "/" . DB_NAME);

//initialize MDB2
$mdb2 = &MDB2::factory(DB_DNS_WRITE);
$mdb2->loadModule('Extended');
$mdb2->loadModule('Date');
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	
// $date=date("Y-m-d");
$date = '2010-10-18';

	$query = sprintf("CALL sp_executeMoneyTTBT('%s')", $date);
	$account_lists = $mdb2->extended->getAll($query);
	$mdb2->disconnect();
	write_my_log('MoneyTTBT',$query.'  varerror '.$account_lists[0]['varerror'].' '.date('Y-m-d h:i:s'));

	if($account_lists[0]['varerror']==0){
		require 'SOAP/Client.php';
		$soapclient = new SOAP_Client('http://202.87.214.213/ws/bravo.php?wsdl');
	$ret = $soapclient->call('SellingValueAndFeeListForBravo',
									$params = array( 
											"TradingDate" 			=> 	$date,															
											'AuthenUser' 	=> 'ba.nd', 
											'AuthenPass' 	=> md5('hsc080hsc')),
								 $options);	
		var_dump($ret);
		write_my_log('MoneyBravo','SellingValueAndFeeListForBravo '.$date.'  varerror '.$ret->error_code.' '.date('Y-m-d h:i:s'));
		
		$ret = $soapclient->call('PaidAdvanceForBravo',
									$params = array( 
											"TradingDate" 			=> 	$date,															
											'AuthenUser' 	=> 'ba.nd', 
											'AuthenPass' 	=> md5('hsc080hsc')),
								 $options);	
		var_dump($ret);
		write_my_log('MoneyBravo','PaidAdvanceForBravo '.$date.'  varerror '.$ret->error_code.' '.date('Y-m-d h:i:s'));
	//echo 'xong';
		
	}
exit;
?>
