<?php
require_once('../includes.php');

/**
	Author: Ly Duong Duy Trung
	Created date: 03/22/2007
*/

class COrder extends WS_Class{
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

		$arr = array( 'listReferenceValues' => array( 'input' => array( 'StockExchangeID', 'OrderDate', 'TimeZone' ),
											'output' => array( 'ReferenceValueID', 'Symbol', 'Floor', 'Ceiling' )),

					'insertReferenceValueForNewStock' => array( 'input' => array( 'Symbol', 'Floor', 'Ceiling', 'TradingDate', 'StockExchangeID' ),
											'output' => array( 'ID' )),

					'listReferenceValuesWithFilter' => array( 'input' => array( 'StockExchangeID', 'OrderDate', 'ListSymbol' ),
											'output' => array( 'ReferenceValueID', 'Symbol', 'Floor', 'Ceiling', 'ReferenceDate', 'StockExchangeID', 'StockID', 'ExchangeName' )),

					'listPostValue' => array( 'input' => array( 'StockKindID', 'StockExchangeID', 'TimeZone' ),
											'output' => array( 'PostUnitID', 'FromValue', 'ToValue', 'PostValue' )),

					'listOrderSides' => array( 'input' => array( 'TimeZone'),
											'output' => array( 'OrderSideID', 'OrderSideName', 'Note' )),

					'listOrderStyles' => array( 'input' => array( 'StockExchangeID', 'TimeZone'),
											'output' => array( 'OrderStyleID', 'OrderStyleName', 'Description' )),

					'listFromTypes' => array( 'input' => array(),
											'output' => array( 'FromTypeID', 'FromName' )),

					'listStockQuantityOfAccount' => array( 'input' => array( 'StockID', 'AccountNo'),
											'output' => array( 'Normal', 'Mortgaged', 'Trading' )),

					'listAllStockQuantityOfAccount' => array( 'input' => array( 'AccountID' ),
											'output' => array( 'StockID', 'Symbol', 'Quantity', 'StockStatusName' )),

					'listOrders' => array( 'input' => array( 'Condition', 'TimeZone' ),
											'output' => array( 'OrderID', 'AccountNo', 'StockID', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideID', 'OrderSideName', 'Session', 'OrderStockStatusID', 'StatusName', 'OrderStyleID', 'OrderStyleName', 'FromName', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'OrderAgencyFee', 'StockExchangeID', 'ExchangeName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'BankName', 'BankShortName', 'CompanyName', 'OldPrice', 'BlockedValue', 'IsNewEdit', 'OrderNumber' )),

					'listOrderForBranch' => array( 'input' => array( 'Condition', 'TimeZone' ),
											'output' => array( "OrderID", "OrderNumber", "AccountID", "StockID", "OrderQuantity", "OrderPrice", "OrderSideID", "Session", "OrderStockStatusID", "OrderStyleID", "FromTypeID", "OldOrderID", "Note", "OrderDate", "IsAssigner", "OrderAgencyFee", "IsGotPaper", "IsEditing", "IsConfirmed", "BankID", "IsUnBlocked", "CreatedBy", "CreatedDate", "UpdatedBy", "UpdatedDate", "Deleted", "OldPrice", "BlockedValue", "IsNewEdit", "AccountNo", "Symbol", "OrderSideName", "StatusName", "OrderStyleName", "FromName", "StockExchangeID", "ExchangeName", "BankName", "BankShortName", "CompanyName", "BranchID")),

					'listMatchedStockQuantity' => array( 'input' => array( 'Condition', 'TimeZone' ),
											'output' => array( 'StockDetailID', 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedAgencyFee', 'OrderSideName', 'MatchedSession', 'TradingDate', 'MatchedAgencyFeeAmount', 'CompanyName', 'CreatedDate' )),

					'deleteOrder' => array( 'input' => array( 'OrderID', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'checkDoubleOrder' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'OrderSideID', 'OrderStyleID', 'OrderDate'),
											'output' => array( 'Count')),

					'changeStatusFromApprovedToTransfering' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'changeStatusFromTransferingToTransfered' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'changeStatusFromTranferingToMatchedOrFailedForCancelOrder' => array( 'input' => array( 'OrderID', 'IsMatched', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'changeStatusFromTranferingToApproved' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'changeATOStatusToExpired' => array( 'input' => array( 'OrderDate'),
											'output' => array()),

					'getTotalQuantityCanBeCanceled' => array( 'input' => array( 'OrderID'),
											'output' => array( 'Quantity' )),

					'insertBuyOrder' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'StockExchangeID', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'updateBuyOrder' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'OrderStyleID', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'insertSellOrder' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'OrderStyleID', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'StockExchangeID', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'updateSellOrder' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'OrderStyleID', 'UpdatedBy' ),
											'output' => array()),

					'insertCancelOrder' => array( 'input' => array( 'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'updateFromApprovedToEditing' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array( )),

					'updateFromEditingToApproved' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array( )),

					'updateIsEditingBeforeEdit' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array( )),

					'updateIsEditingAfterEdit' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array( )),

					'updateQuantityWhenCallCancelOrder' => array( 'input' => array( 'OrderID', 'Quantity' ),
											'output' => array( )),

					'insertReferenceValue' => array( 'input' => array( 'Symbol', 'Floor', 'Ceiling', 'ReferenceDate', 'StockExchangeID' ),
											'output' => array( 'ID' )),

					'insertPhoneCode' => array( 'input' => array( 'AccountNo', 'PhoneCode', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'getPhoneCode' => array( 'input' => array( 'AccountNo' ),
											'output' => array( 'PhoneCode' )),

					'UnLockATOOrder' => array( 'input' => array( 'OrderNumber', 'CancelQuantity', 'OrderDate' ),
											'output' => array()),

					'getCompanyByStock' => array( 'input' => array( 'Symbol' ),
											'output' => array( 'CompanyName' )),

					'getAvailBalanceFromNVB' => array( 'input' => array( 'AccountNo' ),
											'output' => array( 'Balance' )),

					'getATOandATCOrders' => array( 'input' => array( 'OrderDate', 'AccountNo' ),
											'output' => array( 'OrderID', 'AccountID', 'AccountNo', 'OrderNumber',  'OrderSideName', 'Symbol', 'OrderStyleName', 'OrderQuantity', 'OrderPrice', 'StatusName', 'OrderDate', 'UnitCode', 'BankAccount' )),

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						/* HA NOI */
					'insertLOBuyingOrderForHN' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'StockExchangeID', 'IsGotPaper', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'editBuyingOrderForHN' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'insertLOSellingOrderForHN' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'IsGotPaper', 'CreatedBy' ),
											'output' => array( 'ID' )),

					'editSellingOrderForHN' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy' ),
											'output' => array()),

					'deleteOrderForHN' => array( 'input' => array( 'OrderID', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'editPriceOfSellingOrderForHN' => array( 'input' => array( 'OrderID', 'NewOrderPrice', 'UpdatedBy' ),
											'output' => array()),

					'editPriceOfBuyingOrderForHN' => array( 'input' => array( 'OrderID', 'OrderPrice', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'updateFromTransferToEditingForHN' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'updateFromEditingtoTransferForHN' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'updateFromTransferToTransferingForHN' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'updateFromTransferingToTransferForHN' => array( 'input' => array( 'OrderID', 'UpdatedBy' ),
											'output' => array()),

					'updateFromTransferingToTransferWithMatchedOrFailedForHN' => array( 'input' => array( 'OrderID', 'IsMatched', 'UpdatedBy', 'MatchedQuantity' ),
											'output' => array()),

					'insertCancelOrderForHN' => array( 'input' => array( 'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy' ),
											'output' => array( 'OrderID' )),

					'changeStatusFromTranferingToMatchedOrFailedForCancelOrderForHN' => array( 'input' => array( 'OrderID', 'IsMatched', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						/* Chi Them */
					 'listStockDetailByTradingDate' => array( 'input' => array( 'TradingDate' ),
											'output' => array('OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'OrderSideName', 'MatchedSession', 'MatchedAgencyFee', 'IsExist' )),

					 'listStockDetailByTradingDateWithBranchID' => array( 'input' => array( 'TradingDate', 'BranchID' ),
											'output' => array('OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'OrderSideName', 'MatchedSession', 'MatchedAgencyFee', 'IsExist' )),

					'getAvailBalanceFromVCB' => array( 'input' => array('AccountNo'),
											'output' => array( 'Balance' )),
					/*End Chi Them */
					'getRealBalanceFromDAB' => array( 'input' => array( 'DABAccount', 'AccountNo' ),
											'output' => array( 'Balance' )),

					'getAvailBalanceFromDAB' => array( 'input' => array( 'DABAccount', 'AccountNo' ),
											'output' => array( 'Balance' )),

					'updateStatusForOrderWhenEndExecTransaction' => array( 'input' => array( 'OrderDate' ),
											'output' => array( )),

					'updateIsNewEditField' => array( 'input' => array( 'OrderID', 'IsCalled' ),
											'output' => array( )),

					'cancelBlockedMoney' => array( 'input' => array( 'OrderID', 'AccountNo', 'UpdatedBy' ),
											'output' => array( )),

					'getListInvalidFutureBuyingOrder' => array( 'input' => array( 'OrderDate', 'StockExchangeID' ),
											'output' => array( )),

					'GetNextTradingDate' => array( 'input' => array( 'RequestDate' ),
											'output' => array( 'NextDate' )),

					'getFailedOrderListForUnBlocked' => array( 'input' => array( 'AccountNo', 'OrderDate' ),
											'output' => array( 'OrderID', 'OrderDate', 'AccountNo', 'OrderSideName', 'Symbol', 'OrderStyleName', 'OrderQuantity', 'OrderPrice', 'Session', 'StatusName', 'BankID' )),

					'getOrderInfoToCall' => array( 'input' => array( 'OrderID' ),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderStyleName', 'OrderSideName', 'OldOrderID', 'OldPrice', 'Note', 'StockExchangeID', 'IsNewEdit' )),

					'getOrderListToCall' => array( 'input' => array( 'StockExchangeID', 'IsVIP', 'Session', 'OrderDate' ),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideName', 'Note', 'IsNewEdit', 'CreatedDate' )),

					'getOrderInventory' => array( 'input' => array( 'OrderDate' ),
											'output' => array( 'HoSE', 'VIPHose', 'HaSTC', 'VIPHaSTC' )),

					'getDealForBranch' => array( 'input' => array( 'TradingDate', 'AccountNo', 'BranchID' ),
											'output' => array( 'OrderNumber', 'AccountNo', 'OrderSideName', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession' )),

					'getGoodPricesAndVolumns' => array( 'input' => array( 'Symbol', 'TradingDate', 'StockExchangeID' ),
											'output' => array( 'PriorClosePrice', 'Highest', 'Lowest', 'Last', 'Change', 'LastVol', 'Best1Bid', 'Best1BidVolume', 'Best2Bid', 'Best2BidVolume', 'Best3Bid', 'Best3BidVolume', 'Best1Offer', 'Best1OfferVolume', 'Best2Offer', 'Best2OfferVolume', 'Best3Offer', 'Best3OfferVolume' )),

					'getTempQuantity' => array( 'input' => array( 'AccountID', 'StockID', 'OrderDate' ),
											'output' => array( 'TempQuantity' )),

					'list10MatchedDeals' => array( 'input' => array( 'Symbol' ),
											'output' => array( 'Symbol', 'Price', 'Volumn', 'Time' )),

					'displayOrder' => array( 'input' => array( 'StockExchangeID', 'IsVIP', 'OrderDate', 'UpdatedBy' ),
											'output' => array( 'ID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideName', 'Note', 'OrderStyleName' )),

					'newDisplayOrderForHN' => array( 'input' => array( 'IsVIP', 'OrderDate' ),
											'output' => array( 'ID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideName', 'Note', 'OrderStyleName' )),

					'getTradingCode' => array( 'input' => array( 'AccountNo' ),
											'output' => array( 'TradingCode' )),

					'insertLOBuyingOrderForHNX' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'OrderDate', 'CreatedBy' ),
											'output' => array( 'ID' )),
					/* Chi them ngay 04-03-2010 */

					'insertTradeForHNX' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
									'output' => array(  )),
					/* End Chi them ngay 04-03-2010 */
          'checkInvalidDate' => array( 'input' => array( 'TradingDate' ),
                  'output' => array( 'Boolean' )),
						);

		parent::__construct($arr);
	}

	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}

	/**
		Function: listReferenceValues
		Description: list lReference Values
		Input: time_zone
		Output: ???
	*/
    function listReferenceValues($StockExchangeID, $OrderDate, $time_zone) {
		$function_name = 'listReferenceValues';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockExchangeID) || !unsigned($StockExchangeID) ) {
			$this->_ERROR_CODE = 30001;
		} else {
			$query = sprintf( "SELECT %s.StockID, Symbol, Floor, Ceiling
								FROM %s, %s
								WHERE %s.StockExchangeID = %s.ID
								AND %s.ID=%u
								AND ReferenceDate='%s'
								ORDER BY Symbol",
							TBL_REFERENCE_VALUE,
							TBL_REFERENCE_VALUE, TBL_STOCK_EXCHANGE,
							TBL_REFERENCE_VALUE, TBL_STOCK_EXCHANGE,
							TBL_STOCK_EXCHANGE, $StockExchangeID,
							$OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ReferenceValueID"    => new SOAP_Value("ReferenceValueID", "string", $result[$i]['stockid']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"Floor"    => new SOAP_Value("Floor", "string", $result[$i]['floor']),
							"Ceiling"    => new SOAP_Value("Ceiling", "string", $result[$i]['ceiling'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	function insertReferenceValueForNewStock($Symbol, $Floor, $Ceiling, $TradingDate, $StockExchangeID){
		$function_name = 'insertReferenceValueForNewStock';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($Symbol) || !required($Floor) || !required($Ceiling) || !required($StockExchangeID) || !unsigned($StockExchangeID) || !required($TradingDate) ) {
			if ( !required($Symbol) )
				$this->_ERROR_CODE = 30605;

			if ( !required($Floor) )
				$this->_ERROR_CODE = 30606;

			if ( !required($Ceiling) )
				$this->_ERROR_CODE = 30607;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 30608;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 30609;

		} else {
			$query = sprintf( "CALL sp_order_insertReferenceValueForNewStock('%s', %u, %u, '%s', %u)", $Symbol, $Floor, $Ceiling, $TradingDate, $StockExchangeID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30610;

			} else {
				$return = $rs['varerror'];
				if($return < 0) {
					switch($return) {
						case -1:
							$this->_ERROR_CODE = 30611;
							break;

						case -2:
							$this->_ERROR_CODE = 30612;
							break;
					}
				} else {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $return)
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listReferenceValuesWithFilter
		Description: list lReference Values
		Input: time_zone
		Output: ???
	*/
    function listReferenceValuesWithFilter($StockExchangeID, $OrderDate, $ListSymbol) {
		$function_name = 'listReferenceValuesWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockExchangeID) || !unsigned($StockExchangeID) || !required($ListSymbol) ) {
			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 30280;

			if (  !required($ListSymbol) )
				$this->_ERROR_CODE = 30281;

		} else {
			$query = sprintf( "SELECT *
								FROM vw_listReferenceValue
								WHERE StockExchangeID = %u
								AND ReferenceDate='%s'
								AND Symbol IN ( %s ) ORDER BY Symbol ",
							 $StockExchangeID, $OrderDate, $ListSymbol );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ReferenceValueID"    => new SOAP_Value("ReferenceValueID", "string", $result[$i]['id']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"Floor"    => new SOAP_Value("Floor", "string", $result[$i]['floor']),
							"Ceiling"    => new SOAP_Value("Ceiling", "string", $result[$i]['ceiling']),
							"ReferenceDate"    => new SOAP_Value("ReferenceDate", "string", $result[$i]['referencedate']),
							"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listPostValue
		Description: list post unit value of a stock
		Input: $StockKindID, $StockExchangeID
		Output: ???
	*/
    function listPostValue( $StockKindID, $StockExchangeID, $time_zone) {
		$function_name = 'listPostValue';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockKindID) || !unsigned($StockKindID) || !required($StockExchangeID) || !unsigned($StockExchangeID)) {
			if ( !required($StockKindID) || !unsigned($StockKindID) )
				$this->_ERROR_CODE = 30002;

			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 30003;

		} else {
			$query = sprintf( "SELECT ID, FromValue, ToValue, PostValue
								FROM %s
								WHERE Deleted='0'
								AND StockKindID=%u
								AND StockExchangeID=%u ",
								TBL_POST_UNIT, $StockKindID, $StockExchangeID);
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"PostUnitID"    => new SOAP_Value("PostUnitID", "string", $result[$i]['id']),
							"FromValue"    => new SOAP_Value("FromValue", "string", $result[$i]['fromvalue']),
							"ToValue"    => new SOAP_Value("ToValue", "string", $result[$i]['tovalue']),
							"PostValue"    => new SOAP_Value("PostValue", "string", $result[$i]['postvalue'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listOrderSides
		Description: list all Functions
		Input:
		Output: ???
	*/
    function listOrderSides($time_zone) {
		$function_name = 'listOrderSides';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, OrderSideName, Note
							FROM %s
							WHERE Deleted='0'",
							TBL_ORDER_SIDE);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['id']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note'])
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listOrderStyles
		Description: list Order Styles
		Input: $StockExchangeID
		Output:
	*/
	function listOrderStyles($StockExchangeID) {
		$function_name = 'listOrderStyles';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
			$this->_ERROR_CODE = 30027;

		if ($this->_ERROR_CODE <= 0 ) {
			$query = sprintf( "SELECT ID, OrderStyleName, Description
								FROM %s
								WHERE Deleted='0'
								AND StockExchangeID=%u",
							TBL_ORDER_STYLE, $StockExchangeID );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"OrderStyleID"    => new SOAP_Value("OrderStyleID", "string", $result[$i]['id']),
							"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
							"Description"    => new SOAP_Value("Description", "string", $result[$i]['description'])
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listFromTypes
		Description: list From Type
		Input:
		Output:
	*/
	function listFromTypes() {
		$function_name = 'listFromTypes';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, FromName
							FROM %s Order By ID", TBL_FROM_TYPE);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"FromTypeID"    => new SOAP_Value("FromTypeID", "string", $result[$i]['id']),
						"FromName"    => new SOAP_Value("FromName", "string", $result[$i]['fromname'])
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listStockQuantityOfAccount
		Description: list stock' quantity of an account
		Input:
		Output:
	*/
	function listStockQuantityOfAccount($StockID, $AccountNo) {
		$function_name = 'listStockQuantityOfAccount';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockID) || !unsigned($StockID) || !required($AccountNo) ) {
			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 30025;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 30026;
		}

		if ($this->_ERROR_CODE <= 0 ) {
			$today = date('Y-m-d');
			$AccountID = $this->getAccountIDFromAccountNo($AccountNo);

			$query = sprintf( "SELECT Quantity
								FROM vw_getStockQuantityOfAccount
								WHERE StockID=%u
								AND AccountNo='%s'
								AND StockStatusName='Normal' ", $StockID, $AccountNo);
			$result = $this->_MDB2->extended->getRow($query);
			$Normal = $result['quantity'] > 0 ? $result['quantity'] : 0;

			$query = sprintf( "SELECT Quantity
								FROM vw_getStockQuantityOfAccount
								WHERE StockID=%u
								AND AccountID=%u
								AND StockStatusName='Mortgaged' ", $StockID, $AccountID);
			$result = $this->_MDB2->extended->getRow($query);
			$Mortgaged = $result['quantity'] > 0 ? $result['quantity'] : 0;

			$query = sprintf( "SELECT f_getTempQuantity(%u, %u, '%s') as TempAmount ", $AccountID, $StockID,  $today);
			$result = $this->_MDB2->extended->getRow($query);
			$TempAmount = $result['tempamount'];

			$TradingAmount = $Normal + $Mortgaged - $TempAmount;

			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Normal"    => new SOAP_Value("Normal", "string", $Normal),
						"Mortgaged"    => new SOAP_Value("Mortgaged", "string", $Mortgaged),
						"Trading"    => new SOAP_Value("Trading", "string", $TradingAmount)
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listAllStockQuantityOfAccount
		Description: list stock' quantity of an account
		Input: AccountID
		Output: 'StockID', 'Symbol', 'Quantity', 'StockStatusName'
	*/
	function listAllStockQuantityOfAccount($AccountID) {
		$function_name = 'listAllStockQuantityOfAccount';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID) ) {
			$this->_ERROR_CODE = 30270;

		} else {
			$query = sprintf( "SELECT StockID, Symbol, Quantity, StockStatusName
								FROM vw_getStockQuantityOfAccount
								WHERE AccountID=%u
								AND Quantity > 0 ORDER BY Symbol ", $AccountID);
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid'] ),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol'] ),
							"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity'] ),
							"StockStatusName"    => new SOAP_Value("StockStatusName", "string", $result[$i]['stockstatusname'] )
							)
				);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listOrders
		Description: list all Orders on 1 day
		Input: Condition, 'TimeZone'
		Output: 'OrderID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideName', 'Session', 'StatusName', 'OrderStyleName', 'FromName', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'OrderAgencyFee', 'ExchangeName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'
	*/
    function listOrders($Condition, $TimeZone) {
		$function_name = 'listOrders';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') AS nCreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as nUpdatedDate
							FROM vw_getListOrder %s ", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Session"    => new SOAP_Value("Session", "string", $result[$i]['session']),
						"OrderStockStatusID"    => new SOAP_Value("OrderStockStatusID", "string", $result[$i]['orderstockstatusid']),
						"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
						"OrderStyleID"    => new SOAP_Value("OrderStyleID", "string", $result[$i]['orderstyleid']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"FromName"    => new SOAP_Value("FromName", "string", $result[$i]['fromname']),
						"OldOrderID"    => new SOAP_Value("OldOrderID", "string", $result[$i]['oldorderid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"OrderAgencyFee"    => new SOAP_Value("OrderAgencyFee", "string", $result[$i]['orderagencyfee']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['ncreateddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['nupdateddate']), "d/m/Y H:i:s") ),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"BankShortName"    => new SOAP_Value("BankShortName", "string", $result[$i]['shortname']),
						"CompanyName"    => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
						"OldPrice"    => new SOAP_Value("OldPrice", "string", $result[$i]['oldprice']),
						"BlockedValue"    => new SOAP_Value("BlockedValue", "string", $result[$i]['blockedvalue']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listMatchedStockQuantity
		Description: list all Orders on 1 day
		Input: Condition, 'TimeZone'
		Output: 'StockDetailID', 'OrderNumber', 'AccountNo', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'OrderSideName', 'MatchedSession', 'TradingDate', 'MatchedAgencyFee'
	*/
    function listMatchedStockQuantity($Condition, $TimeZone) {
		$function_name = 'listMatchedStockQuantity';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *
							FROM vw_listMatchedStockQuantity  %s ", $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"StockDetailID"    => new SOAP_Value("StockDetailID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
						"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
						"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
						"MatchedAgencyFeeAmount"    => new SOAP_Value("MatchedAgencyFeeAmount", "string", $result[$i]['matchedagencyfee'] * $result[$i]['matchedquantity'] * $result[$i]['matchedprice'] ),
						"CompanyName"    => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: updateBuyOrder
		Description: update a Buy order
		Input: 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'
		Output: success / error code
	*/
	function updateBuyOrder($OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $AccountNo, $UpdatedBy){
		$function_name = 'updateBuyOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30031;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 30032;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 30033;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingBeforeEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 30422;
						break;

					case '-2':
						$this->_ERROR_CODE = 30423;
						break;

					case '-3':
						$this->_ERROR_CODE = 30424;
						break;
				} //switch
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			} // if result

			//block money in bank
			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode, OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee, vw_ListAccountBank_Detail.AccountID, StockID, StockExchangeID, OrderDate
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
			$this->_MDB2->disconnect();

			if ( $bank_rs['bankaccount'] != "") {
				$Symbol = $this->checkStockPrice( $bank_rs['stockid'], $OrderPrice, $bank_rs['stockexchangeid'], $bank_rs['orderdate'] );
				if ($Symbol == false) {
					$this->_ERROR_CODE = 30011;
					return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
				}

				$this->_MDB2->connect();
				$investor_query = sprintf("SELECT ID FROM vw_AccountInfo WHERE AccountNo='%s' AND InvestorType IN ('2','4')", $AccountNo);
				$investor_rs = $this->_MDB2->extended->getRow($investor_query);
				$this->_MDB2->disconnect();
				if ($investor_rs['id'] > 0) {
					$room = checkForeignRoom($Symbol, $OrderDate, $OrderQuantity);
					if ($room < 0) {
						$this->_ERROR_CODE = 30740;
						return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
					}
				}
			} else {
				$this->_ERROR_CODE = 30041;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ( $bank_rs['bankaccount'] != "" || $vip == 1) {

				if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false && $vip == 0) {
					$this->_MDB2->connect();
					$query = sprintf( "SELECT f_getPrivateAgencyFee(%u, %f) as OrderAgencyFee ", $bank_rs['accountid'], $OrderQuantity * $OrderPrice );
					$fee_rs = $this->_MDB2->extended->getRow($query);
					$tempFee = $OrderQuantity * $OrderPrice * $fee_rs['orderagencyfee'];
					$tempFee = $tempFee > 10000 ? $tempFee : 10000;
					$orderValue = $OrderQuantity * $OrderPrice + $tempFee;
					$orderValue = number_format($orderValue, 0, ".", "");

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
							$oldTempFee = $bank_rs['ordervalue'] * $bank_rs['orderagencyfee'];
							$oldTempFee = $oldTempFee > 10000 ? $oldTempFee : 10000;
							$oldOrderValue = $bank_rs['ordervalue'] + $oldTempFee;
							$oldOrderValue = number_format($oldOrderValue, 0, ".", "");
							$dab_rs = $dab->editBlockMoney($AccountNo, $oldOrderID, $newOrderID, $oldOrderValue, $orderValue, $function_name );
							break;

						case ANZ_ID:
							$query = sprintf( "CALL sp_anz_money_request_update_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $orderValue, $UpdatedBy);
							$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							switch ($rs1['varerror']){
								case -1:
									$dab_rs = 34511;//database error
									break;
								case -2:
									$dab_rs = 34512;//not enough money to unlock
									break;
								case -3:
									$dab_rs = 34513;//account does not exist
									break;
								default:
									$dab_rs = $rs1['varerror'];
							}
							break;

						case NVB_ID:
							$dab = &new CNVB();
							$dab_rs = $dab->editBlockMoney(substr($OrderID .date("His"), 3), $bank_rs['bankaccount'], $orderValue, $OrderID);
							break;

						case OFFLINE:
							//inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inCreatedBy  $OrderID, $AccountNo, $orderValue,
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
					$this->_MDB2_WRITE->connect();
					$query = sprintf( " CALL sp_editBuyingOrder(%u, %u, %u, %u, '%s', '%s', %f)", $OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy, $suffix, $fee_rs['orderagencyfee'] );
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30034;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 30035;
									break;

								case '-2':
									$this->_ERROR_CODE = 30036;
									break;

								case '-3':
									$this->_ERROR_CODE = 30037;
									break;

								case '-4':
									$this->_ERROR_CODE = 30038;
									break;

								case '-5':
									$this->_ERROR_CODE = 30039;
									break;

								case '-6':
									$this->_ERROR_CODE = 30040;
									break;

								default:
									$this->_ERROR_CODE = 666;
							}
						}

						$mdb = initWriteDB();
						$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
						$rs = $mdb->extended->getRow($query);
					}

				} else { // bank fail
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
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
							$rs = $mdb->extended->getRow($query);
							break;

						case VCB_ID:
							$arrErr = explode('_', $dab_rs);
							$this->_ERROR_CODE = $arrErr[1];
							$mdb = initWriteDB();

							if($arrErr[0] == 'Lock') {
								$query = sprintf( "CALL sp_order_DenyOrder( %u )", $OrderID);
								$rs = $mdb->extended->getRow($query);

							} elseif($arrErr[0] == 'Cancel') {
								$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
								$rs = $mdb->extended->getRow($query);
							}
							break;

						case NVB_ID:
							$this->_ERROR_CODE = $dab_rs;
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
							$rs = $mdb->extended->getRow($query);
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

							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
							$rs = $mdb->extended->getRow($query);
							break;
					}//switch
				}
			} else { // AccountNo doesn't match with AccountID
				$this->_ERROR_CODE = 30041;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateSellOrder
		Description: update a Buy order
		Input: 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'
		Output: success / error code
	*/
	function updateSellOrder($OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy){
		$function_name = 'updateSellOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30070;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 30071;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 30072;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingBeforeEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 30422;
						break;

					case '-2':
						$this->_ERROR_CODE = 30423;
						break;

					case '-3':
						$this->_ERROR_CODE = 30424;
						break;
				} //switch
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			} // if result

			$this->_MDB2_WRITE->connect();
			$query = sprintf( "CALL sp_editSellingOrder(%u, %u, %u, %u, '%s')", $OrderID, $OrderQuantity, $OrderPrice, $OrderStyleID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30073;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30074;
							break;

						case '-2':
							$this->_ERROR_CODE = 30075;
							break;

						case '-3':
							$this->_ERROR_CODE = 30076;
							break;

						case '-4':
							$this->_ERROR_CODE = 30077;
							break;

						case '-5':
							$this->_ERROR_CODE = 30078;
							break;

						case '-6':
							$this->_ERROR_CODE = 30079;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}

				$mdb = initWriteDB();
				$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
				$rs = $mdb->extended->getRow($query);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteOrder
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function deleteOrder($OrderID, $AccountNo, $UpdatedBy){
		$function_name = 'deleteOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30180;
		} else {

			$query = sprintf( "SELECT OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee, AccountID, OrderSideID
									FROM %s WHERE ID=%u AND Deleted='0' AND OrderStockStatusID IN (%u, %u) ", TBL_ORDER, $OrderID, ORDER_APPROVED, ORDER_PENDING );
			$rs = $this->_MDB2->extended->getRow($query);

			//block money in bank
			if ( $rs['ordersideid'] == ORDER_CANCEL ) {
				$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode
										FROM vw_ListAccountBank_Detail, %s
										WHERE AccountNo='%s'
										AND %s.Deleted='0'
										AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
										AND %s.ID= %u
										ORDER BY Priority ",
										TBL_ORDER,
										$AccountNo,
										TBL_ORDER,
										TBL_ORDER,
										TBL_ORDER, $OrderID );
			} else {
				$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode
										FROM vw_ListAccountBank_Detail, %s
										WHERE AccountNo='%s'
										AND %s.Deleted='0'
										AND vw_ListAccountBank_Detail.BankID = %s.BankID
										AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
										AND %s.ID= %u
										ORDER BY Priority ",
										TBL_ORDER,
										$AccountNo,
										TBL_ORDER,
										TBL_ORDER,
										TBL_ORDER,
										TBL_ORDER, $OrderID );
			}
			$bank_rs = $this->_MDB2->extended->getRow($query);

			$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ($rs['accountid'] == $bank_rs['accountid'] || $vip == 1) {
				if ( $rs['ordersideid'] == ORDER_BUY && (strpos (PAGODA_ACCOUNT, $AccountNo) === false) && $vip == 0) {

					$query = sprintf( "CALL sp_updateIsDeletingBeforeUnBlocked(%u) ", $OrderID );
					$this->_MDB2_WRITE->extended->getRow($query);
					$this->_MDB2_WRITE->disconnect();

					$tempFee = $rs['ordervalue'] * $rs['orderagencyfee'];
					$tempFee = $tempFee > 10000 ? $tempFee : 10000;
					$orderValue = $rs['ordervalue'] + $tempFee;
					$orderValue = number_format($orderValue, 0, ".", "");

					switch ($bank_rs['bankid']){
						case DAB_ID:
							$dab = &new CDAB();
							$dab_rs = $dab->cancelBlockMoney($bank_rs['bankaccount'], $AccountNo, $OrderID, $orderValue );
							break;

						case VCB_ID:
							$dab = &new CVCB();
							$newOrderID = $OrderID . $bank_rs['unitcode'] ;
							$dab_rs = $dab->cancelBlockMoney($AccountNo, $newOrderID, $orderValue);
							break;

						case ANZ_ID:
							$query = sprintf( "CALL sp_anz_money_request_unlock( %u, '%s' , '%s', '%s')", $OrderID, $AccountNo, $rs['ordervalue'], $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();

							switch ($rs1['varerror']){
								case -1:
									$dab_rs = 34511;//database error
									break;
								case -2:
									$dab_rs = 34512;//not enough money to unlock
									break;
								case -3:
									$dab_rs = 34513;//account does not exist
									break;
								default:
									$dab_rs = $rs1['varerror'];
							}
							break;

						case NVB_ID:
							$dab = &new CNVB();
							$dab_rs = $dab->cancelBlockMoney(substr($OrderID .date("His"), 3), $bank_rs['bankaccount'], $orderValue, $OrderID );
							break;

						case OFFLINE:
							//inAccountNo varchar(20),inBankID int,inOrderID bigint,inCancelAmount double,inCreatedBy
							$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							$dab_rs = $off_rs['varerror'];
							break;
					} // switch
				} else {
					$dab_rs = 0;
				}

				$this->_MDB2_WRITE->connect();
				$query = sprintf( "CALL sp_updateIsDeletingAfterUnBlocked(%u) ", $OrderID );
				$this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if ($dab_rs == 0) { //Successfully
					$this->_MDB2_WRITE->connect();
					$query = sprintf( "CALL sp_deleteOrder(%u, '%s')", $OrderID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
					$this->_MDB2_WRITE->disconnect();
					if (empty( $rs)){
						$this->_ERROR_CODE = 30181;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 30182;
									break;

								case '-2':
									$this->_ERROR_CODE = 30183;
									break;

								case '-3':
									$this->_ERROR_CODE = 30184;
									break;

								default:
									$this->_ERROR_CODE = 666;
							} //switch
						} // DB
					} // WS
				} else { //bank fail
					switch ($bank_rs['bankid']){
						case DAB_ID:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 41060;
									break;

								case '-2':
									$this->_ERROR_CODE = 41061;
									break;

								case '-3':
									$this->_ERROR_CODE = 41062;
									break;

								case '-4':
									$this->_ERROR_CODE = 41063;
									break;

								case '-5':
									$this->_ERROR_CODE = 41064;
									break;

								case '1':
									$this->_ERROR_CODE = 41065;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;

						case VCB_ID:
							$this->_ERROR_CODE = $dab_rs;

						case NVB_ID:
							$this->_ERROR_CODE = $dab_rs;
							break;

						case OFFLINE:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 30630;
									break;

								case '-2':
									$this->_ERROR_CODE = 30631;
									break;

								case '-3':
									$this->_ERROR_CODE = 30632;
									break;

								case '-4':
									$this->_ERROR_CODE = 30633;
									break;

								case '-5':
									$this->_ERROR_CODE = 30634;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;
					} // switch
				}
			} else { //deleteOrder: AccountNo doesn't match with AccountID
				$this->_ERROR_CODE = 30185;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkDoubleOrder
		Description: delete an Order
		Input: 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'OrderSideID', 'OrderStyleID', 'OrderDate'
		Output: success / error code
	*/
	function checkDoubleOrder($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $OrderSideID, $OrderStyleID, $OrderDate){
		$function_name = 'checkDoubleOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($StockID) || !unsigned($StockID) || !required($OrderQuantity) || !unsigned($OrderQuantity)
				|| !required($OrderPrice) || !unsigned($OrderPrice) || !required($OrderSideID) || !unsigned($OrderSideID) || !required($OrderStyleID) || !unsigned($OrderStyleID) || !required($OrderDate) ) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 30190;

			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 30191;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 30192;

			if ( !required($OrderPrice) || !unsigned($OrderPrice) )
				$this->_ERROR_CODE = 30193;

			if ( !required($OrderSideID) || !unsigned($OrderSideID) )
				$this->_ERROR_CODE = 30194;

			if ( !required($OrderStyleID) || !unsigned($OrderStyleID) )
				$this->_ERROR_CODE = 30195;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 30196;

		} else {
			$query = sprintf( "SELECT f_checkDoubleOrder('%s', %u, %u, %u, %u, %u, '%s') AS VarError",
									$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $OrderSideID, $OrderStyleID, $OrderDate);
			$rs = $this->_MDB2->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30197;
			} else {
				$result = $rs['varerror'];
				if ($result > 0) {
					$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"Count"    => new SOAP_Value( "Count", "string", $result )
								)
						);
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeStatusFromApprovedToTransfering
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function changeStatusFromApprovedToTransfering($OrderID, $UpdatedBy){
		$function_name = 'changeStatusFromApprovedToTransfering';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30200;
		} else {
			$query = sprintf( "CALL sp_updateFromApprovedToTranfering(%u, '%s')", $OrderID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30201;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30202;
							break;

						case '-2':
							$this->_ERROR_CODE = 30203;
							break;

						case '-3':
							$this->_ERROR_CODE = 30204;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeStatusFromTransferingToTransfered
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function changeStatusFromTransferingToTransfered($OrderID, $UpdatedBy){
		$function_name = 'changeStatusFromTransferingToTransfered';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30210;
		} else {
			$query = sprintf( "CALL sp_updateFromTranferingToTranfered(%u, '%s')", $OrderID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30211;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30212;
							break;

						case '-2':
							$this->_ERROR_CODE = 30213;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeStatusFromTranferingToMatchedOrFailedForCancelOrder
		Description: change Status
		Input: Order id
		Output: success / error code
	*/
	function changeStatusFromTranferingToMatchedOrFailedForCancelOrder($OrderID, $IsMatched, $AccountNo, $UpdatedBy){
		$function_name = 'changeStatusFromTranferingToMatchedOrFailedForCancelOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30220;
		} else {

			if ( intval($IsMatched) == 1) {
				$query = sprintf( "SELECT o1.OrderQuantity, o1.OrderPrice, o1.OrderAgencyFee,
										o2.OrderQuantity AS OlderQuantity, o2.OrderAgencyFee AS OldOrderAgencyFee,
										o1.OldOrderID, o1.AccountID, o2.OrderSideID, o2.UnitCode, o2.BankID
										FROM %s o1, %s o2
										WHERE o1.ID=%u
										AND o1.Deleted='0'
										AND o2.Deleted='0'
										AND o1.OldOrderID=o2.ID
										AND o1.OrderStockStatusID=%u ",
										TBL_ORDER, TBL_ORDER,
										$OrderID,
										ORDER_TRANSFERING ) ;
				$rs = $this->_MDB2->extended->getRow($query);

				//block money in bank
				$query = sprintf( "SELECT vw_ListAccountBank_Detail.*
										FROM vw_ListAccountBank_Detail, %s
										WHERE AccountNo='%s'
										AND %s.Deleted='0'
										AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
										AND vw_ListAccountBank_Detail.BankID = %u
										ORDER BY Priority LIMIT 1",
										TBL_ORDER,
										$AccountNo,
										TBL_ORDER,
										TBL_ORDER,
										$rs['bankid']);
				$bank_rs = $this->_MDB2->extended->getRow($query);

				if ($rs['ordersideid'] == ORDER_BUY ) {

					$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
					if ($bank_rs['accountid'] == $rs['accountid'] || $vip == 1) {
						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false && $vip == 0) {
							//last Order
							$oldTempFee = $rs['olderquantity'] * $rs['orderprice'] * $rs['oldorderagencyfee'];
							$oldTempFee = $oldTempFee > 10000 ? $oldTempFee : 10000;
							$oldOrderValue = $rs['olderquantity'] * $rs['orderprice'] + $oldTempFee;
							$oldOrderValue = number_format($oldOrderValue, 0, ".", "");

							//remain Quantity
							$remainQuantity = $rs['olderquantity'] - $rs['orderquantity'] ;
							$remainQuantity = number_format($remainQuantity, 0, ".", "");

							//cancel Order
							if($remainQuantity > 0) {// incompleted cancel
								$tempCancelFee = $remainQuantity * $rs['orderprice'] * $rs['orderagencyfee'] ;
								$tempCancelFee = $tempCancelFee > 10000 ? $tempCancelFee : 10000;
								$cancelOrderValue = $remainQuantity * $rs['orderprice'] + $tempCancelFee;
								$cancelOrderValue = number_format($cancelOrderValue, 0, ".", "");
							} else { //completed cancel
								$cancelOrderValue = 0;
							}

							$cancelValue = $oldOrderValue - $cancelOrderValue;
							$cancelValue = number_format($cancelValue, 0, ".", "");

							switch($bank_rs['bankid']) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->cancelBlockMoney($bank_rs['bankaccount'], $AccountNo, $rs['oldorderid'], $cancelValue);
									break;

								case VCB_ID:
									$dab = &new CVCB();
									$oldOrderID = $rs['oldorderid'] . $rs['unitcode'];
									$suffix = date("His");
									$newOrderID = $rs['oldorderid'] . $suffix;

									if ($cancelOrderValue > 0) {
										$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $oldOrderValue, $cancelOrderValue, $function_name );
									} else {
										$dab_rs = $dab->cancelBlockMoney($AccountNo, $oldOrderID, $oldOrderValue);
									}
									break;

								case ANZ_ID:
									$query = sprintf( "CALL sp_anz_money_request_unlock( %u, '%s', '%s', '%s' )", $rs['oldorderid'], $AccountNo, $rs['oldordervalue'], $UpdatedBy);
									$this->_MDB2_WRITE->connect();
									$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
									$this->_MDB2_WRITE->disconnect();

									switch ($rs1['varerror']){
										case -1:
											$dab_rs = 34511;//database error
											break;
										case -2:
											$dab_rs = 34512;//not enough money to unlock
											break;
										case -3:
											$dab_rs = 34513;//account does not exist
											break;
										default:
											$dab_rs = $rs1['varerror'];
									}
									break;

								case NVB_ID:
									$dab = &new CNVB();
									$dab_rs = $dab->cancelBlockMoney(substr($rs['oldorderid'] . date("His"), 3), $bank_rs['bankaccount'], $cancelValue, $rs['oldorderid'] );
									break;

								case OFFLINE:
									$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $rs['oldorderid'], $cancelValue, $UpdatedBy);
									$this->_MDB2_WRITE->connect();
									$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
									$this->_MDB2_WRITE->disconnect();
									$dab_rs = $off_rs['varerror'];
									break;
							} // switch
						} else {
							$dab_rs = 0;
						}

						if ($dab_rs != 0) { //fail
							$IsMatched = 0;

							switch($bank_rs['bankid']) {
								case DAB_ID:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 41060;
											break;

										case '-2':
											$this->_ERROR_CODE = 41061;
											break;

										case '-3':
											$this->_ERROR_CODE = 41062;
											break;

										case '-4':
											$this->_ERROR_CODE = 41063;
											break;

										case '-5':
											$this->_ERROR_CODE = 41064;
											break;

										case '1':
											$this->_ERROR_CODE = 41065;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									} // switch
									break;

								case VCB_ID:
									$arrErr = explode("_", $dab_rs);
									$this->_ERROR_CODE = $arrErr[1] ;
									break;

								case NVB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;

								case OFFLINE:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 30640;
											break;

										case '-2':
											$this->_ERROR_CODE = 30641;
											break;

										case '-3':
											$this->_ERROR_CODE = 30642;
											break;

										case '-4':
											$this->_ERROR_CODE = 30643;
											break;

										case '-5':
											$this->_ERROR_CODE = 30644;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									} // switch
									break;
							}// switch
						} // bank
					} else { // AccountNo doesn't match
						$this->_ERROR_CODE = 30225;
						return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
					}
				}
			}

			$query = sprintf( "CALL sp_updateFromTranferingToMatchedOrFailedForCancelOrder(%u, '%u', '%s')", $OrderID, $IsMatched, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30221;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30212;
							break;

						case '-2':
							$this->_ERROR_CODE = 30223;
							break;

						case '-3':
							$this->_ERROR_CODE = 30224;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} //switch
				} // if result
			} // if store

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeStatusFromTranferingToApproved
		Description: change Status
		Input: Order id
		Output: success / error code
	*/
	function changeStatusFromTranferingToApproved($OrderID, $UpdatedBy){
		$function_name = 'changeStatusFromTranferingToApproved';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30230;
		} else {
			$query = sprintf( "CALL sp_updateFromTranferingToApproved(%u, '%s')", $OrderID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30231;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30232;
							break;

						case '-2':
							$this->_ERROR_CODE = 30233;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeATOStatusToExpired
		Description: change Status
		Input: OrderDate
		Output: success / error code
	*/
	function changeATOStatusToExpired($OrderDate){
		$function_name = 'changeATOStatusToExpired';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate) ) {
			$this->_ERROR_CODE = 30240;
		} else {
			$query = sprintf( "CALL sp_updateATOOrderToExpired('%s')", $OrderDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30241;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30242;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getTotalQuantityCanBeCanceled
		Description: change Status
		Input: OrderDate
		Output: success / error code
	*/
	function getTotalQuantityCanBeCanceled($OrderID){
		$function_name = 'getTotalQuantityCanBeCanceled';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30250;
		} else {
			$query = sprintf( "SELECT f_getTotalQuantityCanBeCanceled(%u) AS varError", $OrderID);
			$rs = $this->_MDB2->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30251;
			} else {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Quantity"    => new SOAP_Value( "Quantity", "string", $rs['varerror'] )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertBuyOrder
		Description: insert a new Buy Order
		Input:
		Output: success / error code
	*/
	function insertBuyOrder($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $FromTypeID, $Note, $OrderDate, $IsAssigner, $StockExchangeID, $CreatedBy){
		$function_name = 'insertBuyOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking Acount is active / not
		if (!$this->checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) || $Session > MAX_SESSION_HCM ) {

			if (!required($AccountNo) )
				$this->_ERROR_CODE = 30004;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30005;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30006;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30007;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HCM)
				$this->_ERROR_CODE = 30008;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30009;

		} else {
			$Symbol = $this->checkStockPrice( $StockID, $OrderPrice, $StockExchangeID, $OrderDate );
			if ($Symbol == false) {
				$this->_ERROR_CODE = 30011;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$investor_query = sprintf("SELECT ID FROM vw_AccountInfo WHERE AccountNo='%s' AND InvestorType IN ('2','4')", $AccountNo);
			$investor_rs = $this->_MDB2->extended->getRow($investor_query);
			if ($investor_rs['id'] > 0) {
				$room = checkForeignRoom($Symbol, $OrderDate, $OrderQuantity);
				if ($room < 0) {
					$this->_ERROR_CODE = 30740;
					return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
				}
			}

			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ( $vip == 1 && $FromTypeID == 5) {// web
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$CheckSession = $this->checkSession($OrderDate, $Session, $OrderStyleID, $FromTypeID);
			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED) {
				$this->_ERROR_CODE = 30012;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( $this->_ERROR_CODE == 0 ) {
				if ($CheckSession == ORDER_APPROVED) {
					switch ($OrderStyleID) {
						case ORDER_ATO:
							$query = sprintf( "CALL sp_insertATOBuyingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_ATC:
							$query = sprintf( "CALL sp_insertATCBuyingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_MP:
							$query = sprintf( "CALL sp_insertMPBuyingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_LO:
							$query = sprintf( "CALL sp_insertLOBuyingOrder('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						default:
						    $this->_ERROR_CODE = 30013;
					}
				}

				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30015;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30016;
								break;

							case '-2':
								$this->_ERROR_CODE = 30017;
								break;

							case '-3':
								$this->_ERROR_CODE = 30018;
								break;

							case '-4':
								$this->_ERROR_CODE = 30019;
								break;

							case '-5':
								$this->_ERROR_CODE = 30020;
								break;

							case '-6':
								$this->_ERROR_CODE = 30021;
								break;

							case '-7':
								$this->_ERROR_CODE = 30120;
								break;

							case '-8':
								$this->_ERROR_CODE = 30121;
								break;

							case '-9':
								$this->_ERROR_CODE = 30122;
								break;

							case '-10':
								$this->_ERROR_CODE = 30123;
								break;

							case '-11':
								$this->_ERROR_CODE = 30124;
								break;

							case '-12':
								$this->_ERROR_CODE = 30125;
								break;

							case '-13':
								$this->_ERROR_CODE = 30126;
								break;

							case '-14':
								$this->_ERROR_CODE = 30127;
								break;

							case '-15':
								$this->_ERROR_CODE = 30128;
								break;

							case '-16':
								$this->_ERROR_CODE = 30129;
								break;

							case '-17':
								$this->_ERROR_CODE = 30130;
								break;

							case '-18':
								$this->_ERROR_CODE = 30131;
								break;

							case '-19':
								$this->_ERROR_CODE = 30132;
								break;

							case '-20':
								$this->_ERROR_CODE = 30133;
								break;

							case '-21':
								$this->_ERROR_CODE = 30134;
								break;

							case '-22':
								$this->_ERROR_CODE = 30135;
								break;

							case '-23':
								$this->_ERROR_CODE = 30136;
								break;

							case '-24':
								$this->_ERROR_CODE = 30137;
								break;

							case '-25':
								$this->_ERROR_CODE = 30138;
								break;

							case '-26':
								$this->_ERROR_CODE = 30139;
								break;

							case '-27':
								$this->_ERROR_CODE = 30140;
								break;

							case '-28':
								$this->_ERROR_CODE = 30147;
								break;

							case '-29':
								$this->_ERROR_CODE = 30148;
								break;

							case '-30':
								$this->_ERROR_CODE = 30149;
								break;

							case '-34':
								$this->_ERROR_CODE = 30600;
								break;

							case '-40':
								$this->_ERROR_CODE = 30601;
								break;

							default:
								$this->_ERROR_CODE = 666;
						}
					} else {
						//insert Buy Order Successfully
						$this->items[0] = new SOAP_Value(
								'item',
								$struct,
								array(
									"ID"    => new SOAP_Value( "ID", "string", $result )
									)
							);

						//block money in bank
						$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
						$bank_rs = $this->_MDB2->extended->getAll($query);

						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false && $vip == 0) {
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
										if (!$this->killStupidBank()) // VCB is stupid
											$dab_rs = $dab->blockMoney( $AccountNo, $OrderID, $rs['varordervalue']);
										else
											$dab_rs = 30999;
										break;

									case ANZ_ID:
										$OrderID = $result;
										$query = sprintf( "CALL sp_anz_money_request_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $rs['varordervalue'], $CreatedBy);
										$this->_MDB2_WRITE->connect();
										$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();

										switch ($rs1['varerror']){
											case -1:
												$dab_rs = 34511;//database error
												break;
											case -2:
												$dab_rs = 34512;//not enough money to unlock
												break;
											case -3:
												$dab_rs = 34513;//account does not exist
												break;
											default:
												$dab_rs = $rs1['varerror'];
										}
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->blockMoney(substr($result . date("His"), 3), $bank_rs[$i]['bankaccount'], $rs['varordervalue'], $result);
										break;

									case OFFLINE:
										//inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inOrderDate date,inCreatedBy
//										$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
//										$this->_MDB2_WRITE->connect();
//										$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
//										$this->_MDB2_WRITE->disconnect();
//										$dab_rs = $off_rs['varerror'];
//										break;
                      $mdb = initWriteDB();
                      $query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                      $off_rs = $mdb->extended->getRow($query);
                      $mdb->disconnect();
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
							$BankID = ($vip == 0) ? EXI_ID : '';
						}

						if ($dab_rs == 0) { //Successfully
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToApproved(%u, %u) ", $result, $BankID );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30143;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30141;
											break;

										case '-2':
											$this->_ERROR_CODE = 30142;
											break;
									} //switch
								} // if
							} // if WS
						} else { // bank fail
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

							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToDenied(%u, '%s') ", $result, $dab_rs );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30144;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30145;
											break;

										case '-2':
											$this->_ERROR_CODE = 30146;
											break;
									} //switch
								} // if
							} // if WS
						}
					}
				}
			}
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertSellOrder
		Description: insert a new Sell Order
		Input: $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $FromTypeID, $Note, $OrderDate, $IsAssigner, $StockExchangeID, $CreatedBy
		Output: ID / error code
	*/
	function insertSellOrder($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $OrderStyleID, $FromTypeID, $Note, $OrderDate, $IsAssigner, $StockExchangeID, $CreatedBy){
		$function_name = 'insertSellOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking account is active / not
		if (!$this->checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) || $Session > MAX_SESSION_HCM ) {

			if (!required($AccountNo))
				$this->_ERROR_CODE = 30051;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30052;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30053;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30054;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HCM)
				$this->_ERROR_CODE = 30055;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30056;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ( $vip == 1 && $FromTypeID == 5) {// web
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$CheckSession = $this->checkSession($OrderDate, $Session, $OrderStyleID, $FromTypeID);
			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED) {
				$this->_ERROR_CODE = 30058;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( !$this->checkStockPrice( $StockID, $OrderPrice, $StockExchangeID, $OrderDate ) )
				$this->_ERROR_CODE = 30057;

			if ( $this->_ERROR_CODE == 0 ) {
				if ($CheckSession == ORDER_APPROVED) {
					switch ($OrderStyleID) {
						case ORDER_ATO:
							$query = sprintf( "CALL sp_insertATOSellingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_ATC:
							$query = sprintf( "CALL sp_insertATCSellingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_MP:
							$query = sprintf( "CALL sp_insertMPSellingOrder('%s', %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;

						case ORDER_LO:
							$query = sprintf( "CALL sp_insertLOSellingOrder('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%s')",
											$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
							break;
					}
				}

				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30060;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30061;
								break;

							case '-2':
								$this->_ERROR_CODE = 30062;
								break;

							case '-3':
								$this->_ERROR_CODE = 30063;
								break;

							case '-4':
								$this->_ERROR_CODE = 30064;
								break;

							case '-5':
								$this->_ERROR_CODE = 30065;
								break;

							case '-6':
								$this->_ERROR_CODE = 30066;
								break;

							case '-7':
								$this->_ERROR_CODE = 30150;
								break;

							case '-8':
								$this->_ERROR_CODE = 30151;
								break;

							case '-9':
								$this->_ERROR_CODE = 30152;
								break;

							case '-10':
								$this->_ERROR_CODE = 30153;
								break;

							case '-11':
								$this->_ERROR_CODE = 30154;
								break;

							case '-12':
								$this->_ERROR_CODE = 30155;
								break;

							case '-13':
								$this->_ERROR_CODE = 30156;
								break;

							case '-14':
								$this->_ERROR_CODE = 30157;
								break;

							case '-15':
								$this->_ERROR_CODE = 30158;
								break;

							case '-16':
								$this->_ERROR_CODE = 30159;
								break;

							case '-17':
								$this->_ERROR_CODE = 30160;
								break;

							case '-18':
								$this->_ERROR_CODE = 30161;
								break;

							case '-19':
								$this->_ERROR_CODE = 30162;
								break;

							case '-20':
								$this->_ERROR_CODE = 30163;
								break;

							case '-21':
								$this->_ERROR_CODE = 30164;
								break;

							case '-22':
								$this->_ERROR_CODE = 30165;
								break;

							case '-23':
								$this->_ERROR_CODE = 30166;
								break;

							case '-24':
								$this->_ERROR_CODE = 30167;
								break;

							case '-25':
								$this->_ERROR_CODE = 30168;
								break;

							case '-26':
								$this->_ERROR_CODE = 30169;
								break;

							case '-27':
								$this->_ERROR_CODE = 30170;
								break;

							case '-28':
								$this->_ERROR_CODE = 30171;
								break;

							case '-29':
								$this->_ERROR_CODE = 30172;
								break;

							case '-30':
								$this->_ERROR_CODE = 30173;
								break;

							case '-31':
								$this->_ERROR_CODE = 30174;
								break;

							case '-32':
								$this->_ERROR_CODE = 30175;
								break;

							case '-33':
								$this->_ERROR_CODE = 30176;
								break;

							case '-41':
								$this->_ERROR_CODE = 30177;
								break;

							default:
								$this->_ERROR_CODE = 666;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertCancelOrder
		Description: insert a new Cancel Order
		Input: $'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy'
		Output: ID / error code
	*/
	function insertCancelOrder($OrderQuantity, $Session, $FromTypeID, $OldOrderID, $Note, $OrderDate, $IsAssigner, $CreatedBy){
		$function_name = 'insertCancelOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($OrderDate) || !required($OrderQuantity) || !required($Session) || !required($OldOrderID) || !required($FromTypeID)
			|| !unsigned($OrderQuantity) || !unsigned($OldOrderID) || !unsigned($FromTypeID) || $Session > MAX_SESSION_HCM ) {

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30100;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30101;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HCM)
				$this->_ERROR_CODE = 30102;

			if (!required($OldOrderID) || !unsigned($OldOrderID))
				$this->_ERROR_CODE = 30103;

			if (!required($FromTypeID) || !unsigned($FromTypeID))
				$this->_ERROR_CODE = 30104;

		} else {
			$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ( $vip == 1 && $FromTypeID == 5) {// web
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$CheckSession = $this->checkSession($OrderDate, $Session, ORDER_LO, $FromTypeID);
			$currentSession = whichSession($OrderDate, $Session);
			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED || $currentSession < 0)
				$this->_ERROR_CODE = 30105;

			if ( $this->_ERROR_CODE == 0 ) {
				$query = sprintf( "CALL sp_insertCancelOrder(%u, %u, %u, %u, '%s', '%s', '%u', '%s')",
										$OrderQuantity, $Session, $FromTypeID, $OldOrderID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30106;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30107;
								break;

							case '-2':
								$this->_ERROR_CODE = 30108;
								break;

							case '-3':
								$this->_ERROR_CODE = 30109;
								break;

							case '-4':
								$this->_ERROR_CODE = 30110;
								break;

							case '-5':
								$this->_ERROR_CODE = 30111;
								break;

							case '-6':
								$this->_ERROR_CODE = 30112;
								break;

							case '-7':
								$this->_ERROR_CODE = 30113;
								break;

							case '-8':
								$this->_ERROR_CODE = 30114;
								break;

							default:
								$this->_ERROR_CODE = 666;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: checkStockPrice
		Description: checking Stock Price
		Input: $StockID, $StockPrice, $StockExchangeID
		Output:
	*/
	function checkStockPrice($StockID, $StockPrice, $StockExchangeID, $OrderDate) {
		$mdb = initDB();
		$query = sprintf( "SELECT StockKindID, Symbol
								FROM %s
								WHERE Deleted='0'
								AND ID=%u
								AND StockExchangeID=%u ", TBL_STOCK, $StockID, $StockExchangeID);
		$result = $mdb->extended->getRow($query);
		$mdb->disconnect();

		if ($result['stockkindid'] == 2) { //trai phieu
			return true;
		} else {
			$query = sprintf( "SELECT ID
									FROM %s
									WHERE StockID=%u
									AND Floor <= %u
									AND Ceiling >= %u
									AND StockExchangeID=%u
									AND ReferenceDate='%s' ",
									TBL_REFERENCE_VALUE,
									$StockID,
									$StockPrice, $StockPrice,
									$StockExchangeID,
									$OrderDate);
			$mdb->connect();
			$price_result = $mdb->extended->getRow($query);
			$mdb->disconnect();

			if (count($price_result) > 0) {
				return $result['symbol'];
			} else {
				return false;
			}
		}
	}

	/**
		Function: checkSession
		Description: checking Stock Price
		Input: $OrderDate, $Session, $OrderStyle='LO'
		Output:
	*/
	function checkSession($OrderDate, $Session, $OrderStyle=ORDER_LO, $FromTypeID) {
		//return ORDER_APPROVED;
		// specific order on the right session
		if ($OrderStyle == ORDER_ATO && $Session != 1)
			return ORDER_DENIED;

		if ($OrderStyle == ORDER_MP && $Session != 2)
			return ORDER_DENIED;

		if ($OrderStyle == ORDER_ATC && $Session != 3)
			return ORDER_DENIED;

		$arrOrderDate = parseDate($OrderDate);
		$unixOrderDate = mktime(0, 0, 0, $arrOrderDate[1], $arrOrderDate[2], $arrOrderDate[0]);

		$today = getdate();
		$unixToday = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);

		if ($unixOrderDate < $unixToday) { // some day in the past
			return ORDER_DENIED; // denied
		}

		if ($unixOrderDate == $unixToday) {// today
			if (!$this->checkChangeSession($OrderDate, $Session, $FromTypeID))
				return ORDER_DENIED;

			$session_3_end = $FromTypeID == 5 ? '10:44' : SESSION_3_END;

			$now = time();
			$DateTimeSession3 = $OrderDate ." ". SESSION_4_END;
			$arrDateTimeSession3 = parseDateTime($DateTimeSession3);
			$unixDateTimeSession3 = mktime($arrDateTimeSession3[3], $arrDateTimeSession3[4], 0,
										$arrDateTimeSession3[1], $arrDateTimeSession3[2], $arrDateTimeSession3[0]);

			switch ($Session) {
				case '1':
					$OrderDateTime = $OrderDate ." ". SESSION_1_END;
					break;

				case '2':
					$OrderDateTime = $OrderDate ." ". SESSION_2_END;
					break;

				case '3':
					//$OrderDateTime = $OrderDate ." ". SESSION_3_END;
					$OrderDateTime = $OrderDate ." ". $session_3_end;
					break;

				case '4':
					$OrderDateTime = $OrderDate ." ". SESSION_4_END;
					break;
			}
			//$Session3End = $OrderDate ." ". SESSION_4_END;
			$arrOrderDateTime = parseDateTime($OrderDateTime);
			$unixOrderDateTime = mktime($arrOrderDateTime[3], $arrOrderDateTime[4], 0,
										$arrOrderDateTime[1], $arrOrderDateTime[2], $arrOrderDateTime[0]);
			if ($now > $unixOrderDateTime ) {
				return ORDER_EXPIRED; // expired
			}
			return ORDER_APPROVED; // approve
		} else { // future
			//return ORDER_PENDING; // available
			return ORDER_APPROVED; // approve
		}
	}


/**

*/
	function checkChangeSession($OrderDate, $Session, $FromTypeID) {
		$now = time();

		//1
		$OrderDateEndTime1 = $OrderDate ." 07:30:00";
		$OrderDateStartTime1 = $OrderDate ." ". changeMinute(SESSION_1_END, "-1") .":30";
		$arrOrderDateEndTime1 = parseDateTime($OrderDateEndTime1);
		$arrOrderDateStartTime1 = parseDateTime($OrderDateStartTime1);
		$unixOrderDateEndTime1 = mktime($arrOrderDateEndTime1[3], $arrOrderDateEndTime1[4], $arrOrderDateEndTime1[5],
									$arrOrderDateEndTime1[1], $arrOrderDateEndTime1[2], $arrOrderDateEndTime1[0]);
		$unixOrderDateStartTime1 = mktime($arrOrderDateStartTime1[3], $arrOrderDateStartTime1[4], $arrOrderDateStartTime1[5],
									$arrOrderDateStartTime1[1], $arrOrderDateStartTime1[2], $arrOrderDateStartTime1[0]);
		if ($unixOrderDateEndTime1 <= $now && $unixOrderDateStartTime1 >= $now) {
			return true; // in session 1, don't need to check
		} else {
			//2
			$OrderDateEndTime2 = $OrderDate ." ". changeMinute(SESSION_1_END, "0") .":31";
			$OrderDateStartTime2 = $OrderDate ." ". changeMinute(SESSION_2_START, "0") .":30";
			$arrOrderDateEndTime2 = parseDateTime($OrderDateEndTime2);
			$arrOrderDateStartTime2 = parseDateTime($OrderDateStartTime2);
			$unixOrderDateEndTime2 = mktime($arrOrderDateEndTime2[3], $arrOrderDateEndTime2[4], $arrOrderDateEndTime2[5],
										$arrOrderDateEndTime2[1], $arrOrderDateEndTime2[2], $arrOrderDateEndTime2[0]);
			$unixOrderDateStartTime2 = mktime($arrOrderDateStartTime2[3], $arrOrderDateStartTime2[4], $arrOrderDateStartTime2[5],
										$arrOrderDateStartTime2[1], $arrOrderDateStartTime2[2], $arrOrderDateStartTime2[0]);
			if ($unixOrderDateEndTime2 <= $now && $unixOrderDateStartTime2 >= $now) {
				$mdb = initDBTradingBoard();
				$query = sprintf( "SELECT ID FROM %s WHERE TradingDate='%s' AND Session<=%u AND Session!=5", TBL_MARKET_STAT, $OrderDate, $Session );
				$result = $mdb->extended->getRow($query);
				$mdb->disconnect();
				if ($result['id'] > 0)
					return true;
				else
					return false;

			} else {
				//3
				$OrderDateEndTime3 = $OrderDate ." ". changeMinute(SESSION_2_END, "0") .":31";
				$OrderDateStartTime3 = $OrderDate ." ". changeMinute(SESSION_3_START, "0") .":30";
				$arrOrderDateEndTime3 = parseDateTime($OrderDateEndTime3);
				$arrOrderDateStartTime3 = parseDateTime($OrderDateStartTime3);
				$unixOrderDateEndTime3 = mktime($arrOrderDateEndTime3[3], $arrOrderDateEndTime3[4], $arrOrderDateEndTime3[5],
											$arrOrderDateEndTime3[1], $arrOrderDateEndTime3[2], $arrOrderDateEndTime3[0]);
				$unixOrderDateStartTime3 = mktime($arrOrderDateStartTime3[3], $arrOrderDateStartTime3[4], $arrOrderDateStartTime3[5],
											$arrOrderDateStartTime3[1], $arrOrderDateStartTime3[2], $arrOrderDateStartTime3[0]);
				if ($unixOrderDateEndTime3 <= $now && $unixOrderDateStartTime3 >= $now) {
					$mdb = initDBTradingBoard();
					$query = sprintf( "SELECT ID FROM %s WHERE TradingDate='%s' AND Session<=%u AND Session!=5", TBL_MARKET_STAT, $OrderDate, $Session );
					$result = $mdb->extended->getRow($query);
					$mdb->disconnect();
					if ($result['id'] > 0)
						return true;
					else
						return false;
				} else {
					//4
					/*
					$session_3_end = $FromTypeID == 5 ? '10:29' : SESSION_3_END;

					$OrderDateEndTime4 = $OrderDate ." ". changeMinute($session_3_end, "0") .":31";
					$OrderDateStartTime4 = $OrderDate ." ". changeMinute(SESSION_4_START, "0") .":30";
					$arrOrderDateEndTime4 = parseDateTime($OrderDateEndTime4);
					$arrOrderDateStartTime4 = parseDateTime($OrderDateStartTime4);
					$unixOrderDateEndTime4 = mktime($arrOrderDateEndTime4[3], $arrOrderDateEndTime4[4], $arrOrderDateEndTime4[5],
												$arrOrderDateEndTime4[1], $arrOrderDateEndTime4[2], $arrOrderDateEndTime4[0]);
					$unixOrderDateStartTime4 = mktime($arrOrderDateStartTime4[3], $arrOrderDateStartTime4[4], $arrOrderDateStartTime4[5],
												$arrOrderDateStartTime4[1], $arrOrderDateStartTime4[2], $arrOrderDateStartTime4[0]);
					if ($unixOrderDateEndTime4 <= $now && $unixOrderDateStartTime4 >= $now) {
						$mdb = initDBTradingBoard();
						$query = sprintf( "SELECT ID FROM %s WHERE TradingDate='%s' AND Session<=%u AND Session!=5", TBL_MARKET_STAT, $OrderDate, $Session );
						$result = $mdb->extended->getRow($query);
						$mdb->disconnect();
						if ($result['id'] > 0)
							return true;
						else
							return false;
					} else {
					
						return true; // don't need to check because it's out of time
					}*/
					return true; 
				}
			}
		}
	}


	/**
		Function: checkSessionForHN
		Description: checking Stock Price
		Input: $OrderDate, $Session, $OrderStyle='LO'
		Output:
	*/
	function checkSessionForHN($OrderDate) {
// return ORDER_APPROVED;
		$arrOrderDate = parseDate($OrderDate);
		$unixOrderDate = mktime(0, 0, 0, $arrOrderDate[1], $arrOrderDate[2], $arrOrderDate[0]);

		$today = getdate();
		$unixToday = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);

		if ($unixOrderDate < $unixToday) { // some day in the past
			return ORDER_DENIED; // denied
		}

		if ($unixOrderDate == $unixToday) {// today
			$now = time();
			$DateTimeSession = $OrderDate ." ". HN_SESSION_END;

			$arrDateTimeSession = parseDateTime($DateTimeSession);
			$unixDateTimeSession = mktime($arrDateTimeSession[3], $arrDateTimeSession[4], 0,
										$arrDateTimeSession[1], $arrDateTimeSession[2], $arrDateTimeSession[0]);
			if ( $now < $unixDateTimeSession ) {
				//return 0; // available
				return ORDER_APPROVED; // FOR TEST TRUNG
			} else {
				return ORDER_DENIED; // denied
			}
		} else { // future
			//return ORDER_PENDING; // available
			return ORDER_APPROVED; // FOR TEST TRUNG
		}
	}

	/**   Function: getAccountIDFromAccountNo
			Description: checking Stock Price
			Input: $AccountID, $TotalMoney
			Output:   */
	function getAccountIDFromAccountNo($AccountNo) {
		$query = sprintf( "SELECT ID
								FROM %s
								WHERE Deleted='0'
								AND AccountNo='%s' ",
								TBL_ACCOUNT, $AccountNo );
		$result = $this->_MDB2->extended->getRow($query);
		return $result['id'];
	}

	/**
		Function: updateFromApprovedToEditing
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function updateFromApprovedToEditing( $OrderID, $UpdatedBy ) {
		$function_name = 'updateFromApprovedToEditing';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30390;

		} else {
			$query = sprintf( "CALL sp_updateFromApprovedToEditing( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30391;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30392;
							break;

						case '-2':
							$this->_ERROR_CODE = 30393;
							break;

						case '-3':
							$this->_ERROR_CODE = 30394;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateFromEditingToApproved
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function updateFromEditingToApproved( $OrderID, $UpdatedBy ) {
		$function_name = 'updateFromEditingToApproved';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30400;

		} else {
			$query = sprintf( "CALL sp_updateFromEditingToApproved( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30401;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30402;
							break;

						case '-2':
							$this->_ERROR_CODE = 30403;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateIsEditingBeforeEdit
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function updateIsEditingBeforeEdit( $OrderID, $UpdatedBy ) {
		$function_name = 'updateIsEditingBeforeEdit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30420;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingBeforeEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30421;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30422;
							break;

						case '-2':
							$this->_ERROR_CODE = 30423;
							break;

						case '-3':
							$this->_ERROR_CODE = 30424;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateIsEditingAfterEdit
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function updateIsEditingAfterEdit( $OrderID, $UpdatedBy ) {
		$function_name = 'updateIsEditingAfterEdit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30430;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30431;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30432;
							break;

						case '-2':
							$this->_ERROR_CODE = 30433;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateQuantityWhenCallCancelOrder
		Description: update a Buy order
		Input: 'TradingDate'
		Output: 'StockDetailID' / error code
	*/
	function updateQuantityWhenCallCancelOrder( $OrderID, $Quantity ) {
		$function_name = 'updateQuantityWhenCallCancelOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($OrderID) || !unsigned($OrderID) || !required($Quantity) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30440;

			if ( !required($Quantity) )
				$this->_ERROR_CODE = 30441;

		} else {
			$query = sprintf( "CALL sp_updateQuantityWhenCallCancelOrder( %u, %f )", $OrderID, $Quantity );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30442;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30443;
							break;

						case '-2':
							$this->_ERROR_CODE = 30444;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertReferenceValue
		Description: insert a new Cancel Order
		Input: $'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy'
		Output: ID / error code
	*/
	function insertReferenceValue($Symbol, $Floor, $Ceiling, $ReferenceDate, $StockExchangeID){
		$function_name = 'insertReferenceValue';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($Symbol) || !required($Floor) || !unsigned($Floor) || !required($ReferenceDate)
			|| !required($Ceiling) || !unsigned($Ceiling) || !required($StockExchangeID)|| !unsigned($StockExchangeID)) {

			if (!required($Symbol) )
				$this->_ERROR_CODE = 30410;

			if (!required($Floor) || !unsigned($Floor))
				$this->_ERROR_CODE = 30411;

			if (!required($Ceiling) || !unsigned($Ceiling) )
				$this->_ERROR_CODE = 30412;

			if (!required($ReferenceDate) )
				$this->_ERROR_CODE = 30413;

			if (!required($StockExchangeID) || !unsigned($StockExchangeID))
				$this->_ERROR_CODE = 30414;

		} else {
			$query = sprintf( "CALL sp_insertReferenceValue('%s', %u, %u, '%s', '%u')",
									$Symbol, $Floor, $Ceiling, $ReferenceDate, $StockExchangeID);

			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30415;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30106;
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/* HA NOI */
	/**
		Function: insertLOBuyingOrderForHN
		Description: insert a new Buy Order
		Input: 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'IsGotPaper', 'CreatedBy'
		Output: success / error code
	*/
	function insertLOBuyingOrderForHN($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $StockExchangeID, $IsGotPaper, $CreatedBy){
		$function_name = 'insertLOBuyingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking account is active / not
		if (!$this->checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) || $Session > MAX_SESSION_HN ) {

			if (!required($AccountNo) )
				$this->_ERROR_CODE = 30300;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30301;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30302;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30303;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HN)
				$this->_ERROR_CODE = 30304;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30305;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

if($AccountNo!='057C001223' && $AccountNo != '057C000195')
{			
			$CheckSession = $this->checkSessionForHN($OrderDate);

			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED) {
				$this->_ERROR_CODE = 30306;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}
}
else {$CheckSession = ORDER_APPROVED;}
			if ( !$this->checkStockPrice( $StockID, $OrderPrice, $StockExchangeID, $OrderDate ) )
				$this->_ERROR_CODE = 30307;

			if ( $this->_ERROR_CODE == 0 ) {
				if ($CheckSession == ORDER_APPROVED) {
						$query = sprintf( "CALL sp_insertLOBuyingOrderForHN('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s')",
										$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy);
				}
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30308;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30309;
								break;

							case '-2':
								$this->_ERROR_CODE = 30310;
								break;

							case '-3':
								$this->_ERROR_CODE = 30311;
								break;

							case '-4':
								$this->_ERROR_CODE = 30312;
								break;

							case '-5':
								$this->_ERROR_CODE = 30313;
								break;

							case '-6':
								$this->_ERROR_CODE = 30314;
								break;

							case '-7':
								$this->_ERROR_CODE = 30315;
								break;

							case '-8':
								$this->_ERROR_CODE = 30615;
								break;

							default:
								$this->_ERROR_CODE = 666;
						}
					} else {
						$this->items[0] = new SOAP_Value(
								'item',
								$struct,
								array(
									"ID"    => new SOAP_Value( "ID", "string", $result )
									)
							);

						//block money in bank
						$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
						$bank_rs = $this->_MDB2->extended->getAll($query);

						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
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
										if (!$this->killStupidBank()) // VCB is stupid
											$dab_rs = $dab->blockMoney($AccountNo, $OrderID, $rs['varordervalue']);
										else
											$dab_rs = 30999;
										break;

									case ANZ_ID:
										$OrderID = $result;
										$query = sprintf( "CALL sp_anz_money_request_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $rs['varordervalue'], $CreatedBy);
										$this->_MDB2_WRITE->connect();
										$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();

										switch ($rs1['varerror']){
											case -1:
												$dab_rs = 34511;//database error
												break;
											case -2:
												$dab_rs = 34512;//not enough money to unlock
												break;
											case -3:
												$dab_rs = 34513;//account does not exist
												break;
											default:
												$dab_rs = $rs1['varerror'];
										}
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->blockMoney(substr($result . date("His"), 3), $bank_rs[$i]['bankaccount'], $rs['varordervalue'], $result);
										break;

									case OFFLINE:
										$mdb = initWriteDB();
										$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
										$off_rs = $mdb->extended->getRow($query);
										$mdb->disconnect();
										$dab_rs = $off_rs['varerror'];
										break;
								} //switch

								if ($dab_rs == 0){
									$BankID =  $bank_rs[$i]['bankid'] ;
									break;
								}
							}
						} else {
							$dab_rs = 0;
							$BankID = EXI_ID;
						}

						if ($dab_rs == 0) { //Successfully
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToApproved(%u, %u) ", $result, $BankID );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30316;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30317;
											break;

										case '-2':
											$this->_ERROR_CODE = 30318;
											break;
									} //switch
								} // if
							} // if WS
						} else { // bank fail
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
											$this->_ERROR_CODE = 30660;
											break;

										case '-2':
											$this->_ERROR_CODE = 30661;
											break;

										case '-3':
											$this->_ERROR_CODE = 30662;
											break;

										case '-4':
											$this->_ERROR_CODE = 30663;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;

							}//switch

							//$mdb->connect();
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToDenied(%u, '%s') ", $result, $dab_rs );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30297;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30298;
											break;

										case '-2':
											$this->_ERROR_CODE = 30299;
											break;
									} //switch
								} // if
							} // if WS
						} // bank
					} // WS Insert Result
				} //WS Insert
			}
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function insertLOBuyingOrderForHNX($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $OrderDate, $CreatedBy){
		$function_name = 'insertLOBuyingOrderForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking account is active / not
		if (!$this->checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) ) {

			if (!required($AccountNo) )
				$this->_ERROR_CODE = 30300;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30301;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30302;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30303;

			if (!required($Session) || !unsigned($Session) )
				$this->_ERROR_CODE = 30304;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30305;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}


			$CheckSession = $this->checkSessionForHN($OrderDate);

			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED) {
				$this->_ERROR_CODE = 30306;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( !$this->checkStockPrice( $StockID, $OrderPrice, 2, $OrderDate ) )
				$this->_ERROR_CODE = 30307;

			if ( $this->_ERROR_CODE == 0 ) {
				if ($CheckSession == ORDER_APPROVED) {
						$query = sprintf( "CALL sp_insertLOBuyingOrderForHN('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s')",
										$AccountNo, $StockID, $OrderQuantity, $OrderPrice, 4, 1, '', $OrderDate, 0, 1, $CreatedBy);
				}
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30308;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30309;
								break;

							case '-2':
								$this->_ERROR_CODE = 30310;
								break;

							case '-3':
								$this->_ERROR_CODE = 30311;
								break;

							case '-4':
								$this->_ERROR_CODE = 30312;
								break;

							case '-5':
								$this->_ERROR_CODE = 30313;
								break;

							case '-6':
								$this->_ERROR_CODE = 30314;
								break;

							case '-7':
								$this->_ERROR_CODE = 30315;
								break;

							case '-8':
								$this->_ERROR_CODE = 30615;
								break;

							default:
								$this->_ERROR_CODE = 666;
						}
					} else {
						$this->items[0] = new SOAP_Value(
								'item',
								$struct,
								array(
									"ID"    => new SOAP_Value( "ID", "string", $result )
									)
							);

						//block money in bank
						$query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
						$bank_rs = $this->_MDB2->extended->getAll($query);

						if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
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
										if (!$this->killStupidBank()) // VCB is stupid
											$dab_rs = $dab->blockMoney($AccountNo, $OrderID, $rs['varordervalue']);
										else
											$dab_rs = 30999;
										break;

									case ANZ_ID:
										$OrderID = $result;
										$query = sprintf( "CALL sp_anz_money_request_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $rs['varordervalue'], $CreatedBy);
										$this->_MDB2_WRITE->connect();
										$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();

										switch ($rs1['varerror']){
											case -1:
												$dab_rs = 34511;//database error
												break;
											case -2:
												$dab_rs = 34512;//not enough money to unlock
												break;
											case -3:
												$dab_rs = 34513;//account does not exist
												break;
											default:
												$dab_rs = $rs1['varerror'];
										}
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->blockMoney(substr($result . date("His"), 3), $bank_rs[$i]['bankaccount'], $rs['varordervalue'], $result);
										break;

									case OFFLINE:
										$mdb = initWriteDB();
										$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
										$off_rs = $mdb->extended->getRow($query);
										$mdb->disconnect();
										$dab_rs = $off_rs['varerror'];
										break;
								} //switch

								if ($dab_rs == 0){
									$BankID =  $bank_rs[$i]['bankid'] ;
									break;
								}
							}
						} else {
							$dab_rs = 0;
							$BankID = EXI_ID;
						}

						if ($dab_rs == 0) { //Successfully
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToTransfered(%u, %u) ", $result, $BankID );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30800;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30801;
											break;

										case '-2':
											$this->_ERROR_CODE = 30802;
											break;
									} //switch
								} // if
							} // if WS
						} else { // bank fail
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
											$this->_ERROR_CODE = 30660;
											break;

										case '-2':
											$this->_ERROR_CODE = 30661;
											break;

										case '-3':
											$this->_ERROR_CODE = 30662;
											break;

										case '-4':
											$this->_ERROR_CODE = 30663;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;

							}//switch

							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateBuyingOrderFromPendingToDenied(%u, '%s') ", $result, $dab_rs );
							$status_rs = $mdb->extended->getRow($query);
							$mdb->disconnect();

							if (empty( $status_rs)) {
								$this->_ERROR_CODE = 30297;
							} else {
								$result = $status_rs['varerror'];
								if ($result < 0) { //update Order Status fail
									switch ($result) {
										case '-1':
											$this->_ERROR_CODE = 30298;
											break;

										case '-2':
											$this->_ERROR_CODE = 30299;
											break;
									} //switch
								} // if
							} // if WS
						} // bank
					} // WS Insert Result
				} //WS Insert
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertLOSellingOrderForHN
		Description: insert a new Buy Order
		Input: 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'IsGotPaper', 'CreatedBy'
		Output: success / error code
	*/
	function insertLOSellingOrderForHN($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy){
		$function_name = 'insertLOSellingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking account is active / not
		if (!$this->checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) || $Session > MAX_SESSION_HN ) {

			if (!required($AccountNo) )
				$this->_ERROR_CODE = 30320;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30321;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30322;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30323;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HN)
				$this->_ERROR_CODE = 30324;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30325;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$CheckSession = $this->checkSessionForHN($OrderDate);

			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED) {
				$this->_ERROR_CODE = 30326;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( !$this->checkStockPrice( $StockID, $OrderPrice, 2, $OrderDate ) )
				$this->_ERROR_CODE = 30327;

			if ( $this->_ERROR_CODE == 0 ) {
				if ($CheckSession == ORDER_APPROVED) {
						$query = sprintf( "CALL sp_insertLOSellingOrderForHN('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s')",
										$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy);

				}

				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30328;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30329;
								break;

							case '-2':
								$this->_ERROR_CODE = 30330;
								break;

							case '-3':
								$this->_ERROR_CODE = 30331;
								break;

							case '-4':
								$this->_ERROR_CODE = 30332;
								break;

							case '-5':
								$this->_ERROR_CODE = 30333;
								break;

							case '-6':
								$this->_ERROR_CODE = 30334;
								break;

							default:
								$this->_ERROR_CODE = 666;
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
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editBuyingOrderForHN
		Description: update a Buy order
		Input: 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'
		Output: success / error code
	*/
	function editBuyingOrderForHN($OrderID, $OrderQuantity, $OrderPrice, $AccountNo, $UpdatedBy){
		$function_name = 'editBuyingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30340;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 30341;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 30342;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingBeforeEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 30422;
						break;

					case '-2':
						$this->_ERROR_CODE = 30423;
						break;

					case '-3':
						$this->_ERROR_CODE = 30424;
						break;
				} //switch
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			} // if result

			//block money in bank
			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode, OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee
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

			if ( $bank_rs['bankaccount'] != "") {

				if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
					$query = sprintf( "SELECT f_getPrivateAgencyFee(%u, %f) as OrderAgencyFee ", $bank_rs['accountid'], $OrderQuantity * $OrderPrice );
					$fee_rs = $this->_MDB2->extended->getRow($query);
					$tempFee = $OrderQuantity * $OrderPrice * $fee_rs['orderagencyfee'] ;
					$tempFee = $tempFee > 10000 ? $tempFee : 10000;
					$orderValue = $OrderQuantity * $OrderPrice + $tempFee;
					$orderValue = number_format($orderValue, 0, ".", "");

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
							$oldTempFee = $bank_rs['ordervalue'] * $bank_rs['orderagencyfee'];
							$oldTempFee = $oldTempFee > 10000 ? $oldTempFee : 10000;
							// $OldOrderValue = $OldOrderValue + $oldTempFee;
							$OldOrderValue = $bank_rs['ordervalue'] + $oldTempFee;
							$OldOrderValue = number_format($OldOrderValue, 0, ".", "");
							$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $OldOrderValue, $orderValue, $function_name );
							break;

						case ANZ_ID:
							$query = sprintf( "CALL sp_anz_money_request_update_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $orderValue, $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();

							switch ($rs1['varerror']){
								case -1:
									$dab_rs = 34511;//database error
									break;
								case -2:
									$dab_rs = 34512;//not enough money to unlock
									break;
								case -3:
									$dab_rs = 34513;//account does not exist
									break;
								default:
									$dab_rs = $rs1['varerror'];
							}
							break;

						case NVB_ID:
							$dab = &new CNVB();
							$dab_rs = $dab->editBlockMoney(substr($OrderID . date("His"), 3), $bank_rs['bankaccount'],  $OrderID, $orderValue);
							break;

						case OFFLINE:
							//inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inCreatedBy  $OrderID, $AccountNo, $orderValue,
							$query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							$dab_rs = $off_rs['varerror'];
							break;
					} // switch
				} else {
					$dab_rs = 0;
				}

				if ($dab_rs == 0) { //Successfully
					$this->_MDB2_WRITE->connect();
					$query = sprintf( " CALL sp_editBuyingOrderForHN(%u, %u, %u, '%s', '%s', %f)", $OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy, $suffix, $fee_rs['orderagencyfee'] );
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30343;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 30344;
									break;

								case '-2':
									$this->_ERROR_CODE = 30345;
									break;

								case '-3':
									$this->_ERROR_CODE = 30346;
									break;

								case '-4':
									$this->_ERROR_CODE = 30347;
									break;

								case '-5':
									$this->_ERROR_CODE = 30348;
									break;

								case '-6':
									$this->_ERROR_CODE = 30349;
									break;

								default:
									$this->_ERROR_CODE = $result;
							}
						}
						$mdb = initWriteDB();
						$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
						$rs = $mdb->extended->getRow($query);
					}
				} else { // bank fail
					/*switch ($dab_rs) {
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
					}*/

					/*$mdb = initWriteDB();
					$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
					$rs = $mdb->extended->getRow($query);*/

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
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
							$rs = $mdb->extended->getRow($query);
							break;

						case VCB_ID:
							$arrErr = explode('_', $dab_rs);
							$this->_ERROR_CODE = $arrErr[1];
							$mdb = initWriteDB();

							if($arrErr[0] == 'Lock') {
								$query = sprintf( "CALL sp_order_DenyOrder( %u )", $OrderID);
								$rs = $mdb->extended->getRow($query);

							} elseif($arrErr[0] == 'Cancel') {
								$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
								$rs = $mdb->extended->getRow($query);
							}
							break;

						case NVB_ID:
							$this->_ERROR_CODE = $dab_rs;
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
							$rs = $mdb->extended->getRow($query);
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
				}
			} else { // AccountNo doesn't match with AccountID
				$this->_ERROR_CODE = 30350;
			}// account fail
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editPriceOfBuyingOrderForHN
		Description: update a Buy order
		Input: 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'
		Output: success / error code
	*/
	function editPriceOfBuyingOrderForHN($OrderID, $OrderPrice, $AccountNo, $UpdatedBy){
		$function_name = 'editPriceOfBuyingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30460;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 30462;

		} else {
			$query = sprintf( "CALL sp_getInfoWhenEditPriceOfTransferBuyingOrderHN(%u, %u)", $OrderID, $OrderPrice);
			$bank_rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();

			if ( $bank_rs['varerror'] == 0 ) {
				if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
					$orderValue = $bank_rs['varnewordervalue'];
					if ($orderValue > 0) {
						$dab_rs = 999;
						switch ($bank_rs['varbankid']) {
							case DAB_ID:
								$dab = &new CDAB();
								$dab_rs = $dab->editBlockMoney($bank_rs['varbankaccount'], $AccountNo, $OrderID, $orderValue );
								break;

							case VCB_ID:
								$dab = &new CVCB();
								$oldOrderID = $OrderID . $bank_rs['varunitcode'];
								$suffix = date("His");
								$newOrderID = $OrderID . $suffix;
								$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $bank_rs['varoldordervalue'], $orderValue, $function_name );
								break;

							case ANZ_ID:
								$query = sprintf( "CALL sp_anz_money_request_update_lock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $orderValue, $UpdatedBy);
								$this->_MDB2_WRITE->connect();
								$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
								$this->_MDB2_WRITE->disconnect();

								switch ($rs1['varerror']){
									case -1:
										$dab_rs = 34511;//database error
										break;
									case -2:
										$dab_rs = 34512;//not enough money to unlock
										break;
									case -3:
										$dab_rs = 34513;//account does not exist
										break;
									default:
										$dab_rs = $rs1['varerror'];
								}
								break;

							case NVB_ID:
								$dab = &new CNVB();
								$dab_rs = $dab->editBlockMoney(substr($OrderID . date("His"), 3), $bank_rs['varbankaccount'], $orderValue, $OrderID);
								break;

							case OFFLINE:
								//inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inCreatedBy  $OrderID, $AccountNo, $orderValue,
								$mdb = initWriteDB();
								$query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
								$off_rs = $mdb->extended->getRow($query);
								$mdb->disconnect();
								$dab_rs = $off_rs['varerror'];
								break;

						} // switch
					}

				} else {
					$dab_rs = 0;
				}

				if ($dab_rs == 0) { //Successfully
					$this->_MDB2_WRITE->connect();
					$query = sprintf( " CALL sp_updateIsNewEditWhenIncrementBlocked(%u, '%s', %u, '%s' )", $OrderID, $suffix, $OrderPrice, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30467;
					}
				} else { // bank fail
					switch ($bank_rs['varbankid']) {
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
							$arrErr = explode("_", $dab_rs);
							$this->_ERROR_CODE = $arrErr[1] ;
							break;

						case NVB_ID:
							$this->_ERROR_CODE = $dab_rs;
							break;

						case OFFLINE:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 30680;
									break;

								case '-2':
									$this->_ERROR_CODE = 30681;
									break;

								case '-3':
									$this->_ERROR_CODE = 30682;
									break;

								case '-4':
									$this->_ERROR_CODE = 30683;
									break;

								case '-5':
									$this->_ERROR_CODE = 30684;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;
					}//switch
				}
			} else { // AccountNo doesn't match with AccountID
				$result = $bank_rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30463;
							break;

						case '-2':
							$this->_ERROR_CODE = 30464;
							break;

						case '-3':
							$this->_ERROR_CODE = 30465;
							break;

						case '-4':
							$this->_ERROR_CODE = 30466;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}// varError
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editSellingOrderForHN
		Description: update a Buy order
		Input: 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'
		Output: success / error code
	*/
	function editSellingOrderForHN($OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy){
		$function_name = 'editSellingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderQuantity) || !unsigned($OrderQuantity) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30360;

			if ( !required($OrderQuantity) || !unsigned($OrderQuantity) )
				$this->_ERROR_CODE = 30361;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 30362;

		} else {
			$query = sprintf( "CALL sp_updateIsEditingBeforeEdit( %u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 30422;
						break;

					case '-2':
						$this->_ERROR_CODE = 30423;
						break;

					case '-3':
						$this->_ERROR_CODE = 30424;
						break;
				} //switch
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			} // if result

			$this->_MDB2_WRITE->connect();
			$query = sprintf( " CALL sp_editSellingOrderForHN(%u, %u, %u, '%s')", $OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30363;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30364;
							break;

						case '-2':
							$this->_ERROR_CODE = 30365;
							break;

						case '-3':
							$this->_ERROR_CODE = 30366;
							break;

						case '-4':
							$this->_ERROR_CODE = 30367;
							break;

						case '-5':
							$this->_ERROR_CODE = 30368;
							break;

						case '-6':
							$this->_ERROR_CODE = 30369;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}

				$mdb = initWriteDB();
				$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
				$rs = $mdb->extended->getRow($query);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteOrderForHN
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function deleteOrderForHN($OrderID, $AccountNo, $UpdatedBy){
		$function_name = 'deleteOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30380;
		} else {
			$query = sprintf( "CALL sp_deleteOrderForHN(%u, '%s')", $OrderID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30381;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30382;
							break;

						case '-2':
							$this->_ERROR_CODE = 30383;
							break;

						case '-3':
							$this->_ERROR_CODE = 30384;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				} else {
					$query = sprintf( "SELECT OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee, AccountID, OrderSideID
											FROM %s WHERE ID=%u AND Deleted='1' AND OrderStockStatusID=%u", TBL_ORDER, $OrderID, ORDER_DELETED );
					$rs = $this->_MDB2->extended->getRow($query);

					//block money in bank
					if ( $rs['ordersideid'] == ORDER_CANCEL ) {
						$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode
												FROM vw_ListAccountBank_Detail, %s
												WHERE AccountNo='%s'
												AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
												AND %s.ID=%u
												ORDER BY Priority ",
												TBL_ORDER,
												$AccountNo,
												TBL_ORDER,
												TBL_ORDER, $OrderID);
					} else {
						$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode
												FROM vw_ListAccountBank_Detail, %s
												WHERE AccountNo='%s'
												AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
												AND vw_ListAccountBank_Detail.BankID = %s.BankID
												AND %s.ID=%u
												ORDER BY Priority ",
												TBL_ORDER,
												$AccountNo,
												TBL_ORDER,
												TBL_ORDER,
												TBL_ORDER, $OrderID);
					}
					$bank_rs = $this->_MDB2->extended->getRow($query);

					if ($rs['accountid'] == $bank_rs['accountid']) {

						if ( $rs['ordersideid'] == ORDER_BUY && strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
							$tempFee =  $rs['ordervalue'] *  $rs['orderagencyfee'] ;
							$tempFee = $tempFee > 10000 ? $tempFee : 10000;
							$orderValue = $rs['ordervalue'] + $tempFee;
							$orderValue = number_format($orderValue, 0, ".", "");

							switch ($bank_rs['bankid']) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->cancelBlockMoney($bank_rs['bankaccount'], $AccountNo, $OrderID, $orderValue );
									break;

								case VCB_ID:
									$dab = &new CVCB();
									$oldOrderID = $OrderID . $bank_rs['unitcode'];
									$dab_rs = $dab->cancelBlockMoney( $AccountNo, $oldOrderID, $orderValue);
									break;

								case ANZ_ID:
									$query = sprintf( "CALL sp_anz_money_request_unlock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $orderValue, $UpdatedBy);
									$this->_MDB2_WRITE->connect();
									$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
									$this->_MDB2_WRITE->disconnect();

									switch ($rs1['varerror']){
										case -1:
											$dab_rs = 34511;//database error
											break;
										case -2:
											$dab_rs = 34512;//not enough money to unlock
											break;
										case -3:
											$dab_rs = 34513;//account does not exist
											break;
										default:
											$dab_rs = $rs1['varerror'];
									}
									break;

								case NVB_ID:
									$dab = &new CNVB();
									$dab_rs = $dab->cancelBlockMoney(substr($OrderID .date("His"), 3), $bank_rs['bankaccount'], $orderValue, $OrderID );
									break;

								case OFFLINE:
									//inAccountNo varchar(20),inBankID int,inOrderID bigint,inCancelAmount double,inCreatedBy
									$mdb = initWriteDB();
									$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
									$off_rs = $mdb->extended->getRow($query);
									$mdb->disconnect();
									$dab_rs = $off_rs['varerror'];
									break;
							} //switch
						} else {
							$dab_rs = 0;
						}

						if ($dab_rs != 0) { //Successfully
							switch ($bank_rs['bankid']) {
								case DAB_ID:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 41060;
											break;

										case '-2':
											$this->_ERROR_CODE = 41061;
											break;

										case '-3':
											$this->_ERROR_CODE = 41062;
											break;

										case '-4':
											$this->_ERROR_CODE = 41063;
											break;

										case '-5':
											$this->_ERROR_CODE = 41064;
											break;

										case '1':
											$this->_ERROR_CODE = 41065;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									} // switch
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
											$this->_ERROR_CODE = 30690;
											break;

										case '-2':
											$this->_ERROR_CODE = 30691;
											break;

										case '-3':
											$this->_ERROR_CODE = 30692;
											break;

										case '-4':
											$this->_ERROR_CODE = 30693;
											break;

										case '-5':
											$this->_ERROR_CODE = 30694;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									} // switch
									break;
							}
						}
					} else { //deleteOrderHN: AccountNo doesn't match with AccountID
						$this->_ERROR_CODE = 30385;
					}
				}
			} // WS
		} // valid
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertPhoneCode
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function insertPhoneCode($AccountNo, $PhoneCode, $CreatedBy){
		$function_name = 'insertPhoneCode';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($PhoneCode) || !unsigned($PhoneCode) || !required($AccountNo) ) {
			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 30445;

			if ( !required($PhoneCode) || !unsigned($PhoneCode) )
				$this->_ERROR_CODE = 30446;

		} else {
			$query = sprintf( "CALL sp_insertPhoneCode('%s', %u, '%s')", $AccountNo, $PhoneCode, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30447;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30448;
							break;

						case '-2':
							$this->_ERROR_CODE = 30449;
							break;

						default:
							$this->_ERROR_CODE = 666;
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
		Function: getPhoneCode
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function getPhoneCode($AccountNo){
		$function_name = 'getPhoneCode';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) ) {
			$this->_ERROR_CODE = 30445;

		} else {
			$query = sprintf( "SELECT f_getPhoneCode('%s') AS PhoneCode", $AccountNo);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$this->items[0] = new SOAP_Value(
				'item',
				$struct,
				array(
					"PhoneCode"    => new SOAP_Value( "PhoneCode", "string", $rs['phonecode'] )
					)
			);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}


	/**
		Chi Diep
		Function: listStockDetailByTradingDate
		Description: list lReference Values
		Input: time_zone
		Output: ???
	*/
    function listStockDetailByTradingDate($TradingDate) {
		$function_name = 'listStockDetailByTradingDate';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "Call sp_GetListStockDetail_ByTradingDate('%s')",$TradingDate);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
						"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedsgencyfee']),
						"IsExist"    => new SOAP_Value("IsExist", "string", $result[$i]['isexist'])
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listStockDetailByTradingDateWithBranchID($TradingDate, $BranchID) {
		$function_name = 'listStockDetailByTradingDateWithBranchID';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "Call sp_GetListStockDetail_ByTradingDateWithBranchID('%s', %u)", $TradingDate, $BranchID);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"MatchedQuantity"    => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
						"MatchedPrice"    => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"MatchedSession"    => new SOAP_Value("MatchedSession", "string", $result[$i]['matchedsession']),
						"MatchedAgencyFee"    => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedsgencyfee']),
						"IsExist"    => new SOAP_Value("IsExist", "string", $result[$i]['isexist'])
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	function checkAccountIsActive($AccountNo) {
		$mdb = initDB();
		$query = sprintf("CALL sp_CheckAccount_IsActive('%s')", $AccountNo );
		$rs = $mdb->extended->getRow($query);
		$mdb->disconnect();

		$result = $rs['varerror'];
		if ($result <= 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
		Function: UnLockATOOrder
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function UnLockATOOrder($OrderNumber, $CancelQuantity, $OrderDate){
		$function_name = 'UnLockATOOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderNumber) || !unsigned($OrderNumber) || !required($CancelQuantity) || !unsigned($CancelQuantity) || !required($OrderDate) ) {
			if ( !required($OrderNumber) || !unsigned($OrderNumber) )
				$this->_ERROR_CODE = 30090;

			if ( !required($CancelQuantity) || !unsigned($CancelQuantity) )
				$this->_ERROR_CODE = 30091;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 30092;

		} else {
			$query = sprintf( "CALL sp_UnLockATOAndATCOrder( '%s', %u, '%s')", $OrderNumber, $CancelQuantity, $OrderDate );
			$rs = $this->_MDB2->extended->getRow($query);

			if ($rs['varorderid'] > 0 ) {
				switch ($rs['varbankid']) {
					case DAB_ID:
						$dab = &new CDAB();
						$dab_rs = $dab->cancelBlockMoney($rs['varbankaccount'], $rs['varaccountno'], $rs['varorderid'], $rs['varcancelvalue'] );
						break;

					case VCB_ID:
						$dab = &new CVCB();
						$vcbOrderID = $rs['varorderid'] . $rs['varunitcode'];
						$dab_rs = $dab->cancelBlockMoney( $rs['varaccountno'], $vcbOrderID, $rs['varcancelvalue'] );
						break;

					case ANZ_ID:
						$query = sprintf( "CALL sp_anz_money_request_unlock( %u, '%s', '%s', '%s' )", $rs['varorderid'] , $rs['varaccountno'], $rs['varcancelvalue'] , 'Automatic');
						$this->_MDB2_WRITE->connect();
						$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
						$this->_MDB2_WRITE->disconnect();

						switch ($rs1['varerror']){
							case -1:
								$dab_rs = 34511;//database error
								break;
							case -2:
								$dab_rs = 34512;//not enough money to unlock
								break;
							case -3:
								$dab_rs = 34513;//account does not exist
								break;
							default:
								$dab_rs = $rs1['varerror'];
						}
						break;

					case NVB_ID:
						$dab = &new CNVB();
						$dab_rs = $dab->cancelBlockMoney(substr($rs['varorderid'] . date("His"), 3), $rs['varbankaccount'], $rs['varcancelvalue'], $rs['varorderid'] );
						break;

					case OFFLINE:
						//inAccountNo varchar(20),inBankID int,inOrderID bigint,inCancelAmount double,inCreatedBy
						$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, $u, %f, '%s')", $rs['varaccountno'], OFFLINE, $rs['varorderid'], $rs['varcancelvalue'] , $function_name);
						$this->_MDB2_WRITE->connect();
						$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
						$this->_MDB2_WRITE->disconnect();
						$dab_rs = $off_rs['varerror'];
						break;
				}

				if ($dab_rs == 0) { //Successfully

						$query = sprintf( "CALL sp_updateOrderWhenUnBlocked( %u, %u )", $rs['varorderid'], $CancelQuantity );
						$rs = $this->_MDB2_WRITE->extended->getRow($query);

						if (empty( $rs)){
							$this->_ERROR_CODE = 30093;
						} else {
							$result = $rs['varerror'];
							if ($result < 0) {
								$this->_ERROR_CODE = 30094;
							}
						}
				} else { //bank fail
					switch ($rs['varbankid']) {
						case DAB_ID:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 41060;
									break;

								case '-2':
									$this->_ERROR_CODE = 41061;
									break;

								case '-3':
									$this->_ERROR_CODE = 41062;
									break;

								case '-4':
									$this->_ERROR_CODE = 41063;
									break;

								case '-5':
									$this->_ERROR_CODE = 41064;
									break;

								case '1':
									$this->_ERROR_CODE = 41065;
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
									$this->_ERROR_CODE = 30700;
									break;

								case '-2':
									$this->_ERROR_CODE = 30701;
									break;

								case '-3':
									$this->_ERROR_CODE = 30702;
									break;

								case '-4':
									$this->_ERROR_CODE = 30703;
									break;

								case '-5':
									$this->_ERROR_CODE = 30704;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;
					}
				}
			} else { // OrderID is not exist
				$this->_ERROR_CODE = 30095;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getATOandATCOrders($OrderDate, $AccountNo ){
		$function_name = 'getATOandATCOrders';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getListOrderForUnBlock('%s', '%s')", $OrderDate, $AccountNo );
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"UnitCode"    => new SOAP_Value("UnitCode", "string", $result[$i]['unitcode']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"BankAccount"    => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
						)
				);
		} //for
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getCompanyByStock
		Description: delete an Order
		Input: Order id
		Output: success / error code
	*/
	function getCompanyByStock($Symbol){
		$function_name = 'getCompanyByStock';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($Symbol) ) {
			$this->_ERROR_CODE = 30245;

		} else {
			$query = sprintf( "CALL sp_getCompanyByStock('%s') ", $Symbol);
			$rs = $this->_MDB2->extended->getRow($query);

			$this->items[0] = new SOAP_Value(
				'item',
				$struct,
				array(
					"CompanyName"    => new SOAP_Value( "CompanyName", "string", $rs['companyname'] )
					)
			);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getRealBalanceFromDAB
		Description:
		Input:
		Output: success / error code
	*/
	function getRealBalanceFromDAB($DABAccount, $AccountNo){
		$function_name = 'getRealBalanceFromDAB';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) ) {
			$this->_ERROR_CODE = 30286;

		} else {
			$query = sprintf( "SELECT BankAccount FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' AND BankID=%u", $AccountNo, DAB_ID);
			$rs = $this->_MDB2->extended->getRow($query);

			if ($rs['bankaccount'] <> "") {
				$dab = &new CDAB();
				$result = $dab->getRealBalance($rs['bankaccount'], $AccountNo);

				$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Balance"    => new SOAP_Value( "Balance", "string", $result )
						)
				);
			} else {
				$this->_ERROR_CODE = 30285;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAvailBalanceFromDAB
		Description:
		Input:
		Output: success / error code
	*/
	function getAvailBalanceFromDAB($DABAccount, $AccountNo){
		$function_name = 'getAvailBalanceFromDAB';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) ) {
			$this->_ERROR_CODE = 30291;

		} else {
			$query = sprintf( "SELECT BankAccount FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' AND BankID=%u", $AccountNo, DAB_ID);
			$rs = $this->_MDB2->extended->getRow($query);

			if ($rs['bankaccount'] <> "") {
				$dab = &new CDAB();
				$result = $dab->getAvailBalance($rs['bankaccount'], $AccountNo);

				$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Balance"    => new SOAP_Value( "Balance", "string", $result )
						)
				);
			} else {
				$this->_ERROR_CODE = 30290;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAvailBalanceFromVCB
		Description:
		Input:
		Output: success / error code
	*/
	function getAvailBalanceFromVCB($AccountNo){
		$function_name = 'getAvailBalanceFromVCB';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) ) {
			$this->_ERROR_CODE = 30291;

		} else {
			$query = sprintf("SELECT f_searchBankAccount('%s', %u) AS IsExist", $AccountNo, VCB_ID);
			$rs = $this->_MDB2->extended->getRow($query);
			if ($rs['isexist'] > 0) {
				$vcb = &new CVCB();
				$result = $vcb->getAvailBalance( $AccountNo);
				$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Balance"    => new SOAP_Value( "Balance", "string", $result )
						)
				);
			} else {
				$this->_ERROR_CODE = 30292;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getAvailBalanceFromNVB($AccountNo){
		$function_name = 'getAvailBalanceFromNVB';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) ) {
			$this->_ERROR_CODE = 30291;

		} else {
			$query = sprintf( "SELECT BankAccount FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' AND BankID=%u", $AccountNo, NVB_ID);
			$rs = $this->_MDB2->extended->getRow($query);

			if ($rs['bankaccount'] <> "") {
				$nvb = &new CNVB();
				$result = $nvb->getAvailBalance(time(), $rs['bankaccount']);

				$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Balance"    => new SOAP_Value( "Balance", "string", $result )
						)
				);
			} else {
				$this->_ERROR_CODE = 30290;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateStatusForOrderWhenEndExecTransaction
		Description: check ContractNo exist or not
		Input: ContractNo
		Output:
	*/
	function updateStatusForOrderWhenEndExecTransaction($OrderDate) {
		$function_name = 'updateStatusForOrderWhenEndExecTransaction';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderDate)) {
			$this->_ERROR_CODE = 34025;

		} else {
			if ($this->checkSessionEnd($OrderDate)) {
				$query = sprintf( "CALL sp_updateStatusForOrderWhenEndExecTransactionForHOSEAndHASTC('%s')", $OrderDate );
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				if (empty( $rs)) {
					$this->_ERROR_CODE = 34026;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 34027;
								break;

						}
					} else { 					// Add by Quan Nguyen
						// call new store procedure
						$this->_MDB2_WRITE->disconnect();
						$this->_MDB2_WRITE->connect();
						$query = sprintf("CALL sp_SoldMortage_insert('%s')", $OrderDate);
						$rs = $this->_MDB2_WRITE->extended->getRow($query);
						if (empty($rs)) {
							$this->_ERROR_CODE = 44026;
						} else {
							$result = $rs['varerror'];
							if ($result == -1) $this->_ERROR_CODE = 44027;
						}
					}
					// End adding
				}
			} else {
				$this->_ERROR_CODE = 34028;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function checkSessionEnd($OrderDate) {
return true; // don't need to check anymore
		$now = time();

		$SessionEnd = $OrderDate ." ". changeMinute(SESSION_4_END, "+5") .":00";
		$arrSessionEnd = parseDateTime($SessionEnd);
		$unixSessionEnd = mktime($arrSessionEnd[3], $arrSessionEnd[4], $arrSessionEnd[5],
									$arrSessionEnd[1], $arrSessionEnd[2], $arrSessionEnd[0]);
		if ($unixSessionEnd <= $now) {
			return true;
		} else {
			return false;
		}
	}

/**

*/
	function killStupidBank() {
		$now = time();

		$Start = date("Y-m-d") ." ". changeMinute("16:30", "+5") .":00";
		$End = date("Y-m-d") ." ". changeMinute("17:54", "+5") .":00";

		$arrStart = parseDateTime($Start);
		$unixStart = mktime($arrStart[3], $arrStart[4], $arrStart[5],
									$arrStart[1], $arrStart[2], $arrStart[0]);

		$arrEnd = parseDateTime($End);
		$unixEnd = mktime($arrEnd[3], $arrEnd[4], $arrEnd[5],
									$arrEnd[1], $arrEnd[2], $arrEnd[0]);

		if ($unixStart <= $now && $now <= $unixEnd ) {
			return true;
		} else {
			return false;
		}
	}

	/**
		Function: editPriceOfSellingOrderForHN
		Description:
		Input:
		Output:
	*/
	function editPriceOfSellingOrderForHN($OrderID, $NewOrderPrice, $UpdatedBy) {
		$function_name = 'editPriceOfSellingOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($NewOrderPrice)) {
			if ( !required($OrderID) )
				$this->_ERROR_CODE = 30435;

			if ( !required($NewOrderPrice))
				$this->_ERROR_CODE = 30436;

		} else {
			$query = sprintf( "CALL sp_execWhenEditPriceOfTransferSellingOrderHN(%u, %u, '%s')", $OrderID, $NewOrderPrice, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30437;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30438;
							break;

						case '-2':
							$this->_ERROR_CODE = 30439;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateIsNewEditField
		Description:
		Input:
		Output:
	*/
	function updateIsNewEditField($OrderID, $IsCalled) {
		$function_name = 'updateIsNewEditField';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($IsCalled)) {
			if ( !required($OrderID) )
				$this->_ERROR_CODE = 30470;

			if ( !required($IsCalled))
				$this->_ERROR_CODE = 30471;

		} else {
			$query = sprintf( "CALL sp_updateIsNewEditField(%u, %u )", $OrderID, $IsCalled );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30472;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: cancelBlockedMoney
		Description:
		Input:
		Output: success / error code
	*/
	function cancelBlockedMoney($OrderID, $AccountNo, $UpdatedBy){
		$function_name = 'cancelBlockedMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($AccountNo) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 30475;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 30476;

		} else {
			if (!$this->checkCancelTime()) {
				$this->_ERROR_CODE = 30479;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			$query = sprintf( "SELECT OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee, AccountID, OrderSideID
									FROM %s WHERE ID=%u AND Deleted='0' AND OrderStockStatusID IN (%u, %u, %u, %u) ", TBL_ORDER, $OrderID, ORDER_TRANSFERED, ORDER_EXPIRED, ORDER_FAILED, ORDER_CANCELED);
			$rs = $this->_MDB2->extended->getRow($query);

			//block money in bank
			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode
									FROM vw_ListAccountBank_Detail, %s
									WHERE AccountNo='%s'
									AND %s.Deleted='0'
									AND vw_ListAccountBank_Detail.BankID = %s.BankID
									AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
									AND %s.ID= %u
									ORDER BY Priority ",
									TBL_ORDER,
									$AccountNo,
									TBL_ORDER,
									TBL_ORDER,
									TBL_ORDER,
									TBL_ORDER, $OrderID );
			$bank_rs = $this->_MDB2->extended->getRow($query);

			//$vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
			if ($rs['accountid'] == $bank_rs['accountid'] ) {
//			if ($rs['accountid'] == $bank_rs['accountid'] || $vip == 1) {
				if ( $rs['ordersideid'] == ORDER_BUY && strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
				//if ( $rs['ordersideid'] == ORDER_BUY && (strpos (PAGODA_ACCOUNT, $AccountNo) === false) && $vip == 0) {
					$tempFee = $rs['ordervalue'] * $rs['orderagencyfee'] ;
					$tempFee = $tempFee > 10000 ? $tempFee : 10000;
					$orderValue = $rs['ordervalue'] + $tempFee;
					$orderValue = number_format($orderValue, 0, ".", "");

					switch ($bank_rs['bankid']){
						case DAB_ID:
							$dab = &new CDAB();
							$dab_rs = $dab->cancelBlockMoney($bank_rs['bankaccount'], $AccountNo, $OrderID, $orderValue );
							break;

						case VCB_ID:
							$dab = &new CVCB();
							$newOrderID = $OrderID . $bank_rs['unitcode'] ;
							$dab_rs = $dab->cancelBlockMoney($AccountNo, $newOrderID, $orderValue );
							break;

						case ANZ_ID:
							$query = sprintf( "CALL sp_anz_money_request_unlock( %u, '%s', '%s', '%s' )", $OrderID, $AccountNo, $rs['ordervalue'], $UpdatedBy);
							$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							switch ($rs1['varerror']){
								case -1:
									$dab_rs = 34511;//database error
									break;
								case -2:
									$dab_rs = 34512;//not enough money to unlock
									break;
								case -3:
									$dab_rs = 34513;//account does not exist
									break;
								default:
									$dab_rs = $rs1['varerror'];
							}
							break;

						case NVB_ID:
							$dab = &new CNVB();
							$dab_rs = $dab->cancelBlockMoney(substr($OrderID .date("His"), 3), $bank_rs['bankaccount'], $orderValue, $OrderID );
							break;

						case OFFLINE:
							$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
							$this->_MDB2_WRITE->connect();
							$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
							$this->_MDB2_WRITE->disconnect();
							$dab_rs = $off_rs['varerror'];
							break;
					} // switch
				} else {
					$dab_rs = 0;
				}

				if ($dab_rs == 0) { //Successfully
					$query = sprintf( "CALL sp_updateIsUnBlockedWhenSuccess(%u, '%s')", $OrderID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30478;
					}
				} else { //bank fail
					switch ($bank_rs['bankid']){
						case DAB_ID:
							switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 41060;
									break;

								case '-2':
									$this->_ERROR_CODE = 41061;
									break;

								case '-3':
									$this->_ERROR_CODE = 41062;
									break;

								case '-4':
									$this->_ERROR_CODE = 41063;
									break;

								case '-5':
									$this->_ERROR_CODE = 41064;
									break;

								case '1':
									$this->_ERROR_CODE = 41065;
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
									$this->_ERROR_CODE = 30710;
									break;

								case '-2':
									$this->_ERROR_CODE = 30711;
									break;

								case '-3':
									$this->_ERROR_CODE = 30712;
									break;

								case '-4':
									$this->_ERROR_CODE = 30713;
									break;

								case '-5':
									$this->_ERROR_CODE = 30714;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;
							}
							break;
					}
				}
			} else { //AccountNo doesn't match with AccountID
				$this->_ERROR_CODE = 30477;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

/**

*/
	function checkCancelTime() {
return true;
		$now = time();

		$OrderDateEndHOSE = date('Y-m-d') ." ". changeMinute(SESSION_3_END, "+5") .":30";
		$arrOrderDateEndHOSE = parseDateTime($OrderDateEndHOSE);
		$unixOrderDateEndHOSE = mktime($arrOrderDateEndHOSE[3], $arrOrderDateEndHOSE[4], $arrOrderDateEndHOSE[5],
									$arrOrderDateEndHOSE[1], $arrOrderDateEndHOSE[2], $arrOrderDateEndHOSE[0]);

		$EndWorkingTime = date('Y-m-d') ." 17:00:00";
		$arrEndWorkingTime = parseDateTime($EndWorkingTime);
		$unixEndWorkingTime = mktime($arrEndWorkingTime[3], $arrEndWorkingTime[4], $arrEndWorkingTime[5],
									$arrEndWorkingTime[1], $arrEndWorkingTime[2], $arrEndWorkingTime[0]);

		if ($unixOrderDateEndHOSE < $now && $now < $unixEndWorkingTime)
			return true;
		else
			return false;
	}

	/**
		Function: updateFromTransferToEditingForHN
		Description:
		Input:
		Output:
	*/
	function updateFromTransferToEditingForHN($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferToEditingForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30485;

		} else {
			$query = sprintf( "CALL sp_updateFromTransferToEditingForHN(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30486;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30487;
							break;

						case '-2':
							$this->_ERROR_CODE = 30488;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateFromEditingtoTransferForHN
		Description:
		Input:
		Output:
	*/
	function updateFromEditingtoTransferForHN($OrderID, $UpdatedBy) {
		$function_name = 'updateFromEditingtoTransferForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30490;

		} else {
			$query = sprintf( "CALL sp_updateFromEditingtoTransferForHN(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30491;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30492;
							break;

						case '-2':
							$this->_ERROR_CODE = 30493;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateFromTransferToTransferingForHN
		Description:
		Input:
		Output:
	*/
	function updateFromTransferToTransferingForHN($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferToTransferingForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30495;

		} else {
			$query = sprintf( "CALL sp_updateFromTransferToTransferingForHN(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30496;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30497;
							break;

						case '-2':
							$this->_ERROR_CODE = 30498;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateFromTransferingToTransferForHN
		Description:
		Input:
		Output:
	*/
	function updateFromTransferingToTransferForHN($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferingToTransferForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 30500;

		} else {
			$query = sprintf( "CALL sp_updateFromTransferingToTransferForHN(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 30501;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30502;
							break;

						case '-2':
							$this->_ERROR_CODE = 30503;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getListInvalidFutureBuyingOrder
		Description:
		Input:
		Output:
	*/
	// 20100723 - Them $StockExchangeID ----------------------------------------------------------- //
  // function getListInvalidFutureBuyingOrder($OrderDate) {
  function getListInvalidFutureBuyingOrder($OrderDate, $StockExchangeID) {
  // End 20100723 - Them $StockExchangeID ------------------------------------------------------- //
    $function_name = 'getListInvalidFutureBuyingOrder';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if ( !required($OrderDate) ) {
      $this->_ERROR_CODE = 30480;
    } elseif(!required($StockExchangeID)){
      $this->_ERROR_CODE = 30001;
    }
    else {
      // $query = sprintf( "CALL sp_getListInvalidFutureBuyingOrder('%s' )", $OrderDate );
      $query = sprintf( "CALL sp_getListInvalidFutureBuyingOrder('%s', '%s' )", $OrderDate, $StockExchangeID );
      $rs = $this->_MDB2_WRITE->extended->getAll($query);
      $this->_MDB2_WRITE->disconnect();
      $count = count($rs);
      for($i=0; $i<$count; $i++) {
        // 20100723 - Quang change ---------------------------------
        // $vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist
        $vip = checkVIPAccount($rs[$i]['accountno']);// 1: exist 0: not exist
        // End 20100723 - Quang change -----------------------------
        if ( strpos (PAGODA_ACCOUNT, $rs[$i]['accountno']) === false && $vip == 0) {
          if ($rs[$i]['ordersideid'] == ORDER_BUY) {
            switch ($rs[$i]['bankid']){
              case DAB_ID:
                $dab = &new CDAB();
                $dab_rs = $dab->cancelBlockMoney($rs[$i]['bankaccount'], $rs[$i]['accountno'], $rs[$i]['id'], $rs[$i]['amount'] );
                break;

              case VCB_ID:
                $dab = &new CVCB();
                $newOrderID = $rs[$i]['id']. $rs[$i]['unitcode'] ;
                $dab_rs = $dab->cancelBlockMoney($rs[$i]['accountno'], $newOrderID, $rs[$i]['amount'] );
                break;

              case NVB_ID:
                $dab = &new CNVB();
                $dab_rs = $dab->cancelBlockMoney(substr($rs[$i]['id'] .date("His"), 3), $rs[$i]['bankaccount'], $rs[$i]['amount'], $rs[$i]['id'] );
                break;

              case OFFLINE:
                $query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $rs[$i]['accountno'], OFFLINE, $rs[$i]['id'], $rs[$i]['amount'], $function_name);
                $this->_MDB2_WRITE->connect();
                $off_rs = $this->_MDB2_WRITE->extended->getRow($query);
                $this->_MDB2_WRITE->disconnect();
                $dab_rs = $off_rs['varerror'];
                break;
            } // switch

            if ($dab_rs == 0) {
              $success = 1;
            } else {
              $success = 0;
            }

            $this->_MDB2_WRITE->connect();
            $query = sprintf( "CALL sp_updateFromApprovedToDeniedForFutureBuyingOrder( %u, %u )", $rs[$i]['id'], $success );
            $update_rs = $this->_MDB2_WRITE->extended->getRow($query);
            $this->_MDB2_WRITE->disconnect();
          } // BUY order

          $bank_result .= $rs[$i]['accountno'] ."   ". $rs[$i]['id'] ."   ". $rs[$i]['amount'] ." --> ". $dab_rs . "\r\n";
          $arraySMS['Phone'] = $rs[$i]['mobilephone'];
          $OrderSide = $rs[$i]['ordersideid'] == ORDER_BUY ? "Mua" : "Ban";
          $arraySMS['Content'] = "EPS: Lenh ". $OrderSide . " ". $rs[$i]['symbol'] ." - TK: ". $rs[$i]['accountno'] . " khong hop le do sai gia Tran/San";
          sendSMS ($arraySMS) ;
        } // PAGODA_ACCOUNT
      } // for
      
	  mailSMTP('Quản lý Đặt lệnh','webmaster@eps.com.vn','quan.l@eps.com.vn','ba.nd@eps.com.vn', '', 'Danh sách lệnh đặt trước không hợp lệ - StockExchangeID:'.$StockExchangeID,'Danh sách lệnh đặt trước không hợp lệ \r\n <br>'.$bank_result);
      // mailSMTP('Quản lý Đặt lệnh','webmaster@eps.com.vn','quang.tm@eps.com.vn','quang.tm@eps.com.vn', '', 'Danh sách lệnh đặt trước không hợp lệ - StockExchangeID:'.$StockExchangeID,'Danh sách lệnh đặt trước không hợp lệ \r\n <br>'.$bank_result);
      $filename = $_SERVER['DOCUMENT_ROOT'] . "/bank/unlock/". date("Ymd");
      file_put_contents($filename, $bank_result);
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

	/**
		Function: GetNextTradingDate
		Description:
		Input:
		Output:
	*/
    function GetNextTradingDate($RequestDate) {
		$function_name = 'GetNextTradingDate';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$query = sprintf( "SELECT f_getNextTradingDate( '%s' ) AS NextDate ", $RequestDate );
			$result = $this->_MDB2->extended->getRow($query);
			$count = count($result);
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"NextDate"    => new SOAP_Value("NextDate", "string", $result['nextdate'])
							)
					);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateFromTransferingToTransferWithMatchedOrFailedForHN
		Description:
		Input:
		Output:
	*/
    function updateFromTransferingToTransferWithMatchedOrFailedForHN($OrderID, $IsMatched, $UpdatedBy, $MatchedQuantity) {
		$function_name = 'updateFromTransferingToTransferWithMatchedOrFailedForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($IsMatched) ) {
			if ( !required($OrderID) )
				$this->_ERROR_CODE = 30451;

			if ( !required($IsMatched) )
				$this->_ERROR_CODE = 30452;
		} else {

			$query = sprintf( "CALL sp_updateFromTransferingToTransferWithMatchedOrFailedForHN(%u, '%s', '%s', %u )", $OrderID, $IsMatched, $UpdatedBy, $MatchedQuantity );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();

			if (empty( $rs)) {
				$this->_ERROR_CODE = 30453;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30454;
							break;

						case '-2':
							$this->_ERROR_CODE = 30455;
							break;

						case '-3':
							$this->_ERROR_CODE = 30457;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
				} else {// if
					//varError,varOldValue,varReBlockedValue,varUnitCode,varBankID,varAccountNo,varAccountBank;
					if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
						$suffix = date("His");
						if ($rs['varreblockedvalue'] > 0) {
							switch ($rs['varbankid']) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->editBlockMoney($rs['varaccountbank'], $rs['varaccountno'], $OrderID, $rs['varreblockedvalue'] );
									break;

								case VCB_ID:
									$dab = &new CVCB();
									$oldOrderID = $OrderID . $rs['varunitcode'];
									$newOrderID = $OrderID . $suffix;
									$dab_rs = $dab->editBlockMoney($rs['varaccountno'], $oldOrderID, $newOrderID, $rs['varoldvalue'], $rs['varreblockedvalue'], $function_name );
									break;

								case NVB_ID:
									$dab = &new CNVB();
									$dab_rs = $dab->editBlockMoney(substr($OrderID .date("His"), 3), $rs['varaccountbank'], $rs['varreblockedvalue'], $OrderID);
									break;

								case OFFLINE:
									$query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $rs['varaccountno'], OFFLINE, $OrderID, $rs['varreblockedvalue'], $UpdatedBy);
									$this->_MDB2_WRITE->connect();
									$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
									$this->_MDB2_WRITE->disconnect();
									$dab_rs = $off_rs['varerror'];
									break;
							} //switch
						}
					} else {//PAGODA_ACCOUNT
						$dab_rs = 0;
					}

					if ($dab_rs == 0) { //Successfully
						if ( $rs['varbankid'] == VCB_ID ) {
							$_MDB2_WRITE = initWriteDB();
							$query = sprintf( " CALL sp_updateUnitCode(%u, '%s' )", $OrderID, $suffix);
							$rs = $_MDB2_WRITE->extended->getRow($query);
							$_MDB2_WRITE->disconnect();
							if (empty( $rs)){
								$this->_ERROR_CODE = 30456;
							}
						}
					} else { // bank fail
						switch ($rs['varbankid']) {
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
								$arrErr = explode("_", $dab_rs);
								$this->_ERROR_CODE = $arrErr[1] ;
								break;

							case NVB_ID:
								$this->_ERROR_CODE = $dab_rs;
								break;

							case OFFLINE:
								switch ($dab_rs) {
									case '-1':
										$this->_ERROR_CODE = 30720;
										break;

									case '-2':
										$this->_ERROR_CODE = 30721;
										break;

									case '-3':
										$this->_ERROR_CODE = 30722;
										break;

									case '-4':
										$this->_ERROR_CODE = 30723;
										break;

									case '-5':
										$this->_ERROR_CODE = 30724;
										break;

									default:
										$this->_ERROR_CODE = $dab_rs;
								}
								break;
						}//switch
					}//if
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertCancelOrderForHN
		Description: insert a new Cancel Order
		Input: $'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy'
		Output: ID / error code
	*/
	function insertCancelOrderForHN($OrderQuantity, $Session, $FromTypeID, $OldOrderID, $Note, $OrderDate, $IsAssigner, $CreatedBy){
		$function_name = 'insertCancelOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($OrderDate) || !required($OrderQuantity) || !required($Session) || !required($OldOrderID) || !required($FromTypeID)
			|| !unsigned($OrderQuantity) || !unsigned($OldOrderID) || !unsigned($FromTypeID) || $Session > MAX_SESSION_HCM ) {

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30510;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30511;

			if (!required($Session) || !unsigned($Session) || $Session > MAX_SESSION_HN)
				$this->_ERROR_CODE = 30512;

			if (!required($OldOrderID) || !unsigned($OldOrderID))
				$this->_ERROR_CODE = 30513;

			if (!required($FromTypeID) || !unsigned($FromTypeID))
				$this->_ERROR_CODE = 30514;

		} else {
			$CheckSession = $this->checkSessionForHN($OrderDate);
			if ( $CheckSession == ORDER_EXPIRED || $CheckSession == ORDER_DENIED)
				$this->_ERROR_CODE = 30515;

			if ( $this->_ERROR_CODE == 0 ) {

				$query = sprintf( "CALL sp_insertCancelOrderForHN(%u, %u, %u, %u, '%s', '%s', '%u', '%s')",
										$OrderQuantity, $Session, $FromTypeID, $OldOrderID, $Note, $OrderDate, $IsAssigner, $CreatedBy);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30516;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30517;
								break;

							case '-2':
								$this->_ERROR_CODE = 30518;
								break;

							case '-3':
								$this->_ERROR_CODE = 30519;
								break;

							case '-4':
								$this->_ERROR_CODE = 30520;
								break;

							case '-5':
								$this->_ERROR_CODE = 30521;
								break;

							default:
								$this->_ERROR_CODE = $result;
						}
					} else {
						$this->items[0] = new SOAP_Value(
								'item',
								$struct,
								array(
									"ID"    => new SOAP_Value( "OrderID", "string", $result )
									)
							);
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: changeStatusFromTranferingToMatchedOrFailedForCancelOrderForHN
		Description: change Status
		Input: Order id
		Output: success / error code
	*/
	function changeStatusFromTranferingToMatchedOrFailedForCancelOrderForHN($OrderID, $IsMatched, $AccountNo, $UpdatedBy){
		$function_name = 'changeStatusFromTranferingToMatchedOrFailedForCancelOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30220;
		} else {

			if ( intval($IsMatched) == 1) {

				$query = sprintf( "SELECT o1.OrderQuantity, o1.OrderPrice, o1.OrderAgencyFee,
										o2.OrderQuantity AS OlderQuantity, o2.OrderAgencyFee AS OldOrderAgencyFee,
										o1.OldOrderID, o1.AccountID, o2.OrderSideID, o2.UnitCode, o2.BankID
										FROM %s o1, %s o2
										WHERE o1.ID=%u
										AND o1.Deleted='0'
										AND o2.Deleted='0'
										AND o1.OldOrderID=o2.ID
										AND o1.OrderStockStatusID=%u ",
										TBL_ORDER, TBL_ORDER,
										$OrderID,
										ORDER_TRANSFERING ) ;
				$rs = $this->_MDB2->extended->getRow($query);

				//block money in bank
				$query = sprintf( "SELECT vw_ListAccountBank_Detail.*
										FROM vw_ListAccountBank_Detail, %s
										WHERE AccountNo='%s'
										AND %s.Deleted='0'
										AND vw_ListAccountBank_Detail.AccountID = %s.AccountID
										AND vw_ListAccountBank_Detail.BankID = %u
										ORDER BY Priority LIMIT 1",
										TBL_ORDER,
										$AccountNo,
										TBL_ORDER,
										TBL_ORDER,
										$rs['bankid']);
				$bank_rs = $this->_MDB2->extended->getRow($query);

				if ($rs['ordersideid'] == ORDER_BUY ) {
					if ($bank_rs['accountid'] == $rs['accountid']) {
						//last Order
						$oldTempFee = $rs['olderquantity'] * $rs['orderprice'] * $rs['oldorderagencyfee'];
						$oldTempFee = $oldTempFee > 10000 ? $oldTempFee : 10000;
						$oldOrderValue = $rs['olderquantity'] * $rs['orderprice'] + $oldTempFee;
						$oldOrderValue = number_format($oldOrderValue, 0, ".", "");

						//remain Quantity
						$remainQuantity = $rs['olderquantity'] - $rs['orderquantity'] ;
						$remainQuantity = number_format($remainQuantity, 0, ".", "");

						//cancel Order
						if($remainQuantity > 0) { //incompleted cancel
							$tempCancelFee = $remainQuantity * $rs['orderprice'] * $rs['orderagencyfee'] ;
							$tempCancelFee = $tempCancelFee > 10000 ? $tempCancelFee : 10000;
							$cancelOrderValue = $remainQuantity * $rs['orderprice'] + $tempCancelFee;
							$cancelOrderValue = number_format($cancelOrderValue, 0, ".", "");
						} else { //completed cancel
							$cancelOrderValue =0;
						}

						$cancelValue = $oldOrderValue - $cancelOrderValue;

						if (strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
							switch($bank_rs['bankid']) {
								case DAB_ID:
									$dab = &new CDAB();
									$dab_rs = $dab->cancelBlockMoney($bank_rs['bankaccount'], $AccountNo, $rs['oldorderid'], $cancelValue );
									break;

								case VCB_ID:
									$dab = &new CVCB();
									$oldOrderID = $rs['oldorderid'] . $rs['unitcode'];
									$suffix = date("His");
									$newOrderID = $rs['oldorderid'] . $suffix;

									if ($cancelOrderValue > 0) {
										$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $oldOrderValue, $cancelOrderValue, $function_name );
									} else {
										$dab_rs = $dab->cancelBlockMoney($AccountNo, $oldOrderID, $oldOrderValue);
									}
									break;

								case NVB_ID:
									$dab = &new CNVB();
									$dab_rs = $dab->cancelBlockMoney(substr($rs['oldorderid'] .date("His"), 3), $bank_rs['bankaccount'], $cancelValue, $rs['oldorderid'] );
									break;

								case OFFLINE:
									$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $rs['oldorderid'], $cancelValue, $UpdatedBy);
                                    $mdb = initWriteDB();
$off_rs = $mdb->extended->getRow($query);
                                    $mdb->disconnect();
                                    $dab_rs = $off_rs['varerror'];
									break;
							} // switch
						} else {
							$dab_rs = 0;
						}

						if ($dab_rs != 0) { //fail
							$IsMatched = 0;
							switch($bank_rs['bankid']) {
								case DAB_ID:
									switch ($dab_rs) {
								case '-1':
									$this->_ERROR_CODE = 41060;
									break;

								case '-2':
									$this->_ERROR_CODE = 41061;
									break;

								case '-3':
									$this->_ERROR_CODE = 41062;
									break;

								case '-4':
									$this->_ERROR_CODE = 41063;
									break;

								case '-5':
									$this->_ERROR_CODE = 41064;
									break;

								case '1':
									$this->_ERROR_CODE = 41065;
									break;

								default:
									$this->_ERROR_CODE = $dab_rs;

							} // switch
									break;

								case VCB_ID:
									$arrErr = explode("_", $dab_rs);
									$this->_ERROR_CODE = $arrErr[1] ;
									break;

								case NVB_ID:
									$this->_ERROR_CODE = $dab_rs;
									break;

								case OFFLINE:
									switch ($dab_rs) {
										case '-1':
											$this->_ERROR_CODE = 30730;
											break;

										case '-2':
											$this->_ERROR_CODE = 30731;
											break;

										case '-3':
											$this->_ERROR_CODE = 30732;
											break;

										case '-4':
											$this->_ERROR_CODE = 30733;
											break;

										case '-5':
											$this->_ERROR_CODE = 30734;
											break;

										default:
											$this->_ERROR_CODE = $dab_rs;
									}
									break;
							}
						} // bank
					} else { // AccountNo doesn't match
						$this->_ERROR_CODE = 30225;
						return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
					}
				}
			}

			$query = sprintf( "CALL sp_updateFromTranferingToMatchedOrFailedForCancelOrderForHN(%u, '%u', '%s', '%s')", $OrderID, $IsMatched, $UpdatedBy, $suffix );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30221;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-2':
							$this->_ERROR_CODE = 30223;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} //switch
				} // if result
			} // if store

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getFailedOrderListForUnBlocked
		Description:
		Input:
		Output:
	*/
    function getFailedOrderListForUnBlocked($AccountNo, $OrderDate) {
		$function_name = 'getFailedOrderListForUnBlocked';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getFailedOrderListForUnBlocked('%s', '%s')", $AccountNo, $OrderDate);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"Session"    => new SOAP_Value("Session", "string", $result[$i]['session']),
						"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						)
				);
		}

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listOrderForBranch($Condition, $TimeZone) {
		$function_name = 'listOrderForBranch';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') AS nCreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as nUpdatedDate
							FROM vw_getListOrderForBranch %s ", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"Session"    => new SOAP_Value("Session", "string", $result[$i]['session']),
						"OrderStockStatusID"    => new SOAP_Value("OrderStockStatusID", "string", $result[$i]['orderstockstatusid']),
						"OrderStyleID"    => new SOAP_Value("OrderStyleID", "string", $result[$i]['orderstyleid']),
						"FromTypeID"    => new SOAP_Value("FromTypeID", "string", $result[$i]['fromtypeid']),
						"OldOrderID"    => new SOAP_Value("OldOrderID", "string", $result[$i]['oldorderid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['orderdate']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"OrderAgencyFee"    => new SOAP_Value("OrderAgencyFee", "string", $result[$i]['orderagencyfee']),
						"IsGotPaper"    => new SOAP_Value("IsGotPaper", "string", $result[$i]['isgotpaper']),
						"IsEditing"    => new SOAP_Value("IsEditing", "string", $result[$i]['isediting']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"IsUnBlocked"    => new SOAP_Value("IsUnBlocked", "string", $result[$i]['isunblocked']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['ncreateddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['nupdateddate']), "d/m/Y H:i:s") ),
						"Deleted"    => new SOAP_Value("Deleted", "string", $result[$i]['deleted']),
						"OldPrice"    => new SOAP_Value("OldPrice", "string", $result[$i]['oldprice']),
						"BlockedValue"    => new SOAP_Value("BlockedValue", "string", $result[$i]['blockedvalue']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['statusname']),
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"FromName"    => new SOAP_Value("FromName", "string", $result[$i]['fromname']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"BankShortName"    => new SOAP_Value("BankShortName", "string", $result[$i]['shortname']),
						"CompanyName"    => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
						"BranchID"    => new SOAP_Value("BranchID", "string", $result[$i]['branchid']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getOrderInfoToCall($OrderID) {
		$function_name = 'getOrderInfoToCall';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getOrderInfoToCall(%u) ", $OrderID);
		$result = $this->_MDB2->extended->getRow($query);
		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderID"    => new SOAP_Value( "OrderID", "string", $result['id'] ),
								"AccountNo"    => new SOAP_Value( "AccountNo", "string", $result['accountno'] ),
								"Symbol"    => new SOAP_Value( "Symbol", "string", $result['symbol'] ),
								"OrderQuantity"    => new SOAP_Value( "OrderQuantity", "string", $result['orderquantity'] ),
								"OrderPrice"    => new SOAP_Value( "OrderPrice", "string", $result['orderprice'] ),
								"OrderStyleName"    => new SOAP_Value( "OrderStyleName", "string", $result['orderstylename'] ),
								"OrderSideName"    => new SOAP_Value( "OrderSideName", "string", $result['ordersidename'] ),
								"OldOrderID"    => new SOAP_Value( "OldOrderID", "string", $result['oldorderid'] ),
								"OldPrice"    => new SOAP_Value( "OldPrice", "string", $result['oldprice'] ),
								"Note"    => new SOAP_Value( "Note", "string", $result['note'] ),
								"StockExchangeID"    => new SOAP_Value( "StockExchangeID", "string", $result['stockexchangeid'] ),
								"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result['isnewedit']),
								)
						);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getOrderListToCall($StockExchangeID, $IsVIP, $Session, $OrderDate) {
		$function_name = 'getOrderListToCall';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getOrderListToCall(%u, %u, %u, '%s') ", $StockExchangeID, $IsVIP, $Session, $OrderDate);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['id']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
						"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['orderprice']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getOrderInventory($OrderDate) {
		$function_name = 'getOrderInventory';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_OrderInventory('%s') ", $OrderDate);
		$result = $this->_MDB2->extended->getRow($query);
		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"HoSE"    => new SOAP_Value( "HoSE", "string", $result['varhose'] ),
								"VIPHoSE"    => new SOAP_Value( "VIPHoSE", "string", $result['varviphose'] ),
								"HaSTC"    => new SOAP_Value( "HaSTC", "string", $result['varhastc'] ),
								"VIPHaSTC"    => new SOAP_Value( "VIPHaSTC", "string", $result['varviphastc'] ),
								)
						);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getDealForBranch($TradingDate, $AccountNo, $BranchID) {
		$function_name = 'getDealForBranch';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getDealForBranch('%s', '%s', %u) ", $TradingDate, $AccountNo, $BranchID);
		$result = $this->_MDB2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"OrderNumber"    => new SOAP_Value( "OrderNumber", "string", $result[$i]['ordernumber'] ),
						"AccountNo"    => new SOAP_Value( "AccountNo", "string", $result[$i]['accountno'] ),
						"OrderSideName"    => new SOAP_Value( "OrderSideName", "string", $result[$i]['ordersidename'] ),
						"Symbol"    => new SOAP_Value( "Symbol", "string", $result[$i]['symbol'] ),
						"MatchedQuantity"    => new SOAP_Value( "MatchedQuantity", "string", $result[$i]['matchedquantity'] ),
						"MatchedPrice"    => new SOAP_Value( "MatchedPrice", "string", $result[$i]['matchedprice'] ),
						"MatchedSession"    => new SOAP_Value( "MatchedSession", "string", $result[$i]['matchedsession'] ),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getGoodPricesAndVolumns($Symbol, $TradingDate, $StockExchangeID) {
		$function_name = 'getGoodPricesAndVolumns';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$mdb2 = initTradingBoard();
		$query = sprintf( "CALL sp_getTradingBoardInfoForOrderForm('%s','%s', %u); ", $Symbol, $TradingDate, $StockExchangeID);
		$result = $mdb2->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"PriorClosePrice"    => new SOAP_Value( "PriorClosePrice", "string", $result['PriorClosePrice'] ),
								"Highest"    => new SOAP_Value( "Highest", "string", $result['Highest'] ),
								"Lowest"    => new SOAP_Value( "Lowest", "string", $result['Lowest'] ),
								"Last"    => new SOAP_Value( "Last", "string", $result['Last'] ),
								"Change"    => new SOAP_Value( "Change", "string", $result['Change'] ),
								"LastVol"    => new SOAP_Value( "LastVol", "string", $result['LastVol'] ),
								"Best1Bid"    => new SOAP_Value( "Best1Bid", "string", $result['Best1Bid'] ),
								"Best1BidVolume"    => new SOAP_Value( "Best1BidVolume", "string", $result['Best1BidVolume'] ),
								"Best2Bid"    => new SOAP_Value( "Best2Bid", "string", $result['Best2Bid'] ),
								"Best2BidVolume"    => new SOAP_Value( "Best2BidVolume", "string", $result['Best2BidVolume'] ),
								"Best3Bid"    => new SOAP_Value( "Best3Bid", "string", $result['Best3Bid'] ),
								"Best3BidVolume"    => new SOAP_Value( "Best3BidVolume", "string", $result['Best3BidVolume'] ),
								"Best1Offer"    => new SOAP_Value( "Best1Offer", "string", $result['Best1Offer'] ),
								"Best1OfferVolume"    => new SOAP_Value( "Best1OfferVolume", "string", $result['Best1OfferVolume'] ),
								"Best2Offer"    => new SOAP_Value( "Best2Offer", "string", $result['Best2Offer'] ),
								"Best2OfferVolume"    => new SOAP_Value( "Best2OfferVolume", "string", $result['Best2OfferVolume'] ),
								"Best3Offer"    => new SOAP_Value( "Best3Offer", "string", $result['Best3Offer'] ),
								"Best3OfferVolume"    => new SOAP_Value( "Best3OfferVolume", "string", $result['Best3OfferVolume'] ),
								)
						);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getTempQuantity($AccountID, $StockID, $OrderDate) {
		$function_name = 'getTempQuantity';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT f_getTempQuantity(%u, %u, '%s') AS TempQuantity", $AccountID, $StockID, $OrderDate);
		$result = $this->_MDB2->extended->getRow($query);
		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"TempQuantity"    => new SOAP_Value( "TempQuantity", "string", $result['tempquantity'] ),
								)
						);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function list10MatchedDeals($Symbol) {
		$function_name = 'list10MatchedDeals';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$mdb2 = initTradingBoard();
		$query = sprintf( "CALL sp_LE_get('%s') ", $Symbol);
		$result = $mdb2->extended->getAll($query);
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$this->items[$i] = new SOAP_Value(
								'item',
								$struct,
								array(
									"Symbol"    => new SOAP_Value( "Symbol", "string", $result[$i]['Symbol'] ),
									"Price"    => new SOAP_Value( "Price", "string", $result[$i]['Price'] ),
									"Volumn"    => new SOAP_Value( "Volumn", "string", $result[$i]['Vol'] ),
									"Time"    => new SOAP_Value( "Time", "string", $result[$i]['Time'] ),
									)
							);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function displayOrder($StockExchangeID, $IsVIP, $OrderDate, $UpdatedBy) {
		$function_name = 'displayOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockExchangeID) || !unsigned($StockExchangeID) || !required($IsVIP) || !required($OrderDate) ) {
			if ( !required($StockExchangeID) || !unsigned($StockExchangeID) )
				$this->_ERROR_CODE = 30530;

			if ( !required($IsVIP) )
				$this->_ERROR_CODE = 30531;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 30532;

		} else {
			$query = sprintf( "CALL sp_Order_getOrderInfoToSend(%u, %u, '%s')", $StockExchangeID, $IsVIP, $OrderDate);
			$result = $this->_MDB2->extended->getRow($query);
			if($result['id'] > 0) {
				$query = sprintf( "CALL sp_order_updateFromApprovedToTranfered(%u, '%s')", $result['id'], $UpdatedBy);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)){
					$this->_ERROR_CODE = 30533;
				} else {
					$updateResult = $rs['varerror'];
					if ($updateResult < 0) {
						switch ($updateResult) {
							case '-1':
								$this->_ERROR_CODE = 30534;
								break;

							case '-2':
								$this->_ERROR_CODE = 30535;
								break;

							case '-3':
								$this->_ERROR_CODE = 30536;
								break;

							default:
								$this->_ERROR_CODE = 666;
						} //switch
					} else {// if result
						$this->items[0] = new SOAP_Value(
											'item',
											$struct,
											array(
												"ID"    => new SOAP_Value( "ID", "string", $result['id'] ),
												"AccountNo"    => new SOAP_Value( "AccountNo", "string", $result['accountno'] ),
												"Symbol"    => new SOAP_Value( "Symbol", "string", $result['symbol'] ),
												"OrderQuantity"    => new SOAP_Value( "OrderQuantity", "string", $result['orderquantity'] ),
												"OrderPrice"    => new SOAP_Value( "OrderPrice", "string", $result['orderprice'] ),
												"OrderSideName"    => new SOAP_Value( "OrderSideName", "string", $result['ordersidename'] ),
												"Note"    => new SOAP_Value( "Note", "string", $result['note'] ),
												"OrderStyleName"    => new SOAP_Value( "OrderStyleName", "string", $result['orderstylename'] ),
												)
										);
					}
				} // if store
			}
		}//requirement
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function newDisplayOrderForHN($IsVIP, $OrderDate) {
		$function_name = 'newDisplayOrderForHN';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($IsVIP) || !required($OrderDate) ) {
			if ( !required($IsVIP) )
				$this->_ERROR_CODE = 30531;

			if ( !required($OrderDate) )
				$this->_ERROR_CODE = 30532;

		} else {
			if($IsVIP == 1)
				$query = sprintf( "CALL sp_Order_getVIPHaNoiOrderInfoToSend('%s')", $OrderDate);
			else
				$query = sprintf( "CALL sp_Order_getHaNoiOrderInfoToSend('%s')", $OrderDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result );
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
									'item',
									$struct,
									array(
										"ID"    => new SOAP_Value( "ID", "string", $result[$i]['id'] ),
										"AccountNo"    => new SOAP_Value( "AccountNo", "string", $result[$i]['accountno'] ),
										"Symbol"    => new SOAP_Value( "Symbol", "string", $result[$i]['symbol'] ),
										"OrderQuantity"    => new SOAP_Value( "OrderQuantity", "string", $result[$i]['orderquantity'] ),
										"OrderPrice"    => new SOAP_Value( "OrderPrice", "string", $result[$i]['orderprice'] ),
										"OrderSideName"    => new SOAP_Value( "OrderSideName", "string", $result[$i]['ordersidename'] ),
										"Note"    => new SOAP_Value( "Note", "string", $result[$i]['note'] ),
										"OrderStyleName"    => new SOAP_Value( "OrderStyleName", "string", $result[$i]['orderstylename'] ),
										)
								);
			}
		}//requirement
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function getTradingCode($AccountNo) {
		$function_name = 'getTradingCode';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getTradingCode('%s')", $AccountNo);
		$result = $this->_MDB2->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"TradingCode"    => new SOAP_Value( "TradingCode", "string", $result['vartradingcode'] ),
								)
						);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Chi them ngay 04-03-2010
		Function: insertTradeForHNX
		Description: insert deal for hnx
		Input: $'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy'
		Output: ID / error code
	*/
	function insertTradeForHNX($ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy){
		$function_name = 'insertTradeForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($ConfirmNo) || !required($OrderNumber) || !required($MatchedQuantity) || !required($MatchedPrice) || !required($MatchedSession)|| !required($TradingDate)) {

			if (!required($ConfirmNo) )
				$this->_ERROR_CODE = 99999;

			if (!required($OrderNumber))
				$this->_ERROR_CODE = 99999;

			if (!required($MatchedQuantity) )
				$this->_ERROR_CODE = 99999;

			if (!required($MatchedPrice) )
				$this->_ERROR_CODE = 99999;

			if (!required($MatchedSession))
				$this->_ERROR_CODE = 99999;
			if (!required($TradingDate))
				$this->_ERROR_CODE = 99999;

		} else {


				$query = sprintf( "CALL sp_hnx_Trade_Insert('%s', '%s', %u, %u, %u, '%s', '%s')",
										$ConfirmNo, $OrderNumber, $MatchedQuantity, $MatchedPrice, $MatchedSession, $TradingDate, $CreatedBy);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 999998;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 999997;
								break;

							default:
								$this->_ERROR_CODE = $result;
						}
					} else {
						$this->_ERROR_CODE = 0;
					}
				}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/* End Chi them ngay 04-03-2010 */

  function checkInvalidDate($TradingDate){
    $function_name = 'checkInvalidDate';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $query = sprintf("SELECT f_checkInvalidDate('%s') as Boolean", $TradingDate );
    $rs = $this->_MDB2->extended->getRow($query);

    $result = (string)$rs['boolean'];

    $this->items[0] = new SOAP_Value(
              'item',
              $struct,
              array(
                "Boolean"    => new SOAP_Value( "Boolean", "string", $result )
                )
            );
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
}

function initTradingBoard() {
        //initialize MDB2
        $mdb2 = &MDB2::factory(DB_DNS_TRADING_BOARD);
        $mdb2->loadModule('Extended');
        $mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
        $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
        return $mdb2;
}

function checkVIPAccount($AccountNo) {
	$MDB2 = initDB();
	$query = sprintf( "SELECT f_VipList_IsExisted('%s') AS Boolean", $AccountNo);
	$result = $MDB2->extended->getRow($query);
	return $result['boolean'];
}

function checkForeignRoom($Symbol, $OrderDate, $OrderQuantity) {
	$MDB2 = initTradingBoard();
	$query = sprintf( "SELECT f_getCurrentFroom('%s','%s') AS Quantity", $OrderDate, $Symbol);
	$result = $MDB2->extended->getRow($query);
	if ($result['Quantity'] > $OrderQuantity)
		return $result['Quantity'];
	else
		return -1;
}

function whichSession($OrderDate, $Session) {
	$now = time();

	//2
	$OrderDateStartTime2 = $OrderDate ." ". changeMinute(SESSION_2_START, "0") .":30";
	$OrderDateEndTime2 = $OrderDate ." ". changeMinute(SESSION_2_END, "0") .":31";
	$arrOrderDateEndTime2 = parseDateTime($OrderDateEndTime2);
	$arrOrderDateStartTime2 = parseDateTime($OrderDateStartTime2);
	$unixOrderDateEndTime2 = mktime($arrOrderDateEndTime2[3], $arrOrderDateEndTime2[4], $arrOrderDateEndTime2[5], $arrOrderDateEndTime2[1], $arrOrderDateEndTime2[2], $arrOrderDateEndTime2[0]);
	$unixOrderDateStartTime2 = mktime($arrOrderDateStartTime2[3], $arrOrderDateStartTime2[4], $arrOrderDateStartTime2[5], $arrOrderDateStartTime2[1], $arrOrderDateStartTime2[2], $arrOrderDateStartTime2[0]);

	if ($unixOrderDateStartTime2 <= $now && $unixOrderDateEndTime2 >= $now) {
		if ($Session == 2)
			return 2;

	} else {
		//3
		$OrderDateStartTime3 = $OrderDate ." ". changeMinute(SESSION_3_START, "0") .":30";
		$OrderDateEndTime3 = $OrderDate ." ". changeMinute(SESSION_3_END, "0") .":31";
		$arrOrderDateEndTime3 = parseDateTime($OrderDateEndTime3);
		$arrOrderDateStartTime3 = parseDateTime($OrderDateStartTime3);
		$unixOrderDateEndTime3 = mktime($arrOrderDateEndTime3[3], $arrOrderDateEndTime3[4], $arrOrderDateEndTime3[5], $arrOrderDateEndTime3[1], $arrOrderDateEndTime3[2], $arrOrderDateEndTime3[0]);
		$unixOrderDateStartTime3 = mktime($arrOrderDateStartTime3[3], $arrOrderDateStartTime3[4], $arrOrderDateStartTime3[5], $arrOrderDateStartTime3[1], $arrOrderDateStartTime3[2], $arrOrderDateStartTime3[0]);

		if ($unixOrderDateStartTime3 <= $now && $unixOrderDateEndTime3 >= $now) {
			if ($Session == 3)
				return 3;
		} else {
			return -1;
		}
	}
	return -1;
}

?>
