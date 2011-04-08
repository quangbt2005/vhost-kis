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

define("BankID", "20");

//initialize MDB2
$mdb2 = &MDB2::factory(DB_DNS_WRITE);
$mdb2->loadModule('Extended');
$mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
$date=date("Y-m-d");

$query = sprintf("CALL sp_VirtualBank_Sell( '%s',%u)", $date, BankID);
$result = $mdb2->extended->getRow($query);
$mdb2->disconnect();
write_my_log('SellVirtualBank', $query .'   '. date('Y-m-d h:i:s') . '[' . $result['varError'] . ']');

try{
	if($result['varError'] > 0){
		$query = sprintf("CALL sp_VirtualBank_getSMSForSellandBuy('%s','S')", $date);
		$mdb2->connect();
		$smsresult = $mdb2->extended->getAll($query);
		$mdb2->disconnect();

		$count = count($smsresult);
		$log   = sprintf("Query: %s => Count: %s\n", $query, $count);
		for($i=0; $i<$count; $i++) {
		  $mbnumber = $smsresult[$i]['mobilephone'];
		  $amount   = $smsresult[$i]['amount'];
		  $usableamount = $smsresult[$i]['currentbalance'];
		  if(!empty($mbnumber)){
			$message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $amount, 0, '.', ',' ) . '. Tien ban ck';
			$message .= '. So du hien tai la: ' . number_format($usableamount, 0, '.', ',');
			sendSMS(array('Phone' => $mbnumber, 'Content' => $message));
		  }
		  $log = sprintf("\tMB: %s;Amount: %s;UsableAmount: %s\n", $mbnumber, $amount, $usableamount);
		}
		write_my_log('selling_money_sms_notify', $log ."\nExecuted Time: ". date('Y-m-d h:i:s'));
	}
} catch (Exception $e) {
	$count = sprintf('Query: %s;Count: %s;ExceptionMsg: %s', $query, $count, $e->getMessage());
}
$message  = 'This mail is sent automatically from cron.d<br>';
$message .= 'Task name: sell_order_VirtualBank.php<br>';
$message .= 'Executed time: ' . date('Y-m-d h:i:s') . '<br>';
$message .= 'Job: ' . $query . '<br>';
$message .= 'Result: varError=' . $result['varError'];
$message .= 'SMS: ' . $count;
mailPHPMailer('CRON.D', 'webmaster@eps.com.vn', array('quan.nt@kisvn.vn','ba.nd@kisvn.vn','chi.dl@kisvn.vn','quang.tm@kisvn.vn'), NULL, NULL, 'Cron Task Report (sell_order_VirtualBank).', $message);

exit;

/*
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

define("BankID", "20"); 

//initialize MDB2
$mdb2 = &MDB2::factory(DB_DNS_WRITE);
$mdb2->loadModule('Extended');
$mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);

echo	$query = sprintf("CALL  sp_VirtualBank_Sell('%s', %u)", date('Y-m-d'), BankID);
	$account_lists = $mdb2->extended->getRow($query);
var_dump($account_lists);
	$mdb2->disconnect();
	write_my_log('SellVirtualBank', $query .'	'. date('Y-m-d h:i:s'));

exit;
*/
?>
