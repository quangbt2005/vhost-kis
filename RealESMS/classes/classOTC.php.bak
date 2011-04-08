<?php
require_once('../includes.php');

/**
	Author: Ly Duong Duy Trung
	Created date: 05/26/2008
*/

define('NHHM', '22');

class COTC extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;

	function COTC($check_ip) {
		//initialize MDB2
		/*$this->_MDB2 = initTradingBoard();
		$this->_MDB2_WRITE = initTradingBoard();*/
		$this->_MDB2 = initDB();
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		$this->class_name = get_class($this);
		$this->items = array();

		$arr = array(
					/*'insertOTCAd' => array( 'input' => array( 'SideName', 'CompanyID', 'Volume', 'Price1', 'Price2', 'CreatedBy' ),
											'output' => array( )),

					'updateOTCAd' => array( 'input' => array( 'ID', 'Volume', 'Price1', 'Price2', 'UpdatedBy' ),
											'output' => array()),

					'deleteOTCAd' => array( 'input' => array( 'ID', 'UpdatedBy'),
											'output' => array()),

					'getOTCAds' => array( 'input' => array( 'Type'),
											'output' => array( 'ID', 'TradeCode', 'SideName', 'StockName', 'Volume', 'Price' )),

					'makeDealOTC' => array( 'input' => array( 'ID', 'UpdatedBy'),
											'output' => array()),

					'approveOTCAd' => array( 'input' => array( 'ID', 'UpdatedBy'),
											'output' => array()),

					'listCompanies' => array( 'input' => array( ),
											'output' => array( 'ID', 'CompanyName', 'ShortName', 'StockName')),

					'getOTCAdDetail' => array( 'input' => array( 'ID', 'Type'),
											'output' => array( 'ID', 'CompanyName', 'SideName', 'Volume', 'Price1', 'Price2', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'ApprovedBy', 'ApprovedDate', 'TradeCode' )),

					'getPersonalInfo' => array( 'input' => array( 'Name'),
											'output' => array( 'IsEmployee', 'FullName', 'Phone' )),*/

					'insertBuyOrder' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'IsGotPaper', 'CreatedBy', 'AccountNoContra', 'CompanyNameContra'),
											'output' => array( 'ID' )),

					'insertSellOrder' => array( 'input' => array( 'AccountNo', 'StockID', 'OrderQuantity', 'OrderPrice', 'Session', 'FromTypeID', 'Note', 'OrderDate', 'IsAssigner', 'IsGotPaper', 'CreatedBy', 'AccountNoContra', 'CompanyNameContra'),
											'output' => array( 'ID' )),

					'updateSellOrder' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'UpdatedBy'),
											'output' => array( )),

					'updateBuyOrder' => array( 'input' => array( 'OrderID', 'OrderQuantity', 'OrderPrice', 'AccountNo', 'UpdatedBy'),
											'output' => array( )),

					'deleteOrder' => array( 'input' => array( 'OrderID', 'AccountNo', 'UpdatedBy' ),
											'output' => array()),

					'listOrders' => array( 'input' => array( 'OrderDate', 'AccountID', 'OrderStockStatusID' ),
											'output' => array( 'OrderID', 'AccountNo', 'StockID', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideID', 'OrderSideName', 'Session', 'OrderStockStatusID', 'StatusName', 'OrderStyleID', 'OrderStyleName', 'FromName', 'OldOrderID', 'Note', 'OrderDate', 'OrderAgencyFee', 'StockExchangeID', 'ExchangeName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'BankName', 'BankShortName', 'CompanyName', 'OldPrice', 'BlockedValue', 'IsNewEdit', 'OrderNumber', 'AccountID', 'FromTypeID', 'IsUnBlocked', 'BranchID', 'AccountNoContra', 'CompanyNameContra' )),

					'listOrdersWithLimitation' => array( 'input' => array( 'OrderDate', 'AccountID', 'OrderStockStatusID' ),
											'output' => array( 'OrderID', 'AccountNo', 'StockID', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderSideID', 'OrderSideName', 'Session', 'OrderStockStatusID', 'StatusName', 'OrderStyleID', 'OrderStyleName', 'FromName', 'OldOrderID', 'Note', 'OrderDate', 'OrderAgencyFee', 'StockExchangeID', 'ExchangeName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'BankName', 'BankShortName', 'CompanyName', 'OldPrice', 'BlockedValue', 'IsNewEdit', 'OrderNumber', 'AccountID', 'FromTypeID', 'IsUnBlocked', 'BranchID', 'AccountNoContra', 'CompanyNameContra' )),

					'insertCancelOrderForHN' => array( 'input' => array( 'OrderQuantity', 'Session', 'FromTypeID', 'OldOrderID', 'Note', 'OrderDate', 'IsAssigner', 'CreatedBy'),
											'output' => array( 'ID' )),

					'getOrderInfoToCall' => array( 'input' => array( 'OrderID' ),
											'output' => array( 'OrderID', 'AccountNo', 'Symbol', 'OrderQuantity', 'OrderPrice', 'OrderStyleName', 'OrderSideName', 'OldOrderID', 'OldPrice', 'Note', 'StockExchangeID', 'IsNewEdit', 'AccountNoContra', 'CompanyNameContra' )),

					'updateTFlag' => array( 'input' => array( 'OrderID', 'TFlag', 'UpdatedBy'),
											'output' => array( )),

					'stockDetailWithoutConfirmList' => array( 'input' => array( 'TradingDate', 'TFlag'),
											'output' => array( 'ID', 'OrderNumber', 'AccountNo', 'OrderSideName', 'Symbol', 'MatchedQuantity', 'MatchedPrice', 'Note', 'TradingDate', 'StockExchangeID', 'OrderSideID', 'OrderID', 'TFlag')),

					'executeStockOfBuyingDealWithTFlag' => array( 'input' => array( 'ID', 'UpdatedBy', 'TFlag'),
											'output' => array( )),

					'executeStockOfSellingDealWithTFlag' => array( 'input' => array( 'ID', 'UpdatedBy', 'TFlag'),
											'output' => array( )),

					'editPriceOfTransferBuyingOrder' => array( 'input' => array( 'OrderID', 'OrderPrice', 'AccountNo', 'UpdatedBy'),
											'output' => array( )),

					'editPriceOfSellingOrder' => array( 'input' => array( 'OrderID', 'NewOrderPrice', 'UpdatedBy'),
											'output' => array( )),

					'updateFromEditingtoTransfer' => array( 'input' => array( 'OrderID', 'UpdatedBy'),
											'output' => array( )),

					'updateFromTransferToEditing' => array( 'input' => array( 'OrderID', 'UpdatedBy'),
											'output' => array( )),

					'updateFromTransferingToTransferWithMatchedOrFailed' => array( 'input' => array( 'OrderID', 'IsMatched', 'UpdatedBy', 'MatchedQuantity'),
											'output' => array( )),

					'updateFromTransferingToTransfered' => array( 'input' => array( 'OrderID', 'UpdatedBy'),
											'output' => array( )),

					'updateFromTransferedToTransfering' => array( 'input' => array( 'OrderID', 'UpdatedBy'),
											'output' => array( )),

						);

		parent::__construct($arr);
	}

	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}

	/*
	function insertOTCAd($SideName, $CompanyID, $Volume, $Price1, $Price2, $CreatedBy){
		$function_name = 'insertOTCAd';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if (!required($SideName) || !required($CompanyID) || !unsigned($CompanyID) || !required($Volume) || !unsigned($Volume) || !required($Price1) || !required($Price2) ) {
			if (!required($SideName))
				$this->_ERROR_CODE = 38001;

			if ( !required($CompanyID) || !unsigned($CompanyID) )
				$this->_ERROR_CODE = 38002;

			if ( !required($Volume) || !unsigned($Volume) )
				$this->_ERROR_CODE = 38003;

			if (!required($Price1))
				$this->_ERROR_CODE = 38004;

			if (!required($Price2))
				$this->_ERROR_CODE = 38005;
		} else {

			$query = sprintf( "CALL sp_OTC_Ads_insert('%s', %u, %u, %f, %f, '%s')", $SideName, $CompanyID, $Volume, $Price1, $Price2, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 38006;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 38007;
							break;

						case '-2':
							$this->_ERROR_CODE = 38008;
							break;

						case '-3':
							$this->_ERROR_CODE = 38009;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function updateOTCAd($ID, $Volume, $Price1, $Price2, $UpdatedBy){
		$function_name = 'updateOTCAd';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($Volume) || !unsigned($Volume) || !required($Price1) || !required($Price2) ) {
			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 38010;

			if ( !required($Volume) || !unsigned($Volume) )
				$this->_ERROR_CODE = 38011;

			if (!required($Price1))
				$this->_ERROR_CODE = 38012;

			if (!required($Price2))
				$this->_ERROR_CODE = 38013;
		} else {

			$query = sprintf( "CALL sp_OTC_Ads_update(%u, %u, %f, %f, '%s')", $ID, $Volume, $Price1, $Price2, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 38014;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 38015;
							break;

						case '-2':
							$this->_ERROR_CODE = 38016;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteOTCAd($ID, $UpdatedBy ){
		$function_name = 'deleteOTCAd';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) ) {
			$this->_ERROR_CODE = 38020;

		} else {

			$query = sprintf( "CALL sp_OTC_Ads_delete(%u, '%s')", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 38021;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 38022;
							break;

						case '-2':
							$this->_ERROR_CODE = 38023;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getOTCAds($Type){
		$function_name = 'getOTCAds';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_OTC_Ads_get( '%s' )", $Type);
		$rs = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($rs); $i++){
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value( "ID", "string", $rs[$i]['ID'] ),
						"TradeCode"    => new SOAP_Value( "TradeCode", "string", $rs[$i]['TradeCode'] ),
						"SideName"    => new SOAP_Value( "SideName", "string", $rs[$i]['SideName'] ),
						"StockName"    => new SOAP_Value( "StockName", "string", $rs[$i]['StockName'] ),
						"Volume"    => new SOAP_Value( "Volume", "string", $rs[$i]['Volume'] ),
						"Price"    => new SOAP_Value( "Price", "string", $rs[$i]['Price'] ),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function makeDealOTC($ID, $UpdatedBy ){
		$function_name = 'makeDealOTC';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) ) {
			$this->_ERROR_CODE = 38025;

		} else {

			$query = sprintf( "CALL sp_OTC_Ads_deal(%u, '%s')", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 38026;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 38027;
							break;

						case '-2':
							$this->_ERROR_CODE = 38028;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function approveOTCAd($ID, $UpdatedBy ){
		$function_name = 'makeDealOTC';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) ) {
			$this->_ERROR_CODE = 38030;

		} else {

			$query = sprintf( "CALL sp_OTC_Ads_approve(%u, '%s')", $ID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 38031;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 38032;
							break;

						case '-2':
							$this->_ERROR_CODE = 38033;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function listCompanies(){
		$function_name = 'listCompanies';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_OTC_get_company_list()" );
		$rs = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($rs); $i++){
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value( "ID", "string", $rs[$i]['ID'] ),
						"CompanyName"    => new SOAP_Value( "CompanyName", "string", $rs[$i]['CompanyName'] ),
						"ShortName"    => new SOAP_Value( "ShortName", "string", $rs[$i]['ShortName'] ),
						"StockName"    => new SOAP_Value( "StockName", "string", $rs[$i]['StockName'] ),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getOTCAdDetail($ID, $Type){
		$function_name = 'getOTCAdDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_OTC_Ads_get_detail(%u, '%s')", $ID, $Type );
		$rs = $this->_MDB2->extended->getRow($query);
		if( !empty($rs))
		{
			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value( "ID", "string", $rs['ID'] ),
						"CompanyName"    => new SOAP_Value( "CompanyName", "string", $rs['CompanyName'] ),
						"SideName"    => new SOAP_Value( "SideName", "string", $rs['SideName'] ),
						"Volume"    => new SOAP_Value( "Volume", "string", $rs['Volume'] ),
						"Price1"    => new SOAP_Value( "Price1", "string", $rs['Price1'] ),
						"Price2"    => new SOAP_Value( "Price2", "string", $rs['Price2'] ),
						"CreatedBy"    => new SOAP_Value( "CreatedBy", "string", $rs['CreatedBy'] ),
						"CreatedDate"    => new SOAP_Value( "CreatedDate", "string", $rs['CreatedDate'] ),
						"UpdatedBy"    => new SOAP_Value( "UpdatedBy", "string", $rs['UpdatedBy'] ),
						"UpdatedDate"    => new SOAP_Value( "UpdatedDate", "string", $rs['UpdatedDate'] ),
						"ApprovedBy"    => new SOAP_Value( "ApprovedBy", "string", $rs['ApprovedBy'] ),
						"ApprovedDate"    => new SOAP_Value( "ApprovedDate", "string", $rs['ApprovedDate'] ),
						"TradeCode"    => new SOAP_Value( "TradeCode", "string", $rs['TradeCode'] )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getPersonalInfo($Name){
		$function_name = 'getPersonalInfo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$esms = initDB();
		$query = sprintf( "CALL sp_OTC_Ads_get_who_info('%s')", $Name);
		$rs = $esms->extended->getRow($query);

		if( !empty($rs)) {
			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"IsEmployee"    => new SOAP_Value( "IsEmployee", "string", $rs['isemployee'] ),
						"FullName"    => new SOAP_Value( "FullName", "string", $rs['fullname'] ),
						"Phone"    => new SOAP_Value( "Phone", "string", $rs['phone'] ),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	*/

	function insertBuyOrder($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra){
		$function_name = 'insertBuyOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking Acount is active / not
		if (!checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) ) {

			if (!required($AccountNo) )
				$this->_ERROR_CODE = 30004;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30005;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30006;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30007;

			if (!required($Session))
				$this->_ERROR_CODE = 30008;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30009;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( !checkStockPrice( $StockID, $OrderPrice, $OrderDate ) )
				$this->_ERROR_CODE = 30011;

			if ( $this->_ERROR_CODE == 0 ) {
				$query = sprintf( "CALL sp_upcom_insertBuyingOrder('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
								$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra);

				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30015;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 19001;
								break;

							case '-2':
								$this->_ERROR_CODE = 19002;
								break;

							case '-3':
								$this->_ERROR_CODE = 19003;
								break;

							case '-4':
								$this->_ERROR_CODE = 19004;
								break;

							case '-5':
								$this->_ERROR_CODE = 19005;
								break;

							default:
								$this->_ERROR_CODE = $result;
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
										if (!killStupidBank()) // VCB is stupid
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
									// added by Quang, 20100407 ------------------------------------
        					                                break;
                                    					case OFFLINE:
                                        					//inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inOrderDate date,inCreatedBy
                                        					$mdb = initWriteDB();
                                        					$query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                                        					$off_rs = $mdb->extended->getRow($query);
                                        					$mdb->disconnect();
                                        					$dab_rs = $off_rs['varerror'];
                                        					break;
                                    					// end add -----------------------------------------------------
								}

								if ($dab_rs == 0){
									$BankID = $bank_rs[$i]['bankid'];
									break;
								}
							}
						} else {
							$dab_rs = 0;
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

	function insertSellOrder($AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra ){
		$function_name = 'insertSellOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		// checking account is active / not
		if (!checkAccountIsActive($AccountNo)) {
			$this->_ERROR_CODE = 30275;
			return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
		}

		if (!required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
			|| !unsigned($OrderQuantity) || !unsigned($StockID) ) {

			if (!required($AccountNo))
				$this->_ERROR_CODE = 30051;

			if (!required($OrderDate) )
				$this->_ERROR_CODE = 30052;

			if (!required($StockID) || !unsigned($StockID))
				$this->_ERROR_CODE = 30053;

			if (!required($OrderQuantity) || !unsigned($OrderQuantity))
				$this->_ERROR_CODE = 30054;

			if (!required($Session))
				$this->_ERROR_CODE = 30055;

			if (!required($OrderPrice) )
				$this->_ERROR_CODE = 30056;

		} else {
			if (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false && $FromTypeID == 5) {
				$this->_ERROR_CODE = 30602;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			}

			if ( !checkStockPrice( $StockID, $OrderPrice, $OrderDate ) )
				$this->_ERROR_CODE = 30057;

			if ( $this->_ERROR_CODE == 0 ) {
				$query = sprintf( "CALL sp_upcom_insertSellingOrder('%s', %u, %u, %u, %u, '%u', '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
								$AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra );
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 30060;
				} else {
					$result = $rs['varerror'];

					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 19010;
								break;

							case '-2':
								$this->_ERROR_CODE = 19011;
								break;

							case '-3':
								$this->_ERROR_CODE = 19012;
								break;

							case '-4':
								$this->_ERROR_CODE = 19013;
								break;

							case '-5':
								$this->_ERROR_CODE = 19014;
								break;

							case '-6':
								$this->_ERROR_CODE = 19015;
								break;

							default:
								$this->_ERROR_CODE = $result;
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

	function updateSellOrder($OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy){
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
			$query = sprintf( "CALL sp_upcom_editSellingOrder(%u, %u, %f, '%s')", $OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30073;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19020;
							break;

						case '-2':
							$this->_ERROR_CODE = 19021;
							break;

						case '-3':
							$this->_ERROR_CODE = 19022;
							break;

						case '-4':
							$this->_ERROR_CODE = 19023;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}

				$mdb = initWriteDB();
				$query = sprintf( "CALL sp_updateIsEditingAfterEdit( %u, '%s' )", $OrderID, $UpdatedBy );
				$rs = $mdb->extended->getRow($query);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function updateBuyOrder($OrderID, $OrderQuantity, $OrderPrice, $AccountNo, $UpdatedBy){
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

			//lock money in bank
			$query = sprintf( "SELECT vw_ListAccountBank_Detail.*, UnitCode, OrderQuantity * OrderPrice AS OrderValue, OrderAgencyFee, vw_ListAccountBank_Detail.AccountID
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
							$dab_rs = $dab->editBlockMoney($AccountNo, $oldOrderID, $newOrderID, $oldOrderValue, $orderValue );
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
						// added by Quang, 2010-04-07 ----------------------------------------------
			                        case OFFLINE:
                        			    //inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inCreatedBy  $OrderID, $AccountNo, $orderValue,
                           				 $query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $AccountNo, OFFLINE, $OrderID, $orderValue, $UpdatedBy);
				                        $this->_MDB2_WRITE->connect();
                            				$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
                            				$this->_MDB2_WRITE->disconnect();
                            				$dab_rs = $off_rs['varerror'];
                            				break;
                        			// end add -----------------------------------------------------------------
					} //switch
				} else {
					$dab_rs = 0;
				}

				if ($dab_rs == 0) { //Successfully
					$this->_MDB2_WRITE->connect();
					$query = sprintf( " CALL sp_upcom_editBuyingOrder(%u, %u, %u, '%s', '%s', %f)", $OrderID, $OrderQuantity, $OrderPrice, $UpdatedBy, $suffix, $fee_rs['orderagencyfee'] );
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30034;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 19030;
									break;

								case '-5':
									$this->_ERROR_CODE = 19031;
									break;

								case '-6':
									$this->_ERROR_CODE = 19032;
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
				}
			} else { // AccountNo doesn't match with AccountID
				$this->_ERROR_CODE = 30041;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function deleteOrder($OrderID, $AccountNo, $UpdatedBy){
		$function_name = 'deleteOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) ) {
			$this->_ERROR_CODE = 30380;
		} else {
			$query = sprintf( "CALL sp_upcom_deleteOrder(%u, '%s')", $OrderID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30381;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19040;
							break;

						case '-2':
							$this->_ERROR_CODE = 19041;
							break;

						case '-3':
							$this->_ERROR_CODE = 19042;
							break;

						default:
							$this->_ERROR_CODE = $result;
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
								case OFFLINE:
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
						}
					} else { //deleteOrderHN: AccountNo doesn't match with AccountID
						$this->_ERROR_CODE = 30385;
					}
				}
			} // WS
		} // valid
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

    function listOrders($OrderDate, $AccountID, $OrderStockStatusID) {
		$function_name = 'listOrders';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_upcom_OrderList('%s', %u, %u) ", $OrderDate, $AccountID, $OrderStockStatusID);
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
						"OrderAgencyFee"    => new SOAP_Value("OrderAgencyFee", "string", $result[$i]['orderagencyfee']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") ),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"BankShortName"    => new SOAP_Value("BankShortName", "string", $result[$i]['shortname']),
						"CompanyName"    => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
						"OldPrice"    => new SOAP_Value("OldPrice", "string", $result[$i]['oldprice']),
						"BlockedValue"    => new SOAP_Value("BlockedValue", "string", $result[$i]['blockedvalue']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"FromTypeID"    => new SOAP_Value("FromTypeID", "string", $result[$i]['fromtypeid']),
						"IsUnBlocked"    => new SOAP_Value("IsUnBlocked", "string", $result[$i]['isunblocked']),
						"BranchID"    => new SOAP_Value("BranchID", "string", $result[$i]['branchid']),
						"AccountNoContra"    => new SOAP_Value("AccountNoContra", "string", $result[$i]['accountnocontra']),
						"CompanyNameContra"    => new SOAP_Value("CompanyNameContra", "string", $result[$i]['companynamecontra']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listOrdersWithLimitation($OrderDate, $AccountID, $OrderStockStatusID) {
		$function_name = 'listOrdersWithLimitation';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_upcom_OrderListWithLimit('%s', %u, %u) ", $OrderDate, $AccountID, $OrderStockStatusID);
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
						"OrderAgencyFee"    => new SOAP_Value("OrderAgencyFee", "string", $result[$i]['orderagencyfee']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"ExchangeName"    => new SOAP_Value("ExchangeName", "string", $result[$i]['exchangename']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") ),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"BankShortName"    => new SOAP_Value("BankShortName", "string", $result[$i]['shortname']),
						"CompanyName"    => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
						"OldPrice"    => new SOAP_Value("OldPrice", "string", $result[$i]['oldprice']),
						"BlockedValue"    => new SOAP_Value("BlockedValue", "string", $result[$i]['blockedvalue']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['ordernumber']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"FromTypeID"    => new SOAP_Value("FromTypeID", "string", $result[$i]['fromtypeid']),
						"IsUnBlocked"    => new SOAP_Value("IsUnBlocked", "string", $result[$i]['isunblocked']),
						"BranchID"    => new SOAP_Value("BranchID", "string", $result[$i]['branchid']),
						"AccountNoContra"    => new SOAP_Value("AccountNoContra", "string", $result[$i]['accountnocontra']),
						"CompanyNameContra"    => new SOAP_Value("CompanyNameContra", "string", $result[$i]['companynamecontra']),
						)
				);
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

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
			$query = sprintf( "CALL sp_upcom_insertCancelOrder(%u, %u, %u, %u, '%s', '%s', '%u', '%s')",
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
							$this->_ERROR_CODE = 19050;
							break;

						case '-3':
							$this->_ERROR_CODE = 19051;
							break;

						case '-4':
							$this->_ERROR_CODE = 19052;
							break;

						case '-5':
							$this->_ERROR_CODE = 19053;
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
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

    function getOrderInfoToCall($OrderID) {
		$function_name = 'getOrderInfoToCall';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_upcom_getOrderInfoToCall(%u) ", $OrderID);
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
						"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['orderstylename']),
						"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['ordersidename']),
						"OldOrderID"    => new SOAP_Value("OldOrderID", "string", $result[$i]['oldorderid']),
						"OldPrice"    => new SOAP_Value("OldPrice", "string", $result[$i]['oldprice']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"IsNewEdit"    => new SOAP_Value("IsNewEdit", "string", $result[$i]['isnewedit']),
						"AccountNoContra"    => new SOAP_Value("AccountNoContra", "string", $result[$i]['accountnocontra']),
						"CompanyNameContra"    => new SOAP_Value("CompanyNameContra", "string", $result[$i]['companynamecontra']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	function updateTFlag($OrderID, $TFlag, $UpdatedBy){
		$function_name = 'updateTFlag';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($TFlag) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 19065;

			if ( !required($TFlag) )
				$this->_ERROR_CODE = 19066;

		} else {
			$query = sprintf( "CALL sp_upcom_updateTFlag( %u, '%s', '%s' )", $OrderID, $TFlag, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function stockDetailWithoutConfirmList($TradingDate, $TFlag){
		$function_name = 'stockDetailWithoutConfirmList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_upcom_StockDetailWithoutConfirmList('%s', '%s')", $TradingDate, $TFlag);
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
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"TradingDate"    => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
						"StockExchangeID"    => new SOAP_Value("StockExchangeID", "string", $result[$i]['stockexchangeid']),
						"OrderSideID"    => new SOAP_Value("OrderSideID", "string", $result[$i]['ordersideid']),
						"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['orderid']),
						"TFlag"    => new SOAP_Value("TFlag", "string", $result[$i]['tflag']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function executeStockOfBuyingDealWithTFlag($ID, $UpdatedBy, $TFlag){
		$function_name = 'executeStockOfBuyingDealWithTFlag';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($TFlag) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 19055;

			if ( !required($TFlag) )
				$this->_ERROR_CODE = 19056;

		} else {
			$query = sprintf( "CALL sp_executeStockOfBuyingDealWithTFlag( %u, '%s', '%s' )", $ID, $UpdatedBy, $TFlag);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19057;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19058;
							break;

						case '-2':
							$this->_ERROR_CODE = 19059;
							break;

						case '-3':
							$this->_ERROR_CODE = 19060;
							break;

						case '-5':
							$this->_ERROR_CODE = 19062;
							break;

						case '-6':
							$this->_ERROR_CODE = 19063;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function executeStockOfSellingDealWithTFlag($ID, $UpdatedBy, $TFlag){
		$function_name = 'executeStockOfSellingDealWithTFlag';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ID) || !unsigned($ID) || !required($TFlag) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 19070;

			if ( !required($TFlag) )
				$this->_ERROR_CODE = 19071;

		} else {
			$query = sprintf( "CALL sp_executeStockOfSellingDealWithTFlag( %u, '%s', '%s' )", $ID, $UpdatedBy, $TFlag);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19072;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19073;
							break;

						case '-2':
							$this->_ERROR_CODE = 19074;
							break;

						case '-3':
							$this->_ERROR_CODE = 19075;
							break;

						case '-4':
							$this->_ERROR_CODE = 19076;
							break;

						case '-5':
							$this->_ERROR_CODE = 19077;
							break;

						case '-6':
							$this->_ERROR_CODE = 19078;
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
		Function: editPriceOfTransferBuyingOrder
	*/
	function editPriceOfTransferBuyingOrder($OrderID, $OrderPrice, $AccountNo, $UpdatedBy){
		$function_name = 'editPriceOfTransferBuyingOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !unsigned($OrderID) || !required($OrderPrice) ) {
			if ( !required($OrderID) || !unsigned($OrderID) )
				$this->_ERROR_CODE = 19083;

			if ( !required($OrderPrice) )
				$this->_ERROR_CODE = 19084;

		} else {
			$query = sprintf( "CALL sp_upcom_getInfoWhenEditPriceOfTransferBuyingOrder(%u, %u)", $OrderID, $OrderPrice);
			//varError,varNewOrderValue,varUnitCode,varBankID,varBankAccount,varBlockedValue as varOldOrderValue;
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
								$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $bank_rs['varoldordervalue'], $orderValue );
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
					$query = sprintf( " CALL sp_upcom_updateIsNewEditWhenIncrementBlocked(%u, '%s', %u, '%s' )", $OrderID, $suffix, $OrderPrice, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30467;
					}
				} else { // bank fail
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
				}
			} else { // AccountNo doesn't match with AccountID
				$result = $bank_rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case -1:
							$this->_ERROR_CODE = 19080;//database error
							break;
						case -2:
							$this->_ERROR_CODE = 19081;//not enough money to unlock
							break;
						case -3:
							$this->_ERROR_CODE = 19082;//account does not exist
							break;
						default:
							$this->_ERROR_CODE = $result;
					}
				}
			} // varError
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: editPriceOfSellingOrder
	*/
	function editPriceOfSellingOrder($OrderID, $NewOrderPrice, $UpdatedBy) {
		$function_name = 'editPriceOfSellingOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($NewOrderPrice)) {
			if ( !required($OrderID) )
				$this->_ERROR_CODE = 19085;

			if ( !required($NewOrderPrice))
				$this->_ERROR_CODE = 19086;

		} else {
			$query = sprintf( "CALL sp_upcom_EditPriceOfTransferSellingOrder(%u, %u, '%s')", $OrderID, $NewOrderPrice, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19087;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19088;
							break;

						case '-2':
							$this->_ERROR_CODE = 19089;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateFromEditingtoTransfer
	*/
	function updateFromEditingtoTransfer($OrderID, $UpdatedBy) {
		$function_name = 'updateFromEditingtoTransfer';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 19090;

		} else {
			$query = sprintf( "CALL sp_upcom_updateFromEditingtoTransfer(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19091;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19092;
							break;

						case '-2':
							$this->_ERROR_CODE = 19093;
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
		Function: updateFromTransferToEditing
	*/
	function updateFromTransferToEditing($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferToEditing';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 19095;

		} else {
			$query = sprintf( "CALL sp_upcom_updateFromTransferToEditing(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19096;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19097;
							break;

						case '-2':
							$this->_ERROR_CODE = 19098;
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
		Function: updateFromTransferingToTransferWithMatchedOrFailed
	*/
    function updateFromTransferingToTransferWithMatchedOrFailed($OrderID, $IsMatched, $UpdatedBy, $MatchedQuantity) {
		$function_name = 'updateFromTransferingToTransferWithMatchedOrFailed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) || !required($IsMatched) ) {
			if ( !required($OrderID) )
				$this->_ERROR_CODE = 19100;

			if ( !required($IsMatched) )
				$this->_ERROR_CODE = 19101;
		} else {

			$query = sprintf( "CALL sp_upcom_updateFromTransferingToTransferWithMatchedOrFailed(%u, '%s', '%s', %u )", $OrderID, $IsMatched, $UpdatedBy, $MatchedQuantity );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$this->_MDB2_WRITE->disconnect();

			if (empty( $rs)) {
				$this->_ERROR_CODE = 19102;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19103;
							break;

						case '-2':
							$this->_ERROR_CODE = 19104;
							break;

						case '-3':
							$this->_ERROR_CODE = 19105;
							break;

						default:
							$this->_ERROR_CODE = $result;
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
									$dab_rs = $dab->editBlockMoney($rs['varaccountno'], $oldOrderID, $newOrderID, $rs['varoldvalue'], $rs['varreblockedvalue'] );
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
							$this->_MDB2_WRITE->connect();
							$query = sprintf( " CALL sp_updateUnitCode(%u, '%s' )", $OrderID, $suffix);
							$rs = $this->_MDB2_WRITE->extended->getRow($query);

							if (empty( $rs)){
								$this->_ERROR_CODE = 30456;
							}
						}
					} else { // bank fail
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
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateFromTransferedToTransfering
	*/
	function updateFromTransferedToTransfering($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferedToTransfering';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 19110;

		} else {
			$query = sprintf( "CALL sp_upcom_updateFromTransferedToTransfering(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19111;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19112;
							break;

						case '-2':
							$this->_ERROR_CODE = 19113;
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
		Function: updateFromTransferingToTransfered
	*/
	function updateFromTransferingToTransfered($OrderID, $UpdatedBy) {
		$function_name = 'updateFromTransferingToTransfered';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($OrderID) ) {
			$this->_ERROR_CODE = 19115;

		} else {
			$query = sprintf( "CALL sp_upcom_updateFromTransferingToTransfered(%u, '%s' )", $OrderID, $UpdatedBy );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)) {
				$this->_ERROR_CODE = 19116;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 19117;
							break;

						case '-2':
							$this->_ERROR_CODE = 19118;
							break;

						default:
							$this->_ERROR_CODE = $result;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
  function insertCoBuyOrder($CoAccountNo, $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra){
    $function_name = 'insertCoBuyOrder';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $log[] = sprintf('insertCoBuyOrder - CoAccountNo:%s;AccountNo:%s;StockID:%s;OrderQuantity:%s;OrderPrice:%s;Session:%s;FromTypeID:%s;Note:%s;OrderDate:%s;IsAssigner:%s;IsGotPaper:%s;CreatedBy:%s;AccountNoContra:%s;CompanyNameContra:%s;ExecutedTime:%s', $CoAccountNo, $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra, date('Y-m-d h:i:s'));

    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $log[] = sprintf('authenUser: ERROR_CODE: %s', $this->_ERROR_CODE);
      write_my_log_path("insertCoBuyOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }
    $log[] = sprintf('authenUser: ERROR_CODE: %s', $this->_ERROR_CODE);

    // checking Acount is active / not
    if (!checkAccountIsActive($AccountNo) || !checkAccountIsActive($CoAccountNo)) {
      $this->_ERROR_CODE = 30275;
      $log[] = sprintf('checkAccountIsActive: ERROR_CODE: %s; AccountNo:%s,%s;CoAccountNo: %s,%s', $this->_ERROR_CODE, $AccountNo, (checkAccountIsActive($AccountNo)? 'TRUE' : 'FALSE'), $CoAccountNo, (checkAccountIsActive($CoAccountNo)? 'TRUE' : 'FALSE'));
      write_my_log_path("insertCoBuyOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
      return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
    }
    $log[] = sprintf('checkAccountIsActive: ERROR_CODE: %s; AccountNo:%s,%s;CoAccountNo: %s,%s', $this->_ERROR_CODE, $AccountNo, (checkAccountIsActive($AccountNo)? 'TRUE' : 'FALSE'), $CoAccountNo, (checkAccountIsActive($CoAccountNo)? 'TRUE' : 'FALSE'));

    if (!required($CoAccountNo) || !required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
      || !unsigned($OrderQuantity) || !unsigned($StockID) ) {

      if (!required($CoAccountNo) || !required($AccountNo))
        $this->_ERROR_CODE = 30004;

      if (!required($OrderDate) )
        $this->_ERROR_CODE = 30005;

      if (!required($StockID) || !unsigned($StockID))
        $this->_ERROR_CODE = 30006;

      if (!required($OrderQuantity) || !unsigned($OrderQuantity))
        $this->_ERROR_CODE = 30007;

      if (!required($Session))
        $this->_ERROR_CODE = 30008;

      if (!required($OrderPrice) )
        $this->_ERROR_CODE = 30009;

      $log[] = sprintf('check require: ERROR_CODE: %s', $this->_ERROR_CODE);
    } else {
      $vip   = checkVIPAccount($AccountNo);// 1: exist 0: not exist
      $vipCo = checkVIPAccount($CoAccountNo);// 1: exist 0: not exist

      if ( ($vip == 1 || $vipCo == 1) && $FromTypeID == 5) {// web
        $this->_ERROR_CODE = 30602;
        $log[] = sprintf('Vip on web: Fail; AccountNo: %s;CoAccountNo: %s', (($vip==0)?'not vip':'vip'), (($vipCo==0)?'not vip':'vip'));
        write_my_log_path("insertCoBuyOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }

      if ((strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false || strpos(EOT_PROHIBITION_ACCOUNT, $CoAccountNo) !== false) && $FromTypeID == 5) {
        $this->_ERROR_CODE = 30602;
        $log[] = sprintf('check EOT_PROHIBITION_ACCOUNT: ERROR_CODE: %s;AccountNo:%s,%s;CoAccountNo:%s,%s', $this->_ERROR_CODE, $AccountNo, (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo)), $CoAccountNo, (strpos(EOT_PROHIBITION_ACCOUNT, $CoAccountNo)));
        write_my_log_path("insertCoBuyOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }

      if ( !checkStockPrice( $StockID, $OrderPrice, $OrderDate ) )
        $this->_ERROR_CODE = 30011;

      $log[] = sprintf('checkStockPrice: ERROR_CODE: %s', $this->_ERROR_CODE);

      $buyingOrderID  = '';
      $sellingOrderID = '';
      try{
        if ( $this->_ERROR_CODE == 0 ) {
          // -------------------------------------------------------------------------------------- //
          // Insert buy order for $CoAccountNo
          // -------------------------------------------------------------------------------------- //
          $query = sprintf( "CALL sp_upcom_insertBuyingOrder('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
                  $CoAccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra);
          $log[] = sprintf('%s', $query);
          $rs = $this->_MDB2_WRITE->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 30015;
            $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 19001;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 19002;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 19003;
                  break;

                case '-4':
                  $this->_ERROR_CODE = 19004;
                  break;

                case '-5':
                  $this->_ERROR_CODE = 19005;
                  break;

                default:
                  $this->_ERROR_CODE = $result;
              }
              $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
            } else {
              $isQuotaAccount = CheckIsQuotaAccount($CoAccountNo);

              $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              $log[] = sprintf('BuyingOrderID: %s', $result);
              $buyingOrderID = $result;

              //block money in bank
              $query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $CoAccountNo);
              $log[] = sprintf('%s', $query);
              $mdb = initWriteDB();
              $bank_rs = $mdb->extended->getAll($query);
              $log[] = sprintf('PAGODA_ACCOUNT: %s', (strpos(PAGODA_ACCOUNT, $CoAccountNo) === false)? 'FALSE' : 'TRUE');
              $log[] = sprintf('VIP_ACCOUNT: %s', ($vip == 0)? 'FALSE' : 'TRUE');
              if ( strpos (PAGODA_ACCOUNT, $CoAccountNo) === false && $vipCo == 0) {
                $dab_rs = 999;
                if($isQuotaAccount != 0){
                  $BankID = NHHM;
                  $mdb = initWriteDB();
                  $query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $CoAccountNo, NHHM, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                  $off_rs = $mdb->extended->getRow($query);
                  $mdb->disconnect();
                  $dab_rs = $off_rs['varerror'];

                  $log[] = sprintf('block_money: bankid:NHHM;result:%s', $dab_rs);
                } else {
                  for($i=0; $i<count($bank_rs); $i++) {
                    switch ($bank_rs[$i]['bankid']) {
                      case DAB_ID:
                        $dab = &new CDAB();
                        $dab_rs = $dab->blockMoney($bank_rs[$i]['bankaccount'], $bank_rs[$i]['cardno'], $CoAccountNo, $result, $rs['varordervalue'], $OrderDate);

                        $log[] = sprintf('block_money: bankid:DAB_ID;result:%s', $dab_rs);
                        break;

                      case VCB_ID:
                        $dab = &new CVCB();
                        $OrderID = $result . $rs['varunitcode'];
                        if (!killStupidBank()) // VCB is stupid
                          $dab_rs = $dab->blockMoney( $CoAccountNo, $OrderID, $rs['varordervalue']);
                        else
                          $dab_rs = 30999;

                        $log[] = sprintf('block_money: bankid:VCB_ID;result:%s', $dab_rs);
                        break;

                      case ANZ_ID:
                        $OrderID = $result;
                        $query = sprintf( "CALL sp_anz_money_request_lock( %u, '%s', '%s', '%s' )", $OrderID, $CoAccountNo, $rs['varordervalue'], $CreatedBy);
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
                        $log[] = sprintf('block_money: bankid:ANZ_ID;result:%s', $dab_rs);
                        // added by Quang, 20100407 ------------------------------------
                        break;
                      case OFFLINE:
                        //inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inOrderDate date,inCreatedBy
                        $mdb = initWriteDB();
                        $query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $CoAccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                        $off_rs = $mdb->extended->getRow($query);
                        $mdb->disconnect();
                        $dab_rs = $off_rs['varerror'];

                        $log[] = sprintf('block_money: bankid:OFFLINE;result:%s', $dab_rs);
                        break;
                      // end add -----------------------------------------------------
                    }

                    if ($dab_rs == 0){
                      $BankID = $bank_rs[$i]['bankid'];
                      break;
                    }
                  }
                }
              } else {
                $dab_rs = 0;
              }

              if ($dab_rs == 0) { //Successfully
                $log[] = sprintf('successded_block_money');
                $mdb = initWriteDB();
                if($Session <= 3){
                  $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToApproved(%u, %u) ", $result, $BankID );
                } else {
                  $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToTransfered(%u, %u) ", $result, $BankID );
                }
                $log[] = sprintf('%s', $query);
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              }
              else { // bank fail
                $log[] = sprintf('failed_block_money');
                switch ($dab_rs){
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);

                $mdb = initWriteDB();
                $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToDenied(%u, '%s') ", $result, $dab_rs );
                $log[] = sprintf('%s', $query);
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              }
            }
          }
          // -------------------------------------------------------------------------------------- //
          // End Insert buy order for $CoAccountNo
          // -------------------------------------------------------------------------------------- //
        }

        if($this->_ERROR_CODE == 0){
          // -------------------------------------------------------------------------------------- //
          // Insert sell order for $AccountNo
          // -------------------------------------------------------------------------------------- //
          $query = sprintf( "CALL sp_upcom_insertSellingOrder('%s', %u, %u, %u, %u, '%u', '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
                  $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra );
          $log[] = sprintf('%s', $query);
          $mdb = initWriteDB();
          $rs = $mdb->extended->getRow($query);
          $mdb->disconnect();

          if (empty( $rs)) {
            $this->_ERROR_CODE = 30060;
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 19010;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 19011;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 19012;
                  break;

                case '-4':
                  $this->_ERROR_CODE = 19013;
                  break;

                case '-5':
                  $this->_ERROR_CODE = 19014;
                  break;

                case '-6':
                  $this->_ERROR_CODE = 19015;
                  break;

                default:
                  $this->_ERROR_CODE = $result;
              }
            } else {
              $sellingOrderID = $result;
            }
          }
          $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
          $log[] = sprintf('SellingOrderID: %s', $sellingOrderID);
        }
        $this->items[0] = new SOAP_Value(
            'item',
            $struct,
            array(
              "BuyingOrderID"    => new SOAP_Value( "BuyingOrderID", "string", $buyingOrderID ),
              "SellingOrderID"   => new SOAP_Value( "SellingOrderID", "string", $sellingOrderID ),
            )
        );
      } catch (Exception $e){
        $log[] = sprintf('Exception: %s', $e->getMessage());
        $this->_ERROR_CODE = 30060;
      }
    }
    write_my_log_path("insertCoBuyOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function insertCoSellOrder($CoAccountNo, $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra ){
    $function_name = 'insertCoSellOrder';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    $log[] = sprintf('insertCoSellOrder - CoAccountNo:%s;AccountNo:%s;StockID:%s;OrderQuantity:%s;OrderPrice:%s;Session:%s;FromTypeID:%s;Note:%s;OrderDate:%s;IsAssigner:%s;IsGotPaper:%s;CreatedBy:%s;AccountNoContra:%s;CompanyNameContra:%s;ExecutedTime:%s', $CoAccountNo, $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra, date('Y-m-d h:i:s'));

    if ( authenUser(func_get_args(), $this, $function_name) > 0 ){
      $log[] = sprintf('authenUser: ERROR_CODE: %s', $this->_ERROR_CODE);
      write_my_log_path("insertCoSellOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    $log[] = sprintf('authenUser: ERROR_CODE: %s', $this->_ERROR_CODE);

    // checking account is active / not
    if (!checkAccountIsActive($AccountNo) || !checkAccountIsActive($CoAccountNo)) {
      $this->_ERROR_CODE = 30275;
      $log[] = sprintf('checkAccountIsActive: ERROR_CODE: %s; AccountNo:%s,%s;CoAccountNo: %s,%s', $this->_ERROR_CODE, $AccountNo, (checkAccountIsActive($AccountNo)? 'TRUE' : 'FALSE'), $CoAccountNo, (checkAccountIsActive($CoAccountNo)? 'TRUE' : 'FALSE'));
      write_my_log_path("insertCoSellOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
      return returnXML(func_get_args(), $this->class_name, $function_name, 30275, $this->items, $this );
    }

    $log[] = sprintf('checkAccountIsActive: ERROR_CODE: %s; AccountNo:%s,%s;CoAccountNo: %s,%s', $this->_ERROR_CODE, $AccountNo, (checkAccountIsActive($AccountNo)? 'TRUE' : 'FALSE'), $CoAccountNo, (checkAccountIsActive($CoAccountNo)? 'TRUE' : 'FALSE'));

    if (!required($CoAccountNo) || !required($AccountNo) || !required($OrderDate) || !required($StockID) || !required($OrderQuantity) || !required($OrderPrice) || !required($Session)
      || !unsigned($OrderQuantity) || !unsigned($StockID) ) {

      if (!required($AccountNo) || !required($CoAccountNo))
        $this->_ERROR_CODE = 30051;

      if (!required($OrderDate) )
        $this->_ERROR_CODE = 30052;

      if (!required($StockID) || !unsigned($StockID))
        $this->_ERROR_CODE = 30053;

      if (!required($OrderQuantity) || !unsigned($OrderQuantity))
        $this->_ERROR_CODE = 30054;

      if (!required($Session))
        $this->_ERROR_CODE = 30055;

      if (!required($OrderPrice) )
        $this->_ERROR_CODE = 30056;

      $log[] = sprintf('check require: ERROR_CODE: %s', $this->_ERROR_CODE);
    } else {
      $vip   = checkVIPAccount($AccountNo);// 1: exist 0: not exist
      $vipCo = checkVIPAccount($CoAccountNo);// 1: exist 0: not exist

      if ( ($vip == 1 || $vipCo == 1) && $FromTypeID == 5) {// web
        $this->_ERROR_CODE = 30602;
        $log[] = sprintf('Vip on web: Fail; AccountNo: %s;CoAccountNo: %s', (($vip==0)?'not vip':'vip'), (($vipCo==0)?'not vip':'vip'));
        write_my_log_path("insertCoSellOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }

      if (((strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo) !== false) || (strpos(EOT_PROHIBITION_ACCOUNT, $CoAccountNo) !== false)) && $FromTypeID == 5) {
        $this->_ERROR_CODE = 30602;
        $log[] = sprintf('check EOT_PROHIBITION_ACCOUNT: ERROR_CODE: %s;AccountNo:%s,%s;CoAccountNo:%s,%s', $this->_ERROR_CODE, $AccountNo, (strpos(EOT_PROHIBITION_ACCOUNT, $AccountNo)), $CoAccountNo, (strpos(EOT_PROHIBITION_ACCOUNT, $CoAccountNo)));
        write_my_log_path("insertCoSellOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
        return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      }

      if ( !checkStockPrice( $StockID, $OrderPrice, $OrderDate ) )
        $this->_ERROR_CODE = 30057;

      $log[] = sprintf('checkStockPrice: ERROR_CODE: %s', $this->_ERROR_CODE);

      $sellingOrderID = '';
      $buyingOrderID  = '';
      try{
        if ( $this->_ERROR_CODE == 0 ) {
          // -------------------------------------------------------------------------------------- //
          // Insert sell order for $CoAccountNo
          // -------------------------------------------------------------------------------------- //
          $query = sprintf( "CALL sp_upcom_insertSellingOrder('%s', %u, %u, %u, %u, '%u', '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
                  $CoAccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra );
          $log[] = sprintf('%s', $query);
          $mdb = initWriteDB();
          $rs = $mdb->extended->getRow($query);
          $mdb->disconnect();

          if (empty( $rs)) {
            $this->_ERROR_CODE = 30060;
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 19010;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 19011;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 19012;
                  break;

                case '-4':
                  $this->_ERROR_CODE = 19013;
                  break;

                case '-5':
                  $this->_ERROR_CODE = 19014;
                  break;

                case '-6':
                  $this->_ERROR_CODE = 19015;
                  break;

                default:
                  $this->_ERROR_CODE = $result;
              }
            } else {
              $sellingOrderID = $result;
            }
          }
          $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
          $log[] = sprintf('SellingOrderID: %s', $sellingOrderID);
        }

        if($this->_ERROR_CODE == 0){
          // -------------------------------------------------------------------------------------- //
          // Insert buy order for $AccountNo
          // -------------------------------------------------------------------------------------- //
          $query = sprintf( "CALL sp_upcom_insertBuyingOrder('%s', %u, %u, %u, %u, %u, '%s', '%s', '%u', '%u', '%s', '%s', '%s')",
                  $AccountNo, $StockID, $OrderQuantity, $OrderPrice, $Session, $FromTypeID, $Note, $OrderDate, $IsAssigner, $IsGotPaper, $CreatedBy, $AccountNoContra, $CompanyNameContra);
          $log[] = sprintf('%s', $query);
          $rs = $this->_MDB2_WRITE->extended->getRow($query);

          if (empty( $rs)) {
            $this->_ERROR_CODE = 30015;
            $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
          } else {
            $result = $rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 19001;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 19002;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 19003;
                  break;

                case '-4':
                  $this->_ERROR_CODE = 19004;
                  break;

                case '-5':
                  $this->_ERROR_CODE = 19005;
                  break;

                default:
                  $this->_ERROR_CODE = $result;
              }
              $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
            } else {
              $isQuotaAccount = CheckIsQuotaAccount($AccountNo);

              $vip = checkVIPAccount($AccountNo);// 1: exist 0: not exist

              $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              $log[] = sprintf('BuyingOrderID: %s', $result);
              $buyingOrderID = $result;

              //block money in bank
              $query = sprintf( "SELECT * FROM vw_ListAccountBank_Detail WHERE AccountNo='%s' ORDER BY Priority ", $AccountNo);
              $log[] = sprintf('%s', $query);
              $mdb = initWriteDB();
              $bank_rs = $mdb->extended->getAll($query);
              $log[] = sprintf('PAGODA_ACCOUNT: %s', (strpos(PAGODA_ACCOUNT, $AccountNo) === false)? 'FALSE' : 'TRUE');
              $log[] = sprintf('VIP_ACCOUNT: %s', ($vip == 0)? 'FALSE' : 'TRUE');
              if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false && $vip == 0 ) {
                $dab_rs = 999;
                if($isQuotaAccount != 0){
                  $BankID = NHHM;
                  $mdb = initWriteDB();
                  $query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, NHHM, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                  $off_rs = $mdb->extended->getRow($query);
                  $mdb->disconnect();
                  $dab_rs = $off_rs['varerror'];

                  $log[] = sprintf('block_money: bankid:NHHM;result:%s', $dab_rs);
                } else {
                  for($i=0; $i<count($bank_rs); $i++) {
                    switch ($bank_rs[$i]['bankid']) {
                      case DAB_ID:
                        $dab = &new CDAB();
                        $dab_rs = $dab->blockMoney($bank_rs[$i]['bankaccount'], $bank_rs[$i]['cardno'], $AccountNo, $result, $rs['varordervalue'], $OrderDate);

                        $log[] = sprintf('block_money: bankid:DAB_ID;result:%s', $dab_rs);
                        break;

                      case VCB_ID:
                        $dab = &new CVCB();
                        $OrderID = $result . $rs['varunitcode'];
                        if (!killStupidBank()) // VCB is stupid
                          $dab_rs = $dab->blockMoney( $AccountNo, $OrderID, $rs['varordervalue']);
                        else
                          $dab_rs = 30999;

                        $log[] = sprintf('block_money: bankid:VCB_ID;result:%s', $dab_rs);
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
                        $log[] = sprintf('block_money: bankid:ANZ_ID;result:%s', $dab_rs);
                      // added by Quang, 20100407 ------------------------------------
                        break;
                      case OFFLINE:
                        //inAccountNo varchar(20),inBankID int,inOrderID bigint,inOrderAmount double,inOrderDate date,inCreatedBy
                        $mdb = initWriteDB();
                        $query = sprintf( "CALL sp_VirtualBank_Lock('%s', %u,  %u, %f, '%s', '%s')", $AccountNo, OFFLINE, $result, $rs['varordervalue'], $OrderDate, $CreatedBy);
                        $off_rs = $mdb->extended->getRow($query);
                        $mdb->disconnect();
                        $dab_rs = $off_rs['varerror'];

                        $log[] = sprintf('block_money: bankid:OFFLINE;result:%s', $dab_rs);
                        break;
                      // end add -----------------------------------------------------
                    }

                    if ($dab_rs == 0){
                      $BankID = $bank_rs[$i]['bankid'];
                      break;
                    }
                  }
                }
              } else {
                $dab_rs = 0;
              }

              if ($dab_rs == 0) { //Successfully
                $log[] = sprintf('successded_block_money');
                $mdb = initWriteDB();
                if($Session <= 3){
                  $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToApproved(%u, %u) ", $result, $BankID );
                } else {
                  $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToTransfered(%u, %u) ", $result, $BankID );
                }
                $log[] = sprintf('%s', $query);
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              }
              else { // bank fail
                $log[] = sprintf('failed_block_money');
                switch ($dab_rs){
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);

                $mdb = initWriteDB();
                $query = sprintf( "CALL sp_updateBuyingOrderFromPendingToDenied(%u, '%s') ", $result, $dab_rs );
                $log[] = sprintf('%s', $query);
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
                $log[] = sprintf('ERROR_CODE: %s', $this->_ERROR_CODE);
              }
            }
          }
          // -------------------------------------------------------------------------------------- //
          // End Insert buy order for $AccountNo
          // -------------------------------------------------------------------------------------- //
        }
        $this->items[0] = new SOAP_Value(
            'item',
            $struct,
            array(
              "BuyingOrderID"    => new SOAP_Value( "BuyingOrderID", "string", $buyingOrderID ),
              "SellingOrderID"   => new SOAP_Value( "SellingOrderID", "string", $sellingOrderID ),
            )
        );
      } catch(Exception $e) {
        $log[] = sprintf('Exception: %s', $e->getMessage());
        $this->_ERROR_CODE = 30060;
      }
    }
    write_my_log_path("insertCoSellOrder", implode("\n --> ",$log), '/home/vhosts/eSMS/htdocs/logs/otc/');
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*function initTradingBoard() {
        //initialize MDB2
        $mdb2 = &MDB2::factory(DB_DNS_WRITE);
        $mdb2->loadModule('Extended');
        $mdb2->loadModule('Date');
        $mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
        $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
        return $mdb2;
}*/

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

function checkStockPrice($StockID, $StockPrice, $OrderDate) {
	$mdb = initDB();
	$query = sprintf( "SELECT f_upcom_checkCeilingAndFloor(%u, '%s', %f) AS Boolean", $StockID,  $OrderDate, $StockPrice);
	$result = $mdb->extended->getRow($query);

	if ($result['boolean'] > 0) {
		return true;
	} else {
		return false;
	}
}

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
function CheckIsQuotaAccount($AccountNo) {
  /*
  $MDB2 = initDB();
  $query = sprintf( "SELECT f_quota_QuotaAccount_IsExisted('%s') AS Boolean", $AccountNo);
  $result = $MDB2->extended->getRow($query);
  return $result['boolean'];
  */
  return 0;
}
function checkVIPAccount($AccountNo) {
  $MDB2 = initDB();
  $query = sprintf( "SELECT f_VipList_IsExisted('%s') AS Boolean", $AccountNo);
  $result = $MDB2->extended->getRow($query);
  return $result['boolean'];
}
?>
