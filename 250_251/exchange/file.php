<?php
ob_start();
session_start();
$_DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];

define("DAB_WEBSERVICE_URL", "https://webservice.dongabank.com.vn/securities/WSBean?wsdl");

require $_DOC_ROOT . '/libs/dab.php';

if ( $_SESSION['UserName'] != '') {
	if ( $_REQUEST['Type'] == "" || $_SESSION['Error'] != '' ) { ?>
		<form method="post">
<table align="center" width="30%" border="0">
	<tr>
		<td colspan="2" align="center"><font color="red" size="+2"><?=$_SESSION['Error'];?></font></td>
	</td>
	<tr>
		<td colspan="2" align="center">
			<select name="Type" size="1">
				<option value="1">Lock File</option>
				<option value="2">Aunction File</option>
				<option value="3">Cancel File</option>
				<option value="4">Sell File</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" value="Send" />
			<input type="button" value="Back" onclick="javascript: window.location='index.php'"/>
		</td>
	</tr>
</table>
		</form>

	<?
		session_unregister('Error');

	} else {

			$dab = &new CDAB();
			$soapclient = new SOAP_Client('http://172.25.2.99:8250/ws/exchange.php?wsdl');
			$soapclient->setOpt("timeout", 100);
			$options = array('namespace' => 'urn:CExchange', 'trace' => 1);

			$params = array(
									'OrderDate' => date("Y-m-d"),
									'BankID' => 2,
									'AuthenUser' => 'ba.nd', 'AuthenPass' => md5('hsc080hsc'));

			if ($_REQUEST['Type'] >0 ) {
				switch ($_REQUEST['Type']) {
					case '1':
						$re = $dab->releaseBidFile("/home/vhosts/bos/htdocs/", "getBid.xml");
						break;

					case '2':
						$re = $soapclient->call('getAuctionForXML', $params, $options);
						break;

					case '3':
						$re = $soapclient->call('getAllCancelBidForXML', $params, $options);
						break;

					case '4':
						$re = $soapclient->call('getAllSellForXML', $params, $options);
						break;

				} //switch

				session_register('Error');
				$_SESSION['Error'] = $re;
				header("Location: file.php");
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