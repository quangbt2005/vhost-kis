<?php
/**
	Author: Diep Le Chi
	Created date: 03/05/2007
*/
require_once('../includes.php');

class CPayment extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor
	*/

	function CPayment($check_ip) {
		//initialize _MDB2
		$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		$this->_TIME_ZONE = get_timezon();
		$this->items = array();

		$this->class_name = get_class($this);
		$arr = array(
					/*'listMortageContractUnpaid' => array(
										'input' => array('TimeZone'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'InvestorName', 'ContractNo','BankID', 'BankName', 'IsAssigner', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate')
										),
					'listMortageContractUnpaidWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array('ID', 'AccountID', 'AccountNo', 'InvestorName', 'ContractNo','BankID', 'BankName', 'IsAssigner', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate')
										),
					'addPayment' => array(
										'input' => array( 'MortageContractID', 'PaymentDate', 'TotalMoney', 'CreatedBy'),
										'output' => array('ID')
										),
					'addPaymentDetail' => array(
										'input' => array('PaymentContractID', 'MortageContractDetailID', 'PaymentTypeID', 'RaiseBlockedDate', 'Quantity', 'AmountMoney', 'CreatedBy'),
										'output' => array()
										),
					'deletePayment' => array(
										'input' => array('PaymentContractID','UpdatedBy'),
										'output' => array()
										),
					'getSoldMortageMoney' => array(
										'input' => array( 'AccountID'),
										'output' => array( 'Amount')
										),
					'updateBalancePayment' => array(
										'input' => array('PaymentContractID','UpdatedBy'),
										'output' => array()
										),*/

					'updateNormalWhenPayment' => array( 'input' => array( 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'UpdatedBy' ),
									'output' => array( )),

					'getSoldMortage' => array( 'input' => array( 'AccountNo', 'TradingDate' ),
									'output' => array( 'AccountNo', 'Symbol', 'Quantity', 'FullName' )),

					'insertPaymentWithoutConfirmed' => array( 'input' => array( 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'CreatedBy', 'BankID' ),
									'output' => array( 'ID' )),

					'updatePaymentWithoutConfirmed' => array( 'input' => array( 'PaymentHistoryID', 'Quantity', 'UpdatedBy', 'BankID' ),
									'output' => array( )),

					'deletePaymentWithoutConfirmed' => array( 'input' => array( 'PaymentHistoryID', 'UpdatedBy' ),
									'output' => array( )),

					'getPaymentHistoryList' => array( 'input' => array( 'AccountNo', 'FromDate', 'ToDate', 'IsConfirmed' ),
									'output' => array( 'ID', 'AccountNo', 'Symbol', 'Quantity', 'PaymentDate', 'IsConfirmed', 'ShortName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'StockExchangeID' )),

					'confirmPaymentHistory' => array( 'input' => array( 'PaymentHistoryID', 'UpdatedBy' ),
									'output' => array( )),

					'insertCollectDebt' => array( 'input' => array( 'AccountNo', 'Payment', 'PaymentInterest', 'ContractNo', 'CreatedBy', 'BankID', 'ContractBankID', 'MortageID' ),
									'output' => array( 'ID' )),

					'updateCollectDebt' => array( 'input' => array( 'CollectDebtID', 'AccountNo', 'Payment', 'PaymentInterest', 'ContractNo', 'UpdatedBy', 'BankID', 'ContractBankID', 'MortageID' ),
									'output' => array( )),

					'deleteCollectDebt' => array( 'input' => array( 'CollectDebtID', 'UpdatedBy' ),
									'output' => array( )),

					'getCollectDebtList' => array( 'input' => array( 'AccountNo', 'ContractNo', 'FromDate', 'ToDate', 'IsBank' ),
									'output' => array( 'CollectDebtID', 'AccountNo', 'FullName', 'Payment', 'PaymentInterest', 'ContractNo', 'IsBank', 'IsBravo', 'BankAccount', 'BankName', 'BravoCode', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'ContractBankID', 'ShortName' )),

					'confirmCollectDebt' => array( 'input' => array( 'CollectDebtID', 'UpdatedBy' ),
									'output' => array( )),

					'NewInsertPaymentDetailWithoutConfirmed' => array( 'input' => array( 'MortageID', 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'CreatedBy', 'Note' ),
									'output' => array( 'ID' )),

					'NewUpdatePaymentDetailWithoutConfirmed' => array( 'input' => array( 'PaymentDetailID', 'Quantity', 'UpdatedBy', 'Note' ),
									'output' => array( )),

					'NewDeletePaymentDetailWithoutConfirmed' => array( 'input' => array( 'PaymentDetailID', 'UpdatedBy' ),
									'output' => array( )),

					'NewGetPaymentDetailList' => array( 'input' => array( 'AccountNo', 'Symbol', 'FromDate', 'ToDate' ),
									'output' => array( 'ID', 'MortageID', 'AccountID', 'AccountNo', 'StockID', 'Symbol', 'Quantity', 'PaymentDate', 'Note', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'FullName' )),

					'NewConfirmPaymentDetail' => array( 'input' => array( 'PaymentDetailID', 'UpdatedBy' ),
									'output' => array( )),

					'NewGetPaymentDetailListWithCondition' => array( 'input' => array( 'WhereClause', 'TimeZone' ),
									'output' => array( 'ID', 'MortageID', 'AccountID', 'AccountNo', 'StockID', 'Symbol', 'Quantity', 'PaymentDate', 'Note', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'FullName' )),

				);
		parent::__construct($arr);
	}
	/**
	 *  __destruct
	 */
	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}
	/* ----------------------------- Account Function --------------------------------- */
	/**
	 * Function listMortageContractUnpaid	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listMortageContractUnpaid($timezone) {
		$class_name = $this->class_name;
		$function_name = 'listMortageContractUnpaid';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();

		$query = sprintf("SELECT * from vw_ListMortageContractUnpaid as m");

		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0)
		{
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
							'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
							'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'IsAssigner'  => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
							'ContractValue'  => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
							'ContractDate'  => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
							'ReleaseDate'  => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
							'BlockedDate'  => new SOAP_Value("BlockedDate", "string", $result[$i]['blockeddate'])
							)
					);
			}
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listMortageContractUnpaidWithFilter	:
	 * Input 							: String of condition in where clause and $timezone
	 * OutPut 							: array
	 */
	function listMortageContractUnpaidWithFilter($condition, $timezone) {
		$class_name = $this->class_name;
		$function_name = 'listMortageContractUnpaidWithFilter';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$this->items = array();

		$condition = $condition?' Where '.$condition:'';

		$query = sprintf("SELECT * from vw_ListMortageContractUnpaid as m %s", $condition);

		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0)
		{
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
							'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
							'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'IsAssigner'  => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
							'ContractValue'  => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
							'ContractDate'  => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
							'ReleaseDate'  => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
							'BlockedDate'  => new SOAP_Value("BlockedDate", "string", $result[$i]['blockeddate'])
							)
					);
			}
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addPayment	: insert new addPayment into database
	 * Input 				:  'MortageContractID', 'PaymentDate', 'TotalMoney', 'CreatedBy'
	 * OutPut 				: error code and insert ID. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addPayment($MortageContractID, $PaymentDate, $TotalMoney, $CreatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'addPayment';

		if (authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$data = array(
									"MortageContractID" 	=> $MortageContractID,
									"PaymentDate" 			=> $PaymentDate,
									"TotalMoney" 			=> $TotalMoney,
									"CreatedBy" 			=> $CreatedBy
									);
		if($this->_ERROR_CODE == 0) $this->_ERROR_CODE = $this->checkPayment($data);

		if($this->_ERROR_CODE == 0)
		{

			//echo $query;
			$result = $this->_MDB2_WRITE->extended->getAll($query);

			if(empty($result))	$this->_ERROR_CODE = 18002;
			else{
					if(isset($result[0]['varerror']))
					{
						//echo $result[0]['varerror'];
						// AccountNo have been exist
						if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 18005;
						// Invalid BranchID
						if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 18046;
						//Exception --insert account
						if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 18080;
						// CardNo have been exist
						if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 18006;
						//Invalid Country ID
						if($result[0]['varerror'] == -5) $this->_ERROR_CODE = 18008;
						//Invalid AgencyFee ID
						if($result[0]['varerror'] >0)
						{
							$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
									)
							);
						}else if($this->_ERROR_CODE == 0){
							$this->_ERROR_CODE = $result[0]['varerror'];
						}
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateAccount: update Account
	 * Input 				:  'ID', 'AccountNo', 'ContractNo', 'OpenDate', 'BranchID', 'InvestorID', 'FirstName', 'LastName', 'CardNo', 'CardNoDate', 'CardNoIssuer', 'Gender', 'Ethnic', 'ResidentAddress', 'ContactAddress', 'HomePhone', 'MobilePhone', 'Email', 'BankAccount', 'BankID', 'CountryID', 'AgencyFeeID', 'SignaturePath', 'AssignFirstName', 'AssignLastName', 'AssignAddress', 'AssignCardNo', 'AssignCardNoDate', 'AssignCardNoIssue', 'AssignTelephone', 'AssignSignaturePath', 'PrivilegeID', 'UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	 function updateAccount($AccountID, $ContractNo, $OpenDate, $BranchID, $InvestorID, $FirstName, $LastName, $CardNo, $CardNoDate, $CardNoIssuer, $Gender, $Ethnic, $ResidentAddress, $ContactAddress, $HomePhone, $MobilePhone, $Email, $BankAccount, $BankID, $CountryID, $AgencyFeeID, $SignaturePath, $InvestorType, $InvestorNote, $AssignID, $AssignFirstName,$AssignLastName, $AssignAddress, $AssignCardNo, $AssignCardNoDate, $AssignCardNoIssue, $AssignTelephone, $AssignSignaturePath, $AssignNote, $PrivilegeID, $AssignLawID, $AssignLawFirstName, $AssignLawLastName, $AssignLawAddress, $AssignLawCardNo, $AssignLawCardNoDate, $AssignLawCardNoIssue, $AssignLawTelephone, $AssignLawSignaturePath, $AssignLawNote, $PrivilegeIDLaw, $UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'updateAccount';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$data = array(
									"ID"					=> $AccountID,
									"ContractNo" 			=> $ContractNo,
									"OpenDate" 				=> $OpenDate,
									"BranchID"				=> $BranchID,
									"InvestorID"			=> $InvestorID,
									"FirstName"				=> $FirstName,
									"LastName" 				=> $LastName,
									"CardNo" 				=> $CardNo,
									"CardNoDate" 			=> $CardNoDate,
									"CardNoIssuer"			=> $CardNoIssuer,
									"Gender" 				=> $Gender,
									"Ethnic" 				=> $Ethnic,
									"ResidentAddress" 		=> $ResidentAddress,
									"ContactAddress"		=> $ContactAddress,
									"HomePhone" 			=> $HomePhone,
									"MobilePhone" 			=> $MobilePhone,
									"Email" 				=> $Email,
									"BankAccount"			=> $BankAccount,
									"BankID" 				=> $BankID,
									"CountryID" 			=> $CountryID,
									"AgencyFeeID" 			=> $AgencyFeeID,
									"SignaturePath"			=> $SignaturePath,
									"InvestorType"			=> $InvestorType,
									"InvestorNote"			=> $InvestorNote,
									"AssignID"				=> $AssignID,
									"AssignFirstName" 		=> $AssignFirstName,
									"AssignLastName" 		=> $AssignLastName,
									"AssignAddress" 		=> $AssignAddress,
									"AssignCardNo"			=> $AssignCardNo,
									"AssignCardNoDate" 		=> $AssignCardNoDate,
									"AssignCardNoIssue" 	=> $AssignCardNoIssue,
									"AssignTelephone" 		=> $AssignTelephone,
									"AssignSignaturePath"	=> $AssignSignaturePath,
									"AssignNote"			=> $AssignNote,
									"PrivilegeID"			=> $PrivilegeID,
									"AssignLawID"			=> $AssignLawID,
									"AssignLawFirstName" 	=> $AssignLawnFirstName,
									"AssignLawLastName" 	=> $AssignLawLastName,
									"AssignLawAddress" 		=> $AssignLawAddress,
									"AssignLawCardNo"		=> $AssignLawCardNo,
									"AssignLawCardNoDate" 	=> $AssignLawCardNoDate,
									"AssignLawCardNoIssue" 	=> $AssignLawCardNoIssue,
									"AssignLawTelephone" 	=> $AssignLawTelephone,
									"AssignLawSignaturePath"=> $AssignLawSignaturePath,
									"AssignLawNote"			=> $AssignLawNote,
									"PrivilegeIDLaw"		=> $PrivilegeIDLaw,
									"UpdatedBy" 			=> $UpdatedBy,
									);//$this->_DATE_NOW//
		if($AccountID==''||$AccountID<=0)
		{
			$this->_ERROR_CODE = 18001;
		} else
		{
			// Check validate data input
			$this->_ERROR_CODE = $this->checkAccountValidate($data);
			if($this->_ERROR_CODE == 0 && ($AssignLastName!='' || $AssignCardNo!='')) $this->_ERROR_CODE = $this->checkAssignValidate($data);
			if($this->_ERROR_CODE == 0 && ($AssignLawLastName!='' || $AssignLawCardNo!='')) $this->_ERROR_CODE = $this->checkAssignLawValidate($data);

		}

		if($this->_ERROR_CODE == 0)
		{
			if($InvestorType == 3 || $InvestorType == 4 || $InvestorType == 5)
			{	//To Chuc
				$query = sprintf( "CALL sp_UpdateOrganizeAccount ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $AccountID , $ContractNo, $OpenDate, $BranchID, $FirstName, $LastName, $CardNo, $CardNoDate, $CardNoIssuer, $Gender, $Ethnic, $ResidentAddress, $ContactAddress, $HomePhone, $MobilePhone, $Email, $BankAccount, $BankID, $CountryID, $AgencyFeeID, $SignaturePath, $InvestorType, $InvestorNote, $AssignFirstName, $AssignLastName, $AssignAddress, $AssignCardNo, $AssignCardNoDate, $AssignCardNoIssue, $AssignTelephone, $AssignSignaturePath, $AssignNote, ASSIGNER, $PrivilegeID, $AssignLawFirstName, $AssignLawLastName, $AssignLawAddress, $AssignLawCardNo, $AssignLawCardNoDate, $AssignLawCardNoIssue, $AssignLawTelephone, $AssignLawSignaturePath, $AssignLawNote, LAW_ASSIGNER, $PrivilegeIDLaw, $UpdatedBy);
			}else{
				$query = sprintf( "CALL sp_UpdatePrivateAccount ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $AccountID , $ContractNo, $OpenDate, $BranchID, $FirstName, $LastName, $CardNo, $CardNoDate, $CardNoIssuer, $Gender, $Ethnic, $ResidentAddress, $ContactAddress, $HomePhone, $MobilePhone, $Email, $BankAccount, $BankID, $CountryID, $AgencyFeeID, $SignaturePath, $InvestorType, $InvestorNote, $AssignFirstName, $AssignLastName, $AssignAddress, $AssignCardNo, $AssignCardNoDate, $AssignCardNoIssue, $AssignTelephone, $AssignSignaturePath, $AssignNote, ASSIGNER, $PrivilegeID, $UpdatedBy);

			}
			//echo $query;
			$result = $this->_MDB2_WRITE->extended->getAll($query);

			if(empty($result))	$this->_ERROR_CODE = 18003;
			else{
					if(isset($result[0]['varerror']))
					{
						//Exception --insert assign
						if($result[0]['varerror'] == -10) $this->_ERROR_CODE = 18083;
						//Duplicate Assigner_Law
						if($result[0]['varerror'] == -11) $this->_ERROR_CODE = 18084;
						//Exception --insert assignlaw
						if($result[0]['varerror'] == -12) $this->_ERROR_CODE = 18085;
						//Exception --insert privilele assign
						if($result[0]['varerror'] == -17) $this->_ERROR_CODE = 18087;
						//Invalid PrivilegeIDLaw
						if($result[0]['varerror'] == -18) $this->_ERROR_CODE = 18050;
						//Exception --insert privilele assignlaw
						if($result[0]['varerror'] == -19) $this->_ERROR_CODE = 18088;
						//Duplicate ContracNo
						if($result[0]['varerror'] == -62) $this->_ERROR_CODE = 18086;
						//Invalid Branch ID
						if($result[0]['varerror'] == -63) $this->_ERROR_CODE = 18046;
						//Can not update account
						if($result[0]['varerror'] == -64 || $result[0]['varerror'] == -104) $this->_ERROR_CODE = 18003;
						//Exception --update account
						if($result[0]['varerror'] == -65) $this->_ERROR_CODE = 18092;
						//Duplicate Assigner
						if($result[0]['varerror'] == -66 || $result[0]['varerror'] == -9) $this->_ERROR_CODE = 18082;
						//Can not update assigner
						if($result[0]['varerror'] == -67) $this->_ERROR_CODE = 18093;
						//Exception --update assigner
						if($result[0]['varerror'] == -68) $this->_ERROR_CODE = 18094;
						//Invalid PrivilegeID
						if($result[0]['varerror'] == -72 || $result[0]['varerror'] == -16) $this->_ERROR_CODE = 18010;
						//Can not update assign_privilege
						if($result[0]['varerror'] == -73) $this->_ERROR_CODE = 18096;
						//Exception --update assign_privilege
						if($result[0]['varerror'] == -74) $this->_ERROR_CODE = 18095;
						//Exception -- update investor
						if($result[0]['varerror'] == -78) $this->_ERROR_CODE = 18097;
						//Duplicate CardNo
						if($result[0]['varerror'] == -79) $this->_ERROR_CODE = 18006;
						//Invalid CountryID
						if($result[0]['varerror'] == -80) $this->_ERROR_CODE = 18008;
						//Invalid AgencyFeeID
						if($result[0]['varerror'] == -81) $this->_ERROR_CODE = 18009;
						//Invalid BankID
						if($result[0]['varerror'] == -82) $this->_ERROR_CODE = 18007;
						//Can not update investor
						if($result[0]['varerror'] == -83) $this->_ERROR_CODE = 18098;
						//Invalid AccountID
						if($result[0]['varerror'] == -101 || $result[0]['varerror'] == -103) $this->_ERROR_CODE = 18001;
						//Exception
						if(in_array($result[0]['varerror'],array('-100','-102','-105','-106','-107','-108','-109','-110','-111','-112','-113'))) $this->_ERROR_CODE = 18099;
						if($result[0]['varerror']<0 && $this->_ERROR_CODE == 0){
							$this->_ERROR_CODE = $result[0]['varerror'];
						}
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkAccountValidate	: check the validation of data input
	 * Input 					: array of data
	 * Output 					: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkPayment($data)
	{
		//if(!required($data['FirstName'])) return 18012;
		if(!required($data['MortageContractID']) || !numeric($data['MortageContractID'])) return 21005;
		if(!required($data['PaymentDate'])||!valid_date($data['PaymentDate'])) return 21007;
		if(!required($data['TotalMoney']) || !numeric($data['TotalMoney']) || $data['TotalMoney']<40000000) return 21009;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 21010;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 21011;
		return 0;
	}

	/**Function getSoldMortageMoney :
	 * Input :  'AccountID'
	 * OutPut : array
	 */
	 function getSoldMortageMoney($AccountID) {
		$class_name = $this->class_name;
		$function_name = 'getSoldMortageMoney';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$query = sprintf( "select f_getMoneySoldMortage('%s') as Amount",$AccountID);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0)
		{
			//var_dump($result);
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/* ----------------------------- End Account Function --------------------------------- */
	/**
		Function: updateNormalWhenPayment
		Description:
		Input:
		Output: success / error code
	*/
	function updateNormalWhenPayment($AccountNo, $Symbol, $Quantity, $TradingDate, $UpdatedBy) {
		$function_name = 'updateNormalWhenPayment';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($Symbol) || !required($TradingDate)
				|| !required($Quantity) || !unsigned($Quantity) ) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 21042;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 21043;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 21044;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 21045;

		} else {
			$query = sprintf( "CALL sp_updateNormalWhenPayment('%s', '%s', %u, '%s', '%s')",
							$AccountNo, $Symbol, $Quantity, $TradingDate, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21046;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21047;
							break;

						case '-2':
							$this->_ERROR_CODE = 21048;
							break;

						case '-3':
							$this->_ERROR_CODE = 21049;
							break;

						case '-4':
							$this->_ERROR_CODE = 21050;
							break;

						case '-5':
							$this->_ERROR_CODE = 21051;
							break;

						case '-6':
							$this->_ERROR_CODE = 21052;
							break;

						case '-7':
							$this->_ERROR_CODE = 21052;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getSoldMortage
		Description:
		Input:
		Output: success / error code
	*/
	function getSoldMortage($AccountNo, $TradingDate) {
		$function_name = 'getSoldMortage';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getSoldMortage('%s', '%s')", $AccountNo, $TradingDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
				'item',
				$struct,
				array(
					"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
					"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
					"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
					"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
					)
			);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertPaymentWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function insertPaymentWithoutConfirmed($AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $BankID) {
		$function_name = 'insertPaymentWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($Quantity) || !unsigned($Quantity) || !required(Symbol) || !required($TradingDate)) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 21060;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 21061;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 21062;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 21063;
		} else {
			$query = sprintf( "CALL sp_insertPaymentWithoutConfirmed( '%s', '%s', %u, '%s', '%s', %u )",
							$AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21064;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21065;
							break;

						case '-2':
							$this->_ERROR_CODE = 21066;
							break;

						case '-3':
							$this->_ERROR_CODE = 21067;
							break;

						case '-4':
							$this->_ERROR_CODE = 21068;
							break;

						case '-5':
							$this->_ERROR_CODE = 21069;
							break;

						case '-7':
							$this->_ERROR_CODE = 21070;
							break;

						case '-8':
							$this->_ERROR_CODE = 21071;
							break;
					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateMortageWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function updatePaymentWithoutConfirmed($PaymentHistoryID, $Quantity, $UpdatedBy, $BankID) {
		$function_name = 'updatePaymentWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($PaymentHistoryID) || !unsigned($PaymentHistoryID) || !required($Quantity) || !unsigned($Quantity) ) {

			if ( !required($PaymentHistoryID) || !unsigned($PaymentHistoryID) )
				$this->_ERROR_CODE = 21080;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 21081;

		} else {
			$query = sprintf( "CALL sp_updatePaymentWithoutConfirmed(%u, %u, '%s', %u)", $PaymentHistoryID, $Quantity, $UpdatedBy, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21082;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21083;
							break;

						case '-2':
							$this->_ERROR_CODE = 21084;
							break;

						case '-3':
							$this->_ERROR_CODE = 21085;
							break;

						case '-4':
							$this->_ERROR_CODE = 21086;
							break;

						case '-5':
							$this->_ERROR_CODE = 21087;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deletePaymentWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function deletePaymentWithoutConfirmed($PaymentHistoryID, $UpdatedBy) {
		$function_name = 'deletePaymentWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($PaymentHistoryID) || !unsigned($PaymentHistoryID) ) {
				$this->_ERROR_CODE = 21090;

		} else {
			$query = sprintf( "CALL sp_deletePaymentWithoutConfirmed(%u, '%s')", $PaymentHistoryID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21091;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21092;
							break;

						case '-2':
							$this->_ERROR_CODE = 21093;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getPaymentHistoryList
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function getPaymentHistoryList($AccountNo, $FromDate, $ToDate, $IsConfirmed ) {
		$function_name = 'getPaymentHistoryList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getPaymentHistoryList( '%s', '%s', '%s', '%s' )", $AccountNo, $FromDate, $ToDate, $IsConfirmed );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
						"PaymentDate"    => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"ShortName"    => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: confirmPaymentHistory
		Description:
		Input:
		Output: success / error code
	*/
	function confirmPaymentHistory($PaymentHistoryID, $UpdatedBy) {
		$function_name = 'confirmPaymentHistory';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_confirmPaymentHistory(%u, '%s')", $PaymentHistoryID, $UpdatedBy);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 21100;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 21101;
						break;

					case '-2':
						$this->_ERROR_CODE = 21102;
						break;

					case '-5':
						$this->_ERROR_CODE = 21103;
						break;

					case '-6':
						$this->_ERROR_CODE = 21104;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertCollectDebt
		Description:
		Input:
		Output: success / error code
	*/
	function insertCollectDebt($AccountNo, $Payment, $PaymentInterest, $ContractNo, $CreatedBy, $BankID, $ContractBankID, $MortageID) {
		$function_name = 'insertCollectDebt';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($Payment) || !required($PaymentInterest) || !required($ContractNo)) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 21110;

			if ( !required($Payment) )
				$this->_ERROR_CODE = 21111;

			if ( !required($PaymentInterest) )
				$this->_ERROR_CODE = 21112;

			if ( !required($ContractNo) )
				$this->_ERROR_CODE = 21113;

		} else {
			$query = sprintf( "CALL sp_insertCollectDebt( '%s', %f, %f, '%s', '%s', %u, %u, %u )",
                $AccountNo, $Payment, $PaymentInterest, $ContractNo, $CreatedBy, $BankID, $ContractBankID, $MortageID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21114;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21115;
							break;

						case '-2':
							$this->_ERROR_CODE = 21116;
							break;

						case '-3':
							$this->_ERROR_CODE = 21117;
							break;

					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateCollectDebt
		Description:
		Input:
		Output: success / error code
	*/
	function updateCollectDebt($CollectDebtID, $AccountNo, $Payment, $PaymentInterest, $ContractNo, $UpdatedBy, $BankID, $ContractBankID, $MortageID) {
    $function_name = 'updateCollectDebt';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($CollectDebtID) || !unsigned($CollectDebtID) || !required($AccountNo) || !required($Payment) || !required($PaymentInterest) ||  !required($ContractNo) ) {

			if ( !required($CollectDebtID) || !unsigned($CollectDebtID) )
				$this->_ERROR_CODE = 21120;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 21121;

			if ( !required($Payment) )
				$this->_ERROR_CODE = 21122;

			if ( !required($PaymentInterest) )
				$this->_ERROR_CODE = 21123;

			if ( !required($ContractNo) )
				$this->_ERROR_CODE = 21124;

		} else {
      $query = sprintf( "CALL sp_updateCollectDebt(%u, '%s', %f, %f, '%s', '%s', %u, %u, %u)",
                $CollectDebtID, $AccountNo, $Payment, $PaymentInterest, $ContractNo, $UpdatedBy, $BankID, $ContractBankID, $MortageID );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 21125;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21126;
							break;

						case '-2':
							$this->_ERROR_CODE = 21127;
							break;

						case '-3':
							$this->_ERROR_CODE = 21128;
							break;

						case '-4':
							$this->_ERROR_CODE = 21129;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteCollectDebt
		Description:
		Input:
		Output: success / error code
	*/
	function deleteCollectDebt($CollectDebtID, $UpdatedBy) {
		$function_name = 'deleteCollectDebt';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($CollectDebtID) || !unsigned($CollectDebtID) ) {
				$this->_ERROR_CODE = 21130;

		} else {
			$query = sprintf( "CALL sp_deleteCollectDebt(%u, '%s')", $CollectDebtID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21131;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21132;
							break;

						case '-2':
							$this->_ERROR_CODE = 21133;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getCollectDebtList
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function getCollectDebtList($AccountNo, $ContractNo, $FromDate, $ToDate, $IsBank ) {
		$function_name = 'getCollectDebtList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getCollectDebtList( '%s', '%s', '%s', '%s', '%s' )", $AccountNo, $ContractNo, $FromDate, $ToDate, $IsBank);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"CollectDebtID"    => new SOAP_Value("CollectDebtID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"Payment"    => new SOAP_Value("Payment", "string", $result[$i]['payment']),
						"PaymentInterest"    => new SOAP_Value("PaymentInterest", "string", $result[$i]['paymentinterest']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"IsBank"    => new SOAP_Value("IsBank", "string", $result[$i]['isbank']),
						"IsBravo"    => new SOAP_Value("IsBravo", "string", $result[$i]['isbravo']),
						"BankAccount"    => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"BravoCode"    => new SOAP_Value("BravoCode", "string", $result[$i]['bravocode']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"ContractBankID"    => new SOAP_Value("ContractBankID", "string", $result[$i]['contractbankid']),
						"ShortName"    => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: confirmCollectDebt
		Description:
		Input:
		Output: success / error code
	*/
	function confirmCollectDebt($CollectDebtID, $UpdatedBy) {
		$function_name = 'confirmCollectDebt';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($CollectDebtID) || !unsigned($CollectDebtID) ) {
				$this->_ERROR_CODE = 21130;

		} else {
			$query = sprintf( "CALL sp_getInfoForCollectDebt( %u )", $CollectDebtID);
			$rs = $this->_MDB2->extended->getRow($query);
			$dab_rs = 999;
			$Amount = $rs['payment'] + $rs['paymentinterest'];
			$description = "EPS thu nợ cầm cố hợp đồng " . $rs['contractno'];
			switch ($rs['bankid']) {
				case DAB_ID:
					$dab = &new CDAB();
					$contractno = $CollectDebtID ." ". $rs['contractno'] ;
					$dab_rs = $dab->transfertoEPS($rs['bankaccount'], $rs['accountno'], $contractno, $Amount, $description);
					break;

				case OFFLINE:
					$mdb = initWriteDB();
					$query = sprintf( "CALL sp_VirtualBank_CollectDebt(%u, '%s', '%s')", $CollectDebtID, date("Y-m-d"), $UpdatedBy);
					$offline_rs = $mdb->extended->getRow($query);
					$mdb->disconnect();

					if (PEAR::isError($offline_rs)) {
						$this->_ERROR_CODE = 21200;
					} else {
						$result = $offline_rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 21201;
									break;

								case '-2':
									$this->_ERROR_CODE = 21202;
									break;

								case '-3':
									$this->_ERROR_CODE = 21203;
									break;

								case '-4':
									$this->_ERROR_CODE = 21204;
									break;

								case '-5':
									$this->_ERROR_CODE = 21205;
									break;

								case '-9':
									$this->_ERROR_CODE = 21206;
									break;
							}//switch
						} else {//if
							$dab_rs = 0;
						}
					}//if PEAR
					break;

				case VCB_ID:
					$dab_rs = 666;
					break;
			}

			if ($dab_rs == 0) { //Successfully
				$query = sprintf( "UPDATE %s SET IsBank='1', UpdatedBy='%s', CollectDate=date(now()), UpdatedDate=convert_tz(now(), '+07:00', '+00:00') WHERE ID=%u", TBL_COLLECT_DEBT, $UpdatedBy, $CollectDebtID );
				$this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				//bravo
				$soap = &new Bravo();

        if($rs['bravocode'] == VIRTUAL_BANK_BRAVO_BANKCODE)
        {
          $withdrawValue = array(
                            "TradingDate"     => date("Y-m-d"),
                            'TransactionType' => BRAVO_PAID_MORTAGE_EPS,
                            "AccountNo"       => $rs['accountno'],
                            "Amount"          => $rs['payment'],
                            "Fee"             => $rs['payment'],
                            "Bank"            => $rs['bravocode'],
                            "Branch"          => $rs['mortagebravocode'],
                            "Note"            => $description);
          $ret = $soap->withdraw($withdrawValue);

          if($ret['table0']['Result']==1 && $rs['paymentinterest'] > 0){
            $withdrawValue = array(
                              "TradingDate"     => date("Y-m-d"),
                              'TransactionType' => BRAVO_PAID_MORTAGE_INTEREST_EPS,
                              "AccountNo"       => $rs['accountno'],
                              "Amount"          => $rs['paymentinterest'],
                              "Fee"             => $rs['paymentinterest'],
                              "Bank"            => $rs['bravocode'],
                              "Branch"          => $rs['mortagebravocode'],
                              "Note"            => $description . ' - Lai cam co');
            $ret = $soap->withdraw($withdrawValue);
          }
        } else {
          $withdrawValue = array(
                            "TradingDate"     => date("Y-m-d"),
                            'TransactionType' => BRAVO_PAID_MORTAGE,
                            "AccountNo"       => $rs['accountno'],
                            "Amount"          => $rs['payment'],
                            "Fee"             => $rs['paymentinterest'],
                            "Bank"            => $rs['bravocode'],
                            "Branch"          => $rs['mortagebravocode'],
                            "Note"            => $description);
          $ret = $soap->withdraw($withdrawValue);
        }

				if($ret['table0']['Result']==1){ // success
					$this->_MDB2_WRITE->connect();
					$query = sprintf( "UPDATE %s SET IsBravo='1', UpdatedBy='%s', UpdatedDate=convert_tz(now(), '+07:00', '+00:00') WHERE ID=%u", TBL_COLLECT_DEBT, $UpdatedBy, $CollectDebtID );
					$this->_MDB2_WRITE->extended->getRow($query);
				} else { // Bravo fail
					switch ($ret['table0']['Result']) {
						case '-2':
							$this->_ERROR_CODE = 23002;
							break;

						case '-1':
							$this->_ERROR_CODE = 23003;
							break;

						case '-13':
							$this->_ERROR_CODE = 23006;
							break;

						case '-15':
							$this->_ERROR_CODE = 23005;
							break;

						case '-16':
							$this->_ERROR_CODE = 23004;
							break;

						default:
							$this->_ERROR_CODE = 'Bravo'. $ret['table0']['Result'];
					}//switch

				}
			} else { // bank fail
				switch ($dab_rs) {
/*					case '-1':
						$this->_ERROR_CODE = 22120;
						break;

					case '-2':
						$this->_ERROR_CODE = 22121;
						break;

					case '-3':
						$this->_ERROR_CODE = 22122;
						break;

					case '-4':
						$this->_ERROR_CODE = 22123;
						break;

					case '-5':
						$this->_ERROR_CODE = 22124;
						break;

					case '1':
						$this->_ERROR_CODE = 22126;
						break;

					case '2':
						$this->_ERROR_CODE = 22127;
						break;

					case '5':
						$this->_ERROR_CODE = 22128;
						break;

					case '6':
						$this->_ERROR_CODE = 22129;
						break;

					case '99':
						$this->_ERROR_CODE = 22130;
						break;
*/
					case '-1'://unauthenticate partner
						$this->_ERROR_CODE = 22135;
						break;

					case '-2'://invalid parameters
						$this->_ERROR_CODE = 22136;
						break;

					case '-3'://invalid date
						$this->_ERROR_CODE = 22137;
						break;

					case '-4'://no customer found
						$this->_ERROR_CODE = 22140;
						break;

					case '-5'://transfer unsuccessful
						$this->_ERROR_CODE = 22141;
						break;

					case '1'://invalid account
						$this->_ERROR_CODE = 22142;
						break;

					case '2'://invalid amount
						$this->_ERROR_CODE = 22143;
						break;
					case '3'://duplicate transfer
						$this->_ERROR_CODE = 22147;
						break;

					case '5'://not enough balance
						$this->_ERROR_CODE = 22144;
						break;

					case '6'://duplicate account
						$this->_ERROR_CODE = 22145;
						break;

					case '99'://unknown error
						$this->_ERROR_CODE = 22138;
						break;

					default:
						$this->_ERROR_CODE = $dab_rs;
				} //switch
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewInsertPaymentDetailWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function NewInsertPaymentDetailWithoutConfirmed($MortageID, $AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $Note) {
		$function_name = 'NewInsertPaymentDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageID) || !required($AccountNo) || !required($Symbol) || !required($Quantity) || !required($TradingDate)) {

			if ( !required($MortageID) )
				$this->_ERROR_CODE = 21140;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 21141;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 21142;

			if ( !required($Quantity) )
				$this->_ERROR_CODE = 21143;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 21144;

		} else {
			$query = sprintf( "CALL sp_Mortage_insertPaymentDetailWithoutConfirmed( %u, '%s', '%s', %u, '%s', '%s', '%s' )",
										$MortageID, $AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $Note);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21145;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21146;
							break;

						case '-2':
							$this->_ERROR_CODE = 21147;
							break;

						case '-3':
							$this->_ERROR_CODE = 21148;
							break;

						case '-4':
							$this->_ERROR_CODE = 21149;
							break;

						case '-5':
							$this->_ERROR_CODE = 21150;
							break;

						case '-7':
							$this->_ERROR_CODE = 21151;
							break;

						case '-8':
							$this->_ERROR_CODE = 21152;
							break;

						case '-10':
							$this->_ERROR_CODE = 21153;
							break;

					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewUpdatePaymentDetailWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function NewUpdatePaymentDetailWithoutConfirmed($PaymentDetailID, $Quantity, $UpdatedBy, $Note) {
		$function_name = 'NewUpdatePaymentDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($PaymentDetailID) || !required($Quantity)) {

			if ( !required($PaymentDetailID) )
				$this->_ERROR_CODE = 21155;

			if ( !required($Quantity) )
				$this->_ERROR_CODE = 21156;

		} else {
			$query = sprintf( "CALL sp_Mortage_updatePaymentDetailWithoutConfirmed( %u, %u, '%s', '%s' )",
										$PaymentDetailID, $Quantity, $UpdatedBy, $Note);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21157;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21158;
							break;

						case '-2':
							$this->_ERROR_CODE = 21159;
							break;

						case '-4':
							$this->_ERROR_CODE = 21160;
							break;

						case '-5':
							$this->_ERROR_CODE = 21161;
							break;

						case '-7':
							$this->_ERROR_CODE = 21162;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewDeletePaymentDetailWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function NewDeletePaymentDetailWithoutConfirmed($PaymentDetailID, $UpdatedBy) {
		$function_name = 'NewDeletePaymentDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($PaymentDetailID) || !unsigned($PaymentDetailID) ) {
				$this->_ERROR_CODE = 21165;

		} else {
			$query = sprintf( "CALL sp_Mortage_deletePaymentDetailWithoutConfirmed(%u, '%s')", $PaymentDetailID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 21166;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 21167;
							break;

						case '-2':
							$this->_ERROR_CODE = 21168;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewGetPaymentDetailList
		Description:
		Input:
		Output: ???
	*/
	function NewGetPaymentDetailList($AccountNo, $Symbol, $FromDate, $ToDate) {
		$function_name = 'NewGetPaymentDetailList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getPaymentDetailList( '%s', '%s', '%s', '%s' )", $AccountNo, $Symbol, $FromDate, $ToDate);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"MortageID"    => new SOAP_Value("MortageID", "string", $result[$i]['mortageid']),
						"AccountID"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
						"PaymentDate"    => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewConfirmPaymentDetail
		Description:
		Input:
		Output: success / error code
	*/
	function NewConfirmPaymentDetail($PaymentDetailID, $UpdatedBy) {
		$function_name = 'NewConfirmPaymentDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_confirmPaymentDetail(%u, '%s')", $PaymentDetailID, $UpdatedBy);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 21170;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 21171;
						break;

					case '-2':
						$this->_ERROR_CODE = 21172;
						break;

					case '-5':
						$this->_ERROR_CODE = 21173;
						break;

					case '-6':
						$this->_ERROR_CODE = 21174;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewGetPaymentDetailListWithCondition
		Description:
		Input:
		Output: ???
	*/
	function NewGetPaymentDetailListWithCondition($WhereClause, $TimeZone) {
		$function_name = 'NewGetPaymentDetailListWithCondition';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getPaymentDetailConditionList( \"%s\", \"%s\")", $WhereClause, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"MortageID"    => new SOAP_Value("MortageID", "string", $result[$i]['mortageid']),
						"AccountID"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
						"PaymentDate"    => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

}
?>
