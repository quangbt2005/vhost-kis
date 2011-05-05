<?php
/**
	Author: Diep Le Chi
	Created date: 19/03/2007
*/
require_once('../includes.php');

define("TBL_ASSIGNLAW", "`assign`");
define("TBL_ASSIGNLAW1", "`assignlaw`");

class CTradingRegister extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor
	*/

	function CTradingRegister($check_ip) {
		//initialize _MDB2
		$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		//$this->_TIME_ZONE = get_timezon();
		$this->items = array();

		$this->class_name = get_class($this);
		$arr = array(
					'listTradingRegisterWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'InvestorName', 'StockID', 'Symbol','Quantity', 'StockStatusID', 'StockStatusName', 'RegisterDate', 'Note', 'StockRegisterType', 'IsConfirmed', 'MobilePhone', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'StockExchangeID' )
										),
					'listAccountStock' => array(
										'input' => array( 'AccountNo', 'StockID'),
										'output' => array( 'InvestorName', 'InvestorCardNo','QuantityOfNormalStock', 'QuantityOfBlockedStock', 'QuantityOfNormalStockNotConfirm', 'QuantityOfBlockedStockNotConfirm')
										),
					'listAccountStockW' => array(
										'input' => array( 'AccountNo', 'StockID'),
										'output' => array( 'InvestorName', 'InvestorCardNo','QuantityOfNormalStock', 'QuantityOfBlockedStock', 'QuantityOfNormalStockNotConfirmW', 'QuantityOfBlockedStockNotConfirmW')
										),
					'addTradingRegister' => array(
										'input' => array( 'AccountNo', 'StockID', 'Quantity', 'StockStatusID', 'RegisterDate', 'Note', 'StockRegisterType', 'CreatedBy', 'RegPrice'),
										'output' => array('ID')
										),
					'updateTradingRegister' => array(
										'input' => array('ID', 'AccountNo', 'StockID', 'Quantity', 'Note', 'StockRegisterType', 'UpdatedBy'),
										'output' => array()
										),
					'approveTradingRegister' => array(
										'input' => array('ID', 'StockRegisterType', 'StockTradingType', 'UpdatedBy', 'MobilePhone', 'AccountNo', 'StockSymbol', 'Quantity'),
										'output' => array()
										),
					'deleteTradingRegister' => array(
										'input' => array('ID', 'StockRegisterType', 'UpdatedBy'),
										'output' => array()
										),
					'getStockQuantity' => array(
										'input' => array('AccountNo', 'StockID'),
										'output' => array('QuantityOfNormalStock', 'QuantityOfMortageStock', 'QuantityOfBlockedStock')
										),
					'listAccountProfit' => array(
										'input' => array(),
										'output' => array( 'AccountID', 'AccountNo', 'InvestorName'/*, 'Balance'*/, 'Profit')
										),
					'getLastProfitDate' => array(
										'input' => array(),
										'output' => array('ProfitDate')
										),
					'approveAccountProfit' => array(
										'input' => array('AccountNo', 'ApproveDate', 'Note', 'UpdatedBy'),
										'output' => array('ID')
										),
					'addProfitHistory' => array(
										'input' => array('FromDate', 'ToDate', 'ApproveDate', 'Note', 'UpdatedBy'),
										'output' => array('ID')
										),
					'listProfitHistory' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array('ID', 'FromDate', 'ToDate', 'ProfitDate', 'Note', 'CreatedBy', 'CreatedDate')
										),
					'listEventWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'StockID', 'Symbol', 'StockExchangeID', 'EventTypeID', 'EventTypeName', 'LastRegistrationDate','ExpireDate', 'BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'EventStatus1', 'IsRound1', 'IsRound', 'NumberTransfer', 'Note', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'UBCKDate')
										),
					'listDividendPrivilegeWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'EventID', 'AccountID', 'AccountNo', 'InvestorName', 'StockID', 'Symbol', 'EventTypeID', 'EventTypeName', 'StockQtty', 'NormalPrivilegeQtty', 'IncrementStockQtty','LimitPrivilegeQtty', 'IsConfirmed1', 'IsConfirmed', 'MoneyDividend'/*, 'StockDividend'*/, 'RemainingStockDivident', 'RemainingMoneyByStockDivident', 'MobilePhone', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID')
										),
					'listEventDividendWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'StockID', 'Symbol', 'EventTypeID', 'EventTypeName', 'LastRegistrationDate','ExpireDate', 'BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'EventStatus1', 'IsRound1', 'IsRound', 'NumberTransfer', 'Note', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'UBCKDate')
										),
					'listEventBuyingStockWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'StockID', 'Symbol', 'EventTypeID', 'EventTypeName', 'LastRegistrationDate','ExpireDate', 'BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'EventStatus1', 'IsRound1', 'IsRound', 'NumberTransfer', 'Note', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'UBCKDate')
										),
					'listTransferPrivilegeWithFilter' => array(
										'input' => array( 'Where', 'TimeZone'),
										'output' => array( 'ID', 'EventID', 'AccountIDFrom', 'AccountNoFrom', 'InvestorNameFrom', 'AccountIDTo', 'AccountNoTo', 'InvestorNameTo', 'StockID', 'Symbol', 'EventID', 'EventTypeID', 'EventTypeName', 'PrivilegeQuantity', 'IsConfirmed1', 'IsConfirmed' , 'Note', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listEventByAccountNo' => array(
										'input' => array( 'AccountNo', 'Where', 'TimeZone'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'InvestorName', 'StockID', 'Symbol', 'EventTypeID', 'EventTypeName', 'StockQuantity', 'UBCKDate', 'StockRegistration', 'LastRegistrationDate','ExpireDate', 'BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'EventStatus1', 'IsRound1', 'IsRound', 'NumberTransfer', 'Note', 'NormalPrivilegeQtty','LimitPrivilegeQtty', 'MoneyDividend'/*, 'StockDividend'*/, 'RemainingStockDivident', 'RemainingMoneyByStockDivident', 'MobilePhone', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'addEvent' => array(
										'input' => array('StockID', 'EventTypeID', 'LastRegistrationDate', 'ExpireDate', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'NumberTransfer', 'Note', 'Round', 'CreatedBy', 'UBCKDate'),
										'output' => array('ID')
										),
					'updateEvent' => array(
										'input' => array('ID', 'StockID', 'EventTypeID', 'LastRegistrationDate', 'ExpireDate', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'NumberTransfer', 'Note', 'Round', 'UpdatedBy', 'UBCKDate'),
										'output' => array()
										),
					'approveEvent' => array(
										'input' => array('ID', 'Today', 'UpdatedBy'),
										'output' => array()
										),
					'deleteEvent' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'updateBalanceForDividend' => array(
										'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy'),
										'output' => array()
										),
					'updateStockForDividend' => array(
										'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy', 'MobilePhone', 'AccountNo', 'StockSymbol', 'Quantity'),
										'output' => array()
										),
					'updateStockMoneyForDividend' => array(
										'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy'),
										'output' => array()
										),
					'ConfirmBuyingStockForDividend' => array(
										'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy'),
										'output' => array()
										),
					'updateBuyingStockForDividend' => array(
										'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy', 'MobilePhone', 'AccountNo', 'StockSymbol', 'Quantity'),
										'output' => array()
										),
					'updateEventStatus' => array(
										'input' => array('EventID', 'UpdatedBy'),
										'output' => array()
										),
					'Check_UpdateEventStatus' => array(
										'input' => array('EventID', 'TradingDate'),
										'output' => array()
										),
					'addBuyingStockRegistration' => array(
										'input' => array('EventID', 'Quantity', 'AccountNo', 'TradingDate', 'UpdatedBy'),
										'output' => array('ID')
										),
					'updateBuyingStockRegistration' => array(
										'input' => array('EventID', 'Quantity', 'AccountNo', 'TradingDate', 'UpdatedBy'),
										'output' => array('ID')
										),
					'deleteBuyingStockRegistration' => array(
										'input' => array('EventID', 'AccountNo', 'TradingDate', 'UpdatedBy'),
										'output' => array()
										),
					'addTransferPrivilege' => array(
										'input' => array('FromAccountNo', 'ToAccountNo', 'TradingDate', 'Quantity', 'EventID', 'CreatedBy', 'Note'),
										'output' => array('ID')
										),
					'updateTransferPrivilege' => array(
										'input' => array('ID','FromAccountNo', 'ToAccountNo', 'TradingDate', 'Quantity', 'EventID', 'UpdatedBy', 'Note'),
										'output' => array()
										),
					'deleteTransferPrivilege' => array(
										'input' => array('ID', 'UpdatedBy'),
										'output' => array()
										),
					'approveTransferPrivilege' => array(
										'input' => array('ID', 'Today', 'UpdatedBy'),
										'output' => array()
										),
					'reportBuyingStockPrivilege' => array(
										'input' => array( 'EventID', 'AccountID'),
										'output' => array( 'FullName', 'ContactAddress', 'CardNo', 'AccountNo', 'IncrementStockQtty', 'StockQtty', 'NormalPrivilegeQtty', 'LimitPrivilegeQtty', 'LastRegistrationDate', 'ExpireDate', 'Price', 'Rate','Symbol', 'ParValue', 'CompanyName', 'IsRound', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'CountryName', 'HomePhone', 'MobilePhone','CardNoDate', 'CardNoIssuer')
										),
					'reportBuyingStockPrivilege_byEvent' => array(
										'input' => array( 'EventID'),
										'output' => array( 'FullName', 'ContactAddress', 'CardNo', 'AccountNo', 'IncrementStockQtty', 'StockQtty', 'NormalPrivilegeQtty', 'LimitPrivilegeQtty', 'LastRegistrationDate', 'ExpireDate', 'Price', 'Rate','Symbol', 'ParValue', 'CompanyName', 'IsRound', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'CountryName', 'HomePhone', 'MobilePhone','CardNoDate', 'CardNoIssuer')
										),
					'listEventByUBCKDate' => array(
										'input' => array( 'TradingDate', 'Where'),
										'output' => array( 'EventID', 'Symbol', 'LastRegistrationDate', 'EventTypeName', 'UBCKDate', 'Rate', 'Price','BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate')
										),
					'listEventtBuyingStockUBCKDate' => array(
										'input' => array( 'TradingDate'),
										'output' => array( 'EventID', 'Symbol', 'LastRegistrationDate', 'EventTypeName', 'UBCKDate', 'BeginTranferDate', 'EndTranferDate', 'BeginRegisterDate', 'EndRegisterDate', 'BeforeEndRegisterDate3Date', 'BeforeEndRegisterDate1Date', 'IsSendMSG')
										),
					'UpdateDividendPrivilege' => array(
										'input' => array( 'DividentPrivilegeID', 'NewRetailStockQtty', 'NormalPrivilegeQtty', 'UpdatedBy'),
										'output' => array( )
										),
					'ListEvent_BuyingStock'=> array(
										'input' => array( 'EventID', 'CuttingMoney'),
										'output' => array('AccountID', 'FullName', 'AccountNo', 'StockQtty', 'BuyingQuantity', 'BuyingRegQuantity', 'Price' ,'BuyingMoney' , 'CuttingMoneyStatus', 'AccountBankID')
										),
					'ConfirmBuyingStockForDividend_CutMoney'=> array(
										'input' => array( 'EventID', 'AccountID','UpdatedBy','Today','BankID'),
										'output' => array()
										),
					'listDividendPrivilege_ForSendMSG' => array(
										'input' => array( 'EventID'),
										'output' => array( 'AccountID', 'AccountNo', 'FullName', 'MobilePhone', 'StockSymbol', 'EndRegisterDate', 'BeforeEndRegisterDate1Date', 'Amount')
										),
					'SendSMS_BuyingStockForDividend'=> array(
										'input' => array( 'EventID', 'UpdatedBy'),
										'output' => array()
										),
					'DeleteDividendPrivilege'=> array(
										'input' => array( 'EventID', 'AccountNo', 'UpdatedBy'),
										'output' => array()
										),
					'sendSMSForEvent'=> array(
										'input' => array( 'EventID'),
										'output' => array()
										),
					'getSendSMSRequired'=> array(
										'input' => array( 'EventID'),
										'output' => array('ID', 'MobilePhone', 'AccountNo', 'Symbol', 'Quantity')
										),

					'getTotalBlockedQuantityWithoutConfirmed'=> array(
										'input' => array( 'AccountNo', 'StockID'),
										'output' => array('Quantity')
										),

					'insertWithoutConfirmed'=> array(
										'input' => array( 'AccountNo', 'StockID', 'Quantity', 'UnblockedDate', 'Note', 'CreatedBy'),
										'output' => array('ID')
										),

					'deleteWithoutConfirmed'=> array(
										'input' => array( 'ID', 'UpdatedBy'),
										'output' => array()
										),

					'confirmUnblockedHistory'=> array(
										'input' => array( 'ID', 'UpdatedBy'),
										'output' => array()
										),

					'listUnblockedHistory'=> array(
										'input' => array( 'AccountNo', 'IsConfirmed', 'CreatedBy', 'FromDate', 'ToDate'),
										'output' => array( 'ID', 'AccountID', 'StockID', 'Quantity', 'Note', 'UnblockedDate', 'IsConfirmed', 'CreatedDate', 'CreatedBy', 'UpdatedDate', 'UpdatedBy', 'AccountNo', 'StockSymbol')
										),
					'insertDivident' => array(
										'input' => array( 'AccountID', 'BankID', 'Amount', 'DepositDate', 'Note', 'CreatedBy' ),
										'output' => array( 'ID' )
										),
					'insertBuyingStockDivident' => array(
										'input' => array( 'AccountID', 'BankID', 'Amount', 'DepositDate', 'Note', 'CreatedBy' ),
										'output' => array( 'ID' )
										),
          'ConfirmBuyingStockForDividend_CutMoney_ForTraiPhieu' => array(
                    'input' => array( 'EventID', 'AccountID','UpdatedBy','Today','BankID','Note'),
                    'output' => array()
                    ),
          'updateBalanceForDividend_ForTraiPhieu' => array(
                    'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy','Note'),
                    'output' => array()
                    ),
          'updateStockMoneyForDividend_ForTraiPhieu' => array(
                    'input' => array('EventID', 'AccountID', 'Today', 'UpdatedBy','Note'),
                    'output' => array()
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

	/* ---------------------------  TradingRegister Function ------------------------------- */
	 /**
	 * Function listTradingRegisterWithFilter	: get list of TradingRegisterWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listTradingRegisterWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listTradingRegisterWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf("CALL sp_ListRegisterStock (\"%s\", \"%s\")", $timezone, $condition );

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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								'StockStatusID'  => new SOAP_Value("StockStatusID", "string", $result[$i]['stockstatusid']),
								'StockStatusName'  => new SOAP_Value("StockStatusName", "string", $result[$i]['stockstatusname']),
								'RegisterDate'  => new SOAP_Value("RegisterDate", "string", $result[$i]['tregisterdate']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['tcreateddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['tupdateddate'] ),
								'StockExchangeID'  => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid'] ),
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listAccountStock	: get list of AccountStock that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listAccountStock($AccountNo, $StockID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listAccountStock';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf("CALL sp_getAccountStock ('%s', '%s')", $AccountNo, $StockID );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
								'InvestorCardNo'  => new SOAP_Value("InvestorCardNo", "string", $result[$i]['investorcardno']),
								'QuantityOfNormalStock'  => new SOAP_Value("QuantityOfNormalStock", "string", $result[$i]['quantityofnormalstock']),
								'QuantityOfBlockedStock'  => new SOAP_Value("QuantityOfBlockedStock", "string", $result[$i]['quantityofblockedstock']),
								'QuantityOfNormalStockNotConfirm'  => new SOAP_Value("QuantityOfNormalStockNotConfirm", "string", $result[$i]['quantityofnormalstocknotconfirm']),
								'QuantityOfBlockedStockNotConfirm'  => new SOAP_Value("QuantityOfBlockedStockNotConfirm", "string", $result[$i]['quantityofblockedstocknotconfirm'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listAccountStockW	: get list of AccountStockW that  is not deleted
	 * Input 								: $AccountNo, $StockID
	 * OutPut 								: array
	 */
	function listAccountStockW($AccountNo, $StockID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listAccountStockW';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$condition = $condition?' Where '.$condition:'';

			$query = sprintf("CALL sp_getAccountStockW ('%s', '%s')", $AccountNo, $StockID );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
								'InvestorCardNo'  => new SOAP_Value("InvestorCardNo", "string", $result[$i]['investorcardno']),
								'QuantityOfNormalStock'  => new SOAP_Value("QuantityOfNormalStock", "string", $result[$i]['quantityofnormalstock']),
								'QuantityOfBlockedStock'  => new SOAP_Value("QuantityOfBlockedStock", "string", $result[$i]['quantityofblockedstock']),
								'QuantityOfNormalStockNotConfirmW'  => new SOAP_Value("QuantityOfNormalStockNotConfirmW", "string", $result[$i]['quantityofnormalstocknotconfirmw']),
								'QuantityOfBlockedStockNotConfirmW'  => new SOAP_Value("QuantityOfBlockedStockNotConfirmW", "string", $result[$i]['quantityofblockedstocknotconfirmw'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function addTradingRegister	: insert new TradingRegister into database
	 * Input 					: 'AccountID', 'StockID', 'Quantity', 'StockStatusID', 'RegisterDate', 'Note', 'StockRegisterType', 'CreatedBy'
	 * OutPut 					: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */

	function addTradingRegister($AccountNo, $StockID, $Quantity, $StockStatusID, $RegisterDate, $Note, $StockRegisterType, $CreatedBy, $RegPrice )
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addTradingRegister';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AccountNo" 			=> $AccountNo,
										"StockID" 				=> $StockID,
										"Quantity" 				=> $Quantity,
										"StockStatusID" 		=> $StockStatusID,
										"RegisterDate" 			=> $RegisterDate,
										"Note" 					=> $Note,
										"StockRegisterType" 	=> $StockRegisterType,
										"CreatedBy" 	=> $CreatedBy
										);

			$this->_ERROR_CODE = $this->checkValidate($fields_values);
			if($this->_ERROR_CODE==0 && !required($fields_values['RegisterDate'])||!valid_date($fields_values['RegisterDate'])) $this->_ERROR_CODE = 22008;
			if($this->_ERROR_CODE == 0)
			{
				if(strtoupper($StockRegisterType) == 'W')
				{
					$query = sprintf( "CALL sp_insertWithdrawalStockWithoutConfirmed ('%s','%s','%s','%s','%s','%s','%s')", $AccountNo, $StockID, $Quantity, $StockStatusID, $RegisterDate, $Note, $CreatedBy);
					//echo $query;
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					if(empty($result)|| is_object($result)){
						 $this->_ERROR_CODE = 22002;
						 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}else{
						if(isset($result[0]['varerror']))
						{
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
								//$this->_MDB2_WRITE->lastInsertID()
							}else{
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 22005;
											break;
									case '-2':// Invalid StockID
											$this->_ERROR_CODE = 22006;
											break;
									case '-3'://Invalid StockStatusID
											$this->_ERROR_CODE = 22007;
											break;
									case '-4':// not enougt normal stock for Withdrawal
											$this->_ERROR_CODE = 22018;
											break;
									case '-5':// not enougt block stock for Withdrawal
											$this->_ERROR_CODE = 22023;
											break;
									case '-6':// can not Withdrawal mortage stock
											$this->_ERROR_CODE = 22025;
											break;
									case '-7':// Invalid Date
											$this->_ERROR_CODE = 22104;
											break;
									default://Exception
											$this->_ERROR_CODE = 22019;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
								}
							}
						}
					}
				}else{
					$query = sprintf( "CALL sp_insertDepositStockWithoutConfirmed ('%s','%s','%s','%s','%s','%s','%s', %f)", $AccountNo, $StockID, $Quantity, $StockStatusID, $RegisterDate, $Note, $CreatedBy, $RegPrice);
					//echo $query;
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					if(empty($result)|| is_object($result)){
						 $this->_ERROR_CODE = 22002;
						 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}
					else{
						if(isset($result[0]['varerror']))
						{
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
								//$this->_MDB2_WRITE->lastInsertID()
							}else{
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 22005;
											break;
									case '-2':// Invalid StockID
											$this->_ERROR_CODE = 22006;
											break;
									case '-3'://Invalid StockStatusID
											$this->_ERROR_CODE = 22007;
											break;
									case '-4':// not enougt normal stock for Withdrawal
											$this->_ERROR_CODE = 22018;
											break;
									case '-5':// Invalid Date
											$this->_ERROR_CODE = 22104;
											break;
									default://Exception
											$this->_ERROR_CODE = 22019;
											write_my_log_path('addTradingRegister',$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
								}
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateTradingRegister: update TradingRegister
	 * Input 				: 'ID','AccountID', 'StockID', 'Quantity', 'StockStatusID', 'Note', 'StockRegisterType', 'UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function updateTradingRegister($ID, $AccountNo, $StockID, $Quantity, $Note, $StockRegisterType, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateTradingRegister';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AccountNo" 			=> $AccountNo,
										"StockID" 				=> $StockID,
										"Quantity" 				=> $Quantity,
										"RegisterDate" 			=> $RegisterDate,
										"Note" 					=> $Note,
										"StockRegisterType" 	=> $StockRegisterType,
										"UpdatedBy" 			=> $UpdatedBy
										);
			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22001;
			} else
			{
				$this->_ERROR_CODE = $this->checkValidate($fields_values);
			}
			if($this->_ERROR_CODE == 0)
			{
				if(strtoupper($StockRegisterType) == 'W')
				{
					$query = sprintf( "CALL sp_updateWithdrawalStockWithoutConfirmed ('%s','%s','%s','%s','%s','%s')", $ID, $AccountNo, $StockID, $Quantity, $Note, $UpdatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					if(empty($result) || is_object($result)){
						$this->_ERROR_CODE = 22003;
						write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 22005;
											break;
									case '-2':// Invalid StockID
											$this->_ERROR_CODE = 22006;
											break;
									case '-3'://Invalid StockStatusID
											$this->_ERROR_CODE = 22007;
											break;
									case '-4'://not enougt normal stock for Withdrawal
									case '-5':// //not enougt normal stock for Withdrawal
									case '-6':// //not enougt normal stock for Withdrawal
											$this->_ERROR_CODE = 22018;
											break;
									case '-8':///not enougt block stock for Withdrawal
									case '-10':// /not enougt block stock for Withdrawal
									case '-12':// /not enougt block stock for Withdrawal
											$this->_ERROR_CODE = 22023;
											break;
									case '-7'://Invalid StockRegisterID
											$this->_ERROR_CODE = 22001;
											break;
									case '-9'://error when updating
									case '-11':// error when updating
									case '-13':// error when updating
											$this->_ERROR_CODE = 22024;
											break;
									default://Exception
											$this->_ERROR_CODE = 22019;
											write_my_log_path('updateTradingRegister',$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
								}
							}
						}
					}
				}else{
					$query = sprintf( "CALL sp_updateDepositStockWithoutConfirmed ('%s','%s','%s','%s','%s','%s')", $ID, $AccountNo, $StockID, $Quantity, $Note, $UpdatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					if(empty($result) || is_object($result)){
						$this->_ERROR_CODE = 22003;
						write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 22005;
											break;
									case '-2':// Invalid StockID
											$this->_ERROR_CODE = 22006;
											break;
									case '-3'://Invalid StockStatusID
											$this->_ERROR_CODE = 22007;
											break;
									case '-4'://Invalid StockRegisterID
											$this->_ERROR_CODE = 22001;
									default://Exception
											$this->_ERROR_CODE = 22019;
											write_my_log_path('updateTradingRegister',$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
								}
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function deleteTradingRegister	: delete a TradingRegister
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteTradingRegister($ID, $StockRegisterType, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteTradingRegister';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22001;
			}
			if($this->_ERROR_CODE == 0)
			{
				if(strtoupper($StockRegisterType) == 'W')
				{
					$query = sprintf( "CALL sp_deleteWithdrawalStockWithoutConfirmed ('%u','%s')", $ID, $UpdatedBy);
				}else{
					$query = sprintf( "CALL sp_deleteDepositStockWithoutConfirmed ('%u','%s')", $ID, $UpdatedBy);
				}
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not delete
				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 22004;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							//Invalid WDID
							if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 22001;
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function checkWithdrawalDepositValidate	: check the validation of data input
	 * Input 							: array of data
	 * Output 							: error code. Return 0 if data is valid and return error code
	 							 (number >0).
	 */
	function checkValidate($data)
	{
		if(!required($data['AccountNo'])) return 22005;
		if(!required($data['StockID']) || !numeric($data['StockID'])) return 22006;
		if(!required($data['Quantity']) || !numeric($data['Quantity'])) return 22007;
		if(!required($data['StockRegisterType']) || (!in_array($data['StockRegisterType'],array('W','D')))) return 22012;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 18059;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 18060;
		return 0;
	}

	/**
	 * Function approveWD	: approve WithdrawalDeposit, update balance money
	 * Input 				:  'ID', 'UpdatedBy'
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function approveTradingRegister($ID, $StockRegisterType, $StockTradingType, $UpdatedBy, $MobilePhone, $AccountNo, $StockSymbol, $Quantity)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'approveTradingRegister';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$fields_values = array(
										"UpdatedBy" 	=> $UpdatedBy,
										"UpdatedDate" 	=> $this->_MDB2_WRITE->date->mdbnow()
										);
			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22001;
			} else
			{
				if(strtoupper($StockRegisterType) == 'W')
				{
					$query = sprintf( "CALL sp_confirmWithdrawalStock ('%u','%s','%s')", $ID,  $StockTradingType, $UpdatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not delete
					if(empty($result) || is_object($result)){
						$this->_ERROR_CODE = 22017;
						write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}
					else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid StockStatusID
										$this->_ERROR_CODE = 22007;
										break;
									case -2://Invalid StockRegisterID
										$this->_ERROR_CODE = 22001;
										break;
									case -4:/*Can not insert into stock_history*/
										$this->_ERROR_CODE = 22021;
										break;
									case -3:/*not enougt stock for Withdrawal*/
										$this->_ERROR_CODE = 22018;
										break;
									default://Exception
										$this->_ERROR_CODE = 22019;
										write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
				}else{
					$query = sprintf( "CALL sp_confirmDepositStock ('%u','%s','%s')", $ID,  $StockTradingType, $UpdatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not delete
					if(empty($result) || is_object($result)){
						$this->_ERROR_CODE = 22017;
						write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid StockRegisterID
										$this->_ERROR_CODE = 22001;
										break;
									case -2://Can not insert into account_detail
									case -5://Can not insert into account_detail
										$this->_ERROR_CODE = 22020;
										break;
									case -4:/*Can not insert into stock_history*/
									case -6:/*Can not insert into stock_history*/
										$this->_ERROR_CODE = 22021;
										break;
									case -3:/*Invalid StockStatusID*/
										$this->_ERROR_CODE = 22007;
										break;
									case -7:/*Invalid StockTradingTypeID*/
										$this->_ERROR_CODE = 22022;
										break;
									default://Exception
										$this->_ERROR_CODE = 22019;
										write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
					if($this->_ERROR_CODE==0 && $MobilePhone!='')
					{
						$array_SMS = array('Phone'=>$MobilePhone,
							'Content'=>'EPS xin thong bao TK '.$AccountNo.' chung khoan luu ky ghi so thanh cong '.$StockSymbol.'-'.$Quantity);
						$ok=sendSMS($array_SMS);
						write_my_log_path($function_name ,'Send to '.$array_SMS['Phone'].' '.$array_SMS['Content'].' '.date('Y-m-d h:i:s'),SMS_PATH);
						//if($ok != 200) $this->_ERROR_CODE = 22019;	// khong gui duoc tin nhan
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function getStockQuantity	: getStockQuantity
	 * Input 					: $AccountNo, $StockID
	 * OutPut 					:
	 */
	function getStockQuantity($AccountNo, $StockID)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'getStockQuantity';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );


			if($this->_ERROR_CODE == 0)
			{

				$query = sprintf( "CALL sp_getAccountStockQuantity ('%s','%s')", $AccountNo, $StockID);
				//echo $query;
				$result = $this->_MDB2->extended->getAll($query);
				//Can not delete
				$num_row = count($result);
				if($num_row>0)
				{
						for($i=0; $i<$num_row; $i++) {
							$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'QuantityOfNormalStock'  => new SOAP_Value("InvestorName", "string", $result[$i]['quantityofnormalstock']),
								'QuantityOfMortageStock'  => new SOAP_Value("QuantityOfMortageStock", "string", $result[$i]['quantityofmortagestock']),
								'QuantityOfBlockedStock'  => new SOAP_Value("QuantityOfBlockedStock", "string", $result[$i]['quantityofblockedstock'])
								)
							);
						}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/* --------------------------- End TradingRegister Function ------------------------------- */
	 /**
	 * Function listAccountProfix	: get list of listAccountProfix that  is not deleted
	 * Input 								:
	 * OutPut 								: array
	 */
	function listAccountProfit() {
		try{
			$class_name = $this->class_name;
			$function_name = 'listAccountProfit';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$condition = $condition?' Where '.$condition:'';
			$query = sprintf("SELECT  * FROM vw_AccountProfit Where Profit>0");

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
								//'Balance'  => new SOAP_Value("Balance", "string", $result[$i]['balance']),
								'Profit'  => new SOAP_Value("Profit", "string", $result[$i]['profit'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	 /**
	 * Function approveAccountProfit	: get list of approveAccountProfit that  is not deleted
	 * Input 								:
	 * OutPut 								: array
	 */
	function approveAccountProfit($AccountNo, $ApproveDate, $Note, $UpdatedBy) {
		try{
			$class_name = $this->class_name;
			$function_name = 'approveAccountProfit';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($ApproveDate)||!valid_date($ApproveDate)) $this->_ERROR_CODE = 22026;
			if($this->_ERROR_CODE==0)
			{
				$Amount = $this->getProfitMoney($AccountNo);
				$soap = &new Bravo();
				$deposit_value = array("TradingDate" => $ApproveDate, "AccountNo" => $AccountNo, "Amount" => $Amount, "Note" => "Phan bo lai".$Note);
				$ret = $soap->deposit($deposit_value);
				if($ret['table0']['Result']==1){
					$query = sprintf( "CALL sp_confirmAccountProfitDetail ('%s','%s','%s','%s')", $AccountNo, $ApproveDate, $Note, $UpdatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not approve
					if(empty($result) || is_object($result)){
						$soap->rollback($ret['table1']['Id'], $ApproveDate);
						$this->_ERROR_CODE = 22029;

					}else{
						if(isset($result[0]['varerror']))
						{
							//cannot insert money history
							if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 22028;
							//Exception
							if($result[0]['varerror'] < -1) $this->_ERROR_CODE = 22027;
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
								//$this->_MDB2_WRITE->lastInsertID()
							}
							if($this->_ERROR_CODE!=0){
								$soap->rollback($ret['table1']['Id'], $ApproveDate);
							}
						}
					}
				}else{
					switch ($ret['table0']['Result']) {
						case 0:
							$this->_ERROR_CODE =0;
							break;
						case -2://Error - bravo
							$this->_ERROR_CODE = 23002;
							break;
						case -1://Invalid key
							$this->_ERROR_CODE = 23003;
							break;
						case -13:/*Invalid Transaction Type*/
							$this->_ERROR_CODE = 23006;
							break;
						case -15:/*Invalid CustomerCode*/
							$this->_ERROR_CODE = 23005;
							break;
						case -16:/*Invalid DestCustomerCode*/
							$this->_ERROR_CODE = 23004;
							break;
						default://Unknown Error
							$this->_ERROR_CODE = 23009;
							write_my_log_path($function_name ,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
							break;
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getProfitMoney($AccountNo)
	{
		$query = sprintf( "select b.Profit as Amount from account a,money_balance b Where a.Deleted='0' and (isnull(a.`CloseDate`) or (a.`CloseDate` = '')) and b.Deleted='0' and a.AccountNo='%s' and a.ID=b.AccountID",$AccountNo);
		$result = $this->_MDB2->extended->getAll($query);
	    $num_row = count($result);
		if($num_row>0){
			return $result[0]['amount'];
		}
		return 0;
	}

	function addProfitHistory($FromDate, $ToDate, $ApproveDate, $Note, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addProfitHistory';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($ApproveDate)||!valid_date($ApproveDate)) $this->_ERROR_CODE = 22026;
			if($this->_ERROR_CODE==0 && (!required($FromDate)||!valid_date($FromDate))) $this->_ERROR_CODE = 22030;
			if($this->_ERROR_CODE==0 && (!required($ToDate)||!valid_date($ToDate))) $this->_ERROR_CODE = 22031;
			if($this->_ERROR_CODE==0)
			{
				$query = sprintf( "CALL sp_insertProfitHistory ('%s','%s','%s','%s','%s')", $FromDate, $ToDate, $ApproveDate, $Note, $UpdatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not insert
				if(empty($result))	$this->_ERROR_CODE = 22032;
				else{
					if(isset($result[0]['varerror']))
					{
						//FromDate >= ToDate
						if($result[0]['varerror'] == -1) $this->_ERROR_CODE = 22034;
						//Exception
						if($result[0]['varerror'] < -1) $this->_ERROR_CODE = 22033;
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
							//$this->_MDB2_WRITE->lastInsertID()
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	function getLastProfitDate()
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'getLastProfitDate';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$format_date1 = '%d/%m/%Y';
			//select date_format(f_getLastProfitDate(),'%d/%m/%Y')
			 $query = sprintf( "select date_format(f_getLastProfitDate(),'%s') as profitdate", $format_date1);

			 $result = $this->_MDB2->extended->getAll($query);
			// var_dump($result);
			$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
									array(
										'ProfitDate'  => new SOAP_Value("ProfitDate", "string", $result[0]['profitdate'])
										)
								);
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function listProfitHistory	: get list of EventWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listProfitHistory($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listProfitHistory';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf("CALL sp_getProfitHistory('%s',\"%s\")", $timezone, $condition );

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
								'FromDate'  => new SOAP_Value("FromDate", "string", $result[$i]['fromdate']),
								'ToDate'  => new SOAP_Value("ToDate", "string", $result[$i]['todate']),
								'ProfitDate'  => new SOAP_Value("ProfitDate", "string", $result[$i]['profitdate']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listEventWithFilter	: get list of EventWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listEventWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getStockEventList("%s","%s")', $timezone, $condition );

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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'StockExchangeID'  => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'EventStatus1'  => new SOAP_Value("EventStatus1", "string", $result[$i]['eventstatus1']),
								'EventStatus'  => new SOAP_Value("EventStatus", "string", $result[$i]['eventstatus']),
								'IsRound1'  => new SOAP_Value("IsRound1", "string", $result[$i]['isround1']),
								'IsRound'  => new SOAP_Value("IsRound", "string", $result[$i]['isround']),
								'NumberTransfer'  => new SOAP_Value("NumberTransfer", "string", $result[$i]['numbertransfer']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] ),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function listEventDividendWithFilter	: get list of listEventDividendWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listEventDividendWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventDividendWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getEventDividendList("%s","%s")', $timezone, $condition );

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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								// 'EventStatus1'  => new SOAP_Value("EventStatus1", "string", htmlentities($result[$i]['eventstatus1'])),
                'EventStatus1'  => new SOAP_Value("EventStatus1", "string", ($result[$i]['eventstatus1'])),
								'EventStatus'  => new SOAP_Value("EventStatus", "string", ($result[$i]['eventstatus'])),
								// 'IsRound1'  => new SOAP_Value("IsRound1", "string", htmlentities($result[$i]['isround1'])),
                'IsRound1'  => new SOAP_Value("IsRound1", "string", ($result[$i]['isround1'])),
								'IsRound'  => new SOAP_Value("IsRound", "string", ($result[$i]['isround'])),
								'NumberTransfer'  => new SOAP_Value("NumberTransfer", "string", $result[$i]['numbertransfer']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] ),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function listEventDividendWithFilter	: get list of listEventDividendWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listEventBuyingStockWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventBuyingStockWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getEventBuyingStockList("%s","%s")', $timezone, $condition );

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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'EventStatus1'  => new SOAP_Value("EventStatus1", "string", $result[$i]['eventstatus1']),
								'EventStatus'  => new SOAP_Value("EventStatus", "string", $result[$i]['eventstatus']),
								'IsRound1'  => new SOAP_Value("IsRound1", "string", $result[$i]['isround1']),
								'IsRound'  => new SOAP_Value("IsRound", "string", $result[$i]['isround']),
								'NumberTransfer'  => new SOAP_Value("NumberTransfer", "string", $result[$i]['numbertransfer']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] ),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	 /**
	 * Function listDividendPrivilegeWithFilter	: get list of DividendPrivilegeWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listDividendPrivilegeWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listDividendPrivilegeWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getDividendPrivilege("%s","%s")', $timezone, $condition );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
			 /*StockBuying,StockDivident,MoneyDivident,RemainingStockDivident,RemainingMoneyByStockDivident*/
			 /*RemainingStockDivident,RemainingMoneyByStockDivident,MoneyDivident*/
				for($i=0; $i<$num_row; $i++) {
					//$DividendInfo=split(',', $result[$i]['dividendinfo']);
					//echo $result[$i]['dividentinfo'];
				//	$MoneyDividend =$result[$i]['price']*$result[$i]['stockqtty'];
				//	$MoneyDividend1 = printf('%f', $MoneyDividend);
//$MoneyDividend;
					//settype($MoneyDividend1, "float");
					//var_dump($MoneyDividend1);
				//	echo '<br>';
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'ID'  => new SOAP_Value("ID", "string", $result[$i]['dividendprivilegeid']),
								'EventID'  => new SOAP_Value("EventID", "string", $result[$i]['eventid']),
								'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'StockQtty'  => new SOAP_Value("StockQtty", "string", $result[$i]['stockqtty']),
								'NormalPrivilegeQtty'  => new SOAP_Value("NormalPrivilegeQtty", "string", $result[$i]['normalprivilegeqtty']),
								'IncrementStockQtty'  => new SOAP_Value("IncrementStockQtty", "string", $result[$i]['incrementstockqtty']),
								'LimitPrivilegeQtty'  => new SOAP_Value("LimitPrivilegeQtty", "string", $result[$i]['limitprivilegeqtty']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'IsConfirmed1'  => new SOAP_Value("IsConfirmed1", "string", $result[$i]['isconfirmed1']),
								'MoneyDividend'  => new SOAP_Value("MoneyDividend", "string", $result[$i]['totalmoney']),
								'StockDividend'  => new SOAP_Value("StockDividend", "string", $result[$i]['normalprivilegeqtty']),
								'RemainingStockDivident'  => new SOAP_Value("RemainingStockDivident", "string", $result[$i]['retailstockqtty']),
								'RemainingMoneyByStockDivident'  => new SOAP_Value("RemainingMoneyByStockDivident", "string", $result[$i]['price']*$result[$i]['retailstockqtty']),
								/*'StockQttyReceiveTransfer'  => new SOAP_Value("StockQttyReceiveTransfer", "string", 0),
								'StockQttySendTransfer'  => new SOAP_Value("StockQttySendTransfer", "string", 0),*/
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] ),
								'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function listDividendPrivilegeWithFilter	: get list of DividendPrivilegeWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listTransferPrivilegeWithFilter($condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listTransferPrivilegeWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getTransferPrivilegeList("%s","%s")', $timezone, $condition );

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
								'EventID'  => new SOAP_Value("EventID", "string", $result[$i]['eventid']),
								'AccountIDFrom'  => new SOAP_Value("AccountIDFrom", "string", $result[$i]['accountidfrom']),
								'AccountNoFrom'  => new SOAP_Value("AccountNoFrom", "string", $result[$i]['accountnofrom']),
								'InvestorNameFrom'  => new SOAP_Value("InvestorNameFrom", "string", $result[$i]['investornamefrom']),
								'AccountIDTo'  => new SOAP_Value("AccountIDTo", "string", $result[$i]['accountidto']),
								'AccountNoTo'  => new SOAP_Value("AccountNoTo", "string", $result[$i]['accountnoto']),
								'InvestorNameTo'  => new SOAP_Value("InvestorNameTo", "string", $result[$i]['investornameto']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'PrivilegeQuantity'  => new SOAP_Value("PrivilegeQuantity", "string", $result[$i]['privilegequantity']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'IsConfirmed1'  => new SOAP_Value("IsConfirmed1", "string", $result[$i]['isconfirmed1']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function listEventByAccountNo	: get list of DividendPrivilegeWithFilter that  is not deleted
	 * Input 								: String of condition in where clause and $timezone
	 * OutPut 								: array
	 */
	function listEventByAccountNo($AccountNo, $condition, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventByAccountNo';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_GetListEventByAccountNo("%s","%s","%s")', $timezone, $AccountNo, $condition );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				 /*StockBuying,StockDivident,MoneyDivident,RemainingStockDivident,RemainingMoneyByStockDivident*/
				 /*RemainingStockDivident,RemainingMoneyByStockDivident,MoneyDivident*/
				for($i=0; $i<$num_row; $i++) {
					//$DividendInfo=split(',', $result[$i]['dividendinfo']);
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
								'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['investorname']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'EventTypeID'  => new SOAP_Value("EventTypeID", "string", $result[$i]['eventtypeid']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'StockQuantity'  => new SOAP_Value("StockQuantity", "string", $result[$i]['stockqtty']),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate']),
								'StockRegistration'  => new SOAP_Value("StockRegistration", "string", $result[$i]['incrementstockqtty']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'EventStatus1'  => new SOAP_Value("EventStatus1", "string", $result[$i]['eventstatus1']),
								'EventStatus'  => new SOAP_Value("EventStatus", "string", $result[$i]['eventstatus']),
								'IsRound1'  => new SOAP_Value("IsRound1", "string", $result[$i]['isround1']),
								'IsRound'  => new SOAP_Value("IsRound", "string", $result[$i]['isround']),
								'NormalPrivilegeQtty'  => new SOAP_Value("NormalPrivilegeQtty", "string", $result[$i]['normalprivilegeqtty']),
								'LimitPrivilegeQtty'  => new SOAP_Value("LimitPrivilegeQtty", "string", $result[$i]['limitprivilegeqtty']),
								'MoneyDividend'  => new SOAP_Value("MoneyDividend", "string", $result[$i]['price']*$result[$i]['stockqtty']),
								'StockDividend'  => new SOAP_Value("StockDividend", "string", $result[$i]['normalprivilegeqtty']),
								'RemainingStockDivident'  => new SOAP_Value("RemainingStockDivident", "string", $result[$i]['retailstockqtty']),
								'RemainingMoneyByStockDivident'  => new SOAP_Value("RemainingMoneyByStockDivident", "string", $result[$i]['price']*$result[$i]['retailstockqtty']),
								/*'StockQttyReceiveTransfer'  => new SOAP_Value("StockQttyReceiveTransfer", "string", 0),
								'StockQttySendTransfer'  => new SOAP_Value("StockQttySendTransfer", "string", 0),*/
								'NumberTransfer'  => new SOAP_Value("NumberTransfer", "string", $result[$i]['numbertransfer']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addEvent	: insert new Event into database
	 * Input 					: 'StockID', 'EventTypeID', 'LastRegistrationDate', 'ExpireDate', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'NumberTransfer', 'Note', 'Round', 'CreatedBy'
	 * OutPut 					: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */

	function addEvent($StockID, $EventTypeID, $LastRegistrationDate, $ExpireDate, $BeginTransferDate, $EndTransferDate, $BeginRegisterDate, $EndRegisterDate, $Rate, $Price, $NumberTransfer, $Note, $Round, $CreatedBy, $UBCKDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addEvent';

			if ( authenUser(func_get_args(), $this, $function_name)> 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"StockID" 				=> $StockID,
										"EventTypeID" 			=> $EventTypeID,
										"LastRegistrationDate" 	=> $LastRegistrationDate,
										"ExpireDate" 			=> $ExpireDate,
										"BeginTransferDate" 	=> $BeginTransferDate,
										"EndTransferDate" 		=> $EndTransferDate,
										"BeginRegisterDate" 	=> $BeginRegisterDate,
										"EndRegisterDate" 		=> $EndRegisterDate,
										"Rate" 					=> $Rate,
										"Price" 				=> $Price,
										"NumberTransfer" 		=> $NumberTransfer,
										"CreatedBy" 			=> $CreatedBy
										);

			$this->_ERROR_CODE = $this->checkValidateEvent($fields_values);
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_insertEvent ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $StockID, $EventTypeID, $LastRegistrationDate, $ExpireDate, $BeginTransferDate, $EndTransferDate, $BeginRegisterDate, $EndRegisterDate, $Rate, $Price, $NumberTransfer, $CreatedBy, $Note, $Round, $UBCKDate);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				$this->_ERROR_CODE = 0;
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22053;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
					if(isset($result[0]['varerror']))
					{
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
						}else if($this->_ERROR_CODE ==0) {
							switch ($result[0]['varerror']) {
								case 0:
									$this->_ERROR_CODE =0;
									break;
								case -2://Duplicate EventType
									$this->_ERROR_CODE = 22041;
									break;
								case -3://Invalid StockID
									$this->_ERROR_CODE = 22035;
									break;
								case -4:/*Invalid EventTypeID*/
									$this->_ERROR_CODE = 22036;
									break;
								case -6:/*ExpireDate > LastRegistrationDate*/
									$this->_ERROR_CODE = 22045;
									break;
								case -7:/*lastRegDate la ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22096;
									break;
								case -8:/*inExpireDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22097;
									break;
								case -9:/*Exception*/
									$this->_ERROR_CODE = 22043;
									break;
								case -10:/*inBeginTransferDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22098;
									break;
								case -11:/*inEndTransferDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22099;
									break;
								case -12:/*inBeginRegisterDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22100;
									break;
								case -13:/*inEndRegisterDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22101;
									break;
								case -14:/*UBCKDate ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22103;
									break;
								default://default
									$this->_ERROR_CODE = 22134;
									write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
									break;
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateEvent	: update Event into database
	 * Input 					: 'ID', 'StockID', 'EventTypeID', 'LastRegistrationDate', 'ExpireDate', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate', 'Rate', 'Price', 'EventStatus', 'NumberTransfer', 'Note', 'Round', 'UpdatedBy'
	 * OutPut 					: error code. Return 0 if data is valid and return error code
	 					 (number >0).
	 */

	function updateEvent($ID, $StockID, $EventTypeID, $LastRegistrationDate, $ExpireDate, $BeginTransferDate, $EndTransferDate, $BeginRegisterDate, $EndRegisterDate, $Rate, $Price, $NumberTransfer, $Note, $Round, $UpdatedBy, $UBCKDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateEvent';

			if ( authenUser(func_get_args(), $this, $function_name)> 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"StockID" 				=> $StockID,
										"EventTypeID" 			=> $EventTypeID,
										"LastRegistrationDate" 	=> $LastRegistrationDate,
										"ExpireDate" 			=> $ExpireDate,
										"BeginTransferDate" 	=> $BeginTransferDate,
										"EndTransferDate" 		=> $EndTransferDate,
										"BeginRegisterDate" 	=> $BeginRegisterDate,
										"EndRegisterDate" 		=> $EndRegisterDate,
										"Rate" 					=> $Rate,
										"Price" 				=> $Price,
										"EventStatus" 			=> $EventStatus,
										"NumberTransfer" 		=> $NumberTransfer,
										"CreatedBy" 			=> $CreatedBy
										);
			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22042;
			}
			if($this->_ERROR_CODE == 0) $this->_ERROR_CODE = $this->checkValidateEvent($fields_values);
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_updateEvent ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $ID, $StockID, $EventTypeID, $LastRegistrationDate, $ExpireDate, $BeginTransferDate, $EndTransferDate, $BeginRegisterDate, $EndRegisterDate, $Rate, $Price, $NumberTransfer, $UpdatedBy, $Note, $Round, $UBCKDate);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22054;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
					if(isset($result[0]['varerror']))
					{
						if($result[0]['varerror'] <0){
							switch ($result[0]['varerror']) {
								case 0:
									$this->_ERROR_CODE =0;
									break;
								case -1://Invalid EventID
									$this->_ERROR_CODE = 22042;
									break;
								case -2://Duplicate EventType
									$this->_ERROR_CODE = 22041;
									break;
								case -3://Invalid StockID
									$this->_ERROR_CODE = 22035;
									break;
								case -4:/*Invalid EventTypeID*/
									$this->_ERROR_CODE = 22036;
									break;
								case -5:/*invalid EventStatus*/
									$this->_ERROR_CODE = 22076;
									break;
								case -6:/*ExpireDate > LastRegistrationDate*/
									$this->_ERROR_CODE = 22045;
									break;
								case -7:/*lastRegDate la ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22096;
									break;
								case -8:/*inExpireDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22097;
									break;
								case -9:/*Exception*/
									$this->_ERROR_CODE = 22044;
									break;
								case -10:/*inBeginTransferDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22098;
									break;
								case -11:/*inEndTransferDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22099;
									break;
								case -12:/*inBeginRegisterDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22100;
									break;
								case -13:/*inEndRegisterDatela ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22101;
									break;
								case -14:/*UBCKDate ngay le/thu7/CN*/
									$this->_ERROR_CODE = 22103;
									break;
								default://default
									$this->_ERROR_CODE = 22134;
									write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
									break;
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function checkValidateEvent($data){
		if(!required($data['StockID']) || $data['StockID']<=0) return 22035;
		if(!required($data['EventTypeID']) || $data['EventTypeID']<=0) return 22036;
		if(!required($data['LastRegistrationDate'])||!valid_date($data['LastRegistrationDate'])) return 22046;
		if(!required($data['ExpireDate'])||!valid_date($data['ExpireDate'])) return 22047;
		if(isset($data['LastRegistrationDate']) && isset($data['ExpireDate']) && $data['ExpireDate']>$data['LastRegistrationDate']) return 22045;
		if(!isset($data['BeginTransferDate'])&&!valid_date($data['BeginTransferDate'])) return 22048;
		if(!isset($data['EndTransferDate'])&&!valid_date($data['EndTransferDate'])) return 22049;
		if(isset($data['BeginTransferDate']) && isset($data['EndTransferDate']) && $data['BeginTransferDate']>$data['EndTransferDate']) return 22037;
		if(!isset($data['BeginRegisterDate'])&&!valid_date($data['BeginRegisterDate'])) return 22050;
		if(!isset($data['EndRegisterDate'])&&!valid_date($data['EndRegisterDate'])) return 22051;
		if(isset($data['BeginRegisterDate']) && isset($data['EndRegisterDate']) && $data['BeginRegisterDate']>$data['EndRegisterDate']) return 22038;
		if(!required($data['Price']) || !numeric($data['Price']) ||  $data['Price']<0) return 22039;
		if(!required($data['NumberTransfer']) || ($data['NumberTransfer']<0 || $data['NumberTransfer']>10)) return 22040;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 21010;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 21011;
	}

	/**
	 * Function deleteEvent	: delete a Event
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteEvent($ID, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteEvent';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22042;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_delEvent ('%u','%s')", $ID, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not delete
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22052;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
							//Invalid EventID
							if($result[0]['varerror'] == -1){
								 $this->_ERROR_CODE = 22042;
							}else if($result[0]['varerror'] == -2){
								//Invalid Event Status -- Event has been confirmed
							 	$this->_ERROR_CODE = 22076;
							}else if($result[0]['varerror'] == -3){
								//Exception
								 $this->_ERROR_CODE = 22055;
							}else if($result[0]['varerror'] <0){
								$this->_ERROR_CODE = 22134;
								write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function approveEvent	: approve a Event
	 * Input 					: $ID, $Today, $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function approveEvent($ID, $Today, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'approveEvent';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22042;
			}
			if(!required($Today)||!valid_date($Today)) $this->_ERROR_CODE = 22056;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_confirmEvent ('%u','%s','%s')", $ID, $Today, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not delete
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22057;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror']<=0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid EventID
										$this->_ERROR_CODE = 22058;
										break;
									case -2://Invalid Event Status -- Event has been confirmed
										$this->_ERROR_CODE = 22076;
										break;
									case -3://ngay thuc hien be hon ngay chot
										$this->_ERROR_CODE = 22077;
										break;
									case -4:/*Exception*/
										$this->_ERROR_CODE = 22059;
										break;
									case -5:/*Exception*/
										$this->_ERROR_CODE = 22102;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateBalanceForDividend	: updateBalanceForDividend phan bo co tuc = tien cho khach hang -- ke toan
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateBalanceForDividend($EventID, $AccountID, $Today, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateBalanceForDividend';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

			if($this->_ERROR_CODE == 0)
			{
				$Deposit = $this->CheckUpdateBalance($EventID, $AccountID, $Today);
				if($Deposit['ErrorCode']=='0')
				{
					// money in bank
					$query = sprintf( "SELECT BankID, BankAccount,BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' ORDER BY Priority Limit 1", $AccountID);
					$this->_MDB2->disconnect();
					$this->_MDB2->connect();
					$bank_rs = $this->_MDB2->extended->getAll($query);
					$dab_rs = 999;
					$BankID = 0;
					$TransactionType = BRAVO_DIVIDENT_C;// Co tuc cho khach hang
					if ( $Deposit['AccountNo'] != PAGODA_ACCOUNT ) {
						// khong phai ngan hang DA thi cap nhat bankid de ke toan tu thu no, con la DA thi goi ham chuyen tien cho khach hang va cap nhat bankID
							$i =0;
							$BankID = $bank_rs[$i]['bankid'];
							$BravoCode = $bank_rs[$i]['bravocode'];
							switch ($BankID) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->transferfromEPS($bank_rs[$i]['bankaccount'],$Deposit['AccountNo'], '1_'.$EventID.'_'.$AccountID, $Deposit['Amount'], 'Co tuc tu cp '.$Deposit['StockSymbol']);
									write_my_log_path('transferfromEPS','updateBalanceForDividend BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Deposit['AccountNo'].'  Event_AccountID '.'1_'.$EventID.' '.$AccountID.'  Amount '.$Deposit['Amount'].'  Description Co tuc tu co phieu '.$Deposit['StockSymbol'].' Error '.$dab_rs,EVENT_PATH);
									break;

								case OFFLINE:
									$mdb2 = initWriteDB();
									$query = sprintf( "CALL sp_VirtualBank_insertDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Deposit['Amount'], $Today, 'Co tuc tu cp ' . $Deposit['StockSymbol'], $UpdatedBy);
// return returnXML(func_get_args(), $this->class_name, $function_name, $query, $this->items, $this );
									$rs = $mdb2->extended->getRow($query);
									$mdb2->disconnect();
									$dab_rs = $rs["varerror"];
									break;

								default:
									$dab_rs = 0;
							}

              if($BravoCode != VIRTUAL_BANK_BRAVO_BANKCODE){
                $TransactionType = BRAVO_DIVIDENT_C;     // Tai khoan binh thuong
                $Fee = '0';
              } else {
                $TransactionType = BRAVO_DIVIDENT_C_EPS; // Tai khoan tong
                $Fee = $Deposit['Amount'];
              }
					} else {
						$TransactionType = BRAVO_DIVIDENT_P; // Co tuc cho tu doanh
            $Fee = '0';
						$dab_rs = 0;
						$BankID = EXI_ID;
					}
					if($dab_rs == 0){
            if($BankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Deposit['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $Deposit['Amount'], 0, '.', ',' ) . '. Tra co tuc ' . $Deposit['StockSymbol'];
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'updateBalanceForDividend');
              }
            }

						$soap = &new Bravo();
						// chuyen dl qua cho Bravo
						$Deposit_value = array(
                    "TradingDate"     => $Today,
                    'TransactionType' => $TransactionType,
                    "AccountNo"       => $Deposit['AccountNo'],
                    "Amount"          => $Deposit['Amount'],
                    "Fee"             => $Fee,
                    "Bank"            => $BravoCode,
                    "Branch"          => "",
                    "Note"            => "Tra co tuc ".$Deposit['StockSymbol']);
						//var_dump($withdraw_value);
						$ret = $soap->deposit($Deposit_value);
						if($ret['table0']['Result']==1){
							$query = sprintf( "CALL sp_updateBalanceMoney_inDivident ('%s','%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $Today, $UpdatedBy);
							$result = $this->_MDB2_WRITE->extended->getAll($query);
							//Can not delete
							if(empty($result) || is_object($result)){
								 $this->_ERROR_CODE = 22060;
								 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
							}
							else{
									if(isset($result[0]['varerror']))
									{
										if($result[0]['varerror'] <0){
											switch ($result[0]['varerror']) {
												case 0://Invalid EventID
													$this->_ERROR_CODE = 0;
													break;
												case -2://Invalid EventID
													$this->_ERROR_CODE = 22042;
													break;
												case -3://Invalid AccountID
													$this->_ERROR_CODE = 22005;
													break;
												case -4://Loi khi insert vao money history
													$this->_ERROR_CODE = 22061;
													break;
												case -5://Invalid TradingDate
													$this->_ERROR_CODE = 22073;
													break;
												case -6://BOS chua xac nhan su kien eventstastus<>2
													$this->_ERROR_CODE = 22133;
													break;
												default:
													$this->_ERROR_CODE = 22134;
													write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											}
										}
									}
								}
							if($this->_ERROR_CODE!=0){
								// co loi thi rollback Bravo
								$soap->rollback($ret['table1']['Id'], $Today);
							}
						}else{
							switch ($ret['table0']['Result']) {
								case 0:
									$this->_ERROR_CODE =0;
									break;
								case -2://Error - bravo
									$this->_ERROR_CODE = 23002;
									break;
								case -1://Invalid key
									$this->_ERROR_CODE = 23003;
									break;
								case -13:/*Invalid Transaction Type*/
									$this->_ERROR_CODE = 23006;
									break;
								case -15:/*Invalid CustomerCode*/
									$this->_ERROR_CODE = 23005;
									break;
								case -16:/*Invalid DestCustomerCode*/
									$this->_ERROR_CODE = 23004;
									break;
								default://Unknown Error
									$this->_ERROR_CODE = 23009;
									write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
									break;
							}
						}
					}else{
						switch ($dab_rs) {
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
						}
					}
				}else{
					$this->_ERROR_CODE = $Deposit['ErrorCode'];
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateStockForDividend	: updateStockForDividend -- cap nhat chung khoan - co tuc = cp --> chua cap nhat tien, (cap nhat tien tu cp le la 1 form khac cua ke toan) --> nhan tin thong bao cp thuong da ve tk
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateStockForDividend($EventID, $AccountID, $Today, $UpdatedBy, $MobilePhone,$AccountNo, $StockSymbol, $Quantity)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateStockForDividend';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

			if($this->_ERROR_CODE == 0)
			{
				$Deposit = $this->CheckUpdateStockQuantity($EventID, $AccountID, $Today);
				if($Deposit['ErrorCode']=='0')
				{
						$query = sprintf( "CALL sp_updateQuantityStock_inDivident ('%s','%s','%s','%s')", $EventID, $AccountID, $Today, $UpdatedBy);
						//echo $query;
						$result = $this->_MDB2_WRITE->extended->getAll($query);
						//Can not delete
						if(empty($result) || is_object($result)){
							 $this->_ERROR_CODE = 22060;
							 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
						}
						else{
							if(isset($result[0]['varerror']))
							{
								if($result[0]['varerror'] <0){
									switch ($result[0]['varerror']) {
										case 0:
											$this->_ERROR_CODE =0;
											break;
										case -2://Invalid EventID
											$this->_ERROR_CODE = 22042;
											break;
										case -3://Invalid AccountID
											$this->_ERROR_CODE = 22005;
											break;
										case -4:/*loi khi insert vo Stock_History*/
											$this->_ERROR_CODE = 22021;
											break;
										case -5:/*loi khi insert vao bang money_history*/
											$this->_ERROR_CODE = 22028;
											break;
										case -6:/*invalid tradingdate*/
											$this->_ERROR_CODE = 22073;
											break;
										case -1://Exception
											$this->_ERROR_CODE = 22081;
											break;
										default://default
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
									}
								}

								/*if($this->_ERROR_CODE==0 && $MobilePhone!='') {
									$array_SMS = array('Phone'=>$MobilePhone,
									'Content' => 'EPS xin thong bao co phieu thuong da ve den TK '. $AccountNo .' '. $StockSymbol .'-'. $Quantity);
									//$ok=sendSMS($array_SMS);
									write_my_log_path($function_name, 'Send to '. $array_SMS['Phone'] .' '. $array_SMS['Content'], SMS_PATH);
								}*/
							}
						}
				}else{
					$this->_ERROR_CODE = $Deposit['ErrorCode'];
				}
			}
		} catch(Exception $e) {
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/*function sendSMSForEvent($Event) {
		try{
			$class_name = $this->class_name;
			$function_name = 'sendSMSForEvent';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$today = getdate();
			$sub = $today['year'] .'/'. $today['mon'] .'/';
			$path = SMS_PATH. $sub;

			$pre = $today['year'] . $today['mon'] . $today['mday'] ; //$file = '200916_oneShot.txt.error';
			$file = $pre .'_'. $Event . $today['year'] .'-'. date('m') .'-'. date('d') .'.txt';

			if (file_exists($path . $file)) {
				$command = "mv ". $path . $file ." ". $path . $file .".bak";
				system($command, $re);
			} else {
				$this->_ERROR_CODE = 18130;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if($re <> 1) {
				$handle = fopen($path . $file.".bak", 'r');

				while(true){
					$line = fgets($handle) ;
					if($line == NULL)
							break;
					if (strpos($line, '--!>') > 0)
							continue;
					if(strlen($line) < 2)
							continue;

					$divide = explode('EPS ', $line);
					$arrPhone = explode(' ', $divide[0]);
					while ($phone == '') {$phone= array_pop($arrPhone);}
					$array_SMS = array('Phone'=> $phone, 'Content' => 'EPS '. $divide[1]);
					$result = sendSMS($array_SMS);

					if ($result != 200 ) {
						writeNewFile($path . $file .'.done', $line);
					} else {
						writeNewFile($path . $file, $line);
					}
				}
				fclose($handle);
				unlink($path . $file .".bak");

				$handle = fopen($file, 'a+');
				fwrite($handle, $content);
				fclose($handle);
			}
		} catch(Exception $e) {
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}	*/

	function sendSMSForEvent($EventID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'sendSMSForEvent';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "CALL sp_DividendPrivilege_SMSInfo(%u)", $EventID);
			$rs = $this->_MDB2->extended->getAll($query);

			$count = count($rs);
			for($i=0; $i<$count; $i++) {

				$array_SMS = NULL;
				$phone = $rs[$i]['mobilephone'];
				if($rs[$i]['eventtypeid'] == 1) {
					$content = 'EPS xin thong bao co phieu thuong da ve den TK '. $rs[$i]['accountno'] .' '. $rs[$i]['symbol'] .'-'. $rs[$i]['quantity'];

				} elseif($rs[$i]['eventtypeid'] == 3) {
					$content = 'EPS xin thong bao mua co phieu gia uu dai da ve den TK '. $rs[$i]['accountno'] .' '. $rs[$i]['symbol'] .'-'. $rs[$i]['quantity'];
				}

				$ok = -1;
				$array_SMS = array('Phone' => $phone, 'Content' => $content );

				$ok=sendSMS($array_SMS);
				if($ok == 200) {
					$query = sprintf( "CALL sp_DividendPrivilege_updateIsSMS(%u)", $rs[$i]['id']);
					$this->_MDB2_WRITE->extended->getRow($query);
					$this->_MDB2_WRITE->disconnect();
					$this->_MDB2_WRITE->connect();
					write_my_log_path($function_name, 'Send to '. $array_SMS['Phone'] .' '. $array_SMS['Content'] .' '. date('Y-m-d h:i:s'), SMS_PATH);
				}
			}

		} catch(Exception $e) {
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getSendSMSRequired($EventID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getSendSMSRequired';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "CALL sp_DividendPrivilege_SMSInfo(%u)", $EventID);
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
						$this->items[$i] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
									'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
									'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
									'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
									'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								)
						);
			}

		} catch(Exception $e) {
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateStockMoneyForDividend	: ke toan cap nhat tien, (cap nhat tien tu cp le la 1 form khac cua ke toan)
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateStockMoneyForDividend($EventID, $AccountID, $Today, $UpdatedBy)
  {
    try{
      $class_name = $this->class_name;
      $function_name = 'updateStockMoneyForDividend';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
      if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
      if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

      if($this->_ERROR_CODE == 0)
      {
        $Deposit = $this->CheckUpdateStockQuantity_Bravo($EventID, $AccountID, $Today);
        if($Deposit['ErrorCode']=='0')
        {
          // money in bank
          $query = sprintf( "SELECT BankID, BankAccount,BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' ORDER BY Priority Limit 1", $AccountID);
          $this->_MDB2->disconnect();
          $this->_MDB2->connect();
          $bank_rs = $this->_MDB2->extended->getAll($query);
          $dab_rs = 999;
          $BankID = 0;
          $TransactionType = BRAVO_DIVIDENT_C;// Co tuc cho khach hang
          if ( $Deposit['AccountNo'] != PAGODA_ACCOUNT ) {
              $i =0;
              $BankID = $bank_rs[$i]['bankid'];
              $BravoCode = $bank_rs[$i]['bravocode'];
              switch ($BankID) {
                case DAB_ID:
                  $dab = &new CDAB();
                  $dab_rs = $dab->transferfromEPS($bank_rs[$i]['bankaccount'],$Deposit['AccountNo'], '2_'.$EventID.'_'.$AccountID, $Deposit['Amount'], "Co tuc tu cp le ".$Deposit['StockSymbol']);
                  write_my_log_path('transferfromEPS',$function_name.' BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Deposit['AccountNo'].'  Event_AccountID '.'2_'.$EventID.' '.$AccountID.'  Amount '.$Deposit['Amount']." Description Co tuc tu cp le  ".$Deposit['StockSymbol'].' Error '.$dab_rs,EVENT_PATH);
                  break;

                case OFFLINE:
                  $mdb2 = initWriteDB();
                  $query = sprintf( "CALL sp_VirtualBank_insertDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Deposit['Amount'], $Today, 'Co tuc tu cp le ' . $Deposit['StockSymbol'], $UpdatedBy);
                  $rs = $mdb2->extended->getRow($query);
                  $mdb2->disconnect();
                  $dab_rs = $rs["varerror"];
                  break;

                default:
                  $dab_rs = 0;

              }
          } else {
            $TransactionType = BRAVO_DIVIDENT_P; // Co tuc cho tu doanh
            $dab_rs = 0;
            $BankID = EXI_ID;
          }
          if($dab_rs == 0){
            if($BankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Deposit['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $Deposit['Amount'], 0, '.', ',' ) . '. Nhan co tuc chuyen doi tu cp le ' . $Deposit['StockSymbol'];
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'updateStockMoneyForDividend');
              }
            }

            $soap = &new Bravo();
            $Deposit_value = array("TradingDate"      => $Today,
                                   'TransactionType'  => $TransactionType,
                                   "AccountNo"        => $Deposit['AccountNo'],
                                   "Amount"           => $Deposit['Amount'],
                                   "Bank"             => $BravoCode,
                                   "Branch"           => "",
                                   "Note"             => "Nhan co tuc chuyen doi tu cp le ".$Deposit['StockSymbol']); //'011C001458'
            //var_dump($withdraw_value);
            $ret = $soap->deposit($Deposit_value);
            if($ret['table0']['Result']==1){
              $query = sprintf( "CALL sp_updateQuantityStockMoney_inDivident  ('%s','%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $Today, $UpdatedBy);
              //echo $query;
              $result = $this->_MDB2_WRITE->extended->getAll($query);
              //Can not delete
              if(empty($result) || is_object($result)){
                 $this->_ERROR_CODE = 22060;
                 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
              }
              else{
                if(isset($result[0]['varerror']))
                {
                  if($result[0]['varerror'] <0){
                    switch ($result[0]['varerror']) {
                      case 0:
                        $this->_ERROR_CODE =0;
                        break;
                      case -2://Invalid EventID
                        $this->_ERROR_CODE = 22042;
                        break;
                      case -3://Invalid AccountID
                        $this->_ERROR_CODE = 22005;
                        break;
                      case -5:/*loi khi insert vao bang money_history*/
                        $this->_ERROR_CODE = 22028;
                        break;
                      case -6:/*invalid tradingdate*/
                        $this->_ERROR_CODE = 22073;
                        break;
                      case -7:/*(Account&Event) nay da duoc phan bo tien hoac chua duoc moi gioi phan bo cp*/
                        $this->_ERROR_CODE = 22146;
                        break;
                      case -1://Exception
                        $this->_ERROR_CODE = 22081;
                        break;
                      default://default
                        $this->_ERROR_CODE = 22134;
                        write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
                        break;
                    }
                  }
                }
              }
              if($this->_ERROR_CODE!=0 && $Deposit['Amount']>0){
                $soap->rollback($ret['table1']['Id'], $Today);
              }
            }else{
              switch ($ret['table0']['Result']) {
                case 0:
                  $this->_ERROR_CODE =0;
                  break;
                case -2://Error - bravo
                  $this->_ERROR_CODE = 23002;
                  break;
                case -1://Invalid key
                  $this->_ERROR_CODE = 23003;
                  break;
                case -13:/*Invalid Transaction Type*/
                  $this->_ERROR_CODE = 23006;
                  break;
                case -15:/*Invalid CustomerCode*/
                  $this->_ERROR_CODE = 23005;
                  break;
                case -16:/*Invalid DestCustomerCode*/
                  $this->_ERROR_CODE = 23004;
                  break;
                default://Unknown Error
                  $this->_ERROR_CODE = 23009;
                  write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
                  break;
              }
            }
          }else{
            switch ($dab_rs) {
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
                $this->_ERROR_CODE = 22139;

            }
          }
        }else{
          $this->_ERROR_CODE = $Deposit['ErrorCode'];
        }
      }
    }catch(Exception $e){
      write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
      $this->_ERROR_CODE = 23022;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

	/**
	 * Function ConfirmBuyingStockForDividend	: Xac nhan dang ky mua chung khoan gia uu dai
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function ConfirmBuyingStockForDividend($EventID, $AccountID, $Today, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'ConfirmBuyingStockForDividend';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

			if($this->_ERROR_CODE == 0)
			{
				$Withdrawal = $this->CheckConfirmBuyingStock($EventID, $AccountID, $Today);
				if($Withdrawal['ErrorCode']=='0')
				{

					$query = sprintf( "CALL sp_ConfirmBuyingStockReg_inDivident ('%s','%s','%s','%s')", $EventID, $AccountID, $Today, $UpdatedBy);
					//echo $query;
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not delete
					if(empty($result) || is_object($result)){
						 $this->_ERROR_CODE = 22060;
						 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}
					else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -2://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -3://Invalid AccountID
										$this->_ERROR_CODE = 22005;
										break;
									case -4:/*loi khi insert vao bang money_history*/
										$this->_ERROR_CODE = 22028;
										break;
									case -5:/*k du tien mua*/
										$this->_ERROR_CODE = 22067;
										break;
									case -6:/*Khong hop le ngay dang ky*/
										$this->_ERROR_CODE = 22093;
										break;
									case -7:/*Co chuyen nhuong quyen cho AccID nay nhung chua dc confirm*/
										$this->_ERROR_CODE = 22094;
										break;
									case -1://Exception
										$this->_ERROR_CODE = 22078;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}

				}else{
					$this->_ERROR_CODE = $Withdrawal['ErrorCode'];

				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function ConfirmBuyingStockForDividend_CutMoney	: Ke toan cat tien -- day dl qua Bravo -- cap nhat bankid khi cat tien thanh cong
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function ConfirmBuyingStockForDividend_CutMoney($EventID, $AccountID, $UpdatedBy, $Today, $BankID)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'ConfirmBuyingStockForDividend_CutMoney';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;
			if($this->_ERROR_CODE == 0)
			{
				$Withdrawal = $this->CheckConfirmBuyingStock_CutMoney($EventID, $AccountID, $Today);
				if($Withdrawal['ErrorCode']=='0')
				{
					// money in bank
					$query = sprintf( "SELECT BankID, BankAccount, BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' AND BankID ='%s' ", $AccountID, $BankID);
					$this->_MDB2->disconnect();
					$this->_MDB2->connect();
					$bank_rs = $this->_MDB2->extended->getAll($query);
					$dab_rs = 999;
					$BankID = 0;
					$TransactionType = BRAVO_BUYING_STOCK;// phat hanh them cp
					if ($Withdrawal['AccountNo'] != PAGODA_ACCOUNT ) {
						if(count($bank_rs)>0){
							$i =0;
							$BankID = $bank_rs[$i]['bankid'];
							$BravoCode = $bank_rs[$i]['bravocode'];
							switch ($BankID) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->transfertoEPS($bank_rs[$i]['bankaccount'],$Withdrawal['AccountNo'], '3_'.$EventID.'_'.$AccountID, $Withdrawal['Amount'], "*Mua cp uu dai ".$Withdrawal['StockSymbol']);
									write_my_log_path('transfertoEPS',$function_name.' BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Withdrawal['AccountNo'].'  Event_AccountID '.'3_'.$EventID.' '.$AccountID.'  Amount '.$Withdrawal['Amount']." Decription *Mua cp uu dai ".$Withdrawal['StockSymbol'].' Error '.$dab_rs,EVENT_PATH);
									break;

								case OFFLINE:
									$mdb2 = initWriteDB();
									//`sp_VirtualBank_insertBuyingStockDivident`(inAccountID bigint, inBankID int, inAmount double,inTransactionDate date, inNote text(1000), inCreatedBy varchar(100))
									$query = sprintf( "CALL sp_VirtualBank_insertBuyingStockDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Withdrawal['Amount'], $Today, 'Mua cp uu dai  ' . $Withdrawal['StockSymbol'], $UpdatedBy);
									$rs = $mdb2->extended->getRow($query);
									$mdb2->disconnect();
									$dab_rs = $rs["varerror"];
									break;

								default:
									$dab_rs = 0;

							}
						}else{
							$dab_rs = 9999;
							$this->_ERROR_CODE = 22155;//TK k co TK Ngan hang nay
						}
					} else {
						$TransactionType = BRAVO_BUYING_STOCK; // phat hanh them cp
						$dab_rs = 0;
						$BankID = EXI_ID;
					}
					if($dab_rs == 0){
            if($BankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Withdrawal['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: -' . number_format( $Withdrawal['Amount'], 0, '.', ',' ) . '. Mua cp gia uu dai ' . $Withdrawal['StockSymbol'];
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'ConfirmBuyingStockForDividend_CutMoney');
              }
            }

						$soap = &new Bravo();
						$Withdrawal_value = array("TradingDate" => $Today, 'TransactionType'=>$TransactionType, "AccountNo" => $Withdrawal['AccountNo'], "Amount" => $Withdrawal['Amount'], "Bank"=> $BravoCode, "Branch"=> "", "Note" => "Mua cp gia uu dai ".$Withdrawal['StockSymbol']); //'011C001458'
						//var_dump($withdraw_value);
						$ret = $soap->withdraw($Withdrawal_value);
						if($ret['table0']['Result']==1){

							$query = sprintf( "CALL sp_UpdateDividendPrivilege_BankID ('%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $UpdatedBy);
							//echo $query;
							$result = $this->_MDB2_WRITE->extended->getAll($query);
							//Can not update
							if(empty($result) || is_object($result)){
								 $this->_ERROR_CODE = 22120;
								 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
							}
							else{
								if(isset($result[0]['varerror']))
								{
									//p_iDividentPrivilege sai hoac dang ky mua chua xac nhan hoac da cat tien roi
									if($result[0]['varerror'] == -2){
										 $this->_ERROR_CODE = 22121;
									}else if($result[0]['varerror'] == -3){
									//qua ngay cat tien
										 $this->_ERROR_CODE = 22149;
									}else if($result[0]['varerror'] == -1){
									//Exception
										 $this->_ERROR_CODE = 22122;
									}else if($result[0]['varerror']<0){
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
									}
								}
							}
							if($this->_ERROR_CODE!=0){
								$soap->rollback($ret['table1']['Id'], $Today);
							}
						}else{
							switch ($ret['table0']['Result']) {
								case 0:
									$this->_ERROR_CODE =0;
									break;
								case -2://Error - bravo
									$this->_ERROR_CODE = 23002;
									break;
								case -1://Invalid key
									$this->_ERROR_CODE = 23003;
									break;
								case -13:/*Invalid Transaction Type*/
									$this->_ERROR_CODE = 23006;
									break;
								case -15:/*Invalid CustomerCode*/
									$this->_ERROR_CODE = 23005;
									break;
								case -16:/*Invalid DestCustomerCode*/
									$this->_ERROR_CODE = 23004;
									break;
								default://Unknown Error
									$this->_ERROR_CODE = 23009;
									write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
									break;
							}
						}
					}else{
						switch ($dab_rs) {
							case '-1'://unauthenticate partner
								$this->_ERROR_CODE = 22135;
								break;

							case '-2'://invalid parameters
								$this->_ERROR_CODE = 22136;
								break;

							case '-3'://invalid date
								$this->_ERROR_CODE = 22137;
								break;

							case '-12': // Tai khoan khong ton tai
								$this->_ERROR_CODE = 12001;
								break;

							case '-4'://no customer found
								$this->_ERROR_CODE = 22140;
								break;

							case '-5'://transfer unsuccessful
								$this->_ERROR_CODE = 22141;
								break;

							case '-13':
							case '1'://invalid account
								$this->_ERROR_CODE = 22142;
								break;

							case '2'://invalid amount
								$this->_ERROR_CODE = 22143;
								break;

							case '3'://duplicate transfer
								$this->_ERROR_CODE = 22147;
								break;

							case '-14':
							case '5'://not enough balance
								$this->_ERROR_CODE = 22144;
								break;

							case '6'://duplicate account
								$this->_ERROR_CODE = 22145;
								break;

							case '-15'://can not add history transaction
								$this->_ERROR_CODE = 22228;
								break;

							case '-11':
							case '99'://unknown error
								$this->_ERROR_CODE = 22138;
								break;

							default:
								$this->_ERROR_CODE = 22139;

						}
					}


				}else{
					$this->_ERROR_CODE = $Withdrawal['ErrorCode'];

				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function ConfirmBuyingStockForDividend	: Xac nhan chung khoan ve -- viec mua chung khoan gia uu dai - nhan tin
	 * Input 					: $EventID, $AccountID, $Today, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateBuyingStockForDividend($EventID, $AccountID, $Today, $UpdatedBy, $MobilePhone, $AccountNo, $StockSymbol, $Quantity)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateBuyingStockForDividend';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

			if($this->_ERROR_CODE == 0)
			{

					$query = sprintf( "CALL sp_ConfirmBuyingStock_inDivident ('%s','%s','%s','%s')", $EventID, $AccountID, $Today, $UpdatedBy);
					//echo $query;
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not delete
					if(empty($result) || is_object($result)){
						 $this->_ERROR_CODE = 22060;
						 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
					}
					else{
							if(isset($result[0]['varerror']))
							{
								if($result[0]['varerror'] <0){
									switch ($result[0]['varerror']) {
										case 0:
											$this->_ERROR_CODE =0;
											break;
										case -2://Invalid EventID
											$this->_ERROR_CODE = 22042;
											break;
										case -3://Invalid AccountID
											$this->_ERROR_CODE = 22005;
											break;
										case -4:/*loi khi insert vao StockHistory*/
											$this->_ERROR_CODE = 22021;
											break;
										case -6:/*invalid TradingDate*/
											$this->_ERROR_CODE = 22092;
											break;
										case -7:/*con dang ky mua chung khoan chua xac nhan*/
											$this->_ERROR_CODE = 22091;
											break;
										case -1://Exception
											$this->_ERROR_CODE = 22061;
											break;
										default://default
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
									}
								}
							}

							/*if($this->_ERROR_CODE==0 && $MobilePhone!='')
							{
								$array_SMS = array('Phone'=>$MobilePhone, 'Content'=>'EPS xin thong bao mua co phieu gia uu dai da ve den TK '.$AccountNo.' '.$StockSymbol.'-'.$Quantity);
								$ok=sendSMS($array_SMS);
								write_my_log_path($function_name,'Send to '.$array_SMS['Phone'].' '.$array_SMS['Content'], SMS_PATH);
							}*/
						}

			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function updateEventStatus	: updateEventStatus
	 * Input 					: $EventID, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateEventStatus($EventID, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateEventStatus';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_updateEventStatus ('%s','%s')", $EventID, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22063;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -2://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -3://ko cap nhat ben bang Event dc vi bang Divident_privilege chua thuc hien xong
										$this->_ERROR_CODE = 22064;
										break;
									case -4:/*not exist divident_privilege with this EventID*/
										$this->_ERROR_CODE = 22065;
										break;
									case -5:/*Su kien chua duoc phan bo het*/
										$this->_ERROR_CODE = 22095;
										break;
									case -6:/*invalid tradingdate*/
										$this->_ERROR_CODE = 22073;
										break;
									case -7:/*ngay dong su kien <= ngay ket thuc dang ky mua*/
										$this->_ERROR_CODE = 22151;
										break;
									case -1://Exception
										$this->_ERROR_CODE = 22062;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function Check_UpdateEventStatus	: Check_UpdateEventStatus
	 * Input 					: $EventID
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function Check_UpdateEventStatus($EventID, $TradingDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'Check_UpdateEventStatus';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_updateEventStatus_CheckCondition ('%s', '%s')", $EventID, $TradingDate);
				//echo $query;
				$result = $this->_MDB2->extended->getAll($query);
				//Can not sp_updateEventStatus_CheckCondition
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22063;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -2://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -3://ko cap nhat ben bang Event dc vi bang Divident_privilege chua thuc hien xong
										$this->_ERROR_CODE = 22064;
										break;
									case -4:/*not exist divident_privilege with this EventID*/
										$this->_ERROR_CODE = 22065;
										break;
									case -5:/*Su kien chua duoc phan bo het, phai xoa het nhung khach hang chua dang ky mua hay chua dong tien dang ky mua moi co the phan bo su kien*/
										$this->_ERROR_CODE = 22150;
										break;
									case -6:/*invalid tradingdate*/
										$this->_ERROR_CODE = 22073;
										break;
									case -7:/*ngay dong su kien <= ngay ket thuc dang ky mua*/
										$this->_ERROR_CODE = 22151;
										break;
									case -8:/*inPBDate<=v_dLastRegistrationDate*/
										$this->_ERROR_CODE = 22152;
										break;
									case -9:/*inPBDate<=v_dEndRegisterDate*/
										$this->_ERROR_CODE = 22153;
										break;
									case -10:/*inPBDate la ngay le/thu7/CN*/
										$this->_ERROR_CODE = 22154;
										break;
									case -1://Exception
										$this->_ERROR_CODE = 22062;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**addBuyingStockRegistration
	 * Function addBuyingStockRegistration	: addBuyingStockRegistration
	 * Input 					: $EventID, $Quantity, $AccountID, $TradingDate, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function addBuyingStockRegistration($EventID, $Quantity, $AccountNo, $TradingDate, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addBuyingStockRegistration';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountNo))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($TradingDate)||!valid_date($TradingDate))) $this->_ERROR_CODE = 22073;
			if($this->_ERROR_CODE == 0 && (!required($Quantity)||$Quantity<=0)) $this->_ERROR_CODE = 22009;

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_BuyingStock_Registration ('%s','%s','%s','%s','%s')", $EventID, $Quantity, $AccountNo, $TradingDate, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22066;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
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
							}else{
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -2://Invalid AccountID
										$this->_ERROR_CODE = 22005;
										break;
									case -3:/*k du tien mua*/
										$this->_ERROR_CODE = 22067;
										break;
									case -4:/*So luong dang ky lon hon so luong duoc phep mua*/
										$this->_ERROR_CODE = 22068;
										break;
									case -5:/*Ngay dang ky k hop le*/
										$this->_ERROR_CODE = 22088;
										break;
									case -6:/*Da dang ky mua*/
										$this->_ERROR_CODE = 22090;
										break;
									case -9://Exception
										$this->_ERROR_CODE = 22069;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**updateBuyingStockRegistration
	 * Function addBuyingStockRegistration	: updateBuyingStockRegistration
	 * Input 					: $EventID, $Quantity, $AccountID, $TradingDate, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateBuyingStockRegistration($EventID, $Quantity, $AccountNo, $TradingDate, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateBuyingStockRegistration';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountNo))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($TradingDate)||!valid_date($TradingDate))) $this->_ERROR_CODE = 22073;
			if($this->_ERROR_CODE == 0 && (!required($Quantity)||$Quantity<=0)) $this->_ERROR_CODE = 22009;

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_EditBuyingStock_Registration ('%s','%s','%s','%s','%s')", $EventID, $Quantity, $AccountNo, $TradingDate, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result) || is_object($result)){
					 $this->_ERROR_CODE = 22083;
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
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
							}else{
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -2://Invalid AccountID
										$this->_ERROR_CODE = 22005;
										break;
									case -3:/*k du tien mua*/
										$this->_ERROR_CODE = 22067;
										break;
									case -4:/*So luong dang ky lon hon so luong duoc phep mua*/
										$this->_ERROR_CODE = 22068;
										break;
									case -5:/*Ngay dang ky k hop le*/
										$this->_ERROR_CODE = 22088;
										break;
									case -9://Exception
										$this->_ERROR_CODE = 22069;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function deleteBuyingStockRegistration	: deleteBuyingStockRegistration
	 * Input 					: $EventID, $AccountID, $TradingDate, $UpdatedBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteBuyingStockRegistration($EventID, $AccountNo, $TradingDate, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteBuyingStockRegistration';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && (!required($AccountNo))) $this->_ERROR_CODE = 22005;
			if($this->_ERROR_CODE == 0 && (!required($TradingDate)||!valid_date($TradingDate))) $this->_ERROR_CODE = 22073;

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_EditBuyingStock_Registration ('%s','%s','%s','%s','%s')", $EventID, 0, $AccountNo, $TradingDate, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22082;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4], EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid EventID
										$this->_ERROR_CODE = 22042;
										break;
									case -2://Invalid AccountID
										$this->_ERROR_CODE = 22005;
										break;
									case -3:/*k du tien mua*/
										$this->_ERROR_CODE = 22067;
										break;
									case -4:/*So luong dang ky lon hon so luong duoc phep mua*/
										$this->_ERROR_CODE = 22068;
										break;
									case -5:/*Ngay dang ky k hop le*/
										$this->_ERROR_CODE = 22088;
										break;
									case -9://Exception
										$this->_ERROR_CODE = 22069;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function addTransferPrivilege	: addTransferPrivilege
	 * Input 					: $FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $CreatedBy, $Note
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function addTransferPrivilege($FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $CreatedBy, $Note)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addTransferPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && $FromAccountNo==$ToAccountNo) $this->_ERROR_CODE = 22074;
			if($this->_ERROR_CODE == 0 && (($FromAccountNo=='0' && $ToAccountNo=='0') || ($FromAccountNo=='' && $ToAccountNo==''))){
				$this->_ERROR_CODE = 22075;
			}
			if($this->_ERROR_CODE == 0 && (!required($TradingDate)||!valid_date($TradingDate))) $this->_ERROR_CODE = 22073;
			if($this->_ERROR_CODE == 0 && (!required($Quantity)||$Quantity<=0)) $this->_ERROR_CODE = 22009;
			if($this->_ERROR_CODE == 0 && (!required($CreatedBy))) $this->_ERROR_CODE = 22010;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_insertTransfer_Privilege ('%s','%s','%s','%s','%s','%s','%s')", $FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $CreatedBy, $Note);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22066;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] >0)
							{
								$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
									array(
										'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror'])
										)
								);
							}else{
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid FromAccountID
										$this->_ERROR_CODE = 22071;
										break;
									case -2://Invalid ToAccountID
										$this->_ERROR_CODE = 22072;
										break;
									case -3://Exception
										$this->_ERROR_CODE = 22070;
										break;
									case -4://Invalid TradingDate
										$this->_ERROR_CODE = 22073;
										break;
									case -5://so luong chuyen nhuong lon hon so luong cho phep
										$this->_ERROR_CODE = 22084;
										break;
									case -6://su kien khong cho phep chuyen nhuong
										$this->_ERROR_CODE = 22085;
										break;
									case -7://duplicate row
										$this->_ERROR_CODE = 22089;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateTransferPrivilege	: updateTransferPrivilege
	 * Input 					: $ID, $FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $UpdatedBy, $Note
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function updateTransferPrivilege($ID, $FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $UpdatedBy, $Note)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateTransferPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
			if($this->_ERROR_CODE == 0 && $FromAccountNo==$ToAccountNo) $this->_ERROR_CODE = 22074;
			if($this->_ERROR_CODE == 0 && (($FromAccountNo=='0' && $ToAccountNo=='0') || ($FromAccountNo=='' && $ToAccountNo==''))) $this->_ERROR_CODE = 22075;
			if($this->_ERROR_CODE == 0 && (!required($TradingDate)||!valid_date($TradingDate))) $this->_ERROR_CODE = 22073;
			if($this->_ERROR_CODE == 0 && (!required($Quantity)||$Quantity<=0)) $this->_ERROR_CODE = 22009;
			if($this->_ERROR_CODE == 0 && (!required($UpdatedBy))) $this->_ERROR_CODE = 22011;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_updateTransfer_Privilege ('%s','%s','%s','%s','%s','%s','%s','%s')", $ID, $FromAccountNo, $ToAccountNo, $TradingDate, $Quantity, $EventID, $UpdatedBy, $Note);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not updateEventStatus
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22066;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case 0:
										$this->_ERROR_CODE =0;
										break;
									case -1://Invalid FromAccountID
										$this->_ERROR_CODE = 22071;
										break;
									case -2://Invalid ToAccountID
										$this->_ERROR_CODE = 22072;
										break;
									case -3://Exception
										$this->_ERROR_CODE = 22070;
										break;
									case -4://Invalid TradingDate
										$this->_ERROR_CODE = 22073;
										break;
									case -5://Invalid TransferPrivilegeID
										$this->_ERROR_CODE = 22087;
										break;
									case -6://so luong chuyen nhuong lon hon so luong cho phep
										$this->_ERROR_CODE = 22084;
										break;
									case -7://su kien khong cho phep chuyen nhuong
										$this->_ERROR_CODE = 22085;
										break;
									default://default
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function deleteTransferPrivilege	: delete a TransferPrivilege
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function deleteTransferPrivilege($ID, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteTransferPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22087;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_deleteTransfer_Privilege ('%u','%s')", $ID, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not delete
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22052;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							//Invalid TransferPrivilegeID
							if($result[0]['varerror'] == -1){
							 	$this->_ERROR_CODE = 22087;
							}else if($result[0]['varerror'] == -3) {
								//Exception
								$this->_ERROR_CODE = 22079;
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}


	/**
	 * Function deleteTransferPrivilege	: delete a TransferPrivilege
	 * Input 					: $ID , $UpdateBy
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function approveTransferPrivilege($ID, $Today, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'approveTransferPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ID==''||$ID<=0)
			{
				$this->_ERROR_CODE = 22087;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_ConfirmTransfer_Privilege ('%u','%s','%s')", $ID, $UpdatedBy, $Today);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not delete
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22052;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							//Invalid TransferPrivilegeID
							if($result[0]['varerror'] == -2){
								$this->_ERROR_CODE = 22087;
							}else if($result[0]['varerror'] == -3){
								//Ngay giao dich khong hop le
								 $this->_ERROR_CODE = 22073;
							}else if($result[0]['varerror'] == -1){
								//Exception -- approve
								 $this->_ERROR_CODE = 22078;
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/*------------------------------------End Get Data -----------------------------------------*/

	function CheckUpdateBalance($EventID, $AccountID, $Today)
	{
		$deposit = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'BankID' => 0, 'AccountBank'=> '', 'StockSymbol'=>'','ErrorCode' => '0');
	 	$query = sprintf( "CALL sp_updateBalanceMoney_RetTotalMoney ('%s','%s','%s')", $EventID, $AccountID, $Today);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result)|| is_object($result)){
			$deposit['ErrorCode'] = 22080;
			write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
		}
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					switch ($result[0]['varerror']) {
						case 0:
							$deposit['ErrorCode'] =0;
							break;
						case -2://Invalid EventID
							$deposit['ErrorCode'] = 22042;
							break;
						case -3://Invalid AccountID
							$deposit['ErrorCode'] = 22005;
							break;
						case -4://invalid tradingdate
							$deposit['ErrorCode'] = 22073;
							break;
						case -5://BOS chua xac nhan
							$deposit['ErrorCode'] = 22133;
							break;
						default://default
							$deposit['ErrorCode'] = 22134;
							write_my_log_path('CheckUpdateBalance',$query.'  VarError'.$result[0]['varerror'],EVENT_PATH);
							break;
					}
				}else{
					$deposit['AccountNo'] = $result[0]['varaccountno'];
					$deposit['Amount'] = $result[0]['varamount'];
					$deposit['Note'] = $result[0]['varnote'];
					$deposit['BankID'] = $result[0]['bankid'];
					$deposit['AccountBank'] = $result[0]['accountbank'];
					$deposit['StockSymbol'] = $result[0]['stocksymbol'];
				}
			}
		}
		return $deposit;
	}


	function CheckUpdateStockQuantity($EventID, $AccountID, $Today)
	{
		$deposit = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'BankID' => 0, 'AccountBank'=> '', 'StockSymbol'=>'', 'ErrorCode' => '0');
	 	$query = sprintf( "CALL sp_updateQuantityStock_RetMoney ('%s','%s','%s')", $EventID, $AccountID, $Today);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result)|| is_object($result)){
			$deposit['ErrorCode'] = 22080;
			write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
		}
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					//Invalid EventID
					if($result[0]['varerror'] == -2) $deposit['ErrorCode'] = 22042;
					//Invalid AccountID
					if($result[0]['varerror'] == -3) $deposit['ErrorCode'] = 22005;
					//Invalid TradingDate
					if($result[0]['varerror'] == -4) $deposit['ErrorCode'] = 22073;
					//Exception
					if($result[0]['varerror'] == -1) $deposit['ErrorCode'] = 22061;
				}else{
					$deposit['AccountNo'] = $result[0]['varaccountno'];
					$deposit['Amount'] = $result[0]['varamount'];
					$deposit['Note'] = $result[0]['varnote'];
					$deposit['BankID'] = $result[0]['bankid'];
					$deposit['AccountBank'] = $result[0]['accountbank'];
					$deposit['StockSymbol'] = $result[0]['stocksymbol'];
					if($deposit['Amount'] == '' || $deposit['Amount']<0)
						$deposit['ErrorCode'] = 22086;
				}
			}
		}
		return $deposit;
	}

	function CheckUpdateStockQuantity_Bravo($EventID, $AccountID, $Today)
	{
		$deposit = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'BankID' => 0, 'AccountBank'=> '', 'StockSymbol'=>'', 'ErrorCode' => '0');
	 	$query = sprintf( "CALL sp_updateQuantityStock_RetMoneyBravo ('%s','%s','%s')", $EventID, $AccountID, $Today);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result)|| is_object($result)){
			$deposit['ErrorCode'] = 22080;
			write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
		}
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					//Invalid EventID
					if($result[0]['varerror'] == -2) $deposit['ErrorCode'] = 22042;
					//Invalid AccountID
					if($result[0]['varerror'] == -3) $deposit['ErrorCode'] = 22005;
					//Invalid TradingDate
					if($result[0]['varerror'] == -4) $deposit['ErrorCode'] = 22073;
					//Exception
					if($result[0]['varerror'] == -1) $deposit['ErrorCode'] = 22061;
				}else{
					$deposit['AccountNo'] = $result[0]['varaccountno'];
					$deposit['Amount'] = $result[0]['varamount'];
					$deposit['Note'] = $result[0]['varnote'];
					$deposit['BankID'] = $result[0]['bankid'];
					$deposit['AccountBank'] = $result[0]['accountbank'];
					$deposit['StockSymbol'] = $result[0]['stocksymbol'];
					if($deposit['Amount'] == '' || $deposit['Amount']<0)
						$deposit['ErrorCode'] = 22086;
				}
			}
		}
		return $deposit;
	}

	function CheckConfirmBuyingStock($EventID, $AccountID, $Today)
	{
		$withdrawal = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'BankID' => 0, 'AccountBank'=> '', 'StockSymbol'=>'', 'ErrorCode' => '0');
	 	$query = sprintf( "CALL sp_ConfirmBuyingStockReg_RetTotalMoney ('%s','%s','%s')", $EventID, $AccountID, $Today);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result)|| is_object($result)){
			$withdrawal['ErrorCode'] = 22080;
			write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
		}
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					switch ($result[0]['varerror']) {
						case 0:
							$withdrawal['ErrorCode'] =0;
							break;
						case -1://Exception
							$withdrawal['ErrorCode'] = 22061;
							break;
						case -2://Invalid EventID
							$withdrawal['ErrorCode'] = 22042;
							break;
						case -3://Invalid AccountID
							$withdrawal['ErrorCode'] = 22005;
							break;
						case -4://loi khi insert vao bang money_history
							$withdrawal['ErrorCode'] = 22028;
							break;
						case -5://khong du tien
							$withdrawal['ErrorCode'] = 22067;
							break;
						case -6://ngay khong hop le
							$withdrawal['ErrorCode'] = 22073;
							break;
						default://default
							$withdrawal['ErrorCode'] = 22134;
							write_my_log_path('CheckConfirmBuyingStock',$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
							break;

					}

				}else{
					$withdrawal['AccountNo'] = $result[0]['varaccountno'];
					$withdrawal['Amount'] = $result[0]['varamount'];
					$withdrawal['Note'] = $result[0]['varnote'];
					$withdrawal['BankID'] = $result[0]['bankid'];
					$withdrawal['AccountBank'] = $result[0]['bankaccount'];
					$withdrawal['StockSymbol'] = $result[0]['stocksymbol'];
					if($withdrawal['Amount'] == '' || $withdrawal['Amount']<=0)
						$withdrawal['ErrorCode'] = 22086;
				}
			}
		}
		return $withdrawal;
	}

	function CheckConfirmBuyingStock_CutMoney($EventID, $AccountID, $Today)
	{
		$withdrawal = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'BankID' => 0, 'AccountBank'=> '', 'ErrorCode' => '0');
	 	$query = sprintf( "CALL sp_ConfirmBuyingStockReg_CuttingMoney ('%s','%s','%s')", $EventID, $AccountID, $Today);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result)|| is_object($result)){
			$withdrawal['ErrorCode'] = 22080;
			write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
		}
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					switch ($result[0]['varerror']) {
						case 0:
							$withdrawal['ErrorCode'] =0;
							break;
						case -1://Exception
							$withdrawal['ErrorCode'] = 22061;
							break;
						case -2://Invalid EventID
							$withdrawal['ErrorCode'] = 22042;
							break;
						case -3://Invalid AccountID
							$withdrawal['ErrorCode'] = 22005;
							break;
						case -4://loi khi insert vao bang money_history
							$withdrawal['ErrorCode'] = 22028;
							break;
						case -5://khong du tien
							$withdrawal['ErrorCode'] = 22067;
							break;
						case -6://ngay khong hop le
							$withdrawal['ErrorCode'] = 22073;
							break;
						case -7://Co chuyen nhuong quyen cho AccountID nay, nhung chua dc confirmed
							$withdrawal['ErrorCode'] = 22094;
							break;
						default://default
							$withdrawal['ErrorCode'] = 22134;
							write_my_log_path('CheckConfirmBuyingStock_CutMoney',$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
							break;
					}

				}else{
					$withdrawal['AccountNo'] = $result[0]['varaccountno'];
					$withdrawal['Amount'] = $result[0]['varamount'];
					$withdrawal['Note'] = $result[0]['varnote'];
					$withdrawal['BankID'] = $result[0]['bankid'];
					$withdrawal['AccountBank'] = $result[0]['bankaccount'];
          $withdrawal['StockSymbol'] = $result[0]['stocksymbol'];
					if($withdrawal['Amount'] == '' || $withdrawal['Amount']<=0)
						$withdrawal['ErrorCode'] = 22086;
				}
			}
		}
		return $withdrawal;
	}

	/*
	reportBuyingStockPrivilege
	*/

	/**
	 * Function reportBuyingStockPrivilege	: get list of reportBuyingStockPrivilege
	 * Input 								: EventID, AccountID
	 * OutPut 								: 'FullName', 'ContactAddress', 'CardNo', 'AccountNo', 'IncrementStockQtty', 'StockQtty', 'NormalPrivilegeQtty', 'LimitPrivilegeQtty', 'LastRegistrationDate', 'Price', 'Rate','Symbol', 'ParValue', 'CompanyName', 'IsRound', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate'
	 */
	function reportBuyingStockPrivilege($EventID, $AccountID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'reportBuyingStockPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_ReportBuyingStockPrivilege("%s","%s")', $EventID, $AccountID );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'ContactAddress'  => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
								'CardNo'  => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'IncrementStockQtty'  => new SOAP_Value("IncrementStockQtty", "string", $result[$i]['incrementstockqtty']),
								'StockQtty'  => new SOAP_Value("StockQtty", "string", $result[$i]['stockqtty']),
								'NormalPrivilegeQtty'  => new SOAP_Value("NormalPrivilegeQtty", "string", $result[$i]['normalprivilegeqtty']),
								'LimitPrivilegeQtty'  => new SOAP_Value("LimitPrivilegeQtty", "string", $result[$i]['limitprivilegeqtty']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'ParValue'  => new SOAP_Value("ParValue", "string", $result[$i]['parvalue']),
								'CompanyName'  => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
								'IsRound'  => new SOAP_Value("IsRound", "string", $result[$i]['isround']),
								'BeginTransferDate'  => new SOAP_Value("BeginTransferDate", "string", $result[$i]['begintransferdate']),
								'EndTransferDate'  => new SOAP_Value("EndTransferDate", "string", $result[$i]['endtransferdate'] ),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate'] ),
								'CountryName'  => new SOAP_Value("CountryName", "string", $result[$i]['countryname']),
								'HomePhone'  => new SOAP_Value("HomePhone", "string", $result[$i]['homephone'] ),
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
								'CardNoDate'  => new SOAP_Value("CardNoDate", "string", $result[$i]['cardnodate'] ),
								'CardNoIssuer'  => new SOAP_Value("CardNoIssuer", "string", $result[$i]['cardnoissuer'])
							)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/*
	reportBuyingStockPrivilege
	*/

	/**
	 * Function reportBuyingStockPrivilege_byEvent	: get list of reportBuyingStockPrivilege
	 * Input 								: EventID, AccountID
	 * OutPut 								: 'FullName', 'ContactAddress', 'CardNo', 'AccountNo', 'IncrementStockQtty', 'StockQtty', 'NormalPrivilegeQtty', 'LimitPrivilegeQtty', 'LastRegistrationDate', 'Price', 'Rate','Symbol', 'ParValue', 'CompanyName', 'IsRound', 'BeginTransferDate', 'EndTransferDate', 'BeginRegisterDate', 'EndRegisterDate'
	 */
	function reportBuyingStockPrivilege_byEvent($EventID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'reportBuyingStockPrivilege_byEvent';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_ReportBuyingStockPrivilege_ByEvent("%s")', $EventID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'ContactAddress'  => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
								'CardNo'  => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'IncrementStockQtty'  => new SOAP_Value("IncrementStockQtty", "string", $result[$i]['incrementstockqtty']),
								'StockQtty'  => new SOAP_Value("StockQtty", "string", $result[$i]['stockqtty']),
								'NormalPrivilegeQtty'  => new SOAP_Value("NormalPrivilegeQtty", "string", $result[$i]['normalprivilegeqtty']),
								'LimitPrivilegeQtty'  => new SOAP_Value("LimitPrivilegeQtty", "string", $result[$i]['limitprivilegeqtty']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'ExpireDate'  => new SOAP_Value("ExpireDate", "string", $result[$i]['expiredate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'ParValue'  => new SOAP_Value("ParValue", "string", $result[$i]['parvalue']),
								'CompanyName'  => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
								'IsRound'  => new SOAP_Value("IsRound", "string", $result[$i]['isround']),
								'BeginTransferDate'  => new SOAP_Value("BeginTransferDate", "string", $result[$i]['begintransferdate']),
								'EndTransferDate'  => new SOAP_Value("EndTransferDate", "string", $result[$i]['endtransferdate'] ),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate'] ),
								'CountryName'  => new SOAP_Value("CountryName", "string", $result[$i]['countryname']),
								'HomePhone'  => new SOAP_Value("HomePhone", "string", $result[$i]['homephone'] ),
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone'] ),
								'CardNoDate'  => new SOAP_Value("CardNoDate", "string", $result[$i]['cardnodate'] ),
								'CardNoIssuer'  => new SOAP_Value("CardNoIssuer", "string", $result[$i]['cardnoissuer'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function listEventByUBCKDate	: get list of listEventByUBCKDate
	 * Input 								: TradingDate
	 * OutPut 								:  'EventID', 'Symbol', 'LastRegistrationDate', 'EventTypeName', 'UBCKDate'
	 */
	function listEventByUBCKDate($TradingDate,$condition) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventByUBCKDate';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_GetListEvent_ByUBCKDate("%s","%s")', $TradingDate, $condition );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'EventID'  => new SOAP_Value("EventID", "string", $result[$i]['eventid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function listEventtBuyingStockUBCKDate	: get list of listEventtBuyingStockUBCKDate
	 * Input 								: TradingDate
	 * OutPut 								:  'EventID', 'Symbol', 'LastRegistrationDate', 'EventTypeName', 'UBCKDate'
	 */
	function listEventtBuyingStockUBCKDate($TradingDate) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listEventtBuyingStockUBCKDate';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf('CALL sp_getListEventBuyingStock_UBCKDate("%s")', $TradingDate );

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'EventID'  => new SOAP_Value("EventID", "string", $result[$i]['id']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'LastRegistrationDate'  => new SOAP_Value("LastRegistrationDate", "string", $result[$i]['lastregistrationdate']),
								'EventTypeName'  => new SOAP_Value("EventTypeName", "string", $result[$i]['eventtypename']),
								'UBCKDate'  => new SOAP_Value("UBCKDate", "string", $result[$i]['ubckdate']),
								'BeginTranferDate'  => new SOAP_Value("BeginTranferDate", "string", $result[$i]['begintranferdate']),
								'EndTranferDate'  => new SOAP_Value("EndTranferDate", "string", $result[$i]['endtranferdate']),
								'BeginRegisterDate'  => new SOAP_Value("BeginRegisterDate", "string", $result[$i]['beginregisterdate']),
								'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
								'BeforeEndRegisterDate3Date'  => new SOAP_Value("BeforeEndRegisterDate3Date", "string", $result[$i]['beforeendregisterdate3date']),
								'BeforeEndRegisterDate1Date'  => new SOAP_Value("BeforeEndRegisterDate1Date", "string", $result[$i]['beforeendregisterdate1date']),
								'IsSendMSG'  => new SOAP_Value("IsSendMSG", "string", $result[$i]['issendmsg'])
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function UpdateDividendPrivilege	: delete a UpdateDividendPrivilege
	 * Input 					: 'DividentPrivilegeID', 'NewRetailStockQtty', 'NormalPrivilegeQtty', 'UpdatedBy'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function UpdateDividendPrivilege($DividentPrivilegeID, $NewRetailStockQtty, $NormalPrivilegeQtty, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'UpdateDividendPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($DividentPrivilegeID==''||$DividentPrivilegeID<=0)
			{
				$this->_ERROR_CODE = 22104;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_UpdateDividendPrivilege ('%u','%s','%s','%s')", $DividentPrivilegeID, $NewRetailStockQtty, $NormalPrivilegeQtty, $UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not update
				if(empty($result)|| is_object($result)){
					$withdrawal['ErrorCode'] = 22105;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}
				else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror'] <0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://exception
											$this->_ERROR_CODE = 22106;
											break;

									case '-2'://ID da phan bo
											$this->_ERROR_CODE = 22107;
											break;

									default://deafulr error
											$this->_ERROR_CODE = 22108;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
											break;
								}
							}
						}
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}


	/**
	 * Function UpdateDividendPrivilege	: ListEvent_BuyingStock
	 * Input 					: 'DividentPrivilegeID', 'NewRetailStockQtty', 'NormalPrivilegeQtty', 'UpdatedBy'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function ListEvent_BuyingStock($EventID, $CuttingMoney)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'ListEvent_BuyingStock';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($EventID==''||$EventID<=0)
			{
				$this->_ERROR_CODE = 22114;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_getListEvent_BuyingStock('%s','%s')",$EventID, $CuttingMoney);
				//echo $query;
				$result = $this->_MDB2->extended->getAll($query);
				$num_row = count($result);
				if($num_row>0)
				{
					for($i=0; $i<$num_row; $i++) {
						$this->items[$i] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
									'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
									'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
									'StockQtty'  => new SOAP_Value("StockQtty", "string", $result[$i]['stockqtty']),
									'BuyingQuantity'  => new SOAP_Value("BuyingQuantity", "string", $result[$i]['buyingquantity']),
									'BuyingRegQuantity'  => new SOAP_Value("BuyingRegQuantity", "string", $result[$i]['buyingregquantity']),
									'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
									'BuyingMoney'  => new SOAP_Value("BuyingMoney", "string", $result[$i]['buyingmoney']),
									'AccountBankID'  => new SOAP_Value("AccountBankID", "string", $result[$i]['accountbankid']),
									'CuttingMoneyStatus'  => new SOAP_Value("CuttingMoneyStatus", "string", $result[$i]['cuttingmoneystatus'])
									)
							);
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function listDividendPrivilege_ForSendMSG	: listDividendPrivilege_ForSendMSG
	 * Input 					: 'EventID'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function listDividendPrivilege_ForSendMSG($EventID)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'listDividendPrivilege_ForSendMSG';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($EventID==''||$EventID<=0)
			{
				$this->_ERROR_CODE = 22114;
			}
			 if($this->_ERROR_CODE==0)
			{
				$query = sprintf( "CALL sp_getDividendPrivilege_ForSendMSG('%s')",$EventID);
				//echo $query;
				$result = $this->_MDB2->extended->getAll($query);
				$num_row = count($result);
				if($num_row>0)
				{
					for($i=0; $i<$num_row; $i++) {
						$this->items[$i] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
									'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
									'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
									'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']),
									'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['stocksymbol']),
									'EndRegisterDate'  => new SOAP_Value("EndRegisterDate", "string", $result[$i]['endregisterdate']),
									'BeforeEndRegisterDate1Date'  => new SOAP_Value("BeforeEndRegisterDate1Date", "string", $result[$i]['beforeendregisterdate1date']),
									'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount'])
									)
							);
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getTotalBlockedQuantityWithoutConfirmed($AccountNo, $StockID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getTotalBlockedQuantityWithoutConfirmed';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "SELECT f_UnblockedHistory_TotalBlockedQttyWithoutConfirmed('%s', %u) AS Quantity", $AccountNo, $StockID);
			$result = $this->_MDB2->extended->getRow($query);
			$num_row = count($result);
			if($num_row>0) {
				$this->items[0] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'Quantity'  => new SOAP_Value("Quantity", "string", $result['quantity'])
							)
					);
			}

		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertWithoutConfirmed($AccountNo, $StockID, $Quantity, $UnblockedDate, $Note, $CreatedBy) {
		try{
			$class_name = $this->class_name;
			$function_name = 'insertWithoutConfirmed';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "CALL sp_UnblockedHistory_insertWithoutConfirmed('%s', %u, %u, '%s', '%s', '%s') ", $AccountNo, $StockID, $Quantity, $UnblockedDate, $Note, $CreatedBy );
			$rs = $this->_MDB2->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 22200;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 22201;
							break;

						case '-2':
							$this->_ERROR_CODE = 22202;
							break;

						case '-3':
							$this->_ERROR_CODE = 22203;
							break;

						case '-4':
							$this->_ERROR_CODE = 22204;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				} else {
					//insert Buy Order Successfully
					$this->items[0] = new SOAP_Value(
							'item',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result )
								)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteWithoutConfirmed($ID, $UpdatedBy) {
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteWithoutConfirmed';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "CALL sp_UnblockedHistory_deleteWithoutConfirmed(%u, '%s') ", $ID, $UpdatedBy);
			$rs = $this->_MDB2->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 22205;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 22206;
							break;

						case '-2':
							$this->_ERROR_CODE = 22207;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function confirmUnblockedHistory($ID, $UpdatedBy) {
		try{
			$class_name = $this->class_name;
			$function_name = 'confirmUnblockedHistory';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "CALL sp_UnblockedHistory_confirm(%u, '%s') ", $ID, $UpdatedBy);
			$rs = $this->_MDB2->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 22210;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 22211;
							break;

						case '-2':
							$this->_ERROR_CODE = 22212;
							break;

						case '-3':
							$this->_ERROR_CODE = 22213;
							break;

						case '-4':
							$this->_ERROR_CODE = 22214;
							break;

						case '-5':
							$this->_ERROR_CODE = 22215;
							break;

						case '-6':
							$this->_ERROR_CODE = 22216;
							break;

						case '-7':
							$this->_ERROR_CODE = 22217;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function listUnblockedHistory($AccountNo, $IsConfirmed, $CreatedBy, $FromDate, $ToDate) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listUnblockedHistory';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			 if($this->_ERROR_CODE == 0) {
				$query = sprintf( "CALL sp_UnblockedHistory_getList('%s', '%s', '%s', '%s', '%s')", $AccountNo, $IsConfirmed, $CreatedBy, $FromDate, $ToDate);
				$result = $this->_MDB2->extended->getAll($query);
				$num_row = count($result);
				if($num_row>0) {
					for($i=0; $i<$num_row; $i++) {
						$this->items[$i] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
									'ID'  => new SOAP_Value("ID", "string", $result[$i]['id']),
									'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
									'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
									'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
									'UnblockedDate'  => new SOAP_Value("UnblockedDate", "string", $result[$i]['unblockeddate']),
									'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
									'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
									'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
									'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
									'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
									'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
									'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['stocksymbol']),
									)
							);
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function SendSMS_BuyingStockForDividend	: SendSMS_BuyingStockForDividend
	 * Input 					: 'EventID'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function SendSMS_BuyingStockForDividend($EventID, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'SendSMS_BuyingStockForDividend';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($EventID==''||$EventID<=0)
			{
				$this->_ERROR_CODE = 22114;
			}
			 if($this->_ERROR_CODE==0)
			{
				$query = sprintf( "CALL sp_getDividendPrivilege_ForSendMSG('%s')",$EventID);
				$result = $this->_MDB2->extended->getAll($query);
				$num_row = count($result);
				if($num_row>0)
				{
					for($i=0; $i<$num_row; $i++) {
						if($result[$i]['mobilephone']!=''){
							$array_SMS = array('Phone'=>$result[$i]['mobilephone'],
							'Content'=>'EPS thong bao den khach hang han chot dang ky mua va dong tien cua co phieu '.$result[$i]['stocksymbol'].' la ngay '.$result[$i]['endregisterdate'].'. EPS se tien hanh cat tien ngay '.$result[$i]['beforeendregisterdate1date'].' va ngay '.$result[$i]['endregisterdate']);
							$ok=sendSMS($array_SMS);
							write_my_log_path($function_name,'Su kien '.$EventID.' Send to '.$array_SMS['Phone'].' '.$array_SMS['Content'].' '.date('Y-m-d h:i:s'),SMS_PATH);
						}
					}
				}
				$query = sprintf( "CALL sp_updateEvent_IsSendMSG('%s','%s')",$EventID, $UpdatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not update
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22123;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
					if(isset($result[0]['varerror']))
					{
						if($result[0]['varerror'] <0){
							switch ($result[0]['varerror']) {
								case '0'://sucess
										$this->_ERROR_CODE = 0;
										break;
								case '-1'://exception
										$this->_ERROR_CODE = 22124;
										break;

								case '-2':// ko ton tai EventId
										$this->_ERROR_CODE = 22125;
										break;

								default://deafulr error
										$this->_ERROR_CODE = 22126;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function DeleteDividendPrivilege	: SendSMS_BuyingStockForDividend
	 * Input 					: 'EventID'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function DeleteDividendPrivilege($EventID, $AccountNo, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'DeleteDividendPrivilege';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($EventID==''||$EventID<=0)
			{
				$this->_ERROR_CODE = 22114;
			}else if($AccountNo=='')
			{
				$this->_ERROR_CODE = 22115;
			}
			 if($this->_ERROR_CODE==0)
			{
				$query = sprintf( "CALL sp_DeleteDividendPrivilege('%s', '%s', '%s')", $EventID, $AccountNo, $UpdatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not update
				if(empty($result)|| is_object($result)){
					$this->_ERROR_CODE = 22127;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
				}else{
					if(isset($result[0]['varerror']))
					{
						if($result[0]['varerror'] <0){
							switch ($result[0]['varerror']) {
								case '0'://sucess
										$this->_ERROR_CODE = 0;
										break;
								case '-1'://exception
										$this->_ERROR_CODE = 22128;
										break;

								case '-2':// ko ton tai EventId
										$this->_ERROR_CODE = 22129;
										break;

								case '-3':// ko ton tai AccountID
										$this->_ERROR_CODE = 22130;
										break;

								case '-4':// ko ton tai (event, account) trong dividend_privilege ; hoac (event, account) da cat tien roi
										$this->_ERROR_CODE = 22131;
										break;
								case '-5':// ngay hien tai nho hon ngay dang ky cuoi cung
										$this->_ERROR_CODE = 22148;
										break;
								default://deafulr error
										$this->_ERROR_CODE = 22132;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
										break;
							}
						}
					}
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertDivident($AccountID, $BankID, $Amount, $DepositDate, $Note, $CreatedBy) {
		$function_name = 'insertDivident';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID)|| !required($BankID) || !unsigned($BankID) || !required($Amount) || !unsigned($Amount) || !required($DepositDate) ) {
			if ( !required($AccountID) || !unsigned($AccountID))
				$this->_ERROR_CODE = 22221;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 22222;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 22223;

			if ( !required($DepositDate) )
				$this->_ERROR_CODE = 22224;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_insertDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Amount, $DepositDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 22225;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 22226;
							break;

						case '-2':
							$this->_ERROR_CODE = 22227;
							break;

						case '-3':
							$this->_ERROR_CODE = 22228;
							break;

						case '-4':
							$this->_ERROR_CODE = 22229;
							break;

						case '-9':
							$this->_ERROR_CODE = 22220;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertBuyingStockDivident($AccountID, $BankID, $Amount, $DepositDate, $Note, $CreatedBy) {
		$function_name = 'insertBuyingStockDivident';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID)|| !required($BankID) || !unsigned($BankID) || !required($Amount) || !unsigned($Amount) || !required($DepositDate) ) {
			if ( !required($AccountID) || !unsigned($AccountID))
				$this->_ERROR_CODE = 22230;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 22231;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 22232;

			if ( !required($DepositDate) )
				$this->_ERROR_CODE = 22233;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_insertBuyingStockDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Amount, $DepositDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 22234;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 22235;
							break;

						case '-2':
							$this->_ERROR_CODE = 22236;
							break;

						case '-3':
							$this->_ERROR_CODE = 22237;
							break;

						case '-4':
							$this->_ERROR_CODE = 22238;
							break;

						case '-5':
							$this->_ERROR_CODE = 22239;
							break;

						case '-9':
							$this->_ERROR_CODE = 22240;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

  /**
   * (Function nay chi khac updateStockMoneyForDividend o cho tham so $Note - Tao ngay 20100712, request ngay 20100709)
   * Function updateStockMoneyForDividend_ForTraiPhieu : ke toan cap nhat tien, (cap nhat tien tu cp le la 1 form khac cua ke toan)
   * Input          : $EventID, $AccountID, $Today, $UpdatedBy
   * OutPut           : error code. Return 0 if success else return error code (number >0).
   */
  function updateStockMoneyForDividend_ForTraiPhieu($EventID, $AccountID, $Today, $UpdatedBy, $Note)
  {
    try{
      $class_name = $this->class_name;
      $function_name = 'updateStockMoneyForDividend_ForTraiPhieu';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
      if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
      if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

      if($this->_ERROR_CODE == 0)
      {
        $Deposit = $this->CheckUpdateStockQuantity_Bravo($EventID, $AccountID, $Today);
        if($Deposit['ErrorCode']=='0')
        {
          // money in bank
          $query = sprintf( "SELECT BankID, BankAccount,BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' ORDER BY Priority Limit 1", $AccountID);
          $this->_MDB2->disconnect();
          $this->_MDB2->connect();
          $bank_rs = $this->_MDB2->extended->getAll($query);
          $dab_rs = 999;
          $BankID = 0;
          $TransactionType = BRAVO_DIVIDENT_C;// Co tuc cho khach hang
          if ( $Deposit['AccountNo'] != PAGODA_ACCOUNT ) {
              $i =0;
              $BankID = $bank_rs[$i]['bankid'];
              $BravoCode = $bank_rs[$i]['bravocode'];
              switch ($BankID) {
                case DAB_ID:
                  $dab = &new CDAB();
                  $dab_rs = $dab->transferfromEPS($bank_rs[$i]['bankaccount'],$Deposit['AccountNo'], '2_'.$EventID.'_'.$AccountID, $Deposit['Amount'], $Note);
                  write_my_log_path('transferfromEPS',$function_name.' BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Deposit['AccountNo'].'  Event_AccountID '.'2_'.$EventID.' '.$AccountID.'  Amount '.$Deposit['Amount']." Description " . $Note . ' Error '.$dab_rs,EVENT_PATH);
                  break;

                case OFFLINE:
                  $mdb2 = initWriteDB();
                  $query = sprintf( "CALL sp_VirtualBank_insertDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Deposit['Amount'], $Today, $Note, $UpdatedBy);
                  $rs = $mdb2->extended->getRow($query);
                  $mdb2->disconnect();
                  $dab_rs = $rs["varerror"];
                  break;

                default:
                  $dab_rs = 0;

              }
          } else {
            $TransactionType = BRAVO_DIVIDENT_P; // Co tuc cho tu doanh
            $dab_rs = 0;
            $BankID = EXI_ID;
          }
          if($dab_rs == 0){
            if($BankID == OFFLINE){
            	$query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Deposit['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $Deposit['Amount'], 0, '.', ',' ) . '. ' . $Note;
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'updateStockMoneyForDividend_ForTraiPhieu');
              }
            }

            $soap = &new Bravo();
            $Deposit_value = array("TradingDate"      => $Today,
                                   'TransactionType'  => $TransactionType,
                                   "AccountNo"        => $Deposit['AccountNo'],
                                   "Amount"           => $Deposit['Amount'],
                                   "Bank"             => $BravoCode,
                                   "Branch"           => "",
                                   "Note"             => $Note); //'011C001458'
            //var_dump($withdraw_value);
            $ret = $soap->deposit($Deposit_value);
            if($ret['table0']['Result']==1){
              $query = sprintf( "CALL sp_updateQuantityStockMoney_inDivident  ('%s','%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $Today, $UpdatedBy);
              //echo $query;
              $result = $this->_MDB2_WRITE->extended->getAll($query);
              //Can not delete
              if(empty($result) || is_object($result)){
                 $this->_ERROR_CODE = 22060;
                 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
              }
              else{
                if(isset($result[0]['varerror']))
                {
                  if($result[0]['varerror'] <0){
                    switch ($result[0]['varerror']) {
                      case 0:
                        $this->_ERROR_CODE =0;
                        break;
                      case -2://Invalid EventID
                        $this->_ERROR_CODE = 22042;
                        break;
                      case -3://Invalid AccountID
                        $this->_ERROR_CODE = 22005;
                        break;
                      case -5:/*loi khi insert vao bang money_history*/
                        $this->_ERROR_CODE = 22028;
                        break;
                      case -6:/*invalid tradingdate*/
                        $this->_ERROR_CODE = 22073;
                        break;
                      case -7:/*(Account&Event) nay da duoc phan bo tien hoac chua duoc moi gioi phan bo cp*/
                        $this->_ERROR_CODE = 22146;
                        break;
                      case -1://Exception
                        $this->_ERROR_CODE = 22081;
                        break;
                      default://default
                        $this->_ERROR_CODE = 22134;
                        write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
                        break;
                    }
                  }
                }
              }
              if($this->_ERROR_CODE!=0 && $Deposit['Amount']>0){
                $soap->rollback($ret['table1']['Id'], $Today);
              }
            }else{
              switch ($ret['table0']['Result']) {
                case 0:
                  $this->_ERROR_CODE =0;
                  break;
                case -2://Error - bravo
                  $this->_ERROR_CODE = 23002;
                  break;
                case -1://Invalid key
                  $this->_ERROR_CODE = 23003;
                  break;
                case -13:/*Invalid Transaction Type*/
                  $this->_ERROR_CODE = 23006;
                  break;
                case -15:/*Invalid CustomerCode*/
                  $this->_ERROR_CODE = 23005;
                  break;
                case -16:/*Invalid DestCustomerCode*/
                  $this->_ERROR_CODE = 23004;
                  break;
                default://Unknown Error
                  $this->_ERROR_CODE = 23009;
                  write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
                  break;
              }
            }
          }else{
            switch ($dab_rs) {
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
                $this->_ERROR_CODE = 22139;

            }
          }
        }else{
          $this->_ERROR_CODE = $Deposit['ErrorCode'];
        }
      }
    }catch(Exception $e){
      write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
      $this->_ERROR_CODE = 23022;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  /**
   * (Function nay chi khac updateBalanceForDividend o cho tham so $Note - Tao ngay 20100712, request ngay 20100709)
   * Function updateBalanceForDividend_ForTraiPhieu  : updateBalanceForDividend phan bo co tuc = tien cho khach hang -- ke toan
   * Input          : $EventID, $AccountID, $Today, $UpdatedBy, $Note
   * OutPut           : error code. Return 0 if success else return error code (number >0).
   */
  function updateBalanceForDividend_ForTraiPhieu($EventID, $AccountID, $Today, $UpdatedBy, $Note)
  {
    try{
      $class_name = $this->class_name;
      $function_name = 'updateBalanceForDividend_ForTraiPhieu';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
      if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
      if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;

      if($this->_ERROR_CODE == 0)
      {
        $Deposit = $this->CheckUpdateBalance($EventID, $AccountID, $Today);

        if($Deposit['ErrorCode']=='0')
        {
          // money in bank
          $query = sprintf( "SELECT BankID, BankAccount,BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' ORDER BY Priority Limit 1", $AccountID);
          $this->_MDB2->disconnect();
          $this->_MDB2->connect();
          $bank_rs = $this->_MDB2->extended->getAll($query);
          $dab_rs = 999;
          $BankID = 0;
          $TransactionType = BRAVO_DIVIDENT_C;// Co tuc cho khach hang
          if ( $Deposit['AccountNo'] != PAGODA_ACCOUNT ) {
            // khong phai ngan hang DA thi cap nhat bankid de ke toan tu thu no, con la DA thi goi ham chuyen tien cho khach hang va cap nhat bankID
              $i =0;
              $BankID = $bank_rs[$i]['bankid'];
              $BravoCode = $bank_rs[$i]['bravocode'];
              switch ($BankID) {
                case DAB_ID:
                  $dab = &new CDAB();
                  $dab_rs = $dab->transferfromEPS($bank_rs[$i]['bankaccount'],$Deposit['AccountNo'], '1_'.$EventID.'_'.$AccountID, $Deposit['Amount'], $Note);
                  write_my_log_path('transferfromEPS','updateBalanceForDividend BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Deposit['AccountNo'].'  Event_AccountID '.'1_'.$EventID.' '.$AccountID.'  Amount '.$Deposit['Amount'].'  Description ' . $Note .' Error '.$dab_rs,EVENT_PATH);
                  break;

                case OFFLINE:
                  $mdb2 = initWriteDB();
                  $query = sprintf( "CALL sp_VirtualBank_insertDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Deposit['Amount'], $Today, $Note, $UpdatedBy);
                  $rs = $mdb2->extended->getRow($query);
                  $mdb2->disconnect();
                  $dab_rs = $rs["varerror"];
                  break;

                default:
                  $dab_rs = 0;
              }

          } else {
            $TransactionType = BRAVO_DIVIDENT_P; // Co tuc cho tu doanh
            $dab_rs = 0;
            $BankID = EXI_ID;
          }
          if($dab_rs == 0){
            if($BankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Deposit['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $Deposit['Amount'], 0, '.', ',' ) . '. ' . $Note;
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'updateBalanceForDividend_ForTraiPhieu');
              }
            }

            $soap = &new Bravo();
            // chuyen dl qua cho Bravo
            $Deposit_value = array("TradingDate" => $Today, 'TransactionType'=>$TransactionType, "AccountNo" => $Deposit['AccountNo'], "Amount" => $Deposit['Amount'], "Bank"=> $BravoCode, "Branch"=> "", "Note" => $Note);
            //var_dump($withdraw_value);
            $ret = $soap->deposit($Deposit_value);
            if($ret['table0']['Result']==1){
              $query = sprintf( "CALL sp_updateBalanceMoney_inDivident ('%s','%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $Today, $UpdatedBy);
              //echo $query;
              $result = $this->_MDB2_WRITE->extended->getAll($query);
              //Can not delete
              if(empty($result) || is_object($result)){
                 $this->_ERROR_CODE = 22060;
                 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
              }
              else{
                  if(isset($result[0]['varerror']))
                  {
                    if($result[0]['varerror'] <0){
                      switch ($result[0]['varerror']) {
                        case 0://Invalid EventID
                          $this->_ERROR_CODE = 0;
                          break;
                        case -2://Invalid EventID
                          $this->_ERROR_CODE = 22042;
                          break;
                        case -3://Invalid AccountID
                          $this->_ERROR_CODE = 22005;
                          break;
                        case -4://Loi khi insert vao money history
                          $this->_ERROR_CODE = 22061;
                          break;
                        case -5://Invalid TradingDate
                          $this->_ERROR_CODE = 22073;
                          break;
                        case -6://BOS chua xac nhan su kien eventstastus<>2
                          $this->_ERROR_CODE = 22133;
                          break;
                        default:
                          $this->_ERROR_CODE = 22134;
                          write_my_log_path($function_name ,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
                      }
                    }
                  }
                }
              if($this->_ERROR_CODE!=0){
                // co loi thi rollback Bravo
                $soap->rollback($ret['table1']['Id'], $Today);
              }
            }else{
              switch ($ret['table0']['Result']) {
                case 0:
                  $this->_ERROR_CODE =0;
                  break;
                case -2://Error - bravo
                  $this->_ERROR_CODE = 23002;
                  break;
                case -1://Invalid key
                  $this->_ERROR_CODE = 23003;
                  break;
                case -13:/*Invalid Transaction Type*/
                  $this->_ERROR_CODE = 23006;
                  break;
                case -15:/*Invalid CustomerCode*/
                  $this->_ERROR_CODE = 23005;
                  break;
                case -16:/*Invalid DestCustomerCode*/
                  $this->_ERROR_CODE = 23004;
                  break;
                default://Unknown Error
                  $this->_ERROR_CODE = 23009;
                  write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
                  break;
              }
            }
          }else{
            switch ($dab_rs) {
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
                $this->_ERROR_CODE = 22139;
            }
          }
        }else{
          $this->_ERROR_CODE = $Deposit['ErrorCode'];
        }
      }
    }catch(Exception $e){
      write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
      $this->_ERROR_CODE = 23022;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  /**
   * (Function nay chi khac ConfirmBuyingStockForDividend_CutMoney o cho tham so $Note - Tao ngay 20100712, request ngay 20100709)
   * Function ConfirmBuyingStockForDividend_CutMoney_ForTraiPhieu  : Ke toan cat tien -- day dl qua Bravo -- cap nhat bankid khi cat tien thanh cong
   * Input            : $EventID, $AccountID, $Today, $UpdatedBy, $Note
   * OutPut           : error code. Return 0 if success else return error code (number >0).
   */
  function ConfirmBuyingStockForDividend_CutMoney_ForTraiPhieu($EventID, $AccountID, $UpdatedBy, $Today, $BankID, $Note)
  {
    try{
      $class_name = $this->class_name;
      $function_name = 'ConfirmBuyingStockForDividend_CutMoney_ForTraiPhieu';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

      if(!required($EventID)||!numeric($EventID)) $this->_ERROR_CODE = 22042;
      if($this->_ERROR_CODE == 0 && (!required($AccountID)||!numeric($AccountID))) $this->_ERROR_CODE = 22005;
      if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 22056;
      if($this->_ERROR_CODE == 0)
      {
        $Withdrawal = $this->CheckConfirmBuyingStock_CutMoney($EventID, $AccountID, $Today);
        if($Withdrawal['ErrorCode']=='0')
        {
          // money in bank
          $query = sprintf( "SELECT BankID, BankAccount, BravoCode FROM vw_ListAccountBank_Detail WHERE AccountID='%s' AND BankID ='%s' ", $AccountID, $BankID);
          $this->_MDB2->disconnect();
          $this->_MDB2->connect();
          $bank_rs = $this->_MDB2->extended->getAll($query);
          $dab_rs = 999;
          $BankID = 0;
          $TransactionType = BRAVO_BUYING_STOCK;// phat hanh them cp
          if ($Withdrawal['AccountNo'] != PAGODA_ACCOUNT ) {
            if(count($bank_rs)>0){
              $i =0;
              $BankID = $bank_rs[$i]['bankid'];
              $BravoCode = $bank_rs[$i]['bravocode'];
              switch ($BankID) {
                case DAB_ID:
                  $dab = &new CDAB();
                  $dab_rs = $dab->transfertoEPS($bank_rs[$i]['bankaccount'],$Withdrawal['AccountNo'], '3_'.$EventID.'_'.$AccountID, $Withdrawal['Amount'], $Note);
                  write_my_log_path('transfertoEPS',$function_name.' BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$Withdrawal['AccountNo'].'  Event_AccountID '.'3_'.$EventID.' '.$AccountID.'  Amount '.$Withdrawal['Amount'].' Description ' . $Note .' Error '.$dab_rs,EVENT_PATH);
                  break;

                case OFFLINE:
                  $mdb2 = initWriteDB();
                  //`sp_VirtualBank_insertBuyingStockDivident`(inAccountID bigint, inBankID int, inAmount double,inTransactionDate date, inNote text(1000), inCreatedBy varchar(100))
                  $query = sprintf( "CALL sp_VirtualBank_insertBuyingStockDivident(%u, %u, %f, '%s', '%s', '%s' )", $AccountID, $BankID, $Withdrawal['Amount'], $Today, $Note, $UpdatedBy);
                  $rs = $mdb2->extended->getRow($query);
                  $mdb2->disconnect();
                  $dab_rs = $rs["varerror"];
                  break;

                default:
                  $dab_rs = 0;

              }
            }else{
              $dab_rs = 9999;
              $this->_ERROR_CODE = 22155;//TK k co TK Ngan hang nay
            }
          } else {
            $TransactionType = BRAVO_BUYING_STOCK; // phat hanh them cp
            $dab_rs = 0;
            $BankID = EXI_ID;
          }
          if($dab_rs == 0){
            if($BankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $Withdrawal['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: -' . number_format( $Withdrawal['Amount'], 0, '.', ',' ) . '. ' . $Note;
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'ConfirmBuyingStockForDividend_CutMoney_ForTraiPhieu');
              }
            }

            $soap = &new Bravo();
            $Withdrawal_value = array("TradingDate" => $Today, 'TransactionType'=>$TransactionType, "AccountNo" => $Withdrawal['AccountNo'], "Amount" => $Withdrawal['Amount'], "Bank"=> $BravoCode, "Branch"=> "", "Note" => $Note); //'011C001458'
            //var_dump($withdraw_value);
            $ret = $soap->withdraw($Withdrawal_value);
            if($ret['table0']['Result']==1){

              $query = sprintf( "CALL sp_UpdateDividendPrivilege_BankID ('%s','%s','%s','%s')", $BankID, $EventID, $AccountID, $UpdatedBy);
              //echo $query;
              $result = $this->_MDB2_WRITE->extended->getAll($query);
              //Can not update
              if(empty($result) || is_object($result)){
                 $this->_ERROR_CODE = 22120;
                 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],EVENT_PATH);
              }
              else{
                if(isset($result[0]['varerror']))
                {
                  //p_iDividentPrivilege sai hoac dang ky mua chua xac nhan hoac da cat tien roi
                  if($result[0]['varerror'] == -2){
                     $this->_ERROR_CODE = 22121;
                  }else if($result[0]['varerror'] == -3){
                  //qua ngay cat tien
                     $this->_ERROR_CODE = 22149;
                  }else if($result[0]['varerror'] == -1){
                  //Exception
                     $this->_ERROR_CODE = 22122;
                  }else if($result[0]['varerror']<0){
                    $this->_ERROR_CODE = 22134;
                    write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],EVENT_PATH);
                  }
                }
              }
              if($this->_ERROR_CODE!=0){
                $soap->rollback($ret['table1']['Id'], $Today);
              }
            }else{
              switch ($ret['table0']['Result']) {
                case 0:
                  $this->_ERROR_CODE =0;
                  break;
                case -2://Error - bravo
                  $this->_ERROR_CODE = 23002;
                  break;
                case -1://Invalid key
                  $this->_ERROR_CODE = 23003;
                  break;
                case -13:/*Invalid Transaction Type*/
                  $this->_ERROR_CODE = 23006;
                  break;
                case -15:/*Invalid CustomerCode*/
                  $this->_ERROR_CODE = 23005;
                  break;
                case -16:/*Invalid DestCustomerCode*/
                  $this->_ERROR_CODE = 23004;
                  break;
                default://Unknown Error
                  $this->_ERROR_CODE = 23009;
                  write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],EVENT_PATH);
                  break;
              }
            }
          }else{
            switch ($dab_rs) {
              case '-1'://unauthenticate partner
                $this->_ERROR_CODE = 22135;
                break;

              case '-2'://invalid parameters
                $this->_ERROR_CODE = 22136;
                break;

              case '-3'://invalid date
                $this->_ERROR_CODE = 22137;
                break;

              case '-12': // Tai khoan khong ton tai
                $this->_ERROR_CODE = 12001;
                break;

              case '-4'://no customer found
                $this->_ERROR_CODE = 22140;
                break;

              case '-5'://transfer unsuccessful
                $this->_ERROR_CODE = 22141;
                break;

              case '-13':
              case '1'://invalid account
                $this->_ERROR_CODE = 22142;
                break;

              case '2'://invalid amount
                $this->_ERROR_CODE = 22143;
                break;

              case '3'://duplicate transfer
                $this->_ERROR_CODE = 22147;
                break;

              case '-14':
              case '5'://not enough balance
                $this->_ERROR_CODE = 22144;
                break;

              case '6'://duplicate account
                $this->_ERROR_CODE = 22145;
                break;

              case '-15'://can not add history transaction
                $this->_ERROR_CODE = 22228;
                break;

              case '-11':
              case '99'://unknown error
                $this->_ERROR_CODE = 22138;
                break;

              default:
                $this->_ERROR_CODE = 22139;

            }
          }


        }else{
          $this->_ERROR_CODE = $Withdrawal['ErrorCode'];

        }
      }
    }catch(Exception $e){
      write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
      $this->_ERROR_CODE = 23022;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function writeNewFile($fileName, $content){
        $handle = fopen($fileName, 'a+');
        fwrite($handle, $content);
    fclose($handle);
}

?>
