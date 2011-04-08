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

	$query = sprintf("CALL  sp_VirtualBank_AdvPaymentList('%s', %u)", date('Y-m-d'), BankID);
//	echo $query;
	$account_lists = $mdb2->extended->getRow($query);
	var_dump( $account_lists );
	$mdb2->disconnect();
	write_my_log('AdvanceVirtualBank', $query .'	'.$account_lists['varError'].'   '. date('Y-m-d h:i:s'));

$message  = 'This mail is sent automatically from cron.d<br>';
$message .= 'Task name: advance_VirtualBank.php<br>';
$message .= 'Executed time: ' . date('Y-m-d h:i:s') . '<br>';
$message .= 'Job: ' . $query . '<br>';
$message .= 'Result: varError=' . $account_lists['varError'];
mailPHPMailer('CRON.D', 'webmaster@eps.com.vn', array('quan.nt@kisvn.vn','ba.nd@kisvn.vn','chi.dl@kisvn.vn','quang.tm@kisvn.vn'), NULL, NULL, 'Cron Task Report (advance_VirtualBank).', $message);
exit;
?>
