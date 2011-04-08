<?php
/**
	Author: Diep Le Chi
	Created date: 09/03/2007
*/
require_once('../includes.php');

define("VIRTUAL_BANK_BANKCODE", "61");
define("WITHDRAW_AT_EPS", "M17.03");
define("WITHDRAW_AT_OTHERS", "M17.04");
define("PAY_AT_EPS", "M17.01");
define("PAY_AT_OTHERS", "M17.02");
define("EPS_BANKID", "15");
define("INTERNAL_TRANSFER", "M17.05");

define("VIRTUAL_BANK_LOG_FILE_PATH", "bank/virtual/function/");

class CBank extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor
	*/
	function CBank($check_ip) {
		//initialize _MDB2
		$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		//$this->_TIME_ZONE = get_timezon();
		$this->items = array();
		$this->class_name = get_class($this);

		$arr = array(
					'listBank' => array(
										'input' => array('TimeZone'),
										'output' => array( 'ID', 'BankName', 'ShortName', 'Phone','BankAddress', 'Fax', 'Email', 'MaximumLoanMoney', 'MinimumLoanMoney', 'MaximumPayMoney','MinimumPayMoney', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listBankWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array('ID', 'BankName', 'ShortName', 'Phone','BankAddress', 'Fax', 'Email', 'MaximumLoanMoney', 'MinimumLoanMoney', 'MaximumPayMoney','MinimumPayMoney', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'addBank' => array(
										'input' => array('BankName', 'ShortName', 'Phone', 'BankAddress', 'Fax', 'Email', 'MaximumLoanMoney', 'MinimumLoanMoney', 'MaximumPayMoney', 'MinimumPayMoney', 'CreatedBy'),
										'output' => array('ID')
										),
					'updateBank' => array(
										'input' => array('ID', 'BankName', 'ShortName', 'Phone', 'BankAddress', 'Fax', 'Email', 'MaximumLoanMoney', 'MinimumLoanMoney', 'MaximumPayMoney', 'MinimumPayMoney', 'UpdatedBy'),
										'output' => array()
										),
					'deleteBank' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'listBankLoan' => array(
										'input' => array('TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listBankLoanWithFilter' => array(
										'input' => array('Where', 'TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'addBankLoan' => array(
										'input' => array( 'BankID', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate', 'CreatedBy'),
										'output' => array('ID')
										),
					'updateBankLoan' => array(
										'input' => array( 'ID', 'BankID', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate', 'UpdatedBy'),
										'output' => array()
										),
					'deleteBankLoan' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'listRate' => array(
										'input' => array('TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listRateWithFilter' => array(
										'input' => array('Where', 'TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'addRate' => array(
										'input' => array( 'BankID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy'),
										'output' => array('ID')
										),
					'updateRate' => array(
										'input' => array( 'ID', 'BankID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'UpdatedBy'),
										'output' => array()
										),
					'deleteRate' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'listSpecialRate' => array(
										'input' => array('TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'StockID' , 'StockName', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listSpecialRateWithFilter' => array(
										'input' => array('Where', 'TimeZone'),
										'output' => array('ID', 'BankID', 'BankName', 'StockID' , 'StockName', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'addSpecialRate' => array(
										'input' => array( 'BankID', 'StockID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'CreatedBy'),
										'output' => array('ID')
										),
					'updateSpecialRate' => array(
										'input' => array( 'ID', 'BankID', 'StockID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'UpdatedBy'),
										'output' => array()
										),
					'deleteSpecialRate' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'getPercentRate' => array(
										'input' => array( 'BankID', 'StockID', 'MarketPrice' ),
										'output' => array( 'PercentRate', 'UseMarketPrice' )
										),
					'getTransactionTypeList' => array(
										'input' => array(),
										'output' => array( 'ID', 'Name', 'Type', 'Description' )
										),
					'getTransactionList' => array(
										'input' => array( 'TimeZone', 'WhereClause' ),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'InvestorName', 'Amount', 'IsConfirmed', 'TransactionStatus', 'TransTypeName', 'TransTypeID', 'BankID', 'BankName', 'TradingDate', 'CreatedBy', 'UpdatedBy', 'TransactionBankID', 'TransactionBankName', 'CreatedDate', 'UpdatedDate', 'Note', 'TransBankBravoCode' )
										),
					'getAccountBankInfo' => array(
										'input' => array( 'AccountID', 'BankID' ),
										'output' => array( 'AccountID', 'BankID', 'BankAccount', 'Amount', 'LockAmount', 'UsableAmount' )
										),
					'insertDeposit' => array(
										'input' => array( 'AccountID', 'BankID', 'TransactionBankID', 'Amount', 'DepositDate', 'Note', 'CreatedBy' ),
										'output' => array( 'ID' )
										),
					'deleteDeposit' => array(
										'input' => array( 'ID', 'UpdatedBy' ),
										'output' => array()
										),
					'cofirmDeposit' => array(
										'input' => array( 'ID', 'UpdatedBy', 'TransactionBankID', 'TransactionBankBravoCode', 'AccountNo', 'Amount', 'Note' ),
										'output' => array()
										),
					'insertWithdrawal' => array(
										'input' => array( 'AccountID', 'BankID', 'TransactionBankID', 'Amount', 'WithdrawalDate', 'Note', 'CreatedBy' ),
										'output' => array( 'ID' )
										),
					'deleteWithdrawal' => array(
										'input' => array( 'ID', 'UpdatedBy' ),
										'output' => array()
										),
					'cofirmWithdrawal' => array(
										'input' => array( 'ID', 'UpdatedBy', 'TransactionBankID', 'TransactionBankBravoCode', 'AccountNo', 'Amount', 'Note' ),
										'output' => array()
										),
					'getBankList' => array(
										'input' => array(),
										'output' => array( 'BankID', 'BankName', 'ShortName' )
										),
					'getVirtualBankOfAccount' => array(
										'input' => array('AccountNo'),
										'output' => array( 'AccountID', 'AccountNo', 'BankID', 'BankName', 'BankShortName' )
										),
					'getBankListForWD' => array(
										'input' => array(),
										'output' => array( 'BankID', 'BankName', 'ShortName' )
										),
					'getBankListByType' => array(
										'input' => array('Type'),
										'output' => array( 'BankID', 'BankName', 'ShortName' )
										),
					'getBankListByType4Account' => array(
										'input' => array('Type', 'AccountID '),
										'output' => array( 'BankID', 'BankAccount', 'BankName', 'ShortName' )
										),
					'insertInternalTransfer' => array(
										'input' => array( 'FromAccountID', 'ToAccountID', 'BankID', 'Amount', 'TransactionDate', 'Note', 'CreatedBy' ),
										'output' => array( 'ID' )
										),
					'deleteInternalTransfer' => array(
										'input' => array( 'ID', 'UpdatedBy' ),
										'output' => array()
										),
					'confirmInternalTransfer' => array(
										'input' => array( 'ID', 'UpdatedBy', 'FromAccountNo', 'ToAccountNo', 'Amount' ),
										'output' => array()
										),
					'getListInternalTransfer' => array(
										'input' => array('TimeZone', 'WhereClause'),
										'output' => array( 'ID', 'FromAccountID', 'FromAccountNo', 'FromInvestorName', 'ToAccountID', 'ToAccountNo', 'ToInvestorName', 'Amount', 'TransactionStatus', 'IsConfirmed', 'BankID', 'BankName', 'TradingDate', 'CreatedBy', 'UpdatedBy' )
										),
          'updateAllAdvRate' => array(
                    'input' => array('BankID', 'RateForBank', 'RateForEPS', 'MinAdvCommission'),
                    'output' => array('varError')
                    ),
          'listAllAdvRate' => array(
                    'input' => array('BankID'),
                    'output' => array('BankID', 'BankName', 'ShortName', 'RateForBank', 'RateForEPS', 'MinAdvCommission')
                    ),
          'ReportVirtualBank_ReportTransactionByAccount' => array(
                    'input' => array('BankID', 'AccountNo', 'FromDate', 'ToDate'),
                    'output' => array('TradingDate', 'TransName', 'Note', 'Amount', 'Type', 'TransactionBankName', 'ConfirmedDate', 'PrevBalance', 'CreatedBy', 'UpdatedBy', 'SortDate')
                    ),
          'ReportVirtualBank_GetAccountBalanceByDate' => array(
                    'input' => array('BankID', 'AccountNo', 'FromDate', 'ToDate'),
                    'output' => array('PrevBalance','NextBalance','AccountNo','InvestorName')
                    ),
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

	/* ----------------------------- Bank Function --------------------------------- */
   /**
	 * Function listBank	: get list of bank that bank is not deleted
	 * Input 				: timezone
	 * OutPut 				:
	 */
	function listBank($timezone) {
		$class_name = $this->class_name;
		$function_name = 'listBank';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getBanksList('%s')",$timezone);
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
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							'Phone'  => new SOAP_Value("Phone", "string", $result[$i]['phone']),
							'BankAddress'  => new SOAP_Value("BankAddress", "string", $result[$i]['bankaddress']),
							'Fax'  => new SOAP_Value("Fax", "string", $result[$i]['fax']),
							'Email'  => new SOAP_Value("Email", "string", $result[$i]['email']),
							'MaximumLoanMoney'  => new SOAP_Value("MaximumLoanMoney", "string", $result[$i]['maximumloanmoney']),
							'MinimumLoanMoney'  => new SOAP_Value("MinimumLoanMoney", "string", $result[$i]['minimumloanmoney']),
							'MaximumPayMoney'  => new SOAP_Value("MaximumPayMoney", "string", $result[$i]['maximumpaymoney']),
							'MinimumPayMoney'  => new SOAP_Value("MinimumPayMoney", "string", $result[$i]['minimumpaymoney']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listBankWithCondition	: get list of bank that bank is not deleted
	 * Input 							: String of condition in where clause and $timezone
	 * OutPut 							:
	 */
	function listBankWithFilter($condition, $timezone) {
		$class_name = $this->class_name;
		$function_name = 'listBankWithFilter';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( 'CALL sp_getConditionBanksList("%s","%s")', $timezone, $condition);
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
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							'Phone'  => new SOAP_Value("Phone", "string", $result[$i]['phone']),
							'BankAddress'  => new SOAP_Value("BankAddress", "string", $result[$i]['bankaddress']),
							'Fax'  => new SOAP_Value("Fax", "string", $result[$i]['fax']),
							'Email'  => new SOAP_Value("Email", "string", $result[$i]['email']),
							'MaximumLoanMoney'  => new SOAP_Value("MaximumLoanMoney", "string", $result[$i]['maximumloanmoney']),
							'MinimumLoanMoney'  => new SOAP_Value("MinimumLoanMoney", "string", $result[$i]['minimumloanmoney']),
							'MaximumPayMoney'  => new SOAP_Value("MaximumPayMoney", "string", $result[$i]['maximumpaymoney']),
							'MinimumPayMoney'  => new SOAP_Value("MinimumPayMoney", "string", $result[$i]['minimumpaymoney']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addBank	: insert new bank into database
	 * Input 			: 'BankName','ShortName','Phone','BankAddress','Fax','Phone','Email','MaximumLoanMoney','MinimumLoanMoney','MaximumPayMoney','MinimumPayMoney','CreatedBy'
	 * OutPut 			: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addBank($BankName,$ShortName,$Phone,$BankAddress,$Fax,$Email,$MaximumLoanMoney,$MinimumLoanMoney,$MaximumPayMoney,$MinimumPayMoney,$CreatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'addBank';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$fields_values = array(
									"BankName" 			=> $BankName,
									"ShortName" 		=> $ShortName,
									"Phone" 			=> $Phone,
									"BankAddress" 		=> $BankAddress,
									"Fax"				=> $Fax,
									"Email" 			=> $Email,
									"MaximumLoanMoney" 	=> $MaximumLoanMoney,
									"MinimumLoanMoney" 	=> $MinimumLoanMoney,
									"MaximumPayMoney" 	=> $MaximumPayMoney,
									"MinimumPayMoney" 	=> $MinimumPayMoney,
									"CreatedBy" 		=> $CreatedBy,
									"CreatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		$this->_ERROR_CODE = $this->checkBankValidate($fields_values);
		if($this->_ERROR_CODE == 0)
		{

				$query = sprintf( "CALL sp_insertBank ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $BankName, $ShortName, $BankAddress, $Fax, $Phone, $Email, $MaximumLoanMoney, $MinimumLoanMoney, $MaximumPayMoney, $MinimumPayMoney, $CreatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not insert
				if(empty($result))	$this->_ERROR_CODE = 13002;
				else{
					if(isset($result[0]['varerror']))
					{
						//Bank_Short_Name have been exist
						if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13014;
						//success
						if($result[0]['varerror'] >0)
						{
							$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
									)
							);
						}
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateBank	: update bank
	 * Input 				: 'ID','BankName','ShortName','Phone','BankAddress','Fax','Phone','Email','MaximumLoanMoney','MinimumLoanMoney','MaximumPayMoney','MinimumPayMoney','UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function updateBank($ID,$BankName,$ShortName,$Phone,$BankAddress,$Fax,$Email,$MaximumLoanMoney,$MinimumLoanMoney,$MaximumPayMoney,$MinimumPayMoney,$UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'updateBank';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankName" 			=> $BankName,
									"ShortName" 		=> $ShortName,
									"Phone" 			=> $Phone,
									"BankAddress" 		=> $BankAddress,
									"Fax"				=> $Fax,
									"Email" 			=> $Email,
									"MaximumLoanMoney" 	=> $MaximumLoanMoney,
									"MinimumLoanMoney" 	=> $MinimumLoanMoney,
									"MaximumPayMoney" 	=> $MaximumPayMoney,
									"MinimumPayMoney" 	=> $MinimumPayMoney,
									"UpdatedBy" 		=> $UpdatedBy,
									"UpdatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		if($ID==''||$ID<=0)
		{
			//Invalid Bank ID
			$this->_ERROR_CODE = 13001;
		} else
		{
			$this->_ERROR_CODE = $this->checkBankValidate($fields_values);
		}

		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_updateBank ('%u','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $ID, $BankName, $ShortName, $BankAddress, $Fax, $Phone, $Email, $MaximumLoanMoney, $MinimumLoanMoney, $MaximumPayMoney, $MinimumPayMoney, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);

			if(empty($result))	$this->_ERROR_CODE = 13003;
			else{
					if(isset($result[0]['varerror']))
					{
						//Invalid Bank ID
						if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13001;
						//Bank_Short_Name have been exist
						if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13014;
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function deleteBank	: delete a Bank
	 * Input 				: $ID , $UpdateBy
	 * OutPut 				: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteBank($ID,$UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'deleteBank';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if($ID==''||$ID<=0)
		{
			//Invalid Bank ID
			$this->_ERROR_CODE = 13001;
		}
		if($this->_ERROR_CODE == 0)
		{
			$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);

			$query = sprintf( "CALL sp_deleteBank ('%u','%s')", $ID, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not delete
			if(empty($result))	$this->_ERROR_CODE = 13004;
			else{
					if(isset($result[0]['varerror']))
					{
						//Invalid Bank ID
						if($result[0]['varerror'] <0) $this->_ERROR_CODE = 13001;
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkBankValidate	: check the validation of data input
	 * Input 					: array of data
	 * Output 					: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkBankValidate($data)
	{
		if(!required($data['BankName'])) return 13005;
		if(isset($data['Phone']) && (strlen($data['Phone'])>0) && !valid_phone($data['Phone'])) return 13009;
		if(isset($data['Email']) && (strlen($data['Email'])>0) && !valid_email($data['Email'])) return 13008;
		if(isset($data['Fax']) && (strlen($data['Fax'])>0) && !valid_phone($data['Fax'])) return 13010;
		if(isset($data['MaximumLoanMoney'])&&(strlen($data['MaximumLoanMoney'])>0)&&!numeric($data['MaximumLoanMoney'])) return 13015;
		if(isset($data['MinimumLoanMoney'])&&(strlen($data['RaMinimumLoanMoneyte'])>0)&&!numeric($data['MinimumLoanMoney'])) return 13016;
		if(isset($data['MaximumPayMoney'])&&(strlen($data['MaximumPayMoney'])>0)&&!numeric($data['MaximumPayMoney'])) return 13017;
		if(isset($data['MinimumPayMoney'])&&(strlen($data['MinimumPayMoney'])>0)&&!numeric($data['MinimumPayMoney'])) return 13018;
		if(isset($data['MaximumLoanMoney']) && isset($data['MinimumLoanMoney']) && ($data['MaximumLoanMoney']<$data['MinimumLoanMoney'])) return 13012;
		if(isset($data['MaximumPayMoney']) && isset($data['MinimumPayMoney']) && ($data['MaximumPayMoney']<$data['MinimumPayMoney'])) return 13013;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 13006;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 13007;
		return 0;
	}

	/**
	 * Function checkBankExist	: check the Bank name exist or not
	 * Input 					: array of data
	 * Output 					: if exist return _ERROR_CODE else return 0
	 */
	function checkBankExist($ID,$BankName,$ShortName)
	{
		$class_name = $this->class_name;
		$query = sprintf( "SELECT 0
							FROM %s
							WHERE ID!=%u AND BankName='%s' AND ShortName='%s'
							AND Deleted='0'", TBL_BANK, $ID, $BankName, $ShortName);
		//$query = sprintf( "CALL sp_check_bank_exist_function('%s')", $BankName);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) return 13011;
		return 0;
	}
	/* ----------------------------- End Bank Function --------------------------------- */


	/* ----------------------------- BankLoan Function --------------------------------- */
	/**
	 * Function listBankLoan	: get list of BankLoan
	 * Input 					: $timezone
	 * OutPut 					:
	 */
	function listBankLoan($timezone) {
		$class_name = $this->class_name;
		$function_name = 'listBankLoan';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getBankLoanList('%s')",$timezone);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'LoanPeriod'  => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
							'LoanInterestRate'  => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
							'OverdueInterestRate'  => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listBankLoanWithFilter	: get list of BankLoan
	 * Input 							: String of condition in where clause and $timezone
	 * OutPut 							: array
	 */
	function listBankLoanWithFilter($condition, $timezone) {
		$class_name = $this->class_name;
		$function_name = 'listBankLoanWithFilter';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( 'CALL sp_getConditionBankLoanList("%s","%s")',$timezone, $condition);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'LoanPeriod'  => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
							'LoanInterestRate'  => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
							'OverdueInterestRate'  => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addBankLoan	: insert new BankLoan into database
	 * Input 				:  'BankID', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate', 'CreatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addBankLoan($BankID, $LoanPeriod, $LoanInterestRate, $OverdueInterestRate, $CreatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'addBankLoan';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 				=> $BankID,
									"LoanPeriod" 			=> $LoanPeriod,
									"LoanInterestRate" 		=> $LoanInterestRate,
									"OverdueInterestRate"	=> $OverdueInterestRate,
									"CreatedBy" 			=> $CreatedBy,
									"CreatedDate" 			=> $this->_MDB2_WRITE->date->mdbnow()
									);
		$this->_ERROR_CODE = $this->checkBankLoanValidate($fields_values);
		if($this->_ERROR_CODE == 0)
		{

			$query = sprintf( "CALL sp_insertBankLoan ('%s','%s','%s','%s','%s')", $BankID, $LoanPeriod, $LoanInterestRate, $OverdueInterestRate, $CreatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			// Can not add
			if(empty($result))	$this->_ERROR_CODE = 13032;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Bank ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13037;
					//Bank_Loan have been exist
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13041;
					//Success
					if($result[0]['varerror'] >0)
					{
						$this->items[0] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
								)
						);
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateBankLoan: update BankLoan
	 * Input 				:  'ID','BankID', 'LoanPeriod', 'LoanInterestRate', 'OverdueInterestRate','UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function updateBankLoan($ID,$BankID, $LoanPeriod, $LoanInterestRate, $OverdueInterestRate, $UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'updateBankLoan';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 				=> $BankID,
									"LoanPeriod" 			=> $LoanPeriod,
									"LoanInterestRate" 		=> $LoanInterestRate,
									"OverdueInterestRate"	=> $OverdueInterestRate,
									"UpdatedBy" 			=> $UpdatedBy,
									"UpdatedDate" 			=> $this->_MDB2_WRITE->date->mdbnow()
									);
		if($ID==''||$ID<=0)
		{
			//Invalid Bank_Loan ID
			$this->_ERROR_CODE = 13031;
		} else
		{
			$this->_ERROR_CODE = $this->checkBankLoanValidate($fields_values);
		}

		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_updateBankLoan ('%s','%s','%s','%s','%s','%s')", $ID, $BankID, $LoanPeriod, $LoanInterestRate, $OverdueInterestRate, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not update
			if(empty($result))	$this->_ERROR_CODE = 13033;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Bank_Loan ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13031;
					//Invalid Bank ID
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13037;
					//Bank_Loan have been exist
					if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 13041;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function deleteBankLoan	: delete a BankLoan
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteBankLoan($ID,$UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'deleteBankLoan';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if($ID==''||$ID<=0)
		{
			//Invalid Bank_Loan ID
			$this->_ERROR_CODE = 13031;
		}
		if($this->_ERROR_CODE == 0)
		{
			$fields_values = array("Deleted" => "1",
									"UpdatedBy" => $UpdatedBy,
									"UpdatedDate" => $this->_MDB2_WRITE->date->mdbnow()
									);
			$query = sprintf( "CALL sp_deleteBankLoan ('%s','%s')", $ID, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not delete
			if(empty($result))	$this->_ERROR_CODE = 13034;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Bank_Loan ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13031;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkBankLoanValidate	: check the validation of data input
	 * Input 							: array of data
	 * Output 							: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkBankLoanValidate($data)
	{
		if(isset($data['BankID'])&&!unsigned($data['BankID'])) return 13037;
		if(isset($data['LoanPeriod'])&&(strlen($data['LoanPeriod'])>0)&& !numeric($data['LoanPeriod'])) return 13038;
		if(isset($data['LoanInterestRate'])&&(strlen($data['LoanInterestRate'])>0)&&!numeric($data['LoanInterestRate'])) return 13039;
		if(isset($data['OverdueInterestRate'])&&(strlen($data['OverdueInterestRate'])>0)&&!numeric($data['LoanInterestRate'])) return 13040;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 13035;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 13036;
		return 0;
	}

	/* ----------------------------- End BankLoan Function --------------------------------- */


	/* ----------------------------- Rate Function --------------------------------- */
	/**
	 * Function listRate	: get list of Rate
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listRate($timezone) {
		$class_name = $this->class_name;
		$function_name = 'listRate';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getRateList ('%s')", $timezone);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'FromValue'  => new SOAP_Value("FromValue", "string", $result[$i]['fromvalue']),
							'ToValue'  => new SOAP_Value("ToValue", "string", $result[$i]['tovalue']),
							'PercentRate'  => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							'UseMarketPrice'  => new SOAP_Value("UseMarketPrice", "string", $result[$i]['usemarketprice']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listRateWithFilter		: get list of Rate
	 * Input 							: String of condition in where clause and $timezone
	 * OutPut 							: array
	 */
	function listRateWithFilter($condition, $timezone) {
		$class_name = $this->class_name;
		$function_name = 'listRateWithFilter';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getConditionRateList ('%s', '%s')", $timezone, $condition);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'FromValue'  => new SOAP_Value("FromValue", "string", $result[$i]['fromvalue']),
							'ToValue'  => new SOAP_Value("ToValue", "string", $result[$i]['tovalue']),
							'PercentRate'  => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							'UseMarketPrice'  => new SOAP_Value("UseMarketPrice", "string", $result[$i]['usemarketprice']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addRate		: insert new Rate into database
	 * Input 				:  'BankID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice' , 'CreatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addRate($BankID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $CreatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'addRate';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 			=> $BankID,
									"FromValue" 		=> $FromValue,
									"ToValue" 			=> $ToValue,
									"PercentRate"		=> $PercentRate,
									"UseMarketPrice"	=> $UseMarketPrice,
									"CreatedBy" 		=> $CreatedBy,
									"CreatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		$this->_ERROR_CODE = $this->checkRateValidate($fields_values);
		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_insertRate ('%s','%s','%s','%s','%s','%s')", $BankID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $CreatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not add
			if(empty($result))	$this->_ERROR_CODE = 13047;
			else{
				if(isset($result[0]['varerror']))
				{
					//FromValue > To Value
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13057;
					//invalid Bank ID
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13050;
					//RAte have been exist
					if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 13058;
					//Invalid FormValue and Tovalue
					if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 13059;
					//Success
					if($result[0]['varerror'] >0)
					{
						$this->items[0] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
								)
						);
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateRate	: update Rate
	 * Input 				:  'ID','BankID', 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function updateRate($ID, $BankID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'updateRate';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 			=> $BankID,
									"FromValue" 		=> $FromValue,
									"ToValue" 			=> $ToValue,
									"PercentRate"		=> $PercentRate,
									"UseMarketPrice"	=> $UseMarketPrice,
									"UpdatedBy" 		=> $UpdatedBy,
									"UpdatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		if($ID==''||$ID<=0)
		{
			//Invalid Rate ID
			$this->_ERROR_CODE = 13046;
		} else
		{
			$this->_ERROR_CODE = $this->checkRateValidate($fields_values);
		}

		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_updateRate ('%u', '%s','%s','%s','%s','%s','%s')", $ID, $BankID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not update
			if(empty($result))	$this->_ERROR_CODE = 13048;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid FormValue and Tovalue
					if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 13059;
					//invalid Bank ID
					if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 13050;
					//Invalid Rate ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13046;
					//FromValue > To Value
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13057;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function deleteRate	: delete a BankLoan
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteRate($ID,$UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'deleteRate';
		if($ID==''||$ID<=0)
		{
			//Invalid Rate ID
			$this->_ERROR_CODE = 13046;
		}
		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_deleteRate ('%u', '%s')", $ID, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not delete
			if(empty($result))	$this->_ERROR_CODE = 13049;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Rate ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13046;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkRateValidate	: check the validation of data input
	 * Input 						: array of data
	 * Output 						: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkRateValidate($data)
	{
		if(isset($data['BankID'])&&!unsigned($data['BankID'])) return 13050;
		if(isset($data['FromValue'])&&(strlen($data['FromValue'])>0)&&!numeric($data['FromValue'])) return 13051;
		if(isset($data['ToValue'])&&(strlen($data['ToValue'])>0)&&!numeric($data['ToValue'])) return 13052;
		if(isset($data['FromValue']) && (isset($data['ToValue'])) && ($data['FromValue']>$data['ToValue'])) return 13057;
		if(isset($data['PercentRate'])&&(strlen($data['PercentRate'])>0)&&!numeric($data['PercentRate'])) return 13053;
		if(isset($data['UseMarketPrice'])&&(strlen($data['UseMarketPrice'])>0)&&(!numeric($data['UseMarketPrice']) || (!in_array($data['UseMarketPrice'],array(0,1))))) return 13054;
		//if(isset($data['PercentRate'])&&isset($data['UseMarketPrice'])&&($data['PercentRate']>0)&&($data['UseMarketPrice']==1)) return 13059;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 13055;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 13056;
		return 0;
	}
	/* ----------------------------- End Rate Function --------------------------------- */


	/* ----------------------------- Special Rate Function --------------------------------- */
	/**
	 * Function listSpecialRate	: get list of Special Rate
	 * Input 					: $timezone
	 * OutPut 					: array
	 */
	function listSpecialRate($timezone) {
		$class_name = $this->class_name;
		$function_name = 'listSpecialRate';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getSpecialRateList('%s')", $timezone);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							'StockName'  => new SOAP_Value("StockName", "string", $result[$i]['symbol']),
							'FromValue'  => new SOAP_Value("FromValue", "string", $result[$i]['fromvalue']),
							'ToValue'  => new SOAP_Value("ToValue", "string", $result[$i]['tovalue']),
							'PercentRate'  => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							'UseMarketPrice'  => new SOAP_Value("UseMarketPrice", "string", $result[$i]['usemarketprice']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listSpecialRateWithFilter	: get list of Special Rate
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listSpecialRateWithFilter($condition, $timezone) {
		$class_name = $this->class_name;
		$function_name = 'listSpecialRateWithFilter';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getConditionSpecialRateList('%s', '%s')", $timezone, $condition);
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
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							'StockName'  => new SOAP_Value("StockName", "string", $result[$i]['symbol']),
							'FromValue'  => new SOAP_Value("FromValue", "string", $result[$i]['fromvalue']),
							'ToValue'  => new SOAP_Value("ToValue", "string", $result[$i]['tovalue']),
							'PercentRate'  => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							'UseMarketPrice'  => new SOAP_Value("UseMarketPrice", "string", $result[$i]['usemarketprice']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addSpecialRate	: insert new Special Rate into database
	 * Input 					:  'BankID', $StockID, 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice' , 'CreatedBy'
	 * OutPut 					: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addSpecialRate($BankID, $StockID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $CreatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'addSpecialRate';
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 			=> $BankID,
									"StockID" 			=> $StockID,
									"FromValue" 		=> $FromValue,
									"ToValue" 			=> $ToValue,
									"PercentRate"		=> $PercentRate,
									"UseMarketPrice"	=> $UseMarketPrice,
									"CreatedBy" 		=> $CreatedBy,
									"CreatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		$this->_ERROR_CODE = $this->checkSpecialRateValidate($fields_values);
		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_insertSpecialRate ('%s','%s','%s','%s','%s','%s','%s')", $BankID, $StockID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $CreatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not insert
			if(empty($result))	$this->_ERROR_CODE = 13062;
			else{
				if(isset($result[0]['varerror']))
				{
					//FromValue>ToValue
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13073;
					//Invalid BankID
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13065;
					//Invalid StockID
					if($result[0]['varerror'] == -5) $this->_ERROR_CODE = 13072;
					//Special Rate have been exist
					if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 13074;
					//Invalid FormValue and Tovalue
					if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 13075;
					//success
					if($result[0]['varerror'] >0)
					{
						$this->items[0] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
								)
						);
					}
				}
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateSpecialRate	: update Special Rate
	 * Input 					:  'ID','BankID', $StockID, 'FromValue', 'ToValue', 'PercentRate', 'UseMarketPrice', 'UpdatedBy'
	 * OutPut 					: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function updateSpecialRate($ID, $BankID, $StockID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'updateSpecialRate';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$fields_values = array(
									"BankID" 			=> $BankID,
									"StockID" 			=> $StockID,
									"FromValue" 		=> $FromValue,
									"ToValue" 			=> $ToValue,
									"PercentRate"		=> $PercentRate,
									"UseMarketPrice"	=> $UseMarketPrice,
									"UpdatedBy" 		=> $UpdatedBy,
									"UpdatedDate" 		=> $this->_MDB2_WRITE->date->mdbnow()
									);
		if($ID==''||$ID<=0)
		{
			//Invalid Special Rate ID
			$this->_ERROR_CODE = 13061;
		} else
		{
			$this->_ERROR_CODE = $this->checkSpecialRateValidate($fields_values);
		}

		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_updateSpecialRate ('%u','%s','%s','%s','%s','%s','%s','%s')", $ID, $BankID, $StockID, $FromValue, $ToValue, $PercentRate, $UseMarketPrice, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			//Can not update
			if(empty($result))	$this->_ERROR_CODE = 13063;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Special Rate ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13061;
					//Invalid BankID
					if($result[0]['varerror'] == -3) $this->_ERROR_CODE = 13065;
					//Invalid StockID
					if($result[0]['varerror'] == -4) $this->_ERROR_CODE = 13072;
					//FromValue>ToValue
					if($result[0]['varerror'] == -2) $this->_ERROR_CODE = 13074;
					//Special Rate have been exist
					if($result[0]['varerror'] == -5) $this->_ERROR_CODE = 13074;
					//Invalid FormValue and Tovalue
					if($result[0]['varerror'] == -6) $this->_ERROR_CODE = 13075;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function deleteSpecialRate	: delete a Special Rate
	 * Input 						: $ID , $UpdateBy
	 * OutPut 						: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteSpecialRate($ID,$UpdatedBy)
	{
		$class_name = $this->class_name;
		$function_name = 'deleteSpecialRate';
		if($ID==''||$ID<=0)
		{
			//Invalid Special Rate ID
			$this->_ERROR_CODE = 13061;
		}
		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL sp_deleteSpecialRate ('%u','%s')", $ID, $UpdatedBy);
			$result = $this->_MDB2_WRITE->extended->getAll($query);

			if(empty($result))	$this->_ERROR_CODE = 13064;
			else{
				if(isset($result[0]['varerror']))
				{
					//Invalid Special Rate ID
					if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 13061;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkSpecialRateValidate	: check the validation of data input
	 * Input 						: array of data
	 * Output 						: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkSpecialRateValidate($data)
	{
		if(isset($data['BankID'])&&!unsigned($data['BankID'])) return 13065;
		if(isset($data['StockID'])&&!unsigned($data['StockID'])) return 13072;
		if(isset($data['FromValue'])&&(strlen($data['FromValue'])>0)&&!numeric($data['FromValue'])) return 13066;
		if(isset($data['ToValue'])&&(strlen($data['ToValue'])>0)&&!numeric($data['ToValue'])) return 13067;
		if(isset($data['FromValue']) && (isset($data['ToValue'])) && ($data['FromValue']>$data['ToValue'])) return 13073;
		if(isset($data['PercentRate'])&&(strlen($data['PercentRate'])>0)&&!numeric($data['PercentRate'])) return 13068;
		if(isset($data['UseMarketPrice'])&&(strlen($data['UseMarketPrice'])>0)&&!numeric($data['UseMarketPrice'])) return 13069;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 13070;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 13071;
		return 0;
	}
	/* ----------------------------- End Special Rate Function --------------------------------- */

	/**
		Function: getPercentRate
		Description: update Stock & Money Balance
		Input: $BankID, $StockID, $MarketPrice
		Output: success / error code
	*/
	function getPercentRate($BankID, $StockID, $MarketPrice) {
		$function_name = 'getPercentRate';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($BankID) || !unsigned($BankID) || !required($StockID) || !unsigned($StockID)
				|| !required($MarketPrice) || !unsigned($MarketPrice) ) {
			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 13080;

			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 13081;

			if ( !required($MarketPrice) || !unsigned($MarketPrice) )
				$this->_ERROR_CODE = 13082;

		} else {
			$query = sprintf( "SELECT ID, PercentRate, UseMarketPrice
									FROM %s
									WHERE Deleted='0'
									AND BankID=%u
									AND StockID=%u
									AND FromValue <= %u
									AND ToValue >= %u ", TBL_SPECIAL_RATE, $BankID, $StockID, $MarketPrice, $MarketPrice);
			$result = $this->_MDB2->extended->getRow($query);

			if ( empty($result['id']) || $result['id'] <= 0) {
				$query = sprintf( "SELECT ID, PercentRate, UseMarketPrice
										FROM %s
										WHERE Deleted='0'
										AND BankID=%u
										AND FromValue <= %u
										AND ToValue >= %u ", TBL_RATE, $BankID, $MarketPrice, $MarketPrice);
				$result = $this->_MDB2->extended->getRow($query);
			}

			if ( !empty($result['id']) && $result['id'] > 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"PercentRate"    => new SOAP_Value("PercentRate", "string", $result['percentrate']),
							"UseMarketPrice"    => new SOAP_Value("UseMarketPrice", "string", $result['usemarketprice'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getTransactionTypeList() {
		$class_name = $this->class_name;
		$function_name = 'getTransactionTypeList';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getTransactionTypeList()");
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
							'Name'  => new SOAP_Value("Name", "string", $result[$i]['name']),
							'Type'  => new SOAP_Value("Type", "string", $result[$i]['type']),
							'Description'  => new SOAP_Value("Description", "string", $result[$i]['description']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getTransactionList($TimeZone, $WhereClause) {
		$class_name = $this->class_name;
		$function_name = 'getTransactionList';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getTransactionList(\"%s\", \"%s\")", $TimeZone, $WhereClause);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
							'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
							'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
							'TransactionStatus'  => new SOAP_Value("TransactionStatus", "string", $result[$i]['transactionstatus']),
							'TransTypeName'  => new SOAP_Value("TransTypeName", "string", $result[$i]['transtypename']),
							'TransTypeID'  => new SOAP_Value("TransTypeID", "string", $result[$i]['transtypeid']),
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate'] ),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							'TransactionBankID'  => new SOAP_Value("TransactionBankID", "string", $result[$i]['transactionbankid']),
							'TransactionBankName'  => new SOAP_Value("TransactionBankName", "string", $result[$i]['transactionbankname']),
							'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
							'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
              'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
              'TransBankBravoCode'  => new SOAP_Value("TransBankBravoCode", "string", $result[$i]['transbankbravocode']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getBankList() {
		$class_name = $this->class_name;
		$function_name = 'getBankList';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_getBankList()");
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getBankListForWD() {
		$class_name = $this->class_name;
		$function_name = 'getBankListForWD';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_getBankList4WD()");
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getBankListByType($Type) {
		$class_name = $this->class_name;
		$function_name = 'getBankListByType';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getBankListByType('%s')", $Type);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getBankListByType4Account($Type, $AccountID) {
		$class_name = $this->class_name;
		$function_name = 'getBankListByType4Account';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getBankListByType4Account('%s', %u)", $Type, $AccountID);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
							'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getAccountBankInfo($AccountID, $BankID) {
		$class_name = $this->class_name;
		$function_name = 'getAccountBankInfo';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL  sp_getAccountBankInfo('%s', '%s')", $AccountID, $BankID);
		$result = $this->_MDB2->extended->getRow($query);
		$num_row = count($result);
		if($num_row>0) {
			switch ($result['bankid']) {
				case DAB_ID:
					$dab = &new CDAB();
					$usable = $dab->getAvailBalance($rs['bankaccount'], $AccountNo);
					break;

				case VCB_ID:
					$vcb = &new CVCB();
					$usable = $vcb->getAvailBalance( $AccountNo);
					break;

				case NVB_ID:
					$nvb = &new CNVB();
					$usable = $nvb->getAvailBalance(time(), $rs['bankaccount']);
					break;

				default:
					$usable = $result['usableamount'];
			}

			$this->items[$i] = new SOAP_Value(
					'items',
					'{urn:'. $class_name .'}'.$function_name.'Struct',
					array(
						'AccountID'  => new SOAP_Value("AccountID", "string", $result['accountid']),
						'BankID'  => new SOAP_Value("BankID", "string", $result['bankid']),
						'BankAccount'  => new SOAP_Value("BankAccount", "string", $result['bankaccount']),
						'Amount'  => new SOAP_Value("Amount", "string", $result['amount']),
						'LockAmount'  => new SOAP_Value("LockAmount", "string", $result['lockamount']),
						'UsableAmount'  => new SOAP_Value("UsableAmount", "string", $usable ),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertDeposit($AccountID, $BankID, $TransactionBankID, $Amount, $DepositDate, $Note, $CreatedBy) {
		$function_name = 'insertDeposit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID) || !required($BankID) || !unsigned($BankID) || !required($Amount) || !unsigned($Amount) || !required($DepositDate) ) {
			if ( !required($AccountID) || !unsigned($AccountID) )
				$this->_ERROR_CODE = 13090;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 13091;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 13092;

			if ( !required($DepositDate) )
				$this->_ERROR_CODE = 13093;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_insertDeposit(%u, %u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $TransactionBankID, $Amount, $DepositDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13094;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13095;
							break;

						case '-2':
							$this->_ERROR_CODE = 13096;
							break;

						case '-3':
							$this->_ERROR_CODE = 13097;
							break;

						case '-9':
							$this->_ERROR_CODE = 13098;
							break;

						case '-10':
							$this->_ERROR_CODE = 13141;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result)
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteDeposit($ID, $UpdatedBy) {
		$function_name = 'deleteDeposit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) ) {
			$this->_ERROR_CODE = 13100;

		} else {
			$query = sprintf( "CALL  sp_VirtualBank_deleteDeposit(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13101;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13102;
							break;

						case '-2':
							$this->_ERROR_CODE = 13103;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function cofirmDeposit($ID, $UpdatedBy, $TransactionBankID, $TransactionBankBravoCode, $AccountNo, $Amount, $Note="") {
		$function_name = 'cofirmDeposit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) ) {
			$this->_ERROR_CODE = 13105;

		} else {
			$query = sprintf( "CALL  sp_VirtualBank_confirmDeposit(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13106;
			} else {
				$result = $rs['varerror'];
        $content = date("d/m/Y H:i:s") ." Nop: ID => $ID, AccountNo => $AccountNo, Amount => $Amount, TransactionBankID => $TransactionBankID, TransactionBankBravoCode => $TransactionBankBravoCode, UpdatedBy => $UpdatedBy --> $result" ;
				write_log($function_name, $content, VIRTUAL_BANK_LOG_FILE_PATH) ;

				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13107;
							break;

						case '-2':
							$this->_ERROR_CODE = 13108;
							break;

						case '-3':
							$this->_ERROR_CODE = 13109;
							break;

						case '-4':
							$this->_ERROR_CODE = 13110;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}//switch
				} else {//if
					$bravo_service = &new Bravo();
					$date = date("Y-m-d");

					if ($TransactionBankID == EPS_BANKID) {
						$arrDeposit = array("TradingDate" => $date,
											"TransactionType"=> PAY_AT_EPS,
											"AccountNo" => $AccountNo,
											"Amount" => $Amount,
											"Fee" => 0,
                      "Bank"=> $TransactionBankBravoCode,
											"Note" => $Note);
					} else {
						$arrDeposit = array("TradingDate" => $date,
											"TransactionType"=> PAY_AT_OTHERS,
											"AccountNo" => $AccountNo,
											"Amount" => $Amount,
											"Fee" => 0,
                      "Bank"=> $TransactionBankBravoCode,
											"Note" => $Note);
					}
					$bravo_result = $bravo_service->deposit($arrDeposit );

					if ($bravo_result['table0']['Result'] !=1) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 23003;
								break;

							case '-2':
								$this->_ERROR_CODE = 23002;
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
						}
					}
				}//else
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertWithdrawal($AccountID, $BankID, $TransactionBankID, $Amount, $WithdrawalDate, $Note, $CreatedBy) {
		$function_name = 'insertWithdrawal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID) || !required($BankID) || !unsigned($BankID) || !required($Amount) || !unsigned($Amount) || !required($WithdrawalDate) ) {
			if ( !required($AccountID) || !unsigned($AccountID) )
				$this->_ERROR_CODE = 13120;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 13121;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 13122;

			if ( !required($WithdrawalDate) )
				$this->_ERROR_CODE = 13123;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_insertWithdrawal(%u, %u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $TransactionBankID, $Amount, $WithdrawalDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13124;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13125;
							break;

						case '-2':
							$this->_ERROR_CODE = 13126;
							break;

						case '-3':
							$this->_ERROR_CODE = 13127;
							break;

						case '-4':
							$this->_ERROR_CODE = 13128;
							break;

						case '-9':
							$this->_ERROR_CODE = 13129;
							break;

						case '-10':
							$this->_ERROR_CODE = 13140;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result)
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteWithdrawal($ID, $UpdatedBy) {
		$function_name = 'deleteWithdrawal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) ) {
			$this->_ERROR_CODE = 13115;

		} else {
			$query = sprintf( "CALL  sp_VirtualBank_deleteWithdrawal(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13116;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13117;
							break;

						case '-2':
							$this->_ERROR_CODE = 13118;
							break;

						case '-3':
							$this->_ERROR_CODE = 13119;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}//swtich
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function cofirmWithdrawal($ID, $UpdatedBy, $TransactionBankID, $TransactionBankBravoCode, $AccountNo, $Amount, $Note="") {
		$function_name = 'cofirmWithdrawal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) ) {
			$this->_ERROR_CODE = 13130;

		} else {
			$query = sprintf( "CALL  sp_VirtualBank_confirmWithdrawal(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13131;
			} else {
				$result = $rs['varerror'];

        $content = date("d/m/Y H:i:s") ." Rut: ID => $ID, AccountNo => $AccountNo, Amount => $Amount, TransactionBankID => $TransactionBankID, TransactionBankBravoCode => $TransactionBankBravoCode, UpdatedBy => $UpdatedBy --> $result" ;
				write_log($function_name, $content, VIRTUAL_BANK_LOG_FILE_PATH) ;

				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13132;
							break;

						case '-2':
							$this->_ERROR_CODE = 13133;
							break;

						case '-3':
							$this->_ERROR_CODE = 13134;
							break;

						case '-4':
							$this->_ERROR_CODE = 13135;
							break;

						case '-5':
							$this->_ERROR_CODE = 13136;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} //switch
				} else {//if
					$soap = &new Bravo();
					if ($TransactionBankID == EPS_BANKID) {
						$withdrawValue = array( "TradingDate" => date("Y-m-d"),
												'TransactionType'=> WITHDRAW_AT_EPS,
												"AccountNo" => $AccountNo,
												"Amount" => $Amount,
												"Fee" => 0,
                        "Bank"=> $TransactionBankBravoCode,
                        "Note"=> $Note);
					} else {
						$withdrawValue = array( "TradingDate" => date("Y-m-d"),
												'TransactionType'=> WITHDRAW_AT_OTHERS,
												"AccountNo" => $AccountNo,
												"Amount" => $Amount,
												"Fee" => 0,
                        "Bank"=> $TransactionBankBravoCode,
                        "Note"=> $Note);
					}
					$ret = $soap->withdraw($withdrawValue);

					if($ret['table0']['Result'] != 1){ // success
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
				}
			}//if WS
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getVirtualBankOfAccount($AccountNo) {
		$class_name = $this->class_name;
		$function_name = 'getVirtualBankOfAccount';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_getAccount_VirtualBank('%s')", $AccountNo);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'BankShortName'  => new SOAP_Value("BankShortName", "string", $result[$i]['bankshortname']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertInternalTransfer($FromAccountID, $ToAccountID, $BankID, $Amount, $TransactionDate, $Note, $CreatedBy) {
		$function_name = 'insertInternalTransfer';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($FromAccountID) || !unsigned($FromAccountID) || !required($ToAccountID) || !unsigned($ToAccountID) || !required($BankID) || !unsigned($BankID) || !required($Amount) || !unsigned($Amount) || !required($TransactionDate) ) {
			if ( !required($FromAccountID) || !unsigned($FromAccountID) )
				$this->_ERROR_CODE = 13150;

			if ( !required($ToAccountID) || !unsigned($ToAccountID) )
				$this->_ERROR_CODE = 13151;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 13152;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 13153;

			if ( !required($TransactionDate) )
				$this->_ERROR_CODE = 13154;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_insertInternalTransfer(%u, %u, %u, %f, '%s', '%s', '%s' )", $FromAccountID, $ToAccountID, $BankID, $Amount, $TransactionDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13155;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13156;
							break;

						case '-2':
							$this->_ERROR_CODE = 13157;
							break;

						case '-4':
							$this->_ERROR_CODE = 13158;
							break;

						case '-9':
							$this->_ERROR_CODE = 13159;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result)
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteInternalTransfer($ID, $UpdatedBy) {
		$function_name = 'deleteInternalTransfer';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) ) {
			$this->_ERROR_CODE = 13165;

		} else {
			$query = sprintf( "CALL   sp_VirtualBank_deleteInternalTransfer(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13166;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13167;
							break;

						case '-2':
							$this->_ERROR_CODE = 13168;
							break;

						case '-3':
							$this->_ERROR_CODE = 13169;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}//swtich
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function confirmInternalTransfer($ID, $UpdatedBy, $FromAccountNo, $ToAccountNo, $Amount) {
		$function_name = 'confirmInternalTransfer';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($FromAccountNo) || !required($ToAccountNo) || !required($Amount) || !unsigned($Amount) ) {
			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 13175;

			if ( !required($FromAccountNo) )
				$this->_ERROR_CODE = 13176;

			if ( !required($ToAccountNo) )
				$this->_ERROR_CODE = 13177;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 13178;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_confirmInternalTransfer(%u, '%s' )", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 13179;
			} else {
				$result = $rs['varerror'];

				$content = date("d/m/Y H:i:s") ."	Chuyen khoan: ID => $ID, FromAccountNo => $FromAccountNo, ToAccountNo => $ToAccountNo, Amount => $Amount, UpdatedBy => $UpdatedBy --> $result" ;
				write_log($function, $content, VIRTUAL_BANK_LOG_FILE_PATH) ;

				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 13180;
							break;

						case '-2':
							$this->_ERROR_CODE = 13181;
							break;

						case '-3':
							$this->_ERROR_CODE = 13182;
							break;

						case '-4':
							$this->_ERROR_CODE = 13183;
							break;

						case '-5':
							$this->_ERROR_CODE = 13184;
							break;

						case '-6':
							$this->_ERROR_CODE = 13185;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} //switch
				} else {//if
					$soap = &new Bravo();
					$date = date("Y-m-d");
					$withdrawValue = array( "TradingDate" => $date,
											'TransactionType'=> INTERNAL_TRANSFER,
											"AccountNo" => $FromAccountNo,
											"Amount" => $Amount,
											"Fee" => 0,
											"Bank"=> VIRTUAL_BANK_BANKCODE,
											"Note" => "Chuyen khoan");
					$ret = $soap->withdraw($withdrawValue);

					if($ret['table0']['Result'] != 1){ // success
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
					} else {
						$arrDeposit = array("TradingDate" => $date,
											"TransactionType"=> INTERNAL_TRANSFER,
											"AccountNo" => $ToAccountNo,
											"Amount" => $Amount,
											"Fee" => 0,
											"Bank"=> VIRTUAL_BANK_BANKCODE,
											"Note" => "Chuyen khoan");
						$bravo_result = $bravo_service->deposit($arrDeposit );
						if ($bravo_result['table0']['Result'] !=1) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 23003;
									break;

								case '-2':
									$this->_ERROR_CODE = 23002;
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
							}//switch
						}//if
					}//else
				}
			}//if WS
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getListInternalTransfer($TimeZone, $WhereClause) {
		$class_name = $this->class_name;
		$function_name = 'getListInternalTransfer';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_InternalTransfer_getList(\"%s\", \"%s\")", $TimeZone, $WhereClause);
		$result = $this->_MDB2->extended->getAll($query);
		$num_row = count($result);
		if($num_row>0) {
			for($i=0; $i<$num_row; $i++) {
				$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
							'FromAccountID'  => new SOAP_Value("FromAccountID", "string", $result[$i]['fromaccountid']),
							'FromAccountNo'  => new SOAP_Value("FromAccountNo", "string", $result[$i]['fromaccountno']),
							'FromInvestorName'  => new SOAP_Value("FromInvestorName", "string", $result[$i]['frominvestorname']),
							'ToAccountID'  => new SOAP_Value("ToAccountID", "string", $result[$i]['toaccountid']),
							'ToAccountNo'  => new SOAP_Value("ToAccountNo", "string", $result[$i]['toaccountno']),
							'ToInvestorName'  => new SOAP_Value("ToInvestorName", "string", $result[$i]['toinvestorname']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
							'TransactionStatus'  => new SOAP_Value("TransactionStatus", "string", $result[$i]['transactionstatus']),
							'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
							'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
							'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
							'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
							'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
							'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

  function updateAllAdvRate($BankID, $RateForBank, $RateForEPS, $MinAdvCommission)
  {
    $function_name = 'updateAllAdvRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_bank_updateAllAdvRate('%s', '%s', '%s', '%s')", $BankID, $RateForBank, $RateForEPS, $MinAdvCommission );
    $rs = $this->_MDB2_WRITE->extended->getRow($query);
    $result = $rs['varerror'];

    $this->items[0] = new SOAP_Value(
              'item',
              $struct,
              array(
                "varError"    => new SOAP_Value( "varError", "string", $result)
                )
            );

    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function listAllAdvRate($BankID='')
  {
  	$function_name = 'listAllAdvRate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_bank_listAllAdvRate('%s')", $BankID);
    $result = $this->_MDB2->extended->getAll($query);
    $num_row = count($result);
    if($num_row>0) {
      for($i=0; $i<$num_row; $i++) {
        $this->items[$i] = new SOAP_Value(
            'items',
            '{urn:'. $this->class_name .'}'.$function_name.'Struct',
            array(
              'BankID'            => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
              'BankName'          => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
              'ShortName'         => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
              'RateForBank'       => new SOAP_Value("RateForBank", "string", $result[$i]['rateforbank']),
              'RateForEPS'        => new SOAP_Value("RateForEPS", "string", $result[$i]['rateforeps']),
              'MinAdvCommission'  => new SOAP_Value("MinAdvCommission", "string", $result[$i]['minadvcommission']),
              )
          );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function ReportVirtualBank_ReportTransactionByAccount($BankID, $AccountNo, $FromDate, $ToDate)
  {
    $function_name = 'ReportVirtualBank_ReportTransactionByAccount';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_VirtualBank_ReportTransactionByAccount('%s','%s','%s','%s')", $BankID, $AccountNo, $FromDate, $ToDate);
    $result = $this->_MDB2->extended->getAll($query);
    $num_row = count($result);
    if($num_row>0) {
      for($i=0; $i<$num_row; $i++) {
        $this->items[$i] = new SOAP_Value(
            'items',
            '{urn:'. $this->class_name .'}'.$function_name.'Struct',
            array(
              'TradingDate'          => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
              'TransName'            => new SOAP_Value("TransName", "string", $result[$i]['transname']),
              'Note'                 => new SOAP_Value("Note", "string", $result[$i]['note']),
              'Amount'               => new SOAP_Value("Amount", "string", $result[$i]['amount']),
              'Type'                 => new SOAP_Value("Type", "string", $result[$i]['type']),
              'TransactionBankName'  => new SOAP_Value("TransactionBankName", "string", $result[$i]['transactionbankname']),
              'ConfirmedDate'        => new SOAP_Value("ConfirmedDate", "string", $result[$i]['confirmeddate']),
              'PrevBalance'          => new SOAP_Value("PrevBalance", "string", $result[$i]['prevbalance']),
              'CreatedBy'            => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
              'UpdatedBy'            => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
              'SortDate'             => new SOAP_Value("SortDate", "string", $result[$i]['sortdate']),
              )
          );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function ReportVirtualBank_GetAccountBalanceByDate($BankID, $AccountNo, $FromDate, $ToDate)
  {
    $function_name = 'ReportVirtualBank_GetAccountBalanceByDate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_VirtualBank_getAccountBalanceByDate('%s','%s','%s','%s')", $BankID, $AccountNo, $FromDate, $ToDate);
    $result = $this->_MDB2->extended->getAll($query);
    $num_row = count($result);

    if($num_row>0) {
      for($i=0; $i<$num_row; $i++) {
        $this->items[$i] = new SOAP_Value(
            'items',
            '{urn:'. $this->class_name .'}'.$function_name.'Struct',
            array(
              'PrevBalance'          => new SOAP_Value("PrevBalance", "string", $result[$i]['prevbalance']),
              'NextBalance'          => new SOAP_Value("NextBalance", "string", $result[$i]['nextbalance']),
              'AccountNo'            => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
              'InvestorName'         => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
              )
          );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

}


?>