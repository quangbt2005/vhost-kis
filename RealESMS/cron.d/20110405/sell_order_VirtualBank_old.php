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
//	 echo $query;
        $result = $mdb2->extended->getRow($query);
//	var_dump($result);
        $mdb2->disconnect();
        write_my_log('SellVirtualBank', $query .'   '. date('Y-m-d h:i:s') . '[' . $result['varError'] . ']');


$message  = 'This mail is sent automatically from cron.d<br>';
$message .= 'Task name: sell_order_VirtualBank.php<br>';
$message .= 'Executed time: ' . date('Y-m-d h:i:s') . '<br>';
$message .= 'Job: ' . $query . '<br>';
$message .= 'Result: varError=' . $result['varError'];
mailPHPMailer('CRON.D', 'webmaster@eps.com.vn', array('quan.nt@eps.com.vn','chi.dl@eps.com.vn','quang.tm@eps.com.vn'), NULL, NULL, 'Cron Task Report (sell_order_VirtualBank).', $message);

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
