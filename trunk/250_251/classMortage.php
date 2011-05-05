<?php
require_once('../includes.php');

/**
	Author: Ly Duong Duy Trung
	Created date: 04/23/2007
*/
class CMortage extends WS_Class{
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
							'insertMortageContract' => array( 'input' => array( 'ContractNo', 'BankID', 'AccountNo', 'IsAssigner', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'updateMortageContract' => array( 'input' => array( 'MortageContractID', 'BankID', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'UpdatedBy' ),
											'output' => array()),

							'updateDateInMortageContract' => array( 'input' => array( 'MortageContractID', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'UpdatedBy' ),
											'output' => array()),

							'insertStockSupplement' => array( 'input' => array( 'MortageContractID', 'TotalMoney', 'SupplementDate', 'Note', 'lstMoneyDown', 'lstMortageContractDetailID', 'CreatedBy' ),
											'output' => array( 'ID' )),

							/*'updateStockSupplement' => array( 'input' => array( 'StockSupplementID', 'MortageContractID', 'TotalMoney', 'SupplementDate', 'Note', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array()),*/

							'insertStockSupplementDetail' => array( 'input' => array( 'StockSupplementID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'CreatedBy' ),
											'output' => array( 'ID' )),

							/*'updateStockSupplementDetail' => array( 'input' => array( 'StockSupplementID', 'MortageContractID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'MoneyDown', 'Note', 'UpdatedBy' ),
											'output' => array()),*/

							'insertMoneySupplement' => array( 'input' => array( 'MortageContractID', 'AmountMoney', 'lstMoneyDown', 'lstMortageContractDetailID', 'Note', 'CreatedBy' ),
											'output' => array( 'ID' )),

							/*'updateMoneySupplement' => array( 'input' => array( 'MoneySupplementID', 'MortageContractID', 'AmountMoney', 'Note', 'UpdatedBy' ),
											'output' => array()),*/

							'insertMortageContractDetail' => array( 'input' => array( 'MortageContractID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'CreatedBy' ),
											'output' => array( 'ID' )),

							'updateMoney' => array( 'input' => array( 'MortageContractID', 'UpdatedBy' ),
											'output' => array( )),

							'updateStock' => array( 'input' => array( 'MortageContractID', 'UpdatedBy' ),
											'output' => array( )),

							'approveStockSupplement' => array( 'input' => array( 'StockSupplementID', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array( )),

							'approveMoneySupplement' => array( 'input' => array( 'MoneySupplementID', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array( )),

							/*'approveSupplement' => array( 'input' => array( 'MortageContractID', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array( )),*/

							'returnStockSupplement' => array( 'input' => array( 'StockSupplementID', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array( )),

							'returnMoneySupplement' => array( 'input' => array( 'MoneySupplementID', 'lstMoneyDown', 'lstMortageContractDetailID', 'UpdatedBy' ),
											'output' => array( )),

							'listMortageContracts' => array( 'input' => array( 'TimeZone'),
											'output' => array('MortageContractID', 'ContractNo', 'BankID', 'BankName', 'AccountID', 'AccountNo', 'FullName', 'IsAssigner', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'ContractStatus', 'Released', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listMortageContractsWithFilter' => array( 'input' => array( 'Condition', 'TimeZone' ),
											'output' => array('MortageContractID', 'ContractNo', 'BankID', 'BankName', 'AccountID', 'AccountNo', 'FullName', 'IsAssigner', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'ContractStatus', 'Released', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listMortageContractsOwnSupplement' => array( 'input' => array( 'TimeZone'),
											'output' => array('MortageContractID', 'ContractNo', 'BankID', 'BankName', 'AccountID', 'AccountNo', 'FullName', 'IsAssigner', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'ContractStatus', 'Released', 'MoneySupplementAmount', 'StockSupplementAmount', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listMortageContractsOwnSupplementWithFilter' => array( 'input' => array( 'Condition', 'TimeZone' ),
											'output' => array('MortageContractID', 'ContractNo', 'BankID', 'BankName', 'AccountID', 'AccountNo', 'FullName', 'IsAssigner', 'LoanInterestRate', 'OverdueInterestRate', 'LoanPeriod', 'ContractValue', 'ContractDate', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'ContractStatus', 'Released', 'MoneySupplementAmount', 'StockSupplementAmount', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listAvailStocks' => array( 'input' => array( 'AccountID' ),
											'output' => array('StockID', 'Quantity', 'Symbol', 'ParValue' )),

							'listAvailStocksWhenEdit' => array( 'input' => array( 'MortageContractID', 'AccountID' ),
											'output' => array('StockID', 'Quantity', 'Symbol', 'ParValue' )),

							'listStockSupplement' => array( 'input' => array( 'TimeZone'),
											'output' => array('StockSupplementID', 'MortageContractID', 'TotalMoney', 'SupplementDate', 'Note', 'IsConfirmed', 'lstMoneyDown', 'lstMortageContractDetailID', 'BankID', 'ContractNo', 'AccountID', 'ContractValue', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listStockSupplementWithFilter' => array( 'input' => array( 'Condition', 'TimeZone'),
											'output' => array('StockSupplementID', 'MortageContractID', 'TotalMoney', 'SupplementDate', 'Note', 'IsConfirmed', 'lstMoneyDown', 'lstMortageContractDetailID', 'BankID', 'ContractNo', 'AccountID', 'ContractValue', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listMoneySupplement' => array( 'input' => array( 'TimeZone'),
											'output' => array('MoneySupplementID', 'MortageContractID', 'AmountMoney', 'SupplementDate', 'lstMoneyDown', 'lstMortageContractDetailID', 'Note', 'IsConfirmed', 'ContractNo', 'BankID', 'AccountID', 'ContractValue', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listMoneySupplementWithFilter' => array( 'input' => array( 'Condition', 'TimeZone'),
											'output' => array('MoneySupplementID', 'MortageContractID', 'AmountMoney', 'SupplementDate', 'lstMoneyDown', 'lstMortageContractDetailID', 'Note', 'IsConfirmed', 'ContractNo', 'BankID', 'AccountID', 'ContractValue', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listStockAndMoneySupplement' => array( 'input' => array( 'TimeZone'),
											'output' => array( 'MortageContractID', 'MoneySupplement', 'SupplementDate', 'lstMoneyDown', 'lstMortageContractDetailID', 'Note', 'IsConfirmed', 'StockSupplementMoney', 'ContractNo', 'BankID', 'AccountID', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'listStockAndMoneySupplementWithFilter' => array( 'input' => array( 'Condition', 'TimeZone'),
											'output' => array( 'MortageContractID', 'MoneySupplement', 'SupplementDate', 'lstMoneyDown', 'lstMortageContractDetailID', 'Note', 'IsConfirmed', 'StockSupplementMoney', 'ContractNo', 'BankID', 'AccountID', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

							'getMortageContractDetails' => array( 'input' => array( 'MortageContractID' ),
											'output' => array( 'MortageContractDetailID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'Symbol', 'MoneyDown' )),

							'getStockSupplementDetails' => array( 'input' => array( 'StockSupplementID' ),
											'output' => array( 'StockSupplementDetailID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'Symbol' )),

							'deleteMortageContract' => array( 'input' => array( 'MortageContractID', 'UpdatedBy'),
											'output' => array( )),

							'deleteUnPaidMortageContract' => array( 'input' => array( 'MortageContractID', 'UpdatedBy'),
											'output' => array( )),

							'deleteStockSupplement' => array( 'input' => array( 'StockSupplementID', 'UpdatedBy'),
											'output' => array( )),

							'deleteMoneySupplement' => array( 'input' => array( 'MoneySupplementID', 'UpdatedBy'),
											'output' => array( )),

							'checkContractNo' => array( 'input' => array( 'ContractNo' ),
											'output' => array( 'MortageContractID' )),

							'updateNormalWhenMortage' => array( 'input' => array( 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'UpdatedBy' ),
											'output' => array( )),

							'insertMortageWithoutConfirmed' => array( 'input' => array( 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'CreatedBy', 'BankID' ),
											'output' => array( 'ID' )),

							'updateMortageWithoutConfirmed' => array( 'input' => array( 'MortageHistoryID', 'Quantity', 'UpdatedBy', 'BankID' ),
											'output' => array( )),

							'deleteMortageWithoutConfirmed' => array( 'input' => array( 'MortageHistoryID', 'UpdatedBy' ),
											'output' => array( )),

							'getMortageHistoryList' => array( 'input' => array( 'AccountNo', 'FromDate', 'ToDate', 'IsConfirmed' ),
											'output' => array( 'ID', 'AccountNo', 'Symbol', 'Quantity', 'MortageDate', 'IsConfirmed', 'ShortName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'BankID', 'StockExchangeID' )),

							'confirmMortageHistory' => array( 'input' => array( 'MortageHistoryID', 'UpdatedBy' ),
											'output' => array( )),

							'confirmMortageHistory' => array( 'input' => array( 'MortageHistoryID', 'UpdatedBy' ),
											'output' => array( )),

							'NewInsertMortageContract' => array( 'input' => array( 'ContractNo', 'AccountNo', 'Amount', 'PercentRate', 'BankID', 'MortageDate', 'Note', 'CreatedBy', 'EndDate' ),
											'output' => array( 'ID' )),

							'NewUpdateMortageContract' => array( 'input' => array( 'ID', 'ContractNo', 'Amount', 'PercentRate', 'BankID', 'MortageDate', 'Note', 'UpdatedBy', 'EndDate' ),
											'output' => array( )),

							'NewDeleteMortageContract' => array( 'input' => array( 'MortageContractID', 'UpdatedBy'),
											'output' => array( )),

							'NewInsertMortageDetailWithoutConfirmed' => array( 'input' => array( 'MortageID', 'AccountNo', 'Symbol', 'Quantity', 'TradingDate', 'CreatedBy', 'Note', 'Price' ),
											'output' => array( 'ID' )),

							'NewUpdateMortageDetailWithoutConfirmed' => array( 'input' => array( 'MortageDeatailID', 'Quantity', 'UpdatedBy', 'Note', 'Price' ),
											'output' => array( )),

							'NewDeleteMortageDetailWithoutConfirmed' => array( 'input' => array( 'MortageContractID', 'UpdatedBy'),
											'output' => array( )),

							'NewConfirmMortage' => array( 'input' => array( 'MortageContractID', 'UpdatedBy'),
											'output' => array( )),

							'NewGetMortageList' => array( 'input' => array( 'FromDate', 'ToDate', 'AccountNo', 'ContractNo', 'IsConfirmed', 'CreatedBy' ),
											'output' => array( 'ID', 'ContractNo', 'AccountID', 'AccountNo', 'FullName', 'Amount', 'PercentRate', 'BankID', 'ShortName', 'MortageDate', 'Note', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'ReleaseDate', 'EndDate' )),

							'NewGetMortageDetailList' => array( 'input' => array( 'MortageID' ),
											'output' => array( 'ID', 'StockID', 'Symbol', 'Quantity', 'DetailDate', 'Note', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'Price' )),

							'NewConfirmMortageDetail' => array( 'input' => array( 'MortageDetailID', 'UpdatedBy' ),
											'output' => array( )),

							'NewGetMortageWithConditionList' => array( 'input' => array( 'WhereClause', 'TimeZone' ),
											'output' => array( 'ID', 'ContractNo', 'AccountID', 'AccountNo', 'FullName', 'Amount', 'PercentRate', 'BankID', 'ShortName', 'MortageDate', 'Note', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate', 'ReleaseDate', 'EndDate' )),

							'getMortageDetailQuantityWithoutConfirmed' => array( 'input' => array( 'AccountID', 'StockID' ),
											'output' => array( 'Quantity' )),

							'getTotalQuantityCanBeMortaged' => array( 'input' => array( 'AccountID', 'StockID', 'TradingDate' ),
											'output' => array( 'Quantity' )),

							'getAmountCollect' => array( 'input' => array( 'ContractNo' ),
											'output' => array( 'MortageID', 'Amount', 'AmountCollect' )),

							'getMortageInfo' => array( 'input' => array( 'ContractNo' ),
											'output' => array( 'MortageID', 'ContractNo', 'AccountNo', 'AccountID', 'MortageDate', 'ReleaseDate', 'EndDate', 'PercentRate', 'Amount', 'BankID', 'ShortName', 'Note', 'AmountCollect' )),

							'insertDisbursement' => array( 'input' => array( 'AccountID', 'Amount', 'Note', 'CreatedBy', 'TypeID', 'BankID' ),
											'output' => array( 'ID' )),

							'confirmDisbursement' => array( 'input' => array( 'DisbursementID', 'AccountNo', 'Amount', 'Note', 'UpdatedBy', 'BankID' ),
											'output' => array()),

							'confirmDisbursementForOddStock' => array( 'input' => array( 'DisbursementID', 'AccountNo', 'Amount', 'Note', 'UpdatedBy', 'BankID' ),
											'output' => array()),

							'getDisbursement' => array( 'input' => array( 'AccountNo', 'CreatedBy', 'FromDate', 'ToDate', 'BankID' ),
											'output' => array( 'ID', 'AccountNo', 'Amount', 'Note', 'IsExec', 'IsBravo', 'CreatedDate', 'CreatedBy', 'TypeID', 'FullName', 'BankID', 'BankName')),

							'deleteDisbursement' => array( 'input' => array( 'DisbursementID', 'UpdatedBy' ),
											'output' => array( )),

              'InsertExtraCollectDisbursement' => array( 'input' => array( 'AccountID', 'Amount', 'BankID', 'TradingDate', 'Note', 'TranTypeID', 'CreatedBy' ),
                      'output' => array( 'ID' )),

              'DeleteExtraCollectDisbursement' => array( 'input' => array( 'ID', 'UpdatedBy' ),
                      'output' => array()),

              'GetListExtraCollectDisbursement' => array( 'input' => array( 'FromDate', 'ToDate', 'TranTypeID', 'IsConfirmed', 'AccountNo', 'BankID' ),
                      'output' => array( 'ID', 'AccountID', 'AccountNo', 'FullName', 'Amount', 'BankAccount', 'BankID', 'ShortName', 'TradingDate', 'Note', 'TranTypeID', 'IsConfirmed', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate' )),

              'ConfirmExtraCollectDisbursement' => array( 'input' => array( 'ID', 'UpdatedBy' ),
                      'output' => array()),

						);

		parent::__construct($arr);
	}

	function __destruct() {
		$this->_MDB2->disconnect();
		$this->_MDB2_WRITE->disconnect();
	}

	/**
		Function: insertMortageContract
		Description: update a Buy order
		Input: $ContractNo, $BankID, $AccountID, $IsAssigner, $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $CreatedBy
		Output: success / error code
	*/
	function insertMortageContract($ContractNo, $BankID, $AccountNo, $IsAssigner='0', $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $CreatedBy) {
		$function_name = 'insertMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ContractNo) || !required($BankID) || !unsigned($BankID) || !required($AccountNo) || !required($LoanInterestRate) || !unsigned($LoanInterestRate)
				|| !required($OverdueInterestRate) || !unsigned($OverdueInterestRate) || !required($LoanPeriod) || !unsigned($LoanPeriod)
				|| !required($ContractValue) || !unsigned($ContractValue) || !required(MatureDate)
				|| !required($ContractDate) || !required($ReleaseDate) || !required($BlockedDate) || !required($SendDate)) {

			if ( !required($ContractNo) )
				$this->_ERROR_CODE = 31000;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 31001;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 31002;

			if ( !required($LoanInterestRate) || !unsigned($LoanInterestRate) )
				$this->_ERROR_CODE = 31003;

			if ( !required($OverdueInterestRate) || !unsigned($OverdueInterestRate) )
				$this->_ERROR_CODE = 31004;

			if ( !required($LoanPeriod) || !unsigned($LoanPeriod) )
				$this->_ERROR_CODE = 31005;

			if ( !required($ContractValue) || !unsigned($ContractValue) )
				$this->_ERROR_CODE = 31007;

			if ( !required($ContractDate) )
				$this->_ERROR_CODE = 31008;

			if ( !required($ReleaseDate) )
				$this->_ERROR_CODE = 31009;

			if ( !required($BlockedDate) )
				$this->_ERROR_CODE = 31010;

			if ( !required($SendDate) )
				$this->_ERROR_CODE = 31011;

			if ( !required($MatureDate) )
				$this->_ERROR_CODE = 31018;
		} else {
			$query = sprintf( "CALL sp_insertMortgageContract('%s', %u, '%s', '%u', %f, %f, %u, %f, '%s', '%s', '%s', '%s', '%s', '%s')",
							$ContractNo, $BankID, $AccountNo, $IsAssigner, $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31012;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31013;
							break;

						case '-2':
							$this->_ERROR_CODE = 31014;
							break;

						case '-3':
							$this->_ERROR_CODE = 31015;
							break;

						case '-4':
							$this->_ERROR_CODE = 31016;
							break;

						case '-5':
							$this->_ERROR_CODE = 31017;
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
		Function: updateMortageContract
		Description: update a Buy order
		Input: $MortageContractID, $ContractNo, $BankID, $AccountID, $IsAssigner, $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $CreatedBy
		Output: success / error code
	*/
	function updateMortageContract($MortageContractID, $BankID, $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $UpdatedBy) {
		$function_name = 'updateMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($BankID) || !unsigned($BankID) || !required($LoanInterestRate) || !unsigned($LoanInterestRate) || !required($MortageContractID) || !unsigned($MortageContractID)
				|| !required($OverdueInterestRate) || !unsigned($OverdueInterestRate) || !required($LoanPeriod) || !unsigned($LoanPeriod)
				|| !required(MatureDate) || !required($ContractDate) || !required($ReleaseDate) || !required($BlockedDate) || !required($SendDate)) {

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31100;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 31090;

			if ( !required($LoanInterestRate) || !unsigned($LoanInterestRate) )
				$this->_ERROR_CODE = 31091;

			if ( !required($OverdueInterestRate) || !unsigned($OverdueInterestRate) )
				$this->_ERROR_CODE = 31092;

			if ( !required($LoanPeriod) || !unsigned($LoanPeriod) )
				$this->_ERROR_CODE = 31093;

			if ( !required($ContractDate) )
				$this->_ERROR_CODE = 31094;

			if ( !required($ReleaseDate) )
				$this->_ERROR_CODE = 31095;

			if ( !required($BlockedDate) )
				$this->_ERROR_CODE = 31096;

			if ( !required($SendDate) )
				$this->_ERROR_CODE = 31097;

			if ( !required($MatureDate) )
				$this->_ERROR_CODE = 31098;
		} else {
			$query = sprintf( "CALL sp_updateMortgageContract(%u, %u, %f, %f, %u, %u, '%s', '%s', '%s', '%s', '%s', '%s')",
							$MortageContractID, $BankID, $LoanInterestRate, $OverdueInterestRate, $LoanPeriod, $ContractValue, $ContractDate, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31099;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31101;
							break;

						case '-2':
							$this->_ERROR_CODE = 31102;
							break;

						case '-3':
							$this->_ERROR_CODE = 31103;
							break;

						case '-4':
							$this->_ERROR_CODE = 31104;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateDateInMortageContract
		Description: update a Buy order
		Input: 'MortageContractID', 'ReleaseDate', 'BlockedDate', 'SendDate', 'MatureDate', 'UpdatedBy'
		Output: success / error code
	*/
	function updateDateInMortageContract($MortageContractID, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $UpdatedBy) {
		$function_name = 'updateDateInMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID)
				|| !required(MatureDate) || !required($ReleaseDate) || !required($BlockedDate) || !required($SendDate)) {

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31230;

			if ( !required($ReleaseDate) )
				$this->_ERROR_CODE = 31231;

			if ( !required($BlockedDate) )
				$this->_ERROR_CODE = 31232;

			if ( !required($SendDate) )
				$this->_ERROR_CODE = 31233;

			if ( !required($MatureDate) )
				$this->_ERROR_CODE = 31234;
		} else {
			$query = sprintf( "CALL sp_updateDateInMortgageContract(%u, '%s', '%s', '%s', '%s', '%s')",
							$MortageContractID, $ReleaseDate, $BlockedDate, $SendDate, $MatureDate, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31235;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31236;
							break;

						case '-2':
							$this->_ERROR_CODE = 31237;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertMortageContractDetail
		Description: update a Buy order
		Input: $MortageContractID, $StockID, $Quantity, $MarketPrice, $LoanMoney, $CreatedBy
		Output: success / error code
	*/
	function insertMortageContractDetail($MortageContractID, $StockID, $Quantity, $PercentRate, $MarketPrice, $LoanMoney, $CreatedBy) {
		$function_name = 'insertMortageContractDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) || !required($StockID) || !unsigned($StockID)
				|| !required($Quantity) || !unsigned($Quantity) || !required($MarketPrice) || !unsigned($MarketPrice)
				|| !required($LoanMoney) || !unsigned($LoanMoney) || !required($PercentRate) || !unsigned($PercentRate)) {

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31030;

			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 31031;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31032;

			if ( !required($MarketPrice) || !unsigned($MarketPrice) )
				$this->_ERROR_CODE = 31033;

			if ( !required($LoanMoney) || !unsigned($LoanMoney) )
				$this->_ERROR_CODE = 31034;

			if ( !required($PercentRate) || !unsigned($PercentRate) )
				$this->_ERROR_CODE = 31006;

		} else {
			$query = sprintf( "CALL sp_insertMortgageContractDetail(%u, %u, %u, %f, %u, %f, '%s')",
							$MortageContractID, $StockID, $Quantity, $PercentRate, $MarketPrice, $LoanMoney, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31035;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31036;
							break;

						case '-2':
							$this->_ERROR_CODE = 31037;
							break;

						case '-3':
							$this->_ERROR_CODE = 31038;
							break;

						case '-4':
							$this->_ERROR_CODE = 31039;
							break;
					}
					/*// ROLLBACK
					$query = sprintf( "CALL sp_deleteFailMortageContract(%u)", $MortageContractID );
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
					if (empty( $rs)) {
						$this->_ERROR_CODE = 31040;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) // ROLLBACK Fail
							$this->_ERROR_CODE = 31041;
					}*/
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
		Function: updateMoney
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function updateMoney($MortageContractID, $UpdatedBy) {
		$function_name = 'updateMoney';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31050;

		} else {
			$query = sprintf( "SELECT AccountNo, ContractValue
								FROM %s, %s
								WHERE %s.ID=%u
								AND %s.ContractStatus='UnPaid'
								AND %s.Released='0'
								AND %s.Deleted='0'
								AND %s.AccountID = %s.ID ",
							TBL_MORTGAGE_CONTRACT, TBL_ACCOUNT,
							TBL_MORTGAGE_CONTRACT, $MortageContractID,
							TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT,
							TBL_MORTGAGE_CONTRACT, TBL_ACCOUNT );
			$result = $this->_MDB2->extended->getRow($query);

			if ($result['contractvalue'] > 0) {
				$bravo_service = &new Bravo();
				$date = date("Y-m-d");
				$arrDeposit = array("TradingDate" => $date,
									"AccountNo" => $result['accountno'],
									"Amount" => $result['contractvalue'],
									"Note" => "Tien cam co Chung khoan");
				$bravo_result = $bravo_service->deposit($arrDeposit );
				if ($bravo_result['table0']['Result']==1) {

					$query = sprintf( "CALL sp_updateMoneyWhenMortage(%u, '%s')",
									$MortageContractID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)) {
						$this->_ERROR_CODE = 31051;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 31052;
									break;

								case '-2':
									$this->_ERROR_CODE = 31053;
									break;

								case '-3':
									$this->_ERROR_CODE = 31054;
									break;
							}

							$bravo_rollback = $bravo_service->rollback($ret['table1']['Id'], $date);
							if ($bravo_rollback['table0']['Result'] != 1)
								$this->_ERROR_CODE = 23007;
						}
					}
				} else {
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
			} else {
				$this->_ERROR_CODE = 31050;
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: updateStock
		Description: update Stock
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function updateStock($MortageContractID, $UpdatedBy) {
		$function_name = 'updateStock';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31210;

		} else {
			$query = sprintf( "CALL sp_updateStockWhenMortage(%u, '%s')",
							$MortageContractID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31211;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31212;
							break;

						case '-2':
							$this->_ERROR_CODE = 31213;
							break;

						case '-3':
							$this->_ERROR_CODE = 31214;
							break;

						case '-5':
							$this->_ERROR_CODE = 31215;
							break;

						case '-7':
							$this->_ERROR_CODE = 31216;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: approveStockSupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function approveStockSupplement($StockSupplementID, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'approveStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {
			if ( !required($StockSupplementID) || !unsigned($StockSupplementID) )
				$this->_ERROR_CODE = 31170;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31177;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31178;

		} else {
				$query = sprintf( "CALL sp_approveStockSupplement(%u, '%s')", $StockSupplementID, $UpdatedBy);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)) {
					$this->_ERROR_CODE = 31171;
				} else {
					$result = $rs['varerror'];
					if ($result < 0) {
						switch ($result) {
							case '-11':
								$this->_ERROR_CODE = 31172;
								break;

							case '-12':
								$this->_ERROR_CODE = 31173;
								break;

							case '-13':
								$this->_ERROR_CODE = 31174;
								break;

							case '-14':
								$this->_ERROR_CODE = 31175;
								break;

							case '-15':
								$this->_ERROR_CODE = 31176;
								break;
						}
					} else { /* mortage_contract_detail */
						$arrMortageContractDetailID = explode(",", $lstMortageContractDetailID);
						$arrMoneyDown = explode(",", $lstMoneyDown );
						for($i=0; $i<count($arrMortageContractDetailID); $i++) {
							$mdb = initWriteDB();
							$query = sprintf( "CALL sp_updateMoneyDownInMortageContractDetailWhenStockSupplement(%u, %f, '%s')", $arrMortageContractDetailID[$i], $arrMoneyDown[$i], $UpdatedBy);
							$rs = $mdb->extended->getRow($query);
							$mdb->disconnect();
						}
					}
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: approveMoneySupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, lstMoneyDown', 'lstMortageContractDetailID, $UpdateBy
		Output: success / error code
	*/
	function approveMoneySupplement($MoneySupplementID, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'approveMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {
			if ( !required($MoneySupplementID) )
				$this->_ERROR_CODE = 31180;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31185;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31186;

		} else {
			$query = sprintf( "CALL sp_ValidateBeforeApproveMoneySupplement(%u, '%s')", $MoneySupplementID, $UpdatedBy);
			$rs_valid = $this->_MDB2->extended->getRow($query);
			if ($rs_valid['varerror'] >= 0) {
				$bravo_service = &new Bravo();
				$date = date("Y-m-d");
				$arrWithdraw = array("TradingDate" => $date, "AccountNo" => $rs_valid['varaccountno'], "Amount" => $rs_valid['varamountmoney'], "Note" => "Tien bo sung cam co Chung khoan");
				$bravo_result = $bravo_service->withdraw($arrWithdraw );
				if ($bravo_result['table0']['Result']==1) {
					$query = sprintf( "CALL sp_approveMoneySupplement(%u, '%s')",
									$MoneySupplementID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)) {
						$this->_ERROR_CODE = 31181;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 31182;
									break;

								case '-2':
									$this->_ERROR_CODE = 31183;
									break;

								case '-3':
									$this->_ERROR_CODE = 31184;
									break;

								case '-4':
									$this->_ERROR_CODE = 31187;
									break;
							}

							// rollback in Bravo
							$bravo_rollback = $bravo_service->rollback($ret['table1']['Id'], $date);
							if ($bravo_rollback['table0']['Result'] != 1)
								$this->_ERROR_CODE = 23007;

						} else { /* mortage_contract_detail */
							$arrMortageContractDetailID = explode(",", $lstMortageContractDetailID);
							$arrMoneyDown = explode(",", $lstMoneyDown );
							for($i=0; $i<count($arrMortageContractDetailID); $i++) {
								$mdb = initWriteDB();
								$query = sprintf( "CALL sp_updateMoneyDownInMortageContractDetailWhenStockSupplement(%u, %f, '%s')", $arrMortageContractDetailID[$i], $arrMoneyDown[$i], $UpdatedBy);
								$rs = $mdb->extended->getRow($query);
								$mdb->disconnect();
							}
						}
					}
				} else { // insert to Bravo fail
					$result = $rs_valid['table0']['Result'];
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
			} else {// validate for WS
				$result = $rs_valid['varerror'];
					switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 31182;
						break;

					case '-2':
						$this->_ERROR_CODE = 31183;
						break;

					case '-3':
						$this->_ERROR_CODE = 31184;
						break;

					case '-4':
						$this->_ERROR_CODE = 31187;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: approveSupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, lstMoneyDown', 'lstMortageContractDetailID, $UpdateBy
		Output: success / error code
	*/
	function approveSupplement($MortageContractID, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'approveSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {
			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31260;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31261;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31262;

		} else {
			$query = sprintf( "CALL sp_approveSupplement(%u, '%s')",
							$MortageContractID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31263;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31264;
							break;

						case '-2':
							$this->_ERROR_CODE = 31265;
							break;

						case '-3':
							$this->_ERROR_CODE = 31266;
							break;

						case '-4':
							$this->_ERROR_CODE = 31267;
							break;
// end of sp_approveMoneySupplement
						case '-11':
							$this->_ERROR_CODE = 31268;
							break;

						case '-12':
							$this->_ERROR_CODE = 31269;
							break;

						case '-13':
							$this->_ERROR_CODE = 31270;
							break;

						case '-14':
							$this->_ERROR_CODE = 31271;
							break;

						case '-15':
							$this->_ERROR_CODE = 31272;
							break;

					}
				} else { /* mortage_contract_detail */
					$arrMortageContractDetailID = explode(",", $lstMortageContractDetailID);
					$arrMoneyDown = explode(",", $lstMoneyDown );
					for($i=0; $i<count($arrMortageContractDetailID); $i++) {
						$mdb = initWriteDB();
						$query = sprintf( "CALL sp_updateMoneyDownInMortageContractDetailWhenStockSupplement(%u, %f, '%s')", $arrMortageContractDetailID[$i], $arrMoneyDown[$i], $UpdatedBy);
						$rs = $mdb->extended->getRow($query);
						$mdb->disconnect();
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: returnStockSupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, lstMoneyDown', 'lstMortageContractDetailID, $UpdateBy
		Output: success / error code
	*/
	function returnStockSupplement($StockSupplementID, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'returnStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {
			if ( !required($StockSupplementID) || !unsigned($StockSupplementID) )
				$this->_ERROR_CODE = 31280;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31281;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31282;

		} else {
			$query = sprintf( "CALL sp_returnStockSupplement(%u, '%s')",
							$StockSupplementID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31283;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31284;
							break;

						case '-2':
							$this->_ERROR_CODE = 31285;
							break;

						case '-3':
							$this->_ERROR_CODE = 31286;
							break;

						case '-4':
							$this->_ERROR_CODE = 31287;
							break;
					}
				} else { /* mortage_contract_detail */
					$arrMortageContractDetailID = explode(",", $lstMortageContractDetailID);
					$arrMoneyDown = explode(",", $lstMoneyDown );
					for($i=0; $i<count($arrMortageContractDetailID); $i++) {
						$mdb = initWriteDB();
						$query = sprintf( "CALL sp_updateMortageContractDetailWhenReturnSupplement(%u, %f, '%s')", $arrMortageContractDetailID[$i], $arrMoneyDown[$i], $UpdatedBy);
						$rs = $mdb->extended->getRow($query);
						$mdb->disconnect();
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: returnMoneySupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, lstMoneyDown', 'lstMortageContractDetailID, $UpdateBy
		Output: success / error code
	*/
	function returnMoneySupplement($MoneySupplementID, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'returnMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {
			if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) )
				$this->_ERROR_CODE = 31290;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31291;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31292;

		} else {
			$query = sprintf("CALL sp_ValidateBeforeReturnMoneySupplement(%u, '%s')", $MoneySupplementID, $UpdatedBy);
			$rs = $this->_MDB2->extended->getRow($query);
			if ($rs['varerror'] >= 0) {
				$bravo_service = &new Bravo();
				$date = date("Y-m-d");
				$arrDeposit = array("TradingDate" => $date, "AccountNo" => $result['varaccountno'], "Amount" => $result['varamountmoney'], "Note" => "Tien bo sung cam co Chung khoan");
				$bravo_result = $bravo_service->deposit($arrDeposit);
				if ($bravo_result['table0']['Result']==1) {

					$query = sprintf( "CALL sp_returnMoneySupplement(%u, '%s')",
									$MoneySupplementID, $UpdatedBy);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)) {
						$this->_ERROR_CODE = 31293;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 31294;
									break;

								case '-2':
									$this->_ERROR_CODE = 31295;
									break;

								case '-3':
									$this->_ERROR_CODE = 31296;
									break;

								case '-4':
									$this->_ERROR_CODE = 31297;
									break;
							}

							$bravo_rollback = $bravo_service->rollback($ret['table1']['Id'], $date);
							if ($bravo_rollback['table0']['Result'] != 1)
								$this->_ERROR_CODE = 23007;

						} else { /* mortage_contract_detail */
							$arrMortageContractDetailID = explode(",", $lstMortageContractDetailID);
							$arrMoneyDown = explode(",", $lstMoneyDown );
							for($i=0; $i<count($arrMortageContractDetailID); $i++) {
								$mdb = initWriteDB();
								$query = sprintf( "CALL sp_updateMortageContractDetailWhenReturnSupplement(%u, %f, '%s')", $arrMortageContractDetailID[$i], $arrMoneyDown[$i], $UpdatedBy);
								$rs = $mdb->extended->getRow($query);
								$mdb->disconnect();
							}
						}
					}
				} else { // bravo fail
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
			} else { // validate fail
				$result = $rs['varerror'];
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 31294;
						break;

					case '-2':
						$this->_ERROR_CODE = 31295;
						break;

					case '-3':
						$this->_ERROR_CODE = 31296;
						break;

					case '-4':
						$this->_ERROR_CODE = 31297;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteMortageContract
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function deleteMortageContract($MortageContractID, $UpdatedBy) {
		$function_name = 'deleteMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31080;

		} else {
			$query = sprintf( "CALL sp_deleteMortageContract(%u, '%s')",
							$MortageContractID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31081;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31082;
							break;

						case '-2':
							$this->_ERROR_CODE = 31083;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteUnPaidMortageContract
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function deleteUnPaidMortageContract($MortageContractID, $UpdatedBy) {
		$function_name = 'deleteUnPaidMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31220;

		} else {
			$query = sprintf( "CALL sp_deleteUnPaidMortageContract(%u, '%s')",
							$MortageContractID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31221;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31222;
							break;

						case '-2':
							$this->_ERROR_CODE = 31223;
							break;

						case '-3':
							$this->_ERROR_CODE = 31224;
							break;

						case '-4':
							$this->_ERROR_CODE = 31225;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteStockSupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function deleteStockSupplement($StockSupplementID, $UpdatedBy) {
		$function_name = 'deleteStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) ) {
			$this->_ERROR_CODE = 31190;

		} else {
			$query = sprintf( "CALL sp_deleteStockSupplement(%u, '%s')",
							$StockSupplementID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31191;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31192;
							break;

						case '-2':
							$this->_ERROR_CODE = 31193;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteMoneySupplement
		Description: update Stock & Money Balance
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function deleteMoneySupplement($MoneySupplementID, $UpdatedBy) {
		$function_name = 'deleteMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) ) {
			$this->_ERROR_CODE = 31200;

		} else {
			$query = sprintf( "CALL sp_deleteMoneySupplement(%u, '%s')",
							$MoneySupplementID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31201;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31202;
							break;

						case '-2':
							$this->_ERROR_CODE = 31203;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMortageContracts
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listMortageContracts($TimeZone) {
		$function_name = 'listMortageContracts';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, ContractNo, BankID, BankName, AccountID, AccountNo, FullName, IsAssigner, LoanInterestRate, OverdueInterestRate, LoanPeriod, ContractValue, ContractDate, ReleaseDate, BlockedDate, SendDate, MatureDate, ContractStatus, Released, CreatedBy, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, UpdatedBy, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listMortageContracts ORDER BY ContractDate DESC ", $TimeZone, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"LoanInterestRate"    => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
						"OverdueInterestRate"    => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
						"LoanPeriod"    => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", date_format(new DateTime($result[$i]['contractdate']), "d/m/Y")),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", date_format(new DateTime($result[$i]['releasedate']), "d/m/Y")),
						"BlockedDate"    => new SOAP_Value("BlockedDate", "string", date_format(new DateTime($result[$i]['blockeddate']), "d/m/Y")),
						"SendDate"    => new SOAP_Value("SendDate", "string", date_format(new DateTime($result[$i]['senddate']), "d/m/Y")),
						"MatureDate"    => new SOAP_Value("MatureDate", "string", date_format(new DateTime($result[$i]['maturedate']), "d/m/Y")),
						"ContractStatus"    => new SOAP_Value("ContractStatus", "string", $result[$i]['contractstatus']),
						"Released"    => new SOAP_Value("Released", "string", $result[$i]['released']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMortageContractsWithFilter
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listMortageContractsWithFilter($Condition, $TimeZone) {
		$function_name = 'listMortageContractsWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, ContractNo, BankID, BankName, AccountID, AccountNo, FullName, IsAssigner, LoanInterestRate, OverdueInterestRate, LoanPeriod, ContractValue, ContractDate, ReleaseDate, BlockedDate, SendDate, MatureDate, ContractStatus, Released, CreatedBy, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, UpdatedBy, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
								FROM vw_listMortageContracts WHERE %s ORDER BY ContractDate DESC ", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"LoanInterestRate"    => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
						"OverdueInterestRate"    => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
						"LoanPeriod"    => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", date_format(new DateTime($result[$i]['contractdate']), "d/m/Y")),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", date_format(new DateTime($result[$i]['releasedate']), "d/m/Y")),
						"BlockedDate"    => new SOAP_Value("BlockedDate", "string", date_format(new DateTime($result[$i]['blockeddate']), "d/m/Y")),
						"SendDate"    => new SOAP_Value("SendDate", "string", date_format(new DateTime($result[$i]['senddate']), "d/m/Y")),
						"MatureDate"    => new SOAP_Value("MatureDate", "string", date_format(new DateTime($result[$i]['maturedate']), "d/m/Y")),
						"ContractStatus"    => new SOAP_Value("ContractStatus", "string", $result[$i]['contractstatus']),
						"Released"    => new SOAP_Value("Released", "string", $result[$i]['released']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMortageContractsOwnSupplement
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listMortageContractsOwnSupplement($TimeZone) {
		$function_name = 'listMortageContractsOwnSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, ContractNo, BankID, BankName, AccountID, AccountNo, FullName, IsAssigner, LoanInterestRate, OverdueInterestRate, LoanPeriod, ContractValue, ContractDate, ReleaseDate, BlockedDate, SendDate, MatureDate, ContractStatus, Released, MoneySupplementAmount, StockSupplementAmount, CreatedBy, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, UpdatedBy, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listMortageContractOwnSupplement ORDER BY ContractDate DESC ", $TimeZone, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"LoanInterestRate"    => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
						"OverdueInterestRate"    => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
						"LoanPeriod"    => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", date_format(new DateTime($result[$i]['contractdate']), "d/m/Y")),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", date_format(new DateTime($result[$i]['releasedate']), "d/m/Y")),
						"BlockedDate"    => new SOAP_Value("BlockedDate", "string", date_format(new DateTime($result[$i]['blockeddate']), "d/m/Y")),
						"SendDate"    => new SOAP_Value("SendDate", "string", date_format(new DateTime($result[$i]['senddate']), "d/m/Y")),
						"MatureDate"    => new SOAP_Value("MatureDate", "string", date_format(new DateTime($result[$i]['maturedate']), "d/m/Y")),
						"ContractStatus"    => new SOAP_Value("ContractStatus", "string", $result[$i]['contractstatus']),
						"Released"    => new SOAP_Value("Released", "string", $result[$i]['released']),
						"MoneySupplementAmount"    => new SOAP_Value("MoneySupplementAmount", "string", $result[$i]['moneysupplementamount']),
						"StockSupplementAmount"    => new SOAP_Value("StockSupplementAmount", "string", $result[$i]['stocksupplementamount']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMortageContractsOwnSupplementWithFilter
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listMortageContractsOwnSupplementWithFilter($Condition, $TimeZone) {
		$function_name = 'listMortageContractsOwnSupplementWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT ID, ContractNo, BankID, BankName, AccountID, AccountNo, FullName, IsAssigner, LoanInterestRate, OverdueInterestRate, LoanPeriod, ContractValue, ContractDate, ReleaseDate, BlockedDate, SendDate, MatureDate, ContractStatus, Released, MoneySupplementAmount, StockSupplementAmount, CreatedBy, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, UpdatedBy, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
								FROM vw_listMortageContractOwnSupplement WHERE %s ORDER BY ContractDate DESC ", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"IsAssigner"    => new SOAP_Value("IsAssigner", "string", $result[$i]['isassigner']),
						"LoanInterestRate"    => new SOAP_Value("LoanInterestRate", "string", $result[$i]['loaninterestrate']),
						"OverdueInterestRate"    => new SOAP_Value("OverdueInterestRate", "string", $result[$i]['overdueinterestrate']),
						"LoanPeriod"    => new SOAP_Value("LoanPeriod", "string", $result[$i]['loanperiod']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", $result[$i]['contractdate']),
						"ContractDate"    => new SOAP_Value("ContractDate", "string", date_format(new DateTime($result[$i]['contractdate']), "d/m/Y")),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", date_format(new DateTime($result[$i]['releasedate']), "d/m/Y")),
						"BlockedDate"    => new SOAP_Value("BlockedDate", "string", date_format(new DateTime($result[$i]['blockeddate']), "d/m/Y")),
						"SendDate"    => new SOAP_Value("SendDate", "string", date_format(new DateTime($result[$i]['senddate']), "d/m/Y")),
						"MatureDate"    => new SOAP_Value("MatureDate", "string", date_format(new DateTime($result[$i]['maturedate']), "d/m/Y")),
						"ContractStatus"    => new SOAP_Value("ContractStatus", "string", $result[$i]['contractstatus']),
						"Released"    => new SOAP_Value("Released", "string", $result[$i]['released']),
						"MoneySupplementAmount"    => new SOAP_Value("MoneySupplementAmount", "string", $result[$i]['moneysupplementamount']),
						"StockSupplementAmount"    => new SOAP_Value("StockSupplementAmount", "string", $result[$i]['stocksupplementamount']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listStockSupplement
		Description: list Mortage Contracts
		Input: 'StockSupplementID', 'MortageContractID', 'StockID', 'Quantity', 'PercentRate', 'MarketPrice', 'LoanMoney', 'SupplementDate', 'Note', 'IsConfirmed', 'ContractNo', 'BankID', 'AccountID', 'Symbol', 'ParValue', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'
		Output: ???
	*/
	function listStockSupplement($TimeZone) {
		$function_name = 'listStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listStockSupplement ", $TimeZone, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"StockSupplementID"    => new SOAP_Value("StockSupplementID", "string", $result[$i]['id']),
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"TotalMoney"    => new SOAP_Value("TotalMoney", "string", $result[$i]['totalmoney']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listStockSupplementWithFilter
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listStockSupplementWithFilter($Condition, $TimeZone) {
		$function_name = 'listStockSupplementWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listStockSupplement WHERE %s ", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"StockSupplementID"    => new SOAP_Value("StockSupplementID", "string", $result[$i]['id']),
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"TotalMoney"    => new SOAP_Value("TotalMoney", "string", $result[$i]['totalmoney']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMoneySupplement
		Description: list
		Input: 'MoneySupplementID', 'MortageContractID', 'AmountMoney', 'SupplementDate', 'Note', 'IsConfirmed', 'ContractNo', 'BankID', 'AccountID', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'
		Output: ???
	*/
	function listMoneySupplement($TimeZone) {
		$function_name = 'listMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listMoneySupplement ", $TimeZone, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MoneySupplementID"    => new SOAP_Value("MoneySupplementID", "string", $result[$i]['id']),
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"AmountMoney"    => new SOAP_Value("AmountMoney", "string", $result[$i]['amountmoney']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listMoneySupplementWithFilter
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listMoneySupplementWithFilter($Condition, $TimeZone) {
		$function_name = 'listMoneySupplementWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listMoneySupplement WHERE %s", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MoneySupplementID"    => new SOAP_Value("MoneySupplementID", "string", $result[$i]['id']),
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"AmountMoney"    => new SOAP_Value("AmountMoney", "string", $result[$i]['amountmoney']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"ContractValue"    => new SOAP_Value("ContractValue", "string", $result[$i]['contractvalue']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listStockAndMoneySupplement
		Description: list
		Input: 'MoneySupplementID', 'MortageContractID', 'AmountMoney', 'SupplementDate', 'Note', 'IsConfirmed', 'ContractNo', 'BankID', 'AccountID', 'BankName', 'AccountNo', 'InvestorID', 'FullName', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'
		Output: ???
	*/
	function listStockAndMoneySupplement($TimeZone) {
		$function_name = 'listStockAndMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listStockAndMoneySupplement ", $TimeZone, $TimeZone);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"MoneySupplement"    => new SOAP_Value("MoneySupplement", "string", $result[$i]['moneysupplement']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"StockSupplementMoney"    => new SOAP_Value("StockSupplementMoney", "string", $result[$i]['stocksupplementmoney']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listStockAndMoneySupplementWithFilter
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function listStockAndMoneySupplementWithFilter($Condition, $TimeZone) {
		$function_name = 'listStockAndMoneySupplementWithFilter';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT *, convert_tz(CreatedDate, '+00:00', '%s') as CreatedDate, convert_tz(UpdatedDate, '+00:00', '%s') as UpdatedDate
					FROM vw_listStockAndMoneySupplement WHERE %s", $TimeZone, $TimeZone, $Condition);
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageContractID"    => new SOAP_Value("MortageContractID", "string", $result[$i]['mortagecontractid']),
						"MoneySupplement"    => new SOAP_Value("MoneySupplement", "string", $result[$i]['moneysupplement']),
						"SupplementDate"    => new SOAP_Value("SupplementDate", "string", date_format(new DateTime($result[$i]['supplementdate']), "d/m/Y")),
						"lstMoneyDown"    => new SOAP_Value("lstMoneyDown", "string", $result[$i]['lstmoneydown']),
						"lstMortageContractDetailID"    => new SOAP_Value("lstMortageContractDetailID", "string", $result[$i]['lstmortagecontractdetailid']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"StockSupplementMoney"    => new SOAP_Value("StockSupplementMoney", "string", $result[$i]['stocksupplementmoney']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"BankName"    => new SOAP_Value("BankName", "string", $result[$i]['bankname']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"InvestorID"    => new SOAP_Value("InvestorID", "string", $result[$i]['investorid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", date_format(new DateTime($result[$i]['createddate']), "d/m/Y H:i:s") ),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", date_format(new DateTime($result[$i]['updateddate']), "d/m/Y H:i:s") )
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getMortageContractDetails
		Description: list Mortage Contracts
		Input: MortageContractID
		Output: ???
	*/
	function getMortageContractDetails($MortageContractID) {
		$function_name = 'getMortageContractDetails';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31075;

		} else {
			$query = sprintf( "SELECT %s.ID, StockID, Quantity, PercentRate, MarketPrice, LoanMoney, Symbol, MoneyDown
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND StockID = %s.ID
									AND MortageContractID=%u ",
								TBL_MORTGAGE_CONTRACT_DETAIL, TBL_MORTGAGE_CONTRACT_DETAIL, TBL_STOCK, TBL_MORTGAGE_CONTRACT_DETAIL, TBL_STOCK, $MortageContractID );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"MortageContractDetailID"    => new SOAP_Value("MortageContractDetailID", "string", $result[$i]['id']),
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
							"PercentRate"    => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							"MarketPrice"    => new SOAP_Value("MarketPrice", "string", $result[$i]['marketprice']),
							"LoanMoney"    => new SOAP_Value("LoanMoney", "string", $result[$i]['loanmoney']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"MoneyDown"    => new SOAP_Value("MoneyDown", "string", $result[$i]['moneydown'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getStockSupplementDetails
		Description: list Mortage Contracts
		Input: MortageContractID
		Output: ???
	*/
	function getStockSupplementDetails($StockSupplementID) {
		$function_name = 'getStockSupplementDetails';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) ) {
			$this->_ERROR_CODE = 31065;

		} else {
			$query = sprintf( "SELECT %s.ID, StockID, Quantity, PercentRate, MarketPrice, LoanMoney, Symbol
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND StockID = %s.ID
									AND StockSupplementID=%u ",
								TBL_STOCK_SUPPLEMENT_DETAIL, TBL_STOCK_SUPPLEMENT_DETAIL, TBL_STOCK, TBL_STOCK_SUPPLEMENT_DETAIL, TBL_STOCK, $StockSupplementID );
			$result = $this->_MDB2->extended->getAll($query);
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"StockSupplementDetailID"    => new SOAP_Value("StockSupplementDetailID", "string", $result[$i]['id']),
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
							"PercentRate"    => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
							"MarketPrice"    => new SOAP_Value("MarketPrice", "string", $result[$i]['marketprice']),
							"LoanMoney"    => new SOAP_Value("LoanMoney", "string", $result[$i]['loanmoney']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol'])
							)
					);
				}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	}

	/**
		Function: listAvailStocks
		Description: list Mortage Contracts
		Input: AccountID
		Output: ???
	*/
	function listAvailStocks($AccountID) {
		$function_name = 'listAvailStocks';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID) ) {
			$this->_ERROR_CODE = 31070;

		} else {
			/*$query = sprintf( "SELECT StockID, Quantity, Symbol, ParValue
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND AccountID=%u
									AND StockStatusID=%u
									AND Quantity > 0
									AND %s.StockID = %s.ID
									ORDER BY StockID ", TBL_ACCOUNT_DETAIL, TBL_STOCK, TBL_ACCOUNT_DETAIL, $AccountID, STOCK_NORMAL, TBL_ACCOUNT_DETAIL, TBL_STOCK);
			$result_normal = $this->_MDB2->extended->getAll($query);*/

			/* Unarrival Stock */
			/*$query = sprintf( "SELECT StockID, TQuantity + T1Quantity + T2Quantity + T3Quantity AS Quantity, Symbol, ParValue
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND AccountID=%u
									AND %s.StockID = %s.ID ", TBL_STOCK_BALANCE, TBL_STOCK, TBL_STOCK_BALANCE, $AccountID, TBL_STOCK_BALANCE, TBL_STOCK );
			$result_unarrival = $this->_MDB2->extended->getAll($query);

			$result = $this->mergeNormalAndUnArrivalStock($result_normal, $result_unarrival);*/

			/*$query = sprintf( "SELECT StockID, SUM(Quantity) AS Quantity
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND %s.Deleted='0'
									AND %s.ID = %s.MortageContractID
									AND %s.ContractStatus='Pending'
									AND %s.AccountID=%u
									GROUP BY StockID ",
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									TBL_MORTGAGE_CONTRACT,
									$AccountID);
			$result_existed = $this->_MDB2->extended->getAll($query);

			$result = mergeNormalAndExistedStock($result_normal, $result_existed);*/

			$query = sprintf( "CALL sp_Mortage_getListStock(%u)", $AccountID);
			$result = $this->_MDB2->extended->getAll($query);


			for($i=0; $i<count($result); $i++) {
				if ($result[$i]['quantity'] > 0) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
								"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
								"ParValue"    => new SOAP_Value("ParValue", "string", $result[$i]['parvalue'])
								)
						);
					}
				}
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: listAvailStocksWhenEdit
		Description: list Mortage Contracts
		Input: AccountID
		Output: ???
	*/
	function listAvailStocksWhenEdit($MortageContractID, $AccountID) {
		$function_name = 'listAvailStocksWhenEdit';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) || !required($AccountID) || !unsigned($AccountID) ) {
			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31070;

			if ( !required($AccountID) || !unsigned($AccountID) )
				$this->_ERROR_CODE = 31070;

		} else {
			/* account detail */
			$query = sprintf( "SELECT StockID, Quantity, Symbol, ParValue
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND AccountID=%u
									AND StockStatusID=%u
									AND %s.StockID = %s.ID
									ORDER BY StockID ", TBL_ACCOUNT_DETAIL, TBL_STOCK, TBL_ACCOUNT_DETAIL, $AccountID, STOCK_NORMAL, TBL_ACCOUNT_DETAIL, TBL_STOCK);
			$result_normal = $this->_MDB2->extended->getAll($query);

			/* other contracts */
			$query = sprintf( "SELECT StockID, SUM(Quantity) AS Quantity
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND %s.Deleted='0'
									AND %s.ID = %s.MortageContractID
									AND %s.ContractStatus='Pending'
									AND %s.ID <> %u
									GROUP BY StockID ",
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									TBL_MORTGAGE_CONTRACT,
									$AccountID);
			$result_existed = $this->_MDB2->extended->getAll($query);

			/* this contract */
			$query = sprintf( "SELECT StockID, Quantity
									FROM %s, %s
									WHERE %s.Deleted='0'
									AND %s.Deleted='0'
									AND %s.ID = %s.MortageContractID
									AND %s.ID = %u  ",
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT, TBL_MORTGAGE_CONTRACT_DETAIL,
									TBL_MORTGAGE_CONTRACT,
									$MortageContractID);
			$result_mortaged = $this->_MDB2->extended->getAll($query);

			$result = $this->mergeNormalAndExistedAndMortagedStock($result_normal, $result_existed, $result_mortaged );

			//$result = $result_normal;
			for($i=0; $i<count($result); $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
							"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
							"ParValue"    => new SOAP_Value("ParValue", "string", $result[$i]['parvalue'])
							)
					);
				}
			}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: checkContractNo
		Description: check ContractNo exist or not
		Input: ContractNo
		Output:
	*/
	function checkContractNo($ContractNo) {
		$function_name = 'checkContractNo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ContractNo) ) {
			$this->_ERROR_CODE = 31060;

		} else {
			$query = sprintf("SELECT ID
							FROM %s
							WHERE ContractNo='%s'
							AND Deleted='0' ", TBL_MORTGAGE_CONTRACT, $ContractNo);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31061;
			} else {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"MortageContractID"    => new SOAP_Value( "MortageContractID", "string", $rs['id'] )
							)
					);
			}

		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: mergeNormalAndUnArrivalStock
		Description: check ContractNo exist or not
		Input: ContractNo
		Output:
	*/
	function mergeNormalAndUnArrivalStock($arrNormal, $arrUnarrival) {
		$arrRe = array();
		$arrMerge = array_merge($arrNormal, $arrUnarrival);

		for($i=0; $i<count($arrMerge); $i++) {
			for($k=0; $k<count($arrMerge); $k++) {
				if ($i < $k) {
					if ($arrMerge[$i]['stockid'] == $arrMerge[$k]['stockid']) {
						$arrMerge[$i]['quantity'] = $arrMerge[$i]['quantity'] + $arrMerge[$k]['quantity'];
						$arrMerge[$k] = NULL;
					}
				}
			}
		}

		$k=0;
		for($i=0; $i<count($arrMerge); $i++) {
			if ($arrMerge[$i] != NULL) {
				$arrRe[$k] = $arrMerge[$i];
				$k++;
			}
		}
		return $arrRe;
	}

	/**
		Function: mergeNormalAndExistedAndMortagedStock
		Description:
		Input:
		Output:
	*/
	function mergeNormalAndExistedAndMortagedStock($arrNormal, $arrExisted, $arrMortaged) {
		for($i=0; $i<count($arrNormal); $i++) {
			for($k=0; $k<count($arrExisted); $k++) {
				if ($arrNormal[$i]['stockid'] == $arrExisted[$k]['stockid']) {
					$arrNormal[$i]['quantity'] = $arrNormal[$i]['quantity'] - $arrExisted[$k]['quantity'];
				}
			}
		}

		for($i=0; $i<count($arrNormal); $i++) {
			for($k=0; $k<count($arrMortaged); $k++) {
				if ($arrNormal[$i]['stockid'] == $arrMortaged[$k]['stockid']) {
					$arrNormal[$i]['quantity'] = $arrNormal[$i]['quantity'] + $arrMortaged[$k]['quantity'];
				}
			}
		}

		return $arrNormal;
	}

	/**
		Function: insertStockSupplement
		Description: update a Buy order
		Input: $MortageContractID', 'StockID', 'Quantity', 'MarketPrice', 'Note', 'CreatedBy
		Output: success / error code
	*/
	function insertStockSupplement($MortageContractID, $TotalMoney, $SupplementDate, $Note, $lstMoneyDown, $lstMortageContractDetailID, $CreatedBy) {
		$function_name = 'insertStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) || !required($TotalMoney) || !unsigned($TotalMoney)
				|| !required($SupplementDate) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31110;

			if ( !required($TotalMoney) || !unsigned($TotalMoney) )
				$this->_ERROR_CODE = 31111;

			if ( !required($SupplementDate) )
				$this->_ERROR_CODE = 31112;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31113;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31114;

		} else {
			$query = sprintf( "CALL sp_insertStockSupplement(%u, %f, '%s', '%s', '%s', '%s', '%s')",
							$MortageContractID, $TotalMoney, $SupplementDate, $Note, $lstMoneyDown, $lstMortageContractDetailID, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31115;
			} else {
				$result = $rs['varerror'];
				if ($result <= 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31116;
							break;

						case '-2':
							$this->_ERROR_CODE = 31117;
							break;

						case '-3':
							$this->_ERROR_CODE = 31118;
							break;

						case '-4':
							$this->_ERROR_CODE = 31119;
							break;

						case '-5':
							$this->_ERROR_CODE = 31120;
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
		Function: updateStockSupplement
		Description: update a Buy order
		Input: 'StockSupplementID', 'MortageContractID', 'StockID', 'Quantity', 'MarketPrice', 'Note', 'UpdatedBy'
		Output: success / error code
	*/
	function updateStockSupplement($StockSupplementID, $MortageContractID, $TotalMoney, $SupplementDate, $Note, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy) {
		$function_name = 'updateStockSupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) || !required($MortageContractID) || !unsigned($MortageContractID)
				|| !required($TotalMoney) || !unsigned($TotalMoney) || !required($SupplementDate)
				|| !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {

			if ( !required($StockSupplementID) || !unsigned($StockSupplementID) )
				$this->_ERROR_CODE = 31130;

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31131;

			if ( !required($TotalMoney) || !unsigned($TotalMoney) )
				$this->_ERROR_CODE = 31132;

			if ( !required($SupplementDate) )
				$this->_ERROR_CODE = 31133;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31134;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31135;

		} else {
			$query = sprintf( "CALL sp_updateStockSupplement(%u, %u, %f, '%s', '%s', '%s', '%s', '%s')",
							$StockSupplementID, $MortageContractID, $TotalMoney, $SupplementDate, $Note, $lstMoneyDown, $lstMortageContractDetailID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31136;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31137;
							break;

						case '-2':
							$this->_ERROR_CODE = 31138;
							break;

						case '-3':
							$this->_ERROR_CODE = 31139;
							break;

						case '-4':
							$this->_ERROR_CODE = 31140;
							break;

						case '-5':
							$this->_ERROR_CODE = 31141;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertStockSupplementDetail
		Description: update a Buy order
		Input: $MortageContractID', 'StockID', 'Quantity', 'MarketPrice', 'Note', 'CreatedBy
		Output: success / error code
	*/
	function insertStockSupplementDetail($StockSupplementID, $StockID, $Quantity, $PercentRate, $MarketPrice, $LoanMoney, $CreatedBy) {
		$function_name = 'insertStockSupplementDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($StockSupplementID) || !unsigned($StockSupplementID) || !required($StockID) || !unsigned($StockID)
				|| !required($Quantity) || !unsigned($Quantity) || !required($PercentRate) || !unsigned($PercentRate)
				|| !required($MarketPrice) || !unsigned($MarketPrice) || !required($LoanMoney) || !unsigned($LoanMoney) ) {

			if ( !required($StockSupplementID) || !unsigned($StockSupplementID) )
				$this->_ERROR_CODE = 31240;

			if ( !required($StockID) || !unsigned($StockID) )
				$this->_ERROR_CODE = 31241;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31242;

			if ( !required($PercentRate) || !unsigned($PercentRate) )
				$this->_ERROR_CODE = 31243;

			if ( !required($MarketPrice) || !unsigned($MarketPrice) )
				$this->_ERROR_CODE = 31244;

			if ( !required($LoanMoney) || !unsigned($LoanMoney) )
				$this->_ERROR_CODE = 31245;

		} else {
			$query = sprintf( "CALL sp_insertStockSupplementDetail(%u, %u, %u, %f, %u, %f, '%s')",
							$StockSupplementID, $StockID, $Quantity, $PercentRate, $MarketPrice, $LoanMoney, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31246;
			} else {
				$result = $rs['varerror'];
				if ($result <= 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31247;
							break;

						case '-2':
							$this->_ERROR_CODE = 31248;
							break;

						case '-3':
							$this->_ERROR_CODE = 31249;
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
		Function: insertMoneySupplement
		Description: update a Buy order
		Input: $MortageContractID, $AmountMoney, $lstMoneyDown, $lstMortageContractDetailID, $Note, $CreatedBy
		Output: success / error code
	*/
	function insertMoneySupplement($MortageContractID, $AmountMoney, $lstMoneyDown, $lstMortageContractDetailID, $Note, $CreatedBy) {
		$function_name = 'insertMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) || !required($AmountMoney) || !unsigned($AmountMoney) || !required($lstMoneyDown) || !required($lstMortageContractDetailID) ) {

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31150;

			if ( !required($AmountMoney) || !unsigned($AmountMoney) )
				$this->_ERROR_CODE = 31151;

			if ( !required($lstMoneyDown) )
				$this->_ERROR_CODE = 31152;

			if ( !required($lstMortageContractDetailID) )
				$this->_ERROR_CODE = 31153;

		} else {
			$query = sprintf( "CALL sp_insertMoneySupplement(%u, %u, '%s', '%s', '%s', '%s')",
							$MortageContractID, $AmountMoney, $lstMoneyDown, $lstMortageContractDetailID, $Note, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31154;
			} else {
				$result = $rs['varerror'];
				if ($result <= 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31155;
							break;

						case '-2':
							$this->_ERROR_CODE = 31156;
							break;

						case '-3':
							$this->_ERROR_CODE = 31157;
							break;

						case '-4':
							$this->_ERROR_CODE = 31158;
							break;

						case '-5':
							$this->_ERROR_CODE = 31159;
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
		Function: updateMoneySupplement
		Description: update a Buy order
		Input: 'StockSupplementID', 'MortageContractID', 'StockID', 'Quantity', 'MarketPrice', 'Note', 'UpdatedBy'
		Output: success / error code
	*/
	function updateMoneySupplement($MoneySupplementID, $MortageContractID, $AmountMoney, $Note, $UpdatedBy) {
		$function_name = 'updateMoneySupplement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) || !required($MortageContractID) || !unsigned($MortageContractID)
				|| !required($AmountMoney) || !unsigned($AmountMoney) ) {

			if ( !required($MoneySupplementID) || !unsigned($MoneySupplementID) )
				$this->_ERROR_CODE = 31160;

			if ( !required($MortageContractID) || !unsigned($MortageContractID) )
				$this->_ERROR_CODE = 31161;

			if ( !required($AmountMoney) || !unsigned($AmountMoney) )
				$this->_ERROR_CODE = 31162;

		} else {
			$query = sprintf( "CALL sp_updateMoneySupplement(%u, %u, %u, '%s', '%s')",
							$StockSupplementID, $MortageContractID, $StockID, $Quantity, $MarketPrice, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31163;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31164;
							break;

						case '-2':
							$this->_ERROR_CODE = 31165;
							break;

						case '-3':
							$this->_ERROR_CODE = 31166;
							break;

						case '-4':
							$this->_ERROR_CODE = 31167;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
		Function: updateNormalWhenMortage
		Description:
		Input:
		Output: success / error code
	*/
	function updateNormalWhenMortage($AccountNo, $Symbol, $Quantity, $TradingDate, $UpdatedBy) {
		$function_name = 'updateNormalWhenMortage';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($Symbol) || !required($TradingDate)
				|| !required($Quantity) || !unsigned($Quantity) ) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 31300;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 31301;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 31302;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31303;

		} else {
			$query = sprintf( "CALL sp_updateNormalWhenMortage('%s', '%s', %u, '%s', '%s')",
							$AccountNo, $Symbol, $Quantity, $TradingDate, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31304;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31305;
							break;

						case '-2':
							$this->_ERROR_CODE = 31306;
							break;

						case '-3':
							$this->_ERROR_CODE = 31307;
							break;

						case '-4':
							$this->_ERROR_CODE = 31308;
							break;

						case '-5':
							$this->_ERROR_CODE = 31309;
							break;

						case '-6':
							$this->_ERROR_CODE = 31310;
							break;

						case '-7':
							$this->_ERROR_CODE = 31311;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertMortageWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function insertMortageWithoutConfirmed($AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $BankID) {
		$function_name = 'insertMortageWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountNo) || !required($Quantity) || !unsigned($Quantity) || !required(Symbol) || !required($TradingDate)) {

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 31320;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31321;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 31322;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 31323;
		} else {
			$query = sprintf( "CALL sp_insertMortageWithoutConfirmed( '%s', '%s', %u, '%s', '%s', %u )",
							$AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31324;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31325;
							break;

						case '-2':
							$this->_ERROR_CODE = 31326;
							break;

						case '-3':
							$this->_ERROR_CODE = 31327;
							break;

						case '-4':
							$this->_ERROR_CODE = 31328;
							break;

						case '-5':
							$this->_ERROR_CODE = 31329;
							break;

						case '-7':
							$this->_ERROR_CODE = 31330;
							break;

						case '-8':
							$this->_ERROR_CODE = 31331;
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
	function updateMortageWithoutConfirmed($MortageHistoryID, $Quantity, $UpdatedBy, $BankID) {
		$function_name = 'updateMortageWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageHistoryID) || !unsigned($MortageHistoryID) || !required($Quantity) || !unsigned($Quantity) ) {

			if ( !required($MortageHistoryID) || !unsigned($MortageHistoryID) )
				$this->_ERROR_CODE = 31340;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31341;

		} else {
			$query = sprintf( "CALL sp_updateMortageWithoutConfirmed(%u, %u, '%s', %u)", $MortageHistoryID, $Quantity, $UpdatedBy, $BankID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31342;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31343;
							break;

						case '-2':
							$this->_ERROR_CODE = 31344;
							break;

						case '-3':
							$this->_ERROR_CODE = 31345;
							break;

						case '-4':
							$this->_ERROR_CODE = 31346;
							break;

						case '-5':
							$this->_ERROR_CODE = 31347;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteMortageWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function deleteMortageWithoutConfirmed($MortageHistoryID, $UpdatedBy) {
		$function_name = 'deleteMortageWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageHistoryID) || !unsigned($MortageHistoryID) ) {
				$this->_ERROR_CODE = 31350;

		} else {
			$query = sprintf( "CALL sp_deleteMortageWithoutConfirmed(%u, '%s')", $MortageHistoryID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31351;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31352;
							break;

						case '-2':
							$this->_ERROR_CODE = 31353;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getMortageHistoryList
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function getMortageHistoryList($AccountNo, $FromDate, $ToDate, $IsConfirmed ) {
		$function_name = 'getMortageHistoryList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_getMortageHistoryList( '%s', '%s', '%s', '%s' )", $AccountNo, $FromDate, $ToDate, $IsConfirmed );
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
						"MortageDate"    => new SOAP_Value("MortageDate", "string", $result[$i]['mortagedate']),
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
		Function: confirmMortageHistory
		Description:
		Input:
		Output: success / error code
	*/
	function confirmMortageHistory($MortageHistoryID, $UpdatedBy) {
		$function_name = 'confirmMortageHistory';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_confirmMortageHistory('%s', '%s')", $MortageHistoryID, $UpdatedBy );
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 31355;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$this->_ERROR_CODE = 31356;
						break;

					case '-2':
						$this->_ERROR_CODE = 31360;
						break;

					case '-5':
						$this->_ERROR_CODE = 31357;
						break;

					case '-6':
						$this->_ERROR_CODE = 31358;
						break;

					case '-7':
						$this->_ERROR_CODE = 31359;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewInsertMortageContract
		Description:
		Input:
		Output: success / error code
	*/
	function NewInsertMortageContract($ContractNo, $AccountNo, $Amount, $PercentRate, $BankID, $MortageDate, $Note, $CreatedBy, $EndDate) {
		$function_name = 'NewInsertMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ContractNo) || !required($AccountNo) || !required($Amount) || !unsigned($Amount) || !required($PercentRate) || !unsigned($PercentRate) || !required($BankID) || !unsigned($BankID) || !required(MortageDate) ) {

			if ( !required($ContractNo) )
				$this->_ERROR_CODE = 31370;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 31371;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 31372;

			if (  !required($PercentRate) || !unsigned($PercentRate) )
				$this->_ERROR_CODE = 31373;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 31374;

			if ( !required($MortageDate) )
				$this->_ERROR_CODE = 31375;

		} else {
			$query = sprintf( "CALL sp_Mortage_insertMortage( '%s', '%s', %u, %f, %u, '%s', '%s', '%s', '%s' )",
							$ContractNo, $AccountNo, $Amount, $PercentRate, $BankID, $MortageDate, $Note, $CreatedBy, $EndDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31376;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31377;
							break;

						case '-2':
							$this->_ERROR_CODE = 31378;
							break;

						case '-3':
							$this->_ERROR_CODE = 31379;
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
		Function: NewUpdateMortageContract
		Description:
		Input:
		Output: success / error code
	*/
	function NewUpdateMortageContract($ID, $ContractNo, $Amount, $PercentRate, $BankID, $MortageDate, $Note, $UpdatedBy, $EndDate) {
		$function_name = 'NewUpdateMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($ContractNo) || !required($Amount) || !unsigned($Amount) || !required($PercentRate) || !unsigned($PercentRate) || !required($BankID) || !unsigned($BankID) || !required(MortageDate) ) {

			if ( !required($ContractNo) )
				$this->_ERROR_CODE = 31380;

			if ( !required($ID) || !unsigned($ID) )
				$this->_ERROR_CODE = 31381;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 31382;

			if (  !required($PercentRate) || !unsigned($PercentRate) )
				$this->_ERROR_CODE = 31383;

			if ( !required($BankID) || !unsigned($BankID) )
				$this->_ERROR_CODE = 31384;

			if ( !required($MortageDate) )
				$this->_ERROR_CODE = 31385;

		} else {
			$query = sprintf( "CALL sp_Mortage_updateMortage( %u, '%s', %u, %f, %u, '%s', '%s', '%s', '%s' )",
							$ID, $ContractNo, $Amount, $PercentRate, $BankID, $MortageDate, $Note, $UpdatedBy, $EndDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31386;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31387;
							break;

						case '-2':
							$this->_ERROR_CODE = 31388;
							break;

						case '-3':
							$this->_ERROR_CODE = 31389;
							break;

					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewDeleteMortageContract
		Description:
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function NewDeleteMortageContract($MortageContractID, $UpdatedBy) {
		$function_name = 'NewDeleteMortageContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageContractID) || !unsigned($MortageContractID) ) {
			$this->_ERROR_CODE = 31365;

		} else {
			$query = sprintf( "CALL sp_Mortage_deleteMortage(%u, '%s')",
							$MortageContractID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31366;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31367;
							break;

						case '-2':
							$this->_ERROR_CODE = 31368;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewInsertMortageDetailWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function NewInsertMortageDetailWithoutConfirmed($MortageID, $AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $Note, $Price ) {
		$function_name = 'NewInsertMortageDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageID) || !required($AccountNo) || !required($Symbol) || !required($Quantity) || !unsigned($Quantity) || !required(TradingDate) ) {

			if ( !required($MortageID) )
				$this->_ERROR_CODE = 31390;

			if ( !required($AccountNo) )
				$this->_ERROR_CODE = 31391;

			if ( !required($Symbol) )
				$this->_ERROR_CODE = 31392;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31393;

			if ( !required($TradingDate) )
				$this->_ERROR_CODE = 31394;

		} else {
			$query = sprintf( "CALL sp_Mortage_insertMortageDetailWithoutConfirmed( %u, '%s', '%s', %u, '%s', '%s', '%s', %f)",
							$MortageID, $AccountNo, $Symbol, $Quantity, $TradingDate, $CreatedBy, $Note, $Price);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31395;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31396;
							break;

						case '-2':
							$this->_ERROR_CODE = 31397;
							break;

						case '-3':
							$this->_ERROR_CODE = 31398;
							break;

						case '-4':
							$this->_ERROR_CODE = 31399;
							break;

						case '-5':
							$this->_ERROR_CODE = 31400;
							break;

						case '-7':
							$this->_ERROR_CODE = 31401;
							break;

						case '-8':
							$this->_ERROR_CODE = 31402;
							break;

						case '-10':
							$this->_ERROR_CODE = 31403;
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
		Function: NewUpdateMortageDetailWithoutConfirmed
		Description:
		Input:
		Output: success / error code
	*/
	function NewUpdateMortageDetailWithoutConfirmed($MortageDeatailID, $Quantity, $UpdatedBy, $Note, $Price) {
		$function_name = 'NewUpdateMortageDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageDeatailID) || !required($Quantity) || !unsigned($Quantity) ) {

			if ( !required($MortageDeatailID) )
				$this->_ERROR_CODE = 31410;

			if ( !required($Quantity) || !unsigned($Quantity) )
				$this->_ERROR_CODE = 31411;

		} else {
			$query = sprintf( "CALL sp_Mortage_updateMortageDetailWithoutConfirmed( %u, %u, '%s', '%s', %f )",
							$MortageDeatailID, $Quantity, $UpdatedBy, $Note, $Price );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31412;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31413;
							break;

						case '-2':
							$this->_ERROR_CODE = 31414;
							break;

						case '-3':
							$this->_ERROR_CODE = 31415;
							break;

						case '-4':
							$this->_ERROR_CODE = 31416;
							break;

						case '-5':
							$this->_ERROR_CODE = 31417;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewDeleteMortageDetailWithoutConfirmed
		Description:
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function NewDeleteMortageDetailWithoutConfirmed($MortageDetailID, $UpdatedBy ) {
		$function_name = 'NewDeleteMortageDetailWithoutConfirmed';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageDetailID) || !unsigned($MortageDetailID) ) {
			$this->_ERROR_CODE = 31420;

		} else {
			$query = sprintf( "CALL sp_Mortage_deleteMortageDetailWithoutConfirmed(%u, '%s')",
							$MortageDetailID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31421;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31422;
							break;

						case '-2':
							$this->_ERROR_CODE = 31423;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewConfirmMortage
		Description:
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function NewConfirmMortage($MortageDetailID, $UpdatedBy ) {
		$function_name = 'NewConfirmMortage';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageDetailID) || !unsigned($MortageDetailID) ) {
			$this->_ERROR_CODE = 31425;

		} else {
			$query = sprintf( "CALL sp_Mortage_confirmMortage(%u, '%s')",
							$MortageDetailID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31426;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31427;
							break;

						case '-2':
							$this->_ERROR_CODE = 31428;
							break;

						case '-3':
							$this->_ERROR_CODE = 31429;
							break;

						case '-4':
							$this->_ERROR_CODE = 31430;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewGetMortageList
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function NewGetMortageList($FromDate, $ToDate, $AccountNo, $ContractNo, $IsConfirmed, $CreatedBy ) {
		$function_name = 'NewGetMortageList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getMortageList( '%s', '%s', '%s', '%s', '%s', '%s' )",
								$FromDate, $ToDate, $AccountNo, $ContractNo, $IsConfirmed, $CreatedBy );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['amount']),
						"PercentRate"    => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"ShortName"    => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
						"MortageDate"    => new SOAP_Value("MortageDate", "string", $result[$i]['mortagedate']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
						"EndDate"    => new SOAP_Value("EndDate", "string", $result[$i]['enddate']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewGetMortageDetailList
		Description: list Mortage Contracts
		Input:
		Output: ???
	*/
	function NewGetMortageDetailList($MortageID ) {
		$function_name = 'NewGetMortageDetailList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getMortageDetailList( %u )", $MortageID );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['stockid']),
						"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
						"Quantity"    => new SOAP_Value("Quantity", "string", $result[$i]['quantity']),
						"DetailDate"    => new SOAP_Value("DetailDate", "string", $result[$i]['detaildate']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						"Price"    => new SOAP_Value("Price", "string", $result[$i]['price']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewConfirmMortageDetail
		Description:
		Input: $MortageContractID, $UpdateBy
		Output: success / error code
	*/
	function NewConfirmMortageDetail($MortageDetailID, $UpdatedBy ) {
		$function_name = 'NewConfirmMortageDetail';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($MortageDetailID) || !unsigned($MortageDetailID) ) {
			$this->_ERROR_CODE = 31435;

		} else {
			$query = sprintf( "CALL sp_Mortage_confirmMortageDetail(%u, '%s')",
							$MortageDetailID, $UpdatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31436;
			} else {
				$result = $rs['varerror'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 31437;
							break;

						case '-2':
							$this->_ERROR_CODE = 31438;
							break;

						case '-5':
							$this->_ERROR_CODE = 31439;
							break;

						case '-6':
							$this->_ERROR_CODE = 31440;
							break;
					}
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: NewGetMortageWithConditionList
		Input:
		Output: ???
	*/
	function NewGetMortageWithConditionList($WhereClause, $TimeZone) {
		$function_name = 'NewGetMortageWithConditionList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getMortageWithConditionList( \"%s\", \"%s\" )", $WhereClause, $TimeZone );
		$result = $this->_MDB2->extended->getAll($query);
		for($i=0; $i<count($result); $i++) {
			$this->items[$i] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ID"    => new SOAP_Value("ID", "string", $result[$i]['id']),
						"ContractNo"    => new SOAP_Value("ContractNo", "string", $result[$i]['contractno']),
						"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
						"AccountID"    => new SOAP_Value("AccountID", "string", $result[$i]['accountid']),
						"FullName"    => new SOAP_Value("FullName", "string", $result[$i]['fullname']),
						"Amount"    => new SOAP_Value("Amount", "string", $result[$i]['amount']),
						"PercentRate"    => new SOAP_Value("PercentRate", "string", $result[$i]['percentrate']),
						"BankID"    => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
						"ShortName"    => new SOAP_Value("ShortName", "string", $result[$i]['shortname']),
						"MortageDate"    => new SOAP_Value("MortageDate", "string", $result[$i]['mortagedate']),
						"Note"    => new SOAP_Value("Note", "string", $result[$i]['note']),
						"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['isconfirmed']),
						"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['createdby']),
						"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['createddate']),
						"UpdatedBy"    => new SOAP_Value("UpdatedBy", "string", $result[$i]['updatedby']),
						"UpdatedDate"    => new SOAP_Value("UpdatedDate", "string", $result[$i]['updateddate']),
						"ReleaseDate"    => new SOAP_Value("ReleaseDate", "string", $result[$i]['releasedate']),
						"EndDate"    => new SOAP_Value("EndDate", "string", $result[$i]['enddate']),
						)
				);
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getTotalQuantityCanBeMortage
	*/
	function getTotalQuantityCanBeMortaged($AccountID, $StockID, $TradingDate) {
		$function_name = 'getTotalQuantityCanBeMortaged';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT  f_getTotalQttyCanBeMortage(%u, %u, '%s') AS Quantity",
						$AccountID, $StockID, $TradingDate);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
				'item',
				$struct,
				array(
					"Quantity"    => new SOAP_Value( "Quantity", "string", $rs['quantity'] )
					)
			);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getAmountCollect
	*/
	function getAmountCollect($ContractNo ) {
		$function_name = 'getAmountCollect';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getAmountCollect('%s')", $ContractNo );
		$rs = $this->_MDB2->extended->getRow($query);
		if (!empty($rs))
			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageID"    => new SOAP_Value( "MortageID", "string", $rs['mortageid'] ),
						"Amount"    => new SOAP_Value( "Amount", "string", $rs['amount'] ),
						"AmountCollect"    => new SOAP_Value( "AmountCollect", "string", $rs['amountcollect'] ),
						)
				);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getMortageInfo
	*/
	function getMortageInfo($ContractNo ) {
		$function_name = 'getMortageInfo';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_Mortage_getMortageInfo('%s')", $ContractNo );
		$rs = $this->_MDB2->extended->getRow($query);
		if (!empty($rs))
			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"MortageID"    => new SOAP_Value( "MortageID", "string", $rs['mortageid'] ),
						"ContractNo"    => new SOAP_Value( "ContractNo", "string", $rs['contractno'] ),
						"AccountNo"    => new SOAP_Value( "AccountNo", "string", $rs['accountno'] ),
						"AccountID"    => new SOAP_Value( "AccountID", "string", $rs['accountid'] ),
						"MortageDate"    => new SOAP_Value( "MortageDate", "string", $rs['mortagedate'] ),
						"ReleaseDate"    => new SOAP_Value( "ReleaseDate", "string", $rs['releasedate'] ),
						"EndDate"    => new SOAP_Value( "EndDate", "string", $rs['enddate'] ),
						"PercentRate"    => new SOAP_Value( "PercentRate", "string", $rs['percentrate'] ),
						"Amount"    => new SOAP_Value( "Amount", "string", $rs['amount'] ),
						"BankID"    => new SOAP_Value( "BankID", "string", $rs['bankid'] ),
						"ShortName"    => new SOAP_Value( "ShortName", "string", $rs['shortname'] ),
						"Note"    => new SOAP_Value( "Note", "string", $rs['note'] ),
						"AmountCollect"    => new SOAP_Value( "AmountCollect", "string", $rs['amountcollect'] ),
						)
				);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: ReportWarningValueDownContract
	*/
	function ReportWarningValueDownContract($FromDate, $ToDate, $AccountNo, $BankID, $Percent) {
		$function_name = 'ReportWarningValueDownContract';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ($FromDate == "")
			$query = "CALL sp_Mortage_ReportWarningValueDownContract(NULL,";
		else
			$query = sprintf( "CALL sp_Mortage_ReportWarningValueDownContract('%s', ", $FromDate);

		if ($ToDate == "")
			$query .= " NULL,";
		else
			$query .= sprintf( " '%s',",  $ToDate);

		$query .= sprintf( " '%s', %u, %f)", $AccountNo, $BankID, $Percent);

		$rs = $this->_MDB2->extended->getRow($query);
		if (!empty($rs))
			$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"ContractNo"    => new SOAP_Value( "ContractNo", "string", $rs['contractno'] ),
						"AccountNo"    => new SOAP_Value( "AccountNo", "string", $rs['accountno'] ),
						"FullName"    => new SOAP_Value( "FullName", "string", $rs['fullname'] ),
						"ContractDate"    => new SOAP_Value( "ContractDate", "string", $rs['contractdate'] ),
						"AmountCollect"    => new SOAP_Value( "AmountCollect", "string", $rs['amountcollect'] ),
						"Amount"    => new SOAP_Value( "Amount", "string", $rs['amount'] ),
						"PercentRate"    => new SOAP_Value( "PercentRate", "string", $rs['percentrate'] ),
						"CurrentAmount"    => new SOAP_Value( "CurrentAmount", "string", $rs['currentamount'] ),
						"ShortName"    => new SOAP_Value( "ShortName", "string", $rs['shortname'] ),
						)
				);

		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: insertDisbursement
		Description:
		Input:
		Output: success / error code
	*/
	function insertDisbursement($AccountID, $Amount, $Note, $CreatedBy, $TypeID, $BankID ) {
		$function_name = 'insertDisbursement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		if ( !required($AccountID) || !unsigned($AccountID) || !required($Amount) || !unsigned($Amount) ) {

			if ( !required($AccountID) || !unsigned($AccountID) )
				$this->_ERROR_CODE = 31445;

			if ( !required($Amount) || !unsigned($Amount) )
				$this->_ERROR_CODE = 31446;

		} else {
			$query = sprintf( "CALL sp_DisbursementMortage_insert( %u, %f, '%s', '%s', %u, %u)", $AccountID, $Amount, $Note, $CreatedBy, $TypeID, $BankID );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)) {
				$this->_ERROR_CODE = 31447;
			} else {
				$result = $rs['varerror'];
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value( "ID", "string", $result )
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: confirmDisbursement
	*/
  function confirmDisbursement($DisbursementID, $AccountNo, $Amount, $Note, $UpdatedBy, $BankID) {
    $function_name = 'confirmDisbursement';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "SELECT BankAccount, BravoCode FROM vw_ListAccountBank_Detail, disbursement_mortage WHERE vw_ListAccountBank_Detail.BankID=%u AND disbursement_mortage.BankID=%u AND disbursement_mortage.Deleted='0' AND IsExec='0' AND AccountNo='%s' AND disbursement_mortage.ID=%u AND vw_ListAccountBank_Detail.AccountID = disbursement_mortage.AccountID ", $BankID, $BankID, $AccountNo, $DisbursementID);
    $bank_rs = $this->_MDB2->extended->getRow($query);
    if($bank_rs['bankaccount'] <> '') {
      switch ($BankID) {
        case DAB_ID:
          $dab = &new CDAB();
          $refno = $AccountNo ."_". $DisbursementID ."_". date('Y-m-d');
          $dab_rs = $dab->transferfromEPS($bank_rs['bankaccount'], $AccountNo, $refno, $Amount, $Note);
          break;

        case OFFLINE:
          $mdb = initWriteDB();
          $query = sprintf( "CALL sp_VirtualBank_DisbursementMortage(%u, '%s', '%s')", $DisbursementID, date("Y-m-d"), $UpdatedBy);
          $offline_rs = $mdb->extended->getRow($query);
          $mdb->disconnect();

          if (PEAR::isError($offline_rs)) {
            $this->_ERROR_CODE = 31500;
          } else {
            $result = $offline_rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 31501;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 31502;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 31503;
                  break;

                case '-5':
                  $this->_ERROR_CODE = 31504;
                  break;

                case '-9':
                  $this->_ERROR_CODE = 31505;
                  break;
              }//switch
            } else {//if
              $dab_rs = 0;
            }
          }//if PEAR
          break;
      }//switch

      if($dab_rs == 0) {
        $query = sprintf( "CALL sp_DisbursementMortage_updateIsExec(%u)", $DisbursementID);
        $rs = $this->_MDB2_WRITE->extended->getRow($query);

        if ($rs['varerror'] < 0) {
          switch ($rs['varerror']) {
            case '-2':
              $this->_ERROR_CODE = 31450;
              break;
          }
          return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
        } else {//update Bank
          $soap = &new Bravo();
          // $Deposit_value = array("TradingDate" => date('Y-m-d'), 'TransactionType' => BRAVO_MORTAGE, "AccountNo" => $AccountNo, "Amount" => $Amount, "Bank"=> $bank_rs['bravocode'], "Branch"=> "", "Note" => $Note);

          if($bank_rs['bravocode'] == VIRTUAL_BANK_BRAVO_BANKCODE){
            $Deposit_value = array(
                    "TradingDate"     => date('Y-m-d'),
                    'TransactionType' => BRAVO_MORTAGE_EPS,
                    "AccountNo"       => $AccountNo,
                    "Amount"          => $Amount,
                    "Fee"             => $Amount,
                    "Bank"            => $bank_rs['bravocode'],
                    "Branch"          => "",
                    "Note"            => $Note);
          } else {
            $Deposit_value = array(
                    "TradingDate"     => date('Y-m-d'),
                    'TransactionType' => BRAVO_MORTAGE,
                    "AccountNo"       => $AccountNo,
                    "Amount"          => $Amount,
                    "Bank"            => $bank_rs['bravocode'],
                    "Branch"          => "",
                    "Note"            => $Note);
          }

          $ret = $soap->deposit($Deposit_value);
          if($ret['table0']['Result']==1){
            $this->_MDB2_WRITE->disconnect();
            $this->_MDB2_WRITE->connect();
            $query = sprintf( "CALL sp_DisbursementMortage_updateIsBravo(%u)", $DisbursementID);
            $rs_bravo = $this->_MDB2_WRITE->extended->getAll($query);
            if ($rs_bravo['varerror'] < 0) {
              switch ($rs_bravo['varerror']) {
                case '-2':
                  $this->_ERROR_CODE = 31451;
                  break;
              }//swtich
            }
          } else {//bravo
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
                $this->_ERROR_CODE = $ret['table0']['Result'];
                break;
            }

            if($this->_ERROR_CODE!=0 && $Deposit_value['Amount']>0){
              $soap->rollback($ret['table1']['Id'], date('Y-m-d'));
            }
          }//bravo
        }//update bank
      } else {
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
      } // bank
    } else {//bank account
      $this->_ERROR_CODE = 31452;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

	/**
		Function: confirmDisbursementForOddStock
	*/
	function confirmDisbursementForOddStock($DisbursementID, $AccountNo, $Amount, $Note, $UpdatedBy, $BankID) {
		$function_name = 'confirmDisbursementForOddStock';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "SELECT BankAccount, BravoCode FROM vw_ListAccountBank_Detail, disbursement_mortage WHERE disbursement_mortage.BankID=%u AND disbursement_mortage.Deleted='0' AND IsExec='0' AND AccountNo='%s' AND disbursement_mortage.ID=%u AND vw_ListAccountBank_Detail.AccountID = disbursement_mortage.AccountID AND disbursement_mortage.BankID=vw_ListAccountBank_Detail.BankID", $BankID, $AccountNo, $DisbursementID);
		$bank_rs = $this->_MDB2->extended->getRow($query);

		if($bank_rs['bankaccount'] <> '') {
			switch ($BankID) {
				case DAB_ID:
					$dab = &new CDAB();
					$refno = $AccountNo ."_". $DisbursementID ."_". date('Y-m-d');
					$dab_rs = $dab->transferfromEPS($bank_rs['bankaccount'], $AccountNo, $refno, $Amount, $Note);
					break;

				case OFFLINE:
					$mdb = initWriteDB();
					$query = sprintf( "CALL sp_VirtualBank_DisbursementMortage(%u, '%s', '%s')", $DisbursementID, date("Y-m-d"), $UpdatedBy);
					$offline_rs = $mdb->extended->getRow($query);
					$mdb->disconnect();

					if (PEAR::isError($offline_rs)) {
						$this->_ERROR_CODE = 31510;
					} else {
						$result = $offline_rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 31511;
									break;

								case '-2':
									$this->_ERROR_CODE = 31512;
									break;

								case '-3':
									$this->_ERROR_CODE = 31513;
									break;

								case '-5':
									$this->_ERROR_CODE = 31514;
									break;

								case '-9':
									$this->_ERROR_CODE = 31515;
									break;
							}//switch
						} else {//if
							$dab_rs = 0;
						}
					}//if PEAR
					break;
			}

			if($dab_rs == 0) {
				$query = sprintf( "CALL sp_DisbursementMortage_updateIsExec(%u)", $DisbursementID);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				if ($rs['varerror'] < 0) {
					switch ($rs['varerror']) {
						case '-2':
							$this->_ERROR_CODE = 31450;
							break;
					}
					return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
				} else {//update Bank
					$soap = &new Bravo();
					$Deposit_value = array("TradingDate" => date('Y-m-d'), 'TransactionType' => BRAVO_ODD_STOCK, "AccountNo" => $AccountNo, "Amount" => $Amount, "Bank"=> $bank_rs['bravocode'], "Branch"=> "", "Note" => $Note);
					$ret = $soap->deposit($Deposit_value);
					if($ret['table0']['Result']==1){
						$this->_MDB2_WRITE->disconnect();
						$this->_MDB2_WRITE->connect();
						$query = sprintf( "CALL sp_DisbursementMortage_updateIsBravo(%u)", $DisbursementID);
						$rs_bravo = $this->_MDB2_WRITE->extended->getAll($query);
						if ($rs_bravo['varerror'] < 0) {
							switch ($rs_bravo['varerror']) {
								case '-2':
									$this->_ERROR_CODE = 31451;
									break;
							}//swtich
						}
					} else {//bravo
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
								$this->_ERROR_CODE = $ret['table0']['Result'];
								break;
						}

						if($this->_ERROR_CODE!=0 && $Deposit['Amount']>0){
							$soap->rollback($ret['table1']['Id'], date('Y-m-d'));
						}
					}//bravo
				}//update bank
			} else {
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
			} // bank
		} else {//bank account
			$this->_ERROR_CODE = 31452;
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: getDisbursement
	*/
  function getDisbursement($AccountNo, $CreatedBy, $FromDate, $ToDate, $BankID ) {
		$function_name = 'getDisbursement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_DisbursementMortage_getList('%s', '%s', '%s', '%s', %u)", $AccountNo, $CreatedBy, $FromDate, $ToDate, $BankID );

		$rs = $this->_MDB2->extended->getAll($query);
		$count = count($rs);
		if ($count > 0) {
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value( "ID", "string", $rs[$i]['id'] ),
							"AccountNo"    => new SOAP_Value( "AccountNo", "string", $rs[$i]['accountno'] ),
							"Amount"    => new SOAP_Value( "Amount", "string", $rs[$i]['amount'] ),
							"Note"    => new SOAP_Value( "Note", "string", $rs[$i]['note'] ),
							"IsExec"    => new SOAP_Value( "IsExec", "string", $rs[$i]['isexec'] ),
							"IsBravo"    => new SOAP_Value( "IsBravo", "string", $rs[$i]['isbravo'] ),
							"CreatedBy"    => new SOAP_Value( "CreatedBy", "string", $rs[$i]['createdby'] ),
							"CreatedDate"    => new SOAP_Value( "CreatedDate", "string", $rs[$i]['createddate'] ),
							"TypeID"    => new SOAP_Value( "TypeID", "string", $rs[$i]['typeid'] ),
							"FullName"    => new SOAP_Value( "FullName", "string", $rs[$i]['fullname'] ),
							"BankID"    => new SOAP_Value( "BankID", "string", $rs[$i]['bankid'] ),
							"BankName"    => new SOAP_Value( "BankName", "string", $rs[$i]['bankname'] ),
							)
					);
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
		Function: deleteDisbursement
	*/
	function deleteDisbursement($DisbursementID, $UpdatedBy) {
		$function_name = 'deleteDisbursement';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		$query = sprintf( "CALL sp_DisbursementMortage_delete(%u, '%s')", $DisbursementID, $UpdatedBy);
		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		if (empty( $rs)) {
			$this->_ERROR_CODE = 31455;
		} else {
			$result = $rs['varerror'];
			if ($result < 0) {
				switch ($result) {
					case '-2':
						$this->_ERROR_CODE = 31456;
						break;
				}
			}
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

  function InsertExtraCollectDisbursement($AccountID, $Amount, $BankID, $TradingDate, $Note, $TranTypeID, $CreatedBy)
  {
    $function_name = 'InsertExtraCollectDisbursement';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if ( !required($AccountID) || !unsigned($AccountID) || !required($Amount) || !unsigned($Amount) ) {

      if ( !required($AccountID) || !unsigned($AccountID) )
        $this->_ERROR_CODE = 31445;

      if ( !required($Amount) || !unsigned($Amount) )
        $this->_ERROR_CODE = 31446;

    } else {
      $query = sprintf( "CALL sp_ExtraCollectDisbursement_insert( %u, %f, '%s', '%s', '%s', '%s', '%s')", $AccountID, $Amount, $BankID, $TradingDate, $Note, $TranTypeID, $CreatedBy );
      $rs = $this->_MDB2_WRITE->extended->getRow($query);

      if (empty( $rs)) {
        $this->_ERROR_CODE = 31447;
      } else {
        $result = $rs['varerror'];
        if($result < 0){
          switch ($result) {
            case '-1':
              $this->_ERROR_CODE = 21115;
              break;
          }
        } else {
          $this->items[0] = new SOAP_Value('item',$struct,array(
                "ID"    => new SOAP_Value( "ID", "string", $result )
          ));
        }
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function DeleteExtraCollectDisbursement($ID, $UpdatedBy)
  {
    $function_name = 'DeleteExtraCollectDisbursement';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_ExtraCollectDisbursement_delete(%u, '%s')", $ID, $UpdatedBy);
    $rs = $this->_MDB2_WRITE->extended->getRow($query);

    if (empty( $rs)) {
      $this->_ERROR_CODE = 31455;
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
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function GetListExtraCollectDisbursement($FromDate, $ToDate, $TranTypeID, $IsConfirmed, $AccountNo, $BankID){
    $function_name = 'GetListExtraCollectDisbursement';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_ExtraCollectDisbursement_getList('%s', '%s', '%s', '%s', '%s', '%s')", $FromDate, $ToDate, $TranTypeID, $IsConfirmed, $AccountNo, $BankID );
    $rs = $this->_MDB2->extended->getAll($query);
    $count = count($rs);
    if ($count > 0) {
      for($i=0; $i<$count; $i++) {
        $this->items[$i] = new SOAP_Value(
            'item',
            $struct,
            array(
              "ID"          => new SOAP_Value( "ID", "string", $rs[$i]['id'] ),
              "AccountID"   => new SOAP_Value( "AccountID", "string", $rs[$i]['accountid'] ),
              "AccountNo"   => new SOAP_Value( "AccountNo", "string", $rs[$i]['accountno'] ),
              "FullName"    => new SOAP_Value( "FullName", "string", $rs[$i]['fullname'] ),
              "Amount"      => new SOAP_Value( "Amount", "string", $rs[$i]['amount'] ),
              "BankAccount" => new SOAP_Value( "BankAccount", "string", $rs[$i]['bankaccount'] ),
              "BankID"      => new SOAP_Value( "BankID", "string", $rs[$i]['bankid'] ),
              "ShortName"   => new SOAP_Value( "ShortName", "string", $rs[$i]['shortname'] ),
              "TradingDate" => new SOAP_Value( "TradingDate", "string", $rs[$i]['tradingdate'] ),
              "Note"        => new SOAP_Value( "Note", "string", $rs[$i]['note'] ),
              "TranTypeID"  => new SOAP_Value( "TranTypeID", "string", $rs[$i]['trantypeid'] ),
              "IsConfirmed" => new SOAP_Value( "IsConfirmed", "string", $rs[$i]['isconfirmed'] ),
              "CreatedBy"   => new SOAP_Value( "CreatedBy", "string", $rs[$i]['createdby'] ),
              "CreatedDate" => new SOAP_Value( "CreatedDate", "string", $rs[$i]['createddate'] ),
              "UpdatedBy"   => new SOAP_Value( "UpdatedBy", "string", $rs[$i]['updatedby'] ),
              "UpdatedDate" => new SOAP_Value( "UpdatedDate", "string", $rs[$i]['updateddate'] ),
              )
          );
      }
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }

  function ConfirmExtraCollectDisbursement($ID, $UpdatedBy) {
    $function_name = 'ConfirmExtraCollectDisbursement';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    $query = sprintf( "CALL sp_ExtraCollectDisbursement_getInfo('%s')", $ID);
    $rs    = $this->_MDB2->extended->getRow($query);

    $BankAccount = $rs['bankaccount'];
    $BankID      = (int)$rs['bankid'];
    $BravoCode   = (int)$rs['bravocode'];
    $Amount      = $rs['amount'];
    $AccountNo   = $rs['accountno'];
    $TradingDate = $rs['tradingdate'];
    $Note        = $rs['note'];
    $TranTypeID  = (int)$rs['trantypeid'];

    if($BankAccount <> '') {
      switch ($BankID) {
        case DAB_ID:
          $dab = &new CDAB();
          $refno = $AccountNo ."_". $ID ."_". date('Y-m-d');
          if($TranTypeID == 1){ // Thu tien
            $dab_rs = $dab->transfertoEPS($BankAccount, $AccountNo, $refno, $Amount, $Note);
          } elseif($TranTypeID == 2) { // Chuyen tien
            $dab_rs = $dab->transferfromEPS($BankAccount, $AccountNo, $refno, $Amount, $Note);
          }
          break;

        case OFFLINE:
          $mdb = initWriteDB();
          $query = sprintf( "CALL sp_VirtualBank_ExtraCollectDisbursement(%u, '%s', '%s')", $ID, date("Y-m-d"), $UpdatedBy);
          $offline_rs = $mdb->extended->getRow($query);
          $mdb->disconnect();

          if (PEAR::isError($offline_rs)) {
            $this->_ERROR_CODE = 31500;
          } else {
            $result = $offline_rs['varerror'];
            if ($result < 0) {
              switch ($result) {
                case '-1':
                  $this->_ERROR_CODE = 31501;
                  break;

                case '-2':
                  $this->_ERROR_CODE = 31502;
                  break;

                case '-3':
                  $this->_ERROR_CODE = 31503;
                  break;

                case '-4':
                  $this->_ERROR_CODE = 30624; // khong du tien
                  break;

                case '-5':
                  $this->_ERROR_CODE = 31504;
                  break;

                case '-9':
                  $this->_ERROR_CODE = 31505;
                  break;
              }//switch
            } else {//if
              $dab_rs = 0;
            }
          }//if PEAR
          break;
      }//switch

      if($dab_rs == 0) {
        $query = sprintf( "CALL sp_ExtraCollectDisbursement_Confirm(%u,'%s')", $ID, $UpdatedBy );
        $rs = $this->_MDB2_WRITE->extended->getRow($query);

        if ($rs['varerror'] < 0) {
          switch ($rs['varerror']) {
            case '-2':
              $this->_ERROR_CODE = 31450;
              break;
          }
          return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
        } else {//update Bank
          $soap = &new Bravo();
          if($TranTypeID==1){ // Thu tien
            $transactionType = "M13.09";
            $sign = '-';
          } elseif($TranTypeID==2) { // Chuyen tien
            $transactionType = "M13.08";
            $sign = '%2B';
          }

          if($BankID == OFFLINE){
            $query  = "SELECT mobilephone,ab.usableamount FROM " . TBL_INVESTOR;
            $query .= " i INNER JOIN " . TBL_ACCOUNT . " a ON(i.id=a.investorId)";
            $query .= " INNER JOIN " . TBL_ACCOUNT_BANK . " ab ON(a.id=ab.accountid)";
            $query .= " WHERE a.accountNo='" . $AccountNo . "' AND ab.bankid=" . OFFLINE;

            $mdb = initWriteDB();
            $acc_rs = $mdb->extended->getRow($query);
            $mdb->disconnect();
            if(!empty($acc_rs['mobilephone'])){
              $message  = 'Tai khoan cua quy khach tai KIS da thay doi: ' . $sign . number_format( $Amount, 0, '.', ',' ) . '. '.$Note;
              $message .= '. So du hien tai la: ' . number_format($acc_rs['usableamount'], 0, '.', ',');
              sendSMS(array('Phone' => $acc_rs['mobilephone'], 'Content' => $message));
            }
          }

          $Deposit_value = array(
                "TradingDate"     => date('Y-m-d'),
                'TransactionType' => $transactionType,
                "AccountNo"       => $AccountNo,
                "Amount"          => $Amount,
                "Bank"            => $BravoCode,
                "Branch"          => "",
                "Note"            => $Note);

          $ret = $soap->deposit($Deposit_value);

          if($ret['table0']['Result']!=1){
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
                $this->_ERROR_CODE = $ret['table0']['Result'];
                break;
            }

            if($this->_ERROR_CODE!=0 && $Deposit_value['Amount']>0){
              $soap->rollback($ret['table1']['Id'], date('Y-m-d'));
            }
          }
        }//update bank
      } else {
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
      } // bank
    } else {//bank account
      $this->_ERROR_CODE = 31452;
    }
    return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
  }
}

/**
	Function: mergeNormalAndExistedStock
	Description:
	Input:
	Output:
*/
function mergeNormalAndExistedStock($arrNormal, $arrExisted) {
	for($i=0; $i<count($arrNormal); $i++) {
		for($k=0; $k<count($arrExisted); $k++) {
			if ($arrNormal[$i]['stockid'] == $arrExisted[$k]['stockid']) {
				$arrNormal[$i]['quantity'] = $arrNormal[$i]['quantity'] - $arrExisted[$k]['quantity'];
			}
		}
	}
	return $arrNormal;
}


?>
