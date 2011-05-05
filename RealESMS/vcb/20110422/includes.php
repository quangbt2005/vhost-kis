<?php
	/**
	 * Require files in here
	 */
	$_DocRoot = $_SERVER["DOCUMENT_ROOT"] ;
	require_once("MDB2.php");
	require_once("XML/Unserializer.php");
	require_once ('SOAP/Server.php');

 	require_once("configuration.php");
	require_once($_DocRoot ."/vcb/WebServiceAPI.php");	
	require_once($_DocRoot ."/vcb/common.php");
	//require_once($_DocRoot ."/libs/bravo_webservice.php");
	require_once($_DocRoot ."/vcb/vcb.php");
   ini_set("soap.wsdl_cache_enabled", "1");
?>