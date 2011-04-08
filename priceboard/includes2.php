<?php
	session_start();
	require_once("MDB2.php");	
	require_once("XML/Unserializer.php");
	require_once("configuration.php"); 

	require_once("libs/common.php"); 
	require_once("libs/comet_price_online.php"); 
	
	require_once("classes/cDatabase.php"); 
	require_once("classes/cTrading.php"); 
	require_once("classes/cOTC.php"); 

	$Languages = array("vie", "eng", "jpn");

	if (isset($_GET['language']))
		$Language = trim($_GET['language']); 
	
	if (!in_array($Language, $Languages))
	{
		if (isset($_SESSION["language"]))
			$Language = $_SESSION["language"];
		else
		{
			$Language = "vie";
			$_SESSION["language"] = $Language;
		}
	}	
	else
		$_SESSION["language"] = $Language;	
?>