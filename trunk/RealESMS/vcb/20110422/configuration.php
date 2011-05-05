<?php
	/**
	 * Define BRAVO web service
	 */
		 
	/**
	 * All defines have been stored in here 
	 */

	define("DB_HOST", "172.25.2.103");
	define("DB_HOST_WRITE", "172.25.2.103");
	
	define("DB_TYPE", "mysqli");
	define("DB_NAME", "esms");
	define("DB_USERNAME", "epsesms");
	define("DB_PASSWORD", "root@chipheo310308");


	define("DB_DNS", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST . "/" . DB_NAME);
	define("DB_DNS_WRITE", DB_TYPE . "://" . DB_USERNAME . ":" . DB_PASSWORD . "@" . DB_HOST_WRITE . "/" . DB_NAME);
	
	define("ADMIN_USER_QUERY", " AND ". TBL_EMPLOYEE .".UserName != 'admin' ");
	define("ADMIN_USER", "admin");
	
// Order
	define("ORDER_BUY", "1");
	define("ORDER_SELL", "2");
	define("ORDER_CANCEL", "3");
	define("ORDER_ATO", "1");
	define("ORDER_ATC", "2");
	define("ORDER_LO", "3");
	define("ORDER_MP", "4");
	
	define("ORDER_PENDING", "1");
	define("ORDER_APPROVED", "2");
	define("ORDER_DENIED", "3");
	define("ORDER_TRANSFERED", "4");
	define("ORDER_EXPIRED", "5");
	define("ORDER_DELETED", "6");
	define("ORDER_MATCHED", "7");
	define("ORDER_FAILED", "8");
	define("ORDER_TRANSFERING", "9");
	define("ORDER_INCOMPLETE_MATCHED", "10");
	define("ORDER_CANCELED", "11");
	define("ORDER_INCOMPLETE_CANCELED", "12");

	define("MAX_SESSION_HCM", "4");
	define("MAX_SESSION_HN", "1");
	define("SESSION_1_START", "08:30");
	define("SESSION_1_END", "08:59");
	define("SESSION_2_START", "09:00");
	define("SESSION_2_END", "09:59");
	define("SESSION_3_START", "10:00");
	define("SESSION_3_END", "10:30");
	define("SESSION_4_START", "10:31");
	define("SESSION_4_END", "11:00");

	define("HN_SESSION_START", "09:00");
	define("HN_SESSION_END", "21:00");

	define("MAX_QUANTITY_HCM", "999999999");
	define("MAX_QUANTITY_HN", "4900");

// Assigner
	define("LAW_ASSIGNER", "2");
	define("ASSIGNER", "1");

// stock' status
	define("STOCK_NORMAL", "1");
	define("STOCK_MORTAGED", "2");
	define("STOCK_LOCKED", "3");

//web
	define("EXPIRED_TIME", "30");

//folder	
	define("SIGNATURE_PATH", "/home/vhosts/eSMSstorage/signature/");
	define("CSV_PATH", "/home/vhosts/eSMSstorage/csv/");
	
// Bravo
define("WEBSERVICE_URL", "http://172.25.2.4/BravoServices/Service.asmx?wsdl");
	define("BRAVO_KEY", "*#ksdHR23@32132"); 
?>
