<?php
require_once ("common.php");
require_once ("MDB2.php");
require_once ("XML/Unserializer.php");

define("DB_HOST", "172.25.2.103");
define("DB_HOST_WRITE", "172.25.2.103");
define("DB_TYPE", "mysqli");
define("DB_NAME", "esms");
define("DB_USERNAME", "epsesms_read");
define("DB_PASSWORD", "root@epsesms_read");

//define("DB_HOST", "172.25.2.250");
//define("DB_HOST_WRITE", "172.25.2.250");
//define("DB_TYPE", "mysqli");
//define("DB_NAME", "AdvanceFeeDB");
//define("DB_USERNAME", "esms");
//define("DB_PASSWORD", "esms");


define("DB_DNS", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST . "/" . DB_NAME);
define("DB_DNS_WRITE", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST_WRITE . "/" . DB_NAME);

define("BankID", "20");

//initialize MDB2
$mdb2 = & MDB2 :: factory(DB_DNS_WRITE);
$mdb2->loadModule('Extended');
$mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);

$tradingDate = date('Y-m-d');
$query = sprintf("CALL sp_quota_QuotaTDebtInterest('%s')", $tradingDate);
$rs = $mdb2->extended->getAll($query);
$mdb2->disconnect();

$result = $rs[0]['varError'];
// ---------------------------------------------------------------------------------------------- //
// Send mail
// ---------------------------------------------------------------------------------------------- //
$message = 'This mail is sent automatically from cron.d<br>';
$message .= 'Task name: quota_debt_interest.php<br>';
$message .= 'Executed time: ' . date('Y-m-d h:i:s') . '<br><br>';

$message .= 'Job: ' . $query . '<br>';
$message .= 'Result: ' . (string)$result . '<br><br>';

mailPHPMailer('CRON.D', 'webmaster@eps.com.vn', array('ba.nd@eps.com.vn','chi.dl@eps.com.vn','quang.tm@eps.com.vn'), NULL, NULL,
              'Cron Task Report (quota_debt_interest).', $message);

exit;
?>
