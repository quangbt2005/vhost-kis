<?php
//require_once 'SOAP/Client.php';
require '../includes.php';
// require_once('../libs/dab.php');

$dab = &new CDAB();
$result = $dab->getRealBalance('0101173992', '057C000195');
p($result);
//$result = $dab->getRealBalance('0102309252', '057C001223');
//p($result);
//$result = $dab->creditAccount('057C003481','679700','0101123011','Nguy?n �?ng Tru?ng Giang','DAB','CN Quan 1','9060000','36240','20101021');
//p($result);
//p(DAB_WEBSERVICE_URL);
?>

