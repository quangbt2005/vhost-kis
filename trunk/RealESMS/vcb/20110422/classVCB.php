<?php
/**
	Author: Diep Le Chi
	Created date: 19/03/2007
*/
require_once('includes.php');
//require_once("../XML/Unserializer.php");
define ('FILE_PATH','/home/vhosts/eSMS/htdocs/dab/');
define ('FROMIP','192.168.137.33');
define ('TOIP','192.168.137.33');

define ('FROMIP1','210.245.112.228');
define ('TOIP1','210.245.112.228');

class CVCB extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_MDB2_WRITE1;
	var $_MDB2_WRITE2;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor	
	*/
	
	function CVCB($check_ip) {
		//initialize _MDB2
		//$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		//$this->_MDB2_WRITE1 = initWriteDB();
		//$this->_MDB2_WRITE2 = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		//$this->_TIME_ZONE = get_timezon();
		$this->items = array();
		
		$this->class_name = get_class($this);
		$arr = array( 					
					/*'helloString' => array(
										'input' => array('InputString'),
                                        'output' => array('OutPutString')
										),*/
					'OpenAccount' => array(
										'input' => array('PersonalCard', 'Name', 'Address', 'BankAccountNo', 'PartnerType', 'dtBirthDay', 'PlaceOfBirth', 'dtDateIssue', 'PlaceIssue', 'ZipCode', 'Country', 'Email', 'Phone', 'Fax', 'CompanyAddress', 'CompanyPhone', 'MailingAddress', 'MailingPhone'),
                                        'output' => array('PersonalCard','Name','Account','State','ResponseCode','RespString','OldNewAccount')
										)/*,
					'OpenAccount1' => array(
										'input' => array('PersonalCard', 'Name', 'Address', 'BankAccountNo', 'PartnerType', 'dtBirthDay', 'PlaceOfBirth', 'dtDateIssue', 'PlaceIssue', 'ZipCode', 'Country', 'Email', 'Phone', 'Fax', 'CompanyAddress', 'CompanyPhone', 'MailingAddress', 'MailingPhone'),
                                        'output' => array('PersonalCard','Name','Account','State','ResponseCode','RespString','OldNewAccount')
										)*/
				);		
		parent::__construct($arr);
	}
	/**
	 *  __destruct
	 */
	function __destruct() {
		//$this->_MDB2->disconnect();
		//$this->_MDB2_WRITE->disconnect();
		
	}	
	/* ----------------------------- Account Function --------------------------------- */
		
	
	/**
	 * Function writeImage	: create image and store in folder
	 * Input 				: $ImageSignature ( image) , $AccountNo, $Type
	 * OutPut 				: path of image
	 */
	function helloString($InputString)
	{
		$class_name = $this->class_name;
		$function_name = 'helloString';
		/*$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OutPutString"    => new SOAP_Value( "OutPutString", "string", 'Hello '.$InputString )
								)
						);	*/
		$this->items['OutPutString'] = 	 new SOAP_Value( "OutPutString", "string", 'Hello '.$InputString );
		write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' InputString '.$InputString.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' InputString '.$InputString.' '.date('Y-m-d h:i:s').' ErrorCode '.$this->_ERROR_CODE);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->items, $this );
	}
	
	/**
	 * Function openAccount	: create image and store in folder
	 * Input 				: $ImageSignature ( image) , $AccountNo, $Type
	 * OutPut 				: path of image
	 */
	/*
	function OpenAccount($PersonalCard, $Name, $Address, $BankAccountNo, $PartnerType, $dtBirthDay, $PlaceOfBirth, $dtDateIssue, $PlaceIssue, $ZipCode, $Country, $Email, $Phone, $Fax, $CompanyAddress, $CompanyPhone, $MailingAddress, $MailingPhone)
	{
		$class_name = $this->class_name;
		$function_name = 'OpenAccount';
		$this->_ERROR_CODE = '0000';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
			write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
			mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s').' ErrorCode '.$this->_ERROR_CODE);
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		}
		if(!required($Name)) $this->_ERROR_CODE = 18013;
		if($this->_ERROR_CODE=='0000' && !required($BankAccountNo)) $this->_ERROR_CODE = 18016;			
		if($this->_ERROR_CODE=='0000' && (!required($dtBirthDay)||!valid_date($dtBirthDay))) $this->_ERROR_CODE = 18011;
		if($this->_ERROR_CODE=='0000' && (!required($dtDateIssue)||!valid_date($dtDateIssue))) $this->_ERROR_CODE = 18017;
		if($this->_ERROR_CODE=='0000' && !required($PersonalCard)) $this->_ERROR_CODE = 18072;			
	//	if($this->_ERROR_CODE!=0 && isset($Gender)&&(strlen($Gender)>0)&&!in_array($Gender,array('F','M'))) $this->_ERROR_CODE = 18027;
		if($this->_ERROR_CODE=='0000' && isset($PartnerType)&&(strlen($PartnerType)>0)&&!in_array($PartnerType,array('C','F','P'))) $this->_ERROR_CODE = 18028;
		if($this->_ERROR_CODE=='0000' && !required($Phone) && !valid_phone($Phone)) $this->_ERROR_CODE = 18014;	
		if($this->_ERROR_CODE=='0000' && !required($Email) && !valid_email($Email)) $this->_ERROR_CODE = 18015;	
		//$Account ='057C'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		$err = -1;
	
		if($this->_ERROR_CODE=='0000')
		{
			$BankName = 'VietComBank';
			if($PartnerType == 'F') $PartnerType=2;
			else $PartnerType=1;
			while($err<0 && $this->_ERROR_CODE<=0)
			{					
				
				$Account = rand(0, '9999');
				$Account = addZeroCharacter($Account, 6);		
				$Account ='057C'.$Account;			
				$query = sprintf( "CALL sp_checkAccount ('%s','%s','%s')", 0, $Account, $BankName);
				$this->_MDB2_WRITE->connect();
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				$this->_MDB2_WRITE->disconnect();
				//Can not add
				if(empty($result) || is_object($result))	$this->_ERROR_CODE = 18049;	
				else {
					if(isset($result[0]['varerror'])){												
						$err = $result[0]['varerror'];						
					}else{
						$this->_ERROR_CODE = 18049;
					}
				}
			}	
			if($err == -1) $this->_ERROR_CODE = 18005;														
			if($err>0)
			{
				$ID = $err;	
				$this->_MDB2_WRITE->connect();
				$query = sprintf( "CALL aaa_insertInvestor ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $Name, $Name, $PartnerType, $Address, $Address, $Phone, $Phone, $Email, $dtBirthDay, $PersonalCard, $dtDateIssue, $PlaceIssue, 'F', $BankAccountNo, $BankName, $Country, $ID, $BankName );								
				$result = $this->_MDB2_WRITE->extended->getAll($query);		
				$this->_MDB2_WRITE->disconnect();	
				if(empty($result) || is_object($result))	$this->_ERROR_CODE = 18049;	
				else {					
					if(isset($result[0]['varerror'])){												
						if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 18051;
						if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 18052;// duplicate cardno
						if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 18053;
						if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 18054;
						if($result[0]['varerror'] == -5) $this->_ERROR_CODE = 18055;

					}else{
						$this->_ERROR_CODE = 18049;
					}					
				}
			}	
			//echo $this->_ERROR_CODE;
			if($this->_ERROR_CODE!='0000')
			{
				$this->_MDB2_WRITE->connect();
				$query = sprintf( "CALL sp_deleteRealAccount ('%s')", $Account);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				if(empty($result) || is_object($result)) $this->_ERROR_CODE = 18056;
			
				$Account = '';
				$Name ='';
				$Address = '';
			}
			
		}
		write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. ErrorCode .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. ErrorCode .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name,$Name, $Address, $Account,  $Account?'A':'', $this->_ERROR_CODE, $this );
	}*/
	
	/**
	 * Function openAccount	: create image and store in folder
	 * Input 				: $ImageSignature ( image) , $AccountNo, $Type
	 * OutPut 				: path of image
	 */
	function OpenAccount($PersonalCard, $Name, $Address, $BankAccountNo, $PartnerType, $dtBirthDay, $PlaceOfBirth, $dtDateIssue, $PlaceIssue, $ZipCode, $Country, $Email, $Phone, $Fax, $CompanyAddress, $CompanyPhone, $MailingAddress, $MailingPhone)
	{
		$class_name = $this->class_name;
		$function_name = 'OpenAccount';		
		//vcb_eps/hy6GT^lj(O04h
		$list_args = func_get_args();
		$count = count($list_args);
		$pass=md5('hy6GT^lj(O04h');	
		//echo $list_args[$count-1];
		//	echo '  '.$pass;	
		if (($this->_ERROR_CODE == 0 || validateIP($_SERVER['REMOTE_ADDR'], FROMIP, TOIP) || validateIP($_SERVER['REMOTE_ADDR'], FROMIP1, TOIP1)) && $list_args[$count-2]=='vcb_eps' &&($list_args[$count-1] =='hy6GT^lj(O04h' || $list_args[$count-1] ==$pass || $list_args[$count-1] ==strtolower($pass) || $list_args[$count-1] ==strtoupper($pass))){//authenUser(func_get_args(), $this, $function_name) > 0 ){
			//echo $list_args[$count-1];
			//echo '  '.$pass;
			$this->_ERROR_CODE = '0000';
		}else{
			$Name 		= '';
			$Address 	= '';
			$Account 	= '';
			$Status 	= '';	
			$RespString = 'Invalid user/Password';
			$OldNewAccount = '';
			$this->_ERROR_CODE = '8009';
			$RespString = 'IP deny or wrong username/password';
			write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
			//mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s').' ErrorCode '.$this->_ERROR_CODE);
			$array_input['PersonalCard'] = new SOAP_Value('PersonalCard', 'string', $PersonalCard);
			$array_input['Name'] = new SOAP_Value('Name', 'string', $Name);
			$array_input['Account'] = new SOAP_Value('Account', 'string', $Account);
			$array_input['State'] = new SOAP_Value('State', 'string', $State);
			$array_input['ResponseCode'] = new SOAP_Value('ResponseCode', 'string', $this->_ERROR_CODE);
			$array_input['RespString'] = new SOAP_Value('RespString', 'string', $RespString);
			$array_input['OldNewAccount'] = new SOAP_Value('OldNewAccount', 'string', $OldNewAccount);
			return returnXML(func_get_args(), $this->class_name, $function_name, /*$PersonalCard, $Name, $Account, $State, $ResponseCode, $RespString, $OldNewAccount,*/$array_input, $this );
		}
		$this->_ERROR_CODE = '0000';
		if(!required($Name)){
			 $this->_ERROR_CODE = 8013;
			 $RespString = 'Name is null';
		}
		if($this->_ERROR_CODE=='0000' && !required($BankAccountNo)){
			$this->_ERROR_CODE = 8016;			
			$RespString = 'BankAccountNo is null';
		}
		if($this->_ERROR_CODE=='0000' && (strlen($dtBirthDay)>0 && !dateStr($dtBirthDay))){
			$this->_ERROR_CODE = 8019;			
			$RespString = 'Invalid Birthday';
		}
		if($this->_ERROR_CODE=='0000' && !required($PersonalCard)){
			$this->_ERROR_CODE = 8072;			
			$RespString = 'PersonalCard is null';
		}
		if($this->_ERROR_CODE=='0000' && isset($PartnerType)&&(strlen($PartnerType)>0)&&!in_array($PartnerType,array('C','F','P'))){
			$this->_ERROR_CODE = 8028;
			$RespString = 'Invalid PartnerType';
		}
		if($this->_ERROR_CODE=='0000' && (strlen($dtDateIssue)>0 && !dateStr($dtDateIssue))){
			$this->_ERROR_CODE = 8020;			
			$RespString = 'Invalid dtDateIssue';
		}
		if($this->_ERROR_CODE=='0000')
		{
			$BankName = 'VietComBank';
			$pos = strpos($Name, ' ');
			$FirstName = substr($Name, 0, $pos+1);
			$LastName = substr($Name, $pos+1);
			$query = sprintf( "CALL SP_OpenPrivateAccount_VCB
('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $FirstName, $LastName, $PartnerType, $Address, $MailingAddress?$MailingAddress:$Address, $Phone, $MailingPhone, $Email, $dtBirthDay, $PersonalCard, $dtDateIssue, $PlaceIssue, 'F', $BankAccountNo, $Country, $BankName );								
			$result = $this->_MDB2_WRITE->extended->getAll($query);		
			$this->_MDB2_WRITE->disconnect();
			$Name 		= '';
			$Address 	= '';
			$Account 	= '';
			$Status 	= '';	
			$RespString = '';
			$OldNewAccount = '';
			if(empty($result) || is_object($result))	$this->_ERROR_CODE = 8049;	
			else {					
				if(isset($result[0]['varerror'])){												
					if($result[0]['varerror'] == -1){
						 $this->_ERROR_CODE = 8051;//exception
						 $RespString = 'EPS-err : exception';
					}
					//if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 18052;// duplicate cardno
					if($result[0]['varerror'] == -3){
						 $this->_ERROR_CODE = 8053;//invalid countryName
						 $RespString = 'EPS-err invalid country name';
					}
					if($result[0]['varerror'] == -4){
						 $this->_ERROR_CODE = 8054;//update account err
						 $RespString = 'EPS-err update account';
					}
					if($result[0]['varerror'] == -5){
						$this->_ERROR_CODE = 8055;//insert investor err
						$RespString = 'EPS-err insert Investor';
					}
					if($result[0]['varerror'] == -6){
						$this->_ERROR_CODE = 8056;//ins MoneyBalance err
						$RespString = 'EPS-err insert Balance';
					}
					if($result[0]['varerror'] == -2 || $result[0]['varerror'] >= 0){
						$Name 		= $result[0]['v_sfullname'];
						$Address 	= $result[0]['sresidentaddress']?$result[0]['sresidentaddress']:'';
						$Account 	= $result[0]['v_saccountno'];
						$Status 	= $result[0]['v_iisactive']?'A':'H';
						$OldNewAccount = $result[0]['v_icreated']?0:1;
						$RespString = 'Sucess';
						if($result[0]['v_icreated'] == 0)
						{							
							$new_account = array("AccountNo" => $Account, "AccountName" => $Name, "Address" => $Address, "Tel" => $Phone, "InvestorType" => ($PartnerType=='F')?2:1, "ContractNo" => '', "City" => "", "BankAccount" => $BankAccountNo, "Bank"=>41);	//var_dump($new_account);
							$ret = addNewCustomer($new_account);
						//	var_dump($ret);
						if($ret['table0']['Result']!=1){
								$this->_ERROR_CODE = 8057;//ins MoneyBalance err
								$RespString = 'Bravo-Error';
							}
						}
					}
				}else{
					$this->_ERROR_CODE = 8049;
					$RespString = 'EPS-err: db err';
				}					
			}						
		}
		$array_input['PersonalCard'] = new SOAP_Value('PersonalCard', 'string', $PersonalCard);
		$array_input['Name'] = new SOAP_Value('Name', 'string', $Name);
		$array_input['Account'] = new SOAP_Value('Account', 'string', $Account);
		$array_input['State'] = new SOAP_Value('State', 'string', $Status);
		$array_input['ResponseCode'] = new SOAP_Value('ResponseCode', 'string',$this->_ERROR_CODE);
		$array_input['RespString'] = new SOAP_Value('RespString', 'string', $RespString);
		$array_input['OldNewAccount'] = new SOAP_Value('OldNewAccount', 'string', $OldNewAccount);
		
		
		write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. $query. ' ErrorCode '  .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		//mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. ErrorCode .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, /*$PersonalCard, $Name, $Account, $State, $ResponseCode, $RespString, $OldNewAccount, */$array_input, $this );
	}
	
	function OpenAccount1($PersonalCard, $Name, $Address, $BankAccountNo, $PartnerType, $dtBirthDay, $PlaceOfBirth, $dtDateIssue, $PlaceIssue, $ZipCode, $Country, $Email, $Phone, $Fax, $CompanyAddress, $CompanyPhone, $MailingAddress, $MailingPhone)
	{
		$class_name = $this->class_name;
		$function_name = 'OpenAccount1';
		$this->_ERROR_CODE = '0000';
		if (0){//authenUser(func_get_args(), $this, $function_name) > 0 ){
			$Name 		= '';
			$Address 	= '';
			$Account 	= '';
			$Status 	= '';	
			$RespString = 'Invalid user/Password';
			$OldNewAccount = '';
			
			write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
			mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' ErrorCode '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s').' ErrorCode '.$this->_ERROR_CODE);
			$array_input['PersonalCard'] = new SOAP_Value('PersonalCard', 'string', $PersonalCard);
			$array_input['Name'] = new SOAP_Value('Name', 'string', $Name);
			$array_input['Account'] = new SOAP_Value('Account', 'string', $Account);
			$array_input['State'] = new SOAP_Value('State', 'string', $State);
			$array_input['ResponseCode'] = new SOAP_Value('ResponseCode', 'string', $this->_ERROR_CODE);
			$array_input['RespString'] = new SOAP_Value('RespString', 'string', $RespString);
			$array_input['OldNewAccount'] = new SOAP_Value('OldNewAccount', 'string', $OldNewAccount);
			return returnXML(func_get_args(), $this->class_name, $function_name, /*$PersonalCard, $Name, $Account, $State, $ResponseCode, $RespString, $OldNewAccount,*/$array_input, $this );
		}
		if(!required($Name)){
			 $this->_ERROR_CODE = 8013;
			 $RespString = 'Name is null';
		}
		if($this->_ERROR_CODE=='0000' && !required($BankAccountNo)){
			$this->_ERROR_CODE = 8016;			
			$RespString = 'BankAccountNo is null';
		}
		if($this->_ERROR_CODE=='0000' && !required($PersonalCard)){
			$this->_ERROR_CODE = 8072;			
			$RespString = 'PersonalCard is null';
		}
		if($this->_ERROR_CODE=='0000' && isset($PartnerType)&&(strlen($PartnerType)>0)&&!in_array($PartnerType,array('C','F','P'))){
			$this->_ERROR_CODE = 8028;
			$RespString = 'Invalid PartnerType';
		}
		
		if($this->_ERROR_CODE=='0000')
		{
			$BankName = 'VietComBank';
			$pos = strpos($Name, ' ');
			$FirstName = substr($Name, 0, $pos+1);
			$LastName = substr($Name, $pos+1);
			$query = sprintf( "CALL Sp_aaaaOpenPrivateAccount_VCB
('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $FirstName, $LastName, $PartnerType, $Address, $MailingAddress, $Phone, $MailingPhone, $Email, $dtBirthDay, $PersonalCard, $dtDateIssue, $PlaceIssue, 'F', $BankAccountNo, $Country, $BankName );								
			$result = $this->_MDB2_WRITE->extended->getAll($query);		
			$this->_MDB2_WRITE->disconnect();
			$Name 		= '';
			$Address 	= '';
			$Account 	= '';
			$Status 	= '';	
			$RespString = '';
			$OldNewAccount = '';
			if(empty($result) || is_object($result))	$this->_ERROR_CODE = 8049;	
			else {					
				if(isset($result[0]['varerror'])){												
					if($result[0]['varerror'] == -1){
						 $this->_ERROR_CODE = 8051;//exception
						 $RespString = 'EPS-err : exception';
					}
					//if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 18052;// duplicate cardno
					if($result[0]['varerror'] == -3){
						 $this->_ERROR_CODE = 8053;//invalid countryName
						 $RespString = 'EPS-err invalid country name';
					}
					if($result[0]['varerror'] == -4){
						 $this->_ERROR_CODE = 8054;//update account err
						 $RespString = 'EPS-err update account';
					}
					if($result[0]['varerror'] == -5){
						$this->_ERROR_CODE = 8055;//insert investor err
						$RespString = 'EPS-err insert Investor';
					}
					if($result[0]['varerror'] == -6){
						$this->_ERROR_CODE = 8056;//ins MoneyBalance err
						$RespString = 'EPS-err insert Balance';
					}
					if($result[0]['varerror'] == -2 || $result[0]['varerror'] == 0){
						$Name 		= $result[0]['v_sfullname'];
						$Address 	= $result[0]['sresidentaddress'];
						$Account 	= $result[0]['v_saccountno'];
						$Status 	= $result[0]['v_iisactive']?'A':'H';
						$OldNewAccount = $result[0]['v_icreated']?0:1;
						$RespString = 'Sucess';
					}
				}else{
					$this->_ERROR_CODE = 8049;
					$RespString = 'EPS-err: db err';
				}					
			}						
		}
		$array_input['PersonalCard'] = new SOAP_Value('PersonalCard', 'string', $PersonalCard);
		$array_input['Name'] = new SOAP_Value('Name', 'string', $Name);
		$array_input['Account'] = new SOAP_Value('Account', 'string', $Account);
		$array_input['State'] = new SOAP_Value('State', 'string', $Status);
		$array_input['ResponseCode'] = new SOAP_Value('ResponseCode', 'string',$this->_ERROR_CODE);
		$array_input['RespString'] = new SOAP_Value('RespString', 'string', $RespString);
		$array_input['OldNewAccount'] = new SOAP_Value('OldNewAccount', 'string', $OldNewAccount);
		
		
		write_my_log('VCB-test',$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. ErrorCode .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		mailSMTP('webmaster@eps.com.vn','webmaster@eps.com.vn','chi.dl@eps.com.vn','','','Ket noi VietCombank test','Test ket noi VietComBank '.$_SERVER['REMOTE_ADDR'].' function_name '.$function_name.' Input PersonalCard ' .$PersonalCard. ' Name '. $Name. ' Address '. $Address. ' BankAccountNo '. $BankAccountNo. ' PartnerType '. $PartnerType. ' dtBirthDay '. $dtBirthDay. ' PlaceOfBirth '. $PlaceOfBirth. ' dtDateIssue '. $dtDateIssue. ' PlaceIssue '. $PlaceIssue. ' ZipCode '. $ZipCode. ' Country '.$Country. ' Email '. $Email. ' Phone '. $Phone. ' Fax '. $Fax. ' CompanyAddress '.$CompanyAddress. ' CompanyPhone '. $CompanyPhone. ' MailingAddress '. $MailingAddress. ' MailingPhone '. $MailingPhone.' Output Account'.$Account.' State A '. ErrorCode .$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, /*$PersonalCard, $Name, $Account, $State, $ResponseCode, $RespString, $OldNewAccount, */$array_input, $this );
	}
		
}

function addNewCustomer($values) {
		//echo WEBSERVICE_URL.' '.BRAVO_KEY;
		$soap_client = &new SoapClient(WEBSERVICE_URL, array('trace' => 1) ); 	
			$params["key"] = BRAVO_KEY;
			$params["newCust"] = 'A';
			$params["customerCode"] = $values["AccountNo"];		
			$params["customerName"] = $values["AccountName"]; 
			$params["address"] = $values["Address"]?$values["Address"]:'';
			$params["dien_thoai"] = $values["Tel"]?$values["Tel"]:'';
			$params["Loai_hd"] = $values["InvestorType"];
			$params["sohopdong"] = $values["ContractNo"];
			$params["chinhanh"] = $values["City"]?$values["City"]:''; 
			$params["so_tk_nh"] = $values["BankAccount"]?$values["BankAccount"]:'';
			$params["ngan_hang"] = $values["Bank"]?$values["Bank"]:'';  
			$params["customerCode_Close"] = ""; 
			//var_dump($params);
			$soap_client->NewCustomer($params);								 	
	
			$data = $soap_client->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 			
			return $ret["soap:Body"]["NewCustomerResponse"]["NewCustomerResult"]["DS"];
		
	}
?>
