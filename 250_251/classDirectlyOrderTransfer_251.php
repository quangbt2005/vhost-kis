<?php
require_once 'SOAP/Client.php';
require_once 'Cache/Lite/Function.php';
require_once('../includes.php');

define("WS_ORDER", "http://172.25.2.251/ws/order.php?wsdl");

/**
	Author: Ly Duong Duy Trung
	Created date: 09/09/2008
*/

class classDirectlyOrderTransfer extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;

	function classDirectlyOrderTransfer($check_ip) {
		//initialize MDB2
		//$this->_MDB2 = initDB();
		//$this->_MDB2_WRITE = initWriteDB();
		//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
		$this->_ERROR_CODE = $check_ip;
		$this->class_name = get_class($this);
		$this->items = array();

		$arr = array(
					'getListTransferingOrders' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'MessageType', 'Firm', 'TraderID', 'OrderNumber', 'ClientID', 'SecuritySymbol', 'Side', 'Volume', 'PublishedVolume', 'Price', 'Board', 'Filler', 'PortClientFlag', 'Filler2', 'OrderEntryDate')),

					'getListAdOrders' => array( 'input' => array( 'TradingDate' ),
											'output' => array( 'MessageType', 'Firm', 'TraderID', 'SecuritySymbol', 'Side', 'Volume', 'Price', 'Board', 'Time', 'AddCancelFlag', 'Contact', 'ClientIDBuyer', 'ClientIDSeller', 'DealID', 'Filler', 'BrokerPortfolioVolumeBuyer', 'BrokerClientVolumeBuyer', 'MutualFundVolumeBuyer', 'BrokerForeignVolumeBuyer', 'Filler2', 'BrokerPortfolioVolumeSeller', 'BrokerClientVolumeSeller', 'MutualFundVolumeSeller', 'BrokerForeignVolumeSeller', 'Filler3', 'FirmSeller', 'TraderIDSeller', 'ContraFirmBuyer', 'TraderIDBuyer', 'TraderIDSender', 'TraderIDReciever', 'ContraFirm', 'AdminMessageText', 'ConfirmNumber', 'ReplyCode', 'BrokerPortfolioVolume', 'BrokerClientVolume', 'BrokerMutualFundVolume', 'BrokerForeignVolume' )),

					'updateReject2G' => array( 'input' => array( 'MessageType', 'Firm', 'RejectReasonCode', 'OriginalMessageText'),
											'output' => array( ) ),

					'update1IOrder' => array( 'input' => array( 'MessageType', 'Firm','OrderNumber', 'OrderDate', 'RejectCode', 'MessageText'),
											'output' => array( ) ),

					'updateOrder2B' => array( 'input' => array( 'MessageType', 'Firm', 'OrderNumber', 'OrderEntryDate', 'RejectCode', 'MessageText'),
											'output' => array( ) ),

					'updateOrder2C' => array( 'input' => array( 'MessageType', 'Firm', 'CancelShares', 'OrderNumber', 'OrderEntryDate', 'OrderCancelStatus', 'RejectCode', 'MessageText'),
											'output' => array( ) ),

					'updateOrder2D' => array( 'input' => array( 'MessageType', 'Firm', 'OrderNumber', 'OrderEntryDate', 'ClientID', 'PortClientFlag', 'PublishedVolume', 'Price', 'Filler', 'RejectCode', 'MessageText'),
											'output' => array( ) ),

					'updateMatchOrder2E' => array( 'input' => array( 'MessageType', 'Firm', 'Side', 'OrderNumber', 'OrderEntryDate', 'Filler', 'Volume', 'Price', 'ConfirmNumber'),
											'output' => array( ) ),

					'updateMatchOrder2I' => array( 'input' => array( 'MessageType', 'Firm', 'OrderNumberBuy', 'OrderEntryDateBuy', 'OrderNumberSell', 'OrderEntryDateSell', 'Volume', 'Price', 'ConfirmNumber'),
											'output' => array( ) ),

					'updateConfirmDealOrder2L' => array( 'input' => array( 'MessageType', 'Firm', 'Side', 'DealID', 'ContraFirm', 'Volume', 'Price', 'ConfirmNumber'),
											'output' => array( ) ),

					'updateAdmin3A' => array( 'input' => array( 'MessageType', 'Firm', 'TraderIDSender', 'TraderIDReciever', 'ContraFirm', 'AdminMessageText'),
											'output' => array( ) ),

					'updateDealOrder2F' => array( 'input' => array( 'MessageType', 'FirmBuy', 'TraderIDBuy', 'SideB', 'ContraFirmSell', 'TraderIDContraSideSell', 'SecuritySymbol', 'Volume', 'Price', 'Board', 'ConfirmNumber'),
											'output' => array( ) ),

					'updateResultDealOrder3B' => array( 'input' => array( 'MessageType', 'Firm', 'ConfirmNumber', 'DealID', 'ClientIDBuyer', 'ReplyCode', 'Filler', 'BrokerPortfolioVolume', 'BrokerClientVolume', 'BrokerMutualFundVolume', 'BrokerForeignVolume', 'Filler2'),
											'output' => array( ) ),

					'updateCancelDealOrder3C' => array( 'input' => array( 'MessageType', 'Firm', 'ContraFirm', 'TraderID', 'ConfirmNumber', 'SecuritySymbol', 'Side'),
											'output' => array( ) ),

					'updateCancelDealOrder3D' => array( 'input' => array( 'MessageType', 'Firm', 'ConfirmNumber', 'ReplyCode'),
											'output' => array( ) ),

					'insertAA' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'Volume', 'Price', 'Firm', 'Trader', 'Side', 'Board', 'Time', 'AddCancelFlag', 'Contact'),
											'output' => array( ) ),

					'insertBR' => array( 'input' => array( 'MessageType', 'Firm', 'MarketID', 'VolumeSold', 'ValueSold', 'VolumeBought',  'ValueBought'),
											'output' => array( ) ),

					'insertBS' => array( 'input' => array( 'MessageType', 'Firm', 'AutoMatchHaltFlag', 'PutthroughHaltFlag'),
											'output' => array( ) ),

					'insertCO' => array( 'input' => array( 'MessageType', 'ReferenceNumber'),
											'output' => array( ) ),

					'insertDC' => array( 'input' => array( 'MessageType', 'ConfirmNumber', 'SecurityNumber', 'Volume', 'Price', 'Board'),
											'output' => array( ) ),

					'insertGA' => array( 'input' => array( 'MessageType', 'AdminMessageLengh', 'AdminMessageText'),
											'output' => array( ) ),

					'insertIU' => array( 'input' => array( 'MessageType', 'IndexHoSE', 'TotalTrades', 'TotalSharesTraded',  'TotalValuesTraded', 'UpVolume', 'DownVolume', 'NoChangeVolume', 'Advances', 'Declines', 'NoChange',  'Filler1', 'MarketID', 'Filler2', 'IndexTime'),
											'output' => array( ) ),

					'insertLO' => array( 'input' => array( 'MessageType', 'ConfirmNumber', 'SecurityNumber', 'OddLotVolume', 'Price', 'ReferenceNumber'),
											'output' => array( ) ),

					'insertLS' => array( 'input' => array( 'MessageType', 'ConfirmNumber', 'SecurityNumber', 'LotVolume', 'Price', 'Side'),
											'output' => array( ) ),

					/*'insertLS' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertNH' => array( 'input' => array( 'MessageType', 'NewsNumber', 'SecuritySymbol', 'NewsHeadlineLength', 'TotalNewsStoryPages', 'NewsHeadlineText'),
											'output' => array( ) ),

					'insertNS' => array( 'input' => array( 'MessageType', 'NewsNumber', 'NewsPageNumber', 'NewsTextLength', 'NewsText'),
											'output' => array( ) ),

					'insertOL' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'OddLotVolume', 'Price', 'Side', 'ReferenceNumber'),
											'output' => array( ) ),

					'insertOS' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'Price'),
											'output' => array( ) ),

					/*'insertOS' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertPD' => array( 'input' => array( 'MessageType', 'ConfirmNumber', 'SecurityNumber', 'Volume', 'Price', 'Board'),
											'output' => array( ) ),

					'insertPO' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'ProjectedOpenPrice'),
											'output' => array( ) ),

					/*'insertPO' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertSC' => array( 'input' => array( 'MessageType', 'SystemControlCode', 'Timestamp'),
											'output' => array( ) ),

					'insertSI' => array( 'input' => array( 'MessageType', 'IndexSectoral', 'Filler', 'IndexTime'),
											'output' => array( ) ),

					'insertSR' => array( 'input' => array( 'MessageType', 'MainOrForeignDeal', 'MainOrForeignAccVolume', 'MainOrForeignAccValue', 'DealsInBigLotBoard', 'BigLotAccVolume', 'BigLotAccValue', 'DealsInOddLotBoard', 'OddLotAccVolume', 'OddLotAccValue'),
											'output' => array( ) ),

					'insertSS' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'Filler1', 'SectorNumber', 'Filler2', 'HaltorResumeFlag', 'SystemControlCode', 'Filler3', 'Suspension', 'Delist', 'Filler4', 'Ceiling', 'FloorPrice', 'SecurityType', 'PriorClosePrice', 'Filler5', 'Split', 'Benefit', 'Meeting', 'Notice', 'BoardLot', 'Filler6'),
											'output' => array( ) ),

					/*'insertSS' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertSU' => array( 'input' => array( 'MessageType', 'SecurityNumberOld', 'SecurityNumberNew', 'Filler1', 'SectorNumber', 'Filler2', 'SecuritySymbol', 'SecurityType', 'CeilingPrice', 'FloorPrice', 'LastSalePrice', 'MarketID', 'Filler3', 'SecurityName', 'Filler4', 'Suspension', 'Delist', 'HaltorResumeFlag', 'Split', 'Benefit', 'Meeting', 'Notice', 'ClientIDRequired', 'ParValue', 'SDCFlag', 'PriorClosePrice', 'PriorCloseDate', 'OpenPrice', 'HighestPrice', 'LowestPrice', 'TotalSharesTraded', 'TotalValuesTraded', 'BoardLot', 'Filler5'),
											'output' => array( ) ),

					'insertTC' => array( 'input' => array( 'MessageType', 'Firm', 'TraderID', 'TraderStatus'),
											'output' => array( ) ),

					'insertTP' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'Side', 'Price1Best', 'LotVolume1', 'Price2Best', 'LotVolume2', 'Price3Best', 'LotVolume3'),
											'output' => array( ) ),

					/*'insertTP' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertTR' => array( 'input' => array( 'MessageType', 'SecurityNumber', 'TotalRoom', 'CurrentRoom'),
											'output' => array( ) ),

					/*'insertTR' => array( 'input' => array( 'StringInput'),
											'output' => array( ) ),*/

					'insertTS' => array( 'input' => array( 'MessageType', 'Timestamp'),
											'output' => array( ) ),

					'getOrderInfoToChange1D' => array( 'input' => array( 'AccountNo', 'OrderDate'),
											'output' => array( 'OrderID', 'OrderDate', 'OrderNumber', 'AccountNo', 'OrderSideName', 'Symbol', 'OrderStyleName', 'OrderQuantity', 'OrderPrice', 'StatusName', 'CreatedBy') ),

					'insertOrderChange1D' => array( 'input' => array( 'OrderNumber', 'OrderDate', 'AccountNo', 'CreatedBy'),
											'output' => array( ) ),

					'getOrderChange1DList' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'OrderNumber', 'OrderDate', 'ClientID', 'CreatedBy', 'CreatedDate') ),

					'insertAdvertisement1E' => array( 'input' => array( 'SecuritySymbol', 'Side', 'Volume', 'Price', 'AddCancelFlag', 'Contact', 'CreatedBy', 'Time' ),
											'output' => array( 'ID' ) ),

					'insertOneFirmPutThroughDeal1F' => array( 'input' => array( 'ClientIDBuyer', 'ClientIDSeller', 'SecuritySymbol', 'Price', 'DealID', 'BrokerPortfolioVolumeBuyer', 'BrokerClientVolumeBuyer', 'MutualFundVolumeBuyer', 'BrokerForeignVolumeBuyer', 'BrokerPortfolioVolumeSeller', 'BrokerClientVolumeSeller', 'MutualFundVolumeSeller', 'BrokerForeignVolumeSeller', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'insertDealPutThroughCancelRequest3C' => array( 'input' => array( 'ContraFirm', 'ConfirmNumber', 'SecuritySymbol', 'Side', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'insertTwoFirmPutThroughDeal1G' => array( 'input' => array( 'ClientIDSeller', 'ContraFirmBuyer', 'TraderIDBuyer', 'SecuritySymbol', 'Price', 'DealID', 'BrokerPortfolioVolumeSeller', 'BrokerClientVolumeSeller', 'MutualFundVolumeSeller', 'BrokerForeignVolumeSeller', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'insertPutPhroughDealReply3B' => array( 'input' => array( 'ConfirmNumber', 'DealID', 'ClientIDBuyer', 'ReplyCode', 'BrokerPortfolioVolume', 'BrokerClientVolume', 'BrokerMutualFundVolume', 'BrokerForeignVolume', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'insertDealCancelReply3D' => array( 'input' => array( 'ConfirmNumber', 'ReplyCode', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'list1E' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'TraderID', 'SecuritySymbol', 'Side', 'Volume', 'Price', 'Board', 'Time', 'AddCancelFlag', 'Contact', 'CreatedBy', 'CreatedDate', 'GetNumber' ) ),

					'list1F' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'TraderID', 'ClientIDBuyer', 'ClientIDSeller', 'SecuritySymbol', 'Price', 'Board', 'DealID', 'Filler', 'Filler2', 'Filler3', 'BrokerPortfolioVolumeBuyer', 'BrokerClientVolumeBuyer', 'MutualFundVolumeBuyer', 'BrokerForeignVolumeBuyer', 'BrokerPortfolioVolumeSeller', 'BrokerClientVolumeSeller', 'MutualFundVolumeSeller', 'BrokerForeignVolumeSeller', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'list3D' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'ConfirmNumber', 'ReplyCode', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'list3C' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'ContraFirm', 'TraderID', 'ConfirmNumber', 'SecuritySymbol', 'Side', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'list2F' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'FirmBuy', 'TraderIDBuy', 'SideB', 'ContraFirmSell', 'TraderIDContraSideSell', 'SecuritySymbol', 'Volume', 'Price', 'Board', 'ConfirmNumber', 'OrderDate' ) ),

					'list2L' => array( 'input' => array( 'OrderDate', 'MessageType' ),
											'output' => array( 'ID', 'MessageType', 'Firm', 'Side', 'DealID', 'ContraFirm', 'Volume', 'Price', 'ConfirmNumber', 'OrderDate', 'SecuritySymbol' ) ),

					'list3B' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'ConfirmNumber', 'DealID', 'ClientIDBuyer', 'ReplyCode', 'Filler', 'BrokerPortfolioVolume', 'BrokerClientVolume', 'BrokerMutualFundVolume', 'BrokerForeignVolume', 'Filler2', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'list1G' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'FirmSeller', 'TraderIDSeller', 'ClientIDSeller', 'ContraFirmBuyer', 'TraderIDBuyer', 'SecuritySymbol', 'Price', 'Board', 'DealID', 'Filler', 'BrokerPortfolioVolumeSeller', 'BrokerClientVolumeSeller', 'MutualFundVolumeSeller', 'BrokerForeignVolumeSeller', 'Filler2', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'list3A' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'MessageType', 'Firm', 'TraderIDSender', 'TraderIDReciever', 'ContraFirm', 'AdminMessageText', 'CreatedDate', 'CreatedBy', 'GetNumber' ) ),

					'insertAdmin3A' => array( 'input' => array( 'TraderIDReciever', 'ContraFirm', 'AdminMessageText', 'CreatedBy'),
											'output' => array( 'ID' ) ),

					'list2D' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'MessageType', 'Firm', 'OrderNumber', 'OrderEntryDate', 'ClientID', 'PortClientFlag', 'PublishedVolume', 'Price', 'Filler', 'RejectCode', 'MessageText', 'OrderDate') ),

					'list2G' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'MessageType', 'Firm', 'RejectReasonCode', 'Description', 'OriginalMessageText') ),

					'listPutAd' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'StockExchange', 'Symbol', 'TraderID', 'Vol', 'Price', 'Firm', 'Side', 'Contact') ),

					'GetSymbolOfDealPutThrough' => array( 'input' => array( 'TradingDate', 'Side', 'DealID'),
											'output' => array( 'Symbol') ),

					'CheckInValidDealIDOfPutThrough' => array( 'input' => array( 'TradingDate', 'DealID'),
											'output' => array( 'Boolean') ),

					'getCurrentFroom' => array( 'input' => array( 'TradingDate', 'Symbol'),
											'output' => array( 'Room') ),

					'getInvalidOrder' => array( 'input' => array( 'OrderDate', 'StockExchangeID'),
											'output' => array( 'OrderID', 'OrderNumber', 'AccountNo', 'Symbol') ),

					'insertAdvertisementForHNX' => array( 'input' => array( 'TransDate', 'Symbol', 'TransDesc', 'OrderSide', 'Quantity', 'Price', 'FirmBuyer', 'TradeIDBuyer', 'CancelFlag', 'CreatedBy', 'CHAR'),
											'output' => array( 'ID') ),

					'listAdvertisements' => array( 'input' => array( 'TradingDate'),
											'output' => array( 'ID', 'TRANSDATE', 'SECSYMBOL', 'TRANSDESC', 'TRANSTYPE', 'AMOUNT', 'PRICE', 'FIRMBUYER', 'TRADEIDBUYER', 'TRANSTIME', 'CANCELLFLAG', 'StatusName', 'CreatedBy', 'TRANSNUM' ) ),

					'cancelAdvertisementForHNX' => array( 'input' => array( 'ID'),
											'output' => array( ) ),

					'insertOneFirm' => array( 'input' => array( 'TransDate', 'StockID', 'TransDesc', 'TransType', 'Amount', 'Price', 'SrcAccountID', 'DscAccountID', 'CreatedBy', 'AccountNo', 'OrgSubTranSum', 'CHAR' ),
											'output' => array( 'ID') ),

					'insertOneFirmCancel' => array( 'input' => array( 'ID', 'CreatedBy', 'TRANSDESC', 'OrderDate'),
											'output' => array( 'ID') ),

					'listOneFirmGrid' => array( 'input' => array( 'OrderDate', 'TRANSTYPE', 'IsConfirmed'),
											'output' => array( 'ID', 'TRANSNUM', 'TRANSDATE', 'Symbol', 'TRANSDESC', 'TRANSTYPE', 'AMOUNT', 'PRICE', 'SRCACCOUNT', 'DSCACCOUNT', 'StatusName', 'CreatedBy', 'CreatedDate', 'GetNumber', 'IDRef', 'IsConfirmed' ) ),

					'confirmChangeOrder' => array( 'input' => array( 'OrderID', 'IsMatched', 'MatchedQuantity', 'ExchangeRefno'),
											'output' => array( ) ),

					'updateCancelOrderForHNX' => array( 'input' => array( 'CancelQuantity', 'OrderNumber', 'OrderDate', 'RejectCode', 'OrderID'),
											'output' => array( ) ),

					'listTwoFirmOrderCrossGrid' => array( 'input' => array( 'TRANSDATE'),
											'output' => array( 'OrderCrossID', 'TRANSDATE', 'SECSYMBOL', 'AMOUNT', 'PRICE', 'ORGSUBTRANNUM', 'CONTRAFIRM', 'CONTRATRADERID', 'CONFIRMNO', 'CreatedDate', 'IsApproved', 'StockID' ) ),

					'insertConfirmOneFirmCancel' => array( 'input' => array( 'ID', 'CreatedBy', 'TRANSDESC', 'OrderDate'),
											'output' => array( 'ID') ),

					'insertTwoFirm' => array( 'input' => array( 'TransDate', 'StockID', 'TransDesc', 'TransType', 'Amount', 'Price', 'FIRMBUYER', 'TRADEIDBUYER', 'SrcAccountID', 'CreatedBy', 'ORGSUBTRANNUM', 'CHAR'),
											'output' => array( 'ID') ),

					'listTwoFirmSellerGrid' => array( 'input' => array( 'TRANSDATE'),
											'output' => array( 'ID', 'TRANSNUM', 'TRANSDATE', 'Symbol', 'TRANSDESC', 'TRANSTYPE', 'AMOUNT', 'PRICE', 'AccountNo', 'StatusName', 'FIRMBUYER', 'TRADEIDBUYER', 'CreatedBy', 'CreatedDate', 'GetNumber' ) ),

					'listTwoFirmBuyerGrid' => array( 'input' => array( 'TRANSDATE'),
											'output' => array( 'ID', 'TRANSNUM', 'TRANSDATE', 'AccountNo', 'TRANSTYPE', 'Symbol', 'AMOUNT', 'PRICE', 'TRANSDESC', 'CANCELLFLAG', 'CreatedBy', 'CreatedDate', 'GetNumber', 'ORGSUBTRANNUM', 'CONTRAFIRM', 'CONTRATRADERID', 'CONFIRMNO', 'IsApproved', 'StatusName' ) ),

					'insertTwoFirmReplyCancel2Firm' => array( 'input' => array( 'TRANSDATE', 'CANCELLFLAG', 'IDRef', 'CreatedBy'),
											'output' => array( 'ID') ),

					'insertTwoFirmReply2Firm' => array( 'input' => array( 'TRANSDATE', 'TRANSDESC', 'SRCACCOUNTID', 'CANCELLFLAG', 'OrderCrossID', 'CreatedBy', 'AccountNo', 'StockID', 'Amount', 'Price'),
											'output' => array( 'ID') ),

					'insertTwoFirmCancel2Firm' => array( 'input' => array( 'IDRef', 'TransDate', 'CreatedBy'),
											'output' => array( 'ID') ),

					'listTwoFirmPTCancelReqGrid' => array( 'input' => array( 'TRANSDATE'),
											'output' => array( 'ID', 'BOORGTRANSNUM', 'BOORGSUBTRANNUM', 'ORGTRANSNUM', 'ORGSUBTRANNUM', 'TRANSNUM', 'TRADEDATE', 'TRADETIME', 'FIRM', 'CONTRAFIRM', 'TRADEID', 'CONFIRMNO', 'SIDE', 'IsConfirmed', 'AccountNoSeller', 'AMOUNT', 'PRICE', 'Symbol' ) ),

					'listTwoFirmCancel2FirmGrid' => array( 'input' => array( 'TRANSDATE'),
											'output' => array( 'ID', 'TRANSNUM', 'TRANSDATE', 'Symbol', 'TRANSDESC', 'TRANSTYPE', 'AMOUNT', 'PRICE', 'AccountNo', 'StatusName', 'FIRMBUYER', 'TRADEIDBUYER', 'CreatedBy', 'CreatedDate', 'GetNumber' ) ),

					'listTwoFirmReplyCancel2FirmGrid' => array( 'input' => array( 'OrderDate'),
											'output' => array( 'ID', 'TRANSNUM', 'TRANSDATE', 'Symbol', 'TRANSTYPE', 'AMOUNT', 'PRICE', 'AccountNoBuyer', 'CANCELLFLAG', 'StatusName', 'IDRef',  'CreatedBy', 'CreatedDate', 'GetNumber' ) ),

					'listTwoFirmPTADVGrid' => array( 'input' => array( 'SYMBOL', 'TRANSDATE', 'SIDE'),
											'output' => array( 'SYMBOL', 'VOLUME', 'PRICE', 'FIRM', 'TRADEID', 'SIDE', 'ADVTIME', 'AORC', 'CONTACT', 'TRANSDATE', 'ORGSUBTRANSNUM' ) ),

					'CheckBuyingAndSellingWithinSameDay' => array( 'input' => array( 'SrcAccountID', 'StockID', 'TransDate', 'OrderSideID'),
											'output' => array( 'Boolean' ) ),

					'unlockMoneyAtBank' => array('input' => array('AccountNo', 'BankID', 'BankAccount', 'OldOrderID', 'OrderValue', 'UnitCode'),
											'output' => array()),

					'getPushOrderGrid' => array('input' => array('AccountNo', 'IsPush', 'OrderDate'),
											'output' => array('OrderID', 'AccountNo', 'OrderSideName', 'Symbol', 'OrderQuantity', 'OrderPrice', 'StatusName', 'IsPush', 'CreatedBy', 'CreatedDate')),

					'pushOrderPush' => array('input' => array('OrderID', 'OrderDate', 'UpdatedBy'),
											'output' => array( 'Boolean' )),
					/* Chi them ngay 04-03-2010 */

					'insertTradeForHNX' => array( 'input' => array( 'ConfirmNo', 'OrderNumber', 'MatchedQuantity', 'MatchedPrice', 'MatchedSession', 'TradingDate', 'CreatedBy' ),
									'output' => array(  )),
					/* End Chi them ngay 04-03-2010 */
					'getListApprovedOrderForHNX' => array( 'input' => array('OrderDate'),
									'output' => array( 'MTI', 'TRANSCODE', 'TRANSSUBCODE', 'BUSSINESSDATE', 'TRANSDATE', 'TRANSTIME', 'EXCHANGEID', 'SECSYMBOL', 'TRANSDESC', 'TRANSSTATUS',
																		 'TRANSTYPE', 'AMOUNT', 'PRICETYPE', 'PRICE', 'FIRM', 'TRADEID', 'BOARD', 'SRCACCOUNT', 'CLIENTFLAG', 'BOORGTRANSNUM', 'DELETE',
																		 'LOCALMACHINE', 'LOCALIPADDRESS', 'MAKERID', 'CHECKERID', 'SECUSERNAME', 'SECUSERPASSWORD') ),
					'resendTransferOrder' => array('input' => array('OrderDate', 'OrderID'),
									'output' => array() ),
					'getTransferingOrderForReSend' => array('input' => array('OrderDate', 'AccountNo', 'OrderID'),
									'output' => array('OrderID','OrderNumber','AccountNo','OrderSideName','Symbol','OrderStyleName','OrderPrice','OrderQuantity','StatusName','o.GetNumber') ),
						);

		parent::__construct($arr);
	}

	function __destruct() {
		//$this->_MDB2->disconnect();
		//$this->_MDB2_WRITE->disconnect();
		//$this->_MDB2_TB_WRITE->disconnect();
	}

	/**
		Function: getListTransferingOrders
	*/
    function getListTransferingOrders($TradingDate) {
		$function_name = 'getListTransferingOrders';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_ThreadOneInfo('%s')", $TradingDate);
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
								"ClientID"    => new SOAP_Value("ClientID", "string", $result[$i]['ClientID']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"Volume"    => new SOAP_Value("Volume", "string", $result[$i]['Volume']),
								"PublishedVolume"    => new SOAP_Value("PublishedVolume", "string", $result[$i]['PublishedVolume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"PortClientFlag"    => new SOAP_Value("PortClientFlag", "string", $result[$i]['PortClientFlag']),
								"Filler2"    => new SOAP_Value("Filler2", "string", $result[$i]['Filler2']),
								"OrderEntryDate"    => new SOAP_Value("OrderEntryDate", "string", $result[$i]['OrderEntryDate']),
								)
						);
					/*$content = sprintf( "MessageType=%s, Firm=%s, TraderID=%s, OrderNumber=%s, ClientID=%s, SecuritySymbol=%s, Side=%s, Volume=%s, PublishedVolume=%s, Price=%s, Board=%s, Filler=%s, PortClientFlag=%s, Filler2=%s, OrderEntryDate=%s",
									$result[$i]['MessageType'], $result[$i]['Firm'], $result[$i]['TraderID'], $result[$i]['OrderNumber'], $result[$i]['ClientID'], $result[$i]['SecuritySymbol'], $result[$i]['Side'], $result[$i]['Volume'], $result[$i]['PublishedVolume'], $result[$i]['Price'], $result[$i]['Board'], $result[$i]['Filler'], $result[$i]['PortClientFlag'], $result[$i]['Filler2'], $result[$i]['OrderEntryDate']);
					another_write_log($function_name, $content, 'directly_tranfer');*/
				}
				$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
				another_write_log($function_name, $content, 'directly_tranfer');
			}//if
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: getListAdOrders
	*/
    function getListAdOrders($TradingDate) {
		$function_name = 'getListAdOrders';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL  sp_order_ThreadTwoInfo('%s')", $TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"Volume"    => new SOAP_Value("Volume", "string", $result[$i]['Volume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"Time"    => new SOAP_Value("Time", "string", $result[$i]['Time']),
								"AddCancelFlag"    => new SOAP_Value("AddCancelFlag", "string", $result[$i]['AddCancelFlag']),
								"Contact"    => new SOAP_Value("Contact", "string", $result[$i]['Contact']),
								"ClientIDBuyer"    => new SOAP_Value("ClientIDBuyer", "string", $result[$i]['ClientIDBuyer']),
								"ClientIDSeller"    => new SOAP_Value("ClientIDSeller", "string", $result[$i]['ClientIDSeller']),
								"DealID"    => new SOAP_Value("DealID", "string", $result[$i]['DealID']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"BrokerPortfolioVolumeBuyer"    => new SOAP_Value("BrokerPortfolioVolumeBuyer", "string", $result[$i]['BrokerPortfolioVolumeBuyer']),
								"BrokerClientVolumeBuyer"    => new SOAP_Value("BrokerClientVolumeBuyer", "string", $result[$i]['BrokerClientVolumeBuyer']),
								"MutualFundVolumeBuyer"    => new SOAP_Value("MutualFundVolumeBuyer", "string", $result[$i]['MutualFundVolumeBuyer']),
								"BrokerForeignVolumeBuyer"    => new SOAP_Value("BrokerForeignVolumeBuyer", "string", $result[$i]['BrokerForeignVolumeBuyer']),
								"Filler2"    => new SOAP_Value("Filler2", "string", $result[$i]['Filler2']),
								"BrokerPortfolioVolumeSeller"    => new SOAP_Value("BrokerPortfolioVolumeSeller", "string", $result[$i]['BrokerPortfolioVolumeSeller']),
								"BrokerClientVolumeSeller"    => new SOAP_Value("BrokerClientVolumeSeller", "string", $result[$i]['BrokerClientVolumeSeller']),
								"MutualFundVolumeSeller"    => new SOAP_Value("MutualFundVolumeSeller", "string", $result[$i]['MutualFundVolumeSeller']),
								"BrokerForeignVolumeSeller"    => new SOAP_Value("BrokerForeignVolumeSeller", "string", $result[$i]['BrokerForeignVolumeSeller']),
								"Filler3"    => new SOAP_Value("Filler3", "string", $result[$i]['Filler3']),
								"FirmSeller"    => new SOAP_Value("FirmSeller", "string", $result[$i]['FirmSeller']),
								"TraderIDSeller"    => new SOAP_Value("TraderIDSeller", "string", $result[$i]['TraderIDSeller']),
								"ContraFirmBuyer"    => new SOAP_Value("ContraFirmBuyer", "string", $result[$i]['ContraFirmBuyer']),
								"TraderIDBuyer"    => new SOAP_Value("TraderIDBuyer", "string", $result[$i]['TraderIDBuyer']),
								"TraderIDSender"    => new SOAP_Value("TraderIDSender", "string", $result[$i]['TraderIDSender']),
								"TraderIDReciever"    => new SOAP_Value("TraderIDReciever", "string", $result[$i]['TraderIDReciever']),
								"ContraFirm"    => new SOAP_Value("ContraFirm", "string", $result[$i]['ContraFirm']),
								"AdminMessageText"    => new SOAP_Value("AdminMessageText", "string", $result[$i]['AdminMessageText']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"ReplyCode"    => new SOAP_Value("ReplyCode", "string", $result[$i]['ReplyCode']),
								"BrokerPortfolioVolume"    => new SOAP_Value("BrokerPortfolioVolume", "string", $result[$i]['BrokerPortfolioVolume']),
								"BrokerClientVolume"    => new SOAP_Value("BrokerClientVolume", "string", $result[$i]['BrokerClientVolume']),
								"BrokerMutualFundVolume"    => new SOAP_Value("BrokerMutualFundVolume", "string", $result[$i]['BrokerMutualFundVolume']),
								"BrokerForeignVolume"    => new SOAP_Value("BrokerForeignVolume", "string", $result[$i]['BrokerForeignVolume']),
								)
						);
				}//for
				$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
				another_write_log($function_name, $content, 'directly_tranfer');
			}//if
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: update1IOrder
	*/
    function update1IOrder($MessageType, $Firm, $OrderNumber, $OrderDate, $RejectCode, $MessageText) {
		$function_name = 'update1IOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateOrder1I('%s', %u, '%s', '%s', '%s', '%s')", $MessageType, $Firm, $OrderNumber, $OrderDate, $RejectCode, $MessageText);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30211;
			} else {
				$result = $rs['varError'];
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateOrder2B
	*/
    function updateOrder2B($MessageType, $Firm, $OrderNumber, $OrderEntryDate, $RejectCode, $MessageText) {
		$function_name = 'updateOrder2B';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateOrder2B('%s', '%s', '%s', '%s', '%s', '%s')", $MessageType, $Firm, $OrderNumber, $OrderEntryDate, $RejectCode, $MessageText);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateOrder2C
	*/
    function updateOrder2C($MessageType, $Firm, $CancelShares, $OrderNumber, $OrderEntryDate, $OrderCancelStatus, $RejectCode, $MessageText) {
		$function_name = 'updateOrder2C';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateOrder2C('%s', '%s', %u, '%s', '%s', '%s', '%s', '%s')", $MessageType, $Firm, $CancelShares, $OrderNumber, $OrderEntryDate, $OrderCancelStatus, $RejectCode, $MessageText);
			//$rs = $this->_MDB2_WRITE->extended->getRow($query);
			//$this->_MDB2_WRITE->disconnect();
			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');

			$OrderDate = parse2CharDate($OrderEntryDate);
			$OrderDate = date("Y-m-d");

			if ($OrderCancelStatus == 'S') {
				//$this->_MDB2_WRITE->connect();
				$query = sprintf( "CALL sp_UnLockATOAndATCOrder( '%s', %u, '%s')", $OrderNumber, $CancelShares, $OrderDate );
				$at_rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				$content = date("d/m/Y H:i:s") ."       ". $query ;
				another_write_log($function_name, $content, 'directly_tranfer');

				if ($at_rs['varCancelValue'] > 0 ) {
					if ($at_rs['varOrderID'] > 0 ) {
						switch ($at_rs['varBankID']) {
							case DAB_ID:
								$dab = &new CDAB();
								$dab_rs = $dab->cancelBlockMoney($at_rs['varBankAccount'], $at_rs['varAccountNo'], $at_rs['varOrderID'], $at_rs['varCancelValue'] );
								$dab_rs = 0;
								break;

							case VCB_ID:
								$dab = &new CVCB();
								$vcbOrderID = $at_rs['varOrderID'] . $at_rs['varUnitCode'];
								$dab_rs = $dab->cancelBlockMoney( $at_rs['varAccountNo'], $vcbOrderID, $at_rs['varCancelValue'] );
								break;

							case NHHM:
              case OFFLINE:
								$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $at_rs['varAccountNo'], $at_rs['varBankID'], $at_rs['varOrderID'], $at_rs['varCancelValue'], 'HOET');
								$this->_MDB2_WRITE->connect();
								$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
								$this->_MDB2_WRITE->disconnect();
								$dab_rs = 0;
								break;

							case NVB_ID:
								$dab = &new CNVB();
								$dab_rs = $dab->cancelBlockMoney(substr($at_rs['varOrderID'] .date("His"), 3), $at_rs['varBankAccount'], $at_rs['varCancelValue'], $at_rs['varOrderID'] );
								$dab_rs = 0;
								break;

							default: // VIP
								$dab_rs = 0;
						}

						if ($dab_rs == 0) { //Successfully
								$this->_MDB2_WRITE->connect();
								$query = sprintf( "CALL sp_updateOrderWhenUnBlocked( %u, %u )", $at_rs['varOrderID'], $CancelShares );
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
						}
					} else { // OrderID is not exist
						$this->_ERROR_CODE = 30095;
					}
				}
			} else {
				//$this->_MDB2_WRITE->connect();
				$query = sprintf( "CALL sp_order_updateQuantityOfCancelOrder('%s', %u, '%s')", $OrderNumber, $CancelShares, $OrderDate);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if (empty( $rs)){
					$this->_ERROR_CODE = 30560;
				} else {
					$result = $rs['varError'];
					$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $result ;
					another_write_log($function_name, $content, 'directly_tranfer');

					if ($result < 0) {
//return returnXML(func_get_args(), $this->class_name, $function_name, $result, $this->items, $this );
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30561;
								break;

							case '-2':
								$this->_ERROR_CODE = 30562;
								break;

							default:
								$this->_ERROR_CODE = 666;
						}//switch
					} else {//result

						$this->_MDB2 = newInitDB();

						$query = sprintf( "CALL sp_order_getOrderInfoForCancel('%s', '%s')", $OrderNumber, $OrderDate );

						$order_rs = $this->_MDB2->extended->getRow($query);
//return returnXML(func_get_args(), $this->class_name, $function_name, 'line 670', $this->items, $this );
						if ($order_rs['OrderSideID'] == ORDER_BUY ) {
							if ( strpos (PAGODA_ACCOUNT, $order_rs['AccountNo']) === false ) {
								switch($order_rs['BankID']) {
									case DAB_ID:
										$dab = &new CDAB();
										$dab_rs = $dab->cancelBlockMoney($order_rs['BankAccount'], $order_rs['AccountNo'], $order_rs['OldOrderID'], $order_rs['OrderValue']);
										$dab_rs = 0;
										break;

									case VCB_ID:
										$dab = &new CVCB();
										$oldOrderID = $order_rs['OldOrderID'] . $order_rs['UnitCode'];
										$suffix = date("His");
										$newOrderID = $order_rs['OldOrderID'] . $suffix;
										$newAmount = $order_rs['OldOrderValue'] - $order_rs['OrderValue'];
										if ($newAmount > 0)
											$dab_rs = $dab->editBlockMoney( $order_rs['AccountNo'], $oldOrderID, $newOrderID, $order_rs['OldOrderValue'], $newAmount );
										else
											$dab_rs = $dab->cancelBlockMoney($order_rs['AccountNo'], $oldOrderID, $order_rs['OldOrderValue'] );
										break;

									case NHHM:
                  case OFFLINE:
										$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $order_rs['AccountNo'], $order_rs['BankID'], $order_rs['OldOrderID'], $order_rs['OrderValue'], 'HOET');
										$this->_MDB2_WRITE->connect();
										$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();
										$dab_rs = 0;
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->cancelBlockMoney(substr($order_rs['OldOrderID'] .date("His"), 3), $order_rs['BankAccount'], $order_rs['OrderValue'], $order_rs['OldOrderID']);
										$dab_rs = 0;
										break;

									default: // VIP
										$dab_rs = 0;
								} // switch
							} else {
								$dab_rs = 0;
							}

							if ($dab_rs != 0) { //fail
								$IsMatched = 0;
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
							} // bank
						}//buy

					}

					$this->_MDB2_WRITE->connect();
//return returnXML(func_get_args(), $this->class_name, $function_name, 'line 749', $this->items, $this );
					$query = sprintf( "CALL sp_order_updateFromTranferedToMatchedOrFailedForCancelOrder(%u, '1', 'HoET')", $order_rs['CancelOrderID']);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
//return returnXML(func_get_args(), $this->class_name, $function_name, 9999888, $this->items, $this );
					if (empty( $rs)){
						$this->_ERROR_CODE = 30221;
					} else {

						$result = $rs['varerror'];
//return returnXML(func_get_args(), $this->class_name, $function_name, 9999999, $this->items, $this );
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

					$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
					another_write_log($function_name, $content, 'directly_tranfer');

				}//ws

			}

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateOrder2D
	*/
    function updateOrder2D($MessageType, $Firm, $OrderNumber, $OrderEntryDate, $ClientID, $PortClientFlag, $PublishedVolume, $Price, $Filler, $RejectCode, $MessageText) {
		$function_name = 'updateOrder2D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateOrder2D('%s', '%s', '%s', '%s', '%s', '%s', %u, %f, '%s', '%s', '%s')", $MessageType, $Firm, $OrderNumber, $OrderEntryDate, $ClientID, $PortClientFlag, $PublishedVolume, $Price, $Filler, $RejectCode, $MessageText);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateMatchOrder2E
	*/
    function updateMatchOrder2E($MessageType, $Firm, $Side, $OrderNumber, $OrderEntryDate, $Filler, $Volume, $Price, $ConfirmNumber) {
		$function_name = 'updateMatchOrder2E';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$Price = $Price * 1000;

			$this->_MDB2_WRITE = newInitWriteDB();
			/*$query = sprintf( "CALL sp_hoet_updateMatchOrder2E('%s', '%s', '%s', '%s', '%s', '%s', %u, %f, '%s')", $MessageType, $Firm, $Side, $OrderNumber, $OrderEntryDate, $Filler, $Volume, $Price, $ConfirmNumber);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');

			$this->_MDB2_WRITE->disconnect();
			$this->_MDB2_WRITE->connect();*/
			$query = sprintf( "CALL sp_order_insertStockDetailForHOSE('%s', '%s', %u, %f, '%s', 'HOSE')", $ConfirmNumber, $OrderNumber, $Volume, $Price, date("Y-m-d")/*$OrderEntryDate*/ );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (PEAR::isError($rs)) {
				$this->_ERROR_CODE = 30211 ."	--> ". $rs->getMessage();
				another_write_log($function_name .'.redo', $query, 'directly_tranfer');
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					$this->_ERROR_CODE = $result;
					another_write_log($function_name .'_error', $query, 'directly_tranfer');
					// newSendSMS('0976149240,0908672669', "$function_name --> $ConfirmNumber, $OrderNumber, $Volume, $Price");
					newSendSMS('0908672669', "$function_name --> $ConfirmNumber, $OrderNumber, $Volume, $Price");
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
			// newSendSMS('0976149240,0908672669', "$function_name --> $ConfirmNumber, $OrderNumber, $Volume, $Price");
			newSendSMS('0908672669', "$function_name --> $ConfirmNumber, $OrderNumber, $Volume, $Price");
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateMatchOrder2I
	*/
    function updateMatchOrder2I($MessageType, $Firm, $OrderNumberBuy, $OrderEntryDateBuy, $OrderNumberSell, $OrderEntryDateSell, $Volume, $Price, $ConfirmNumber) {
		$function_name = 'updateMatchOrder2I';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			/*$query = sprintf( "CALL sp_hoet_updateMatchOrder2I('%s', '%s', '%s', '%s', '%s', '%s', %u, %f, '%s')", $MessageType, $Firm, $OrderNumberBuy, $OrderEntryDateBuy, $OrderNumberSell, $OrderEntryDateSell, $Volume, $Price, $ConfirmNumber);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');

			$this->_MDB2_WRITE->disconnect();
			$this->_MDB2_WRITE->connect();*/

			$Price = $Price * 1000;
			$query = sprintf( "CALL sp_order_insertStockDetailForHOSE('%s', '%s', %u, %f, '%s', 'HOSE')", $ConfirmNumber, $OrderNumberBuy, $Volume, $Price, date("Y-m-d")/*$OrderEntryDateBuy*/ );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (PEAR::isError($rs)) {
				$this->_ERROR_CODE = 30211 ."	--> ". $rs->getMessage();
				another_write_log($function_name .'.redo', $query, 'directly_tranfer');
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					$this->_ERROR_CODE = $result;
					another_write_log($function_name .'_error', $query, 'directly_tranfer');
					// newSendSMS('0976149240,0908672669', "$function_name --> $ConfirmNumber, $OrderNumberBuy, $Volume, $Price");
					newSendSMS('0908672669', "$function_name --> $ConfirmNumber, $OrderNumberBuy, $Volume, $Price");
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');

			$this->_MDB2_WRITE->disconnect();
			$this->_MDB2_WRITE->connect();
			$query = sprintf( "CALL sp_order_insertStockDetailForHOSE('%s', '%s', %u, %f, '%s', 'HOSE')", $ConfirmNumber, $OrderNumberSell, $Volume, $Price, date("Y-m-d")/*$OrderEntryDateSell*/ );
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (PEAR::isError($rs)) {
				$this->_ERROR_CODE = 30211 ."	--> ". $rs->getMessage();
				another_write_log($function_name .'.redo', $query, 'directly_tranfer');
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					$this->_ERROR_CODE = $result;
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
			// newSendSMS('0976149240,0908672669', "$function_name --> $ConfirmNumber, $OrderNumberBuy, $Volume, $Price");
			newSendSMS('0908672669', "$function_name --> $ConfirmNumber, $OrderNumberBuy, $Volume, $Price");
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateConfirmDealOrder2L
	*/
    function updateConfirmDealOrder2L($MessageType, $Firm, $Side, $DealID, $ContraFirm, $Volume, $Price, $ConfirmNumber) {
		$function_name = 'updateConfirmDealOrder2L';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateConfirmDealOrder2L('%s', '%s', '%s', '%s', '%s', %u, %f, '%s')", $MessageType, $Firm, $Side, $DealID, $ContraFirm, $Volume, $Price, $ConfirmNumber);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateAdmin3A
	*/
    function updateAdmin3A($MessageType, $Firm, $TraderIDSender, $TraderIDReciever, $ContraFirm, $AdminMessageText) {
		$function_name = 'updateAdmin3A';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateAdmin3A('%s', '%s', '%s', '%s', '%s', '%s')", $MessageType, $Firm, $TraderIDSender, $TraderIDReciever, $ContraFirm, $AdminMessageText);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateDealOrder2F
	*/
    function updateDealOrder2F($MessageType, $FirmBuy, $TraderIDBuy, $SideB, $ContraFirmSell, $TraderIDContraSideSell, $SecuritySymbol, $Volume, $Price, $Board, $ConfirmNumber) {
		$function_name = 'updateDealOrder2F';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateDealOrder2F('%s', '%s', '%s', '%s', '%s', '%s', '%s', %u, %f, '%s', '%s')", $MessageType, $FirmBuy, $TraderIDBuy, $SideB, $ContraFirmSell, $TraderIDContraSideSell, $SecuritySymbol, $Volume, $Price, $Board, $ConfirmNumber);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateResultDealOrder3B
	*/
    function updateResultDealOrder3B($MessageType, $Firm, $ConfirmNumber, $DealID, $ClientIDBuyer, $ReplyCode, $Filler, $BrokerPortfolioVolume, $BrokerClientVolume, $BrokerMutualFundVolume, $BrokerForeignVolume, $Filler2) {
		$function_name = 'updateResultDealOrder3B';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateResultDealOrder3B('%s', '%s', '%s', '%s', '%s', '%s', '%s', %u, %u, %u,  %u, '%s')", $MessageType, $Firm, $ConfirmNumber, $DealID, $ClientIDBuyer, $ReplyCode, $Filler, $BrokerPortfolioVolume, $BrokerClientVolume, $BrokerMutualFundVolume, $BrokerForeignVolume, $Filler2);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateCancelDealOrder3C
	*/
    function updateCancelDealOrder3C($MessageType, $Firm, $ContraFirm, $TraderID, $ConfirmNumber, $SecuritySymbol, $Side) {
		$function_name = 'updateCancelDealOrder3C';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateCancelDealOrder3C('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $MessageType, $Firm, $ContraFirm, $TraderID, $ConfirmNumber, $SecuritySymbol, $Side);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateCancelDealOrder3D
	*/
    function updateCancelDealOrder3D($MessageType, $Firm, $ConfirmNumber, $ReplyCode) {
		$function_name = 'updateCancelDealOrder3D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateCancelDealOrder3D('%s', '%s', '%s', '%s')", $MessageType, $Firm, $ConfirmNumber, $ReplyCode);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertAA
	*/
    function insertAA($MessageType, $SecurityNumber, $Volume, $Price, $Firm, $Trader, $Side, $Board, $Time, $AddCancelFlag, $Contact) {
		$function_name = 'insertAA';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertAA('%s', %u, %u, %f, %u, '%s', '%s', '%s', '%s', '%s', '%s')", $MessageType, $SecurityNumber, $Volume, $Price, $Firm, $Trader, $Side, $Board, $Time, $AddCancelFlag, $Contact);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertBR
	*/
    function insertBR($MessageType, $Firm, $MarketID, $VolumeSold, $ValueSold, $VolumeBought,  $ValueBought) {
		$function_name = 'insertBR';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertBR('%s', '%s', '%s', %u, %f, %u, %f)", $MessageType, $Firm, $MarketID, $VolumeSold, $ValueSold, $VolumeBought,  $ValueBought);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertBS
	*/
    function insertBS($MessageType, $Firm, $AutoMatchHaltFlag, $PutthroughHaltFlag) {
		$function_name = 'insertBS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertBS('%s', '%s', '%s', '%s')", $MessageType, $Firm, $AutoMatchHaltFlag, $PutthroughHaltFlag);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertCO
	*/
    function insertCO($MessageType, $ReferenceNumber) {
		$function_name = 'insertCO';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertCO('%s', '%s')", $MessageType, $ReferenceNumber);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertDC
	*/
    function insertDC($MessageType, $ConfirmNumber, $SecurityNumber, $Volume, $Price, $Board) {
		$function_name = 'insertDC';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertDC('%s', '%s', '%s', %u, %f, '%s')", $MessageType, $ConfirmNumber, $SecurityNumber, $Volume, $Price, $Board);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertGA
	*/
    function insertGA($MessageType, $AdminMessageLengh, $AdminMessageText) {
		$function_name = 'insertGA';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$AdminMessageText = trim($AdminMessageText);
			$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertGA('%s', %u, '%s')", $MessageType, $AdminMessageLengh, $AdminMessageText);
			$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			//another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
			newSendSMS('0976149240,0983500511', $AdminMessageText);
           	//sendSMS('0976149240,0983500511', $AdminMessageText);

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertIU
	*/
    function insertIU($MessageType, $IndexHoSE, $TotalTrades, $TotalSharesTraded,  $TotalValuesTraded, $UpVolume, $DownVolume, $NoChangeVolume, $Advances, $Declines, $NoChange,  $Filler1, $MarketID, $Filler2, $IndexTime) {
		$function_name = 'insertIU';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$IndexHoSE = explode(';', $IndexHoSE);
			$TotalTrades = explode(';', $TotalTrades);
			$TotalSharesTraded = explode(';', $TotalSharesTraded);
			$TotalValuesTraded = explode(';', $TotalValuesTraded);
			$UpVolume = explode(';', $UpVolume);
			$DownVolume = explode(';', $DownVolume);
			$NoChangeVolume = explode(';', $NoChangeVolume);
			$Advances = explode(';', $Advances);
			$Declines = explode(';', $Declines);
			$NoChange = explode(';', $NoChange);
			$Filler1 = explode(';', $Filler1);
			$MarketID = explode(';', $MarketID);
			$Filler2 = explode(';', $Filler2);
			$IndexTime = explode(';', $IndexTime);

			$count = count($IndexTime);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertIU('%s', %f,  %f,  %f,  %f,  %f,  %f,  %f, %u, %u, %u, '%s', '%s', '%s', '%s')", $MessageType, $IndexHoSE[$i], $TotalTrades[$i], $TotalSharesTraded[$i],  $TotalValuesTraded[$i], $UpVolume[$i], $DownVolume[$i], $NoChangeVolume[$i], $Advances[$i], $Declines[$i], $NoChange[$i],  $Filler1[$i], $MarketID[$i], $Filler2[$i], $IndexTime[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertLO
	*/
    function insertLO($MessageType, $ConfirmNumber, $SecurityNumber, $OddLotVolume, $Price, $ReferenceNumber) {
		$function_name = 'insertLO';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertLO('%s', '%s', '%s', %u, %f, '%s')", $MessageType, $ConfirmNumber, $SecurityNumber, $OddLotVolume, $Price, $ReferenceNumber);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertLS
	*/
    function insertLS($MessageType, $ConfirmNumber, $SecurityNumber, $LotVolume, $Price, $Side) {
		$function_name = 'insertLS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$ConfirmNumber = explode(';', $ConfirmNumber);
			$SecurityNumber = explode(';', $SecurityNumber);
			$LotVolume = explode(';', $LotVolume);
			$Price = explode(';', $Price);
			$Side = explode(';', $Side);

			$count = count($ConfirmNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertLS('%s', '%s', '%s', %u, %f, '%s')", $MessageType, $ConfirmNumber[$i], $SecurityNumber[$i], $LotVolume[$i], $Price[$i], $Side[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);
				//$this->_MDB2_TB_WRITE->disconnect();

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/*    function insertLS($StringInput) {
		$function_name = 'insertLS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
					//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
					$query = sprintf( "CALL sp_udp_insertLS('%s', '%s', '%s', %u, %f, '%s')", $arrElements[0], $arrElements[1], $arrElements[2], $arrElements[3], $arrElements[4], $arrElements[5]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertNH
	*/
    function insertNH($MessageType, $NewsNumber, $SecuritySymbol, $NewsHeadlineLength, $TotalNewsStoryPages, $NewsHeadlineText) {
		$function_name = 'insertNH';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertNH('%s', '%s', '%s', %u, %u, '%s')", $MessageType, $NewsNumber, $SecuritySymbol, $NewsHeadlineLength, $TotalNewsStoryPages, $NewsHeadlineText);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertNS
	*/
    function insertNS($MessageType, $NewsNumber, $NewsPageNumber, $NewsTextLength, $NewsText) {
		$function_name = 'insertNS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertNS('%s', '%s', %u, %u, '%s')", $MessageType, $NewsNumber, $NewsPageNumber, $NewsTextLength, $NewsText);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertOL
	*/
    function insertOL($MessageType, $SecurityNumber, $OddLotVolume, $Price, $Side, $ReferenceNumber) {
		$function_name = 'insertOL';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertOL('%s', '%s', %u, %f, '%s', '%s')", $MessageType, $SecurityNumber, $OddLotVolume, $Price, $Side, $ReferenceNumber);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertOS
	*/
    function insertOS($MessageType, $SecurityNumber, $Price) {
		$function_name = 'insertOS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$SecurityNumber = explode(';', $SecurityNumber);
			$Price = explode(';', $Price);

			$count = count($SecurityNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertOS('%s', '%s', %f)", $MessageType, $SecurityNumber[$i], $Price[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/*	function insertOS($StringInput) {
		$function_name = 'insertOS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
					//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
					$query = sprintf( "CALL sp_udp_insertOS('%s', '%s', %f)", $arrElements[0], $arrElements[1], $arrElements[2]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertPD
	*/
    function insertPD($MessageType, $ConfirmNumber, $SecurityNumber, $Volume, $Price, $Board) {
		$function_name = 'insertPD';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$ConfirmNumber = explode(';', $ConfirmNumber);
			$SecurityNumber = explode(';', $SecurityNumber);
			$Volume = explode(';', $Volume);
			$Price = explode(';', $Price);
			$Board = explode(';', $Board);

			$count = count($ConfirmNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertPD('%s', '%s', '%s', %u, %f, '%s')", $MessageType, $ConfirmNumber[$i], $SecurityNumber[$i], $Volume[$i], $Price[$i], $Board[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertPO
	*/
    function insertPO($MessageType, $SecurityNumber, $ProjectedOpenPrice) {
		$function_name = 'insertPO';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$SecurityNumber = explode(';', $SecurityNumber );
			$ProjectedOpenPrice = explode(';', $ProjectedOpenPrice);

			$count = count($ProjectedOpenPrice);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertPO('%s', '%s', %f)", $MessageType, $SecurityNumber[$i], $ProjectedOpenPrice[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/*    function insertPO($StringInput) {
		$function_name = 'insertPO';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
					//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
					$query = sprintf( "CALL sp_udp_insertPO('%s', '%s', %f)", $arrElements[0], $arrElements[1], $arrElements[2]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertSC
	*/
    function insertSC($MessageType, $SystemControlCode, $Timestamp) {
		$function_name = 'insertSC';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertSC('%s', '%s', '%s')", $MessageType, $SystemControlCode, $Timestamp);
			$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			//another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');

			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_Order_insertOrderSession('%s', '%s')", date("Y-m-d"), $SystemControlCode);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

            newSendSMS('0976149240,0983500511', $MessageType .'             '. $SystemControlCode);
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertSI
	*/
    function insertSI($MessageType, $IndexSectoral, $Filler, $IndexTime) {
		$function_name = 'insertSI';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$IndexSectoral = explode(';', $IndexSectoral);
			$Filler = explode(';', $Filler);
			$IndexTime = explode(';', $IndexTime);

			$count = count($IndexSectoral);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertSI('%s', %f, '%s', '%s')", $MessageType, $IndexSectoral[$i], $Filler[$i], $IndexTime[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertSR
	*/
    function insertSR($MessageType, $MainOrForeignDeal, $MainOrForeignAccVolume, $MainOrForeignAccValue, $DealsInBigLotBoard, $BigLotAccVolume, $BigLotAccValue, $DealsInOddLotBoard, $OddLotAccVolume, $OddLotAccValue) {
		$function_name = 'insertSR';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertSR('%s', %u, %u, %f, %u, %u, %f, %u, %u, %f)", $MessageType, $MainOrForeignDeal, $MainOrForeignAccVolume, $MainOrForeignAccValue, $DealsInBigLotBoard, $BigLotAccVolume, $BigLotAccValue, $DealsInOddLotBoard, $OddLotAccVolume, $OddLotAccValue);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertSS
	*/
    function insertSS($MessageType, $SecurityNumber, $Filler1, $SectorNumber, $Filler2, $HaltorResumeFlag, $SystemControlCode, $Filler3, $Suspension, $Delist, $Filler4, $Ceiling, $FloorPrice, $SecurityType, $PriorClosePrice, $Filler5, $Split, $Benefit, $Meeting, $Notice, $BoardLot, $Filler6) {
		$function_name = 'insertSS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$SecurityNumber = explode(';', $SecurityNumber);
			$Filler1 = explode(';', $Filler1);
			$SectorNumber = explode(';', $SectorNumber);
			$Filler2 = explode(';', $Filler2);
			$HaltorResumeFlag = explode(';', $HaltorResumeFlag);
			$SystemControlCode = explode(';', $SystemControlCode);
			$Filler3 = explode(';', $Filler3);
			$Suspension = explode(';', $Suspension);
			$Delist = explode(';', $Delist);
			$Filler4 = explode(';', $Filler4);
			$Ceiling = explode(';', $Ceiling);
			$FloorPrice = explode(';', $FloorPrice);
			$SecurityType = explode(';', $SecurityType);
			$PriorClosePrice = explode(';', $PriorClosePrice);
			$Filler5 = explode(';', $Filler5);
			$Split = explode(';', $Split);
			$Benefit = explode(';', $Benefit);
			$Meeting = explode(';', $Meeting);
			$Notice = explode(';', $Notice);
			$BoardLot = explode(';', $BoardLot);
			$Filler6 = explode(';', $Filler6);

			$count = count($SecurityNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertSS('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %f, %f, '%s', %f, '%s', '%s', '%s', '%s', '%s', %u, '%s')", $MessageType, $SecurityNumber[$i], $Filler1[$i], $SectorNumber[$i], $Filler2[$i], $HaltorResumeFlag[$i], $SystemControlCode[$i], $Filler3[$i], $Suspension[$i], $Delist[$i], $Filler4[$i], $Ceiling[$i], $FloorPrice[$i], $SecurityType[$i], $PriorClosePrice[$i], $Filler5[$i], $Split[$i], $Benefit[$i], $Meeting[$i], $Notice[$i], $BoardLot[$i], $Filler6[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');

				if($HaltorResumeFlag[$i] == 'H' || $HaltorResumeFlag[$i] == 'S' ) {
					$this->_MDB2_WRITE = newInitWriteDB();
					$query = sprintf( "CALL sp_updateHaltorResumeFlagAndSuspensionOnStock(%u, '%s', '%s')", $SecurityNumber[$i], $HaltorResumeFlag[$i], $Suspension[$i]);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
					$content = date("d/m/Y H:i:s") ."	". $query ;
					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/*    function insertSS($StringInput) {
		$function_name = 'insertSS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
//MessageType, $SecurityNumber, $Filler1, $SectorNumber, $Filler2, $HaltorResumeFlag, $SystemControlCode, $Filler3, $Suspension, $Delist, $Filler4, $Ceiling, $FloorPrice, $SecurityType, $PriorClosePrice, $Filler5, $Split, $Benefit, $Meeting, $Notice, $BoardLot, $Filler6
					//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
					$query = sprintf( "CALL sp_udp_insertSS('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %f, %f, '%s', %f, '%s', '%s', '%s', '%s', '%s', %u, '%s')", $arrElements[0], $arrElements[1], $arrElements[2], $arrElements[3], $arrElements[4], $arrElements[5], $arrElements[6], $arrElements[7], $arrElements[8], $arrElements[9], $arrElements[10], $arrElements[11], $arrElements[12], $arrElements[13], $arrElements[14], $arrElements[15], $arrElements[16], $arrElements[17], $arrElements[18], $arrElements[19], $arrElements[20], $arrElements[21]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');

					if($arrElements[5] == 'H' || $arrElements[5] == 'S' ) { //HaltorResumeFlag
						$this->_MDB2_WRITE = newInitWriteDB();
						$query = sprintf( "CALL sp_updateHaltorResumeFlagAndSuspensionOnStock(%u, '%s', '%s')", $arrElements[1], $arrElements[5], $arrElements[8]); //$SecurityNumber, $HaltorResumeFlag, $Suspension
						$rs = $this->_MDB2_WRITE->extended->getRow($query);
						$content = date("d/m/Y H:i:s") ."	". $query ;
						another_write_log($function_name, $content, 'directly_tranfer');
					}
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertSU
	*/
    function insertSU($MessageType, $SecurityNumberOld, $SecurityNumberNew, $Filler1, $SectorNumber, $Filler2, $SecuritySymbol, $SecurityType, $CeilingPrice, $FloorPrice, $LastSalePrice, $MarketID, $Filler3, $SecurityName, $Filler4, $Suspension, $Delist, $HaltorResumeFlag, $Split, $Benefit, $Meeting, $Notice, $ClientIDRequired, $ParValue, $SDCFlag, $PriorClosePrice, $PriorCloseDate, $OpenPrice, $HighestPrice, $LowestPrice, $TotalSharesTraded, $TotalValuesTraded, $BoardLot, $Filler5) {
		$function_name = 'insertSU';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertSU('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %f, %f, %f, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %f, '%s', %f, '%s', %f, %f, %f, %u, %u, %u, '%s')", $MessageType, $SecurityNumberOld, $SecurityNumberNew, $Filler1, $SectorNumber, $Filler2, $SecuritySymbol, $SecurityType, $CeilingPrice, $FloorPrice, $LastSalePrice, $MarketID, $Filler3, $SecurityName, $Filler4, $Suspension, $Delist, $HaltorResumeFlag, $Split, $Benefit, $Meeting, $Notice, $ClientIDRequired, $ParValue, $SDCFlag, $PriorClosePrice, $PriorCloseDate, $OpenPrice, $HighestPrice, $LowestPrice, $TotalSharesTraded, $TotalValuesTraded, $BoardLot, $Filler5);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertTC
	*/
    function insertTC($MessageType, $Firm, $TraderID, $TraderStatus) {
		$function_name = 'insertTC';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertTC('%s', '%s', '%s', '%s')", $MessageType, $Firm, $TraderID, $TraderStatus);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertTP
	*/
    function insertTP($MessageType, $SecurityNumber, $Side, $Price1Best, $LotVolume1, $Price2Best, $LotVolume2, $Price3Best, $LotVolume3) {
		$function_name = 'insertTP';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$SecurityNumber = explode(';', $SecurityNumber);
			$Side = explode(';', $Side);
			$Price1Best = explode(';', $Price1Best);
			$LotVolume1 = explode(';', $LotVolume1);
			$Price2Best = explode(';', $Price2Best);
			$LotVolume2 = explode(';', $LotVolume2);
			$Price3Best = explode(';', $Price3Best);
			$LotVolume3 = explode(';', $LotVolume3);

			$count = count($SecurityNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertTP('%s', '%s', '%s', %f, %u, %f, %u, %f, %u)", $MessageType, $SecurityNumber[$i], $Side[$i], $Price1Best[$i], $LotVolume1[$i], $Price2Best[$i], $LotVolume2[$i], $Price3Best[$i], $LotVolume3[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

/*    function insertTP($StringInput) {
		$function_name = 'insertTP';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
					//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
					$query = sprintf( "CALL sp_udp_insertTP('%s', '%s', '%s', %f, %u, %f, %u, %f, %u)", $arrElements[0], $arrElements[1], $arrElements[2], $arrElements[3], $arrElements[4], $arrElements[5], $arrElements[6], $arrElements[7], $arrElements[8]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertTR
	*/
    function insertTR($MessageType, $SecurityNumber, $TotalRoom, $CurrentRoom) {
		$function_name = 'insertTR';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$SecurityNumber = explode(';', $SecurityNumber);
			$TotalRoom = explode(';', $TotalRoom);
			$CurrentRoom = explode(';', $CurrentRoom);

			$count = count($SecurityNumber);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$query = sprintf( "CALL sp_udp_insertTR('%s', '%s', %u, %u)", $MessageType, $SecurityNumber[$i], $TotalRoom[$i], $CurrentRoom[$i]);
				//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

				$content = date("d/m/Y H:i:s") ."	". $query ;
				another_write_log('oneShot', $content, 'directly_tranfer');

				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/*function insertTR($StringInput) {
		$function_name = 'insertTR';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$arrRecords = splitIntoRecords($StringInput);
			$count = count($arrRecords);
			for($i=0; $i<$count; $i++) {
				//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
				$arrElements = explode("/", $arrRecords[$i] );
				if(count($arrElements) > 1) {
					//$query = sprintf( "CALL sp_udp_insertTR('%s', '%s', %u, %u)", $MessageType, $SecurityNumber, $TotalRoom, $CurrentRoom);
					$query = sprintf( "CALL sp_udp_insertTR('%s', '%s', %u, %u)", $arrElements[0], $arrElements[1], $arrElements[2], $arrElements[3]);
					//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

					$content = date("d/m/Y H:i:s") ."	". $query ;
					//another_write_log('oneShot', $content, 'directly_tranfer');

					another_write_log($function_name, $content, 'directly_tranfer');
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }*/

	/**
		Function: insertTS
	*/
    function insertTS($MessageType, $Timestamp) {
		$function_name = 'insertTS';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			//$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_udp_insertTS('%s', '%s')", $MessageType, $Timestamp);
			//$rs = $this->_MDB2_TB_WRITE->extended->getRow($query);

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log('oneShot', $content, 'directly_tranfer');

			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: updateReject2G
	*/
    function updateReject2G($MessageType, $Firm, $RejectReasonCode, $OriginalMessageText) {
		$function_name = 'updateReject2G';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hoet_updateReject2G('%s', '%s', '%s', '%s')", $MessageType, $Firm, $RejectReasonCode, $OriginalMessageText);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if($RejectReasonCode == '08') {
				$message = parseMessageType($OriginalMessageText);
				switch($message) {
					case '1C':
						$OrderNumber = parse2GToOrderNumber($OriginalMessageText);
						updateFailCancelOrder($OrderNumber, date("Y-m-d") ) ;

						break;
				}//switch
			}

			$content = date("d/m/Y H:i:s") ."	". $query ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: getOrderInfoToChange1D
	*/
    function getOrderInfoToChange1D($AccountNo, $OrderDate) {
		$function_name = 'getOrderInfoToChange1D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_getOrderInfoToChange1D('%s', '%s')", $AccountNo, $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['OrderID']),
								"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['OrderDate']),
								"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
								"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
								"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['OrderSideName']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['OrderStyleName']),
								"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['OrderQuantity']),
								"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['OrderPrice']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertOrderChange1D
	*/
    function insertOrderChange1D($OrderNumber, $OrderDate, $AccountNo, $CreatedBy) {
		$function_name = 'insertOrderChange1D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertOrderChange1D('%s', '%s', '%s', '%s')", $OrderNumber, $OrderDate, $AccountNo, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30540;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30541;
							break;

						case '-2':
							$this->_ERROR_CODE = 30542;
							break;

						case '-3':
							$this->_ERROR_CODE = 30543;
							break;

						case '-4':
							$this->_ERROR_CODE = 30544;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: getOrderChange1DList
	*/
    function getOrderChange1DList($OrderDate) {
		$function_name = 'getOrderChange1DList';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_getOrderChange1DList('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
								"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['OrderDate']),
								"ClientID"    => new SOAP_Value("ClientID", "string", $result[$i]['ClientID']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertAdvertisement1E
	*/
    function insertAdvertisement1E($SecuritySymbol, $Side, $Volume, $Price, $AddCancelFlag, $Contact, $CreatedBy, $Time) {
		$function_name = 'insertAdvertisement1E';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertAdvertisement1E('%s', '%s', %u, %f, '%s', '%s', '%s', '%s')", $SecuritySymbol, $Side, $Volume, $Price, $AddCancelFlag, $Contact, $CreatedBy, $Time);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30545;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30546;
							break;

						case '-2':
							$this->_ERROR_CODE = 30547;
							break;

						case '-3':
							$this->_ERROR_CODE = 30548;
							break;

				            	case '-4':
              						$this->_ERROR_CODE = 30549;
              						break;
						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertOneFirmPutThroughDeal1F
	*/
    function insertOneFirmPutThroughDeal1F($ClientIDBuyer, $ClientIDSeller, $SecuritySymbol, $Price, $DealID, $BrokerPortfolioVolumeBuyer, $BrokerClientVolumeBuyer, $MutualFundVolumeBuyer, $BrokerForeignVolumeBuyer, $BrokerPortfolioVolumeSeller, $BrokerClientVolumeSeller, $MutualFundVolumeSeller, $BrokerForeignVolumeSeller, $CreatedBy) {
		$function_name = 'insertOneFirmPutThroughDeal1F';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertOneFirmPutThroughDeal1F('%s', '%s', '%s', %f, '%s', %u, %u, %u, %u, %u, %u, %u, %u, '%s')", $ClientIDBuyer, $ClientIDSeller, $SecuritySymbol, $Price, $DealID, $BrokerPortfolioVolumeBuyer, $BrokerClientVolumeBuyer, $MutualFundVolumeBuyer, $BrokerForeignVolumeBuyer, $BrokerPortfolioVolumeSeller, $BrokerClientVolumeSeller, $MutualFundVolumeSeller, $BrokerForeignVolumeSeller, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30570;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30571;
							break;

						case '-2':
							$this->_ERROR_CODE = 30572;
							break;

						case '-3':
							$this->_ERROR_CODE = 30573;
							break;

						case '-4':
							$this->_ERROR_CODE = 30574;
							break;

						case '-5':
							$this->_ERROR_CODE = 30575;
							break;

						case '-6':
							$this->_ERROR_CODE = 30576;
							break;

						case '-7':
							$this->_ERROR_CODE = 30577;
							break;

						case '-8':
							$this->_ERROR_CODE = 30578;
							break;

            					case '-9':
              						$this->_ERROR_CODE = 30579;
              						break;
						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $result ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertDealPutThroughCancelRequest3C
	*/
    function insertDealPutThroughCancelRequest3C($ContraFirm, $ConfirmNumber, $SecuritySymbol, $Side, $CreatedBy) {
		$function_name = 'insertDealPutThroughCancelRequest3C';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertDealPutThroughCancelRequest3C('%s', '%s', '%s', '%s', '%s')", $ContraFirm, $ConfirmNumber, $SecuritySymbol, $Side, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30550;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30551;
							break;

						case '-2':
							$this->_ERROR_CODE = 30552;
							break;

						case '-3':
							$this->_ERROR_CODE = 30553;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertTwoFirmPutThroughDeal1G
	*/
    function insertTwoFirmPutThroughDeal1G($ClientIDSeller, $ContraFirmBuyer, $TraderIDBuyer, $SecuritySymbol, $Price, $DealID, $BrokerPortfolioVolumeSeller, $BrokerClientVolumeSeller, $MutualFundVolumeSeller, $BrokerForeignVolumeSeller, $CreatedBy) {
		$function_name = 'insertTwoFirmPutThroughDeal1G';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertTwoFirmPutThroughDeal1G('%s', '%s', '%s', '%s', %f, '%s', %u, %u, %u, %u, '%s')", $ClientIDSeller, $ContraFirmBuyer, $TraderIDBuyer, $SecuritySymbol, $Price, $DealID, $BrokerPortfolioVolumeSeller, $BrokerClientVolumeSeller, $MutualFundVolumeSeller, $BrokerForeignVolumeSeller, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30580;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30581;
							break;

						case '-2':
							$this->_ERROR_CODE = 30582;
							break;

						case '-3':
							$this->_ERROR_CODE = 30583;
							break;

						case '-4':
							$this->_ERROR_CODE = 30584;
							break;

						case '-5':
							$this->_ERROR_CODE = 30585;
							break;

						case '-6':
							$this->_ERROR_CODE = 30586;
							break;
            					case '-7':
              						$this->_ERROR_CODE = 30587;
              						break;
						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $result;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertPutPhroughDealReply3B
	*/
    function insertPutPhroughDealReply3B($ConfirmNumber, $DealID, $ClientIDBuyer, $ReplyCode, $BrokerPortfolioVolume, $BrokerClientVolume, $BrokerMutualFundVolume, $BrokerForeignVolume, $CreatedBy) {
		$function_name = 'insertPutPhroughDealReply3B';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertPutPhroughDealReply3B('%s', '%s', '%s', '%s', %u, %u, %u, %u, '%s')", $ConfirmNumber, $DealID, $ClientIDBuyer, $ReplyCode, $BrokerPortfolioVolume, $BrokerClientVolume, $BrokerMutualFundVolume, $BrokerForeignVolume, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30590;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30591;
							break;

						case '-2':
							$this->_ERROR_CODE = 30592;
							break;

						case '-3':
							$this->_ERROR_CODE = 30593;
							break;

						case '-4':
							$this->_ERROR_CODE = 30594;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
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


			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $result;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertDealCancelReply3D
	*/
    function insertDealCancelReply3D($ConfirmNumber, $ReplyCode, $CreatedBy) {
		$function_name = 'insertDealCancelReply3D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertDealCancelReply3D('%s', '%s', '%s')", $ConfirmNumber, $ReplyCode, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value( "ID", "string", $rs['varError']  )
							)
					);

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $rs['varError'] ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list1E
	*/
    function list1E($OrderDate) {
		$function_name = 'list1E';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list1E('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"Volume"    => new SOAP_Value("Volume", "string", $result[$i]['Volume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"Time"    => new SOAP_Value("Time", "string", $result[$i]['Time']),
								"AddCancelFlag"    => new SOAP_Value("AddCancelFlag", "string", $result[$i]['AddCancelFlag']),
								"Contact"    => new SOAP_Value("Contact", "string", $result[$i]['Contact']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list1F
	*/
    function list1F($OrderDate) {
		$function_name = 'list1F';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list1F('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"ClientIDBuyer"    => new SOAP_Value("ClientIDBuyer", "string", $result[$i]['ClientIDBuyer']),
								"ClientIDSeller"    => new SOAP_Value("ClientIDSeller", "string", $result[$i]['ClientIDSeller']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"DealID"    => new SOAP_Value("DealID", "string", $result[$i]['DealID']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"Filler2"    => new SOAP_Value("Filler2", "string", $result[$i]['Filler2']),
								"Filler3"    => new SOAP_Value("Filler3", "string", $result[$i]['Filler3']),
								"BrokerPortfolioVolumeBuyer"    => new SOAP_Value("BrokerPortfolioVolumeBuyer", "string", $result[$i]['BrokerPortfolioVolumeBuyer']),
								"BrokerClientVolumeBuyer"    => new SOAP_Value("BrokerClientVolumeBuyer", "string", $result[$i]['BrokerClientVolumeBuyer']),
								"MutualFundVolumeBuyer"    => new SOAP_Value("MutualFundVolumeBuyer", "string", $result[$i]['MutualFundVolumeBuyer']),
								"BrokerForeignVolumeBuyer"    => new SOAP_Value("BrokerForeignVolumeBuyer", "string", $result[$i]['BrokerForeignVolumeBuyer']),
								"BrokerPortfolioVolumeSeller"    => new SOAP_Value("BrokerPortfolioVolumeSeller", "string", $result[$i]['BrokerPortfolioVolumeSeller']),
								"BrokerClientVolumeSeller"    => new SOAP_Value("BrokerClientVolumeSeller", "string", $result[$i]['BrokerClientVolumeSeller']),
								"MutualFundVolumeSeller"    => new SOAP_Value("MutualFundVolumeSeller", "string", $result[$i]['MutualFundVolumeSeller']),
								"BrokerForeignVolumeSeller"    => new SOAP_Value("BrokerForeignVolumeSeller", "string", $result[$i]['BrokerForeignVolumeSeller']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list3D
	*/
    function list3D($OrderDate) {
		$function_name = 'list3D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list3D('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"ReplyCode"    => new SOAP_Value("ReplyCode", "string", $result[$i]['ReplyCode']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list3C
	*/
    function list3C($OrderDate) {
		$function_name = 'list3C';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list3C('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"ContraFirm"    => new SOAP_Value("ContraFirm", "string", $result[$i]['ContraFirm']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list2F
	*/
    function list2F($OrderDate) {
		$function_name = 'list2F';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list2F('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"FirmBuy"    => new SOAP_Value("FirmBuy", "string", $result[$i]['FirmBuy']),
								"TraderIDBuy"    => new SOAP_Value("TraderIDBuy", "string", $result[$i]['TraderIDBuy']),
								"SideB"    => new SOAP_Value("SideB", "string", $result[$i]['SideB']),
								"ContraFirmSell"    => new SOAP_Value("ContraFirmSell", "string", $result[$i]['ContraFirmSell']),
								"TraderIDContraSideSell"    => new SOAP_Value("TraderIDContraSideSell", "string", $result[$i]['TraderIDContraSideSell']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Volume"    => new SOAP_Value("Volume", "string", $result[$i]['Volume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['OrderDate']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list2L
	*/
    function list2L($OrderDate, $MessageType ) {
		$function_name = 'list2L';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list2L('%s', '%s')", $OrderDate, $MessageType );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"DealID"    => new SOAP_Value("DealID", "string", $result[$i]['DealID']),
								"ContraFirm"    => new SOAP_Value("ContraFirm", "string", $result[$i]['ContraFirm']),
								"Volume"    => new SOAP_Value("Volume", "string", $result[$i]['Volume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['OrderDate']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list3B
	*/
    function list3B($OrderDate) {
		$function_name = 'list3B';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list3B('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"ConfirmNumber"    => new SOAP_Value("ConfirmNumber", "string", $result[$i]['ConfirmNumber']),
								"DealID"    => new SOAP_Value("DealID", "string", $result[$i]['DealID']),
								"ClientIDBuyer"    => new SOAP_Value("ClientIDBuyer", "string", $result[$i]['ClientIDBuyer']),
								"ReplyCode"    => new SOAP_Value("ReplyCode", "string", $result[$i]['ReplyCode']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"BrokerPortfolioVolume"    => new SOAP_Value("BrokerPortfolioVolume", "string", $result[$i]['BrokerPortfolioVolume']),
								"BrokerClientVolume"    => new SOAP_Value("BrokerClientVolume", "string", $result[$i]['BrokerClientVolume']),
								"BrokerMutualFundVolume"    => new SOAP_Value("BrokerMutualFundVolume", "string", $result[$i]['BrokerMutualFundVolume']),
								"BrokerForeignVolume"    => new SOAP_Value("BrokerForeignVolume", "string", $result[$i]['BrokerForeignVolume']),
								"Filler2"    => new SOAP_Value("Filler2", "string", $result[$i]['Filler2']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list1G
	*/
    function list1G($OrderDate) {
		$function_name = 'list1G';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list1G('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"FirmSeller"    => new SOAP_Value("FirmSeller", "string", $result[$i]['FirmSeller']),
								"TraderIDSeller"    => new SOAP_Value("TraderIDSeller", "string", $result[$i]['TraderIDSeller']),
								"ClientIDSeller"    => new SOAP_Value("ClientIDSeller", "string", $result[$i]['ClientIDSeller']),
								"ContraFirmBuyer"    => new SOAP_Value("ContraFirmBuyer", "string", $result[$i]['ContraFirmBuyer']),
								"TraderIDBuyer"    => new SOAP_Value("TraderIDBuyer", "string", $result[$i]['TraderIDBuyer']),
								"SecuritySymbol"    => new SOAP_Value("SecuritySymbol", "string", $result[$i]['SecuritySymbol']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Board"    => new SOAP_Value("Board", "string", $result[$i]['Board']),
								"DealID"    => new SOAP_Value("DealID", "string", $result[$i]['DealID']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"BrokerPortfolioVolumeSeller"    => new SOAP_Value("BrokerPortfolioVolumeSeller", "string", $result[$i]['BrokerPortfolioVolumeSeller']),
								"BrokerClientVolumeSeller"    => new SOAP_Value("BrokerClientVolumeSeller", "string", $result[$i]['BrokerClientVolumeSeller']),
								"MutualFundVolumeSeller"    => new SOAP_Value("MutualFundVolumeSeller", "string", $result[$i]['MutualFundVolumeSeller']),
								"BrokerForeignVolumeSeller"    => new SOAP_Value("BrokerForeignVolumeSeller", "string", $result[$i]['BrokerForeignVolumeSeller']),
								"Filler2"    => new SOAP_Value("Filler2", "string", $result[$i]['Filler2']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list3A
	*/
    function list3A($OrderDate) {
		$function_name = 'list3A';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list3A('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"TraderIDSender"    => new SOAP_Value("TraderIDSender", "string", $result[$i]['TraderIDSender']),
								"TraderIDReciever"    => new SOAP_Value("TraderIDReciever", "string", $result[$i]['TraderIDReciever']),
								"ContraFirm"    => new SOAP_Value("ContraFirm", "string", $result[$i]['ContraFirm']),
								"AdminMessageText"    => new SOAP_Value("AdminMessageText", "string", $result[$i]['AdminMessageText']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: insertAdmin3A
	*/
    function insertAdmin3A($TraderIDReciever, $ContraFirm, $AdminMessageText, $CreatedBy) {
		$function_name = 'insertAdmin3A';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_order_insertAdmin3A('%s', '%s', '%s', '%s')", $TraderIDReciever, $ContraFirm, $AdminMessageText, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"ID"    => new SOAP_Value( "ID", "string", $rs['varError'] )
							)
					);

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $rs['varError']   ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list2D
	*/
    function list2D($OrderDate) {
		$function_name = 'list2D';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list2D('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
								"OrderEntryDate"    => new SOAP_Value("OrderEntryDate", "string", $result[$i]['OrderEntryDate']),
								"ClientID"    => new SOAP_Value("ClientID", "string", $result[$i]['ClientID']),
								"PortClientFlag"    => new SOAP_Value("PortClientFlag", "string", $result[$i]['PortClientFlag']),
								"PublishedVolume"    => new SOAP_Value("PublishedVolume", "string", $result[$i]['PublishedVolume']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Filler"    => new SOAP_Value("Filler", "string", $result[$i]['Filler']),
								"RejectCode"    => new SOAP_Value("RejectCode", "string", $result[$i]['RejectCode']),
								"MessageText"    => new SOAP_Value("MessageText", "string", $result[$i]['MessageText']),
								"OrderDate"    => new SOAP_Value("OrderDate", "string", $result[$i]['OrderDate']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: list2G
	*/
    function list2G($OrderDate) {
		$function_name = 'list2G';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_list2G('%s')", $OrderDate );
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"MessageType"    => new SOAP_Value("MessageType", "string", $result[$i]['MessageType']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"RejectReasonCode"    => new SOAP_Value("RejectReasonCode", "string", $result[$i]['RejectReasonCode']),
								"Description"    => new SOAP_Value("Description", "string", $result[$i]['Description']),
								"OriginalMessageText"    => new SOAP_Value("OriginalMessageText", "string", $result[$i]['OriginalMessageText']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: listPutAd
	*/
    function listPutAd($OrderDate) {
		$function_name = 'listPutAd';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "CALL sp_order_listPutAd('%s')", $OrderDate );
			$result = $this->_MDB2_TB_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"StockExchange"    => new SOAP_Value("StockExchange", "string", $result[$i]['StockExchange']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"TraderID"    => new SOAP_Value("TraderID", "string", $result[$i]['TraderID']),
								"Vol"    => new SOAP_Value("Vol", "string", $result[$i]['Vol']),
								"Price"    => new SOAP_Value("Price", "string", $result[$i]['Price']),
								"Firm"    => new SOAP_Value("Firm", "string", $result[$i]['Firm']),
								"Side"    => new SOAP_Value("Side", "string", $result[$i]['Side']),
								"Contact"    => new SOAP_Value("Contact", "string", $result[$i]['Contact']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: GetSymbolOfDealPutThrough
	*/
    function GetSymbolOfDealPutThrough($TradingDate, $Side, $DealID) {
		$function_name = 'GetSymbolOfDealPutThrough';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "SELECT f_order_GetSymbolOfDealPutThrough('%s', '%s', '%s') AS Symbol", $TradingDate, $Side, $DealID );
			$result = $this->_MDB2->extended->getRow($query);
			$count = count($result);
			if($count > 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Symbol"    => new SOAP_Value("Symbol", "string", $result['Symbol']),
							)
					);
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: CheckInValidDealIDOfPutThrough
	*/
    function CheckInValidDealIDOfPutThrough($TradingDate, $DealID) {
		$function_name = 'CheckInValidDealIDOfPutThrough';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "SELECT f_order_CheckInValidDealIDOfPutThrough('%s', '%s') AS Boolean", $TradingDate, $DealID );
			$result = $this->_MDB2->extended->getRow($query);
			$count = count($result);
			if($count > 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Boolean"    => new SOAP_Value("Boolean", "string", $result['Boolean']),
							)
					);
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: getCurrentFroom
	*/
    function getCurrentFroom($TradingDate, $Symbol) {
		$function_name = 'getCurrentFroom';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_TB_WRITE = initDBTradingBoardWrite();
			$query = sprintf( "SELECT f_getCurrentFroom('%s', '%s') AS Room", $TradingDate, $Symbol );
			$result = $this->_MDB2_TB_WRITE->extended->getRow($query);
			$count = count($result);
			if($count > 0) {
				$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Room"    => new SOAP_Value("Room", "string", $result['Room']),
							)
					);
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
		Function: getInvalidOrder
	*/
    function getInvalidOrder($OrderDate, $StockExchangeID) {
		$function_name = 'getInvalidOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2 = newInitDB();
			$query = sprintf( "CALL sp_order_getInvalidOrder('%s', %u) ", $OrderDate, $StockExchangeID);
			$result = $this->_MDB2->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['OrderID']),
								"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
								"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								)
						);
				}
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertAdvertisementForHNX($TransDate, $Symbol, $TransDesc, $OrderSide, $Quantity, $Price, $FirmBuyer, $TradeIDBuyer, $CancelFlag, $CreatedBy, $CHAR) {
		$function_name = 'insertAdvertisementForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_Adventisment_insert('%s', '%s', '%s', '%s', %u, %f, '%s', '%s', '%s', '%s', '%s')", $TransDate, $Symbol, $TransDesc, $OrderSide, $Quantity, $Price, $FirmBuyer, $TradeIDBuyer, $CancelFlag, $CreatedBy, $CHAR);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30745;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30746;
							break;

						case '-2':
							$this->_ERROR_CODE = 30747;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listAdvertisements($TradingDate) {
		$function_name = 'listAdvertisements';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_Adventisment_Grid('%s')", $TradingDate );
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"SECSYMBOL"    => new SOAP_Value("SECSYMBOL", "string", $result[$i]['SECSYMBOL']),
								"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"FIRMBUYER"    => new SOAP_Value("FIRMBUYER", "string", $result[$i]['FIRMBUYER']),
								"TRADEIDBUYER"    => new SOAP_Value("TRADEIDBUYER", "string", $result[$i]['TRADEIDBUYER']),
								"TRANSTIME"    => new SOAP_Value("TRANSTIME", "string", $result[$i]['TRANSTIME']),
								"CANCELLFLAG"    => new SOAP_Value("CANCELLFLAG", "string", $result[$i]['CANCELLFLAG']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function cancelAdvertisementForHNX($ID) {
		$function_name = 'cancelAdvertisementForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_Adventisment_Cancel(%u)", $ID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30540;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30541;
							break;

						default:
							$this->_ERROR_CODE = 666;
					}
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertOneFirm($TransDate, $StockID, $TransDesc, $TransType, $Amount, $Price, $SrcAccountID, $DscAccountID, $CreatedBy, $AccountNo, $OrgSubTranSum, $CHAR) {
		$function_name = 'insertOneFirm';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$soapclient = new SOAP_Client(WS_ORDER);
			$re = $soapclient->call( 'insertLOBuyingOrderForHNX',
					 $params = array("AccountNo" => $AccountNo,
									'StockID' => $StockID,
									'OrderQuantity' => $Amount,
									'OrderPrice' => $Price,
									'Session' => '4',
									'FromTypeID' => '1',
									'OrderDate' => $TransDate,
									"CreatedBy" => $CreatedBy,
									"AuthenUser" => 'ba.nd',
									"AuthenPass" => md5('hsc080hsc') ));
			if ($re->error_code <> "0" ) {
				$this->_ERROR_CODE = $re->error_code;
				return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

			} else { // error
				$this->_MDB2_WRITE = newInitWriteDB();
				$query = sprintf( "CALL sp_hnx_OneFirm_Insert('%s', %u, '%s', '%s', %u, %f, '%s', '%s', '%s', %u, '%s', '%s')", $TransDate, $StockID, $TransDesc, $TransType, $Amount, $Price, $SrcAccountID, $DscAccountID, $CreatedBy, $re->items[0]->ID, $OrgSubTranSum, $CHAR);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);

				if (empty( $rs)){
					$this->_ERROR_CODE = 30750;
				} else {
					$result = $rs['varError'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30751;
								break;

							case '-2':
								$this->_ERROR_CODE = 30752;
								break;

							case '-3':
								$this->_ERROR_CODE = 30753;
								break;

							case '-4':
								$this->_ERROR_CODE = 30754;
								break;

							case '-5':
								$this->_ERROR_CODE = 30755;
								break;

							case '-6':
								$this->_ERROR_CODE = 30756;
								break;

							case '-7':
								$this->_ERROR_CODE = 30757;
								break;

							case '-8':
								$this->_ERROR_CODE = 30758;
								break;

							default:
								$this->_ERROR_CODE = 666;
						} // switch
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

				$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertOneFirmCancel($ID, $CreatedBy, $TRANSDESC, $OrderDate) {
		$function_name = 'insertOneFirmCancel';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_OneFirmCancel_Insert(%u, '%s', '%s', '%s')", $ID, $CreatedBy, $TRANSDESC, $OrderDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30760;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30761;
							break;

						case '-2':
							$this->_ERROR_CODE = 30762;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listOneFirmGrid($OrderDate, $TRANSTYPE, $IsConfirmed ) {
		$function_name = 'listOneFirmGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_OneFirm_Grid('%s', '%s', '%s')", $OrderDate, $TRANSTYPE, $IsConfirmed );
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"SRCACCOUNT"    => new SOAP_Value("SRCACCOUNT", "string", $result[$i]['SRCACCOUNT']),
								"DSCACCOUNT"    => new SOAP_Value("DSCACCOUNT", "string", $result[$i]['DSCACCOUNT']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								"IDRef"    => new SOAP_Value("IDRef", "string", $result[$i]['IDRef']),
								"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['IsConfirmed']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmOrderCrossGrid($TRANSDATE) {
		$function_name = 'listTwoFirmOrderCrossGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_OrderCross_Grid('%s')", $TRANSDATE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"OrderCrossID"    => new SOAP_Value("OrderCrossID", "string", $result[$i]['OrderCrossID']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"SECSYMBOL"    => new SOAP_Value("SECSYMBOL", "string", $result[$i]['SECSYMBOL']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"ORGSUBTRANNUM"    => new SOAP_Value("ORGSUBTRANNUM", "string", $result[$i]['ORGSUBTRANNUM']),
								"CONTRAFIRM"    => new SOAP_Value("CONTRAFIRM", "string", $result[$i]['CONTRAFIRM']),
								"CONTRATRADERID"    => new SOAP_Value("CONTRATRADERID", "string", $result[$i]['CONTRATRADERID']),
								"CONFIRMNO"    => new SOAP_Value("CONFIRMNO", "string", $result[$i]['CONFIRMNO']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"IsApproved"    => new SOAP_Value("IsApproved", "string", $result[$i]['IsApproved']),
								"StockID"    => new SOAP_Value("StockID", "string", $result[$i]['StockID']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmSellerGrid($TRANSDATE) {
		$function_name = 'listTwoFirmSellerGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Seller_Grid('%s')", $TRANSDATE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"FIRMBUYER"    => new SOAP_Value("FIRMBUYER", "string", $result[$i]['FIRMBUYER']),
								"TRADEIDBUYER"    => new SOAP_Value("TRADEIDBUYER", "string", $result[$i]['TRADEIDBUYER']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmBuyerGrid($TRANSDATE) {
		$function_name = 'listTwoFirmBuyerGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Buyer_Grid('%s')", $TRANSDATE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);

			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
								"CANCELLFLAG"    => new SOAP_Value("CANCELLFLAG", "string", $result[$i]['CANCELLFLAG']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								"ORGSUBTRANNUM"    => new SOAP_Value("ORGSUBTRANNUM", "string", $result[$i]['ORGSUBTRANNUM']),
								"CONTRAFIRM"    => new SOAP_Value("CONTRAFIRM", "string", $result[$i]['CONTRAFIRM']),
								"CONTRATRADERID"    => new SOAP_Value("CONTRATRADERID", "string", $result[$i]['CONTRATRADERID']),
								"CONFIRMNO"    => new SOAP_Value("CONFIRMNO", "string", $result[$i]['CONFIRMNO']),
								"IsApproved"    => new SOAP_Value("IsApproved", "string", $result[$i]['IsApproved']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmPTCancelReqGrid($TRANSDATE) {
		$function_name = 'listTwoFirmPTCancelReqGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_PTCancelReq_Grid('%s')", $TRANSDATE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"BOORGTRANSNUM"    => new SOAP_Value("BOORGTRANSNUM", "string", $result[$i]['BOORGTRANSNUM']),
								"BOORGSUBTRANNUM"    => new SOAP_Value("BOORGSUBTRANNUM", "string", $result[$i]['BOORGSUBTRANNUM']),
								"ORGTRANSNUM"    => new SOAP_Value("ORGTRANSNUM", "string", $result[$i]['ORGTRANSNUM']),
								"ORGSUBTRANNUM"    => new SOAP_Value("ORGSUBTRANNUM", "string", $result[$i]['ORGSUBTRANNUM']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRADEDATE"    => new SOAP_Value("TRADEDATE", "string", $result[$i]['TRADEDATE']),
								"TRADETIME"    => new SOAP_Value("TRADETIME", "string", $result[$i]['TRADETIME']),
								"FIRM"    => new SOAP_Value("FIRM", "string", $result[$i]['FIRM']),
								"CONTRAFIRM"    => new SOAP_Value("CONTRAFIRM", "string", $result[$i]['CONTRAFIRM']),
								"TRADEID"    => new SOAP_Value("TRADEID", "string", $result[$i]['TRADEID']),
								"CONFIRMNO"    => new SOAP_Value("CONFIRMNO", "string", $result[$i]['CONFIRMNO']),
								"SIDE"    => new SOAP_Value("SIDE", "string", $result[$i]['SIDE']),
								"IsConfirmed"    => new SOAP_Value("IsConfirmed", "string", $result[$i]['IsConfirmed']),
								"AccountNoSeller"    => new SOAP_Value("AccountNoSeller", "string", $result[$i]['AccountNoSeller']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmCancel2FirmGrid($TRANSDATE) {
		$function_name = 'listTwoFirmCancel2FirmGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Cancel2Firm_Grid('%s')", $TRANSDATE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"FIRMBUYER"    => new SOAP_Value("FIRMBUYER", "string", $result[$i]['FIRMBUYER']),
								"TRADEIDBUYER"    => new SOAP_Value("TRADEIDBUYER", "string", $result[$i]['TRADEIDBUYER']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmReplyCancel2FirmGrid($OrderDate) {
		$function_name = 'listTwoFirmReplyCancel2FirmGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_ReplyCancel2Firm_Grid('%s')", $OrderDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value("ID", "string", $result[$i]['ID']),
								"TRANSNUM"    => new SOAP_Value("TRANSNUM", "string", $result[$i]['TRANSNUM']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
								"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
								"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"AccountNoBuyer"    => new SOAP_Value("AccountNoBuyer", "string", $result[$i]['AccountNoBuyer']),
								"CANCELLFLAG"    => new SOAP_Value("CANCELLFLAG", "string", $result[$i]['CANCELLFLAG']),
								"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
								"IDRef"    => new SOAP_Value("IDRef", "string", $result[$i]['IDRef']),
								"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['CreatedBy']),
								"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate']),
								"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['GetNumber']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function listTwoFirmPTADVGrid($SYMBOL, $TRANSDATE, $SIDE) {
		$function_name = 'listTwoFirmPTADVGrid';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_PTADV_Grid('%s', '%s', '%s')", $SYMBOL, $TRANSDATE, $SIDE);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$count = count($result);
			if($count > 0) {
				for($i=0; $i<$count; $i++) {
					$this->items[$i] = new SOAP_Value(
							'item',
							$struct,
							array(
								"SYMBOL"    => new SOAP_Value("SYMBOL", "string", $result[$i]['SYMBOL']),
								"VOLUME"    => new SOAP_Value("VOLUME", "string", $result[$i]['VOLUME']),
								"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
								"FIRM"    => new SOAP_Value("FIRM", "string", $result[$i]['FIRM']),
								"TRADEID"    => new SOAP_Value("TRADEID", "string", $result[$i]['TRADEID']),
								"SIDE"    => new SOAP_Value("SIDE", "string", $result[$i]['SIDE']),
								"ADVTIME"    => new SOAP_Value("ADVTIME", "string", $result[$i]['ADVTIME']),
								"AORC"    => new SOAP_Value("AORC", "string", $result[$i]['AORC']),
								"CONTACT"    => new SOAP_Value("CONTACT", "string", $result[$i]['CONTACT']),
								"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
								"ORGSUBTRANSNUM"    => new SOAP_Value("ORGSUBTRANSNUM", "string", $result[$i]['ORGSUBTRANSNUM']),
								)
						);
				}
			}
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
			another_write_log($function_name, $content, 'directly_tranfer');

		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function confirmChangeOrder($OrderID, $IsMatched, $MatchedQuantity, $ExchangeRefno) {
    $function_name = 'confirmChangeOrder';
    $struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

    if ( authenUser(func_get_args(), $this, $function_name) > 0 )
      return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

    if ( !required($OrderID) || !required($IsMatched) ) {
      if ( !required($OrderID) )
        $this->_ERROR_CODE = 30451;

      if ( !required($IsMatched) )
        $this->_ERROR_CODE = 30452;
    } else {
      $this->_MDB2_WRITE = newInitWriteDB();
      $query = sprintf( "CALL sp_hnx_ChangeOrder_Confirm(%u, '%s', %u, '%s' )", $OrderID, $IsMatched, $MatchedQuantity, $ExchangeRefno);
      $rs = $this->_MDB2_WRITE->extended->getRow($query);
      $this->_MDB2_WRITE->disconnect();

      if (empty( $rs)) {
        $this->_ERROR_CODE = 30453;
      } else {
        $result = $rs['varError'];
        if ($result < 0) {
          switch ($result) {
            case '-1':
              $this->_ERROR_CODE = 30454;
              break;

            case '-2':
              $this->_ERROR_CODE = 30455;
              break;

            default:
              $this->_ERROR_CODE = 666;
          } // switch
        } else {// if
          //,varOldValue,varReBlockedValue,varUnitCode,varBankID,varAccountNo,varAccountBank;
          if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false) {
            $suffix = date("His");
            if ($rs['varReBlockedValue'] > 0) {
              switch ($rs['varBankID']) {
                case DAB_ID:
                  $dab = &new CDAB();
                  $dab_rs = $dab->editBlockMoney($rs['varAccountBank'], $rs['varAccountNo'], $OrderID, $rs['varReBlockedValue'] );
                  break;

                case VCB_ID:
                  $dab = &new CVCB();
                  $oldOrderID = $OrderID . $rs['varUnitCode'];
                  $newOrderID = $OrderID . $suffix;
                  $dab_rs = $dab->editBlockMoney($rs['varAccountNo'], $oldOrderID, $newOrderID, $rs['varOldValue'], $rs['varReBlockedValue'] );
                  break;

                case NVB_ID:
                  $dab = &new CNVB();
                  $dab_rs = $dab->editBlockMoney(substr($OrderID .date("His"), 3), $rs['varAccountBank'], $rs['varReBlockedValue'], $OrderID);
                  break;

                case NHHM:
                case OFFLINE:
                  $query = sprintf( "CALL sp_VirtualBank_Edit( '%s', %u, %u, %f, '%s')", $rs['varAccountNo'], $rs['varBankID'], $OrderID, $rs['varReBlockedValue'], 'HNX');
                  $this->_MDB2_WRITE->connect();
                  $off_rs = $this->_MDB2_WRITE->extended->getRow($query);
                  $this->_MDB2_WRITE->disconnect();
                  $dab_rs = $off_rs['varError'];
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

              case NHHM:
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


    function insertConfirmOneFirmCancel($ID, $CreatedBy, $TRANSDESC, $OrderDate) {
		$function_name = 'insertConfirmOneFirmCancel';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_OneFirmCancel_Confirm_Insert(%u, '%s', '%s', '%s')", $ID, $CreatedBy, $TRANSDESC, $OrderDate);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30760;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30761;
							break;

						case '-2':
							$this->_ERROR_CODE = 30762;
							break;

						default:
							$this->_ERROR_CODE = 666;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertTwoFirm($TransDate, $StockID, $TransDesc, $TransType, $Amount, $Price, $FIRMBUYER, $TRADEIDBUYER, $SrcAccountID, $CreatedBy, $ORGSUBTRANNUM, $CHAR) {
		$function_name = 'insertTwoFirm';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Insert('%s', %u, '%s', '%s', %u, %f, '%s', '%s', %u, '%s', '%s', '%s')", $TransDate, $StockID, $TransDesc, $TransType, $Amount, $Price, $FIRMBUYER, $TRADEIDBUYER, $SrcAccountID, $CreatedBy, $ORGSUBTRANNUM, $CHAR);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30760;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30761;
							break;

						case '-2':
							$this->_ERROR_CODE = 30762;
							break;

						case '-3':
							$this->_ERROR_CODE = 30762;
							break;

						case '-4':
							$this->_ERROR_CODE = 30763;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertTwoFirmReplyCancel2Firm($TRANSDATE, $CANCELLFLAG, $IDRef, $CreatedBy) {
		$function_name = 'insertTwoFirmReplyCancel2Firm';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_ReplyCancel2Firm_insert('%s', '%s', '%s', '%s')", $TRANSDATE, $CANCELLFLAG, $IDRef, $CreatedBy);

			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			if (empty( $rs)){
				$this->_ERROR_CODE = 30780;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30781;
							break;

						case '-2':
							$this->_ERROR_CODE = 30782;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertTwoFirmReply2Firm($TRANSDATE, $TRANSDESC, $SRCACCOUNTID, $CANCELLFLAG, $OrderCrossID, $CreatedBy, $AccountNo, $StockID, $Amount, $Price) {
		$function_name = 'insertTwoFirmReply2Firm';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			// if cancelflag equal C, call sp_hnx_TwoFirm_Reply2Firm_insert - do not insert LOBuyingOrder
			if ($CANCELLFLAG != "C") {
				$soapclient = new SOAP_Client(WS_ORDER);
				$re = $soapclient->call( 'insertLOBuyingOrderForHNX',
						 $params = array("AccountNo" => $AccountNo,
										'StockID' => $StockID,
										'OrderQuantity' => $Amount,
										'OrderPrice' => $Price,
										'Session' => '4',
										'FromTypeID' => '1',
										'OrderDate' => $TRANSDATE,
										"CreatedBy" => $CreatedBy,
										"AuthenUser" => 'ba.nd',
										"AuthenPass" => md5('hsc080hsc') ));

				if ($re->error_code != "0" ) {
					$this->_ERROR_CODE = $re->error_code;
					return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
				}
				else {
					$this->_MDB2_WRITE = newInitWriteDB();
					$query = sprintf( "CALL sp_hnx_TwoFirm_Reply2Firm_insert('%s', '%s', %u, '%s', %u, '%s', %u)", $TRANSDATE, $TRANSDESC, $SRCACCOUNTID, $CANCELLFLAG, $OrderCrossID, $CreatedBy, $re->items[0]->ID);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);
				}
			}

			else { // cancelflag == C
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Reply2Firm_insert('%s', '%s', %u, '%s', %u, '%s', %u)", $TRANSDATE, $TRANSDESC, $SRCACCOUNTID, $CANCELLFLAG, $OrderCrossID, $CreatedBy, $re->items[0]->ID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);
			}

			if (empty( $rs)){
				$this->_ERROR_CODE = 30790;
			}
			else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30791;
							break;

						case '-2':
							$this->_ERROR_CODE = 30792;
							break;

						case '-3':
							$this->_ERROR_CODE = 30793;
							break;

						case '-4':
							$this->_ERROR_CODE = 30794;
							break;

						case '-5':
							$this->_ERROR_CODE = 30795;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} // switch
				} else {
					$this->items[0] = new SOAP_Value(
								'item',
								$struct,
								array(
									"ID"    => new SOAP_Value( "ID", "string", $result )
									)
							);
				}

				$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
				another_write_log($function_name, $content, 'directly_tranfer');
			}
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function insertTwoFirmCancel2Firm($IDRef, $TransDate, $CreatedBy) {
		$function_name = 'insertTwoFirmCancel2Firm';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_TwoFirm_Cancel2Firm_Insert('%s', '%s', '%s')", $IDRef, $TransDate, $CreatedBy);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30785;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30786;
							break;

						case '-2':
							$this->_ERROR_CODE = 30787;
							break;

						case '-3':
							$this->_ERROR_CODE = 30788;
							break;

						default:
							$this->_ERROR_CODE = $result;
					} // switch
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

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function CheckBuyingAndSellingWithinSameDay($SrcAccountID, $StockID, $TransDate, $OrderSideID) {
		$function_name = 'CheckBuyingAndSellingWithinSameDay';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "SELECT f_CheckBuyingAndSellingWithinSameDay(%u, %u , '%s', %u) AS Boolean", $SrcAccountID, $StockID, $TransDate, $OrderSideID);

			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			$this->items[0] = new SOAP_Value(
						'item',
						$struct,
						array(
							"Boolean"    => new SOAP_Value( "Boolean", "string", $rs['Boolean'])
							)
					);

			$this->_ERROR_CODE = $rs['Boolean'];
			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

    function updateCancelOrderForHNX($CancelQuantity, $OrderNumber, $OrderDate, $RejectCode, $OrderID) {
		$function_name = 'updateCancelOrderForHNX';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			if ($RejectCode == "100013") {
				//updateFailCancelOrder($OrderNumber, date("Y-m-d") ) ;

				$this->_MDB2_WRITE = newInitWriteDB();
				$query = sprintf( "CALL sp_updateFromTranferingToMatchedOrFailedForCancelOrder(%u, '0', 'HoET')", $OrderID);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if (empty( $rs)){
					$_ERROR_CODE = 30221;
				} else {
					$result = $rs['varError'];
					if ($result < 0) {
						switch ($result) {
							case '-1':
								$_ERROR_CODE = 30212;
								break;

							case '-2':
								$_ERROR_CODE = 30223;
								break;

							case '-3':
								$_ERROR_CODE  = 30224;
								break;

							default:
								$_ERROR_CODE  = 666;
						} //switch
					} // if result

					$content = date("d/m/Y H:i:s") ."	". $query ."	". $result;
					another_write_log('updateReject2G', $content, 'directly_tranfer');
				} // if store
			} else { //reject
				$this->_MDB2_WRITE = newInitWriteDB();
				$query = sprintf( "CALL sp_hnx_updateQuantityOfCancelOrder('%s', %u, '%s')", $OrderNumber, $CancelQuantity, $OrderDate);
				$rs = $this->_MDB2_WRITE->extended->getRow($query);
				$this->_MDB2_WRITE->disconnect();

				if (empty( $rs)){
					$this->_ERROR_CODE = 30765;
				} else {
					$result = $rs['varError'];
					$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $result ;
					another_write_log($function_name, $content, 'directly_tranfer');

					if ($result < 0) {
						switch ($result) {
							case '-1':
								$this->_ERROR_CODE = 30766;
								break;

							case '-2':
								$this->_ERROR_CODE = 30767;
								break;

							default:
								$this->_ERROR_CODE = 666;
						}//switch
					} else {//result
						$this->_MDB2 = newInitDB();
						$query = sprintf( "CALL sp_hnx_getOrderInfoForCancel('%s', '%s')", $OrderNumber, $OrderDate );
						$order_rs = $this->_MDB2->extended->getRow($query);

						if ($order_rs['OrderSideID'] == ORDER_BUY ) {
							if ( strpos (PAGODA_ACCOUNT, $order_rs['AccountNo']) === false ) {
								switch($order_rs['BankID']) {
									case DAB_ID:
										$dab = &new CDAB();
										$dab_rs = $dab->cancelBlockMoney($order_rs['BankAccount'], $order_rs['AccountNo'], $order_rs['OldOrderID'], $order_rs['OrderValue']);
										$dab_rs = 0;
										break;

									case VCB_ID:
										$dab = &new CVCB();
										$oldOrderID = $order_rs['OldOrderID'] . $order_rs['UnitCode'];
										$suffix = date("His");
										$newOrderID = $order_rs['OldOrderID'] . $suffix;
										$newAmount = $order_rs['OldOrderValue'] - $order_rs['OrderValue'];
										if ($newAmount > 0)
											$dab_rs = $dab->editBlockMoney( $order_rs['AccountNo'], $oldOrderID, $newOrderID, $order_rs['OldOrderValue'], $newAmount );
										else
											$dab_rs = $dab->cancelBlockMoney($order_rs['AccountNo'], $oldOrderID, $order_rs['OldOrderValue'] );
										break;

									case NHHM:
                  case OFFLINE:
										$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $order_rs['AccountNo'], $order_rs['BankID'], $order_rs['OldOrderID'], $order_rs['OrderValue'], 'HOET');
										$this->_MDB2_WRITE->connect();
										$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
										$this->_MDB2_WRITE->disconnect();
										$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $off_rs['varError'];
										another_write_log($function_name, $content, 'directly_tranfer');
										$dab_rs = 0;
										break;

									case NVB_ID:
										$dab = &new CNVB();
										$dab_rs = $dab->cancelBlockMoney(substr($order_rs['OldOrderID'] .date("His"), 3), $order_rs['BankAccount'], $order_rs['OrderValue'], $order_rs['OldOrderID']);
										$dab_rs = 0;
										break;

									default: // VIP
										$dab_rs = 0;
								} // switch
							} else {
								$dab_rs = 0;
							}

							if ($dab_rs != 0) { //fail
								$IsMatched = 0;
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
							} // bank
						}//buy

					}

					$this->_MDB2_WRITE->connect();
					$query = sprintf( "CALL sp_hnx_updateFromTranferedToMatchedOrFailedForCancelOrder(%u, '1', 'HNX')", $order_rs['CancelOrderID']);
					$rs = $this->_MDB2_WRITE->extended->getRow($query);

					if (empty( $rs)){
						$this->_ERROR_CODE = 30775;
					} else {
						$result = $rs['varerror'];
						if ($result < 0) {
							switch ($result) {
								case '-1':
									$this->_ERROR_CODE = 30776;
									break;

								case '-2':
									$this->_ERROR_CODE = 30777;
									break;

								default:
									$this->_ERROR_CODE = 666;
							} //switch

						} // if result
					} // if store

					$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
					another_write_log($function_name, $content, 'directly_tranfer');
				}//ws
			}//if reject
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
    }

	/**
	 * Function: Unlock Money at Bank
	 */
	function unlockMoneyAtBank($AccountNo, $BankID, $BankAccount, $OldOrderID, $OrderValue, $UnitCode ) {
		$function_name = 'unlockMoneyAtBank';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try {
			if ( strpos (PAGODA_ACCOUNT, $AccountNo) === false ) {
				switch($BankID) {
					case DAB_ID:
						$dab = &new CDAB();
						$dab_rs = $dab->cancelBlockMoney($BankAccount, $AccountNo, $OldOrderID, $OrderValue);
						$dab_rs = 0;
						break;

					case VCB_ID:
						$dab = &new CVCB();
						$oldOrderID = $OldOrderID . $UnitCode;
						$suffix = date("His");
						$newOrderID = $OldOrderID . $suffix;
						$newAmount = $OldOrderValue - $OrderValue;
						if ($newAmount > 0)
							$dab_rs = $dab->editBlockMoney( $AccountNo, $oldOrderID, $newOrderID, $OldOrderValue, $newAmount );
						else
							$dab_rs = $dab->cancelBlockMoney($AccountNo, $oldOrderID, $OldOrderValue );
						break;

					case NHHM:
          case OFFLINE:
						$query = sprintf( "CALL sp_VirtualBank_Cancel('%s', %u, %u, %f, '%s')", $AccountNo, $BankID, $OldOrderID, $OrderValue, 'HNX');
						$this->_MDB2_WRITE = newInitWriteDB();
						$off_rs = $this->_MDB2_WRITE->extended->getRow($query);
						$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $off_rs['varError'];
						another_write_log($function_name, $content, 'directly_tranfer');
						$dab_rs = 0;
						break;

					case NVB_ID:
						$dab = &new CNVB();
						$dab_rs = $dab->cancelBlockMoney(substr($OldOrderID .date("His"), 3), $BankAccount, $OrderValue, $OldOrderID);
						$dab_rs = 0;
						break;

					default: // VIP
						$dab_rs = 0;
				} // switch
			} else {
				$dab_rs = 0;
			}

			if ($dab_rs != 0) { //fail
				$IsMatched = 0;
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
			} // bank
		}	catch(Exception $e) {
				$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function: get push order grid
	 */
	function getPushOrderGrid($AccountNo, $IsPush, $OrderDate) {
	$function_name = 'getPushOrderGrid';
	$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

	if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	try{
		$this->_MDB2_WRITE = newInitWriteDB();
		$query = sprintf( "CALL sp_hnx_PushOrder_Grid('%s', %u, '%s')", $AccountNo, $IsPush, $OrderDate);
		$result = $this->_MDB2_WRITE->extended->getAll($query);
		$count = count($result);
		if($count > 0) {
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['OrderID']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
							"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['OrderSideName']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
							"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['OrderQuantity']),
							"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['OrderPrice']),
							"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
							"IsPush"    => new SOAP_Value("IsPush", "string", $result[$i]['IsPush']),
							"CreatedBy"    => new SOAP_Value("CreatedBy", "string", $result[$i]['o.CreatedBy']),
							"CreatedDate"    => new SOAP_Value("CreatedDate", "string", $result[$i]['CreatedDate'])
							)
					);
			}
		}
		$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
		another_write_log($function_name, $content, 'directly_tranfer');

	} catch(Exception $e) {
		$this->_ERROR_CODE = $e->getMessage();
	}
	return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	/**
	 * Function: push order push
	 */
	function pushOrderPush($OrderID, $OrderDate, $UpdatedBy) {
	$function_name = 'pushOrderPush';
	$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

	if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	try{
		$this->_MDB2_WRITE = newInitWriteDB();
		$query = sprintf( "CALL sp_hnx_PushOrder_Push(%u, '%s' , '%s')", $OrderID, $OrderDate, $UpdatedBy);

		$rs = $this->_MDB2_WRITE->extended->getRow($query);

		$this->items[0] = new SOAP_Value(
					'item',
					$struct,
					array(
						"Boolean"    => new SOAP_Value( "Boolean", "string", $rs['varError'])
						)
				);

		$this->_ERROR_CODE = $rs['varError'];
		$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
		another_write_log($function_name, $content, 'directly_tranfer');
	} catch(Exception $e) {
		$this->_ERROR_CODE = $e->getMessage();
	}
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

				$this->_MDB2_WRITE = newInitWriteDB();
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

	function getListApprovedOrderForHNX($OrderDate) {
	$function_name = 'getListApprovedOrderForHNX';
	$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

	if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	try{
		$this->_MDB2_WRITE = newInitWriteDB();
		$query = sprintf( "CALL sp_hnx_NewOrder('%s')", $OrderDate);
		$result = $this->_MDB2_WRITE->extended->getAll($query);
		$count = count($result);
		if($count > 0) {
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"MTI"    => new SOAP_Value("MTI", "string", $result[$i]['MTI']),
							"TRANSCODE"    => new SOAP_Value("TRANSCODE", "string", $result[$i]['TRANSCODE']),
							"TRANSSUBCODE"    => new SOAP_Value("TRANSSUBCODE", "string", $result[$i]['TRANSSUBCODE']),
							"BUSSINESSDATE"    => new SOAP_Value("BUSSINESSDATE", "string", $result[$i]['BUSSINESSDATE']),
							"TRANSDATE"    => new SOAP_Value("TRANSDATE", "string", $result[$i]['TRANSDATE']),
							"TRANSTIME"    => new SOAP_Value("TRANSTIME", "string", $result[$i]['TRANSTIME']),
							"EXCHANGEID"    => new SOAP_Value("EXCHANGEID", "string", $result[$i]['EXCHANGEID']),
							"SECSYMBOL"    => new SOAP_Value("SECSYMBOL", "string", $result[$i]['SECSYMBOL']),
							"TRANSDESC"    => new SOAP_Value("TRANSDESC", "string", $result[$i]['TRANSDESC']),
							"TRANSSTATUS"    => new SOAP_Value("TRANSSTATUS", "string", $result[$i]['TRANSSTATUS']),
							"TRANSTYPE"    => new SOAP_Value("TRANSTYPE", "string", $result[$i]['TRANSTYPE']),
							"AMOUNT"    => new SOAP_Value("AMOUNT", "string", $result[$i]['AMOUNT']),
							"PRICETYPE"    => new SOAP_Value("PRICETYPE", "string", $result[$i]['PRICETYPE']),
							"PRICE"    => new SOAP_Value("PRICE", "string", $result[$i]['PRICE']),
							"FIRM"    => new SOAP_Value("FIRM", "string", $result[$i]['FIRM']),
							"TRADEID"    => new SOAP_Value("TRADEID", "string", $result[$i]['TRADEID']),
							"BOARD"    => new SOAP_Value("BOARD", "string", $result[$i]['BOARD']),
							"SRCACCOUNT"    => new SOAP_Value("SRCACCOUNT", "string", $result[$i]['SRCACCOUNT']),
							"CLIENTFLAG"    => new SOAP_Value("CLIENTFLAG", "string", $result[$i]['CLIENTFLAG']),
							"BOORGTRANSNUM"    => new SOAP_Value("BOORGTRANSNUM", "string", $result[$i]['BOORGTRANSNUM']),
							"DELETE"    => new SOAP_Value("DELETE", "string", $result[$i]['DELETE']),
							"LOCALMACHINE"    => new SOAP_Value("LOCALMACHINE", "string", $result[$i]['LOCALMACHINE']),
							"LOCALIPADDRESS"    => new SOAP_Value("LOCALIPADDRESS", "string", $result[$i]['LOCALIPADDRESS']),
							"MAKERID"    => new SOAP_Value("MAKERID", "string", $result[$i]['MAKERID']),
							"CHECKERID"    => new SOAP_Value("CHECKERID", "string", $result[$i]['CHECKERID']),
							"SECUSERNAME"    => new SOAP_Value("SECUSERNAME", "string", $result[$i]['SECUSERNAME']),
							"SECUSERPASSWORD"    => new SOAP_Value("SECUSERPASSWORD", "string", $result[$i]['SECUSERPASSWORD'])
							)
					);
			}
		}
		$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
		another_write_log($function_name, $content, 'directly_tranfer');

	} catch(Exception $e) {
		$this->_ERROR_CODE = $e->getMessage();
	}
	return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function resendTransferOrder($OrderDate, $OrderID) {
		$function_name = 'resendTransferOrder';
		$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
			return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

		try{
			$this->_MDB2_WRITE = newInitWriteDB();
			$query = sprintf( "CALL sp_hnx_ResendTransferingOrder('%s', %u)", $OrderDate, $OrderID);
			$rs = $this->_MDB2_WRITE->extended->getRow($query);

			if (empty( $rs)){
				$this->_ERROR_CODE = 30540;
			} else {
				$result = $rs['varError'];
				if ($result < 0) {
					switch ($result) {
						case '-1':
							$this->_ERROR_CODE = 30541;
							break;

						default:
							$this->_ERROR_CODE = 30435;
							break;
					}
				}
			}

			$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $this->_ERROR_CODE ;
			another_write_log($function_name, $content, 'directly_tranfer');
		} catch(Exception $e) {
			$this->_ERROR_CODE = $e->getMessage();
		}
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	function getTransferingOrderForReSend($OrderDate, $AccountNo, $OrderID) {
	$function_name = 'getTransferingOrderForReSend';
	$struct = '{urn:'. $this->class_name .'}'. $function_name . 'Struct';

	if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );

	try{
		$this->_MDB2_WRITE = newInitWriteDB();
		$query = sprintf( "CALL sp_hnx_GetTransferingOrderForReSend('%s', '%s', %u)", $OrderDate, $AccountNo, $OrderID);

		$result = $this->_MDB2_WRITE->extended->getAll($query);
		$count = count($result);
		if($count > 0) {
			for($i=0; $i<$count; $i++) {
				$this->items[$i] = new SOAP_Value(
						'item',
						$struct,
						array(
							"OrderID"    => new SOAP_Value("OrderID", "string", $result[$i]['OrderID']),
							"OrderNumber"    => new SOAP_Value("OrderNumber", "string", $result[$i]['OrderNumber']),
							"AccountNo"    => new SOAP_Value("AccountNo", "string", $result[$i]['AccountNo']),
							"OrderSideName"    => new SOAP_Value("OrderSideName", "string", $result[$i]['OrderSideName']),
							"Symbol"    => new SOAP_Value("Symbol", "string", $result[$i]['Symbol']),
							"OrderStyleName"    => new SOAP_Value("OrderStyleName", "string", $result[$i]['OrderStyleName']),
							"OrderPrice"    => new SOAP_Value("OrderPrice", "string", $result[$i]['OrderPrice']),
							"OrderQuantity"    => new SOAP_Value("OrderQuantity", "string", $result[$i]['OrderQuantity']),
							"StatusName"    => new SOAP_Value("StatusName", "string", $result[$i]['StatusName']),
							"GetNumber"    => new SOAP_Value("GetNumber", "string", $result[$i]['o.GetNumber'])
							)
					);
			}
		}
		$content = date("d/m/Y H:i:s") ."	". $query ."	--> ". $count;
		another_write_log($function_name, $content, 'directly_tranfer');

	} catch(Exception $e) {
		$this->_ERROR_CODE = $e->getMessage();
	}
	return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateFailCancelOrder($OrderNumber, $OrderDate) {
	$mdb2_read = newInitDB();
	$mdb2_write = newInitWriteDB();
	$_ERROR_CODE = 0;

	$query = sprintf("CALL sp_order_getOrderInfoForCancel('%s', '%s')", $OrderNumber, $OrderDate);
	$cancel_rs = $mdb2_read->extended->getRow($query);
	$mdb2_read->disconnect();
	$content = date("d/m/Y H:i:s") ."	". $query ;
	another_write_log('updateReject2G', $content, 'directly_tranfer');

	if ($cancel_rs['CancelOrderID'] > 0) {
		$query = sprintf( "CALL sp_updateFromTranferingToMatchedOrFailedForCancelOrder(%u, '0', 'HoET')", $cancel_rs['CancelOrderID']);
		$rs = $mdb2_write->extended->getRow($query);
		$mdb2_write->disconnect();

		if (empty( $rs)){
			$_ERROR_CODE = 30221;
		} else {
			$result = $rs['varError'];
			if ($result < 0) {
				switch ($result) {
					case '-1':
						$_ERROR_CODE = 30212;
						break;

					case '-2':
						$_ERROR_CODE = 30223;
						break;

					case '-3':
						$_ERROR_CODE  = 30224;
						break;

					default:
						$_ERROR_CODE  = 666;
				} //switch
			} // if result

			$content = date("d/m/Y H:i:s") ."	". $query ."	". $result;
			another_write_log('updateReject2G', $content, 'directly_tranfer');
		} // if store
	} else {//OrderID
		$_ERROR_CODE  = 999;
	}
	return $_ERROR_CODE;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function newInitDB() {
	//initialize MDB2
	$mdb2 = &MDB2::factory(DB_DNS);
	$mdb2->loadModule('Extended');
	$mdb2->loadModule('Date');
	$mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	return $mdb2;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
	Description: init DB for WRITE;
	input: null
	return db object
*/
function newInitWriteDB()
{
	//initialize MDB2
	$mdb2 = &MDB2::factory(DB_DNS_WRITE);
	$mdb2->loadModule('Extended');
	$mdb2->loadModule('Date');
	$mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	return $mdb2;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function initDBTradingBoardWrite() {
        //initialize MDB2
        $mdb2 = &MDB2::factory(DB_DNS_TRADING_BOARD);
        $mdb2->loadModule('Extended');
        $mdb2->loadModule('Date');
        $mdb2->setOption('portability', MDB2_PORTABILITY_NONE);
        $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
        return $mdb2;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function parse2GToOrderNumber($str) {
	$str = trim($str);
	if(strlen($str) > 0) {
		$MessageType = 2;
		$Firm = 2;
		$OrderDate = 4;
		$str = substr($str, $MessageType + $Firm );
	        $str = trim($str);
		//$str = substr($str, 0, strlen($str) - $OrderDate );
		$str = substr($str, 0, 8);
	}
	return $str;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function parseMessageType($str) {
	$str = trim($str);
	if(strlen($str) > 0) {
		$MessageType = 2;
		$str = substr($str, 0, $MessageType );
	}
	return $str;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function parse2CharDate($str) {
	$date = substr($str, 0, 2);
	$month = substr($str, -2);
	return date('Y') .'-'. $month .'-'. $date;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function newSendSMS($array, $Message ) {
return 200;
        require_once 'HTTP/Client.php';
        $Message = str_replace(" ", "%20", $Message);
        $client =& new HTTP_Client();
        $ok=$client->get('http://172.25.2.6:8888/?PhoneNumber='.$array.'&Text='.$Message);
        return $ok;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function checkVIPAccount($AccountNo) {
	$MDB2 = initDB();
	$query = sprintf( "SELECT f_VipList_IsExisted('%s') AS Boolean", $AccountNo);
	$result = $MDB2->extended->getRow($query);
	return $result['boolean'];
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function splitIntoRecords($str) {
	if($str <> '') {
		$arrRecords = explode(";", $str);
		return $arrRecords;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function another_write_log($filename, $content, $path='temp/', $obj=NULL) {
	$path = '/home/vhosts/hoet/'. $path .'/';
	$date_array = getdate();

	if($obj <> NULL) {
		$count = count($obj);
		$user = $obj[$count-2];
	}

	if (!is_dir($path)){
		mkdir( $path, 0755 );
	}
	$csv_dir = $path .'/'. $date_array['year'].'/';
	if (!is_dir($csv_dir)){
		mkdir( $csv_dir, 0755 );
	}
	$csv_dir = $csv_dir.$date_array['mon'].'/';
	if (!is_dir($csv_dir)){
		mkdir( $csv_dir, 0755 );
	}
	if($user <> '')
		$filepath = $csv_dir . $date_array['year'] . $date_array['mon'] . $date_array['mday'] .'_'. $user .'.txt';
	else
		$filepath = $csv_dir . $date_array['year'] . $date_array['mon'] . $date_array['mday'] .'_'. $filename .'.txt';

	$message  = '';

	if ( ! file_exists($filepath)) {
		$message .= "<!-- Log file ".$date_array['mon'].'-'.$date_array['year']." --!>\n\n";
	}

	if ( ! $fp = @fopen($filepath, "a")) {
		return FALSE;
	}

	$message .= ' --> '.$content."\n";

	flock($fp, LOCK_EX);
	fwrite($fp, $message);
	flock($fp, LOCK_UN);
	fclose($fp);

	@chmod($filepath, 0644);

}

?>
