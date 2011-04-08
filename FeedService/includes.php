<?php
	/**
	 * Require files in here
	 */
 	$_DocRoot = $_SERVER["DOCUMENT_ROOT"] ;

	require_once("MDB2.php");
	require_once ('SOAP/Server.php');
	require_once("Pager/Pager.php");
	require_once("XML/Unserializer.php");


	require_once($_DocRoot . "/config.php");	
	require_once($_DocRoot . "/core/WebServiceAPI.php");
	require_once($_DocRoot . "/libs/common.php");	


  ini_set("soap.wsdl_cache_enabled", "1");
?>
