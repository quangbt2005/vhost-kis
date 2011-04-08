<?php
require_once('../includes.php');
require_once('../classes/classQuota.php');

$check_remoter = validRemoteIP($_SERVER['REMOTE_ADDR']);

$server = new SOAP_Server;
$server->_auto_translation = true;
$classObj = new CQuota($check_remoter);
$server->addObjectMap($classObj, 'urn:CQuota');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST')
{
    $server->service($HTTP_RAW_POST_DATA);
}
else
{
    require_once 'SOAP/Disco.php';
    $disco = new SOAP_DISCO_Server($server,"CQuota");
    header("Content-type: text/xml");
    if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0)
    {
        echo $disco->getWSDL();
    }
    else
    {
        echo $disco->getDISCO();
    }
    exit;
}
?>
