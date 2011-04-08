<?php
require_once('../includes.php');
require_once 'XML/Query2XML.php';
require_once 'XML/Query2XML/ISO9075Mapper.php';
define("DAB_FILE_PATH", "/home/vhosts/eSMSstorage/bank/dab/");
define('NVB_FILE_PATH','/home/vhosts/eSMSstorage/bank/nvb/result/');
define('NVB_RESULT_FILE_PATH','/home/vhosts/eSMSstorage/bank/nvb/result/');

/**
	Author: Ly Duong Duy Trung
	Created date: 05/30/2007
*/
class CExchange extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	
	function __construct($check_ip) {
		//initialize MDB2
		$this->_MDB2 = initDB();
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		$this->class_name = get_class($this);
		$this->items = array();

		$arr = array( 
							'insertOrderTemp' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderStyleID', 'MatchedQuantity', 'OrderSideName', 'StockExchangeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'OrderTempID' )),

							'insertStockDetail' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'AccountID', 'StockID', 'MatchedQuantity', 'MatchedPrice', 'OrderSideID', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
											'output' => array( 'StockDetailID' )),

							'insertSellingOrderForTransactionExecute' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'Note', 'StockExchangeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertBuyingOrderForTransactionExecute' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'Note', 'StockExchangeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertBuyingOrderForTransactionExecuteWithoutBlockingMoney' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'Note', 'StockExchangeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertBuyingOrderForTransactionExecuteWithReservingMoney' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'Note', 'StockExchangeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertStockDetailOnline' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertStockDetailForExecuteTransaction' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'insertStockDetailForKLDK' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'updateOrderTemp' => array( 'input' => array( 'ID', 'AccountNo', 'OrderQuantity', 'OrderStyleID', 'Price' ),
											'output' => array( )),

							'executeStockOfBuyingDeal' => array( 'input' => array( 'ID', 'UpdatedBy' ),
											'output' => array( )),

							'executeStockOfSellingDeal' => array( 'input' => array( 'ID', 'UpdatedBy' ),
											'output' => array( )),

							'executeMoneyForSellingTransaction' => array( 'input' => array( 'TradingDate', 'UpdatedBy' ),
											'output' => array( )),

							'executeMoneyForBuyingTransaction' => array( 'input' => array( 'TradingDate', 'UpdatedBy' ),
											'output' => array( )),

							'executeMoneyForBuyingTransactionOfAccount' => array( 'input' => array( 'AccountID', 'AmountMoney', 'TradingDate', 'Updatedby' ),
											'output' => array( )),

							'executeEndTransaction' => array( 'input' => array( 'TradingDate' ),
											'output' => array( )),

							'confirmMatchedAgencyFee' => array( 'input' => array( 'TradingDate' ),
											'output' => array( )),

							'updateStockDetail' => array( 'input' => array( 'ID', 'OrderNumber', 'AccountNo', 'MatchedQuantity', 'UpdatedBy' ),
											'output' => array( )),

							'editBuyingOrderWhenExecTransaction' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'OrderStyleID', 'AccountNo', 'UpdatedBy' ),
											'output' => array( )),

							'editSellingOrderWhenExecTransaction' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'OrderStyleID', 'UpdatedBy' ),
											'output' => array( )),

							'listWarningOrderTemp' => array( 'input' => array( 'TradingDate','StockExchangeID' ),
											'output' => array( 'OrderTempID', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderStyleName', 'OrderDate', 'ExchangeName', 'StockExchangeID', 'OrderSideID', 'OrderStyleID', 'MatchedQuantity', 'Value' )),

							'getPrivateStockDetailWithoutConfirmList' => array( 'input' => array( 'OrderNumber', 'TradingDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID', 'OrderSideID' )),

							'getStockDetailWithoutConfirmList' => array( 'input' => array( 'OrderDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'TradingDate', 'StockExchangeID', 'OrderSideID', 'Note' )),

							'getOrderWithoutOrderNumberList' => array( 'input' => array( 'OrderDate', 'StockExchangeID' ),
											'output' => array( 'ID', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'StatusName', 'OrderStyleName', 'FromName', 'StockExchangeID' )),

							'getStockDetailWithConfirmList' => array( 'input' => array( 'OrderDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'OrderSide', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'MatchedAgencyFee', 'Note', 'StockExchangeID' )),

							'getFullStockDetailWithConfirmList' => array( 'input' => array( 'OrderDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'OrderSide', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'MatchedAgencyFee', 'MatchedValue', 'Commission', 'LogMoney', 'TMoney', 'StockExchangeID' )),

							'getReportStockList' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'Symbol', 'Mua', 'Ban' )),

							'getStockDetailWithoutExecAgencyFeeList' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID', 'OrderSideID' )),

							'getStockDetailAfterExecMoney' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'ID', 'ConfirmNo', 'OrderNumber', 'OrderSide', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'MatchedAgencyFee',  'Note', 'StockExchangeID' )),

							'checkOrderIsWarningOrNormal' => array( 'input' => array( 'OrderTempID' ),
											'output' => array( )),

							'getNextOrderNumber' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'OrderNumber' )),

							'getNextConfirmNo' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'ConfirmNo' )),

							'getAccountWithBuyingTransactionList' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'AccountID', 'AccountNo', 'AmountMoney' )),

							'getAuctionForXML' => array( 'input' => array( 'OrderDate', 'BankID' ),
											'output' => array( 'FileName' )),

							'getAllSellForXML' => array( 'input' => array( 'OrderDate', 'BankID' ),
											'output' => array( 'FileName' )),

							'getAllCancelBidForXML' => array( 'input' => array( 'OrderDate', 'BankID' ),
											'output' => array( 'FileName' )),

							'getDABLockMoneyFile' => array( 'input' => array(),
											'output' => array( 'FileContent' )),

							'DABgetListOrderInfo' => array( 'input' => array( 'OrderDate' ),
											'output' => array( 'OrderID', 'AccountNo', 'Value' )),

							'DABgetResultFile' => array( 'input' => array( 'FileName' ),
											'output' => array( 'FileContent' )),

							'CheckTransaction' => array( 'input' => array(  ),
											'output' => array( )),

							'getBuyInfo' => array( 'input' => array( 'OrderDate' ),
											'output' => array( "AccountNo", "Amount" )),

							'getBuyInfoForChecking' => array( 'input' => array( ),
											'output' => array( "AccountNo", "LogMoney" )),

							'getSellInfo' => array( 'input' => array( 'OrderDate' ),
											'output' => array( "AccountNo", "Amount" )),

							'getSellInfoForChecking' => array( 'input' => array( ),
											'output' => array( "AccountNo", "TMoney" )),

							'getBuyInfoForBravo' => array( 'input' => array( 'OrderDate'),
											'output' => array( "AccountNo", "Amount", "Fee", "BranchName" )),

							'getSellInfoForBravo' => array( 'input' => array( 'OrderDate'),
											'output' => array( "AccountNo", "Amount", "Fee", "BranchName" )),

							'getBuyInfoForBravoChecking' => array( 'input' => array( ),
											'output' => array( "AccountNo", "LogMoney" )),

							'getSellInfoForBravoChecking' => array( 'input' => array( ),
											'output' => array( "AccountNo", "TMoney" )),

							'editMoney' => array( 'input' => array( 'OrderID', 'NewValue' ),
											'output' => array( )),

							'cutMoney' => array( 'input' => array( 'OrderID'),
											'output' => array( )),

							'insertMissingDeal' => array( 'input' => array( 'OrderNumber', 'AccountNo', 'Symbol', 'StockExchangeID', 'Quantity', 'Price', 'OrderSideID', 'Session', 'TradingDate', 'Note', 'CreatedBy' ),
											'output' => array( 'OrderID' )),

							'getOrderListToEditOrAuction' => array( 'input' => array( 'OrderID', 'AccountNo'),
											'output' => array( 'ID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Note', 'OrderSide' )),

							'getMoneyBeforeCutting' => array( 'input' => array( 'OrderID'),
											'output' => array( 'TotalAmount' )),

							'calculateAveragePrices' => array( 'input' => array( ),
											'output' => array( )),
							/* 04/07/2008  Chi */
							'getOrderTempMissingList' => array( 'input' => array( 'OrdeDate', 'IsValid', 'StockExchangeID'),
											'output' => array( 'OrderID', 'OrderNumber', 'Symbol', 'AccountNo', 'OrderQuantity', 'OrderPrice', 'OrderSideName', 'OrderStyleID', 'OrderStyleName', 'StockExchangeID', 'StockExchange', 'OrderMissingStatus' )),
											
							'updateOrderTempMissing' => array( 'input' => array( 'OrderID', 'AccountNo'),
											'output' => array( )),
											
							'updateOrderTempMissingIsValidField' => array( 'input' => array( 'OrderID'),
											'output' => array(  )),
							/* End 04/07/2008  Chi */
							/* 17/07/2008  Chi */
							'changeOrderStatusToFailed' => array( 'input' => array( 'OrderID', 'CreatedBy'),
											'output' => array(  )),
							/* End 17/07/2008  Chi */
							'deleteDeal' => array( 'input' => array( 'ID'),
											'output' => array( )),
							'editDeal' => array( 'input' => array( 'ID', 'AccountNo', 'Quantity', 'CreatedBy' ),
											'output' => array( )),
							'getListStockDetailForExecTrans' => array( 'input' => array( 'TradingDate', 'AccountNo', 'StockExchangeID' ),
											'output' => array( 'ID', 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'OrderSideName' , 'MatchedSession', 'MatchedAgencyFee', 'IsExist' )),
							/* 24/07/2008  Chi */
							'getStockBalanceListForTTBT' => array( 'input' => array( 'TradingDate', 'AccountNo'),
											'output' => array(  'AccountNo', 'Symbol', 'T3Quantity', 'AccountID', 'StockID' )),

							'executeStockTTBTPrivateAccount' => array( 'input' => array( 'AccountID', 'StockID', 'T3Quantity', 'TradingDate'),
											'output' => array('ID')),
							/* End 24/07/2008  Chi */
							'getAdditionCommission' => array( 'input' => array( 'TradingDate', 'UpdatedBy'),
											'output' => array()),

							'insertAdditionallyCommission' => array( 'input' => array( 'TradingDate', 'MinCommission', 'CreatedBy'),
											'output' => array()),

							'lockMoney' => array( 'input' => array( 'OrderID', 'Amount', 'AccountNo' ),
											'output' => array( )),

							'getMatchedOrderUnLocked' => array( 'input' => array( ),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol')),

							'getInvalidBankIDOfMatchedOrder' => array( 'input' => array( ),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol')),

							'getStockDetailWithoutConfirmForHOSE' => array( 'input' => array( 'TradingDate', 'TFlag' ),
											'output' => array( 'ID', 'OrderNumber', 'AccountNo', 'OrderSideName', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID', 'OrderSideID', 'OrderID', 'TFlag')),

							'updateTFlagForHOSE' => array( 'input' => array( 'OrderID', 'TFlag', 'UpdatedBy' ),
											'output' => array( )),

							'updateTFlagForHNX' => array( 'input' => array( 'OrderID', 'TFlag', 'UpdatedBy' ),
											'output' => array( )),

							'getStockDetailWithoutConfirmForHNX' => array( 'input' => array( 'TradingDate', 'TFlag' ),
											'output' => array( 'ID', 'OrderNumber', 'AccountNo', 'OrderSideName', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID', 'OrderSideID', 'OrderID', 'TFlag')),

							'getMatchedQuantityGreaterThanOrderQuantity' => array( 'input' => array(),
											'output' => array( 'AccountNo', 'Symbol', 'OrderID', 'MatchedQuantity', 'OrderQuantity')),

							'confirmBuyOrderForVirtualBank' => array( 'input' => array('TradingDate', 'BankID'),
											'output' => array( )),

							'cancelBuyOrderForVirtualBank' => array( 'input' => array('TradingDate', 'BankID'),
											'output' => array( )),

							'getListMatchNotCutMoney' => array( 'input' => array('TradingDate', 'BankID', 'AccountNo'),
											'output' => array( 'AccountNo', 'LockID', 'AccountID', 'OrderID', 'Symbol', 'MatchedQuantity', 'Value', 'Commission')),

							'getList4Unlock' => array( 'input' => array('TradingDate', 'BankID', 'AccountNo'),
											'output' => array( 'AccountNo', 'AccountID', 'LockID', 'BidAmount', 'OrderID', 'OrderNumber', 'OrderPrice', 'OrderQuantity', 'Symbol', 'StatusName')),

							'unLockForVirtualBank' => array( 'input' => array('AccountID', 'LockID', 'BankID', 'LockAmount', 'UpdatedBy'),
											'output' => array( )),

							'checkAuctionForVirtualBank' => array( 'input' => array('TradingDate', 'BankID'),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol', 'Amount', 'BidAmount', 'Delta')),

							'getAuctionForNVB' => array( 'input' => array('OrderDate'),
											'output' => array( )),

						);

		parent::__construct($arr);
	}

	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}				

	/**
		Function: insertOrderTemp
		Description: update a Buy order
		Input: 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'OrderSideName', 'StockExchangeID', 'OrderDate'
		Output: success / error code
	*/
	function insertOrderTemp($OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $OrderStyleID, $MatchedQuantity, $OrderSideName, $StockExchangeID, $OrderDate, $CreatedBy ) {
		$function_name = 'insertOrderTemp';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($MatchedQuantity) 
				|| !required($OrderSideName) || !required($StockExchangeID) || !unsigned($StockExchangeID) || !required($OrderDate)
				|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) 
				|| !required($OrderStyleID) || !unsigned($OrderStyleID)) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34001;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34002;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34003;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34004;

			if ( !required($OrderSideName) )
				$this->_ERROR_CODE = 34005;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34006;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 34007;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34012;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 34013;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34014;

		} else {
			$query = sprintf( "CALL sp_insertOrderTemp('%s', '%s', '%s', %u, %u, %u, %u, '%s', %u, '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $OrderStyleID, $MatchedQuantity, $OrderSideName, $StockExchangeID, $OrderDate, $CreatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34008;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34009;
							break;

						case '-2':
							$this->_ERROR_CODE = 34010;
							break;

						case '-3':
							$this->_ERROR_CODE = 34011;
							break;

					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderTempID"    => new SOAP_Value( "OrderTempID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertStockDetail
		Description: update a Buy order
		Input: 'ConfirmNo', 'OrderNumber', 'AccountID', 'StockID', 'MatchedQuantity', 'MatchedPrice', 'OrderSideID', 'MatchedSession', 'TradingDate', 'CreatedBy'
		Output: 'StockDetailID' / error code
	*/
	function insertStockDetail($ConfirmNo, $OrderNumber, $AccountID, $StockID, $MatchedQuantity, $MatchedPrice, $OrderSideID, $MatchedSession, $TradingDate, $CreatedBy) {
		$function_name = 'insertStockDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ConfirmNo) || !required($OrderNumber) || !required($AccountID) || !unsigned($AccountID) 
				|| !required($StockID) || !unsigned($StockID) || !required($MatchedQuantity) || !required($MatchedPrice) 
				|| !required($OrderSideID) || !unsigned($OrderSideID) || !required($MatchedSession)
				|| !required($TradingDate) ) {

			if ( !required($ConfirmNo) )
				$this->_ERROR_CODE = 34030;

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34031;

			if ( !required($AccountID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34032;

			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 34033;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34034;

			if ( !required($MatchedPrice) )
				$this->_ERROR_CODE = 34035;

			if ( !required($OrderSideID) || !unsigned($OrderSideID) )
				$this->_ERROR_CODE = 34036;

			if ( !required($MatchedSession) )
				$this->_ERROR_CODE = 34037;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 34038;

		} else {
			$query = sprintf( "CALL sp_insertStockDetail('%s', '%s', %u, %u, %u, %u, %u, %u, '%s', '%s')", 
							$ConfirmNo, $OrderNumber, $AccountID, $StockID, $MatchedQuantity, $MatchedPrice, $OrderSideID, $MatchedSession, $TradingDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34039;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34040;
							break;

					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"StockDetailID"    => new SOAP_Value( "StockDetailID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertSellingOrderForTransactionExecute
		Description: update a Buy order
		Input: 'OrderNumber', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'Note', 'StockExchangeID', 'OrderDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertSellingOrderForTransactionExecute($OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy) {
		$function_name = 'insertSellingOrderForTransactionExecute';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($OrderDate)
				|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice)
				|| !required($Session) || !unsigned($Session) || !required($OrderStyleID) || !unsigned($OrderStyleID) || !required($StockExchangeID) || !unsigned($StockExchangeID) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34110;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34111;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34112;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34113;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 34114;

			if ( !required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 34115;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 34116;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34123;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34124;

		} else {
			$query = sprintf( "CALL sp_insertSellingOrderForTransactionExecute('%s', '%s', '%s', %u, %u, %u, %u, '%s', %u, '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34117;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34118;
							break;

						case '-2':
							$this->_ERROR_CODE = 34119;
							break;

						case '-3':
							$this->_ERROR_CODE = 34120;
							break;

						case '-4':
							$this->_ERROR_CODE = 34121;
							break;

						case '-5':
							$this->_ERROR_CODE = 34122;
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
		Function: insertBuyingOrderForTransactionExecute
		Description: update a Buy order
		Input: 'OrderNumber', 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'Note', 'OrderDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertBuyingOrderForTransactionExecute( $OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy ) {
		$function_name = 'insertBuyingOrderForTransactionExecute';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($OrderDate)
				|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice)
				|| !required($Session) || !unsigned($Session) || !required($OrderStyleID) || !unsigned($OrderStyleID) || !required($StockExchangeID) || !unsigned($StockExchangeID) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34130;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34131;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34132;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34133;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 34134;

			if ( !required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 34135;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 34136;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34142;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34143;

		} else {
			$query = sprintf( "CALL sp_insertBuyingOrderForTransactionExecute('%s', '%s', '%s', %u, %u, %u, %u, '%s', %u, '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34137;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34138;
							break;

						case '-2':
							$this->_ERROR_CODE = 34139;
							break;

						case '-3':
							$this->_ERROR_CODE = 34140;
							break;

						case '-4':
							$this->_ERROR_CODE = 34141;
							break;

					}
				} else {
						//block money in bank
						$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
						$bank_rs = $this->_MDB2->extended->getAll($query);

						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false ) {
							$dab_rs = 999;

							for($i=0; $i<count($bank_rs); $i++) {

								switch ($bank_rs[$i]['bankid']) {
									case DAB_ID:
										$dab = &new CDAB();
										$dab_rs = $dab->blockMoney($bank_rs[$i]['bankaccount'], $bank_rs[$i]['cardno'], $AccountNo, $result, $rs['varordervalue'], $OrderDate);
										break;

									case VCB_ID:
										$dab = &new CVCB();
										$OrderID = $result . $rs['varunitcode'];
										$dab_rs = $dab->blockMoney( $AccountNo, $OrderID, $rs['varordervalue']);
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->blockMoney(substr($result . date("His"), 3), $bank_rs[$i]['bankaccount'], $rs['varordervalue'], $result);
										break;

									case OFFLINE:
										$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
										$this->_MDB2_WRITE->connect();
										$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();										
										$dab_rs = $off_rs['varerror'];
										break;
								}

								if ($dab_rs == 0){
									$BankID = $bank_rs[$i]['bankid'];
									break;
								}
							}
						} else {
							$dab_rs = 0;
							$BankID = EXI_ID;
						}

						if ($dab_rs != 0) { //fail
							$i = $i - 1;
							switch ($bank_rs[$i]['bankid']) {
								case DAB_ID:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 41020;
											break;
						
										case '-2':
											$this->_ERROR_CODE = 41021;
											break;
						
										case '-3':
											$this->_ERROR_CODE = 41022;
											break;
						
										case '-4':
											$this->_ERROR_CODE = 41023;
											break;
						
										case '-5':
											$this->_ERROR_CODE = 41024;
											break;
						
										case '1':
											$this->_ERROR_CODE = 41025;
											break;
					
										case '2':
											$this->_ERROR_CODE = 41026;
											break;
					
										case '3':
											$this->_ERROR_CODE = 41027;
											break;
					
										case '4':
											$this->_ERROR_CODE = 41028;
											break;
		
										case '5':
											$this->_ERROR_CODE = 41030;
											break;
					
										case '99':
											$this->_ERROR_CODE = 41029;
											break;
					
										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;

								case VCB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;
									
								case NVB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;

								case OFFLINE:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 30650;
											break;
						
										case '-2':
											$this->_ERROR_CODE = 30651;
											break;
						
										case '-3':
											$this->_ERROR_CODE = 30652;
											break;
						
										case '-4':
											$this->_ERROR_CODE = 30653;
											break;
					
										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;
							}//switch

							$this->_MDB2_WRITE->connect();
							$query = sprintf( "DELETE FROM %s WHERE ID=%u ", TBL_ORDER, $result );
							$delete_rs = $this->_MDB2_WRITE->extended->getRow($query);

						} else { // bank
							$this->items[0] = new SOAP_Value(
									'item',
									$struct,
									array(
										"ID"    => new SOAP_Value( "ID", "string", $result )
										)
								);

							$this->_MDB2_WRITE->connect();
							$query = sprintf( "CALL sp_updateBankIDWhenInsertWarningOrder( %u, %u ) ", $result, $BankID);
							$status_rs = $this->_MDB2_WRITE->extended->getRow($query);

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 34145;
							} 
						}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertBuyingOrderForTransactionExecuteWithBlockingMoney
		Description: Buy order
		Input: 'OrderNumber', 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'Note', 'OrderDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertBuyingOrderForTransactionExecuteWithoutBlockingMoney( $OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy ) {
		$function_name = 'insertBuyingOrderForTransactionExecuteWithoutBlockingMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($OrderDate)
				|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice)
				|| !required($Session) || !unsigned($Session) || !required($OrderStyleID) || !unsigned($OrderStyleID) || !required($StockExchangeID) || !unsigned($StockExchangeID) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34370;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34371;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34372;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34373;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 34374;

			if ( !required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 34375;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 34376;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34377;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34378;

		} else {
			$query = sprintf( "CALL sp_insertBuyingOrderForTransactionExecute('%s', '%s', '%s', %u, %u, %u, %u, '%s', %u, '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34379;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34380;
							break;

						case '-2':
							$this->_ERROR_CODE = 34381;
							break;

						case '-3':
							$this->_ERROR_CODE = 34382;
							break;

						case '-4':
							$this->_ERROR_CODE = 34383;
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
		Function: insertBuyingOrderForTransactionExecuteWithReservingMoney
	*/
	function insertBuyingOrderForTransactionExecuteWithReservingMoney( $OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy ) {
		$function_name = 'insertBuyingOrderForTransactionExecuteWithReservingMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($OrderDate)
				|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice)
				|| !required($Session) || !unsigned($Session) || !required($OrderStyleID) || !unsigned($OrderStyleID) || !required($StockExchangeID) || !unsigned($StockExchangeID) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34410;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34411;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34412;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34413;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 34414;

			if ( !required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 34415;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 34416;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34417;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34418;

		} else {
			$query = sprintf( "CALL sp_insertBuyingOrderForTransactionExecute('%s', '%s', '%s', %u, %u, %u, %u, '%s', %u, '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $Note, $StockExchangeID, $OrderDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34419;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34420;
							break;

						case '-2':
							$this->_ERROR_CODE = 34421;
							break;

						case '-3':
							$this->_ERROR_CODE = 34422;
							break;

						case '-4':
							$this->_ERROR_CODE = 34423;
							break;

					}
				} else {
						//block money in bank
						$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
						$bank_rs = $this->_MDB2->extended->getAll($query);

						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false ) {
							$dab_rs = 999;

							for($i=0; $i<count($bank_rs); $i++) {
								switch ($bank_rs[$i]['bankid']) {
									case DAB_ID:
										$dab = &new CDAB();
										$dab_rs = $dab->blockMoney($bank_rs[$i]['bankaccount'], $bank_rs[$i]['cardno'], $AccountNo, $result, 1, $OrderDate);
										break;

									case VCB_ID:
										$dab = &new CVCB();
										$OrderID = $result . $rs['varunitcode'];
										$dab_rs = $dab->blockMoney( $AccountNo, $OrderID, 1);
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->blockMoney(substr($result . date("His"), 3), $bank_rs[$i]['bankaccount'], 1, $result);
										break;

									case OFFLINE:
										$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, 1, $OrderDate, $CreatedBy);
										$this->_MDB2_WRITE->connect();
										$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();										
										$dab_rs = $off_rs['varerror'];
										break;
								}

								if ($dab_rs == 0){
									$BankID = $bank_rs[$i]['bankid'];
									break;
								}
							}
						} else {
							$dab_rs = 0;
							$BankID = EXI_ID;
						}

						if ($dab_rs != 0) { //fail
							$i = $i - 1;
							switch ($bank_rs[$i]['bankid']) {
								case DAB_ID:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 41020;
											break;
						
										case '-2':
											$this->_ERROR_CODE = 41021;
											break;
						
										case '-3':
											$this->_ERROR_CODE = 41022;
											break;
						
										case '-4':
											$this->_ERROR_CODE = 41023;
											break;
						
										case '-5':
											$this->_ERROR_CODE = 41024;
											break;
						
										case '1':
											$this->_ERROR_CODE = 41025;
											break;
					
										case '2':
											$this->_ERROR_CODE = 41026;
											break;
					
										case '3':
											$this->_ERROR_CODE = 41027;
											break;
					
										case '4':
											$this->_ERROR_CODE = 41028;
											break;
		
										case '5':
											$this->_ERROR_CODE = 41030;
											break;
					
										case '99':
											$this->_ERROR_CODE = 41029;
											break;
					
										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;

								case VCB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;
									
								case NVB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;

								case OFFLINE:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 30650;
											break;
						
										case '-2':
											$this->_ERROR_CODE = 30651;
											break;
						
										case '-3':
											$this->_ERROR_CODE = 30652;
											break;
						
										case '-4':
											$this->_ERROR_CODE = 30653;
											break;
					
										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;
							}//switch

							$this->_MDB2_WRITE->connect();
							$query = sprintf( "DELETE FROM %s WHERE ID=%u ", TBL_ORDER, $result );
							$delete_rs = $this->_MDB2_WRITE->extended->getRow($query);

						} else { // bank
							$this->items[0] = new SOAP_Value(
									'item',
									$struct,
									array(
										"ID"    => new SOAP_Value( "ID", "string", $result )
										)
								);

							$this->_MDB2_WRITE->connect();
							$query = sprintf( "CALL sp_updateBankIDWhenInsertWarningOrder( %u, %u ) ", $result, $BankID);
							$status_rs = $this->_MDB2_WRITE->extended->getRow($query);

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 34145;
							} 
						}

				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertStockDetailOnline
		Description: update a Buy order
		Input: 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertStockDetailOnline( $ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy ) {
		$function_name = 'insertStockDetailOnline';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($ConfirmNo) || !required($MatchedQuantity) || !required($MatchedPrice) 
				|| !required($MatchedSession) || !unsigned($MatchedSession) || !required($TradingDate) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34180;

			if ( !required($ConfirmNo) )
				$this->_ERROR_CODE = 34181;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34182;

			if ( !required($MatchedPrice) )
				$this->_ERROR_CODE = 34183;

			if ( !required($MatchedSession) || !unsigned($MatchedSession) )
				$this->_ERROR_CODE = 34184;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 34185;

		} else {
			$query = sprintf( "CALL sp_insertStockDetailOnline('%s', '%s', %u, %u, %u, '%s', '%s')", 
							$ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34186;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34187;
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
		Function: insertStockDetailForExecuteTransaction
		Description: update a Buy order
		Input: 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertStockDetailForExecuteTransaction( $ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy ) {
		$function_name = 'insertStockDetailForExecuteTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($ConfirmNo) || !required($MatchedQuantity) || !required($MatchedPrice) 
				|| !required($MatchedSession) || !unsigned($MatchedSession) || !required($TradingDate) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34250;

			if ( !required($ConfirmNo) )
				$this->_ERROR_CODE = 34251;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34252;

			if ( !required($MatchedPrice) )
				$this->_ERROR_CODE = 34253;

			if ( !required($MatchedSession) || !unsigned($MatchedSession) )
				$this->_ERROR_CODE = 34254;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 34255;

		} else {
			$query = sprintf( "CALL sp_insertStockDetailForExecuteTransaction('%s', '%s', %u, %u, %u, '%s', '%s')", 
							$ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34256;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34257;
							break;

						case '-2':
							$this->_ERROR_CODE = 34258;
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
		Function: insertStockDetailForKLDK
		Description: update a Buy order
		Input: 'ConfirmNo', 'OrderNumber', 'AccountID', 'StockID', 'MatchedQuantity', 'MatchedPrice', 'OrderSideID', 'MatchedSession', 'TradingDate', 'CreatedBy'
		Output: success / error code
	*/
	function insertStockDetailForKLDK( $ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy ) {
		$function_name = 'insertStockDetailForKLDK';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($ConfirmNo) || !required($MatchedQuantity) || !required($MatchedPrice) 
				|| !required($MatchedSession) || !unsigned($MatchedSession) || !required($TradingDate) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34300;

			if ( !required($ConfirmNo) )
				$this->_ERROR_CODE = 34301;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34304;

			if ( !required($MatchedPrice) )
				$this->_ERROR_CODE = 34305;

			if ( !required($MatchedSession) || !unsigned($MatchedSession) )
				$this->_ERROR_CODE = 34307;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 34308;

		} else {
			$query = sprintf( "CALL sp_insertStockDetailForKLDK('%s', '%s', %u, %u, %u, '%s', '%s')", 
							$ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34309;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34310;
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: updateOrderTemp
		Description: update a Buy order
		Input: 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'OrderSideName', 'StockExchangeID', 'OrderDate'
		Output: success / error code
	*/
	function updateOrderTemp($ID, $AccountNo, $OrderQuantity, $OrderStyleID, $Price) {
		$function_name = 'updateOrderTemp';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($ID) || !unsigned($ID) || !required($OrderStyleID) || !unsigned($OrderStyleID) ) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34270;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 34271;

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 34272;
				
			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 34524;

		} else {
			$query = sprintf( "CALL sp_updateOrderTemp(%u, '%s', %u, %u, %f)", $ID, $AccountNo, $OrderQuantity, $OrderStyleID, $Price);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34273;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34274;
							break;

						case '-2':
							$this->_ERROR_CODE = 34275;
							break;

						case '-3':
							$this->_ERROR_CODE = 34276;
							break;

						case '-4':
							$this->_ERROR_CODE = 34277;
							break;

						case '-5':
							$this->_ERROR_CODE = 34278;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: executeStockOfBuyingDeal
		Description: update a Buy order
		Input: 'ID', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function executeStockOfBuyingDeal($ID, $UpdatedBy) {
		$function_name = 'executeStockOfBuyingDeal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) ) {

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 34050;

		} else {
			$query = sprintf( "CALL sp_executeStockOfBuyingDeal(%u, '%s')", $ID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34056;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34057;
							break;

						case '-2':
							$this->_ERROR_CODE = 34058;
							break;

						case '-3':
							$this->_ERROR_CODE = 34059;
							break;

						case '-4':
							$this->_ERROR_CODE = 34060;
							break;

					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: executeStockOfSellingDeal
		Description: update a Buy order
		Input: 'ID', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function executeStockOfSellingDeal($ID, $UpdatedBy) {
		$function_name = 'executeStockOfSellingDeal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) ) {

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 34070;

		} else {
			$query = sprintf( "CALL sp_executeStockOfSellingDeal(%u, '%s')", $ID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34076;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34077;
							break;

						case '-2':
							$this->_ERROR_CODE = 34078;
							break;

						case '-3':
							$this->_ERROR_CODE = 34079;
							break;

						case '-4':
							$this->_ERROR_CODE = 34080;
							break;

						case '-5':
							$this->_ERROR_CODE = 34082;
							break;

						case '-6':
							$this->_ERROR_CODE = 34081;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: confirmMatchedAgencyFee
		Description: update a Buy order
		Input: 'ID', 'OrderNumber', 'AccountNo', 'StockID', 'MatchedQuantity', 'TradingDate', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function confirmMatchedAgencyFee( $TradingDate ) {
		$function_name = 'confirmMatchedAgencyFee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) ) {
			$this->_ERROR_CODE = 34150;

		} else {
			$query = sprintf( "CALL sp_confirmMatchedAgencyFee( '%s' )", $TradingDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34151;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34152;
							break;

						case '-2':
							$this->_ERROR_CODE = 34153;
							break;

						case '-3':
							$this->_ERROR_CODE = 34154;
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
		Function: executeMoneyForSellingTransaction
		Description: update a Buy order
		Input: 'ID', 'OrderNumber', 'AccountNo', 'StockID', 'MatchedQuantity', 'TradingDate', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function executeMoneyForSellingTransaction( $TradingDate, $UpdatedBy ) {
		$function_name = 'executeMoneyForSellingTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) ) {
			$this->_ERROR_CODE = 34160;

		} else {
			$query = sprintf( "CALL sp_executeMoneyForSellingTransaction( '%s', '%s'  )", $TradingDate, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34161;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34162;
							break;

						case '-2':
							$this->_ERROR_CODE = 34163;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: executeMoneyForBuyingTransaction
		Description: update a Buy order
		Input: 'ID', 'OrderNumber', 'AccountNo', 'StockID', 'MatchedQuantity', 'TradingDate', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function executeMoneyForBuyingTransaction( $TradingDate, $UpdatedBy ) {
		$function_name = 'executeMoneyForBuyingTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) ) {
			$this->_ERROR_CODE = 34170;

		} else {
			$query = sprintf( "CALL sp_executeMoneyForBuyingTransaction( '%s', '%s' )", $TradingDate, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34171;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34172;
							break;

					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: executeMoneyForBuyingTransactionOfAccount
		Description: update a Buy order
		Input: 'ID', 'OrderNumber', 'AccountNo', 'StockID', 'MatchedQuantity', 'TradingDate', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function executeMoneyForBuyingTransactionOfAccount( $AccountID, $AmountMoney, $TradingDate, $UpdatedBy ) {
		$function_name = 'executeMoneyForBuyingTransactionOfAccount';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) || !required($AccountID) || !unsigned($AccountID) || !required($AmountMoney) ) {

			if ( !required($AccountID) || !unsigned($AccountID) )
				$this->_ERROR_CODE = 34280;

			if ( !required($TradingDate) ) 
				$this->_ERROR_CODE = 34281;

			if ( !required($AmountMoney) ) 
				$this->_ERROR_CODE = 34282;

		} else {
			$query = sprintf( "CALL sp_executeMoneyForBuyingTransactionOfAccount( %u, %f, '%s', '%s' )", $AccountID, $AmountMoney, $TradingDate, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34283;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34284;
							break;

						case '-2':
							$this->_ERROR_CODE = 34285;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: executeEndTransaction
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function executeEndTransaction( $TradingDate ) {
		$function_name = 'executeEndTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) ) {
			$this->_ERROR_CODE = 34290;

		} else {
			$query = sprintf( "CALL sp_executeEndTransaction( '%s' )", $TradingDate );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34291;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34292;
							break;

						case '-2':
							$this->_ERROR_CODE = 34293;
							break;

						case '-3':
							$this->_ERROR_CODE = 34294;
							break;

						case '-4':
							$this->_ERROR_CODE = 34295;
							break;

						case '-5':
							$this->_ERROR_CODE = 34296;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: updateStockDetail
		Description: update a Buy order
		Input: 'ID', 'AccountNo', 'MatchedQuantity', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function updateStockDetail($ID, $OrderNumber, $AccountNo, $MatchedQuantity, $UpdatedBy) {
		$function_name = 'updateStockDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($AccountNo) || !required($MatchedQuantity) ) {

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 34090;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34091;

			if ( !required($MatchedQuantity) )
				$this->_ERROR_CODE = 34092;

		} else {
			$query = sprintf( "CALL sp_updateStockDetail(%u, '%s', '%s', %u, '%s')", 
							$ID, $OrderNumber, $AccountNo, $MatchedQuantity, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34093;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34094;
							break;

						case '-2':
							$this->_ERROR_CODE = 34095;
							break;

						case '-3':
							$this->_ERROR_CODE = 34096;
							break;

						case '-4':
							$this->_ERROR_CODE = 34097;
							break;

						case '-5':
							$this->_ERROR_CODE = 34098;
							break;

						case '-6':
							$this->_ERROR_CODE = 34099;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editBuyingOrderWhenExecTransaction
		Description: update a Buy order
		Input: 'ID', 'AccountNo', 'MatchedQuantity', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function editBuyingOrderWhenExecTransaction($OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $AccountNo, $UpdatedBy) {
		$function_name = 'editBuyingOrderWhenExecTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderStyleID) || !unsigned($OrderStyleID) 
			|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) || !unsigned($OrderPrice) ) {

			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 34340;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 34341;

			if ( !required($OrderPrice))
				$this->_ERROR_CODE = 34342;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID))
				$this->_ERROR_CODE = 34343;

		} else {

			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode, OrderQuantity * OrderPrice * (1 + OrderAgencyFee) as OldOrderValue
									FROM vw_ListAccountBank_Detail, %s
									WHERE %s.ID = %u
									AND vw_ListAccountBank_Detail.AccountNo = '%s'
									AND %s.Deleted='0'
									AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
									AND vw_ListAccountBank_Detail.BankID = %s.BankID
									ORDER BY Priority ", 
									TBL_ORDER,
									TBL_ORDER, $OrderID,
									$AccountNo,
									TBL_ORDER,
									TBL_ORDER,
									TBL_ORDER );
			$bank_rs = $this->_MDB2->extended->getRow($query);

			if ( $bank_rs['bankaccount'] != "" ) {
				if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false ) { 
					$query = sprintf( "SELECT f_getPrivateAgencyFee(%u, %f) as OrderAgencyFee ", $bank_rs['accountid'], $OrderQuantity * $OrderPrice );
					$fee_rs = $this->_MDB2->extended->getRow($query);
					$orderValue = $OrderQuantity * $OrderPrice * ($fee_rs['orderagencyfee'] + 1);

					switch ($bank_rs['bankid']) {
						case DAB_ID:
							$dab = &new CDAB();
							$dab_rs = $dab->editBlockMoney($bank_rs['bankaccount'], $AccountNo, $OrderID, $orderValue );
							break;

						case VCB_ID:
							$dab = &new CVCB();
							$oldOrderID = $OrderID . $bank_rs['unitcode'];
							$suffix = date("His");
							$newOrderID = $OrderID . $suffix;
							$dab_rs = $dab->editBlockMoney($AccountNo, $oldOrderID, $newOrderID, $bank_rs['oldordervalue'], $orderValue );
							break;

						case NVB_ID:
							$dab = &new CNVB();
							$dab_rs = $dab->editBlockMoney(substr($OrderID .date("His"), 3), $bank_rs['bankaccount'], $orderValue, $OrderID);
							break;

						case OFFLINE:
							$query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							$dab_rs = $off_rs['varerror'];
							break;
					} //switch
				} else {
					$dab_rs = 0;
				}

				if ($dab_rs == 0) { //Successfully

					$query = sprintf( "CALL sp_editBuyingOrderWhenExecTransaction(%u, %u, %u, %u, '%s')", 
									$OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
		
					if (empty( $rs)) {
						$this->_ERROR_CODE = 34344;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 34345;
									break;
		
								case '-2':
									$this->_ERROR_CODE = 34346;
									break;
		
								case '-3':
									$this->_ERROR_CODE = 34347;
									break;
		
								case '-4':
									$this->_ERROR_CODE = 34348;
									break;
		
								case '-5':
									$this->_ERROR_CODE = 34349;
									break;
							} // switch
						} // if store
					} // if WS
				} else {// bank fail
					switch ($bank_rs['bankid']) {
						case DAB_ID:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 41040;
									break;
				
								case '-2':
									$this->_ERROR_CODE = 41041;
									break;
				
								case '-3':
									$this->_ERROR_CODE = 41042;
									break;
				
								case '-4':
									$this->_ERROR_CODE = 41043;
									break;
				
								case '-5':
									$this->_ERROR_CODE = 41044;
									break;
				
								case '1':
									$this->_ERROR_CODE = 41045;
									break;
			
								case '2':
									$this->_ERROR_CODE = 41046;
									break;
			
								case '3':
									$this->_ERROR_CODE = 41047;
									break;
			
								case '4':
									$this->_ERROR_CODE = 41048;
									break;
		
								case '5':
									$this->_ERROR_CODE = 41050;
									break;
		
								case '6':
									$this->_ERROR_CODE = 41051;
									break;
		
								case '7':
									$this->_ERROR_CODE = 41052;
									break;
			
								case '99':
									$this->_ERROR_CODE = 41049;
									break;
			
								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;
						
						case VCB_ID:
							$arrErr = explode('_', $dab_rs);
							$this->_ERROR_CODE = $arrErr[1];
							break;
							
						case NVB_ID:
							$this->_ERROR_CODE = $dab_rs;
							break;

						case OFFLINE:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 30620;
									break;
				
								case '-2':
									$this->_ERROR_CODE = 30621;
									break;
				
								case '-3':
									$this->_ERROR_CODE = 30622;
									break;
				
								case '-4':
									$this->_ERROR_CODE = 30623;
									break;
				
								case '-5':
									$this->_ERROR_CODE = 30624;
									break;
			
								default:
									$this->_ERROR_CODE = $dab_rs;
							}
					}//switch
				}//else
			} else {// bank is existed
				$this->_ERROR_CODE = 34350;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editSellingOrderWhenExecTransaction
		Description: update a Buy order
		Input: 'ID', 'AccountNo', 'MatchedQuantity', 'UpdatedBy'
		Output: 'StockDetailID' / error code
	*/
	function editSellingOrderWhenExecTransaction($OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy) {
		$function_name = 'editSellingOrderWhenExecTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderStyleID) || !unsigned($OrderStyleID) 
			|| !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) || !unsigned($OrderPrice) ) {

			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 34320;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 34321;

			if ( !required($OrderPrice) || !unsigned($OrderPrice))
				$this->_ERROR_CODE = 34322;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID))
				$this->_ERROR_CODE = 34323;

		} else {
			$query = sprintf( "CALL sp_editSellingOrderWhenExecTransaction(%u, %u, %u, %u, '%s')", 
							$OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34324;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34325;
							break;

						case '-3':
							$this->_ERROR_CODE = 34326;
							break;

						case '-4':
							$this->_ERROR_CODE = 34327;
							break;

						case '-5':
							$this->_ERROR_CODE = 34328;
							break;

						case '-6':
							$this->_ERROR_CODE = 34329;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/**
		Function: listWarningOrderTemp
		Description: 
		Input: 
		Output: ???
	*/	
	function listWarningOrderTemp($TradingDate,$StockExchangeID) {
		$function_name = 'listWarningOrderTemp';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getWarningOrderTempList('%s','%s')", $TradingDate, $StockExchangeID );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderTempID"    => new SOAP_Value("OrderTempID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"OrderStyleID"    => new SOAP_Value("OrderStyleID", "string", $result[$i]['orderstyleid']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"Value"    => new SOAP_Value("Value", "string", $result[$i]['val']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getPrivateStockDetailWithoutConfirmList
		Description: 
		Input: 'OrderNumber', 'TradingDate'
		Output: 'ConfirmNo', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID'
	*/	
	function getPrivateStockDetailWithoutConfirmList($OrderNumber, $TradingDate) {
		$function_name = 'getPrivateStockDetailWithoutConfirmList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($TradingDate) ) {
			if ( !required($OrderNumber) ) 
				$this->_ERROR_CODE = 34190;

			if ( !required($TradingDate) ) 
				$this->_ERROR_CODE = 34191;

		} else {
			$query = sprintf( "CALL sp_getPrivateStockDetailWithoutConfirmList('%s', '%s')", $OrderNumber, $TradingDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
							"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
							"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getStockDetailWithoutConfirmList
		Description: 
		Input: 'OrderNumber'
		Output: 'ConfirmNo', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'MatchedQuantity', 'MatchedPrice'
	*/	
	function getStockDetailWithoutConfirmList($OrderDate) {
		$function_name = 'getStockDetailWithoutConfirmList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			$this->_ERROR_CODE = 34200;

		} else {
			$query = sprintf( "CALL sp_getStockDetailWithoutConfirmList('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
							"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
							"Note"    => new SOAP_Value("Note", "string", $result[$i]['note'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getStockDetailWithoutConfirmForHOSE($TradingDate, $TFlag) {
		$function_name = 'getStockDetailWithoutConfirmForHOSE';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_hose_StockDetailWithoutConfirmList('%s', '%s')", $TradingDate, $TFlag );
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
						"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"TFlag"    => new SOAP_Value("TFlag", "string", $result[$i]['tflag']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function updateTFlagForHOSE($OrderID, $TFlag, $UpdatedBy) {
		$function_name = 'updateTFlagForHOSE';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf("CALL sp_hose_updateTFlag(%u, '%s', '%s')", $OrderID, $TFlag, $UpdatedBy);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 34021;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 34022;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function updateTFlagForHNX($OrderID, $TFlag, $UpdatedBy) {
		$function_name = 'updateTFlagForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf("CALL sp_hnx_updateTFlag(%u, '%s', '%s')", $OrderID, $TFlag, $UpdatedBy);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 34021;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 34022;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getStockDetailWithoutConfirmForHNX($TradingDate, $TFlag) {
		$function_name = 'getStockDetailWithoutConfirmForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_hnx_StockDetailWithoutConfirmList('%s', '%s')", $TradingDate, $TFlag );
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
						"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"TFlag"    => new SOAP_Value("TFlag", "string", $result[$i]['tflag']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getOrderWithoutOrderNumberList
		Description: 
		Input: 'OrderDate'
		Output: 'ID', 'OrderNumber', 'AccountNo', 'OrderSide', 'Symbol', 'OrderQuantity', 'OrderPrice', 'Session', 'StatusName', 'OrderStyleName', 'FromName', 'StockExchangeID'
	*/	
	function getOrderWithoutOrderNumberList($OrderDate, $StockExchangeID) {
		$function_name = 'getOrderWithoutOrderNumberList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			$this->_ERROR_CODE = 34210;

		} else {
			$query = sprintf( "CALL sp_getOrderWithoutOrderNumberList('%s', %u)", $OrderDate, $StockExchangeID);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
							"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
							"Session"    => new SOAP_Value("Session", "string", $result[$i]['session']),
							"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
							"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
							"FromName"    => new SOAP_Value("FromName", "string", $result[$i]['fromname']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getStockDetailWithConfirmList
		Description: 
		Input: 'OrderDate'
		Output: 'ID', 'ConfirmNo', 'OrderNumber', 'OrderSide', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'MatchedAgencyFee', 'Note', 'StockExchangeID'
	*/	
	function getStockDetailWithConfirmList($OrderDate) {
		$function_name = 'getStockDetailWithConfirmList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			$this->_ERROR_CODE = 34220;

		} else {
			$query = sprintf( "CALL sp_getStockDetailWithConfirmList('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
							"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee']),
							"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getFullStockDetailWithConfirmList
		Description: 
		Input: 'OrderDate'
		Output: 'ID', 'ConfirmNo', 'OrderNumber', 'OrderSide', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'MatchedAgencyFee', 'MatchedValue', 'Commission', 'TMoney', 'StockExchangeID'
	*/	
	function getFullStockDetailWithConfirmList($OrderDate) {
		$function_name = 'getFullStockDetailWithConfirmList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			$this->_ERROR_CODE = 34230;

		} else {
			$query = sprintf( "CALL sp_getFullStockDetailWithConfirmList('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
							"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee']),
							"MatchedValue"    => new SOAP_Value("MatchedValue", "string", $result[$i]['matchedvalue']),
							"Commission"    => new SOAP_Value("Commission", "string", $result[$i]['commission']),
							"LogMoney"    => new SOAP_Value("LogMoney", "string", $result[$i]['logmoney']),
							"TMoney"    => new SOAP_Value("TMoney", "string", $result[$i]['tmoney']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkOrderIsWarningOrNormal
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function checkOrderIsWarningOrNormal($OrderTempID) {
		$function_name = 'checkOrderIsWarningOrNormal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderTempID) || !unsigned($OrderTempID)) {
			$this->_ERROR_CODE = 34020;

		} else {
			$query = sprintf("CALL sp_executeForOneRowOfOrderTemp(%u)", $OrderTempID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34021;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34022;
							break;

						case '-2':
							$this->_ERROR_CODE = 34023;
							break;

						case '-3':
							$this->_ERROR_CODE = 34023;
							break;
					}
				}

			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getNextOrderNumber
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getNextOrderNumber($TradingDate) {
		$function_name = 'getNextOrderNumber';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) ) {
			$this->_ERROR_CODE = 34240;

		} else {
			$query = sprintf("SELECT f_getNextOrderNumber('%s') AS varError ", $TradingDate );
			$rs = $this->_MDB2->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34241;
			} else {
				$result = $rs['varerror'];
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"OrderNumber"    => new SOAP_Value( "OrderNumber", "string", $result )
							)
					);
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getNextConfirmNo
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getNextConfirmNo($TradingDate) {
		$function_name = 'getNextConfirmNo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34246;

		} else {
			$query = sprintf("SELECT f_getNextConfirmNo('%s') AS varError ", $TradingDate);
			$rs = $this->_MDB2->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34246;
			} else {
				$result = $rs['varerror'];
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ConfirmNo"    => new SOAP_Value( "ConfirmNo", "string", $result )
							)
					);
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getReportStockList
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getReportStockList($TradingDate) {
		$function_name = 'getReportStockList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34195;

		} else {
			$query = sprintf( "CALL sp_getReportStockList('%s')", $TradingDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"Mua"    => new SOAP_Value("Mua", "string", $result[$i]['mua']),
							"Ban"    => new SOAP_Value("Ban", "string", $result[$i]['ban'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getStockDetailWithoutExecAgencyFeeList
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getStockDetailWithoutExecAgencyFeeList($TradingDate) {
		$function_name = 'getStockDetailWithoutExecAgencyFeeList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34225;

		} else {
			$query = sprintf( "CALL sp_getStockDetailWithoutExecAgencyFeeList('%s')", $TradingDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
							"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
							"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getStockDetailAfterExecMoney
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getStockDetailAfterExecMoney($TradingDate) {
		$function_name = 'getStockDetailAfterExecMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34215;

		} else {
			$query = sprintf( "CALL sp_getStockDetailAfterExecMoney('%s')", $TradingDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"ConfirmNo"    => new SOAP_Value("ConfirmNo", "string", $result[$i]['confirmno']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
							"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee']),
							"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAccountWithBuyingTransactionList
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getAccountWithBuyingTransactionList($TradingDate) {
		$function_name = 'getAccountWithBuyingTransactionList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34235;

		} else {
			$query = sprintf( "CALL sp_getAccountWithBuyingTransactionList('%s')", $TradingDate );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"AmountMoney"    => new SOAP_Value("AmountMoney", "string", my_format_number($result[$i]['amountmoney']) )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAuctionForXML
		Description: 
		Input: 
		Output: 
	*/	
	function getAuctionForXML($OrderDate, $BankID) {
		$function_name = 'getAuctionForXML';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) || !required($BankID) ) {
			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34355;

			if ( !required($OrderDate) ) 
				$this->_ERROR_CODE = 34356;

		} else {
			$query = sprintf( "CALL sp_getAuctionForXML('%s', %u )", $OrderDate, $BankID );

			$path =  DAB_PATH;
			$date_array = getdate();
			$csv_dir = $path . $date_array['year'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}
			$csv_dir = $csv_dir . $date_array['mon'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}

			$filename = $csv_dir . date("Ynd") . '_DAB_Auction.xml';
			$query2xml = XML_Query2XML::factory($this->_MDB2);

			if (file_exists($filename)) {
				$this->_ERROR_CODE = 34205;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$dom = $query2xml->getXML( $query , 
											array(
												 'rootTag' => 'AllAuction',
												 'idColumn' => false,
												 'rowTag' => 'Auction',
												'elements' => array(
														'custaccount' => 'custaccount',
														'scraccount' => 'scraccount',
														'refno' => 'refno', 
														'amount' => 'amount', 
														'fee' => 'fee', 
														'scrdate' => ':'.date("YmdHis"),
													 )
											  )
											);

			
			$dom->formatOutput = true;
			file_put_contents($filename, $dom->saveXML());

			$dab = new CDAB();
			$dab_rs = $dab->auctionFile($csv_dir, date("Ynd") . '_DAB_Auction.xml' );
			if ($dab_rs == 0){
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FileName"    => new SOAP_Value( "FileName", "string", "result_". date("Ynd") . '_DAB_Auction.xml' )
							)
				);

				$resultFileName = 'result_'. date("Ynd") . '_DAB_Auction.xml';
				$query = sprintf("UPDATE %s SET DABAuction='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $resultFileName , date("Y-m-d") );

			} else {
				$this->_ERROR_CODE = 34357 ." ". $dab_rs;
				$query = sprintf("UPDATE %s SET DABAuction='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $dab_rs, date("Y-m-d") );
			}

			$rs = $this->_MDB2_WRITE->extended->getRow($query);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getAuctionForNVB($OrderDate) {
		$function_name = 'getAuctionForNVB';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			if ( !required($OrderDate) ) 
				$this->_ERROR_CODE = 34356;

		} else {
			$query = sprintf( "CALL sp_getAuctionForXML('%s', %u )", $OrderDate, NVB_ID);
			$rs = $this->_MDB2->extended->getAll($query);

			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?> 
					<DOCUMENT>";
			$xml .= "<BATCHID>". date("dmYHis") ."</BATCHID>"; 
			$xml .= "<CURR>VND</CURR>"; 

			for($i=0; $i<count($rs); $i++) {

					$xml .= "<TRANSACTION>"; 
					$xml .= "<CREDITACCOUNT>". EPS_NVB . "</CREDITACCOUNT>"; 
					$xml .= "<DEBITACCOUNT>". $rs[$i]['custaccount'] . "</DEBITACCOUNT>"; 
					$xml .= "<AMOUNT>". $rs[$i]['amount'] ."</AMOUNT>"; 
					$xml .= "<FEEAMT>". $rs[$i]['fee'] ."</FEEAMT> ";
					$xml .= "<TRANSACTIONCODE>". $rs[$i]['refno'] ."</TRANSACTIONCODE>";
					$xml .= "<DECS>Cat tien lenh ". $rs[$i]['refno'] ."</DECS>";
					$xml .= "</TRANSACTION>"; 
			}

			$xml .= "</DOCUMENT>"; 

			$dab = &new CNVB();
			$dab_rs = $dab->cutMoneyByList(time(), $xml);
			if ($dab_rs == 0){
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FileName"    => new SOAP_Value( "FileName", "string", "result_". date("Ynd") . '_DAB_Auction.xml' )
							)
				);

				$resultFileName = 'result_'. date("Ynd") . '_DAB_Auction.xml';
				$query = sprintf("UPDATE %s SET DABAuction='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $resultFileName , date("Y-m-d") );

			} else {
				$this->_ERROR_CODE = 34357 ." ". $dab_rs;
				$query = sprintf("UPDATE %s SET DABAuction='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $dab_rs, date("Y-m-d") );
			}

			$rs = $this->_MDB2_WRITE->extended->getRow($query);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAllSellForXML
		Description: check ContractNo exist or not
		Input: ContractNo
		Output: 
	*/	
	function getAllSellForXML($OrderDate, $BankID) {
		$function_name = 'getAllSellForXML';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) || !required($BankID) ) {
			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34360;

			if ( !required($OrderDate) ) 
				$this->_ERROR_CODE = 34361;

		} else {
			$query = sprintf( "CALL sp_getAllSellForXML('%s', %u )", $OrderDate, $BankID );

			$path =  DAB_PATH;
			$date_array = getdate();
			$csv_dir = $path . $date_array['year'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}
			$csv_dir = $csv_dir . $date_array['mon'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}

			$filename = $csv_dir . date("Ynd") . '_DAB_Sell.xml';
			$query2xml = XML_Query2XML::factory($this->_MDB2);

			if (file_exists($filename)) {
				$this->_ERROR_CODE = 34205;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$dom = $query2xml->getXML( $query , 
											array(
												 'rootTag' => 'AllSell',
												 'idColumn' => false,
												 'rowTag' => 'Sell',
												 'encoder' => false,
												 'mapper' => 'XML_Query2XML_ISO9075Mapper::map',
												'elements' => array(
														'scraccount' => 'scraccount',
														'refno' => 'refno',
														'receiver_account' => 'receiver_account', 
														'receiver_name' => 'receiver_name', 
														'receiver_bank' => ':DAB', 
														'receiver_bank_city' => ':CN Quan 1',
														'isDAB' => ':1',
														'amount' => 'amount',
														'fee' => 'fee',
														'scrdate' => ':'.date("YmdHis"),
														'transferdate' => 'transferdate',
													 )
											  )
											);
			
			$dom->formatOutput = true;
			file_put_contents($filename, $dom->saveXML());

			$dab = new CDAB();
			$dab_rs = $dab->sellFile($csv_dir, date("Ynd") . '_DAB_Sell.xml');

			if ($dab_rs == 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FileName"    => new SOAP_Value( "FileName", "string", "result_". date("Ynd") . '_DAB_Sell.xml' )
						)
				);

				$resultFileName = 'result_'. date("Ynd") . '_DAB_Sell.xml';				
				$query = sprintf("UPDATE %s SET DABSell='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $resultFileName, date("Y-m-d") );

			} else {
				$this->_ERROR_CODE = 34362 . " ". $dab_rs;
				$query = sprintf("UPDATE %s SET DABSell='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $dab_rs, date("Y-m-d") );
			}

			$rs = $this->_MDB2_WRITE->extended->getRow($query);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAllCancelBidForXML
		Description: 
		Input: 
		Output: 
	*/	
	function getAllCancelBidForXML($OrderDate, $BankID) {
		$function_name = 'getAllCancelBidForXML';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) || !required($BankID) ) {
			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34365;

			if ( !required($OrderDate) ) 
				$this->_ERROR_CODE = 34366;

		} else {
			$query = sprintf( "CALL sp_getAllCancelBidForXML('%s', %u )", $OrderDate, $BankID );

			$path =  DAB_PATH;
			$date_array = getdate();
			$csv_dir = $path . $date_array['year'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}
			$csv_dir = $csv_dir . $date_array['mon'].'/';
			if (!is_dir($csv_dir)){
				mkdir( $csv_dir, 0777 ); 
			}

			$filename = $csv_dir . date("Ynd") . '_DAB_CancelBidForXML.xml';
			$query2xml = XML_Query2XML::factory($this->_MDB2);

			if (file_exists($filename)) {
				$this->_ERROR_CODE = 34205;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$dom = $query2xml->getXML( $query , 
											array(
												 'rootTag' => 'AllCancelBid',
												 'idColumn' => false,
												 'rowTag' => 'CancelBid',
												'elements' => array(
														'custaccount' => 'custaccount',
														'scraccount' => 'scraccount',
														'refno' => 'refno', 
														'amount' => 'amount', 
													 )
											  )
											);
			
			$dom->formatOutput = true;
			file_put_contents($filename, $dom->saveXML());

			$dab = new CDAB();
			$dab_rs = $dab->releaseBidFile($csv_dir, date("Ynd") . '_DAB_CancelBidForXML.xml');
			if ($dab_rs == 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"FileName"    => new SOAP_Value( "FileName", "string", "result_". date("Ynd") . '_DAB_CancelBidForXML.xml' )
						)
				);

				$resultFileName = 'result_'. date("Ynd") . '_DAB_CancelBidForXML.xml';				
				$query = sprintf("UPDATE %s SET DABCancel='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $resultFileName, date("Y-m-d") );

			} else {
				$this->_ERROR_CODE = 34367 ." ". $dab_rs;
				$query = sprintf("UPDATE %s SET DABCancel='%s' WHERE TradingDate='%s'", TBL_JOB_CALENDAR, $dab_rs, date("Y-m-d") );
			}

			$rs = $this->_MDB2_WRITE->extended->getRow($query);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getDABLockMoneyFile
		Description: 
		Input: 
		Output: 
	*/	
	function getDABLockMoneyFile() {
		$function_name = 'getDABLockMoneyFile';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$path =  DAB_PATH;
		$date_array = getdate();
		$csv_dir = $path . $date_array['year'].'/';
		if (!is_dir($csv_dir)){
			mkdir( $csv_dir, 0777 ); 
		}
		$csv_dir = $csv_dir . $date_array['mon'].'/';
		if (!is_dir($csv_dir)){
			mkdir( $csv_dir, 0777 ); 
		}

		$dab = new CDAB();
		$dab_rs = $dab->releaseBidFile($_SERVER['DOCUMENT_ROOT'].'/', 'getBid.xml');
		if ($dab_rs == 0) {

			$directory = DAB_FILE_PATH . $date_array['year'].'/'.$date_array['mon'].'/';//date("Y/m/");;
			$FileName = 'result_getBid.xml';

			if (file_exists($directory . $FileName)) {
				$size = filesize($directory . $FileName);
				$handle = fopen($directory . $FileName, "r");
				$stream = fread($handle, $size ? $size : 1000000);
				 
				$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $this->class_name .'}'.$function_name.'Struct',
								array(
									'FileContent'  => $stream)
								);
				fclose($handle);
			} else {
				$this->_ERROR_CODE = 18130;//File does not exist
			}

		} else {
			$this->_ERROR_CODE = 34367 ." ". $dab_rs;
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: DABgetListOrderInfo
		Description: 
		Input: 
		Output: 
	*/	
	function DABgetListOrderInfo($OrderDate) {
		$function_name = 'DABgetListOrderInfo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_DAB_getListOrderInfo('%s')", $OrderDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Value"    => new SOAP_Value("Value", "string", $result[$i]['value'])
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: DABgetResultFile
		Description: 
		Input: 
		Output: 
	*/	
	function DABgetResultFile($FileName) {
		$class_name = $this->class_name;
		$function_name = 'DABgetResultFile';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// find directory 		result_20071012_DAB_Sell.xml
		$directory = DAB_FILE_PATH;
		$arrFile = explode("_", $FileName);
		$directory .= substr($arrFile[1], 0, 4 ) . "/"; //2007
		$directory .= substr($arrFile[1], 4, -2 ) . "/"; //10

		if (file_exists($directory . $FileName)) {
			$size = filesize($directory . $FileName);
			$handle = fopen($directory . $FileName, "r");
			$stream = fread($handle, $size ? $size : 1000000);
			 
			$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'FileContent'  => $stream)
							);
			fclose($handle);
		}else{
			$this->_ERROR_CODE = 18130;//File does not exist
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: CheckTransaction
		Description: 
		Input: 
		Output: 
	*/	
	function CheckTransaction() {
		$function_name = 'CheckTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = "CALL sp_ChkTransaction()";
		$result = $this->_MDB2->extended->getRow($query);
		$this->_ERROR_CODE = $result['varerror'];
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getBuyInfo
		Description: 
		Input: 
		Output: 
	*/	
	function getBuyInfo($OrderDate) {
		$function_name = 'getBuyInfo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getAuctionForXML_Transaction('%s' )", $OrderDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['scraccount']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['amount']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getBuyInfoForChecking
		Description: 
		Input: 
		Output: 
	*/	
	function getBuyInfoForChecking() {
		$function_name = 'getBuyInfoForChecking';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$arrAccountNo = explode("\t", PAGODA_ACCOUNT );
		$strAccountNo = "'";
		for($i=0; $i<count($arrAccountNo); $i++) {
			$strAccountNo .= $arrAccountNo[$i];
			if ($i < count($arrAccountNo)-1)
				$strAccountNo .= "', ";
			else 
				$strAccountNo .= "'";
		}

		$query = sprintf( "SELECT a.AccountNo, LogMoney1 
								FROM money_balance mb,account a 
								WHERE LogMoney1 > 0 
								AND AccountNo NOT IN (%s) 
								AND mb.AccountID = a.ID", $strAccountNo );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"LogMoney"    => new SOAP_Value("Amount", "string", $result[$i]['logmoney1']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getSellInfo
		Description: 
		Input: 
		Output: 
	*/	
	function getSellInfo($OrderDate) {
		$function_name = 'getSellInfo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getAllSellForXML_Transaction('%s' )", $OrderDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['scraccount']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['amount']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getSellInfoForChecking
		Description: 
		Input: 
		Output: 
	*/	
	function getSellInfoForChecking() {
		$function_name = 'getSellInfoForChecking';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$arrAccountNo = explode("\t", PAGODA_ACCOUNT );
		$strAccountNo = "'";
		for($i=0; $i<count($arrAccountNo); $i++) {
			$strAccountNo .= $arrAccountNo[$i];
			if ($i < count($arrAccountNo)-1)
				$strAccountNo .= "', ";
			else 
				$strAccountNo .= "'";
		}

		$query = sprintf( "SELECT a.AccountNo, TMoney 
								FROM money_balance mb, account a 
								WHERE TMoney > 0 
								AND AccountNo NOT IN (%s)
								AND mb.AccountID=a.ID ", $strAccountNo );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"TMoney"    => new SOAP_Value("TMoney", "string", $result[$i]['tmoney']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getSellInfoForBravo
		Description: 
		Input: 
		Output: 
	*/	
	function getSellInfoForBravo($OrderDate) {
		$function_name = 'getSellInfoForBravo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getSellingValueAndFeeListForBravo('%s')", $OrderDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['value']),
						"Fee"    => new SOAP_Value("Fee", "string", $result[$i]['commission']),
						"BranchName"    => new SOAP_Value("BranchName", "string", $result[$i]['branchname']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getBuyInfoForBravo
		Description: 
		Input: 
		Output: 
	*/	
	function getBuyInfoForBravo($OrderDate) {
		$function_name = 'getBuyInfoForBravo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getBuyingValueAndFeeListForBravo('%s')", $OrderDate );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['value']),
						"Fee"    => new SOAP_Value("Fee", "string", $result[$i]['commission']),
						"BranchName"    => new SOAP_Value("BranchName", "string", $result[$i]['branchname']),
						)
				);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getSellInfoForBravoChecking
		Description: 
		Input: 
		Output: 
	*/	
	function getSellInfoForBravoChecking() {
		$function_name = 'getSellInfoForBravoChecking';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT a.AccountNo, TMoney 
								FROM money_balance mb, account a  
								WHERE TMoney > 0 
								AND mb.AccountID=a.ID " );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"TMoney"    => new SOAP_Value("TMoney", "string", $result[$i]['tmoney']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getBuyInfoForBravoChecking
		Description: 
		Input: 
		Output: 
	*/	
	function getBuyInfoForBravoChecking() {
		$function_name = 'getBuyInfoForBravoChecking';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT a.AccountNo, LogMoney1 
								FROM money_balance mb, account a 
								WHERE LogMoney1 > 0 
								AND mb.AccountID = a.ID" );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"LogMoney"    => new SOAP_Value("LogMoney", "string", $result[$i]['logmoney1']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editMoney
		Description: 
		Input: 
		Output: 
	*/	
	function editMoney($OrderID, $NewValue) {
		$function_name = 'editMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, %s.ID, %s.OrderDate, UnitCode, OrderQuantity * OrderPrice * (1 + OrderAgencyFee) as OldOrderValue
								FROM vw_ListAccountBank_Detail, %s
								WHERE %s.ID = %u
								AND %s.Deleted='0'
								AND %s.OrderSideID=%u
								AND %s.OrderStockStatusID IN (%u, %u, %u, %u)
								AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
								AND vw_ListAccountBank_Detail.BankID = %s.BankID ", 
								TBL_ORDER, TBL_ORDER, // SELECT
								TBL_ORDER, // FROM
								TBL_ORDER, $OrderID,
								TBL_ORDER, //Deleted
								TBL_ORDER, ORDER_BUY, //Side
								TBL_ORDER, ORDER_TRANSFERED, ORDER_MATCHED, ORDER_FAILED, ORDER_INCOMPLETE_MATCHED, //status
								TBL_ORDER, //AccountID
								TBL_ORDER ); // BankID
		$result = $this->_MDB2->extended->getRow($query);

		if ($result['id'] > 0){
			switch ($result['bankid']) {
				case DAB_ID:
					$dab = &new CDAB();
					$dab_rs = $dab->editBlockMoney($result['bankaccount'], $result['accountno'], $OrderID, $NewValue );
					break;
	
				case VCB_ID:
					$dab = &new CVCB();
					$oldOrderID = $OrderID . $result['unitcode'];
					$suffix = date("His");
					$newOrderID = $OrderID . $suffix;
					$dab_rs = $dab->editBlockMoney($result['accountno'], $oldOrderID, $newOrderID, $result['oldordervalue'], $NewValue );
					break;

				case NVB_ID:
					$dab = &new CNVB();
					$dab_rs = $dab->editBlockMoney(substr($OrderID .date("His"), 3), $result['bankaccount'], $NewValue, $OrderID);
					break;

				case OFFLINE:
					$query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $result['accountno'], OFFLINE, $OrderID, $NewValue, $function_name);
					$this->_MDB2_WRITE->connect();
					$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
					$this->_MDB2_WRITE->disconnect();
					$dab_rs = $off_rs['varerror'];
					break;
			} //switch

			if ($dab_rs != 0) { // fail
				switch ($result['bankid']) {
					case DAB_ID:
						switch ($dab_rs) {
							case '-1':
								$this->_ERROR_CODE = 41040;
								break;
			
							case '-2':
								$this->_ERROR_CODE = 41041;
								break;
			
							case '-3':
								$this->_ERROR_CODE = 41042;
								break;
			
							case '-4':
								$this->_ERROR_CODE = 41043;
								break;
			
							case '-5':
								$this->_ERROR_CODE = 41044;
								break;
			
							case '1':
								$this->_ERROR_CODE = 41045;
								break;
		
							case '2':
								$this->_ERROR_CODE = 41046;
								break;
		
							case '3':
								$this->_ERROR_CODE = 41047;
								break;
		
							case '4':
								$this->_ERROR_CODE = 41048;
								break;
	
							case '5':
								$this->_ERROR_CODE = 41050;
								break;
	
							case '6':
								$this->_ERROR_CODE = 41051;
								break;
	
							case '7':
								$this->_ERROR_CODE = 41052;
								break;
		
							case '99':
								$this->_ERROR_CODE = 41049;
								break;
		
							default:
								$this->_ERROR_CODE = $dab_rs;
						}
						break;
					
					case VCB_ID:
						$arrErr = explode('_', $dab_rs);
						$this->_ERROR_CODE = $arrErr[1];
						break;
						
					case NVB_ID:
						$this->_ERROR_CODE = $dab_rs;
						break;

					case OFFLINE:
						switch ($dab_rs) {
							case '-1':
								$this->_ERROR_CODE = 30670;
								break;
	
							case '-2':
								$this->_ERROR_CODE = 30671;
								break;
	
							case '-3':
								$this->_ERROR_CODE = 30672;
								break;
	
							case '-4':
								$this->_ERROR_CODE = 30673;
								break;
	
							case '-5':
								$this->_ERROR_CODE = 30674;
								break;

							default:
								$this->_ERROR_CODE = $dab_rs;
						}
						break;
				}//switch
			} else {// bank successful
				if ($result['bankid'] == VCB_ID) {
					$query = sprintf( " CALL sp_updateUnitCode(%u, '%s' )", $OrderID, $suffix);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
				}
			} // if bank
		} else {
			$this->_ERROR_CODE = 30041;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: cutMoney
		Description: 
		Input: 
		Output: 
	*/	
	function cutMoney($OrderID) {
		$function_name = 'cutMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getAuctionForAnOrder(%u)", $OrderID); 
		$result = $this->_MDB2->extended->getRow($query);

		if ($result['bankid'] > 0){
			switch ($result['bankid']) {
				case DAB_ID:
					$dab = &new CDAB();
					$dab_rs = $dab->cutMoney($result['custaccount'], $result['scraccount'], $OrderID, $result['amount'], $result['fee']);
					break;
	
				case VCB_ID:
					$dab = &new CVCB();
					$NewValue = $result['amount'] + $result['fee'];
					$dab_rs = $dab->cutMoney($result['scraccount'], $OrderID, $NewValue );
					break;

				case NVB_ID:
					$dab = &new CNVB();
					$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?> 
							<DOCUMENT>";
					$xml .= "<BATCHID>". date("dmYHis") ."</BATCHID>"; 
					$xml .= "<CURR>VND</CURR>"; 
					$xml .= "<TRANSACTION>"; 
					$xml .= "<CREDITACCOUNT>". EPS_NVB . "</CREDITACCOUNT>"; 
					$xml .= "<DEBITACCOUNT>". $result['custaccount'] . "</DEBITACCOUNT>"; 
					$xml .= "<AMOUNT>". $result['amount'] ."</AMOUNT>"; 
					$xml .= "<FEEAMT>". $result['fee'] ."</FEEAMT> ";
					$xml .= "<TRANSACTIONCODE>". $OrderID ."</TRANSACTIONCODE>";
					$xml .= "<DECS>Cat tien lenh $OrderID </DECS>";
					$xml .= "</TRANSACTION>"; 
					$xml .= "</DOCUMENT>"; 
					$dab_rs = $dab->cutMoney(time(), $xml);
					break;	
			} //switch

			if ($dab_rs != 0) { // fail
				switch ($dab_rs) {
					case '-1':
						$this->_ERROR_CODE = 41070;
						break;
	
					case '-2':
						$this->_ERROR_CODE = 41071;
						break;
	
					case '-3':
						$this->_ERROR_CODE = 41072;
						break;
	
					case '-4':
						$this->_ERROR_CODE = 41073;
						break;
	
					case '-5':
						$this->_ERROR_CODE = 41074;
						break;
	
					case '1':
						$this->_ERROR_CODE = 41075;
						break;

					case '2':
						$this->_ERROR_CODE = 41076;
						break;

					case '99':
						$this->_ERROR_CODE = 41077;
						break;

					default:
						$this->_ERROR_CODE = $dab_rs;
				} //switch

			} // if bank
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertMissingDeal
		Description: update a Buy order
		Input: 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'OrderSideName', 'StockExchangeID', 'OrderDate'
		Output: success / error code
	*/
	function insertMissingDeal($OrderNumber, $AccountNo, $Symbol, $StockExchangeID, $Quantity, $Price, $OrderSideID, $Session, $TradingDate, $Note, $CreatedBy) {
		$function_name = 'insertMissingDeal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !required($AccountNo) || !required($Symbol) || !required($StockExchangeID) || !unsigned($StockExchangeID) 
				|| !required($Quantity) || !unsigned($Quantity) || !required($Price) || !unsigned($Price) || !required($OrderSideID) || !unsigned($OrderSideID) 
				|| !required($Session) || !unsigned($Session) || !required($TradingDate) ) {

			if ( !required($OrderNumber) )
				$this->_ERROR_CODE = 34390;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34391;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 34392;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 34393;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 34394;

			if ( !required($Price) || !unsigned($Price)  )
				$this->_ERROR_CODE = 34395;

			if ( !required($OrderSideID) || !unsigned($OrderSideID)  )
				$this->_ERROR_CODE = 34396;

			if ( !required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 34397;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 34398;

		} else {
			$query = sprintf( "CALL sp_insertMissingDeal('%s', '%s', '%s', %u, %u, %f, %u, %u, '%s', '%s', '%s')", 
							$OrderNumber, $AccountNo, $Symbol, $StockExchangeID, $Quantity, $Price, $OrderSideID, $Session, $TradingDate, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34399;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34400;
							break;

						case '-2':
							$this->_ERROR_CODE = 34401;
							break;

						case '-3':
							$this->_ERROR_CODE = 34402;
							break;

						case '-4':
							$this->_ERROR_CODE = 34403;
							break;

						case '-5':
							$this->_ERROR_CODE = 34404;
							break;

						case '-6':
							$this->_ERROR_CODE = 34405;
							break;

						case '-8':
							$this->_ERROR_CODE = 34406;
							break;

					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderID"    => new SOAP_Value( "OrderID", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getOrderListToEditOrAuction
		Description: 
		Input: 
		Output: 
	*/	
	function getOrderListToEditOrAuction($OrderID, $AccountNo) {
		$function_name = 'getOrderListToEditOrAuction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getOrderListToEditOrAuction('%s', '%s')", $OrderID, $AccountNo);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"OrderSide"    => new SOAP_Value("OrderSide", "string", $result[$i]['orderside']),
						)
				);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: cutMoney
		Description: 
		Input: 
		Output: 
	*/	
	function getMoneyBeforeCutting($OrderID) {
		$function_name = 'getMoneyBeforeCutting';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getAuctionForAnOrder(%u)", $OrderID); 
		$result = $this->_MDB2->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
				'item',
				$struct,
				array(
					"TotalAmount"    => new SOAP_Value( "TotalAmount", "string", $result['amount'] + $result['fee'] )
					)
			);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: calculateAveragePrices
	*/
	function calculateAveragePrices() {
		$function_name = 'calculateAveragePrices';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_aaaInsertAvgPrice()");
		$this->_MDB2_WRITE->extended->getRow($query);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	
	/**
		Function: getOrderTempMissingList
		Description: 
		Input: $OrdeDate, $IsValid, $StockExchangeID
		Output: 
	*/	
	function getOrderTempMissingList($OrdeDate, $IsValid, $StockExchangeID) {
		$function_name = 'getOrderTempMissingList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getOrderTempMissingList('%s', '%s', %u)", $OrdeDate, $IsValid, $StockExchangeID);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"OrderStyleID"    => new SOAP_Value("OrderStyleID", "string", $result[$i]['orderstyleid']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"StockExchange"    => new SOAP_Value("StockExchange", "string", $result[$i]['stockexchange']),
						"OrderMissingStatus"    => new SOAP_Value("OrderMissingStatus", "string", $result[$i]['ordermissingstatus']),
						)
				);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		'updateOrderTempMissing' => array( 'input' => array( 'OrderID', 'AccountNo'),
											'output' => array( )),
		Function: updateOrderTempMissing
		Description: update 
		Input: 'OrderID', 'AccountNo'
		Output: success / error code
	*/
	function updateOrderTempMissing($OrderID, $AccountNo) {
		$function_name = 'updateOrderTempMissing';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($AccountNo) ) {

			if ( !required($OrderID) )
				$this->_ERROR_CODE = 34500;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34501;
			

		} else {
			$query = sprintf( "CALL sp_updateOrderTempMissing(%u, '%s')", $OrderID, $AccountNo);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34502;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1'://Exception
							$this->_ERROR_CODE = 34503;
							break;

						case '-2'://;/*Ko ton tai hay order nay da dc xu ly roi*/
							$this->_ERROR_CODE = 34504;
							break;

						case '-3':/*AccountNo ko hop le*/
							$this->_ERROR_CODE = 34505;
							break;

						case '-4':;/*Symbol ko hop le*/
							$this->_ERROR_CODE = 34506;
							break;

						case '-5':;/*ko dc mua ban mot loai ck trong cung ngay*/
							$this->_ERROR_CODE = 34507;
							break;

					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		
		Function: updateOrderTempMissingIsValidField
		Description: update 
		Input: 'OrderID'
		Output: success / error code
	*/
	function updateOrderTempMissingIsValidField($OrderID) {
		$function_name = 'updateOrderTempMissingIsValidField';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID)) {

				$this->_ERROR_CODE = 34500;

		} else {
			$query = sprintf( "CALL sp_updateOrderTempMissingIsValidField(%u)", $OrderID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_ERROR_CODE = 0;
			/*if (empty( $rs)) {
				$this->_ERROR_CODE = 34508;
			} else {
				$result = $rs['varerror'];
				
			}*/
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		
		Function: changeOrderStatusToFailed
		Description: change status 
		Input: 'OrderID', 'CreatedBy'
		Output: success / error code
	*/
	function changeOrderStatusToFailed($OrderID, $CreatedBy) {
		$function_name = 'changeOrderStatusToFailed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID)) {

				$this->_ERROR_CODE = 34500;

		} else {
			$query = sprintf( "CALL sp_changeOrderStatusToFailed(%u, '%s')", $OrderID, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			switch ($rs['varerror']){
				case -1:
					$this->_ERROR_CODE = 34511;//database error
					break;
				case -2:
					$this->_ERROR_CODE = 34516;//ko the thay doi trang thai cua order nay
					break;
				default:
					$this->_ERROR_CODE = $rs['varerror'];
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		
		Function: deleteDeal
		Description: delete 
		Input: 'ID'
		Output: success / error code
	*/
	function deleteDeal($ID) {
		$function_name = 'deleteDeal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID)) {

				$this->_ERROR_CODE = 34525;

		} else {
			$query = sprintf( "CALL sp_deleteDeal(%u)", $ID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			
			if (empty( $rs)) {
				$this->_ERROR_CODE = 34526;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1'://Exception
							$this->_ERROR_CODE = 34527;
							break;

						case '-2'://*ko the xoa deal nay*/
							$this->_ERROR_CODE = 34528;
							break;

					}
				}
				else $this->_ERROR_CODE = 0;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		Function: editDeal
		Description: update a deal
		Input: 'ID', 'AccountNo', 'Quantity', 'CreatedBy'
		Output: / error code
	*/
	function editDeal($ID, $AccountNo, $Quantity, $CreatedBy) {
		$function_name = 'editDeal';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($AccountNo) || !required($Quantity) || !unsigned($Quantity) || !required($CreatedBy) ) {

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 34529;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34530;

			if ( !required($Quantity) || !unsigned($Quantity))
				$this->_ERROR_CODE = 34531;

			if ( !required($CreatedBy) )
				$this->_ERROR_CODE = 34532;

		} else {
			$query = sprintf( "CALL sp_editDeal(%u, '%s', %u, '%s')", $ID, $AccountNo, $Quantity, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34533;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34534;
							break;

						case '-2':
							$this->_ERROR_CODE = 34535;
							break;

						case '-3':
							$this->_ERROR_CODE = 34536;
							break;

						case '-6':
							$this->_ERROR_CODE = 34537;
							break;

						case '-7':
							$this->_ERROR_CODE = 34538;
							break;
					}
				}
				else $this->_ERROR_CODE = 0;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/**
		Function: getListStockDetailForExecTrans
		Description: 
		Input: 
		Output: 
	*/	
	function getListStockDetailForExecTrans($TradingDate, $AccountNo, $StockExchangeID) {
		$function_name = 'getListStockDetailForExecTrans';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34538;

		} else {
			$query = sprintf( "CALL sp_GetListStockDetailForExecTrans('%s', '%s', %u)", $TradingDate, $AccountNo, $StockExchangeID );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
							"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
							"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
							"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
							"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee']),
							"IsExist"    => new SOAP_Value("IsExist", "string", $result[$i]['isexist']),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	/* 24/07/2008  Chi */
		/**
		Function: getStockBalanceListForTTBT
		Description: 
		Input: 
		Output: 
	*/	
	function getStockBalanceListForTTBT($TradingDate, $AccountNo) {
		$function_name = 'getStockBalanceListForTTBT';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34518;

		} else {
			$query = sprintf( "CALL sp_getStockBalanceListForTTBT('%s', '%s' )", $TradingDate , $AccountNo);
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"T3Quantity"    => new SOAP_Value("T3Quantity", "string", $result[$i]['t3quantity']),
							"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
		/**
		Function: executeStockTTBTPrivateAccount
		Description: 
		Input: 'AccountID', 'StockID', 'T3Quantity', 'TradingDate'
		Output: ID or vaerror
	*/	
	function executeStockTTBTPrivateAccount($AccountID, $StockID, $T3Quantity, $TradingDate) {
		$function_name = 'executeStockTTBTPrivateAccount';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate)) {
			$this->_ERROR_CODE = 34518;
		}else if(!required($AccountID)){
			$this->_ERROR_CODE = 34519;
		}else if(!required($StockID)){
			$this->_ERROR_CODE = 34520;
		}else if(!required($T3Quantity)){
			$this->_ERROR_CODE = 34521;
		} else {
			$query = sprintf( "CALL sp_executeStockTTBTPrivateAccount(%u, %u, '%s', '%s')", $AccountID, $StockID, $T3Quantity, $TradingDate );
			$result = $this->_MDB2_WRITE->extended->getAll($query);
				//Can not add
				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 34522;	
					 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4], DEBUG_PATH);
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
									'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror']),
									)
							);
						}else 
						{
							if($result[0]['varerror'] < 0){
								$this->_ERROR_CODE = 34523;
								write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],DEBUG_PATH);
							}
											
						}
					}				
				}		
			
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/* END 24/07/2008  Chi */

	/**	
		Function: getAdditionCommission
	*/
	function getAdditionCommission($TradingDate, $UpdatedBy) {
		$function_name = 'getAdditionCommission';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getAdditionallyCommission('%s')", $TradingDate);
		$rs = $this->_MDB2->extended->getAll($query);
		$count = count($rs);
		
		for($i=0; $i<$count; $i++) {
			$dab_rs = 999;
			switch ($rs[$i]['bankid']) {
				case DAB_ID:
					$dab = &new CDAB();
					$description = "Phu thu phi giao dich";
					$contractno = "PTDG ". $rs[$i]['accountno'] ." ". $rs[$i]['orderid'];
					$dab_rs = $dab->transfertoEPS($rs[$i]['bankaccount'], $rs[$i]['accountno'], $contractno, $rs[$i]['additionallycommission'], $description);
					break;

				case VCB_ID:
					$dab_rs = 666;
					break;
			}

			if ($dab_rs == 0) { //Successfully
				$query = sprintf( "CALL sp_updateIsExecOfAdditionallyCommission(%u, '%s')", $rs[$i]['orderid'], $UpdatedBy);
				$history_rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();


			} else { // bank fail
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
						$this->_ERROR_CODE = 'DAB'. $dab_rs;
				} //switch
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertAdditionallyCommission
	*/	
	function insertAdditionallyCommission($TradingDate, $MinCommission, $CreatedBy) {
		$function_name = 'insertAdditionallyCommission';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) || !required($MinCommission) ) {
			if ( !required($TradingDate) ) 
				$this->_ERROR_CODE = 34425;

			if ( !required($MinCommission) ) 
				$this->_ERROR_CODE = 34426;

		} else {
			$query = sprintf( "CALL sp_insertAdditionallyCommission('%s', %f, '%s')", $TradingDate, $MinCommission, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34427;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34428;
							break;

						case '-2':
							$this->_ERROR_CODE = 34429;
							break;

					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: lockMoney
	*/
	function lockMoney( $OrderID, $Amount, $AccountNo) {
		$function_name = 'lockMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($Amount) || !unsigned($Amount) || !required($AccountNo) ) {

			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 34430;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 34431;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 34432;

		} else {
			//block money in bank
			$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
			$bank_rs = $this->_MDB2->extended->getAll($query);
	
			$dab_rs = 999;

			for($i=0; $i<count($bank_rs); $i++) {

				switch ($bank_rs[$i]['bankid']) {
					case DAB_ID:
						$dab = &new CDAB();
						$dab_rs = $dab->blockMoney($bank_rs[$i]['bankaccount'], $bank_rs[$i]['cardno'], $AccountNo, $OrderID, $Amount, date('Y-m-d') );
						break;

					case VCB_ID:
						$dab = &new CVCB();
						$suffix = date("His");
						$newOrderID = $OrderID . $suffix;
						$dab_rs = $dab->blockMoney( $AccountNo, $newOrderID, $Amount);
	
						$query = sprintf( " CALL sp_updateUnitCode(%u, '%s' )", $OrderID, $suffix);
						$rs = $this->_MDB2_WRITE->extended->getRow($query);
						$this->_MDB2_WRITE->disconnect();
						$this->_MDB2_WRITE->connect();
						break;

					case NVB_ID:
						$dab = &new CNVB();
						$dab_rs = $dab->blockMoney(substr($OrderID . date("His"), 3), $bank_rs[$i]['bankaccount'], $Amount, $OrderID);
						break;

					case OFFLINE:
						$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $OrderID, $Amount, $OrderDate, $CreatedBy);
						$this->_MDB2_WRITE->connect();
						$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
						$this->_MDB2_WRITE->disconnect();										
						$dab_rs = $off_rs['varerror'];
						break;
				}

				if ($dab_rs == 0){
					$query = sprintf( "CALL sp_updateBankIDWhenInsertWarningOrder( %u, %u ) ", $OrderID, $bank_rs[$i]['bankid'] );
					$status_rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $status_rs)) {
						$this->_ERROR_CODE = 34145;
					} 

					break;
				}
			}
	
			if ($dab_rs != 0) { //fail
				$i = $i - 1;
				switch ($bank_rs[$i]['bankid']) {
					case DAB_ID:
						switch ($dab_rs) {
							case '-1':
								$this->_ERROR_CODE = 41020;
								break;
			
							case '-2':
								$this->_ERROR_CODE = 41021;
								break;
			
							case '-3':
								$this->_ERROR_CODE = 41022;
								break;
			
							case '-4':
								$this->_ERROR_CODE = 41023;
								break;
			
							case '-5':
								$this->_ERROR_CODE = 41024;
								break;
			
							case '1':
								$this->_ERROR_CODE = 41025;
								break;
		
							case '2':
								$this->_ERROR_CODE = 41026;
								break;
		
							case '3':
								$this->_ERROR_CODE = 41027;
								break;
		
							case '4':
								$this->_ERROR_CODE = 41028;
								break;

							case '5':
								$this->_ERROR_CODE = 41030;
								break;
		
							case '99':
								$this->_ERROR_CODE = 41029;
								break;
		
							default:
								$this->_ERROR_CODE = $dab_rs;
						}
						break;

					case VCB_ID:
						$this->_ERROR_CODE = $dab_rs;
						break;
						
					case NVB_ID:
						$this->_ERROR_CODE = $dab_rs;
						break;

					case OFFLINE:
						switch ($dab_rs) {
							case '-1':
								$this->_ERROR_CODE = 30650;
								break;
			
							case '-2':
								$this->_ERROR_CODE = 30651;
								break;
			
							case '-3':
								$this->_ERROR_CODE = 30652;
								break;
			
							case '-4':
								$this->_ERROR_CODE = 30653;
								break;
		
							default:
								$this->_ERROR_CODE = $dab_rs;
						}
						break;
				}//switch
			} 
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getMatchedOrderUnLocked() {
		$function_name = 'getMatchedOrderUnLocked';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_order_Forecast_MatchedOrderBeUnLocked()");
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getInvalidBankIDOfMatchedOrder() {
		$function_name = 'getInvalidBankIDOfMatchedOrder';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_order_Forecast_InvalidBankIDOfMatchedOrder()");
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getMatchedQuantityGreaterThanOrderQuantity() {
		$function_name = 'getMatchedQuantityGreaterThanOrderQuantity';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_order_Forecast_MatchedQuantityGreaterThanOrderQuantity()");
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity'])
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function confirmBuyOrderForVirtualBank($TradingDate, $BankID) {
		$function_name = 'confirmBuyOrderForVirtualBank';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) || !required($BankID) ) {
			if ( !required($TradingDate) ) 
				$this->_ERROR_CODE = 34440;

			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34441;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_Auction('%s', %u)", $TradingDate, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34442;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34443;
							break;

						case '-2':
							$this->_ERROR_CODE = 34444;
							break;

					}
				} 
			}
		}
	
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function cancelBuyOrderForVirtualBank($TradingDate, $BankID) {
		$function_name = 'cancelBuyOrderForVirtualBank';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($TradingDate) || !required($BankID) ) {
			if ( !required($TradingDate) ) 
				$this->_ERROR_CODE = 34450;

			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34451;

		} else {
			$query = sprintf( "CALL  sp_VirtualBank_UnLockBID('%s', %u)", $TradingDate, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34452;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34453;
							break;

						case '-2':
							$this->_ERROR_CODE = 34454;
							break;

					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getListMatchNotCutMoney($TradingDate, $BankID, $AccountNo) {
		$function_name = 'getListMatchNotCutMoney';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_getListMatchNotCutMoney('%s', %u, '%s')", $TradingDate, $BankID, $AccountNo);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"LockID"    => new SOAP_Value("LockID", "string", $result[$i]['lockid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"Value"    => new SOAP_Value("Value", "string", $result[$i]['value']),
						"Commission"    => new SOAP_Value("Commission", "string", $result[$i]['commission']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getList4Unlock($TradingDate, $BankID, $AccountNo) {
		$function_name = 'getList4Unlock';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_getList4Unlock('%s', %u, '%s')", $TradingDate, $BankID, $AccountNo);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"LockID"    => new SOAP_Value("LockID", "string", $result[$i]['lockid']),
						"BidAmount"    => new SOAP_Value("BidAmount", "string", $result[$i]['bidamount']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function unLockForVirtualBank($AccountID, $LockID, $BankID, $LockAmount, $UpdatedBy) {
		$function_name = 'unLockForVirtualBank';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !required($LockID) || !required($LockAmount) || !required($BankID) ) {
			if ( !required($AccountID) ) 
				$this->_ERROR_CODE = 34460;

			if ( !required($LockID) ) 
				$this->_ERROR_CODE = 34461;

			if ( !required($LockAmount) ) 
				$this->_ERROR_CODE = 34462;

			if ( !required($BankID) ) 
				$this->_ERROR_CODE = 34463;

		} else {
			$query = sprintf( "CALL sp_VirtualBank_UnLock(%u, %u, %u, %f, '%s')", $AccountID, $LockID, $BankID, $LockAmount, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 34464;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 34465;
							break;

						case '-2':
							$this->_ERROR_CODE = 34466;
							break;

						case '-3':
							$this->_ERROR_CODE = 34467;
							break;

						case '-4':
							$this->_ERROR_CODE = 34468;
							break;
					}
				} 
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function checkAuctionForVirtualBank($TradingDate, $BankID) {
		$function_name = 'checkAuctionForVirtualBank';
		$class_name = $this->class_name;
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_VirtualBank_CheckAuction('%s', %u)", $TradingDate, $BankID);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array( 
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['amount']),
						"BidAmount"    => new SOAP_Value("BidAmount", "string", $result[$i]['bidamount']),
						"Delta"    => new SOAP_Value("Delta", "string", $result[$i]['delta']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

}
?>
