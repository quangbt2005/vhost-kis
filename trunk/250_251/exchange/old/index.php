<?php
ob_start();
session_start();
//session_unset('Error');
$_DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];

require_once 'SOAP/Client.php';
require 'Cache/Lite/Function.php';
require_once("MDB2.php");

//db
define("DB_TYPE", "mysqli");
define("DB_NAME_TRADING_BOARD", "esms");
define("DB_HOST_TRADING_BOARD", "172.25.2.103");
define("DB_USERNAME_TRADING_BOARD", "epsesms");
define("DB_PASSWORD_TRADING_BOARD",  "root@chipheo310308");
define("DB_DNS_TRADING_BOARD", DB_TYPE . "://" . DB_USERNAME_TRADING_BOARD . ":" . DB_PASSWORD_TRADING_BOARD . "@" . DB_HOST_TRADING_BOARD . "/" . DB_NAME_TRADING_BOARD);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ( ($_REQUEST['UserName'] == "" || $_REQUEST['PassWord'] == "" || $_SESSION['Error'] != '') && empty($_SESSION['UserName']) ) { ?>
	<p align="center" ><font color="red" size="+1"><?=$_SESSION['Error'];?></font></p>
	<form method="post">
	<p align="center">
		Username: <input type="text" name="UserName"/> <br/>
		Password: <input type="password" name="PassWord"/><br/>
		<input type="submit" value="Sign In"><br/>
	</p>
	</form>
<? unset ($_SESSION['Error'] );
	exit;
	} else { 
	$mdb2 = &MDB2::factory(DB_DNS_TRADING_BOARD);
	$mdb2->loadModule('Extended');
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);

	$query = sprintf( "SELECT ID FROM `employee` WHERE UserName='%s' AND PassWord=md5('%s')", $_REQUEST['UserName'], $_REQUEST['PassWord'] );
	$result = $mdb2->extended->getRow($query);

	if ($result['id'] > 0 || $_SESSION['UserName'] > 0) {
		if ( empty($_SESSION['UserName']) ) {
			session_register('UserName');
			$_SESSION['UserName'] = $result['id'];
		}
?>
	<form method="post" name="exchange" >
		<input type="hidden" name="doWhat"/>
	<p align="center">
		<a href="javascript: doIt('money', 'exchange.php');">Sửa tiền</a><br/>
		<a href="javascript: doIt('file', 'file.php');">Gởi file</a><br/>
	</p>
	</form>
<script>
	function doIt(doWhat, actionPage){
		document.exchange.doWhat.value = doWhat;
		document.exchange.action= actionPage;
		document.exchange.submit();
	}
</script>
<?php
	} else {
		session_register('Error');
		$_SESSION['Error'] = "Authen Fail";
		header("Location: index.php");
		exit;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function p($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
?>
