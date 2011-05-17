<?php
require_once 'SOAP/Client.php';
require_once 'Crypt/HMAC.php';
require_once 'common.php';
//define("DAB_FILE_PATH", "/home/vhosts/eSMSstorage/bank/dab/function/");
define("DAB_LOG_FILE_PATH", "bank/dab/function/");

class CDAB {
	var $url;
	var $error;
	var $soapClient;
	var $soapOptions;
	var $hasher;
	var $accessKey;

	function CDAB() {
		$this->url = DAB_WEBSERVICE_URL;
		$soapClient = new SOAP_Client($this->url, true, false, array(), "/tmp/pear/cache" );
		$soapClient->setOpt("timeout", 100);
		//$soapClient->setOpt('curl', CURLOPT_VERBOSE, 0);
		$soapClient->setOpt('curl', CURLOPT_SSL_VERIFYHOST, 0);
		$soapClient->setOpt('curl', CURLOPT_SSL_VERIFYPEER, 0);
		$soapClient->setOpt('curl', CURLOPT_CAPATH, '/usr/local/ssl/certs');
		$this->soapOptions = array('namespace' => 'http://controller.com.eab', 'trace' => 1);

		$secretkey = "5wMr N5lFU?|!b)R^jZN,lebw~xVPz9+XG\"NHB?N";
		$this->hasher =& new Crypt_HMAC($secretkey, "sha1");

		$this->soapClient = $soapClient;
		$this->accessKey = "JnShns06ip2cQ6S2vxKZ";
	}

	function addSOAPHeader($function) {
		$timestamp = date("d/m/Y H:i:s");
		$stringToSign = $function . $timestamp;
		$signature = hex2b64($this->hasher->hash($stringToSign));
		$header = new SOAP_Header (
											"securityHeader",
											NULL,
											array( 'paccesskey' => $this->accessKey, 'timestamp' => $timestamp, "signature" => $signature, "action" => $function ) );
		$this->soapClient->addHeader($header );
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: invalid date
-4: no customer found or customer has been disabled
-5: has already existed bid
0: bid successful
1: DAB custaccount is locked
2: DAB custaccount is disabled
3: DAB custaccount is not enough balance
4: expiry overdraft 99: unknown error
*/
	function blockMoney($dabAccount, $idCardNo, $epsAccount, $orderID, $orderAmount, $orderDate) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "bid";
		$this->addSOAPHeader($function);

		$arrOrderDate = parseDate($orderDate);
		$sourceDate = $arrOrderDate[0] . $arrOrderDate[1] . $arrOrderDate[2] . date("His");
		$transferDate = $arrOrderDate[0] . $arrOrderDate[1] . $arrOrderDate[2];

		$result = $this->soapClient->call( $function,
										$params = array(
															'custaccount' => $dabAccount,
															'CID' => $idCardNo,
															'scraccount' => $epsAccount,
															'refno' => $orderID,
															'amount' => $orderAmount,
															'scrdate' => $sourceDate,
															'transferflag' => 0,
															'transferdate' => $transferDate ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, CID => $idCardNo, scraccount => $epsAccount, refno => $orderID, amount => $orderAmount, scrdate => $sourceDate, transferdate => $transferDate 	--> $result" ;
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name blockMoney custaccount '.$dabAccount.' CID '.$idCardNo.' epsAccount '.$epsAccount.' refno '.$orderID.' amount '.$orderAmount.' sourceDate '.$sourceDate.' transferdate '.$transferDate.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: database error
-4: No bid or bid failed or bid's already auctioned/canceled
-5: can't unlock
0: success
1: DAB custaccount is locked
2: DAB custaccount is disabled
3: DAB custaccount is not enough balance
4: expiry overdraft
5:unauthorized
6:unlock unsuccessful
7:No bid found
99: unknown error
*/
	function editBlockMoney($dabAccount, $epsAccount, $orderID, $orderAmount) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "editBid";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'refno' => $orderID,
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount,
															'amount' => $orderAmount),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	refno => $orderID, custaccount => $dabAccount, scraccount => $epsAccount, amount => $orderAmount	--> $result" ;
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name editBlockMoney custaccount '.$dabAccount.' CID '.$idCardNo.' epsAccount '.$epsAccount.' refno '.$orderID.' amount '.$orderAmount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: database error
-4: No bid or bid failed or bid's already auctioned/canceled
-5: update error
0: success
1: unsuccess (can't unlock)
99: unknown error
*/
	function cancelBlockMoney($dabAccount, $epsAccount, $orderID, $orderAmount) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "cancelBid";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'refno' => $orderID,
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount,
															'amount' => $orderAmount),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	refno => $orderID, custaccount => $dabAccount, scraccount => $epsAccount, amount => $orderAmount	--> $result" ;
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		//write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name cancelBlockMoney custaccount '.$dabAccount.' CID '.$idCardNo.' epsAccount '.$epsAccount.' refno '.$orderID.' amount '.$orderAmount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');
		return $result;
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: invalid date
-4: No customer found
-5: Customer disable
0: valid
*/
	function associateBankAccount($dabAccount, $epsAccount, $idCardNo) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "checkDABCustomer";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call($function,
									 $params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount,
															'CID' => $idCardNo,
															'scrdate' => date("YmdHis") ),
									$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount, CID => $idCardNo		--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		//write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name associateBankAccount custaccount '.$dabAccount.' CID '.$idCardNo.' epsAccount '.$epsAccount.' scrdate '.date("YmdHis").'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');
		return $result;
	}

/*
int -1: unauthenticate partner -2: invalid parameters -3: No customer found -4: Update error 0: success
*/
	function disableAssociateBankAccount($dabAccount, $epsAccount) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "disableSCustomer";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call($function,
									 $params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount ),
									$this->soapOptions);
		//log
		/*$filename = DAB_FILE_PATH . $_SERVER['REMOTE_ADDR'];
		$handle = fopen($filename, 'a');
		$content = "DAB: $dabAccount, EPS: $epsAccount \r\n";
		fwrite($handle, $content);
		write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name disableAssociateBankAccount custaccount '.$dabAccount.' epsAccount '.$epsAccount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount	--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		return $result;
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: invalid date
-4: No bid or bid failed or bid's already auctioned/canceled
-5: bid amount/fee < auction amount/fee
0: auction successful
1: auction unsuccessful (can't unlock)
2: auction successful but can't transfer money immediately
99: unknown error
*/
	function cutMoney($dabAccount, $epsAccount, $orderID, $orderAmount, $orderFee) {
if(!defined('DAB_TOOLS')) return 0;
		$function = "auction";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount,
															'refno' => $orderID,
															'amount' => $orderAmount,
															'fee' => $orderFee,
															'scrdate' => date("YmdHis") ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount, refno => $orderID, amount => $orderAmount, fee => $orderFee	--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name cutMoney custaccount '.$dabAccount.' epsAccount '.$epsAccount.' refno '.$orderID.' amount '.$orderAmount.' fee '.$fee.' scrdate '.date("YmdHis").'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

/*
-1: unauthenticate partner
-2: invalid parameters
-3: invalid date
-4: has already existed selling
0: sell successful
1: sell unsuccessful (database error)
99: unknown error
*/
	function creditAccount($epsAccount, $orderID, $dabAccount, $fullName, $bankName, $bankCity, $orderAmount, $orderFee, $T3) {
		$function = "sell";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'scraccount' => $epsAccount,
															'refno' => $orderID,
															'receiver_account' => $dabAccount,
															'receiver_name' => $fullName,
															'receiver_bank' => $bankName,
															'receiver_bank_city' => $bankCity,
															'isDAB' => 1,
															'amount' => $orderAmount,
															'fee' => $orderFee,
															'scrdate' => date("YmdHis"),
															'transferdate' => $T3 ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	scraccount => $epsAccount, refno => $orderID, receiver_account => $dabAccount, receiver_name => $fullName, receiver_bank => $bankName,  receiver_bank_city => $bankCity, amount => $orderAmount, fee => $orderFee, transferdate => $T3 	--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name creditAccount custaccount '.$dabAccount.' epsAccount '.$epsAccount.' refno '.$orderID.' amount '.$orderAmount.' fee '.$orderFee.' receiver_name '.$fullName.' receiver_bank '.$bankName.' transferdate '.$T3.' scrdate '.date("YmdHis").'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
		int -1: unauthenticate partner
		0: transfer selling file successful
		1: transfer selling file unsuccessful
		-1: file doesnt exist
	*/
	function sellFile($filepath, $filename) {
		$function = "sellFile";
		$this->addSOAPHeader($function);

		$tmpName = $filepath.$filename;
		if(file_exists($tmpName))
		{
			$fp      = fopen($tmpName, 'r');
			$data = fread($fp, filesize($tmpName));
			$filecontent = chunk_split(base64_encode($data));

			$result = $this->soapClient->call( $function,
											$params = array(
																'filename' => $filename,
																'filecontent' => $filecontent,
															 ),
											$this->soapOptions);
		}else{
			$result = -1;
		}
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name auctionFile sellFile '.$filepath.' filename '.$filename.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

  function sell($_params) {
    $function = "sell";
    $this->addSOAPHeader($function);

    $result = $this->soapClient->call( $function,
          $params = array(
                    'scraccount'        => $_params['scraccount'],
                    'refno'             => $_params['refno'],
                    'receiver_account'  => $_params['receiver_account'],
                    'receiver_name'     => $_params['receiver_name'],
                    'receiver_bank'     => $_params['receiver_bank'],
                    'receiver_bank_city' => $_params['receiver_bank_city'],
                    'isDAB'             => 1,
                    'amount'            => $_params['amount'],
                    'fee'               => $_params['fee'],
                    'scrdate'           => $_params['scrdate'],
                    'transferdate'      => $_params['transferdate'], ),
          $this->soapOptions);

    return $result;
  }

	/*
		int -1: unauthenticate partner
		0: transfer selling file successful
		1: transfer selling file unsuccessful
		-1: file doesnt exist
	*/
	function auctionFile($filepath, $filename) {
		$function = "auctionFile";
		$this->addSOAPHeader($function);
		$tmpName = $filepath.$filename;
		if(file_exists($tmpName))
		{
			$fp      = fopen($tmpName, 'r');
			$data = fread($fp, filesize($tmpName));
			$filecontent = chunk_split(base64_encode($data));

			$result = $this->soapClient->call( $function,
											$params = array(
																'filename' => $filename,
																'filecontent' => $filecontent,
															 ),
											$this->soapOptions);
		}else{
			$result = -1;
		}
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name auctionFile filepath '.$filepath.' filename '.$filename.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
		int -1: unauthenticate partner
		0: transfer selling file successful
		1: transfer selling file unsuccessful
		-1: file doesnt exist
	*/
	function releaseBidFile($filepath, $filename) {
		$function = "releaseBidFile";
		$this->addSOAPHeader($function);

		$tmpName = $filepath.$filename;
		if(file_exists($tmpName))
		{
			$fp      = fopen($tmpName, 'r');
			$data = fread($fp, filesize($tmpName));
			$filecontent = chunk_split(base64_encode($data));

			$result = $this->soapClient->call( $function,
											$params = array(
																'filename' => $filename,
																'filecontent' => $filecontent,
															 ),
											$this->soapOptions);
		}else{
			$result = -1;
		}
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name releaseBidFile filepath '.$filepath.' filename '.$filename.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
		-1: unauthenticate partner
		-2: invalid parameters
		-3: No customer found
		0: authorize
		1: unauthorized
		99:unknown error
	*/
	function checkAssignment($dabAccount, $epsAccount) {
		$function = "checkAuthorization";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount),
										$this->soapOptions);
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name checkAssignment custaccount '.$dabAccount.' epsAccount '.$epsAccount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

/*
	-1: unauthenticate partner
	-2: Invalid customer else return string include balance and available balance, devide by "^"
*/
	function getRealBalance($dabAccount, $epsAccount) {
		$function = "getBalance";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount),
										$this->soapOptions);
		$arr = explode("^", $result);

		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name getRealBalance custaccount '.$dabAccount.' epsAccount '.$epsAccount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $arr[0];
	}

/*
	-1: unauthenticate partner
	-2: Invalid customer else return string include balance and available balance, devide by "^"
*/
	function getAvailBalance($dabAccount, $epsAccount) {
return 100000000;
		$function = "getBalance";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(
															'custaccount' => $dabAccount,
															'scraccount' => $epsAccount),
										$this->soapOptions);
		$arr = explode("^", $result);

		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name getAvailBalance custaccount '.$dabAccount.' epsAccount '.$epsAccount.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $arr[1];
	}

	/*
	-1: unauthenticate partner
	-2: invalid parameters
	-3: invalid date
	-4: can't pay in advance to this custaccount
	0: sell (advance) successful
	1: invalid custaccount
	2: invalid adv_amount
	3: sell (advance) successful but can't send SMS to customer
	5: sell (advance) unsuccessful
	10: has already paid in advance
	20: out of loan limit
	99: unknown error
	*/
	function sellAdvance($epsAccount, $dabAccount, $contract_id, $isDAB, $adv_amount, $adv_fee, $refno_list) {
		$function = "sellAdvance";
		$this->addSOAPHeader($function);
		//1: lender is DAB; 0: lender is partner
		$result = $this->soapClient->call( $function,
										$params = array(
														   'scraccount' => $epsAccount ,
														   'custaccount' => $dabAccount,
														   'contract_id' => $contract_id,
														   'lender' => $isDAB,
														   'adv_amount' => $adv_amount,
														   'iamount' => $adv_fee,
														   'refno_list' => $refno_list
														   ),
										$this->soapOptions);

		$content = date("d/m/Y H:i:s") ."	scraccount => $epsAccount, custaccount => $dabAccount, contract_id => $contract_id, lender => $isDAB, adv_amount => $adv_amount, iamount => $adv_fee, refno_list => $refno_list		--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;

		//$arr = explode("^", $result);
		//var_dump($arr);
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name sellAdvance custaccount '.$dabAccount.' epsAccount '.$epsAccount.' contract_id '.$contract_id.' isDAB '.$isDAB.' adv_amount '.$adv_amount.' adv_fee '.$adv_fee.' refno_list '.$refno_list.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
		//return $arr[0];
	}

	/*
	long -1: unauthenticate partner
	 -3: Invalid date
	*/
	function getBalanceAdvance() {
		$function = "getBalanceAdvance";
		$this->addSOAPHeader($function);
		//var_dump($this->soapClient);
		$result = $this->soapClient->call( $function,
										$params = array(
														   'adv_date' => date("Ymd")
														   ),
										$this->soapOptions);
		$arr = explode("^", $result);
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name getBalanceAdvance  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $arr[1];
	}

	/*
	transfer_type - the type of transfer (0: from partner to custaccount 1: from custaccount to partner)
	int -1: unauthenticate partner
	-2: invalid parameters
	-3: invalid date
	-4: no customer found
	-5: transfer unsuccessful
	0: transfer successful
	1: invalid account
	2: invalid amount
	5: not enough balance
	6: duplicate account
	*/
	function transferfromEPS($dabAccount,$epsAccount,$refno,$amount,$description) {
return 0;
		$function = "transfer";
		$this->addSOAPHeader($function);
		//var_dump($this->soapClient);
		$result = $this->soapClient->call( $function,
										$params = array(
														   'transfer_type' => 0,
														   'custaccount' => $dabAccount,
														   'scraccount' => $epsAccount ,
														   'refno'	=> $refno,
														   'amount'	=> $amount,
														   'description'	=> $description,
														   'scrdate'=> date("YmdHis"),
														   ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount , refno	=> $refno, amount	=> $amount, description	=> $description		--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name transferfromEPS custaccount '.$dabAccount.' epsAccount '.$epsAccount.' refno '.$refno.' amount '.$amount.' description '.$description.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
	transfer_type - the type of transfer (0: from partner to custaccount 1: from custaccount to partner)
	int -1: unauthenticate partner
	-2: invalid parameters
	-3: invalid date
	-4: no customer found
	-5: transfer unsuccessful
	0: transfer successful
	1: invalid account
	2: invalid amount
	5: not enough balance
	6: duplicate account
	*/
	function transfertoEPS($dabAccount,$epsAccount,$refno,$amount,$description) {
$content = date("d/m/Y H:i:s") ." custaccount => $dabAccount, scraccount => $epsAccount , refno => $refno, amount => $amount, description => $description   --> 0";
write_log('transfer', $content, DAB_LOG_FILE_PATH) ;
return 0;
		$function = "transfer";
		$this->addSOAPHeader($function);
		//var_dump($this->soapClient);
		$result = $this->soapClient->call( $function,
										$params = array(
														   'transfer_type' => 1 ,
														   'custaccount' => $dabAccount,
														   'scraccount' => $epsAccount ,
														   'refno'	=> $refno,
														   'amount'	=> $amount,
														   'description'	=> $description,
														   'scrdate'=> date("YmdHis"),
														   ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount , refno	=> $refno, amount	=> $amount, description	=> $description		--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name creditAccount transfertoEPS '.$dabAccount.' epsAccount '.$epsAccount.' refno '.$refno.' amount '.$amount.' description '.$description.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
	   status - the status of sell advance order (0: Approved 1: Customer agreed 2: Customer canceled 3: Waiting)
    fromdate - from the date (Format: yyyymmdd Ex: 20070809)
    todate - to the date (Format: yyyymmdd Ex: 20070809)
	int -1: unauthenticate partner -2: invalid parameters -3: invalid date 0: process successful 1: unable to process >1: error code of partner 99: unknown error
	*/
	function getAdvanceInfo($status,$fromdate,$todate) {
		$function = "getAdvanceInfo";
		$this->addSOAPHeader($function);
		$result = $this->soapClient->call( $function,
										$params = array(
														   'status' => $status ,
														   'fromdate' => $fromdate,
														   'todate' => $todate
														   ),
										$this->soapOptions);
		$Array_err = array("-1","-2","-3","0","1","99");
		if(in_array($result,$Array_err)){
			return $result;
		}

		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name getAdvanceInfo  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		//return base64_decode($result);
		$result = asciiArrToStr($result);
		return $result;
	}

	/*
	    scraccount - the account number of customer at Partner
    	custaccount - the account which receives money (receiver_account in sell order)
    	contract_id - the contract id of customer which was provided by partner
		int -1: unauthenticate partner -2: invalid parameters -3: no contract found or invalid contract 0: cancel sell 	(advance) successful 1: cancel sell unsuccessful 99: unknown error
	*/
	function cancelsellAdvance($dabAccount,$epsAccount,$contract_no) {
		$function = "cancelsellAdvance";
		$this->addSOAPHeader($function);
		$result = $this->soapClient->call( $function,
										$params = array(
														'scraccount' => $epsAccount ,
														'custaccount' => $dabAccount,														   													    'contract_id' => $contract_no
														   ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount, scraccount => $epsAccount 	--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		/*write_my_log_path('DAB-connect',$_SERVER['REMOTE_ADDR'].' function_name cancelsellAdvance custaccount '.$dabAccount.' epsAccount '.$epsAccount.' contract_no '.$contract_no.'  ' .date('Y-m-d h:i:s'),DAB_PATH.'logs/');*/
		return $result;
	}

	/*
    	custaccount - the account which receives money (receiver_account in sell order)
		int -1: unauthenticate partner -2: invalid parameters  -3: khong tim thay khach hang  -4: khach hang da map voi CTCK khac
	*/
	function getCustomerIDNumber($dabAccount) {
		$function = "getCustomerIDNumber";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array( 'custAccount' => $dabAccount ),
										$this->soapOptions);
		$content = date("d/m/Y H:i:s") ."	custaccount => $dabAccount	--> $result";
		write_log($function, $content, DAB_LOG_FILE_PATH) ;
		return $result;
	}

	/*
		int -1: unauthenticate partner 	99: loi he thong
	*/
	function getAvailableBalanceAdvance() {
		$function = "getAvailableBalanceAdvance";
		$this->addSOAPHeader($function);

		$result = $this->soapClient->call( $function,
										$params = array(),
										$this->soapOptions);
		return $result;
	}

}

function hex2b64($str) {
    $raw = '';
    for ($i=0; $i < strlen($str); $i+=2) {
        $raw .= chr(hexdec(substr($str, $i, 2)));
    }
    return base64_encode($raw);
}

function asciiArrToStr($array)  {
	$str = '';
	if(is_array($array)) {
		if(count($array)) {
			foreach($array as $v) {
				$v = chr($v);
				$str .= $v;
			}
		}
	}
	$str = str_replace("<!DOCTYPE AllSelAdvance SYSTEM \"users.dtd\">", "", $str);
	return $str;
}

?>
