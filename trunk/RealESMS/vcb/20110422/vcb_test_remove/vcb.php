<?php

$_DocRoot = $_SERVER["DOCUMENT_ROOT"] ;

require_once($_DocRoot .'/vcb/vcb_test/includes.php');
require_once($_DocRoot ."/vcb/vcb_test/classVCB.php");

$check_remoter = validRemoteIP($_SERVER['REMOTE_ADDR']);

$server = new SOAP_Server;
$server->_auto_translation = true;
$vcb   = new CVCB($check_remoter);
$server->addObjectMap($vcb, 'urn:CVCB');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $server->service($HTTP_RAW_POST_DATA);
} else {
    require_once 'SOAP/Disco.php';
    $disco = new SOAP_DISCO_Server($server,"CVCB");
    header("Content-type: text/xml");
    if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0) {
        echo $disco->getWSDL();
    } else {
        echo $disco->getDISCO();
    }
    exit;
}
?>