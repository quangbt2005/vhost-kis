<?php
	// Database connection information

	define("DB_HOST1", "172.25.2.250");

	define("DB_TYPE", "mysqli");
	define("DB_NAME", "tradingboard");

	define("DB_HOST", "172.25.2.250");
	define("DB_USERNAME", "esms");
       define("DB_PASSWORD", "esms");
       define("DB_NAME_ESMS", "esms");
/*
	define("DB_HOST", "172.25.2.104");
	define("DB_USERNAME", "priceonline");
    define("DB_PASSWORD", "root@chipheo310308");
/*

/*
	define("DB_HOST", "172.25.2.112");
	define("DB_USERNAME", "epsesms");
  define("DB_PASSWORD", "root@chipheo310308");
*/
	define("DB_NAME_ESMS", "esms");
	define("DB_USERNAME1", "epsonline_write");
	define("DB_PASSWORD1", "root@epsonline_write");
/*
	define("DB_HOST", "172.25.2.250");
        define("DB_TYPE", "mysqli");
        define("DB_NAME", "tradingboard");
        define("DB_NAME_ESMS", "esms");
        define("DB_USERNAME", "esms");
        define("DB_PASSWORD", "esms");
*/
	// define("OTC_DB_HOST", "172.25.2.111");//172.25.2.103");
	define("OTC_DB_HOST", "172.25.2.250");//172.25.2.103");
	define("DB_NAME_OTC", "web_report");
	define("OTC_DB_USERNAME", "rep_agent");//epsonline_write");
	define("OTC_DB_PASSWORD", "RepAgent");//root@epsonline_write");

	/*
	define("DB_HOST", "172.25.2.104");
        define("DB_TYPE", "mysqli");
        define("DB_NAME", "tradingboard");
        define("DB_NAME_ESMS", "esms");
        define("DB_USERNAME", "priceonline");
        define("DB_PASSWORD", "trum@nhamnho");
	*/	
	define("DB_DNS", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST . "/" . DB_NAME);

	define("DB_DNS_ESMS", DB_TYPE . "://" . DB_USERNAME1 . ":" . DB_PASSWORD1 . "@" . DB_HOST1 . "/" . DB_NAME_ESMS);	
	define("DB_DNS_OTC", DB_TYPE . "://" . OTC_DB_USERNAME . ":" . OTC_DB_PASSWORD . "@" . OTC_DB_HOST . "/" . DB_NAME_OTC);	
?>
