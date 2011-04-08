<?php
	// Define trading time 
	define("BEGIN_OPEN_PROJECT", strtotime("08:30:00")); 
	define("END_OPEN_PROJECT", strtotime("08:59:59")); 
	define("BEGIN_LAST_PROJECT", strtotime("09:00:00")); 
	define("END_LAST_PROJECT", strtotime("10:14:59")); 
	define("BEGIN_CLOSE_PROJECT", strtotime("10:15:00")); 
	define("END_CLOSE_PROJECT", strtotime("10:29:59")); 
	define("BEGIN_RUN_OFF", strtotime("10:30:00")); 
	define("END_RUN_OFF", strtotime("11:00:00")); 

	define("DB_TYPE", "mysqli");

	define("DB_NAME_TRADING_BOARD", "tradingboard");

        define("DB_HOST_TRADING_BOARD", "172.25.2.105");
        define("DB_USERNAME_TRADING_BOARD", "tradingboard");
        define("DB_PASSWORD_TRADING_BOARD", "u9ZpMq9kc4sCFIChAfIR");

/*
	define("DB_HOST_TRADING_BOARD", "172.25.2.104");//172.25.2.62");
        define("DB_USERNAME_TRADING_BOARD", "priceonline");
        define("DB_PASSWORD_TRADING_BOARD", "root@chipheo310308");
*/
	define("DB_DNS_TRADING_BOARD", DB_TYPE . "://" . DB_USERNAME_TRADING_BOARD . ":" . DB_PASSWORD_TRADING_BOARD . "@" . DB_HOST_TRADING_BOARD . "/" . DB_NAME_TRADING_BOARD);

	define("DB_NAME_ESMS", "esms");
	define("DB_HOST_ESMS", "172.25.2.103");
	define("DB_USERNAME_ESMS", "esms_read");
	define("DB_PASSWORD_ESMS", "root@chipheo310308");
	define("DB_DNS_ESMS", DB_TYPE . "://" . DB_USERNAME_ESMS . ":" . DB_PASSWORD_ESMS . "@" . DB_HOST_ESMS . "/" . DB_NAME_ESMS);

	define("DB_NAME_WEBSITE", "web_report");

        define("DB_HOST_WEBSITE", "172.25.2.105");
        define("DB_USERNAME_WEBSITE", "web_report");
        define("DB_PASSWORD_WEBSITE", "g4ySZ6VPgJr3UZiy5aHX");

	define("DB_DNS_WEBSITE", DB_TYPE . "://" . DB_USERNAME_WEBSITE . ":" . DB_PASSWORD_WEBSITE . "@" . DB_HOST_WEBSITE . "/" . DB_NAME_WEBSITE);

	define("TBL_IP_ALLOWED", "`ip_allowed`");
	define("TBL_IP_DENIED", "`ip_denied`");

	define("HCM_EXCHANGE", 1); 
	define("HN_EXCHANGE", 2); 
	define("DOWNLOAD_PATH", 'http://upload.eps.com.vn/'); 
	define("NEWS_PATH", 'news/'); 
	define("ANALYTICAL_PATH", 'reportAnalyze/'); 
	define("FINANCE_PATH", 'finance/'); 
	define("WEBSITE_CHART", 'http://www.eps.com.vn/ws/chart.php?wsdl'); 
	define("LOGIN_URL", 'https://online.eps.com.vn/'); 
	
	define("PAGER_MODE", 'Jumping'); 
	define("PAGER_SEPARATOR", ' '); 
	
?>
