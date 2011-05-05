<?php
require 'SOAP/Client.php';
require_once("XML/Unserializer.php");;
$soapclient = new SOAP_Client('http://210.245.112.228/vcb/vcb.php?wsdl' ); 
$ret1 = $soapclient->call('OpenAccount',
							$params = array( 
									'PersonalCard'=>'0982644', 'Name'=>'Ye li zhi', 'Address'=>'131 kkk', 'BankAccountNo'=>'145443', 'PartnerType'=>'C', 'dtBirthDay'=>'', 'PlaceOfBirth'=>'', 'dtDateIssue'=>'', 'PlaceIssue'=>'', 'ZipCode'=>'', 'Country'=>'VietNam', 'Email'=>'', 'Phone'=>'', 'Fax'=>'', 'CompanyAddress'=>'', 'CompanyPhone'=>'', 'MailingAddress'=>'', 'MailingPhone'=>'',								
									'AuthenUser' => 'vcb_eps', 
									'AuthenPass' => md5('hy6GT^lj(O04h1')),
                         $options);	
echo "---------------OpenAccount-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";
exit;
/*$tmpName = 'Dat_Lenh.xml';
	
	$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data= $image;
fclose($fp);
var_dump($data);
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 			
			var_dump($ret);*/
		//	exit;
//require 'includes.php';
$aa = new SoapClient('https://www.vietcombank.com.vn/secure/VCB_services/Securities_Service.asmx?wsdl', array('trace' => 1) ); 
/*'Reference_Number'=>'1273547', 
									'Stock_Account'=>'009C123456', 
									'Amount'=>'200000', 
									'Stock_Code'=>'', 
									'Stock_Price'=>'', 
									'Quantity'=>'', 
									'Reserve_Code'=>'0200',									
									'Transaction_Date'=>'170407', 
									'Command_Code'=>'0', 
									'Command_Style'=>'B',
									'Currency_Code'=>'VND', 
									'Securities_ID'=>'EPSHCM', 
									'Market_Command'=>'MP',
									'Command_Language'=>'V'*/
			$params["Reference_Number"] = '876543';
			$params["Stock_Account"] = '057FIS1752';
			$params["Amount"] = '200000';		
			$params["Stock_Code"] = 'EPS'; 
			$params["Stock_Price"] = '';
			$params["Quantity"] = '';
			$params["Reserve_Code"] = '0200';
			$params["Transaction_Date"] = '170407';
			$params["Command_Code"] = 'O'; 
			$params["Command_Style"] = 'B';
			$params["Currency_Code"] = 'VND';
			$params["Securities_ID"] = 'EPSHCM';  
			$params["Market_Command"] = "MP";
			$params["Command_Language"] = "V"; 
			//var_dump($aa);
			$aa->Dat_Lenh($params);								 	
			//var_dump($aa->__getLastResponse());
			$data = $aa->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 			
			var_dump($ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]);
			echo $ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'];
			//return $ret["soap:Body"]["NewCustomerResponse"]["NewCustomerResult"]["DS"];
			$params["Reference_Number"] = '1234576';
			$params["Stock_Account"] = '057FIS1752';
			$params["Amount"] = '200000';		
			$params["Stock_Code"] = ''; 
			$params["Stock_Price"] = '';
			$params["Quantity"] = '';
			$params["Reserve_Code"] = '0200';
			$params["Transaction_Date"] = '170407';
			$params["Command_Code"] = 'O'; 
			$params["Command_Style"] = 'B';
			$params["Currency_Code"] = 'VND';
			$params["Securities_ID"] = 'EPSHCM';  
			$params["Market_Command"] = "MP";
			$params["Command_Language"] = "V"; 
			//var_dump($aa);
			$aa->Khop_Lenh($params);								 	
			//var_dump($aa->__getLastResponse());
			$data = $aa->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 			
			var_dump($ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]);
			echo $ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]['RESPONSE_CODE'];
			exit;
$soapclient = new SOAP_Client('');//http://210.245.112.228/vcb/vcb.php?wsdlhttp://yelizhi.com.vn/vcb/vcb.php?wsdl'); 

$soapclient->setOpt("timeout", 100);
		//$soapClient->setOpt('curl', CURLOPT_VERBOSE, 0); 
		$soapclient->setOpt('curl', CURLOPT_SSL_VERIFYHOST, 0);
		$soapclient->setOpt('curl', CURLOPT_SSL_VERIFYPEER, 0); 
		$soapclient->setOpt('curl', CURLOPT_CAPATH, '/usr/local/ssl/certs'); 
var_dump($soapclient);
/*$ret1 = $soapclient->call('helloString',
							$params = array( 
									'InputString'=>'Diep Le Chi',
									'AuthenUser' => 'admin', 
									'AuthenPass' => md5('admin')
								),
                         $options);	
echo "---------------helloString-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";
Amount:			2000000
Stock_Code:		EPS
Stock_Price:		20000
Quantity:			100
Reserve_Code:		0200
Transaction_Date:		170407
Command_Code:		O
Command_Style:		B
Currency_Code:		VND
Securities_ID:		EPSHCM
Market_Command:		MP
Command_Language:	V
*/
$ret1 = $soapclient->call('Dat_Lenh',
							$params = array( 
									'Reference_Number'=>'1273547', 
									'Stock_Account'=>'009C123456', 
									'Amount'=>'200000', 
									'Stock_Code'=>'', 
									'Stock_Price'=>'', 
									'Quantity'=>'', 
									'Reserve_Code'=>'0200',									
									'Transaction_Date'=>'170407', 
									'Command_Code'=>'0', 
									'Command_Style'=>'B',
									'Currency_Code'=>'VND', 
									'Securities_ID'=>'EPSHCM', 
									'Market_Command'=>'MP',
									'Command_Language'=>'V'
								),
                         $options);	
echo "---------------Dat_Lenh-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;

$soapclient = new SOAP_Client('http://210.245.112.228/dab/dab.php?wsdl'); //yelizhi.com.vnhttp://172.25.2.251/dab/dab.php?wsdl
/*echo "<pre>";
print_r($soapclient);
echo "</pre>";
*/
$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
//$tmpName  = 'D:\www\back_to_top1.gif';
$tmpName  = 'D:\www\esms\doc_tester\dab_test.xml';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('errorfile',
							$params = array( 
									'FileName'=>'chi_test_20070827.xml',
									'FileContent' =>  $data["image"],								
									'AuthenUser' => 'admin', 
									'AuthenPass' => md5('admin')),
                         $options);	
echo "---------------errorfile-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;
$dab = &new CDAB();

$chkbankaccount = $dab->sellFile('/home/vhosts/eps/htdocs/', 'DAB_20070815_sell.xml');
echo "<pre> sellFile";
p($chkbankaccount);
echo "</pre>";
$chkbankaccount = $dab->auctionFile('/home/vhosts/eps/htdocs/', 'DAB_20070815_auction.xml');
echo "<pre> auctionFile";
p($chkbankaccount);
echo "</pre>";
$chkbankaccount = $dab->releaseBidFile('/home/vhosts/eps/htdocs/', 'DAB_20070815_cancelBid.xml');
echo "<pre> releaseBidFile";
p($chkbankaccount);
echo "</pre>";

exit;

			$chkbankaccount = $dab->associateBankAccount('123456', '124365', '123654');
			echo "<pre>";
p($chkbankaccount);
echo "</pre>";
			if($chkbankaccount !=  0) $ERROR_CODE = 18137;
			//unauthenticate partner 
			if($chkbankaccount == -1) $ERROR_CODE = 18132;
			//invalid parameters
			if($chkbankaccount == -2) $ERROR_CODE = 18133;
			//invalid date
			if($chkbankaccount == -3) $ERROR_CODE = 18134;
			//No customer found
			if($chkbankaccount == -4) $ERROR_CODE = 18135;
			//Customer disable
			if($chkbankaccount == -5) $ERROR_CODE = 18136;
echo $chkbankaccount;
exit;

$soapclient = new SOAP_Client('http://210.245.112.226/dab/dab.php?wsdl'); //yelizhi.com.vnhttp://172.25.2.251/dab/dab.php?wsdl
/*echo "<pre>";
print_r($soapclient);
echo "</pre>";
*/
$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
//$tmpName  = 'D:\www\back_to_top1.gif';
$tmpName  = 'D:\www\esms\doc_tester\dab_test.xml';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('errorfile',
							$params = array( 
									'FileName'=>'dab_test.xml',
									'FileContent' =>  $data["image"],								
									'AuthenUser' => 'admin', 
									'AuthenPass' => md5('admin')),
                         $options);	
echo "---------------errorfile-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;
/*
require 'configuration.php';
$url = DAB_WEBSERVICE_URL;
		$soapClient = new SOAP_Client("https://webservice.dongabank.com.vn/security/WSBean?wsdl", true);
		$soapClient->setOpt("timeout", 100);
		//$soapClient->setOpt('curl', CURLOPT_VERBOSE, 0); 
		$soapClient->setOpt('curl', CURLOPT_SSL_VERIFYHOST, 0);
		$soapClient->setOpt('curl', CURLOPT_SSL_VERIFYPEER, 0); 
		$soapClient->setOpt('curl', CURLOPT_CAPATH, '/usr/local/ssl/certs'); 
		$soapOptions = array('namespace' => 'http://controller.com.eab', 'trace' => 1);

		$secretkey = "5wMr N5lFU?|!b)R^jZN,lebw~xVPz9+XG\"NHB?N";
		$hasher =& new Crypt_HMAC($secretkey, "sha1");

		$soapClient = $soapClient;
		$accessKey = "JnShns06ip2cQ6S2vxKZ";
		$timestamp = date("d/m/Y H:i:s");
		
		$function = "checkDABCustomer";
		
		$stringToSign = $function . $timestamp;
		$signature = hex2b64($hasher->hash($stringToSign));
		$header = new SOAP_Header ( 
											"securityHeader",          
											NULL,          
											array( 'paccesskey' => $accessKey, 'timestamp' => $timestamp, "signature" => $signature, "action" => $function ) );
		$soapClient->addHeader($header ); 
		
		//$this->addSOAPHeader($function);

		$result = $soapClient->call($function,
									 $params = array( 
															'custaccount' => '123456', 
															'scraccount' => '123456', 
															'CID' => '123456',
															'scrdate' => date("YmdHis") ),
									$soapOptions);
		echo "---------------checkDABCustomer-------------";
echo "<pre>";
p($result);
echo "</pre>";
		
		
		
		$function = "sellFile";
		
		$stringToSign = $function . $timestamp;
		$signature = hex2b64($hasher->hash($stringToSign));
		$header = new SOAP_Header ( 
											"securityHeader",          
											NULL,          
											array( 'paccesskey' => $accessKey, 'timestamp' => $timestamp, "signature" => $signature, "action" => $function ) );
		$soapClient->addHeader($header ); 
		
		//$this->addSOAPHeader($function);

		$result = $soapClient->call($function,
									$params = array( 
											'filename' => $filename,
											'filecontent' => $filecontent,
											 ),
									$soapOptions);
		echo "---------------sellFile-------------";
echo "<pre>";
p($result);
echo "</pre>";
		exit;
		*/
$dab = &new CDAB();
			//p(DAB_WEBSERVICE_URL);
			//var_dump($dab);
			$chkbankaccount = $dab->associateBankAccount('123456', '124365', '123654');
			echo "<pre>";
p($chkbankaccount);
echo "</pre>";
			if($chkbankaccount !=  0) $ERROR_CODE = 18137;
			//unauthenticate partner 
			if($chkbankaccount == -1) $ERROR_CODE = 18132;
			//invalid parameters
			if($chkbankaccount == -2) $ERROR_CODE = 18133;
			//invalid date
			if($chkbankaccount == -3) $ERROR_CODE = 18134;
			//No customer found
			if($chkbankaccount == -4) $ERROR_CODE = 18135;
			//Customer disable
			if($chkbankaccount == -5) $ERROR_CODE = 18136;
			
$tmpName  = '/home/vhosts/sandbox/htdocs/signature/057C001234_AssignLaw.xml';
//$tmpName  = 'D:\www\esms\doc_tester\Error_Code.XML';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));

//$dab = &new CDAB();
			//p(DAB_WEBSERVICE_URL);
			//var_dump($dab);
			$chkbankaccount = $dab->sellFile('Error_codes.XML', htmlspecialchars($data["image"]));
			echo "<pre>";
p($chkbankaccount);
echo "</pre>";
			//chk error
			if($chkbankaccount !=  0) $ERROR_CODE = 18137;
			//unauthenticate partner 
			if($chkbankaccount == -1) $ERROR_CODE = 18132;
			//invalid parameters
			if($chkbankaccount == -2) $ERROR_CODE = 18133;
			//invalid date
			if($chkbankaccount == -3) $ERROR_CODE = 18134;
			//No customer found
			if($chkbankaccount == -4) $ERROR_CODE = 18135;
			//Customer disable
			if($chkbankaccount == -5) $ERROR_CODE = 18136;
exit;

$soapclient = new SOAP_Client('http://172.25.2.251/ws/account.php?wsdl'); //yelizhi.com.vn

$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
//$tmpName  = 'D:\www\back_to_top1.gif';
$tmpName  = 'D:\www\esms\doc_tester\Error_codes.XML';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  '057C001234',
									'Type'			=> 'AssignLaw',
									'FileExtension' => 'XML',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;


$ret = $soapclient->call('addAccount',
							$params = array( 														
									"AccountID" 			=> 0, 
									"AccountNo"				=> '057C101459',
									"ContractNo" 			=> '220a92222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 29,	
									"FirstName"				=> 'Si', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '12379aa6590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 1, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 3,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 0,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '18x7355461',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 0,
									"AssignLawFirstName" 	=> 'hello', 
									"AssignLawLastName" 	=> 'ggg', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggsg35gg',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> '15874521', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"CreatedBy" 			=> 'chi.dl',																 									'InvestorDOB'			=> '1981/12/12',
									'AssignDOB'				=> '1981/12/12',
									'AssignEmail'			=> 'chi@chi.com',
									'AssignLawDOB'			=> '1981/12/12',
									'AssignLawEmail'		=> 'chi@chi.aaa',
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);

echo "---------------addAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

exit;
$ret = $soapclient->call('listAccountBank',
							$params = array( 
									'AccountID'		=> '1',	//011C004444														
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------listAccountBank-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

$ret = $soapclient->call('deleteAccountBank',
							$params = array( 
									'AccountID'		=> '1',	//011C004444														
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------deleteAccountBank-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

$ret = $soapclient->call('addAccountBank',
							$params = array( 
									'AccountID'		=> '1',	//011C004444	
									'BankID'		=> 1,
									'BankAccount'	=> '123456',
									'Priority'		=> '1',
									'CreatedBy'		=> 'chi.dl',												
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------listAccountBank-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;




 $ret = $soapclient->call('updateAgencyFeeForAccount',
							$params = array( 
									'AccountNo'		=> '057C272763',	//011C004444
									'AgencyFeeID'	=> '1',	
									'UpdatedBy'		=> 'chi.dl',							
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------getAccountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

  $ret = $soapclient->call('getAccountMoney', //172.25.2.252
							$params = array( 
									'AccountNo'		=> '057C005244',	//011C004444
									'TradingDate'	=> '2007-06-04',								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('123456')),
                         $options);	
echo "---------------getAccountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;
$ret = $soapclient->call('listInvestorAssign',
                          $params = array(        
								"AccountNo"=>"057C272763",
								"OrderDate"              => '2007-07-26',   
								'AuthenUser'    => 'admin',
                                'AuthenPass'    => md5('admin')),
                         $options);
echo "---------------listInvestorAssign-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

$ret1 = $soapclient->call('listStockDetailByTradingDate',
							$params = array( 
									'TradingDate'=> '2007-06-21',
									'AccountNo'		=>  '057C171717',
									'Type'			=> 'Investor',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------listStockDetailByTradingDate-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";
exit;
$soapclient = new SOAP_Client('http://172.25.2.252/ws/account.php?wsdl');
$ret1 = $soapclient->call('viewAccountInfo',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  '057C171717',
									'Type'			=> 'Investor',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";
exit;
$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
$tmpName  = 'D:\www\back_to_top1.gif';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  '057C171717',
									'Type'			=> 'AssignLaw',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;





$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
$tmpName  = 'D:\www\back_to_top1.gif';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  '056C001010',
									'Type'			=> 'Investor',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;


$ret = $soapclient->call('checkAccountNo',
                          $params = array(     
						  		"ID"	=>0,
								"Prefix"	=> '056C',   
								"AccountNo"=>"001223",
								"CreatedBy"              => 'chi',   
								'AuthenUser'    => 'admin',
                                'AuthenPass'    => md5('123456')),
                         $options);
echo "---------------listInvestorAssign-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;
/**/
/*
$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/test.gif';//
$tmpName  = 'D:\www\back_to_top1.gif';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
//echo '<br>';
//echo '<br>';
*/
$soapclient = new SOAP_Client('http://172.25.2.251/ws/account_test.php?wsdl');//yelizhi.com.vn-

$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
/*$tmpName  = 'D:\www\back_to_top1.gif';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  '056C999999',
									'Type'			=> 'Investor',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;
*/
$ret = $soapclient->call('readImage1',
							$params = array( 									
									'ImageName'		=> 'test.gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
						 echo "<pre>";
print_r($ret);
echo "</pre>";
//echo chunk_split($ret->items[0]->ImageSignature);exit;
$image = base64_decode($ret->items[0]->ImageSignature);//
	if(!is_null($image))
	{
		header('Content-type: image/gif');
		echo $image;
	}exit;
echo "---------------readimage-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";


//echo base64_decode($data["image"]);
exit;
/*$ret = $soapclient->call('addAccount',
							$params = array( 														
									"AccountID" 			=> 0, 
									"AccountNo"				=> '011C101459',
									"ContractNo" 			=> '220a92222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 29,	
									"FirstName"				=> 'Si', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '12379aa6590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 0, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 3,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 0,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '18x7355461',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 0,
									"AssignLawFirstName" 	=> 'hello', 
									"AssignLawLastName" 	=> 'ggg', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggsg35gg',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> '15874521', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"CreatedBy" 			=> 'chi.dl',																 									'InvestorDOB'			=> '1981/12/12',
									'AssignDOB'				=> '1981/12/12',
									'AssignEmail'			=> 'chi@chi.com',
									'AssignLawDOB'			=> '1981/12/12',
									'AssignLawEmail'		=> 'chi@chi.aaa',
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	*/
//echo count($params) . " client";
//var_dump($params);, 'InvestorDOB', 'AssignDOB', 'AssignEmail', 'AssignLawDOB', 'AssignLawEmail'

$ret = $soapclient->call('updateAccount',
							$params = array( 														
									"AccountID" 			=> 244, 
									"AccountNo"				=> '011C101459',
									"ContractNo" 			=> '220a92222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 366,	
									"FirstName"				=> 'Si', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '12379aa6590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 0, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 2,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 491,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '18x7355461',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 492,
									"AssignLawFirstName" 	=> 'GiGi', 
									"AssignLawLastName" 	=> 'Ye', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggsg35gg',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> '15874521', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"UpdatedBy" 			=> 'chi.dl',																 									'InvestorDOB'			=> '1981/12/12',
									'AssignDOB'				=> '1981/12/12',
									'AssignEmail'			=> 'chi@chi.com',
									'AssignLawDOB'			=> '1981/12/12',
									'AssignLawEmail'		=> 'chi@chi.aaa',
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------updateAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=> $ret->items[0]->AccountNo?$ret->items[0]->AccountNo:'011C101459',
									'Type'			=> 'Investor',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";
$imagetypearr = array('image/gif','image/jpeg','image/png','image/pjpeg');
//$tmpName  = '/home/vhosts/sandbox/htdocs/signature/logo.gif';//
$tmpName  = 'D:\www\logo.gif';
$data["image"] = '';
$fp      = fopen($tmpName, 'r');
$image = fread($fp, filesize($tmpName));
//echo '<br>';
//echo '<br>';
$data["image"] = chunk_split(base64_encode($image));
//$data["image"] = str_replace('/','',$data["image"]);
//$data["image"] = str_replace('+','',$data["image"]);
fclose($fp);
$ret1 = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'AccountNo'		=>  $ret->items[0]->AccountNo?$ret->items[0]->AccountNo:'011C101459',
									'Type'			=> 'Assign',
									'FileExtension' => 'gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret1);
echo "</pre>";

exit;
exit;
/*$ret = $soapclient->call('listAccountWithFilter',
                          $params = array(        
								"Where"=>"",
								"TimeZone"              => '+07:00',                                'AuthenUser'    => 'admin',
                                'AuthenPass'    => md5('admin')),
                         $options);
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
$ret = $soapclient->call('writeImage1',
							$params = array( 
									'ImageSignature'=> htmlspecialchars($data["image"]),
									'ImageName'		=> 'logo123456789.gif',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;*/


$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/account.php?wsdl');//
$ret = $soapclient->call('listInvestorAssign',
							$params = array( 
									'AccountNo'=> '011C001234',
									'OrderDate'		=> '2007-07-17',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> md5('admin')),
                         $options);	
echo "---------------writeimage-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

exit;

$handle = fopen("D:\\www\\esms\\back_to_top.gif", "w");
if (fwrite($handle, base64_decode($data["image"])) === FALSE) {
	echo "Cannot write to file ($filename)";
	exit;
}
echo "Success, wrote to file back_to_top1.gif";
    
    fclose($handle);
    
exit;
exit;

$soapclient = new SOAP_Client('http://192.168.0.15/websetup1/service.asmx?WSDL');
$options = array('namespace' => 'http://192.168.0.15/websetup1/service.asmx?WSDL', 'trace' => 1);

$re = $soapclient->call('BlockAmount',
$params = array( 'p_ac' => '1000000',
				  'p_amount' => '1000000',
				  'p_remark' => '1000000',
				  'p_user' => '1000000',
), $options);
echo "---------------BlockAmount-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;

$client = new SoapClient("http://192.168.0.15/websetup1/service.asmx?WSDL", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));

$client->setCredentials("pnhdt","123456");
/*$client = new SoapClient("http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));
$client->setHeaders("<AuthHeader xmlns=\"203.113.145.197:8181\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");*/
$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";

exit;


$soapclient = new SOAP_Client('http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl',true, '',array('user'=>'pnhdt','pass'=>'123456') );
//p($soapclient);
//$soapclient->setOpt("timeout", 100);

// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

$re = $soapclient->call('sayHello',
$params = array( 'userID' => 'pnhdt',
'message' => 'aaa' ), $options);
echo "---------------sayHello-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;


$client = new SoapClient("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));

$client->setCredentials("pnhdt","123456");
/*$client = new SoapClient("http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));
$client->setHeaders("<AuthHeader xmlns=\"203.113.145.197:8181\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");*/
$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
var_dump($client);
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

echo $client->__call("sayHello", $params = array(
                                    'userID'     => 'pnhdt',
                                    'message'     => 'e10adc3949ba59abbe56e057f20f883e'),$options);
exit;



$client = new SoapClient("https://webservice.dongabank.com.vn/security/WSBean?wsdl", array(
    "login"      => "",
    "password"   => "",
    "trace"      => 1,
    "exceptions" => 0));

//$client->yourFunction();
//$client->setOpt('curl', CURLOPT_SSLCERT, 'd:\www\esms\wsdongabank.crt');
var_dump($client);
  $client->setOpt('curl', CURLOPT_VERBOSE, '1');
        $client->setOpt('curl', CURLOPT_SSL_VERIFYHOST, '0');
        $client->setOpt('curl', CURLOPT_SSL_VERIFYPEER, '0');
        $client->setOpt('curl', CURLOPT_SSLCERT, 'd:\www\esms\wsdongabank.crt');
        $client->setOpt('curl', CURLOPT_SSLCERTPASSWD, '');
        $client->setOpt('curl', CURLOPT_POST, '0');
        $client->setOpt('curl', CURLOPT_RETURNTRANSFER, '1'); 
		
print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
/*var_dump($client);*/
$options = array('namespace' => 'http://controller.com.eab', 'trace' => 1);
$ret=$client->__call("getString", $params = array(
                                    'str'     => 'Diep Le Chi',
                                    ),$options);
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret=$client->__call('bid',
$params = array(    'partnercode'     => 'EPS',
					'password'     => 'e10adc3949ba59abbe56e057f20f883e',
					'custaccount'     => '0101000035',
					'scraccount'     => '056C001234',
					'refno'     => '1',
					'amount'     => '10000000',
					'fee'     => '100000',
					'scrdate'     => '20070706142450'

), $options);
echo "---------------bid-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;


//https://webservice.dongabank.com.vn/security/WSBean?wsdl
$soapclient = new SOAP_Client('https://webservice.dongabank.com.vn/security/WSBean?wsdl',true);
//p($soapclient);
$soapclient->setOpt("timeout", 100);
//$soapclient->setOpt("curl",CURLOPT_SSL_VERIFYPEER,'0');
$soapclient->setOpt('curl', CURLOPT_VERBOSE, '1');
$soapclient->setOpt('curl', CURLOPT_SSL_VERIFYHOST, '0');
$soapclient->setOpt('curl', CURLOPT_SSL_VERIFYPEER, '0');
/*$soapclient->setOpt('curl', CURLOPT_SSLCERT, 'c:\certificate.pem');
$soapclient->setOpt('curl', CURLOPT_SSLCERTPASSWD, 'xzhengpw');
$soapclient->setOpt('curl', CURLOPT_POST, '0');
$soapclient->setOpt('curl', CURLOPT_RETURNTRANSFER, '1'); */
// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);
/*
    partnercode - the code of partner
    password - the partner's password
    custaccount - the account number of customer at DAB
    scraccount - the account number of customer at Partner
    refno - the reference number from partner
    amount - the bid's money
    fee - the fee of this bid
    scrdate - bid date
*/
$re = $soapclient->call('bid',
$params = array(  'partnercode'     => 'EPS',
					'password'     => 'e10adc3949ba59abbe56e057f20f883e',
					'custaccount'     => '0101000035',
					'scraccount'     => '056C001234',
					'refno'     => '1',
					'amount'     => '10000000',
					'fee'     => '100000',
					'scrdate'     => '20070706142450'

), $options);
echo "---------------bid-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;



$client = new SoapClient("https://webservice.dongabank.com.vn/security/WSBean?wsdl", array(
    "login"      => "",
    "password"   => "",
    "trace"      => 1,
    "exceptions" => 0));

//$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
/*var_dump($client);*/
$options = array('namespace' => 'http://controller.com.eab', 'trace' => 1);
$ret=$client->__call("getString", $params = array(
                                    'str'     => 'Diep Le Chi',
                                    ),$options);
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret=$client->__call('bid',
$params = array(    'partnercode'     => 'EPS',
					'password'     => 'e10adc3949ba59abbe56e057f20f883e',
					'custaccount'     => '0101000035',
					'scraccount'     => '056C001234',
					'refno'     => '1',
					'amount'     => '10000000',
					'fee'     => '100000',
					'scrdate'     => '20070706142450'

), $options);
echo "---------------bid-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

//https://webservice.dongabank.com.vn/security/WSBean?wsdl
$soapclient = new SOAP_Client('https://webservice.dongabank.com.vn/security/WSBean?wsdl');
//p($soapclient);
$soapclient->setOpt("timeout", 100);
$soapclient->setOpt("curl", CURLOPT_SSL_VERIFYPEER,0);

// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);
/*
    partnercode - the code of partner
    password - the partner's password
    custaccount - the account number of customer at DAB
    scraccount - the account number of customer at Partner
    refno - the reference number from partner
    amount - the bid's money
    fee - the fee of this bid
    scrdate - bid date
*/
$re = $soapclient->call('bid',
$params = array(  'partnercode'     => 'EPS',
					'password'     => 'e10adc3949ba59abbe56e057f20f883e',
					'custaccount'     => '0101000035',
					'scraccount'     => '056C001234',
					'refno'     => '1',
					'amount'     => '10000000',
					'fee'     => '100000',
					'scrdate'     => '20070706142450'

), $options);
echo "---------------bid-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;


$client = new SoapClient("https://webservice.dongabank.com.vn/services/WSBean?wsdl", array(
    "login"      => "",
    "password"   => "",
    "trace"      => 1,
    "exceptions" => 0));

//$client->setCredentials("pnhdt","123456");
/*$client = new SoapClient("http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));
$client->setHeaders("<AuthHeader xmlns=\"203.113.145.197:8181\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");*/
$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
var_dump($client);
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

$ret=$client->__call("getString", $params = array(
                                    'str'     => 'Diep Le Chi',
                                    ),$options);
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

 $soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/withdrawal_deposit.php?wsdl');
 $ret = $soapclient->call('approveWithdrawalDeposit',
							$params = array( 
									"ID" 	=> 68, 
									"WDType" 		=> 'D',																	
									"UpdatedBy" 	=> 'chi.dl', 
									"ApproveDate"	=> '2007-07-05',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------approveWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;


$proxy=array('proxy_host'=>'203.113.145.197','proxy_host'=>"8181",'user'=>'pnhdt','pass'=>'123456');

/*$wsdl = new SOAP_WSDL("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl",$proxy);

//var_dump($wsdl);

$client = new SOAP_Client("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl",true,'',$proxy);
echo "<br>";
echo "-----------------";
*/
$soapclient = new SOAP_Client('http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl',true, '',array('user'=>'pnhdt','pass'=>'123456') );
//p($soapclient);
//$soapclient->setOpt("timeout", 100);

// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

$re = $soapclient->call('sayHello',
$params = array( 'userID' => 'pnhdt',
'message' => 'aaa' ), $options);
echo "---------------sayHello-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;

$client = new SoapClient("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));

$client->setCredentials("pnhdt","123456");
/*$client = new SoapClient("http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));
$client->setHeaders("<AuthHeader xmlns=\"203.113.145.197:8181\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");*/
$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
var_dump($client);
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

echo $client->__call("sayHello", $params = array(
                                    'userID'     => 'pnhdt',
                                    'message'     => 'e10adc3949ba59abbe56e057f20f883e'),$options);
exit;


$soapclient = new SOAP_Client('http://pnhdt:123456aa@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl');
//$soapclient->setCredentials("pnhdt","123456");
//p($soapclient);
//$soapclient->setOpt("timeout", 100);

// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

$re = $soapclient->call('sayHello',
$params = array( 'userID' => 'pnhdt',
'message' => 'aaa' ), $options);
echo "---------------sayHello-------------";
echo "<pre>";
print_r($re);
echo "</pre>";

exit;


/*$soapclient = new SOAP_Client('http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl' );

//p($soapclient);
$soapclient->setOpt("timeout", 600);
*/
$client = new SoapClient("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));

$client->setCredentials("pnhdt","123456");
// This namespace is the same as declared in server.php.
$options = array('namespace' => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws', 'trace' => 1);

$ret = $client->__call('sayHello',
$params = array( 'userID' => 'Diep Le Chi',
'message' => 'Programmer' ), $options);
echo "---------------sayHello-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;
  $soap = new SOAP_Client('http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl');
  $username = 'pnhdt';
$password = '123456';
 $soap->setHeaders("<AuthHeader xmlns=\"lokad.com/ws\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");
$ret = $soap->call('sayHello',
                            $params = array(
                                    'AuthenUser'     => 'ba.nd',
                                    'AuthenPass'     => md5('00db007')),
                         $options);
  
echo "---------------sayHello-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";


exit;


$client = new SoapClient("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "1234567",
    "trace"      => 1,
    "exceptions" => 0));

$client->setCredentials("pnhdt","1234567");
/*$client = new SoapClient("http://pnhdt:123456@203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl", array(
    "login"      => "pnhdt",
    "password"   => "123456",
    "trace"      => 1,
    "exceptions" => 0));
$client->setHeaders("<AuthHeader xmlns=\"203.113.145.197:8181\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");*/
$client->yourFunction();

print "<pre>\n";
print "Request: \n".htmlspecialchars($client->__getLastRequest()) ."\n";
print "Function: \n".var_dump($client->__getFunctions() )."\n";
print "Response: \n".htmlspecialchars($client->__getLastResponse())."\n";
print "</pre>";
var_dump($client);
echo $client->call("sayHello", $params = array(
                                    'userID'     => 'pnhdt',
                                    'message'     => 'e10adc3949ba59abbe56e057f20f883e'),'','');
exit;
$soap = new SOAP_Client('http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl');
  $username = 'pnhdt';
$password = '123456';
 $soap->setHeaders("<AuthHeader xmlns=\"lokad.com/ws\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");
$ret = $soap->call('sayHello',
                            $params = array(
                                    'AuthenUser'     => 'ba.nd',
                                    'AuthenPass'     => md5('00db007')),
                         $options);
  
echo "---------------sayHello-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
exit;
 
 
  $soap = new SOAP_Client('http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl');
  $username = 'pnhdt';
$password = '123456';
 $soap->setHeaders("<AuthHeader xmlns=\"lokad.com/ws\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");
$ret = $client->call('sayHello',
                            $params = array(
                                    'AuthenUser'     => 'ba.nd',
                                    'AuthenPass'     => 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);
  
echo "---------------sayHello-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

// adds authentication to a SOAP client
// returns true if the authentication was successful
function addAuthentication($soap, $username, $password)
{
    // username and password are added in an AuthHeader
    $soap->setHeaders("<AuthHeader xmlns=\"lokad.com/ws\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");

    // we check if the authentication was successful
    $result = $soap->call('IsAuthenticated','','');
  

    if ($error = $soap->getError()) die($error);
    return ($result["IsAuthenticatedResult"] == 'true');
}
addAuthentication($soap, $username, $password);
exit;
/*
$url = 'http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl';
$wsdl = new SOAP_WSDL($url);
$soap = $wsdl->getProxy();
$auth = $soap->Authenticate('pnhdt','123456','none','none');
$gks = $soap->getKnownServers($auth->SID,10);
*/

$proxy=array('proxy_user'=>'pnhdt','proxy_pass'=>'123456');

$wsdl = new SOAP_WSDL("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl",$proxy);

var_dump($wsdl);

$client = new SOAP_Client("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl",false,false,$proxy);
echo "<br>";
echo "-----------------";

var_dump($client); 
echo "<br>";
$client = new SOAP_Client("http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl");
echo "<br>";
echo "-----------------";

var_dump($client); 
echo "<br>";

// or
$ret = $client->call('sayHello',
                            $params = array(
                                    'AuthenUser'     => 'ba.nd',
                                    'AuthenPass'     => md5('00db007')),
                         $options);
  
echo "---------------sayHello-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/account.php?wsdl');
$ret = $soapclient->call('listAccountWithFilter1',
                                                        $params = array(        
                                                                        "Where"=>"",
                                                                        "TimeZone"              => '+07:00',                                                                                                                                    

'AuthenUser'    => 'admin',
                                                                        'AuthenPass'    => '21232F297A57A5A743894A0E4A801FC3'),
                         $options);
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
/*

// example of Auth_HTTP basic implementation 

require_once("Auth/HTTP.php");

// setting the database connection options
$AuthOptions = array(
'dsn'=>"http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl",
'table'=>"",                            // your table name 
'usernamecol'=>"pnhdt",            // the table username column
'passwordcol'=>"123456",            // the table password column
'cryptType'=>"none",                // password encryption type in your db
);


$a = new Auth_HTTP("DB", $AuthOptions);

$a->setRealm('yourrealm');            // realm name
$a->setCancelText('<h2>Error 401</h2>');        // error message if authentication fails
$a->start();                    // starting the authentication process


if($a->getAuth())                // checking for autenticated user 
{
    echo "Hello $a->username welcome to my secret page";
    
};




$options = array(
        'wsdl'           => 'http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl',
        'authentication' => 'headers',
        'implementation' => 'detect',
        'soapoptions'    => array('trace'=>1,'exceptions'=>0)
    );

$username = 'pnhdt';
$password = '123456';

    // login option 1: using username & password (to be sent with next method call)
    $service =& new Webservices($options ,$username, $password);
/*

 $soap = new SOAP_Client('http://203.113.145.197:8181/axis/test/acbTCBS.jws?wsdl');
$username = 'pnhdt';
$password = '123456';

// adds authentication to a SOAP client
// returns true if the authentication was successful
function addAuthentication($soap, $username, $password)
{
    // username and password are added in an AuthHeader
    $soap->setHeaders("<AuthHeader xmlns=\"lokad.com/ws\">
                           <UserName>$username</UserName>
                           <Password>$password</Password>
                       </AuthHeader>");

    // we check if the authentication was successful
    $result = $soap->call('IsAuthenticated');
    if ($error = $soap->getError()) die($error);
    return ($result["IsAuthenticatedResult"] == 'true');
}
addAuthentication($soap, $username, $password);

*/

/**
 * This client runs against the example server in SOAP/example/server.php.  It
 * does not use WSDL to run these requests, but that can be changed easily by
 * simply adding '?wsdl' to the end of the url.
 */
//echo $_SERVER['REMOTE_ADDR'];
 //$soapclient = new SOAP_Client('http://192.168.1.252/ws/account.php?wsdl');
 /*require_once("includes.php");
	require_once("XML/Unserializer.php");
 $soap = &new Bravo();
$new_account = array("AccountNo" => '011C001234', "AccountName" => 'inLastName inFirstName', "Address" => 'inResidentAddress');	
$ret = $soap->addNewCustomer($new_account);
var_dump($ret);
$new_account = array("AccountNo" => '011C001223', "AccountName" => 'Diep Chi', "Address" => 'inResidentAddress');	
$ret = $soap->addNewCustomer($new_account);
var_dump($ret);
*/
/*
$value ='';
require_once("configuration.php");
	
	require_once("MDB2.php");
	//initialize MDB2
	define("TBL_ASSIGNLAW", "`assign`");
define("TBL_ASSIGNLAW1", "`assignlaw`");

	$mdb2 = &MDB2::factory(DB_DNS_WRITE);
	$mdb2->loadModule('Extended');
	$mdb2->loadModule('Date');
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$timezone="+07:00";
	$condition = $condition?' AND '.$condition:'';	
$select = sprintf("SELECT concat(%s.FirstName,', ',%s.LastName) as InvestorName,%s.OpenDate, CONVERT_TZ(%s.CloseDate,'+00:00','%s') as  CloseDate, CONVERT_TZ(%s.CreatedDate,'+00:00','%s') as CreatedDate, CONVERT_TZ(%s.UpdatedDate,'+00:00','%s') as UpdatedDate, %s.ID, %s.AccountNo, %s.ContractNo, %s.InvestorID , %s.BranchID, %s.BranchName, %s.CardNo as AssignCardNo, %s.CardNo as InvestorCardNo, %s.CreatedBy, %s.UpdatedBy", TBL_INVESTOR, TBL_INVESTOR, TBL_ACCOUNT, TBL_ACCOUNT, $timezone, TBL_ACCOUNT, $timezone, TBL_ACCOUNT, $timezone, TBL_ACCOUNT, TBL_ACCOUNT, TBL_ACCOUNT, TBL_ACCOUNT, TBL_ACCOUNT, TBL_BRANCH, TBL_ASSIGN, TBL_INVESTOR,TBL_ACCOUNT,TBL_ACCOUNT);
		echo $query = sprintf("%s FROM %s, %s, %s LEFT JOIN %s ON (%s.ID=%s.AssignID AND %s.Deleted='0') LEFT JOIN %s as %s ON (%s.ID=%s.AssignLawID AND %s.Deleted='0') WHERE %s.Deleted='0' AND %s.Deleted='0' AND %s.InvestorID=%s.ID AND %s.ID=%s.BranchID AND (%s.CloseDate is NULL OR %s.CloseDate='') %s Order By %s.ID DESC LIMIT 20", $select , TBL_ACCOUNT, TBL_BRANCH, TBL_INVESTOR, TBL_ASSIGN, TBL_ASSIGN, TBL_INVESTOR, TBL_ASSIGN, TBL_ASSIGNLAW, TBL_ASSIGNLAW1, TBL_ASSIGNLAW1, TBL_INVESTOR, TBL_ASSIGNLAW1, TBL_ACCOUNT, TBL_INVESTOR,  TBL_ACCOUNT, TBL_INVESTOR, TBL_BRANCH, TBL_ACCOUNT, TBL_ACCOUNT, TBL_ACCOUNT, $condition, TBL_ACCOUNT);
		
		$result = $mdb2->extended->getAll($query);
		$num_row = count($result);
		$mdb2->disconnect();
		if($num_row>0)
		{
			for($i=0; $i<$num_row; $i++) {
			
						$value[]=array(
							'ID'  => $result[$i]['id'], 
							'InvestorName'  => $result[$i]['investorname'], 
							'AccountNo'  => $result[$i]['accountno'], 
							'ContractNo'  => $result[$i]['contractno'], 
							'OpenDate'  => $result[$i]['opendate'], 
							'CloseDate'  =>  $result[$i]['closedate'], 
							'InvestorID'  => $result[$i]['investorid'], 
							'BranchID'  => $result[$i]['branchid'], 
							'BranchName'  => $result[$i]['branchname'],
							'AssignCardNo'  =>  $result[$i]['assigncardno'],
							'InvestorCardNo'  => $result[$i]['investorcardno'], 
							'CreatedBy'  => $result[$i]['createdby'], 
							'CreatedDate'  => $result[$i]['createddate'] ,
							'UpdatedBy'  => $result[$i]['updatedby'], 
							'UpdatedDate'  => $result[$i]['updateddate'] 			
							);
					
			}
		}
		var_dump($value);*/
	/*	$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/account.php?wsdl');
$ret = $soapclient->call('listAccountWithFilter',
                                                        $params = array(        
                                                                        "Where"=>"",
                                                                        "TimeZone"              => '+07:00',                                                                                                                                    

'AuthenUser'    => 'admin',
                                                                        'AuthenPass'    => '21232F297A57A5A743894A0E4A801FC3'),
                         $options);
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

 $soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/employee.php?wsdl');
 $ret = $soapclient->call('listEmployees',
							$params = array( 																		
									"TimeZone"		=> '+07:00', 																								
										'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
//$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/transfer.php?wsdl');
 $soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/withdrawal_deposit.php?wsdl');
 $ret = $soapclient->call('approveWithdrawalDeposit',
							$params = array( 
									"ID" 	=> 67, 
									"WDType" 		=> 'D',																	
									"UpdatedBy" 	=> 'chi.dl', 
									"ApproveDate"	=> '2007-07-03',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------approveWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
 /*$ret = $soapclient->call('addWithdrawalDeposit',
							$params = array( 
									"AccountID" 	=> 1, 
									"AmountMoney" 	=> 10000000, 
									"WDDate" 		=> '2007-06-20',
									"WDType" 		=> 'D',
									"Note" 			=> 'Rut tien test bravo', 	
									"CardNo" 		=> '123796590', 
									"CreatedBy" 	=> 'chi.dl', 
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------addWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*$ret = $soapclient->call('approveWithdrawalDeposit',
							$params = array( 
									"ID" 	=> 18, 
									"WDType" 		=> 'D',																	
									"UpdatedBy" 	=> 'chi.dl', 
									"ApproveDate"	=> '2007-06-21',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------approveWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";/**/
/*
 $soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/account.php?wsdl');
$ret = $soapclient->call('updateAccount',
							$params = array( 														
									"AccountID" 			=> 237, 
									"AccountNo"				=> '011C001459',
									"ContractNo" 			=> '2202222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 29,	
									"FirstName"				=> 'Si A', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '123796590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 0, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 3,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 0,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '18755461',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 0,
									"AssignLawFirstName" 	=> 'hello', 
									"AssignLawLastName" 	=> 'ggg', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggg5gg',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> '15874521', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"UpdatedBy" 			=> 'chi.dl',																 			
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
//echo count($params) . " client";
//var_dump($params);
echo "---------------updateAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
/*
$ret = $soapclient->call('checkAccountNo1',
							$params = array( 
									'AccountNo'		=> '011C444444',	//011C004444
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*$ret = $soapclient->call('deleteRealAccount',
							$params = array( 
									'AccountID'		=> '61',	//011C004444
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------deleteRealAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
  $ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'		=> '011C001234',	//011C004444
									'TradingDate'	=> '2007-06-04',								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAccountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*//*
$ret = $soapclient->call('checkAccountNo',
							$params = array( 
									'ID'     => 0,	
									'Prefix'		=> '011FIS',		
									"AccountNo"		=> '',
									"CreatedBy"		=> 'chi.dl',													 			
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------checkAccountNo-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 
 //$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/withdrawal_deposit.php?wsdl');
 /*$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'		=> '011C001234',	
									'TradingDate'	=> '2007-05-21',								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAccountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*
 $ret = $soapclient->call('deleteWithdrawalDeposit',
							$params = array( 
									'ID'		=> '1',	
									'WDType'	=> 'D', 
									'UpdatedBy'	=> 'chi.dl', 								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------deleteWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
  /*$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'		=> '011C001412',									
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------listInvestorAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*$soapclient = new SOAP_Client('http://yelizhi.com.vn/ws/withdrawal_deposit.php?wsdl');
 
 $ret = $soapclient->call('listWithdrawalDepositWithFilter',
							$params = array( 
									"Where"			=> '',																	
									"TimeZone" 		=> '+07:00',																																																
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------approveWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*
$ret = $soapclient->call('approveWithdrawalDeposit',
							$params = array( 
									"ID"			=> 24,																	
									"WDType" 		=> 'D',																																
									"UpdatedBy" 	=> 'chi.dl', 								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------approveWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
 $ret = $soapclient->call('updateWithdrawalDeposit',
							$params = array( 
									"ID"			=> 208,
									"AccountID" 	=> 1, 
									"AmountMoney" 	=> 2000001, 									
									"WDType" 		=> 'D',
									"Note" 			=> '',
									"CardNo"		=> '012013014',																										
									"UpdatedBy" 	=> 'chi.dl', 								
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------updateWithdrawalDeposit-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*$ret = $soapclient->call('listInvestorAssign',
							$params = array( 
									'AccountNo'		=> '011C000098',
									'OrderDate'		=>'2007-05-08',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------listInvestorAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
 $ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'		=> '011C001234',									
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------listInvestorAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
 /*
 $ret = $soapclient->call('listInvestorAccount',
							$params = array( 
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------listInvestorAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('listAccountWithFilter',
							$params = array( 									
									"Where"			=> "account.OpenDate>='2007-05-05' AND account.OpenDate <= '2007-05-05' AND account.ContractNo  like'%040404%' AND account.AccountNo like '%011C040404%' AND investor.CardNo like '%01%' AND assignlaw.CardNo like '%040405%' AND assign.CardNo like '%040406%'",
									"TimeZone"		=> '+07:00', 																								
										'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/

 /*$ret = $soapclient->call('addAccount',
							$params = array( 														
									"AccountID" 			=> 0, 
									"AccountNo"				=> '011C001459',
									"ContractNo" 			=> '22092222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 29,	
									"FirstName"				=> 'Si', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '123796590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 0, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 3,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 0,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '18755461',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 0,
									"AssignLawFirstName" 	=> 'hello', 
									"AssignLawLastName" 	=> 'ggg', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggg5gg',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> '15874521', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"CreatedBy" 			=> 'chi.dl',																 			
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
//echo count($params) . " client";
//var_dump($params);
echo "---------------addAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
*/

/*
$ret = $soapclient->call('checkCardNo',
							$params = array( 
									'AccountID'     => '1',	
									'CardNo'		=> 'inCardNo',
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
*/
/*$ret = $soapclient->call('listAccountInfo',
							$params = array( 
									'AccountID'     => '17',	
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('listInvestorAssign',
							$params = array( 
									'AccountNo'     => '011C001412',	
									'OrderDate'		=> '2007-04-19',															 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'     => '011C001234',																 			
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
 $ret = $soapclient->call('closeAccount',
							$params = array( 
									'ID'     => '7',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
*/
/*$ret = $soapclient->call('checkAccountNo',
							$params = array( 
									'ID'     => 0,	
									'Prefix'		=> '011C',		
									"AccountNo"		=> '54545',
									"CreatedBy"		=> 'chi.dl',													 			
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('listAccountWithFilter',
							$params = array( 
									'Where'     => "account.OpenDate='2007-04-21'",	
									'TimeZone'		=> '+07:00',		
									'AuthenUser' 	=> 'admin', 
									'AuthenPass' 	=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";



$ret = $soapclient->call('checkAccountNo',
							$params = array( 
									'ID'     => '59',	
									'Prefix'		=> '011C',		
									"AccountNo"		=> '012346',
									"CreatedBy"		=> 'chi.dl',													 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*$ret = $soapclient->call('listInvestorAssign',
							$params = array( 
									'AccountNo'     => '011C001412',	
									'OrderDate'		=> '2007-04-19',															 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									'AccountNo'     => '011C001412',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------getAcountMoney-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									"AccountNo"		=> '011C001412',								
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------listPaymentType-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('closeAccount',
							$params = array( 
									"ID"		=> '17',	
									"CloseDate"	=> '2007-04-12',
									'UpdatedBy'	=> 'chi.dl',							
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> md5('00db007')),
                         $options);	
echo "---------------listPaymentType-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('getAccountMoney',
							$params = array( 
									"AccountNo"		=> '011C002382',								
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listPaymentType-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('closeAccount',
							$params = array( 
									"ID"		=> '16',		
									"CloseDate"	=> '2007-04-12',	
									'UpdatedBy'	=> 'chi.dl',					
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listPaymentType-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

/*
$ret = $soapclient->call('closeAccount',
							$params = array( 
									'ID'     => '13',
									'CloseDate'	=> '2007-12-12',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
$ret = $soapclient->call('closeAccount',
							$params = array( 
									'ID'     => '17',
									'CloseDate'	=> '2007-12-12',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('closeAccount',
							$params = array( 
									'ID'     => '4',
									'CloseDate'	=> '2007-12-12',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('closeAccount',
							$params = array( 
									'ID'     => '5',
									'CloseDate'	=> '2007-12-12',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------closeAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('deleteAccount',
							$params = array( 
									'ID'     => '1',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------deleteAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('deleteAccount',
							$params = array( 
									'ID'     => '17',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------deleteAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('deleteAccount',
							$params = array( 
									'ID'     => '4',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------deleteAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

$ret = $soapclient->call('deleteAccount',
							$params = array( 
									'ID'     => '5',
									'UpdatedBy'	=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------deleteAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
*/
/*

$ret = $soapclient->call('listInvestorAssign',
							$params = array( 
									'InvestorID' => '25',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listInvestorWithFilter-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";

*/
/*
$ret = $soapclient->call('updateAccount',
							$params = array( 														
									"AccountID" 			=> 22, 
									"AccountNo"				=> '',
									"ContractNo" 			=> '222222', 
									"OpenDate" 				=> '2007-04-18', 	
									"BranchID"				=> 10,
									"InvestorID"			=> 29,	
									"FirstName"				=> 'Si', 	
									"LastName" 				=> 'Nguyen Van', 
									"CardNo" 				=> '12396590', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> '', 									
									"BankAccount"			=> '', 
									"BankID" 				=> 0, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> 'ffffffffffffffffff',
									"InvestorType"			=> 3,	
									"InvestorNote"			=> 'eeeeeeeeee',
									"AssignID"				=> 0,																
									"AssignFirstName" 		=> 'Chi', 
									"AssignLastName" 		=> 'Ye', 
									"AssignAddress" 		=> '123 chichi', 									
									"AssignCardNo"			=> '1875461',
									"AssignCardNoDate" 		=> '', 
									"AssignCardNoIssue" 	=> '', 
									"AssignTelephone" 		=> '457824', 									
									"AssignSignaturePath"	=> '', 	
									"AssignNote"			=> 'o',
									"PrivilegeID"			=> 1,
									"AssignLawID"			=> 0,
									"AssignLawFirstName" 	=> 'hello', 
									"AssignLawLastName" 	=> 'ggg', 
									"AssignLawAddress" 		=> 'gggg', 									
									"AssignLawCardNo"		=> 'ggggg',
									"AssignLawCardNoDate" 	=> 'gggg', 
									"AssignLawCardNoIssue" 	=> 'gggg', 
									"AssignLawTelephone" 	=> 'gggg', 									
									"AssignLawSignaturePath"=> "", 
									"AssignLawNote"			=> "aa",
									"PrivilegeIDLaw"		=> '1',									
									"UpdatedBy" 			=> 'chi.dl',																 			
									'AuthenUser' 			=> 'admin', 
									'AuthenPass' 			=> '21232F297A57A5A743894A0E4A801FC3'),
                         $options);	
//echo count($params) . " client";
//var_dump($params);
echo "---------------updateAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
/**/
//print_r(count($params));

/*
$ret = $soapclient->call('listAccountWithFilter',
							$params = array( 									
									"Where"			=> "account.OpenDate>='2007-05-05' AND account.OpenDate <= '2007-05-05' AND account.ContractNo  like'%040404%' AND account.AccountNo like '%011C040404%' AND investor.CardNo like '%01%' AND assignlaw.CardNo like '%040405%' AND assign.CardNo like '%040406%'",
									"TimeZone"		=> '+07:00', 																								
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";
$ret = $soapclient->call('listAccount',
							$params = array( 									
									"TimeZone"		=> '+07:00', 																								
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
$ret = $soapclient->call('checkAccountNo',
							$params = array( 									
									"ID"		=> '0', 																								
									"Prefix"	=> '011C',
									"AccountNo"	=> '',
									"CreatedBy"	=> 'chi.dl',
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------listAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
/*
$ret = $soapclient->call('addAccount',
							$params = array( 
									"AccountID" 			=> '35', 
									"AccountNo"				=> '011C0',
									"ContractNo" 			=> '123456', 
									"OpenDate" 				=> '2007-04-04', 	
									"BranchID"				=> 1,	
									"FirstName"				=> 'Chi', 	
									"LastName" 				=> 'Diep', 
									"CardNo" 				=> '12365918', 
									"CardNoDate" 			=> '1997-07-26', 									
									"CardNoIssuer"			=> 'HCM', 	
									"Gender" 				=> 1, 
									"Ethnic" 				=> 'abc', 
									"ResidentAddress" 		=> '123 hhh', 									
									"ContactAddress"		=> '123 hhh', 	
									"HomePhone" 			=> '123456', 
									"MobilePhone" 			=> '090123456', 
									"Email" 				=> 'sup3@yyy.co', 									
									"BankAccount"			=> '154236', 
									"BankID" 				=> 30, 
									"CountryID" 			=> 2, 
									"AgencyFeeID" 			=> 2, 									
									"SignaturePath"			=> '',
									"InvestorType"			=> 1,									
									"AssignFirstName" 		=> 'Ye', 
									"AssignLastName" 		=> 'GiGi', 
									"AssignAddress" 		=> '1254 ggg', 									
									"AssignCardNo"			=> '789345',
									"AssignCardNoDate" 		=> '1997-07-26', 
									"AssignCardNoIssue" 	=> 'hn', 
									"AssignTelephone" 		=> '19972607', 									
									"AssignSignaturePath"	=> '', 	
									"AssignLawFirstName" 	=> 'AA', 
									"AssignLawLastName" 	=> 'BB', 
									"AssignLawAddress" 		=> '158 HMHGF', 									
									"AssignLawCardNo"		=> '158762',
									"AssignLawCardNoDate" 	=> '1997-07-26', 
									"AssignLawCardNoIssue" 	=> 'ffds', 
									"AssignLawTelephone" 	=> '5657887', 									
									"AssignLawSignaturePath"=> '', 
									"PrivilegeID"			=> 1,									
									"CreatedBy" 			=> 'chi.dl',																 			
									'AuthenUser' 	=> 'ba.nd', 
									'AuthenPass' 	=> 'e10adc3949ba59abbe56e057f20f883e'),
                         $options);	
echo "---------------addAccount-------------";
echo "<pre>";
print_r($ret);
echo "</pre>";*/
?>
