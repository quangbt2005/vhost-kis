<?php
/**
	Author: Diep Le Chi
	Created date: 12/04/2007
**/
require_once('../includes.php');

class CAdvancePaper extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor
	*/

	function CAdvancePaper($check_ip) {
		//initialize _MDB2
		$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		//$this->_TIME_ZONE = get_timezon();
		$this->items = array();

		$this->class_name = get_class($this);
		$arr = array(
					'listStockSold' => array(
										'input' => array('AccountID','AdvanceDate','TimeZone'),
										'output' => array( 'ID', 'AccountID', 'StockID', 'StockSymbol', 'Quantity', 'Price', 'TradingDate', 'Total', 'Amount', 'MoneyLeft', 'NumAdvanceDay')
										),
					'listStockSoldNotAdvance' => array(
										'input' => array( 'AccountID','AdvancePaperID','AdvanceDate','TimeZone', 'TDate', 'OrderBankID', 'BankID'),
										'output' => array( 'ID', 'AccountID', 'BankAccount', 'StockID', 'StockSymbol', 'Quantity', 'Price', 'TradingDate', 'Total', 'Amount', 'MoneyLeft', 'NumAdvanceDay','OrderFee','T3Date')
										),
					'GetListStockDetailForAdvPaper_DAB' => array(
										'input' => array( 'TradingDate', 'AccountNo'),
										'output' => array( 'ID', 'AccountID', 'BankAccount', 'StockID', 'StockSymbol', 'OrderQuantity', 'MatchedQuantity', 'Price', 'Total', 'MoneyLeft', 'NumAdvanceDay','OrderFee','T3Date','IsTDay', 'TradingDate','MaxAdvanceFee')
										),
					'listAdvancePaper' => array(
										'input' => array( 'Where','TimeZone'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'FullName', 'Amount', 'ContractNo', 'AdvanceDate', 'AdvanceFee', 'Note', 'IsConfirmed', 'IsConfirmed1', 'BankID', 'BankName', 'IsTradingTime', 'TDate', 'OrderBankID', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate','IsEPSFee')
										),
					'getAdvancePaper' => array(
										'input' => array( 'AdvanceID','TimeZone'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'Amount', 'ContractNo', 'AdvanceDate', 'AdvanceFee', 'Note', 'IsConfirmed', 'IsConfirmed1', 'BankID', 'BankName', 'Rate', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'getAdvancePaperDetail' => array(
										'input' => array( 'AdvanceID','TimeZone'),
										'output' => array( 'ID', 'StockID', 'StockSymbol', 'Amount', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'getMaxAdvanceMoney' => array(
										'input' => array( 'BankID', 'AccountID', 'AdvanceDate', 'AdvancePaperID','OrderBankID','TDay'),
										'output' => array( 'Amount','AdvanceFee')
										),
					'getMaxAdvanceMoney_DAB' => array(
										'input' => array(),
										'output' => array( 'Amount')
										),
					'checkTrading4Advance' => array(
										'input' => array('TradingDate'),
										'output' => array( 'IsTrading')
										),
					'addAdvancePager' => array(
										'input' => array( 'AccountID', 'Amount', 'AdvanceDate', 'AdvanceFee', 'CardNo', 'Note', 'CreatedBy', 'BankID', 'IsTradingTime','OrderBankID', 'TDay'),
										'output' => array('ID','ContractNo')
										),
					'addAdvancePagerDetail' => array(
										'input' => array( 'AdvancePaperID', 'OrderID', 'Amount', 'CreatedBy', 'AccountNo', 'OrderAmount', 'OrderFee', 'T3Date', 'OrderBankID', 'BankAccount', 'IsTrading', 'BankID', 'FullName'),
										'output' => array('ID')
										),
					'updateAdvancePager' => array(
										'input' => array( 'AdvancePaperID', 'Amount', 'AdvanceDate', 'AdvanceFee', 'Note', 'UpdatedBy', 'BankID', 'OrderBankID', 'TDay'),
										'output' => array()
										),
					'deleteAdvancePager' => array(
										'input' => array('AdvancePaperID','UpdatedBy'),
										'output' => array()
										),
					/*'getSoldMortageMoney' => array(
										'input' => array( 'AccountID'),
										'output' => array( 'Amount')
										),*/
					'approveAdvance' => array(
										'input' => array('AdvancePaperID', 'UpdatedBy', 'ApproveDate','IsTradingTime','OrderBankID', 'BankID'),
										'output' => array('OrderID')
										),
					'addAdvancePaper_DAB' => array(
										'input' => array( 'AccountID', 'AccountNo', 'BankAccount', 'FullName', 'OrderAmount', 'OrderFee', 'Amount', 'AdvanceDate', 'OrderID', 'Note', 'T3Date', 'CreatedBy', 'NumDay', 'IsTDay'),
										'output' => array('ID')
										),
					'addAdvancePaperWithoutLimitation_DAB' => array(
										'input' => array( 'AccountID', 'AccountNo', 'BankAccount', 'FullName', 'OrderAmount', 'OrderFee', 'Amount', 'AdvanceDate', 'OrderID', 'Note', 'T3Date', 'CreatedBy', 'NumDay', 'IsTDay'),
										'output' => array('ID')
										),
					'listBankAdvance'	=>	array(
										'input' => array(),
										'output' => array('BankID', 'BankName')
										),
					'getAdvanceFeeForAmount'	=>	array(
										'input' => array('Amount', 'BankID'),
										'output' => array('Fee')
										),
					'AdvancePaper_Report1'	=>	array(
										'input' => array('AdvancePaperID'),
										'output' => array('TradingDate', 'OrderSellingAmount', 'APToDate', 'NumDay', 'AccountNo', 'FullName', 'CardNo', 'CardNoIssuer', 'CardNoDate', 'ContactAddress', 'APAmount', 'AdvanceDate', 'FullOrderSellingAmount', 'MobilePhone', 'HomePhone')
										),
					'AdvancePaper_Report2'	=>	array(
										'input' => array('AdvancePaperID'),
										'output' => array('Symbol', 'MatchedQuantity', 'MatchedPrice', 'AccountNo', 'FullName', 'ContactAddress', 'DealSellingAmount', 'FullDealSellingAmount', 'DealAgencyAmount', 'MatchedAgencyFee')
										),
					'ReportAdvancePaper_FollowUp'	=>	array(
										'input' => array('TradingDate', 'advBankID'),
										'output' => array('AccountNo', 'BankAccount', 'FullName', 'TradingDate', 'MatchedQuantity', 'Symbol', 'MatchedPrice', 'NumDay', 'T3Date', 'Amount', 'AdvanceFee', 'ContractNo', 'ShortName', 'CardNo' )
										),
					'ReportAdvancePaper_AccountPeriod'	=>	array(
										'input' => array('AccountNo', 'AdvanceDateFrom', 'AdvanceDateTo'),
										'output' => array('AccountNo', 'FullName', 'TradingDate', 'MatchedQuantity', 'Symbol', 'MatchedPrice', 'NumDay', 'T3Date', 'Amount', 'AdvanceFee', 'ContractNo', 'AdvanceDate')
										),
					'ReportAdvancePaper_Accounting'	=>	array(
										'input' => array('T3DateFrom', 'T3DateTo', 'advBankID'),
										'output' => array('AccountNo', 'BankAccount', 'FullName', 'AdvanceAmount', 'AdvanceFee', 'ShortName', 'T3Date')
										),
					'ReportAdvancePaper_AdvanceDate'	=>	array(
										'input' => array('AdvanceDateFrom', 'AdvanceDateTo', 'advBankID'),
										'output' => array('AccountNo', 'BankAccount', 'FullName', 'AdvanceAmount', 'AdvanceFee', 'ShortName', 'T3Date', 'NumDay')
										),
					'listPayment' => array(
										'input' => array('Where', 'TimeZone'),
										'output' => array('PaymentID', 'PaymentDate', 'PaymentMoney', 'AccountID', 'AccountNo', 'InvestorName', 'MortageContractNo', 'BankName', 'MortageContractValue', 'MortageReleaseDate', 'MortageContractStatus','PaymentContractType','IsConfirmed','IsConfirmed1','Note','CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listPaymentStockWithoutMoney' => array(
										'input' => array('Where', 'TimeZone'),
										'output' => array('MortageContractID', 'MortageContractNo', 'PaymentID', 'Payment', 'MortageContractDetailID', 'PaymentContractDetailID', 'TradingDate', 'PaymentDetailMoney', 'PaymentQuantity', 'StockID', 'StockSymbol', 'AccountID', 'AccountNo', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listPaymentDetail' => array(
										'input' => array('PaymentContractDetailID', 'TimeZone'),
										'output' => array( 'ID', 'PaymentContractID', 'MortageContractDetailID', 'PaymentTypeID', 'PaymentTypeName', 'PaymentDetailRaiseBlockedDate','PaymentDetailStockSymbol', 'PaymentDetailQuantity', 'PaymentDetailAmountMoney', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate')
										),
					'listMortageContractUnpaid' => array(
										'input' => array('TimeZone','PaymentID'),
										'output' => array( 'ID', 'AccountID', 'AccountNo', 'InvestorName', 'ContractNo','BankID', 'BankName', 'IsAssigner', 'ContractValue', 'ContractValueLeft', 'PaymentValueNotConfirm', 'PaymentValueConfirm', 'SoldMortage', 'ContractDate', 'ReleaseDate', 'BlockedDate')
										),
					'listMortageContractUnpaidWithFilter' => array(
										'input' => array( 'Where', 'TimeZone','PaymentID'),
										'output' => array('ID', 'AccountID', 'AccountNo', 'InvestorName', 'ContractNo','BankID', 'BankName', 'IsAssigner', 'ContractValue', 'ContractValueLeft', 'PaymentValueNotConfirm', 'PaymentValueConfirm', 'SoldMortage', 'ContractDate', 'ReleaseDate', 'BlockedDate')
										),
					'listMortageContractDetail' => array(
										'input' => array( 'MortageContractID'),
										'output' => array( 'MortageContractID', 'MortageContractDetailID', 'PaymentContractDetailID', 'PaymentTypeID', 'PaymentTypeName', 'StockID', 'Symbol', 'Quantity', 'Amount', 'QuantityOfPayment', 'AmountOfPayment', 'QuantitySoldMortage', 'AmountSoldMortage')
										),
					'listSoldMortage'	=>	array(
										'input' => array( 'AccountID', 'TimeZone'),
										'output' => array('AccountID', 'StockID', 'Symbol', 'Quantity', 'TotalMoney')
										),
					'addPaymentForSoldMortage'	=>	array(
										'input' => array( 'PaymentContractID', 'AccountID', 'Today', 'CreatedBy'),
										'output' => array()
										),
					'addPayment' => array(
										'input' => array( 'MortageContractID', 'PaymentDate', 'TotalMoney', 'Note', 'CreatedBy', 'PaymentContractDetailID'),
										'output' => array('ID')
										),
					'addPaymentMoney' => array(
										'input' => array( 'MortageContractID', 'PaymentDate', 'TotalMoney', 'Note', 'CreatedBy'),
										'output' => array('ID')
										),
					'addPaymentDetail' => array(
										'input' => array('PaymentContractID', 'MortageContractDetailID', 'RaiseBlockedDate', 'Quantity', 'AmountMoney', 'CreatedBy', 'Today'),
										'output' => array('ID')
										),
					'addPaymentMoneyDetail' => array(
										'input' => array('PaymentContractID', 'MortageContractDetailID', 'AmountMoney', 'CreatedBy', 'Today'),
										'output' => array('ID')
										),
					/*'updatePayment' => array(
										'input' => array('PaymentID', 'PaymentDate', 'TotalMoney', 'UpdatedBy', 'PaymentContractDetailID'),
										'output' => array('ID')
										),	*/
					'checkMoneyForPayment' => array(
										'input' => array('AccountID','Money','Today'),
										'output' => array()
										),
					'deletePayment' => array(
										'input' => array('PaymentContractID','UpdatedBy'),
										'output' => array()
										),
					'approvePayment' => array(
										'input' => array('PaymentContractID','UpdatedBy','ApproveDate'),
										'output' => array()
										),
					'approvePaymentMoney' => array(
										'input' => array('PaymentContractID','UpdatedBy','ApproveDate'),
										'output' => array()
										),
					'UpdateAdvancePaper_IsEPSFee' => array(
										'input' => array( 'AccountID', 'ContractNo', 'UpdatedBy', 'Today'),
										'output' => array( )
										),
					'ListAdvancePaper_FromDAB' => array(
										'input' => array( 'ContractStatus', 'FromDate', 'ToDate'),
										'output' => array( 'ListContract' )
										),
					'CancelSellAdvance_DAB' => array(
										'input' => array( 'DABBankAccount', 'AccountNo', 'ContractNo', 'CancelDate'),
										'output' => array()
										),
					'getAdvanceFee' => array(
										'input' => array( 'BankID'),
										'output' => array('AdvanceFee')
										),
					'ANZ_money_import' => array(
										'input' => array( 'AccountNo', 'Money', 'UpdatedBy'),
										'output' => array()
										),
					'updateConfirmable' => array(
										'input' => array( 'AdvancePaperID'),
										'output' => array()
										),
					'getAvailableBalanceAdvance' => array(
										'input' => array(),
										'output' => array( 'Room')
										),
          'getAdvanceFee_getInfo' => array(
                    'input' => array('BankID'),
                    'output' => array('Rate', 'RateForBank', 'RateForEPS', 'MinAdvCommission ', 'MinAmountAdvance')
                    ),
          'getAdvanceAmountforBankAndDate' => array(
                    'input' => array('AdvanceDate','TDate','BankID'),
                    'output' => array('AdvanceAmount', 'Numday', 'Val')
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

	/* ----------------------------- AdvancePager Function --------------------------------- */
	function checkTrading4Advance($TradingDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'checkTrading4Advance';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf( "select f_CheckExecuteTransaction('%s') as IsTrading",$TradingDate);
			$result = $this->_MDB2->extended->getAll($query);
			//$num_row = count($result);
			// $result[0]['istrading'] = 1 lam giao dich roi, 0: chua lam giao dich
					$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'IsTrading'  => new SOAP_Value("IsTrading", "string", $result[0]['istrading'])									 						)
						);
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**Function getMaxAdvanceMoney : get max advance money for account
		Input :  'AccountID', 'AdvanceDate'
	 * OutPut 				: array
	 */
	 function getMaxAdvanceMoney($BankID, $AccountID, $AdvanceDate, $AdvancePaperID, $OrderBankID, $TDay) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getMaxAdvanceMoney';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

 			$query = sprintf( "call sp_getAdvanceMoney('%s','%s','%s','%s','%s','%s')",$TDay,$OrderBankID, $BankID, $AccountID,$AdvanceDate, $AdvancePaperID);
			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']) 										 						)
						);
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**Function getMaxAdvanceMoney_DAB : get max advance money for account
		Input :  'AccountID', 'AdvanceDate'
	 * OutPut 				: array
	 */
	 function getMaxAdvanceMoney_DAB() {
		try{
			$class_name = $this->class_name;
			$function_name = 'getMaxAdvanceMoney_DAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$dab = &new CDAB();
			$chkbankaccount = $dab->getBalanceAdvance();

			$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'Amount'  => new SOAP_Value("Amount", "string", $chkbankaccount)																	 						)
						);
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	/**
	 * Function listStockSold	: get list of AdvancePager that is not deleted
	 * Input 				: 'AccountID','AdvanceDate'
	 * OutPut 				: array
	 */
	function listStockSold($AccountID,$AdvanceDate,$timeZone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'ListStockSold';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf( "CALL sp_ListStockSold('%s','%s','%s')",$AccountID,$AdvanceDate,$timeZone);
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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['symbol']),
								'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'Total'  => new SOAP_Value("Total", "string", $result[$i]['total']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'MoneyLeft'  => new SOAP_Value("MoneyLeft", "string", $result[$i]['moneyleft']),
								'NumAdvanceDay'  => new SOAP_Value("NumAdvanceDay", "string", $result[$i]['numday'])
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
	 * Function listStockSoldNotAdvance	:
	 * Input 							: $AccountID$AdvanceDate
	 * OutPut 							: array
	 */
	function listStockSoldNotAdvance($AccountID,$AdvancePaperID,$AdvanceDate,$timeZone,$TDate, $OrderBankID, $BankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listStockSoldNotAdvance';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf( "CALL sp_ListStockSoldForAdvance('%s', '%s','%s','%s','%s','%s','%s')", $BankID, $OrderBankID, $TDate, $AccountID,$AdvancePaperID,$AdvanceDate,$timeZone);
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
								'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankcccount']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['symbol']),
								'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								'Price'  => new SOAP_Value("Price", "string", $result[$i]['price']),
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'Total'  => new SOAP_Value("Total", "string", $result[$i]['total']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'MoneyLeft'  => new SOAP_Value("MoneyLeft", "string", $result[$i]['moneyleft']),
								'NumAdvanceDay'  => new SOAP_Value("NumAdvanceDay", "string", $result[$i]['numday']),
								'OrderFee'  => new SOAP_Value("OrderFee", "string", $result[$i]['orderfee']),
								'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date'])
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
	 * Function listStockSoldNotAdvance	:
	 * Input 							: $AccountID$AdvanceDate
	 * OutPut 							: array
	 */
	function GetListStockDetailForAdvPaper_DAB($TradingDate,$AccountNo) {
		try{
			$class_name = $this->class_name;
			$function_name = 'GetListStockDetailForAdvPaper_DAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			//, $BankID :2,$OrderBankID:2
			$hour =  date('H');
			if($hour>=ADVANCE_START && $hour<ADVANCE_END)
			{
				$BankID = DAB_ID;
				$OrderBankID =  DAB_ID;
				$query = sprintf( "CALL sp_GetListStockDetail_ForAdvPaper('%s','%s','%s','%s')", $BankID, $OrderBankID, $TradingDate,$AccountNo);
				$result = $this->_MDB2->extended->getAll($query);
				$num_row = count($result);
				if($num_row>0)
				{
					for($i=0; $i<$num_row; $i++) {
						$this->items[$i] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'ID'  => new SOAP_Value("ID", "string", $result[$i]['orderid']),
									'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
									'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
									'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
									'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['symbol']),
									'OrderQuantity'  => new SOAP_Value("OrderQuantity", "string", $result[$i]['orderquantity']),
									'MatchedQuantity'  => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
									'Price'  => new SOAP_Value("Price", "string", $result[$i]['matchedprice']),
									'Total'  => new SOAP_Value("Total", "string", $result[$i]['total']),
									'MoneyLeft'  => new SOAP_Value("MoneyLeft", "string", $result[$i]['moneyleft']),
									'NumAdvanceDay'  => new SOAP_Value("NumAdvanceDay", "string", $result[$i]['numday']),
									'OrderFee'  => new SOAP_Value("OrderFee", "string", $result[$i]['matchedagencyfee']),
									'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date']),
									'IsTDay'  => new SOAP_Value("IsTDay", "string", $result[$i]['iscurrdate']),
									'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
									'MaxAdvanceFee'  => new SOAP_Value("MaxAdvanceFee", "string", round($result[$i]['aprate']*$result[$i]['numday']*$result[$i]['moneyleft']))

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
	 * Function listAdvancePaper	:
	 * Input 						: $condition
	 * OutPut 						: array
	 */
	function listAdvancePaper($condition,$timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listAdvancePaper';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf( "CALL sp_ListAdvancePaper(\"%s\",\"%s\")", $timezone, $condition);
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
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
								'AdvanceDate'  => new SOAP_Value("AdvanceDate", "string", $result[$i]['advancedate']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'Note'  	=> new SOAP_Value("Note", "string", $result[$i]['note']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'IsConfirmed1'  => new SOAP_Value("IsConfirmed1", "string", $result[$i]['isconfirmed1']),
								'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
								'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
								'IsTradingTime'  => new SOAP_Value("IsTradingTime", "string", $result[$i]['istradingtime']),
								'TDate'  => new SOAP_Value("TDate", "string", $result[$i]['tdate']),
								'OrderBankID'  => new SOAP_Value("OrderBankID", "string", $result[$i]['orderbankid']),
								'CreatedBy'  => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
								'CreatedDate'  => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate'] ),
								'UpdatedBy'  => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
								'UpdatedDate'  => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate'] ),
								'IsEPSFee'  => new SOAP_Value("IsEPSFee", "string", $result[$i]['isepsfee'] ),
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
	 * Function getAdvancePaper	:
	 * Input 					: $AdvanceID
	 * OutPut 					: array
	 */
	function getAdvancePaper($AdvanceID,$timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getAdvancePaper';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf( "call sp_AdvancePaper('%s','%s')",$AdvanceID,timezone);
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
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
								'AdvanceDate'  => new SOAP_Value("AdvanceDate", "string", $result[$i]['advancedate']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'Note'  => new SOAP_Value("Note", "string", $result[$i]['note']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'IsConfirmed1'  => new SOAP_Value("IsConfirmed1", "string", $result[$i]['isconfirmed1']),
								'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
								'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
								'Rate'  => new SOAP_Value("Rate", "string", $result[$i]['rate']),
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
	 * Function getAdvancePaper	:
	 * Input 					: $AdvanceID
	 * OutPut 					: array
	 */
	function getAdvancePaperDetail($AdvanceID,$TimeZone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getAdvancePaperDetail';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf( "call sp_AdvancePaperForStock('%s')",$AdvanceID);
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
								'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['stocksymbol']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount'])
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
	 * Function addAdvancePager	: insert new AdvancePager into database
	 * Input 		: $AccountID, $Amount, $AdvanceDate, $CardNo, $Note, $CreatedBy
	 * OutPut 		: insertID. Return 0 if data is valid and return error code(number >0).
	 */
	function addAdvancePager($AccountID, $Amount, $AdvanceDate, $AdvanceFee, $CardNo, $Note, $CreatedBy, $BankID,$IsTradingTime, $OrderBankID, $TDay)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addAdvancePager';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AccountID" => $AccountID,
										"Amount" 	=> $Amount,
										"AdvanceDate" 		=> $AdvanceDate,
										"Note" 			=> $Note,
										"CreatedBy" 	=> $CreatedBy,
										);
			if(!required($Amount) or (!numeric($Amount)/* or $Amount<10000000*/)) $this->_ERROR_CODE = 20006;
			if($this->_ERROR_CODE == 0 and (!required($AdvanceDate)) or !valid_date($AdvanceDate)) $this->_ERROR_CODE = 20007;
			if($this->_ERROR_CODE == 0 and (!required($AdvanceFee)) or !numeric($AdvanceFee)) $this->_ERROR_CODE = 20021;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf("CALL sp_insertAdvancePaper ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $TDay, $OrderBankID, $IsTradingTime, $BankID, $AccountID, $Amount, $AdvanceDate, $AdvanceFee, $CardNo, $Note, $CreatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not add
				if(empty($result) || is_object($result))	$this->_ERROR_CODE = 20002;
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
									'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror']),
									'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[0]['varcontract'])
									)
							);
						}else
						{
							switch ($result[0]['varerror']) {
								case '0'://sucess
										$this->_ERROR_CODE = 0;
										break;
								case '-1'://Invalid AccountID or AccountNo
										$this->_ERROR_CODE = 22005;
										break;
								case '-2':// Duplicate ContracNo
										$this->_ERROR_CODE = 20015;
										break;
								case '-3'://Invalid Advance Fee
										$this->_ERROR_CODE = 20016;
										break;
								case '-4':// AdvanceMoney>Maxadvancemoney
										$this->_ERROR_CODE = 20009;
										break;
								case '-5':// Invalid CardNo
										$this->_ERROR_CODE = 20018;
										break;
								case '-9999':// exception
										$this->_ERROR_CODE = 20017;
										break;
								default://Exception
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function addAdvancePaper_DAB	: insert new AdvancePager into database for DAB
	 * Input 		: $AccountID, $Amount, $AdvanceDate, $AdvanceFee, $OrderID, $OrderBankID, $Note, $CreatedBy
	 * OutPut 		: insertID. Return 0 if data is valid and return error code(number >0).
	 */
	function addAdvancePaper_DAB($AccountID, $AccountNo, $BankAccount, $FullName, $OrderAmount, $OrderFee, $Amount, $AdvanceDate, $OrderID, $Note, $T3Date, $CreatedBy, $NumDay, $IsTDay) {
		try{
			$class_name = $this->class_name;
			$function_name = 'addAdvancePaper_DAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($Amount) or (!numeric($Amount) or $Amount<5000000))
				$this->_ERROR_CODE = 20006;

			if($this->_ERROR_CODE == 0 and (!required($AdvanceDate)) or !valid_date($AdvanceDate))
				$this->_ERROR_CODE = 20007;

			$hour =  date('H');
			if($this->_ERROR_CODE == 0 and ($hour<ADVANCE_START || $hour>ADVANCE_END))
				$this->_ERROR_CODE = 20046;

			//if($this->_ERROR_CODE == 0 and (!required($AdvanceFee)) or !numeric($AdvanceFee)) $this->_ERROR_CODE = 20021;
			if($this->_ERROR_CODE == 0) {
				//,$OrderBankID :2
				$OrderBankID = DAB_ID;

				$query = sprintf("CALL sp_insertAdvancePaper_DAB ('%s','%s','%s','%s','%s','%s','%s','%s')", $NumDay, $AccountID, $Amount, $AdvanceDate, $OrderID, $OrderBankID, $Note, $CreatedBy);
				//write_my_log_path('Advance-Store',$query,ADVANCE_PATH);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not add
				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 20037;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				} else {
					if(isset($result[0]['varerror'])) {
						//success
						if($result[0]['varerror'] >0) {
							$adv_online= $this->AdvanceForDAB_Online($result[0]['varerror'],$OrderID, $FullName, $OrderAmount, $OrderFee, $T3Date, $IsTDay);
							write_my_log_path('DAB-Advance_Debug','addAdvancePaper_DAB : OrderAmount '.$OrderAmount.' OrderFee '.$OrderFee.' AccountNo '.$AccountNo.' '.date('Y-m-d h:i:s'), ADVANCE_PATH);
							if($adv_online!=0) {
								$query = sprintf("CALL sp_DeleteAdvancePaper_DAB ('%s','%s','%s')", $result[0]['varcontractno'], $AdvanceDate, $CreatedBy);
								$this->_MDB2_WRITE->disconnect();
								$this->_MDB2_WRITE->connect();
								$result = $this->_MDB2_WRITE->extended->getAll($query);

								$this->_ERROR_CODE = $adv_online;
							} else {
								$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
									array(
										'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror']),
										)
								);
							}

						} else if($this->_ERROR_CODE==0) {
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 20038;
											break;
									case '-2':// invalid Advance Amount
											$this->_ERROR_CODE = 20039;
											break;
									case '-3'://error insert vao money_history
											$this->_ERROR_CODE = 20040;
											break;
									case '-9999':// exception
											$this->_ERROR_CODE = 20041;
											break;
									default://Exception
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function addAdvancePaperWithoutLimitation_DAB	: insert new AdvancePager into database for DAB
	 * Input 		: $AccountID, $Amount, $AdvanceDate, $AdvanceFee, $OrderID, $OrderBankID, $Note, $CreatedBy
	 * OutPut 		: insertID. Return 0 if data is valid and return error code(number >0).
	 */
	function addAdvancePaperWithoutLimitation_DAB($AccountID, $AccountNo, $BankAccount, $FullName, $OrderAmount, $OrderFee, $Amount, $AdvanceDate, $OrderID, $Note, $T3Date, $CreatedBy, $NumDay, $IsTDay) {
		try{
			$class_name = $this->class_name;
			$function_name = 'addAdvancePaperWithoutLimitation_DAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if(!required($Amount) or !numeric($Amount) )
				$this->_ERROR_CODE = 20006;

			if($this->_ERROR_CODE == 0 and (!required($AdvanceDate)) or !valid_date($AdvanceDate))
				$this->_ERROR_CODE = 20007;

			$hour =  date('H');
			if($this->_ERROR_CODE == 0 and ($hour<ADVANCE_START || $hour>ADVANCE_END))
				$this->_ERROR_CODE = 20046;

			//if($this->_ERROR_CODE == 0 and (!required($AdvanceFee)) or !numeric($AdvanceFee)) $this->_ERROR_CODE = 20021;
			if($this->_ERROR_CODE == 0) {
				//,$OrderBankID :2
				$OrderBankID = DAB_ID;

				$query = sprintf("CALL sp_insertAdvancePaper_DAB ('%s','%s','%s','%s','%s','%s','%s','%s')", $NumDay, $AccountID, $Amount, $AdvanceDate, $OrderID, $OrderBankID, $Note, $CreatedBy);
				//write_my_log_path('Advance-Store',$query,ADVANCE_PATH);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not add
				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 20037;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				} else {
					if(isset($result[0]['varerror'])) {
						//success
						if($result[0]['varerror'] >0) {
							$adv_online= $this->AdvanceForDAB_Online($result[0]['varerror'],$OrderID, $FullName, $OrderAmount, $OrderFee, $T3Date, $IsTDay);
							write_my_log_path('DAB-Advance_Debug','addAdvancePaperWithoutLimitation_DAB : OrderAmount '.$OrderAmount.' OrderFee '.$OrderFee.' AccountNo '.$AccountNo.' '.date('Y-m-d h:i:s'), ADVANCE_PATH);
							if($adv_online!=0) {
								$query = sprintf("CALL sp_DeleteAdvancePaper_DAB ('%s','%s','%s')", $result[0]['varcontractno'], $AdvanceDate, $CreatedBy);
								$this->_MDB2_WRITE->disconnect();
								$this->_MDB2_WRITE->connect();
								$result = $this->_MDB2_WRITE->extended->getAll($query);

								$this->_ERROR_CODE = $adv_online;
							} else {
								$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
									array(
										'ID'  => new SOAP_Value("ID", "string", $result[0]['varerror']),
										)
								);
							}

						} else if($this->_ERROR_CODE==0) {
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AccountID or AccountNo
											$this->_ERROR_CODE = 20038;
											break;
									case '-2':// invalid Advance Amount
											$this->_ERROR_CODE = 20039;
											break;
									case '-3'://error insert vao money_history
											$this->_ERROR_CODE = 20040;
											break;
									case '-9999':// exception
											$this->_ERROR_CODE = 20041;
											break;
									default://Exception
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function addAdvancePager	: insert new AdvancePager into database
	 * Input 		: $ID, $Amount, $AdvanceDate, $AdvanceFee, $Note, $UpdatedBy
	 * OutPut 		: insertID. Return 0 if data is valid and return error code(number >0).
	 */
	function updateAdvancePager($AdvancePaperID, $Amount, $AdvanceDate, $AdvanceFee, $Note, $UpdatedBy, $BankID, $OrderBankID, $TDay)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updateAdvancePager';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AccountID" => $AccountID,
										"Amount" 	=> $Amount,
										"AdvanceDate" 		=> $AdvanceDate,
										"Note" 			=> $Note,
										"CreatedBy" 	=> $CreatedBy,
										);
			if($AdvancePaperID==''||$AdvancePaperID<=0)
			{
				$this->_ERROR_CODE = 20001;
			}
			if(!required($Amount) or (!numeric($Amount)/* or $Amount<=10000000*/)) $this->_ERROR_CODE = 20006;
			if($this->_ERROR_CODE == 0 and (!required($AdvanceDate)) or !valid_date($AdvanceDate)) $this->_ERROR_CODE = 20007;
			if($this->_ERROR_CODE == 0 and (!required($AdvanceFee)) or !numeric($AdvanceFee)) $this->_ERROR_CODE = 20021;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf("CALL sp_updateAdvancePaper ('%s','%s','%s','%s','%s','%s','%s','%s','%s')", $TDay, $OrderBankID, $BankID, $AdvancePaperID, $Amount, $AdvanceDate, $AdvanceFee, $Note, $UpdatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not add
				if(empty($result) || is_object($result))	$this->_ERROR_CODE = 20003;
				else{
					if(isset($result[0]['varerror']))
					{
						if($result[0]['varerror']<0){
							switch ($result[0]['varerror']) {
								case '0'://sucess
										$this->_ERROR_CODE = 0;
										break;
								case '-1'://Invalid AdvancePaperID or AdvancePaperID da duoc xac nhan
										$this->_ERROR_CODE = 20001;
										break;
								case '-3':// Invalid Advance Fee
										$this->_ERROR_CODE = 20016;
										break;
								case '-4'://AdvanceMoney>Maxadvancemoney
										$this->_ERROR_CODE = 20009;
										break;
								case '-9999':// exception
										$this->_ERROR_CODE = 22019;
										break;
								default://Exception
										$this->_ERROR_CODE = 22134;
										write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function addAdvancePager	: insert new AdvancePager into database
	 * Input 		: $ID, $Amount, $AdvanceDate, $AdvanceFee, $Note, $UpdatedBy
	 * OutPut 		: insertID. Return 0 if data is valid and return error code(number >0).
	 */
	function deleteAdvancePager($AdvancePaperID, $UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deleteAdvancePager';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AccountID" => $AccountID,
										"Amount" 	=> $Amount,
										"AdvanceDate" 		=> $AdvanceDate,
										"Note" 			=> $Note,
										"CreatedBy" 	=> $CreatedBy,
										);
			if($AdvancePaperID==''||$AdvancePaperID<=0)
			{
				$this->_ERROR_CODE = 20001;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf("CALL sp_deleteAdvancePaper ('%s','%s')", $AdvancePaperID, $UpdatedBy);
				$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not add
				if(empty($result) || is_object($result))	$this->_ERROR_CODE = 20004;
				else{
					if(isset($result[0]['varerror']))
					{
						/*Invalid AdvancePaperID or AdvancePaperID da duoc xac nhan*/
						if($result[0]['varerror'] == -1){
							 $this->_ERROR_CODE = 20001;
						}else if($result[0]['varerror'] == -9995){
						 	////exception
						 	$this->_ERROR_CODE = 20023;
						}else if($result[0]['varerror']<0){
							$this->_ERROR_CODE = 22134;
							write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function addAdvancePagerDetail: add AdvancePager
	 * Input 				:  $Amount, $Note, $UpdatedBy
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function addAdvancePagerDetail($AdvancePaperID, $OrderID, $Amount, $CreatedBy, $AccountNo, $OrderAmount, $OrderFee, $T3Date, $OrderBankID, $BankAccount, $IsTrading , $BankID, $FullName)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addAdvancePagerDetail';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AdvancePaperID" => $AdvancePaperID,
										"StockDetailID" => $OrderID,
										"Amount" => $Amount,
										"CreatedBy" 	=> $CreatedBy
										);
			if($AdvancePaperID==''||$AdvancePaperID<=0)
			{
				$this->_ERROR_CODE = 20001;
			} else
			{
				if(!required($AdvancePaperID)) $this->_ERROR_CODE = 20001;
				if($this->_ERROR_CODE == 0 and !required($OrderID)) $this->_ERROR_CODE = 20008;
				if($this->_ERROR_CODE == 0 and !required($Amount) and (!numeric($Amount) or $Amount<=0)) $this->_ERROR_CODE = 20006;
			}

			if($this->_ERROR_CODE == 0)
			{
				$ERROR_CODE = 0;
				if($OrderBankID==DAB_ID && $IsTrading==1){
					$OrderAmount1 = $OrderAmount+$OrderFee;
					$ERROR_CODE = $this->creditAccountForAdvance( $OrderID, $AccountNo, $BankAccount, $FullName, $OrderAmount1, $OrderFee, $T3Date);
				//	$ERROR_CODE = $this->creditAccountForAdvance( $OrderID, '057C001223', '0101000035', $AccountNo/*Fullname*/, $OrderAmount, $OrderFee, $T3Date);
				}
				if($ERROR_CODE == 0)
				{
					$query = sprintf("CALL sp_insertAdvancePaperDetail ('%s','%s','%s','%s','%s')", $BankID, $AdvancePaperID, $OrderID, $Amount, $CreatedBy);
					$result = $this->_MDB2_WRITE->extended->getAll($query);
						//Can not add
					if(empty($result) || is_object($result))
					{
						$this->_ERROR_CODE = 20014;
						 write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
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
							}else
							{
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid AdvancePaperID or AdvancePaperID da duoc xac nhan
											$this->_ERROR_CODE = 20001;
											break;
									case '-2'://Invalid StockDetail
											$this->_ERROR_CODE = 20008;
											break;
									case '-3'://AdvanceMoneyforStock>MaxadvancemoneyForStock
											$this->_ERROR_CODE = 20012;
											break;
									case '-9998':// exception
											$this->_ERROR_CODE = 20013;
											break;
									default://Exception
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
											break;
								}
							}
						}
					}
				}
			}
			//echo $this->_ERROR_CODE;
			if($this->_ERROR_CODE != 0) $this->deleteAP($AdvancePaperID,$CreatedBy);
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
	 * Function creditAccountForAdvance: add AdvancePager
	 * Input 				:  $Amount, $Note, $UpdatedBy
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function creditAccountForAdvance( $OrderID, $AccountNo, $DABBankAccount, $Fullname, $Amount, $Fee, $T3Date)
	{
		if($this->_ERROR_CODE == 0 and !required($OrderID))
			$this->_ERROR_CODE = 20008;

		if($this->_ERROR_CODE == 0 and !required($Amount) and (!numeric($Amount) or $Amount<=0))
			$this->_ERROR_CODE = 20006;

		//write_my_log_path('DAB-Sell4Advance','AccountNo '.$AccountNo.' OrderID'.$OrderID.' DABBankAccount'.$DABBankAccount.' Fullname '.$AccountNo.' '.'DAB'.' '.'CN Quan 1'.' Amount '.$Amount.' Fee '.$Fee.' T3Date'.$T3Date.' Error '.$chkbankaccount.' '.date('Y-m-d h:i:s'),ADVANCE_PATH);

		if($this->_ERROR_CODE == 0) {
			$path =  DAB_PATH;
			$date_array = getdate();
			$csv_dir = $path . $date_array['year'].'/';
			$csv_dir = $csv_dir . $date_array['mon'].'/';
			$filename = $csv_dir . date("Ynd") . '_DAB_Sell.xml';
			if (!file_exists($filename)) {
				$dab = &new CDAB();
				$chkbankaccount = $dab->creditAccount($AccountNo, $OrderID, $DABBankAccount, $Fullname, 'DAB', 'CN Quan 1', $Amount, $Fee, $T3Date);

				/*
				-1: unauthenticate partner
				-2: invalid parameters
				-3: invalid date
				-4: has already existed selling
				0: sell successful
				1: sell unsuccessful (database error)
				99: unknown error
				*/
				switch ($chkbankaccount) {
					case '0'://sucess
						break;
					case '2'://sucess
						break;
					case '-1'://unauthenticate partner
						$ERROR_CODE = 18132;
						break;

					case '-2'://invalid parameters
						$ERROR_CODE = 18133;
						break;

					case '-3'://invalid date
						$ERROR_CODE = 18134;
						break;

					case '-4'://has already existed selling
						$ERROR_CODE = 20025;
						break;

					case '1'://sell unsuccessful
						$ERROR_CODE = 20026;
						break;

					case '99'://Unknown error
						$ERROR_CODE = 20027;
						break;

					default://deafulr error
						$ERROR_CODE = 20028;
						break;
				}
				write_my_log_path('DAB-Sell4Advance','AccountNo '.$AccountNo.' OrderID '.$OrderID.' DABBankAccount '.$DABBankAccount.' Fullname '.$Fullname.' '.'DAB'.' '.'CN Quan 1'.' Amount '.$Amount.' Fee '.$Fee.' T3Date '.$T3Date.' Error '.$chkbankaccount.' '.date('Y-m-d h:i:s'), ADVANCE_PATH);
			}
		}

		//return $ERROR_CODE;
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}
	/**
	 * Function updateBalanceAdvance: update BalanceAdvance and add 1 record Deposit money for advance money
	 * Input 				:  $AdvancePaperID
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	function approveAdvance($AdvancePaperID, $UpdatedBy, $ApproveDate, $IsTradingTime, $OrderBankID, $BankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'approveAdvance';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$fields_values = array(
										"AdvancePaperID" => $AdvancePaperID,
										"UpdateBy" 	=> $UpdatedBy
										);
			if($AdvancePaperID==''||$AdvancePaperID<=0)
			{
				$this->_ERROR_CODE = 20001;
			}
			$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'OrderID'  => new SOAP_Value("OrderID", "string", 0)
									)
							);
			if($this->_ERROR_CODE == 0)	{
				$AdvanceInfo = $this->checkforapproveAdvancePape($AdvancePaperID, $ApproveDate);
				if($AdvanceInfo['ErrorCode']=='0' && $AdvanceInfo['AccountNo']!='0') {
					switch($OrderBankID) {
						case DAB_ID:
							$listAdv = $this->AdvanceForDAB($AdvancePaperID, $OrderBankID);
							break;

						case OFFLINE:
							$mdb2 = initWriteDB();
							$query = sprintf("CALL sp_VirtualBank_insertAdvancePaper('%s', %u, %f, '%s', '%s', '%s')", $AdvanceInfo['AccountNo'], OFFLINE, $AdvanceInfo['Amount'], $ApproveDate, $AdvanceInfo['Note'], $UpdatedBy);
							$result = $mdb2->extended->getRow($query);
							$mdb2->disconnect();
							$this->_MDB2_WRITE->disconnect();

							switch ($result['varerror']) {
								case '-1':
									$this->_ERROR_CODE = 20100;
									break;

								case '-2':
									$this->_ERROR_CODE = 20101;
									break;

								case '-3':
									$this->_ERROR_CODE = 20102;
									break;

								case '-4':
									$this->_ERROR_CODE = 20103;
									break;

								case '-9':
									$this->_ERROR_CODE = 20104;
									break;

								default:
									$this->_ERROR_CODE = $result['varerror'];
							}//switch

							write_my_log_path('ApproveAdvance-Log', $query .'  --> '. $this->_ERROR_CODE, ADVANCE_PATH);
							$listAdv = $result['varerror'] > 0 ? 0 : $this->_ERROR_CODE;
							break;

						default:
							$listAdv = 99;
					}//switch

					if($listAdv == 0){
            if($OrderBankID == OFFLINE){
              $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
              $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
              $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
              $query .= " WHERE a.accountNo='" . $AdvanceInfo['AccountNo'] . "' AND ab.bankid=" . OFFLINE;
              $mdb = initWriteDB();
              $acc_rs = $mdb->extended->getRow($query);
              $mdb->disconnect();
              if(!empty($acc_rs['mobilephone'])){
                $message  = 'Tai khoan cua quy khach tai KIS da thay doi: %2B' . number_format( $AdvanceInfo['Amount'], 0, '.', ',' ) . '. Ung truoc tien ban ck';
                $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
                sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message), 'approveAdvance');
              }
            }

						$soap = &new Bravo();
						$deposit_value = array( "TradingDate"   => $ApproveDate,
                                    "AccountNo"     => $AdvanceInfo['AccountNo'],
                                    "Amount"        => $AdvanceInfo['Amount'],
                                    "Fee"           => $AdvanceInfo['Fee'],
                                    "Bank"          => $AdvanceInfo['BravoCode'],
                                    "Branch"        => 0,
                                    "Type"          => $AdvanceInfo['InvestorType'],
                                    "Note"          => "Ung truoc",
                                    "transactionType" => '1',  // "transactionType" => '1' ung truoc
                                    "BankID"        => $BankID,
                                    "OrderBankBravoCode" => $AdvanceInfo['OrderBankBravoCode'],);

						$ret = $soap->advanceMoney($deposit_value);

						write_my_log_path('Bravo-Log',"TradingDate ".$ApproveDate." AccountNo ". $AdvanceInfo['AccountNo']." Amount ".$AdvanceInfo['Amount']." Bank ".$AdvanceInfo['BravoCode'], ADVANCE_PATH);

            $ret['table0']['Result'] = 1;
						if($ret['table0']['Result']==1) {
							$this->_MDB2_WRITE->connect();
							$query = sprintf("CALL sp_confirmAdvancePaper ('%s','%s','%s')", $AdvancePaperID, $UpdatedBy, $ApproveDate);
							$result = $this->_MDB2_WRITE->extended->getAll($query);
							write_my_log_path('ApproveAdvance-Log',$query.'  '.$result->backtrace[0]['args'][4], ADVANCE_PATH);
								//Can not add
							if(empty($result) || is_object($result)){
								$soap->rollback($ret['table1']['Id'], $ApproveDate);
								write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
								$this->_ERROR_CODE = 20020;
							} else {
								if(isset($result[0]['varerror'])) {
									if($result[0]['varerror']<0){
										switch ($result[0]['varerror']) {
											case '0'://sucess
													$this->_ERROR_CODE = 0;
													break;
											case '-1'://Invalid AdvancePaper or Invalid Advance Money
													$this->_ERROR_CODE = 20001;
													break;
											case '-3'://co it nhat 1 record trong advance_detail da het ngay t3
													$this->_ERROR_CODE = 20023;
													break;
											case '-9995'://exception
													$this->_ERROR_CODE = 20019;
													break;
											case '-1000':// exception
													$this->_ERROR_CODE = 20047;
													break;
											default://default
													$this->_ERROR_CODE = 22134;
													write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
													break;
										}
									}

									if($this->_ERROR_CODE!=0){
										//$this->deleteAP($AdvancePaperID,$UpdatedBy);
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
									write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],ADVANCE_PATH);
									break;
							}
						}
					}else{
						$this->_ERROR_CODE=$listAdv;
						$this->items[0] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
								array(
									'OrderID'  => new SOAP_Value("OrderID", "string", $listAdv)
									)
							);
					}
				}else{
					$this->_ERROR_CODE=$AdvanceInfo['ErrorCode'];
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}



	function deleteAP($AdvancePaperID,$UpdatedBy)
	{
		$mdbwrite2 = initWriteDB();
		$ERROR_CODE = 0;
		if($AdvancePaperID==''||$AdvancePaperID<=0)
		{
			$ERROR_CODE = 20001;
		}
		if($ERROR_CODE == 0)
		{
			$query1 = sprintf("CALL sp_realdeleteAdvancePaper ('%s','%s')", $AdvancePaperID, $UpdatedBy);
			$result = $mdbwrite2->extended->getAll($query1);
			//Can not add
			if(empty($result) || is_object($result)){
				$ERROR_CODE = 20004;
				write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
			}
			else{
				if(isset($result[0]['varerror']))
				{
					$ERROR_CODE = $result[0]['varerror'];
					/*Invalid AdvancePaper*/
					if($result[0]['varerror'] == -1) $ERROR_CODE = 20001;
				}
			}

		}
		return $ERROR_CODE;
	}

	function AdvanceForDAB_Online($AdvancePaperID,$OrderID, $Fullname, $OrderAmount, $OrderFee, $T3Date, $IsTDay) {
		$OrderBankID = DAB_ID;
		$ERROR_CODE = 0;
		$mdb2 = initDB();

		if($AdvancePaperID =='' || $AdvancePaperID<=0) {
			$advancelist[$i]['ErrorCode'] = 20001;
		}

		if($advancelist[$i]['ErrorCode'] == 0) {
			$query11 = sprintf("CALL sp_AdvancePaper_ByAdvPaperID('%s', '%s')", $AdvancePaperID, $OrderBankID);
			$result = $mdb2->extended->getAll($query11);
			$num_row = count($result);
			if($num_row>0) {
				if($OrderBankID == DAB_ID) {
					if($result[0]['apbankid'] != DAB_ID) {
						$lender = 0;
					}else {
						$lender = 1;
					}

					for($i=0; $i<$num_row; $i++) {
							if($result[$i]['orderidstring']=='' || $result[$i]['accountno']=='' || $result[$i]['contractno']=='') {
								$chkbankaccount = -99;
							} else {

								//$IsTDay == 1 la ngay T nen goi ham sell, $IsTDay == 0 thi la T1,T2 khong can goi sell
								if($IsTDay == 1){
									$ERROR_CODE = $this->creditAccountForAdvance( $OrderID, $result[$i]['accountno'], $result[$i]['bankaccount'], $Fullname, $OrderAmount+$OrderFee, $OrderFee, $T3Date);
									write_my_log_path('DAB-Advance_Debug','OrderAmount '.$OrderAmount.' OrderFee'.$OrderFee.' AccountNo '.$result[$i]['accountno'].' '.date('Y-m-d h:i:s'), ADVANCE_PATH);
								}

								if($ERROR_CODE == 0){
									$dab = &new CDAB();
									$chkbankaccount = $dab->sellAdvance($result[$i]['accountno'], $result[$i]['bankaccount'], $result[$i]['contractno']?$result[$i]['contractno']:0, $lender, $result[$i]['amount']?$result[$i]['amount']:0,$result[0]['advancefee']?$result[0]['advancefee']:0,$result[$i]['orderidstring']?$result[$i]['orderidstring']:0);
								} else {
									write_my_log_path('DAB-Advance_error','AdvancePaperID '.$AdvancePaperID.' Account No'.$result[$i]['accountno'].' ContractNo '.$result[$i]['contractno'].' BankAccount '.$result[$i]['bankaccount'].'  AdvanceAmount '.$result[$i]['amount'].'  AdvanceFee '.$result[0]['advancefee'].'  orderid '.$result[$i]['orderidstring'].'  orderbankid '.$OrderBankID.' Advance bankid '.$result[$i]['apbankid'].' T3OrderDate '.$result[$i]['t3orderdate'].' Lender'.$lender.' Error '.$chkbankaccount.' '.date('Y-m-d h:i:s'), ADVANCE_PATH);
									return $ERROR_CODE;
								}
							}

							write_my_log_path('DAB-Advance1','AdvancePaperID '.$AdvancePaperID.' Account No'.$result[$i]['accountno'].' ContractNo '.$result[$i]['contractno'].' BankAccount '.$result[$i]['bankaccount'].'  AdvanceAmount '.$result[$i]['amount'].'  AdvanceFee '.$result[0]['advancefee'].'  orderid '.$result[$i]['orderidstring'].'  orderbankid '.$OrderBankID.' Advance bankid '.$result[$i]['apbankid'].' T3OrderDate '.$result[$i]['t3orderdate'].' Lender'.$lender.' Error '.$chkbankaccount.' '.date('Y-m-d h:i:s'),ADVANCE_PATH);

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
							switch ($chkbankaccount) {
								case '0'://sucess
									$ERROR_CODE = 0;
									break;
								case '3'://sucess
									$ERROR_CODE = 0;
									break;
								case '-1'://unauthenticate partner
									$ERROR_CODE = 18132;
									break;

								case '-2'://invalid parameters
									$ERROR_CODE = 18133;
									break;

								case '-3'://invalid date
									$ERROR_CODE = 18134;
									break;

								case '-4'://can't pay in advance to this custaccount
									$ERROR_CODE = 20030;
									break;

								case '1'://invalid custaccount
									$ERROR_CODE = 20031;
									break;

								case '2'://invalid adv_amount
									$ERROR_CODE = 20032;
									break;

								case '5'://sell (advance) unsuccessful
									$ERROR_CODE = 20033;
									break;

								case '10'://has already paid in advance
									$ERROR_CODE = 20034;
									break;

								case '20'://out of loan limit
									$ERROR_CODE = 20035;
									break;
								case '21'://amount biger 95%
									$ERROR_CODE = 20048;
									break;
								case '-99'://Advance Data error
									$ERROR_CODE = 20036;
									break;

								case '99'://Unknown error
									$ERROR_CODE = 20027;
									break;

								default://deafulr error
									$ERROR_CODE = 20028;
									break;
							}
						//}
					}
				}
			}
		}

		return $ERROR_CODE;
	}

	function AdvanceForDAB($AdvancePaperID, $OrderBankID)
	{
		$ERROR_CODE = 0;
		$mdb2 = initDB();
		$advancelist = array('AccountNo'=>'0', 'RefOrderID'=>0, 'Amount'=>0, 'OrderBankID' => '0', 'BravoCode' => '0', 'ErrorCode' => '0');
		if($AdvancePaperID==''||$AdvancePaperID<=0)
		{
			$advancelist[$i]['ErrorCode'] = 20001;
		}

		if($advancelist[$i]['ErrorCode'] == 0)
		{
			$query11 = sprintf("CALL sp_AdvancePaper_ByAdvPaperID('%s', '%s')", $AdvancePaperID, $OrderBankID);
			$result = $mdb2->extended->getAll($query11);
			$num_row = count($result);
			if($num_row>0)
			{
				if($OrderBankID == DAB_ID)
				{
					$dab = &new CDAB();

					if($result[0]['apbankid'] != DAB_ID)
					{
						$lender = 0;
					}else{
						$lender = 1;
					}
					for($i=0; $i<$num_row; $i++) {

							if($result[$i]['orderidstring']=='' || $result[$i]['accountno']=='' || $result[$i]['contractno']=='')
							{
								$chkbankaccount = -99;
							}else{
								$chkbankaccount = $dab->sellAdvance($result[$i]['accountno'], $result[$i]['bankaccount'], $result[$i]['contractno']?$result[$i]['contractno']:0, $lender, $result[$i]['amount']?$result[$i]['amount']:0,$result[0]['advancefee']?$result[0]['advancefee']:0,$result[$i]['orderidstring']?$result[$i]['orderidstring']:0);

							}

								write_my_log_path('DAB-Advance1','AdvancePaperID '.$AdvancePaperID.' Account No'.$result[$i]['accountno'].' ContractNo '.$result[$i]['contractno'].' BankAccount '.$result[$i]['bankaccount'].'  AdvanceAmount '.$result[$i]['amount'].'  AdvanceFee '.$result[0]['advancefee'].'  orderid '.$result[$i]['orderidstring'].'  orderbankid '.$OrderBankID.' Advance bankid '.$result[$i]['apbankid'].' T3OrderDate '.$result[$i]['t3orderdate'].' Error '.$chkbankaccount.' '.date('Y-m-d h:i:s'),ADVANCE_PATH);

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
							switch ($chkbankaccount) {
								case '0'://sucess
									$ERROR_CODE = 0;
									break;
								case '3'://sucess
									$ERROR_CODE = 0;
									break;
								case '-1'://unauthenticate partner
									$ERROR_CODE = 18132;
									break;

								case '-2'://invalid parameters
									$ERROR_CODE = 18133;
									break;

								case '-3'://invalid date
									$ERROR_CODE = 18134;
									break;

								case '-4'://can't pay in advance to this custaccount
									$ERROR_CODE = 20030;
									break;

								case '1'://invalid custaccount
									$ERROR_CODE = 20031;
									break;

								case '2'://invalid adv_amount
									$ERROR_CODE = 20032;
									break;

								case '5'://sell (advance) unsuccessful
									$ERROR_CODE = 20033;
									break;

								case '10'://has already paid in advance
									$ERROR_CODE = 20034;
									break;

								case '20'://out of loan limit
									$ERROR_CODE = 20035;
									break;

								case '-99'://Advance Data error
									$ERROR_CODE = 20036;
									break;

								case '99'://Unknown error
									$ERROR_CODE = 20027;
									break;

								default://deafulr error
									$ERROR_CODE = 20028;
									break;
							}
						//}
					}
				}
			}
		}

		return $ERROR_CODE;//$advancelist;
	}

	/**
	 * Function listBankAdvance	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listBankAdvance() {
		try{
			$class_name = $this->class_name;
			$function_name = 'listBankAdvance';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_getListBankForAdvance()");

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'BankID'  => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
								'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['bankname'])
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
	 * Function getAdvanceFeeForAmount	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function getAdvanceFeeForAmount($Amount,$BankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'getAdvanceFeeForAmount';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("select f_getAdvaceFeeForAmount('%s','%s') as Fee",$Amount,$BankID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'Fee'  => new SOAP_Value("Fee", "string", $result[0]['fee'])
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
	 * Function AdvancePaper_Report1	:
	 * Input 				: $AdvancePaperID
	 * OutPut 				: array
	 */
	function AdvancePaper_Report1($AdvancePaperID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'AdvancePaper_Report1';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			//$condition = $condition?' and '.$condition:'';
			$query = sprintf("CALL sp_ReportAdvancePaper('%s')",$AdvancePaperID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'OrderSellingAmount'  => new SOAP_Value("OrderSellingAmount", "string", $result[$i]['ordersellingamount']),
								'APToDate'  => new SOAP_Value("APToDate", "string", $result[$i]['aptodate']),
								'NumDay'  => new SOAP_Value("NumDay", "string", $result[$i]['numday']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'CardNo'  => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
								'CardNoIssuer'  => new SOAP_Value("CardNoIssuer", "string", $result[$i]['cardnoissuer']),
								'CardNoDate'  => new SOAP_Value("CardNoDate", "string", $result[$i]['cardnodate']),
								'ContactAddress'  => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
								'APAmount'  => new SOAP_Value("APAmount", "string", $result[$i]['apamount']),
								'AdvanceDate'  => new SOAP_Value("AdvanceDate", "string", $result[$i]['advancedate']),
								'FullOrderSellingAmount'  => new SOAP_Value("FullOrderSellingAmount", "string", $result[$i]['fullordersellingamount']),
								'MobilePhone'  => new SOAP_Value("MobilePhone", "string", $result[$i]['mobilephone']?$result[$i]['mobilephone']:''),
								'HomePhone'  => new SOAP_Value("HomePhone", "string", $result[$i]['homephone']?$result[$i]['homephone']:'')
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
	 * Function AdvancePaper_Report2	:
	 * Input 				: $AdvancePaperID
	 * OutPut 				: array
	 */
	function AdvancePaper_Report2($AdvancePaperID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'AdvancePaper_Report2';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ReportAdvancePaper_ConfirmTransaction('%s')",$AdvancePaperID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'MatchedQuantity'  => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
								'MatchedPrice'  => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'ContactAddress'  => new SOAP_Value("ContactAddress", "string", $result[$i]['contactaddress']),
								'DealSellingAmount'  => new SOAP_Value("DealSellingAmount", "string", $result[$i]['dealsellingamount']),
								'FullDealSellingAmount'  => new SOAP_Value("FullDealSellingAmount", "string", $result[$i]['fulldealsellingamount']),
								'DealAgencyAmount'  => new SOAP_Value("DealAgencyAmount", "string", $result[$i]['dealagencyamount']),
								'MatchedAgencyFee'  => new SOAP_Value("MatchedAgencyFee", "string", $result[$i]['matchedagencyfee'])
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
	 * Function AdvancePaper_Report2	:
	 * Input 				: $AdvancePaperID
	 * OutPut 				: array
	 */
	function ReportAdvancePaper_FollowUp($TradingDate, $advBankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'ReportAdvancePaper_FollowUp';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ReportAdvancePaper_FollowUp('%s','%s')", $TradingDate, $advBankID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'MatchedQuantity'  => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'MatchedPrice'  => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
								'NumDay'  => new SOAP_Value("NumDay", "string", $result[$i]['numday']),
								'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
								'CardNo'  => new SOAP_Value("CardNo", "string", $result[$i]['cardno']),
								'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname'])
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
	 * Function ReportAdvancePaper_AccountPeriod	:
	 * Input 				: $AdvancePaperID
	 * OutPut 				: array
	 */
	function ReportAdvancePaper_AccountPeriod($AccountNo, $AdvanceDateFrom, $AdvanceDateTo) {
		try{
			$class_name = $this->class_name;
			$function_name = 'ReportAdvancePaper_AccountPeriod';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ReportAdvancePaper_AccountPeriod('%s','%s','%s')", $AccountNo, $AdvanceDateFrom, $AdvanceDateTo);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'MatchedQuantity'  => new SOAP_Value("MatchedQuantity", "string", $result[$i]['matchedquantity']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'MatchedPrice'  => new SOAP_Value("MatchedPrice", "string", $result[$i]['matchedprice']),
								'NumDay'  => new SOAP_Value("NumDay", "string", $result[$i]['numday']),
								'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['amount']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'ContractNo'  => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
								'AdvanceDate'  => new SOAP_Value("AdvanceDate", "string", $result[$i]['advancedate'])
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
	 * Function ReportAdvancePaper_Accounting	:
	 * Input 				: $AdvancePaperID
	 * OutPut 				: array
	 */
	function ReportAdvancePaper_Accounting($T3DateFrom, $T3DateTo, $advBankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'ReportAdvancePaper_Accounting';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ReportAdvancePaper_Accounting('%s', '%s', '%s')", $T3DateFrom, $T3DateTo, $advBankID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'AdvanceAmount'  => new SOAP_Value("AdvanceAmount", "string", $result[$i]['advanceamount']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
								'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date'])
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
	 * Function ReportAdvancePaper_AdvanceDate	:
	 * Input 				: $AdvanceDateFrom, $AdvanceDateTo, $advBankID
	 * OutPut 				: array
	 */
	function ReportAdvancePaper_AdvanceDate($AdvanceDateFrom, $AdvanceDateTo, $advBankID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'ReportAdvancePaper_AdvanceDate';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ReportAdvancePaper_AdvanceDate('%s', '%s', '%s')",$AdvanceDateFrom, $AdvanceDateTo, $advBankID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'BankAccount'  => new SOAP_Value("BankAccount", "string", $result[$i]['bankaccount']),
								'FullName'  => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
								'AdvanceAmount'  => new SOAP_Value("AdvanceAmount", "string", $result[$i]['amount']),
								'AdvanceFee'  => new SOAP_Value("AdvanceFee", "string", $result[$i]['advancefee']),
								'ShortName'  => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
								'T3Date'  => new SOAP_Value("T3Date", "string", $result[$i]['t3date']),
								'NumDay'  => new SOAP_Value("NumDay", "string", $result[$i]['numday'])
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
	/*-----------------------------------------END ADVANCE PAPER---------------------------------------*/
	/*--------------------------------------------PAYMENT----------------------------------------------*/

	/**
	 * Function listPayment	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listPayment($condition,$timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listPayment';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf("CALL sp_ListPaymentContract('%s', \"%s\")",$timezone,$condition);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{

				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'PaymentID'  => new SOAP_Value("PaymentID", "string", $result[$i]['paymentcontractid']),
								'PaymentDate'  => new SOAP_Value("PaymentDate", "string", $result[$i]['paymentdate']),
								'PaymentMoney'  => new SOAP_Value("PaymentMoney", "string", $result[$i]['totalmoney']),
								'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
								'InvestorName'  => new SOAP_Value("InvestorName", "string", $result[$i]['fullnameinvestor']),
								'MortageContractNo'  => new SOAP_Value("MortageContractNo", "string", $result[$i]['mortagecontractno']),
								'BankName'  => new SOAP_Value("BankName", "string", $result[$i]['mortagecontractbank']),
								'MortageContractValue'  => new SOAP_Value("MortageContractValue", "string", $result[$i]['contractvalue']),
								'MortageReleaseDate'  => new SOAP_Value("MortageReleaseDate", "string", $result[$i]['releasedate']),
								'MortageContractStatus'  => new SOAP_Value("MortageContractStatus", "string", $result[$i]['contractstatus']),
								'PaymentContractType'  => new SOAP_Value("PaymentContractType", "string", $result[$i]['paymentcontracttype']),
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
	 * Function listPaymentStockWithoutMoney	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listPaymentStockWithoutMoney($condition,$timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listPaymentStockWithoutMoney';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			//$condition = $condition?' and '.$condition:'';
			$query = sprintf('CALL sp_ListPaymentStockWithoutMoney("%s", "%s")',$timezone,$condition);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'MortageContractID'  => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
								'MortageContractNo'  => new SOAP_Value("MortageContractNo", "string", $result[$i]['mortagecontractno']),
								'PaymentID'  => new SOAP_Value("PaymentID", "string", $result[$i]['paymentid']),
								'PaymentContract'  => new SOAP_Value("PaymentContract", "string", $result[$i]['paymentcontract']),
								'MortageContractDetailID'  => new SOAP_Value("MortageContractDetailID", "string", $result[$i]['mortagecontractdetailid']),
								'PaymentContractDetailID'  => new SOAP_Value("PaymentContractDetailID", "string", $result[$i]['paymentcontractdetailid']),
								'TradingDate'  => new SOAP_Value("TradingDate", "string", $result[$i]['tradingdate']),
								'PaymentDetailMoney'  => new SOAP_Value("PaymentDetailMoney", "string", $result[$i]['paymentdetailmoney']),
								'PaymentQuantity'  => new SOAP_Value("PaymentQuantity", "string", $result[$i]['paymentquantity']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'StockSymbol'  => new SOAP_Value("StockSymbol", "string", $result[$i]['stocksymbol']),
								'AccountID'  => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
								'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
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
	 * Function listPaymentDetail	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listPaymentDetail($PaymentContractDetailID,$timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listPaymentDetail';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			$query = sprintf("CALL sp_ListPaymentContractDetail('%s','%s')",$PaymentContractDetailID,$timezone);

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
								'PaymentContractID'  => new SOAP_Value("PaymentContractID", "string", $result[$i]['paymentcontractid']),
								'MortageContractDetailID'  => new SOAP_Value("MortageContractDetailID", "string", $result[$i]['mortagecontractdetailid']),
								'PaymentTypeID'  => new SOAP_Value("PaymentTypeID", "string", $result[$i]['paymenttypeid']),
								'PaymentTypeName'  => new SOAP_Value("PaymentTypeName", "string", $result[$i]['paymenttypename']),
								'PaymentDetailRaiseBlockedDate'  => new SOAP_Value("PaymentDetailRaiseBlockedDate", "string", $result[$i]['raiseblockeddate']),
								'PaymentDetailStockSymbol'  => new SOAP_Value("PaymentDetailStockSymbol", "string", $result[$i]['symbol']),
								'PaymentDetailQuantity'  => new SOAP_Value("PaymentDetailQuantity", "string", $result[$i]['quantity']),
								'PaymentDetailAmountMoney'  => new SOAP_Value("PaymentDetailAmountMoney", "string", $result[$i]['amountmoney']),
								'IsConfirmed'  => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
								'IsConfirmed1'  => new SOAP_Value("IsConfirmed1", "string", $result[$i]['isconfirmed1']),
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
	 * Function listMortageContractUnpaid	:
	 * Input 				: $timezone
	 * OutPut 				: array
	 */
	function listMortageContractUnpaid($timezone,$PaymentID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listMortageContractUnpaid';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$query = sprintf('CALL sp_ListMortageNotPaid("%s","","%s")',$timezone,$PaymentID);
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
								'ContractValueLeft'  => new SOAP_Value("ContractValueLeft", "string", $result[$i]['contractvalueleft']),
								'PaymentValueNotConfirm'  => new SOAP_Value("PaymentValueNotConfirm", "string", $result[$i]['paymentvaluenotconfirm']),
								'PaymentValueConfirm'  => new SOAP_Value("PaymentValueConfirm", "string", $result[$i]['paymentvalueconfirm']),
								'SoldMortage'  => new SOAP_Value("SoldMortage", "string", $result[$i]['soldmortage']),
								'ContractDate'  => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
								'ReleaseDate'  => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
								'BlockedDate'  => new SOAP_Value("BlockedDate", "string", $result[$i]['blockeddate'])
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
	 * Function listMortageContractUnpaidWithFilter	:
	 * Input 							: String of condition in where clause and $timezone
	 * OutPut 							: array
	 */
	function listMortageContractUnpaidWithFilter($condition, $timezone,$PaymentID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listMortageContractUnpaidWithFilter';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$this->items = array();

			$query = sprintf('CALL sp_ListMortageNotPaid("%s","%s","%s")',$timezone,$condition,$PaymentID);

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
								'ContractValueLeft'  => new SOAP_Value("ContractValueLeft", "string", $result[$i]['contractvalueleft']),
								'PaymentValueNotConfirm'  => new SOAP_Value("PaymentValueNotConfirm", "string", $result[$i]['paymentvaluenotconfirm']),
								'PaymentValueConfirm'  => new SOAP_Value("PaymentValueConfirm", "string", $result[$i]['paymentvalueconfirm']),
								'SoldMortage'  => new SOAP_Value("SoldMortage", "string", $result[$i]['soldmortage']),
								'ContractDate'  => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
								'ReleaseDate'  => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
								'BlockedDate'  => new SOAP_Value("BlockedDate", "string", $result[$i]['blockeddate'])
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
	 * Function listMortageContractDetail	:
	 * Input 					: MortageContractID
	 * OutPut 					: array
	 */
	function listMortageContractDetail($MortageContractID) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listMortageContractDetail';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$this->items = array();

			$condition = $condition?' Where '.$condition:'';

			$query = sprintf("select * from vw_ListMortageDetail as md where md.MortageContractID='%s'", $MortageContractID);

			$result = $this->_MDB2->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				for($i=0; $i<$num_row; $i++) {
					$this->items[$i] = new SOAP_Value(
							'items',
							'{urn:'. $class_name .'}'.$function_name.'Struct',
							array(
								'MortageContractID'  => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
								'MortageContractDetailID'  => new SOAP_Value("MortageContractDetailID", "string", $result[$i]['mortagecontractdetailid']),
								'PaymentContractDetailID'  => new SOAP_Value("PaymentContractDetailID", "string", $result[$i]['paymentcontractdetailid']),
								'PaymentTypeID'  => new SOAP_Value("PaymentTypeID", "string", $result[$i]['paymenttypeid']),
								'PaymentTypeName'  => new SOAP_Value("PaymentTypeName", "string", $result[$i]['paymenttypename']),
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['loanmoney']),
								'QuantityOfPayment'  => new SOAP_Value("QuantityOfPayment", "string", $result[$i]['quantityofpayment']),
								'AmountOfPayment'  => new SOAP_Value("AmountOfPayment", "string", $result[$i]['amountofpayment']),
								'QuantitySoldMortage'  => new SOAP_Value("QuantitySoldMortage", "string", $result[$i]['quantitysoldmortage']),
								'AmountSoldMortage'  => new SOAP_Value("AmountSoldMortage", "string", $result[$i]['amountsoldmortage'])
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
	 * Function listSoldMortage	:
	 * Input 					: String of condition in where clause and $timezone
	 * OutPut 					: array
	 */
	function listSoldMortage($AccountID, $timezone) {
		try{
			$class_name = $this->class_name;
			$function_name = 'listSoldMortage';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$this->items = array();
			$query = sprintf("SELECT sum(sold_mortage.`Quantity`) AS `Quantity`, sum(sold_mortage.`ToTalMoney`) as `TotalMoney`, sold_mortage.StockID, sold_mortage.Symbol,sold_mortage.AccountID from vw_ListSoldMortage sold_mortage Where sold_mortage.AccountID=%s group by sold_mortage.AccountID, sold_mortage.StockID", $AccountID);

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
								'StockID'  => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								'Symbol'  => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								'Quantity'  => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								'TotalMoney'  => new SOAP_Value("TotalMoney", "string", $result[$i]['totalmoney'])
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
	 * Function listSoldMortage	:
	 * Input 					: String of condition in where clause and $timezone
	 * OutPut 					: array
	 */
	function addPaymentForSoldMortage($PaymentContractID, $AccountID, $Today, $CreatedBy) {
		try{
			$class_name = $this->class_name;
			$function_name = 'addPaymentForSoldMortage';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$this->items = array();
			if($this->_ERROR_CODE == 0)
			{
				if(isset($PaymentContractID)&&$PaymentContractID<0) $this->_ERROR_CODE = 21001;
				if($this->_ERROR_CODE == 0 && (!required($AccountID)||!unsigned($AccountID))) $this->_ERROR_CODE = 21022;
				if($this->_ERROR_CODE == 0 && (!required($Today)||!valid_date($Today))) $this->_ERROR_CODE = 21008;
			}
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_insertPaymentForSoldMortage ('%s','%s','%s','%s')", $PaymentContractID, $AccountID, $Today, $CreatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 18002;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				}
				else{
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
						}else {
							switch ($result[0]['varerror']) {
								case 0:
									$this->_ERROR_CODE =0;
									break;
								case -1://Invalid AccountID
									$this->_ERROR_CODE = 21022;
									break;
								case -2://Invalid PaymentContractID
									$this->_ERROR_CODE = 21001;
									break;
								case -3:/*Money is not enough**/
								case -4:/*Money is not enough**/
									$this->_ERROR_CODE = 21021;
									break;
								case -5:/*Invalid  account stock detail*/
									$this->_ERROR_CODE = 21032;
									break;
								case -6:/*moneySoldMortage=0*/
									$this->_ERROR_CODE = 21035;
									break;
								case -9:/*error insert vao stock_history*/
									$this->_ERROR_CODE = 21033;
									break;
								case -10://error insert vao money_history
									$this->_ERROR_CODE = 21017;
									break;
								case -9998://Exception
									$this->_ERROR_CODE = 21023;
									break;
								default://default
									$this->_ERROR_CODE = 22134;
									write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 function updatePaymentContract($PaymentContractID,$PaymentContractDetail,$UpdatedBy)
	 {
	 	$mdbwrite2 = initWriteDB();
		if($this->_ERROR_CODE == 0)
		{
			if(!required($PaymentContractID)||!unsigned($PaymentContractID)) $this->_ERROR_CODE = 21001;
			if($this->_ERROR_CODE == 0 && (!required($PaymentContractDetail)||!unsigned($PaymentContractDetail))) $this->_ERROR_CODE = 21027;
		}
		if($this->_ERROR_CODE == 0)
		{
			$query = sprintf( "CALL `sp_updatePaymentContractID` ('%s','%s','%s')", $PaymentContractID,$PaymentContractDetail,$UpdatedBy);
			//echo $query;
			$result = $mdbwrite2->extended->getAll($query);

			if(empty($result) || is_object($result)){
				$this->_ERROR_CODE = 21002;
				write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
			}else{
				if(isset($result[0]['varerror']))
				{
					/*Invalid PaymentContractID*/
					if($result[0]['varerror'] == -1){
						 $this->_ERROR_CODE = 21001;
					}else if($result[0]['varerror'] == -2){
						/*mortage contract detail khong thuoc vao mortage contract can giai toa*/
					 	$this->_ERROR_CODE = 21036;
					}else if($result[0]['varerror'] == -9998){
						// Exception
						 $this->_ERROR_CODE = 21024;
					}else if($result[0]['varerror']<0){
						$this->_ERROR_CODE = 22134;
						write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
					}
				}
			}
		}
		return $this->_ERROR_CODE;//returnXML($class_name, $function_name, $this->_ERROR_CODE, $this->items);
	 }
	/**
	 * Function addPayment	: insert new addPayment into database
	 * Input 				: 'MortageContractID', 'PaymentDate', 'TotalMoney', 'CreatedBy'
	 * OutPut 				: error code and insert ID. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addPayment($MortageContractID, $PaymentDate, $TotalMoney, $Note, $CreatedBy,$PaymentContractDetailID)
	{
		try{
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
			if(!required($data['MortageContractID']) || !numeric($data['MortageContractID'])) $this->_ERROR_CODE = 21005;
			if($this->_ERROR_CODE == 0) $this->_ERROR_CODE = $this->checkPayment($data);

			if($this->_ERROR_CODE == 0)
			{
				if($PaymentContractDetailID!='')
				{
					$query = sprintf( "CALL `sp_insertPaymentWithoutConfirm` ('%s','%s','%s','%s','%s','%s')", $MortageContractID, $PaymentDate, $TotalMoney, $Note, $CreatedBy, $PaymentContractDetailID);
				}else{
					$query = sprintf( "CALL `sp_insertPaymentWithoutConfirm` ('%s','%s','%s','%s','%s','%s')", $MortageContractID, $PaymentDate, $TotalMoney, $Note, $CreatedBy, 0);
				}
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 21002;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				}
				else{
						$varError = 0;
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
								if($result[0]['varerror']<0){
									switch ($result[0]['varerror']) {
										case '0'://sucess
												$this->_ERROR_CODE = 0;
												break;
										case '-1'://Invalid MortageContractID
												$this->_ERROR_CODE = 21019;
												break;
										case '-2'://moneyleft for mortage< 20.000.000
												$this->_ERROR_CODE = 21026;
												break;
										case '-3'://Payment money > mortage contractvalue
												$this->_ERROR_CODE = 21025;
												break;
										case '-4':// Hop dong cam co da duoc giai toa het
												$this->_ERROR_CODE = 21028;
												break;
										case '-5':// Hop dong cam co da duoc giai toa het
												$this->_ERROR_CODE = 21021;
												break;
										case '-6'://Gia tri hop dong giai toa <20000000
												$this->_ERROR_CODE = 21009;
												break;
										case '-9999'://Exception
												$this->_ERROR_CODE = 21020;
												break;
										default://default
												$this->_ERROR_CODE = 22134;
												write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
												break;
									}
								}
							}
							$varError = $result[0]['varerror'];
						}

						if($this->_ERROR_CODE==0 && $varError>0 && $PaymentContractDetailID!='')
						{
							$PaymentContractDetailArray=split('[,;]', $PaymentContractDetailID);
							//var_dump($PaymentContractDetailArray);
							$countID = 	count($PaymentContractDetailArray);
							for($i=0;$i<$countID;$i++)
							{
								if($PaymentContractDetailArray[$i]!='' || $PaymentContractDetailArray[$i]!=0)
									$this->_ERROR_CODE = $this->updatePaymentContract($varError,$PaymentContractDetailArray[$i],$CreatedBy);
								if($this->_ERROR_CODE!=0){
									$this->items[0] = new SOAP_Value(
								'items',
								'{urn:'. $class_name .'}'.$function_name.'Struct',
									array(

										)
								);
									 break;
								}
							}
						}
						if($this->_ERROR_CODE!=0) $this->delPayment($varError,$CreatedBy);
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addPaymentMoney	: insert new addPayment into database
	 * Input 				: 'MortageContractID', 'PaymentDate', 'TotalMoney', 'CreatedBy'
	 * OutPut 				: error code and insert ID. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function addPaymentMoney($MortageContractID, $PaymentDate, $TotalMoney, $Note, $CreatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addPaymentMoney';

			if (authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$data = array(
										"MortageContractID" 	=> $MortageContractID,
										"PaymentDate" 			=> $PaymentDate,
										"TotalMoney" 			=> $TotalMoney,
										"CreatedBy" 			=> $CreatedBy
											);
			if(!required($data['MortageContractID']) || !numeric($data['MortageContractID'])) $this->_ERROR_CODE = 21005;
			if($this->_ERROR_CODE == 0) $this->_ERROR_CODE = $this->checkPayment($data);

			if($this->_ERROR_CODE == 0)
			{

				$query = sprintf( "CALL `sp_insertPaymentMoneyWithoutConfirm` ('%s','%s','%s','%s','%s')", $MortageContractID, $PaymentDate, $TotalMoney, $Note, $CreatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 21002;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
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
							}else {
								if($result[0]['varerror']<0){
									switch ($result[0]['varerror']) {
										case '0'://sucess
												$this->_ERROR_CODE = 0;
												break;
										case '-1'://Invalid MortageContractID
												$this->_ERROR_CODE = 21019;
												break;
										case '-2'://moneyleft for mortage< 20.000.000
												$this->_ERROR_CODE = 21026;
												break;
										case '-3'://Payment money > mortage contractvalue
												$this->_ERROR_CODE = 21025;
												break;
										case '-4':// Hop dong cam co da duoc giai toa het
												$this->_ERROR_CODE = 21028;
												break;
										case '-5':// Hop dong cam co da duoc giai toa het
												$this->_ERROR_CODE = 21021;
												break;
										case '-6'://Gia tri hop dong giai toa <20000000
												$this->_ERROR_CODE = 21009;
												break;
										case '-9999'://Exception
												$this->_ERROR_CODE = 21020;
												break;
										default://default
												$this->_ERROR_CODE = 22134;
												write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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

	function delPayment($PaymentID,$UpdatedBy)
	{
		$mdbwrite2 = initWriteDB();

		$query1 = sprintf("CALL sp_rollbackPayment (%s,'%s')", $PaymentID, $UpdatedBy);
		$result = $mdbwrite2->extended->getAll($query1);

	}

	/**
	 * Function addPayment	: insert new addPayment into database
	 * Input 				: 'MortageContractID', 'PaymentDate', 'TotalMoney', 'CreatedBy'
	 * OutPut 				: error code and insert ID. Return 0 if data is valid and return error code
	 					 (number >0).
	 */
	function updatePayment($PaymentID, $PaymentDate, $TotalMoney, $UpdatedBy, $PaymentContractDetailID)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'updatePayment';

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
				if($PaymentContractDetailID!='')
				{
					$query = sprintf( "CALL `sp_updatePaymentWithoutConfirm` ('%s','%s','%s','%s','%s')", $PaymentID, $PaymentDate, $TotalMoney, $UpdatedBy, $PaymentContractDetailID);
				}else{
					$query = sprintf( "CALL `sp_updatePaymentWithoutConfirm` ('%s','%s','%s','%s','%s')", $PaymentID, $PaymentDate, $TotalMoney, $UpdatedBy, 0);
				}
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 21003;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://Invalid MortageContractID
											$this->_ERROR_CODE = 21019;
											break;
									case '-2'://moneyleft for mortage< 20.000.000
											$this->_ERROR_CODE = 21026;
											break;
									case '-3'://Payment money > mortage contractvalue
											$this->_ERROR_CODE = 21025;
											break;
									case '-4':// Hop dong cam co da duoc giai toa het
											$this->_ERROR_CODE = 21028;
											break;
									case '-5'://Money is not enough
											$this->_ERROR_CODE = 21021;
											break;
									case '-9999'://Exception
											$this->_ERROR_CODE = 21020;
											break;
									default://default
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
											break;
								}
							}
							if($this->_ERROR_CODE == 0){
								$this->_ERROR_CODE = $result[0]['varerror'];
							}
						}

						if($this->_ERROR_CODE==0 && $PaymentID>0 && $PaymentContractDetailID!='')
						{
							$PaymentContractDetailArray=split('[,;]', $PaymentContractDetailID);
							//var_dump($PaymentContractDetailArray);
							$countID = 	count($PaymentContractDetailArray);
							for($i=0;$i<$countID;$i++)
							{
								if($PaymentContractDetailArray[$i]!='' || $PaymentContractDetailArray[$i]!=0)
									$this->_ERROR_CODE = $this->updatePaymentContract($PaymentID,$PaymentContractDetailArray[$i],$UpdatedBy);
								if($this->_ERROR_CODE!=0) break;
							}
						}
						if($this->_ERROR_CODE!=0) $this->delPayment($PaymentID,$UpdatedBy);
					}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function deletePayment:deletePayment
	 * Input 				:  $PaymentID,$UpdatedBy
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	 function deletePayment($PaymentID,$UpdatedBy)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'deletePayment';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_deletePaymentWithoutConfirm ('%s','%s')", $PaymentID,$UpdatedBy);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 18003;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
				}else{
						if(isset($result[0]['varerror']))
						{
							if($result[0]['varerror']<0){
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://nvalid PaymentContractID
											$this->_ERROR_CODE = 21001;
											break;
									case '-4':// Mortage Contract da giai toa het
											$this->_ERROR_CODE = 21027;
											break;
									case '-9999'://Exception--delete payment
											$this->_ERROR_CODE = 21038;
											break;
									default://default
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
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
	 * Function approvePayment:approvePayment
	 * Input 				:  $PaymentID,$UpdatedBy,ApproveDate
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	 function approvePayment($PaymentID,$UpdatedBy, $ApproveDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'approvePayment';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			if($this->_ERROR_CODE == 0)
			{
				$PaymentInfo = $this->checkforapprovePayment($PaymentID, $ApproveDate);
				if($PaymentInfo['ErrorCode']=='0')
				{
					$soap = &new Bravo();
					$withdraw_value = array("TradingDate" => $ApproveDate, "AccountNo" => $PaymentInfo['AccountNo'], "Amount" => $PaymentInfo['Amount'], "Note" => "Giai toa"); //'011C001458'
					//var_dump($withdraw_value);
					$ret = $soap->withdraw($withdraw_value,getInvestorType($PaymentInfo['AccountNo']));
					if($ret['table0']['Result']==1){
						$query = sprintf( "CALL sp_confirmPayment ('%s','%s','%s')", $PaymentID,$UpdatedBy, $ApproveDate);
						//echo $query;
						$result = $this->_MDB2_WRITE->extended->getAll($query);

						if(empty($result) || is_object($result)){
							$soap->rollback($ret['table1']['Id'], $ApproveDate);
							write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
							$this->_ERROR_CODE = 21037;
						}
						else
						{
							if(isset($result[0]['varerror']))
							{
								if($result[0]['varerror']<0){
									switch ($result[0]['varerror']) {
										case '0'://sucess
												$this->_ERROR_CODE = 0;
												break;
										case '-2'://invalid PaymentContractID
												$this->_ERROR_CODE = 21001;
												break;
										case '-3':// invalid paymnet money or moneyleft for mortage contract less than 20000000
												$this->_ERROR_CODE = 21026;
												break;
										case '-4'://payment da xac nhan
												$this->_ERROR_CODE = 21029;
												break;
										case '-5'://invalid payment money
												$this->_ERROR_CODE = 21032;
												break;
										case '-6'://invalid payment detail money
												$this->_ERROR_CODE = 21031;
												break;
										case '-7'://invalid account_detail
												$this->_ERROR_CODE = 21032;
												break;
										case '-8'://*error insert money history
												$this->_ERROR_CODE = 21017;
												break;
										case '-9'://*error insert Stock Histoty
												$this->_ERROR_CODE = 21033;
												break;
										case '-11'://*Money is not enough
												$this->_ERROR_CODE = 21021;
												break;
										case '-8888'://*error insert money history
												$this->_ERROR_CODE = 21034;
												break;
										default://default
												$this->_ERROR_CODE = 22134;
												write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
												break;
									}
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
								write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],ADVANCE_PATH);
								break;
						}
					}
				}else{
					$this->_ERROR_CODE = $PaymentInfo['ErrorCode'];

				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function approvePaymentMoney:approvePaymentMoney
	 * Input 				:  $PaymentID,$UpdatedBy
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	 function approvePaymentMoney($PaymentID,$UpdatedBy, $ApproveDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'approvePaymentMoney';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();

			if($this->_ERROR_CODE == 0)
			{
				$PaymentInfo = $this->checkforapprovePaymentMoney($PaymentID, $ApproveDate);
				if($PaymentInfo['ErrorCode']=='0')
				{
					$soap = &new Bravo();
					$withdraw_value = array("TradingDate" => $ApproveDate, "AccountNo" => $PaymentInfo['AccountNo'], "Amount" => $PaymentInfo['Amount'], "Note" => "Giai toa");
					//var_dump($deposit_value);
					$ret = $soap->withdraw($withdraw_value,getInvestorType($PaymentInfo['AccountNo']));
					if($ret['table0']['Result']==1){
						$query = sprintf( "CALL sp_confirmPaymentMoney ('%s','%s','%s')", $PaymentID,$UpdatedBy, $ApproveDate);

						$result = $this->_MDB2_WRITE->extended->getAll($query);
						//can not approve
						if(empty($result) || is_object($result)){
							$soap->rollback($ret['table1']['Id'], $ApproveDate);
							write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
							$this->_ERROR_CODE = 21037;
						}
						else{
								if(isset($result['varerror']))
								{
									if($result[0]['varerror']<0){
										switch ($result[0]['varerror']) {
											case '0'://sucess
													$this->_ERROR_CODE = 0;
													break;
											case '-2'://invalid PaymentContractID
													$this->_ERROR_CODE = 21001;
													break;
											case '-3':// invalid paymnet money or moneyleft for mortage contract less than 20000000
													$this->_ERROR_CODE = 21026;
													break;
											case '-4'://payment da xac nhan
													$this->_ERROR_CODE = 21029;
													break;
											case '-5'://invalid payment money
													$this->_ERROR_CODE = 21032;
													break;
											case '-6'://invalid payment detail money
													$this->_ERROR_CODE = 21031;
													break;
											case '-7'://invalid account_detail
													$this->_ERROR_CODE = 21032;
													break;
											case '-8'://*error insert money history
													$this->_ERROR_CODE = 21017;
													break;
											case '-9'://*error insert Stock Histoty
													$this->_ERROR_CODE = 21033;
													break;
											case '-11'://*Money is not enough
													$this->_ERROR_CODE = 21021;
													break;
											case '-8888'://*error insert money history
													$this->_ERROR_CODE = 21034;
													break;
											default://default
													$this->_ERROR_CODE = 22134;
													write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
													break;
										}
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
								write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],ADVANCE_PATH);
								break;
						}
					}
				}else{
					$this->_ERROR_CODE = $PaymentInfo['ErrorCode'];
				}
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function addPaymentDetail: addPaymentDetail	 * Input 				:  'PaymentContractID', 'MortageContractDetailID', 'PaymentTypeID', 'RaiseBlockedDate', 'Quantity', 'AmountMoney', 'CreatedBy')
	 * OutPut 				: error code. Return 0 if data is valid and return error code
	 					 	(number >0).
	 */
	 function addPaymentDetail($PaymentContractID, $MortageContractDetailID, $RaiseBlockedDate, $Quantity, $AmountMoney, $CreatedBy, $Today)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'addPaymentDetail';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			$this->items = array();
			$data = array(
										"PaymentContractID"			=> $PaymentContractID,
										"MortageContractDetailID" 	=> $MortageContractDetailID,
										"RaiseBlockedDate"			=> $RaiseBlockedDate,
										"Quantity"					=> $Quantity,
										"AmountMoney"				=> $AmountMoney,
										"CreatedBy" 				=> $CreatedBy
										);//$this->_DATE_NOW//
			if(!required($data['PaymentContractID']) || !numeric($data['PaymentContractID'])) $this->_ERROR_CODE = 21001;
			if(!required($data['MortageContractDetailID']) || !numeric($data['MortageContractDetailID'])) $this->_ERROR_CODE = 21005;
			if(!required($data['RaiseBlockedDate']) || !valid_date($data['RaiseBlockedDate'])) $this->_ERROR_CODE = 21008;
			if(!required($data['Quantity']) && !numeric($data['Quantity'])) $this->_ERROR_CODE = 21040;
			//if(!required($data['AmountMoney']) || !numeric($data['AmountMoney'])) $this->_ERROR_CODE = 21039;
			if($this->_ERROR_CODE == 0)
			{
				$query = sprintf( "CALL sp_insertPaymentDetailWithoutConfirm ('%s','%s','%s','%s','%s','%s','%s')", $PaymentContractID, $MortageContractDetailID, $RaiseBlockedDate, $Quantity, $AmountMoney, $CreatedBy, $Today);
				//echo $query;
				$result = $this->_MDB2_WRITE->extended->getAll($query);

				if(empty($result) || is_object($result)){
					$this->_ERROR_CODE = 21003;
					write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
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
							}else {
								switch ($result[0]['varerror']) {
									case '0'://sucess
											$this->_ERROR_CODE = 0;
											break;
									case '-1'://invalid paymnetID
											$this->_ERROR_CODE = 21001;
											break;
									case '-2'://Invalid MortageContractDetailID
											$this->_ERROR_CODE = 21005;
											break;
									case '-3'://*Invalid PaymentContractID
											$this->_ERROR_CODE = 21001;
											break;
									case '-4'://Invalid PaymentTypeID
											$this->_ERROR_CODE = 21006;
											break;
									case '-5'://Money is not enoungh
									case '-7'://Money is not enoungh
											$this->_ERROR_CODE = 21021;
											break;
									case '-6'://*Invalid AccountID
											$this->_ERROR_CODE = 21022;
											break;
									case '-9998'://*Exception --insert paymentdetail
											$this->_ERROR_CODE = 21013;
											break;
									default://default
											$this->_ERROR_CODE = 22134;
											write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
											break;
								}
							}
						}
					}
			}

			if($this->_ERROR_CODE!=0)
				{
				//	echo 1;
					$this->_MDB2_WRITE->disconnect();
					$this->delPayment($PaymentContractID,$CreatedBy);
				}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}


	function rollbackupdatePayment($PaymentID,$UpdatedBy)
	{
		$mdbwrite2 = initWriteDB();

		$query1 = sprintf("CALL sp_rollbackupdatePayment (%s,'%s')", $PaymentID, $UpdatedBy);
		$result = $mdbwrite2->extended->getAll($query1);

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
		if(!required($data['PaymentDate'])||!valid_date($data['PaymentDate'])) return 21007;
		if(!required($data['TotalMoney']) || !numeric($data['TotalMoney']) || $data['TotalMoney']<20000000) return 21009;
		if(isset($data['CreatedBy']) &&!required($data['CreatedBy'])) return 21010;
		if(isset($data['UpdatedBy']) &&!required($data['UpdatedBy'])) return 21011;
		return 0;
	}
	/*-----------------------------------------END PAYMENT---------------------------------------------*/
	/**Function checkMoneyForPayment :
	 * Input :  'AccountID',$Money,$Today
	 * OutPut : array
	 */
	 function checkMoneyForPayment($AccountID,$Money,$Today) {
		$class_name = $this->class_name;
		$function_name = 'checkMoneyForPayment';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$this->_ERROR_CODE = $this->chkMoney($AccountID,$Money,$Today);
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 function chkMoney($AccountID,$Money,$Today)
	 {
	 	$query = sprintf( "select f_checkMoney('%s','%s','%s') as Amount",$AccountID,$Money,$Today);
		$result = $this->_MDB2->extended->getAll($query);
	    if( $result[0]['amount']<= 0)
			return 21021;
		else
			return 0;

	 }

	 function checkforapproveAdvancePape($AdvancePapaerID, $ApproveDate)
	 {
	 	$advanceinfo = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'ErrorCode' => '0','InvestorType'=>1,'BravoCode'=>0,'BranchName'=>'','Fee'=>0);
	 	$query = sprintf( "CALL sp_checkforconfirmedAdvancePaper ('%s','%s')", $AdvancePapaerID, $ApproveDate);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		write_my_log_path('ApproveAdvance-Log',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
		// Can not check
		if(empty($result) || is_object($result))	$advanceinfo['ErrorCode'] = 21041;
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					//Invalid AdvancePaper or Invalid Advance Money
					if($result[0]['varerror'] == -1){
						 $this->_ERROR_CODE = 20001;
					}else if($result[0]['varerror'] == -3){
						/*co it nhat 1 record trong advance_detail da het ngay t3*/
						 $this->_ERROR_CODE = 20023;
					}else if($result[0]['varerror'] == -9995) $this->_ERROR_CODE = 20019;
				}else{
					$advanceinfo['Amount']     = $result[0]['varamount'];
					$advanceinfo['AccountNo']  = $result[0]['varaccountno'];
					$advanceinfo['Note']       = $result[0]['varnote'];
					/*$advanceinfo['Fee'] = 0;//$result[0]['advancefee'];*/
          $advanceinfo['Fee']        = $result[0]['varadvancefee'];
					$advanceinfo['BravoCode']  = $result[0]['varbravocode'];
					$advanceinfo['BranchName'] = $result[0]['varbranchname'];
          $advanceinfo['OrderBankBravoCode']  = $result[0]['varorderbankbravocode'];

					if($advanceinfo['Amount'] == '' || $advanceinfo['Amount']<=0)
						$advanceinfo['ErrorCode'] = 20006;
				}
			}
		}
		return $advanceinfo;
	 }

	 function checkforapprovePayment($PaymentID, $ApproveDate)
	 {
	 	$payment = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'ErrorCode' => '0','InvestorType'=>1);
	 	$query = sprintf( "CALL sp_checkforconfirmedPayment ('%s','%s')", $PaymentID, $ApproveDate);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result))	$payment['ErrorCode'] = 20024;
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					switch ($result[0]['varerror']) {
						case '-2':/*invalid PaymentContractID*/
								$payment['ErrorCode'] = 21001;
								break;
						case '-3'://*invalid paymnet money or moneyleft for mortage contract less than 20000000*/
								$payment['ErrorCode'] = 21026;
								break;
						case '-4':/*payment da xac nhan*/
								$payment['ErrorCode'] = 21029;
								break;
						case '-5':/*invalid payment money*/
								$payment['ErrorCode'] = 21032;
								break;
						case '-6':/*invalid payment detail money*/
								$payment['ErrorCode'] = 21031;
								break;
						case '-7':/*invalid account_detail*/
								$payment['ErrorCode'] = 21032;
								break;
						case '-8':/*error insert money history*/
								$payment['ErrorCode'] = 21017;
								break;
						case '-9':/*error insert Stock Histoty*/
								$payment['ErrorCode'] = 21033;
								break;
						case '-11':/*Money is not enough*/
								$payment['ErrorCode'] = 21021;
								break;
						case '-8888'://Exception --approve payment
								$payment['ErrorCode'] = 21034;
								break;
						default://deafulr error
								$payment['ErrorCode'] = 21060;
								break;
					}
				}else{
					$payment['AccountNo'] = $result[0]['varaccountno'];
					$payment['Amount'] = $result[0]['varamount'];
					$payment['Note'] = $result[0]['varnote'];
					if($payment['Amount'] == '' || $payment['Amount']<=0)
						$payment['ErrorCode'] = 21009;
				}
			}
		}
		return $payment;
	 }

	function checkforapprovePaymentMoney($PaymentID, $ApproveDate)
	 {
	 	$payment = array('AccountNo'=>'0', 'Amount'=>0, 'Note'=>'', 'ErrorCode' => '0','InvestorType'=>1);
	 	$query = sprintf( "CALL sp_checkforconfirmedPaymentMoney ('%s','%s')", $PaymentID, $ApproveDate);
		//echo $query;
		$result = $this->_MDB2->extended->getAll($query);
		// Can not check
		if(empty($result))	$payment['ErrorCode'] = 21041;
		else
		{
			if(isset($result[0]['varerror']))
			{
				if($result[0]['varerror'] <0 ){
					switch ($result[0]['varerror']) {
						case '-2':/*invalid PaymentContractID*/
								$payment['ErrorCode'] = 21001;
								break;
						case '-3'://*invalid paymnet money or moneyleft for mortage contract less than 20000000*/
								$payment['ErrorCode'] = 21026;
								break;

						case '-4':/*payment da xac nhan*/
								$payment['ErrorCode'] = 21029;
								break;
						case '-5':/*invalid payment money*/
								$payment['ErrorCode'] = 21032;
								break;
						case '-6':/*invalid payment detail money*/
								$payment['ErrorCode'] = 21031;
								break;
						case '-7':/*invalid account_detail*/
								$payment['ErrorCode'] = 21032;
								break;
						case '-8':/*error insert money history*/
								$payment['ErrorCode'] = 21017;
								break;
						case '-9':/*error insert Stock Histoty*/
								$payment['ErrorCode'] = 21033;
								break;
						case '-11':/*Money is not enough*/
								$payment['ErrorCode'] = 21021;
								break;
						case '-8888'://Exception --approve payment
								$payment['ErrorCode'] = 21034;
								break;
						default://deafulr error
								$payment['ErrorCode'] = 21060;
								break;
					}
				}else{
					$payment['AccountNo'] = $result[0]['varaccountno'];
					$payment['Amount'] = $result[0]['varamount'];
					$payment['Note'] = $result[0]['varnote'];
					if($payment['Amount'] == '' || $payment['Amount']<=0)
						$payment['ErrorCode'] = 21009;
				}
			}
		}
		return $payment;
	 }

	 /**
	 * Function UpdateDividendPrivilege	: delete a UpdateDividendPrivilege
	 * Input 					: 'DividentPrivilegeID', 'NewRetailStockQtty', 'NormalPrivilegeQtty', 'UpdatedBy'
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function UpdateAdvancePaper_IsEPSFee($AccountID, $ContractNo, $UpdatedBy, $Today)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'UpdateAdvancePaper_IsEPSFee';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			if($ContractNo=='')
			{
				//Invalid ContractNo
				$this->_ERROR_CODE = 22113;
			}

			if($this->_ERROR_CODE == 0)
			{
				// money in bank
				$query = sprintf( "SELECT BankID, BankAccount,AccountNo FROM vw_ListAccountBank_Detail WHERE AccountID='%s' ORDER BY Priority ", $AccountID);
				$bank_rs = $this->_MDB2->extended->getAll($query);
				$dab_rs = 999;
				$BankID = 0;
				$TransactionType = BRAVO_ADVANCE_EPSFEE_C;// EPS thu phi quan ly hop dong ung truoc
				$AccountNo =  $bank_rs[0]['accountno']?$bank_rs[0]['accountno']:'';
				if ( $bank_rs[0]['accountno'] != PAGODA_ACCOUNT ) {
					for($i=0; $i<count($bank_rs); $i++) {
						$BankID = $bank_rs[$i]['bankid'];
						switch ($BankID) {
							case DAB_ID:
								$dab = &new CDAB();
								$dab_rs = $dab->transfertoEPS($bank_rs[$i]['bankaccount'], $bank_rs[$i]['accountno'],'4_'.$ContractNo.'_'.$AccountID, ADVANCE_IPSFEE, "Thu phi quan ly hop dong ung truoc ".$ContractNo);
								write_my_log_path('transfertoEPS',$function_name.' BankAccount '.$bank_rs[$i]['bankaccount'].'  AccountNo '.$bank_rs['AccountNo'].'  Event_AccountID '.'4_'.$ContractNo.'_'.$AccountID.'  Amount '.ADVANCE_IPSFEE.' Error '.$dab_rs,EVENT_PATH);
								break;
							default:
								$dab_rs = 0;

						}

						if ($dab_rs == 0){
							break;
						}
					}
					if($dab_rs == 0){
						$soap = &new Bravo();
						$Withdrawal_value = array("TradingDate" => $Today, 'TransactionType'=>$TransactionType, "AccountNo" =>  $AccountNo, "Amount" => ADVANCE_IPSFEE, "Bank"=> $BankID, "Branch"=> "", "Note" => "Thu phi quan ly hop dong ung truoc".$ContractNo); //'011C001458'
						$ret = $soap->withdraw($Withdrawal_value);
						if($ret['table0']['Result']==1){
							$query = sprintf( "CALL sp_UpdateAdvancePaper_IsEPSFee ('%s','%s')", $ContractNo, $UpdatedBy);
							//echo $query;
							$result = $this->_MDB2_WRITE->extended->getAll($query);
							//Can not update
							if(empty($result) || is_object($result)){
								$this->_ERROR_CODE = 20052;
								write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
							}else{
								if(isset($result[0]['varerror']))
								{
									if($result[0]['varerror']<0){
										switch ($result[0]['varerror']) {
											case '0'://sucess
													$this->_ERROR_CODE = 0;
													break;
											case '-1'://exception
													$this->_ERROR_CODE = 20049;
													break;

											case '-2'://Invalid ContractNo
													$this->_ERROR_CODE = 20050;
													break;

											default://deafulr error
													$this->_ERROR_CODE = 20051;
													break;
										}//switch
									}

								}// end if isset($result[0]['varerror']
								if($this->_ERROR_CODE!=0){
									$soap->rollback($ret['table1']['Id'], $Today);
								}
							}
						}else{// end if $ret['table0']['Result']
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
										write_my_log_path($function_name,'  Bravo '.$ret['table0']['Result'],ADVANCE_PATH);
										break;
								}

							}// end if $ret['table0']['Result']
					}else{//end if($dab_rs == 0){
						switch ($dab_rs) {
							case '-1'://unauthenticate partner
								$this->_ERROR_CODE = 22120;
								break;

							case '-2'://invalid parameters
								$this->_ERROR_CODE = 22121;
								break;

							case '-3'://invalid date
								$this->_ERROR_CODE = 22122;
								break;

							case '-4'://no customer found
								$this->_ERROR_CODE = 22123;
								break;

							case '-5'://transfer unsuccessful
								$this->_ERROR_CODE = 22124;
								break;

							case '1'://invalid account
								$this->_ERROR_CODE = 22126;
								break;

							case '2'://invalid amount
								$this->_ERROR_CODE = 22127;
								break;
							case '3'://duplicate transfer
								$this->_ERROR_CODE = 22147;
								break;
							case '5'://not enough balance
								$this->_ERROR_CODE = 22128;
								break;

							case '6'://duplicate account
								$this->_ERROR_CODE = 22129;
								break;

							case '99':
								$this->_ERROR_CODE = 22130;
								break;

							default:
								$this->_ERROR_CODE = $dab_rs;
						}//end switch
					}// end if($dab_rs == 0){
				}// end if ( $bank_rs[0]['accountno'] != PAGODA_ACCOUNT ) {
			}	// end	if($this->_ERROR_CODE == 0)
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function ListAdvancePaper_FromDAB	: ListAdvancePaper_FromDAB
	 * Input 					: ContractStatus, $FromDate, $ToDate
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function ListAdvancePaper_FromDAB($ContractStatus, $FromDate, $ToDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'ListAdvancePaper_FromDAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			$dab = &new CDAB();
			$dab_rs = $dab->getAdvanceInfo($ContractStatus, $FromDate, $ToDate);
			$Array_err = array("-1","-2","-3","0","1","99");
			if(in_array($dab_rs,$Array_err))
			{
				switch ($dab_rs) {
					case '0'://sucess
							$this->_ERROR_CODE = 0;
							break;
					case '-1'://unauthenticate partner
							$this->_ERROR_CODE = 20053;
							break;

					case '-2'://Iinvalid parameters
							$this->_ERROR_CODE = 20054;
							break;
					case '-3'://invalid date
							$this->_ERROR_CODE = 20055;
							break;
					case '99'://unknown error
							$this->_ERROR_CODE = 20056;
							break;
					default://deafulr error
							$this->_ERROR_CODE = 20057;
							break;
				}
			}else{
				$dab_rs = str_replace("<!DOCTYPE AllSelAdvance SYSTEM \"users.dtd\">", "", $dab_rs);
				$this->items[0] = new SOAP_Value(
					'items',
					'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'ListContract'  => new SOAP_Value("ListContract", "string", $dab_rs)
							)
					);
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function CancelSellAdvance_DAB	: CancelSellAdvance_DAB
	 * Input 					: $DABBankAccount, $AccountNo, $ContractNo
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function CancelSellAdvance_DAB($DABBankAccount, $AccountNo, $ContractNo,$CancelDate)
	{
		try{
			$class_name = $this->class_name;
			$function_name = 'CancelSellAdvance_DAB';

			if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
			if(!required($DABBankAccount)) $this->_ERROR_CODE = 20066;
			else if(!required($AccountNo)) $this->_ERROR_CODE = 20067;
			else if(!required($ContractNo)) $this->_ERROR_CODE = 20068;
			if($this->_ERROR_CODE == 0){
				$dab = &new CDAB();
				$dab_rs = $dab->cancelsellAdvance($DABBankAccount, $AccountNo, $ContractNo);
				switch ($dab_rs) {
					case '0'://sucess
							$this->_ERROR_CODE = 0;
							break;
					case '-1'://unauthenticate partner
							$this->_ERROR_CODE = 20053;
							break;

					case '-2'://Iinvalid parameters
							$this->_ERROR_CODE = 20054;
							break;
					case '-3'://no contract found or invalid contract
							$this->_ERROR_CODE = 20064;
							break;
					case '-1'://cancel sell unsuccessful
							$this->_ERROR_CODE = 20065;
							break;
					case '99'://unknown error
							$this->_ERROR_CODE = 20056;
							break;
					default://deafulr error
							$this->_ERROR_CODE = 20057;
							break;
				}
				/*if($this->_ERROR_CODE==0)
				{
					$query = sprintf("CALL sp_DeleteAdvancePaper_DAB ('%s','%s','%s')", $ContractNo, $CancelDate, $CreatedBy);
					$this->_MDB2_WRITE->disconnect();
					$this->_MDB2_WRITE->connect();
					$result = $this->_MDB2_WRITE->extended->getAll($query);
					//Can not delete
					if(empty($result) || is_object($result)){
						$this->_ERROR_CODE = 20061;
						write_my_log_path('ErrorCallStore',$query.'  '.$result->backtrace[0]['args'][4],ADVANCE_PATH);
					}
					else{
						if(isset($result[0]['varerror']))
						{
							//Invalid AdvancePaper
							if($result[0]['varerror'] == -1){
								 $this->_ERROR_CODE = 20001;
							}else if($result[0]['varerror'] == -3){
								//error when call sp_insertMoneyHistory
								 $this->_ERROR_CODE = 20062;
							}else if($result[0]['varerror'] == -9999){
								 $this->_ERROR_CODE = 20063;
							}else if($result[0]['varerror']<0){
								$this->_ERROR_CODE = 22134;
								write_my_log_path($function_name,$query.'  VarError '.$result[0]['varerror'],ADVANCE_PATH);
							}

						}
					}
				}
				*/
			}
		}catch(Exception $e){
			write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
			$this->_ERROR_CODE = 23022;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

		/**
	 * Function CancelSellAdvance_DAB	: CancelSellAdvance_DAB
	 * Input 					: $DABBankAccount, $AccountNo, $ContractNo
	 * OutPut 					: error code. Return 0 if success else return error code (number >0).
	 */
	function ANZ_money_import($AccountNo, $Money, $UpdatedBy)
	{
	 	$class_name = $this->class_name;
		$function_name = 'ANZ_money_import';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	 	$query = sprintf( "CALL sp_anz_money_import( '%s', '%s', '%s' )", $AccountNo, $Money, $UpdatedBy);
		$rs1 = $this->_MDB2_WRITE->extended->getRow($query);
		$this->_MDB2_WRITE->disconnect();
		switch ($rs1['varerror']){
			case -1:
				$this->_ERROR_CODE = 34511;//database error
				break;
			case -2:
				$this->_ERROR_CODE = 34513;//account does not exist
				break;
			default:
				$this->_ERROR_CODE = $rs1['varerror'];
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function getAdvanceFee
	 */
	function getAdvanceFee($BankID)	{
		$function_name = 'getAdvanceFee';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	 	$query = sprintf( "SELECT f_advance_getAdvanceFee(%u) AS AdvanceFee", $BankID);
		$rs = $this->_MDB2->extended->getRow($query);
		$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"AdvanceFee"    => new SOAP_Value( "AdvanceFee", "string", $rs['advancefee'] )
						)
				);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function updateConfirmable
	 */
	function updateConfirmable($AdvancePaperID)	{
		$function_name = 'updateConfirmable';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	 	$query = sprintf( "CALL sp_AdvancePaper_updateCanConfirmField(%u)", $AdvancePaperID );
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 function getAvailableBalanceAdvance() {
		$class_name = $this->class_name;
		$function_name = 'getAvailableBalanceAdvance';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$dab = &new CDAB();
		$result = $dab->getAvailableBalanceAdvance();
		switch($result) {
			case '-1':
				$this->_ERROR_CODE = 41080;
				break;

			case '99':
				$this->_ERROR_CODE = 41084;
				break;
			default:
				$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Room"    => new SOAP_Value( "Room", "string", $result)
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	 }

   function getAdvanceFee_getInfo($BankID)
   {
   	try{
      $class_name = $this->class_name;
      $function_name = 'getAdvanceFee_getInfo';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      $this->items = array();
      $query = sprintf("CALL sp_AdvanceFee_getInfo('%s')", $BankID);

      $result = $this->_MDB2->extended->getAll($query);
      $num_row = count($result);
      if($num_row>0)
      {
        for($i=0; $i<$num_row; $i++) {
          $this->items[$i] = new SOAP_Value(
              'items',
              '{urn:'. $class_name .'}'.$function_name.'Struct',
              array(
                'Rate'              => new SOAP_Value("Rate", "string", $result[$i]['rate']),
                'RateForBank'       => new SOAP_Value("RateForBank", "string", $result[$i]['rateforbank']),
                'RateForEPS'        => new SOAP_Value("RateForEPS", "string", $result[$i]['rateforeps']),
                'MinAdvCommission ' => new SOAP_Value("MinAdvCommission", "string", $result[$i]['minadvcommission']),
                'MinAmountAdvance'  => new SOAP_Value("MinAmountAdvance", "string", $result[$i]['minamountadvance']),
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

   function getAdvanceAmountforBankAndDate($AdvanceDate, $TDate, $BankID){
    try{
      $class_name = $this->class_name;
      $function_name = 'getAdvanceAmountforBankAndDate';

      if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
      $this->items = array();
      $query = sprintf("CALL sp_getAdvanceAmountforBankAndDate('%s','%s','%s')", $AdvanceDate, $TDate, $BankID);

      $result = $this->_MDB2->extended->getAll($query);
      $num_row = count($result);
      if($num_row>0)
      {
        for($i=0; $i<$num_row; $i++) {
          $this->items[$i] = new SOAP_Value(
              'items',
              '{urn:'. $class_name .'}'.$function_name.'Struct',
              array(
                'AdvanceAmount'     => new SOAP_Value("AdvanceAmount", "string", $result[$i]['advanceamount']),
                'Numday'            => new SOAP_Value("Numday", "string", $result[$i]['numday']),
                'Val'               => new SOAP_Value("Val", "string", $result[$i]['val']),
                )
            );
        }
      }
    } catch(Exception $e) {
      write_my_log_path('PHP-Exception',$function_name.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),DEBUG_PATH);
      $this->_ERROR_CODE = 23022;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
   }
}

?>
