<?php
ob_start();
session_start();
$_DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];

define("DAB_WEBSERVICE_URL", "https://webservice.dongabank.com.vn/securities/WSBean?wsdl");
//db
define("DB_TYPE", "mysqli");
define("DB_NAME_TRADING_BOARD", "esms");
define("DB_HOST_TRADING_BOARD", "172.25.2.103");
define("DB_USERNAME_TRADING_BOARD", "epsesms");
define("DB_PASSWORD_TRADING_BOARD",  "root@chipheo310308");
define("DB_DNS_TRADING_BOARD", DB_TYPE . "://" . DB_USERNAME_TRADING_BOARD . ":" . DB_PASSWORD_TRADING_BOARD . "@" . DB_HOST_TRADING_BOARD . "/" . DB_NAME_TRADING_BOARD);

require $_DOC_ROOT . '/libs/dab.php';
require_once("MDB2.php");
include_once ( $_DOC_ROOT .'/logs/my_helper.php');

if ( $_SESSION['UserName'] != '') {
	if ( $_REQUEST['Type'] == "" || $_SESSION['Error'] != '' || $_REQUEST['Amount'] == "" ) { ?>
		<form method="post" onsubmit="javascript: return warning();" name="exchange">
<table align="center" width="30%" border="0">
	<tr>
		<td colspan="2" align="center"><font color="red" size="+2"><?=$_SESSION['Error'];?></font></td>
	</td>
	<tr>
		<td colspan="2">&nbsp;</td>
		<tr>
			<td align="right">OrderID:</td>
			<td>
			 <input type="text" name="OrderID"/><br />
			</td>
		</tr>
		<td colspan="2" align="center">
			<select name="Type" size="1">
				<option value="1">Insert</option>
				<option value="2">Edit</option>
				<option value="3">Cancel</option>
				<option value="4">Auction</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">Amount:</td>
		<td>
		 <input type="text" name="Amount"/><br />
		</td>
	</tr>
	<tr>
		<td align="right">Fee (for Auction ONLY):</td>
		<td>
		 <input type="text" name="Fee"/><br />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" value="Fix" />
			<input type="button" value="Back" onclick="javascript: window.location='index.php'"/>
		</td>
	</tr>
</table>
		</form>
<script>
	function warning(){
		if (document.exchange.Type.value == "4") {
			accept = confirm("This is AUNCTION!! ARE YOU SURE TO DO THAT?");
			if (accept)
				return true;
			else
				return false;
		}	
	}
</script>
	<?
		session_unregister('Error');

	} else {
			$mdb2 = &MDB2::factory(DB_DNS_TRADING_BOARD);
			$mdb2->loadModule('Extended');
			$mdb2->loadModule('Date');
			$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
			$dab = &new CDAB();

			/*$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, `order`.OrderDate
									FROM vw_ListAccountBank_Detail, `order`
									WHERE `order`.ID = %u
									AND `order`.Deleted='0'
									AND vw_ListAccountBank_Detail.AccountID = `order`.AccountID
									AND vw_ListAccountBank_Detail.BankID=%u
									ORDER BY Priority ", $_REQUEST['OrderID'], 2 );*/
			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, `order`.OrderDate
									FROM vw_ListAccountBank_Detail, `order`
									WHERE `order`.ID = %u
									AND vw_ListAccountBank_Detail.AccountID = `order`.AccountID
									AND vw_ListAccountBank_Detail.BankID=%u
									ORDER BY Priority ", $_REQUEST['OrderID'], 2 );

			$result = $mdb2->extended->getRow($query);

			if ($result['accountid'] >0 ) {
				switch ($_REQUEST['Type']) {
					case '1':
						$re = $dab->blockMoney($result['bankaccount'], $result['cardno'], $result['accountno'], $_REQUEST['OrderID'], $_REQUEST['Amount'], $result['orderdate']);
						$detail = $result['bankaccount'] . ", " . $result['cardno'] .", ". $result['accountno'] .", ". $_REQUEST['OrderID'] .", ". $_REQUEST['Amount'] .", ". $result['orderdate'];
						break;

					case '2':
						$re = $dab->editBlockMoney($result['bankaccount'], $result['accountno'], $_REQUEST['OrderID'], $_REQUEST['Amount']);
						$detail = $result['bankaccount'] .", ". $result['accountno'] .", ". $_REQUEST['OrderID'] .", ". $_REQUEST['Amount'];
						break;

					case '3':
						$re = $dab->cancelBlockMoney($result['bankaccount'], $result['accountno'], $_REQUEST['OrderID'], $_REQUEST['Amount']);
						$detail = $result['bankaccount'] .", ". $result['accountno'] .", ". $_REQUEST['OrderID'] .", ". $_REQUEST['Amount'];
						break;

					case '4':
						$re = $dab->cutMoney($result['bankaccount'], $result['accountno'], $_REQUEST['OrderID'], $_REQUEST['Amount'], $_REQUEST['Fee']);
						$detail = $result['bankaccount'] .", ". $result['accountno'] .", ". $_REQUEST['OrderID'] .", ". $_REQUEST['Amount'] . ", ". $_REQUEST['Fee'];
						break;

				} //switch

				my_log('ba.nd', 'ALL', $detail);
				session_register('Error');
				$_SESSION['Error'] = $re;
				header("Location: exchange.php");
				exit;

			} else {// if ORderID
				session_register('Error');
				$_SESSION['Error'] = "OrderID is not exist";
				header("Location: exchange.php");
				exit;
			}
	}
} else {
	header("Location: index.php");
	exit;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function p1($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
?>
