<?php
//require_once 'SOAP/Client.php';
// require '../includes.php';
require_once('../libs/dab.php');

$src_file = "/home/vhosts/eSMSstorage/bank/dab/2011/1/";
$dab = &new CDAB();
$result = $dab->sell(array(
				'scraccount'		=> '057C005985',
				'refno'		=> '730012',
				'receiver_account'	=> '0101000203',
				'receiver_name'	=> 'Trần Nguyễn Đình Hoàng',
				'receiver_bank'	=> 'DAB',
				'receiver_bank_city'	=> 'CN Quan 1',
				'isDAB'		=> '1',
				'amount'		=> '11200000',
				'fee'			=> '44800',
				'scrdate'		=> '20110120151236',
				'transferdate'	=> '20110125',
			)
);
p($result);
//$result = $dab->getRealBalance('0102309252', '057C001223');
//p($result);
//$result = $dab->creditAccount('057C003481','679700','0101123011','Nguy?n �?ng Tru?ng Giang','DAB','CN Quan 1','9060000','36240','20101021');
//p($result);
//p(DAB_WEBSERVICE_URL);
?>

