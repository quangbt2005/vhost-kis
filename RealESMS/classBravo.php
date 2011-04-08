<?php
/**
	Author: Diep Le Chi
	Created date: 19/03/2007
	Nguyen Dinh Ba: call sp_getSellingValueAndFeeListForBravo('2007-08-02'); T3 anh Quan goi khi chay cron
Nguyen Dinh Ba: call sp_getBuyingValueAndFeeListForBravo('2007-07-30'); T Binh chay khi ket thuc giao dich
*/
require_once('../includes.php');

define("VIRTUAL_BANK_BANKCODE", 61);
class CBravoMoney extends WS_Class{
	var $_MDB2;
	var $_MDB2_WRITE;
	var $_ERROR_CODE;
	var $items;
	/*
		constructor	
	*/
	
	function CBravoMoney($check_ip) {
		//initialize _MDB2
		$this->_MDB2 = initDB() ;
		$this->_MDB2_WRITE = initWriteDB();
		$this->_ERROR_CODE = $check_ip;
		//$this->_TIME_ZONE = get_timezon();
		$this->items = array();
		
		$this->class_name = get_class($this);
		$arr = array( 
					'SellingValueAndFeeListForBravo' => array( 	
										'input' => array('TradingDate'),
										'output' => array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError', 'Tax' )
										),
					'SellingValueAndFeeListForBravoTDate' => array( 	
										'input' => array('TradingDate'),
										'output' => array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError', 'Tax' )
										),
					'BuyingValueAndFeeListForBravo' => array( 
										'input' => array( 'TradingDate'),
										'output' => array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError')
										),
					'PaidAdvanceForBravo' => array( 
										'input' => array( 'TradingDate'),
										'output' => array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError', 'BankID', 'OrderBankBravoCode')
										),
					'CloseBravoAccount' => array( 
										'input' => array( 'AccountNo'),
										'output' => array()
										)

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
	 * Function SellingValueAndFeeListForBravo ngay T3	: update money --> bravo
	 * Input 				: $TradingDate
	 * OutPut 				: error code and items ( AccountNo, Amount, Fee and bravoerrocode)
	 */
/*	function SellingValueAndFeeListForBravo($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'SellingValueAndFeeListForBravo';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$date_array = getdate();
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Sell_T3Date.csv')===true) {	
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		} else {	
			$query = sprintf('select f_getTDate("%s",3) as TDate',$TradingDate);
			$result = $this->_MDB2->extended->getAll($query);
			$Tdate = $result[0]['tdate'];
			$query = sprintf('call sp_getSellingValueAndFeeListForBravo("%s")',$Tdate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0) {
				$this->export_csv($TradingDate,$result,'sell');
				$soap = &new Bravo();			
				$Note = "Tien ban chung khoan";
				$bravolist = array();
				for($i=0; $i<$num_row; $i++) {
					$sellingstock = array("TradingDate" => $TradingDate, 
										"AccountNo" => $result[$i]['accountno'], 
										"Amount" => (int)$result[$i]['bravocode']==VIRTUAL_BANK_BANKCODE ? $result[$i]['value'] : 0, 
										"Fee" => $result[$i]['commission'], 
										"Bank" => $result[$i]['bravocode'], 
										"Branch" => $result[$i]['branchname'], 
										"Type" => $result[$i]['investortype'], 
										"Note" => 'Ban ck ngay '.$Tdate.' - '.$Note, 
										'TDate' => 3); 
					$ret = $soap->sellingstock($sellingstock);
					$bravoerror = 0;
					if($ret['table0']['Result']==1) 
						$bravoerror = 0;
					if($ret['table0']['Result']==-2) 
						$bravoerror = 23002;
					if($ret['table0']['Result']==-1) 
						$bravoerror = 23003;
					if($ret['table0']['Result']==-13) 
						$bravoerror = 23006;
					if($ret['table0']['Result']==-15) 
						$bravoerror = 23005;
					if($ret['table0']['Result']==-16) 
						$bravoerror = 23004;

					$withdrawValue = array( "TradingDate" => date("Y-m-d"), 
											'TransactionType'=> "M18.02", 
											"AccountNo" => $result[$i]['accountno'], 
											"Amount" => $result[$i]['tax'], 
											"Bank" => $result[$i]['bravocode'], 
											"Branch" => $result[$i]['branchname'], 
											"Note" => "Thue TNCN");
					$ret = $soap->withdraw($withdrawValue);

					switch ($ret['table0']['Result']) {
						case '-2':
							$bravoerror = $bravoerror .'	'. 23002;
							break;

						case '-1':
							$bravoerror = $bravoerror .'	'. 23003;
							break;

						case '-13':
							$bravoerror = $bravoerror .'	'. 23006;
							break;

						case '-15':
							$bravoerror = $bravoerror .'	'. 23005;
							break;

						case '-16':
							$bravoerror = $bravoerror .'	'. 23004;
							break;

						default:
							$bravoerror = $bravoerror .'	'. $ret['table0']['Result'];						
					}//switch

					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'Tax'  => new SOAP_Value("Tax", "string", $result[$i]['tax']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)												
							)
						);
					
					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['value'],
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'Tax' => $result[$i]['tax'],
							'BravoError'  => $bravoerror												
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'Tax', 'BravoError');	
					csv_bank($bravolist,$TradingDate.'_Bravolist_Sell_T3Date',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );		
	}*/

	function SellingValueAndFeeListForBravo($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'SellingValueAndFeeListForBravo';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$date_array = getdate();
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Sell_T3Date.csv')===true) {
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		} else {
			$query = sprintf('select f_getTDate("%s",3) as TDate',$TradingDate);
			$result = $this->_MDB2->extended->getAll($query);
			$Tdate = $result[0]['tdate'];
			$query = sprintf('call sp_getSellingValueAndFeeListForBravo("%s")',$Tdate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0) {
				$this->export_csv($TradingDate,$result,'sell');
				$soap = &new Bravo();
				$Note = "Tien ban chung khoan";
				$bravolist = array();
				for($i=0; $i<$num_row; $i++) {
					$sellingstock = array("TradingDate" => $TradingDate,
										"AccountNo" => $result[$i]['accountno'],
										"Amount" => (int)$result[$i]['bravocode']==VIRTUAL_BANK_BRAVO_BANKCODE ? $result[$i]['value'] : 0,
										"Fee" => $result[$i]['commission'],
										"Bank" => $result[$i]['bravocode'],
										"Branch" => $result[$i]['branchname'],
										"Type" => $result[$i]['investortype'],
										"Note" => 'Ban ck ngay '.$Tdate.' - '.$Note,
										'TDate' => 3);
					$ret = $soap->sellingstock($sellingstock);
					$bravoerror = 0;
					if($ret['table0']['Result']==1)
						$bravoerror = 0;
					if($ret['table0']['Result']==-2)
						$bravoerror = 23002;
					if($ret['table0']['Result']==-1)
						$bravoerror = 23003;
					if($ret['table0']['Result']==-13)
						$bravoerror = 23006;
					if($ret['table0']['Result']==-15)
						$bravoerror = 23005;
					if($ret['table0']['Result']==-16)
						$bravoerror = 23004;

          // ------------------------------------------------------------------------------------ //
          // 20100615 - ma link M03.05 neu bravo_code = ngan hang ao
          // fee = amount
          // ------------------------------------------------------------------------------------ //
          $transactionType = "M18.02";
          $fee = 0;
          $note = "Thue TNCN";
          if((int)$result[$i]['bravocode']==(int)VIRTUAL_BANK_BRAVO_BANKCODE)
          {
          	$transactionType = "M03.05";
            $fee = $result[$i]['tax'];
            $note = "Thue TNCN ban chung khoan ngay T2";
          }
          // ------------------------------------------------------------------------------------ //
          // End 20100615
          // ------------------------------------------------------------------------------------ //
					$withdrawValue = array( "TradingDate" => date("Y-m-d"),
											'TransactionType'=> $transactionType,
											"AccountNo"      => $result[$i]['accountno'],
											"Amount"         => $result[$i]['tax'],
                      "Fee"            => $fee,
											"Bank"           => $result[$i]['bravocode'],
											"Branch"         => $result[$i]['branchname'],
											"Note"           => $note);
					$ret = $soap->withdraw($withdrawValue);

					switch ($ret['table0']['Result']) {
						case '-2':
							$bravoerror = $bravoerror .'	'. 23002;
							break;

						case '-1':
							$bravoerror = $bravoerror .'	'. 23003;
							break;

						case '-13':
							$bravoerror = $bravoerror .'	'. 23006;
							break;

						case '-15':
							$bravoerror = $bravoerror .'	'. 23005;
							break;

						case '-16':
							$bravoerror = $bravoerror .'	'. 23004;
							break;

						default:
							$bravoerror = $bravoerror .'	'. $ret['table0']['Result'];
					}//switch

					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", (int)$result[$i]['bravocode']==VIRTUAL_BANK_BRAVO_BANKCODE ? $result[$i]['value'] : 0),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'Tax'  => new SOAP_Value("Tax", "string", $result[$i]['tax']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)
							)
						);

					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => (int)$result[$i]['bravocode']==VIRTUAL_BANK_BRAVO_BANKCODE ? $result[$i]['value'] : 0,
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');
					csv_bank($bravolist,$TradingDate.'_Bravolist_Sell_T3Date',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	
	/**
	 * Function SellingValueAndFeeListForBravo ngay T	: update money --> bravo
	 * Input 				: $TradingDate
	 * OutPut 				: error code and items ( AccountNo, Amount, Fee and bravoerrocode)
	 */
	/*function SellingValueAndFeeListForBravoTDate($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'SellingValueAndFeeListForBravoTDate';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$date_array = getdate();
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Sell_TDate.csv')===true) {	
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		} else {			
			$query = sprintf('call sp_getSellingValueAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0) {
				$this->export_csv($TradingDate,$result,'sell');
				$soap = &new Bravo();			
				$Note = "Tien ban chung khoan";
				$bravolist = array();
				for($i=0; $i<$num_row; $i++) {
					$sellingstock = array("TradingDate" => $TradingDate, 
										"AccountNo" => $result[$i]['accountno'], 
										"Amount" => $result[$i]['value'], 
										"Fee" => $result[$i]['commission'], 
										"Bank" => $result[$i]['bravocode'], 
										"Branch" => $result[$i]['branchname'], 
										"Type" => $result[$i]['investortype'], 
										"Note" => 'Ban ck ngay '.$TradingDate.' - '.$Note, 
										'TDate' => 0); 
					$ret = $soap->sellingstock($sellingstock);
					$bravoerror = 0;
					if($ret['table0']['Result']==1) 
						$bravoerror = 0;
					if($ret['table0']['Result']==-2) 
						$bravoerror = 23002;
					if($ret['table0']['Result']==-1) 
						$bravoerror = 23003;
					if($ret['table0']['Result']==-13) 
						$bravoerror = 23006;
					if($ret['table0']['Result']==-15) 
						$bravoerror = 23005;
					if($ret['table0']['Result']==-16) 
						$bravoerror = 23004;

					$withdrawValue = array( "TradingDate" => date("Y-m-d"), 
											'TransactionType'=> "M18.01", 
											"AccountNo" => $result[$i]['accountno'], 
											"Amount" => $result[$i]['tax'], 
											"Bank" => $result[$i]['bravocode'], 
											"Branch" => $result[$i]['branchname'], 
											"Note" => "Thue TNCN");
					$ret = $soap->withdraw($withdrawValue);

					switch ($ret['table0']['Result']) {
						case '-2':
							$bravoerror = $bravoerror .'	'. 23002;
							break;

						case '-1':
							$bravoerror = $bravoerror .'	'. 23003;
							break;

						case '-13':
							$bravoerror = $bravoerror .'	'. 23006;
							break;

						case '-15':
							$bravoerror = $bravoerror .'	'. 23005;
							break;

						case '-16':
							$bravoerror = $bravoerror .'	'. 23004;
							break;

						default:
							$bravoerror = $bravoerror .'	'. $ret['table0']['Result'];						
					}//switch

					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'Tax'  => new SOAP_Value("Tax", "string", $result[$i]['tax']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)												
							)
						);
					
					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['value'],
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror												
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');	
					csv_bank($bravolist,$TradingDate.'_Bravolist_Sell_TDate',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );		
	}*/
	function SellingValueAndFeeListForBravoTDate($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'SellingValueAndFeeListForBravoTDate';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		$date_array = getdate();
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Sell_TDate.csv')===true) {
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		} else {
			$query = sprintf('call sp_getSellingValueAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0) {
				$this->export_csv($TradingDate,$result,'sell');
				$soap = &new Bravo();
				$Note = "Tien ban chung khoan";
				$bravolist = array();
				for($i=0; $i<$num_row; $i++) {
					$sellingstock = array("TradingDate" => $TradingDate,
										"AccountNo" => $result[$i]['accountno'],
										"Amount" => $result[$i]['value'],
										"Fee" => $result[$i]['commission'],
										"Bank" => $result[$i]['bravocode'],
										"Branch" => $result[$i]['branchname'],
										"Type" => $result[$i]['investortype'],
										"Note" => 'Ban ck ngay '.$TradingDate.' - '.$Note,
										'TDate' => 0);
					$ret = $soap->sellingstock($sellingstock);
					$bravoerror = 0;
					if($ret['table0']['Result']==1)
						$bravoerror = 0;
					if($ret['table0']['Result']==-2)
						$bravoerror = 23002;
					if($ret['table0']['Result']==-1)
						$bravoerror = 23003;
					if($ret['table0']['Result']==-13)
						$bravoerror = 23006;
					if($ret['table0']['Result']==-15)
						$bravoerror = 23005;
					if($ret['table0']['Result']==-16)
						$bravoerror = 23004;

          // ------------------------------------------------------------------------------------ //
          // 20100615 - ma link M02.04 neu bravo_code = ngan hang ao
          // amount = $result[$i]['commission']
          // fee    = $result[$i]['tax']
          // ------------------------------------------------------------------------------------ //
          $transactionType = "M18.01";   // Gia tri cho cac ngan hang khac 61 (nhu cu)
          $amount = $result[$i]['tax'];  // Gia tri cho cac ngan hang khac 61 (nhu cu)
          $fee = 0;                      // Gia tri cho cac ngan hang khac 61 (nhu cu)
          $note = "Thue TNCN";

          if((int)$result[$i]['bravocode']==(int)VIRTUAL_BANK_BRAVO_BANKCODE)
          {
            $transactionType = "M02.04";
            $amount = $result[$i]['commission'];
            $fee = $result[$i]['tax'];
            $note = "Phi + Thue TNCN ban chung khoan ngay T";
          }
          // ------------------------------------------------------------------------------------ //
          // End 20100615
          // ------------------------------------------------------------------------------------ //

					$withdrawValue = array( "TradingDate" => date("Y-m-d"),
											// 'TransactionType'   => "M18.01",
                      'TransactionType'   => $transactionType,
											"AccountNo"         => $result[$i]['accountno'],
											// "Amount"            => $result[$i]['tax'],
                      "Amount"            => $amount,
                      "Fee"               => $fee,
											"Bank"              => $result[$i]['bravocode'],
											"Branch"            => $result[$i]['branchname'],
											"Note"              => $note);
					$ret = $soap->withdraw($withdrawValue);

					switch ($ret['table0']['Result']) {
						case '-2':
							$bravoerror = $bravoerror .'	'. 23002;
							break;

						case '-1':
							$bravoerror = $bravoerror .'	'. 23003;
							break;

						case '-13':
							$bravoerror = $bravoerror .'	'. 23006;
							break;

						case '-15':
							$bravoerror = $bravoerror .'	'. 23005;
							break;

						case '-16':
							$bravoerror = $bravoerror .'	'. 23004;
							break;

						default:
							$bravoerror = $bravoerror .'	'. $ret['table0']['Result'];
					}//switch

					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'Tax'  => new SOAP_Value("Tax", "string", $result[$i]['tax']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)
							)
						);

					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['value'],
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');
					csv_bank($bravolist,$TradingDate.'_Bravolist_Sell_TDate',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}

	 /**
	 * Function BuyingValueAndFeeListForBravo	: update money --> bravo
	 * Input 				: $TradingDate
	 * OutPut 				: error code and items ( AccountNo, success or fail)
	 */
	/*function BuyingValueAndFeeListForBravo($TradingDate) {	
		$class_name = $this->class_name;
		$function_name = 'BuyingValueAndFeeListForBravo';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		//echo $csv_dir.$TradingDate.'_Bravolist_Buy.csv'.file_exists($csv_dir.$TradingDate.'_Bravolist.csv');
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Buy.csv'))
		{	
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		}else
		{				
			$query = sprintf('call sp_getBuyingValueAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				$this->export_csv($TradingDate,$result,'buy');
				$soap = &new Bravo();
				$Note = "Tien mua chung khoan";
				for($i=0; $i<$num_row; $i++) {			
					$buyingstock = array("TradingDate" => $TradingDate, "AccountNo" => $result[$i]['accountno'], "Amount" => $result[$i]['value'], "Fee" => $result[$i]['commission'], "Bank" => $result[$i]['bravocode'], "Branch" => $result[$i]['branchname'], "Type" => $result[$i]['investortype'], "Note" => $Note); 
					$ret = $soap->buyingstock($buyingstock);
					if($ret['table0']['Result']==1) $bravoerror = 0;
					if($ret['table0']['Result']==-2) $bravoerror = 23002;
					if($ret['table0']['Result']==-1) $bravoerror = 23003;
					if($ret['table0']['Result']==-13) $bravoerror = 23006;
					if($ret['table0']['Result']==-15) $bravoerror = 23005;
					if($ret['table0']['Result']==-16) $bravoerror = 23004;
					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)											
							)
						);
					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['value'],
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror												
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');	
					csv_bank($bravolist,$TradingDate.'_Bravolist_Buy',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );		
	}*/

	function BuyingValueAndFeeListForBravo($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'BuyingValueAndFeeListForBravo';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();

		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		//echo $csv_dir.$TradingDate.'_Bravolist_Buy.csv'.file_exists($csv_dir.$TradingDate.'_Bravolist.csv');
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_Buy.csv'))
		{
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		}else
		{
			$query = sprintf('call sp_getBuyingValueAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				$this->export_csv($TradingDate,$result,'buy');
				$soap = &new Bravo();
				$Note = "Tien mua chung khoan";
				for($i=0; $i<$num_row; $i++) {
					$buyingstock = array(
                  "TradingDate"   => $TradingDate,
                  "AccountNo"     => $result[$i]['accountno'],
                  "Amount"        => $result[$i]['value'],
                  "Fee"           => $result[$i]['commission'],
                  "Bank"          => $result[$i]['bravocode'],
                  "Branch"        => $result[$i]['branchname'],
                  "Type"          => $result[$i]['investortype'], "Note" => $Note
                              );
					$ret = $soap->buyingstock($buyingstock);
					if($ret['table0']['Result']==1) $bravoerror = 0;
					if($ret['table0']['Result']==-2) $bravoerror = 23002;
					if($ret['table0']['Result']==-1) $bravoerror = 23003;
					if($ret['table0']['Result']==-13) $bravoerror = 23006;
					if($ret['table0']['Result']==-15) $bravoerror = 23005;
					if($ret['table0']['Result']==-16) $bravoerror = 23004;
					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", $result[$i]['commission']),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)
							)
						);
					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['value'],
							'Fee'  => $result[$i]['commission'],
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror
							);
				}
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');
					csv_bank($bravolist,$TradingDate.'_Bravolist_Buy',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
		
		
	/**
	 * Function PaidAdvanceForBravo	: 
	 * Input 						: $TradingDate
	 * OutPut 						: error code and items ( AccountNo, success or fail)
	 */
	/*
	function PaidAdvanceForBravo($TradingDate) {	
		$class_name = $this->class_name;
		$function_name = 'PaidAdvanceForBravo';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		
		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		//echo $csv_dir.$TradingDate.'_Bravolist_Buy.csv'.file_exists($csv_dir.$TradingDate.'_Bravolist.csv');
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_PaidAdvance.csv'))
		{	
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		}else
		{				
			$query = sprintf('call sp_getAdvanceAmountAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				$this->export_csv($TradingDate,$result,'paidadvance');
				$soap = &new Bravo();
				$Note = "Thanh toan tien ung truoc";
				for($i=0; $i<$num_row; $i++) {			
					$buyingstock = array("TradingDate" => $TradingDate, "AccountNo" => $result[$i]['accountno'], "Amount" => $result[$i]['amount'], "Fee" => 0, "Bank" => $result[$i]['bravocode'], "Branch" => $result[$i]['branchname'], "Type" => $result[$i]['investortype'], "Note" => $Note, "transactionType" => '2', "BankID" => $result[$i]['bankid']); 
					$ret = $soap->advanceMoney($buyingstock);
					if($ret['table0']['Result']==1) $bravoerror = 0;
					if($ret['table0']['Result']==-2) $bravoerror = 23002;
					if($ret['table0']['Result']==-1) $bravoerror = 23003;
					if($ret['table0']['Result']==-13) $bravoerror = 23006;
					if($ret['table0']['Result']==-15) $bravoerror = 23005;
					if($ret['table0']['Result']==-16) $bravoerror = 23004;
					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'  => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'  => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'  => new SOAP_Value("Fee", "string", 0),
							'Bank'  => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'BravoError'  => new SOAP_Value("BravoError", "string", $bravoerror)											
							)
						);
					$bravolist[$i] = array(
							'AccountNo'  => $result[$i]['accountno'],
							'Amount'  => $result[$i]['amount'],
							'Fee'  => 0,
							'Bank'  => $result[$i]['bravocode'],
							'BravoError'  => $bravoerror												
							);
				}//$result[$i]['fee']
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');	
					csv_bank($bravolist,$TradingDate.'_PaidAdvanceForBravo',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );		
	}*/
	function PaidAdvanceForBravo($TradingDate) {
		$class_name = $this->class_name;
		$function_name = 'PaidAdvanceForBravo';

		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();

		$csv_dir = CSV_PATH.$date_array['year'].'/'.$date_array['mon'].'/';
		//echo $csv_dir.$TradingDate.'_Bravolist_Buy.csv'.file_exists($csv_dir.$TradingDate.'_Bravolist.csv');
		if(file_exists($csv_dir.$TradingDate.'_Bravolist_PaidAdvance.csv'))
		{
			// Da thuc hien insert dl vao bravo voi TradingDate
			$this->_ERROR_CODE = 23008;
		}else
		{
			$query = sprintf('call sp_getAdvanceAmountAndFeeListForBravo("%s")',$TradingDate);
			$result = $this->_MDB2_WRITE->extended->getAll($query);
			$num_row = count($result);
			if($num_row>0)
			{
				$this->export_csv($TradingDate,$result,'paidadvance');
				$soap = &new Bravo();
				$Note = "Thanh toan tien ung truoc";
				for($i=0; $i<$num_row; $i++) {
					$buyingstock = array(
              "TradingDate"     => $TradingDate,
              "AccountNo"       => $result[$i]['accountno'],
              "Amount"          => $result[$i]['amount'],
              "Fee"             => $result[$i]['fee'],
              "Bank"            => $result[$i]['bravocode'],
              "Branch"          => $result[$i]['branchname'],
              "Type"            => $result[$i]['investortype'],
              "Note"            => $Note,
              "transactionType" => '2',
              "BankID"          => $result[$i]['bankid'],
              "OrderBankBravoCode" => $result[$i]['orderbankbravocode'],);

					$ret = $soap->advanceMoney($buyingstock);
					if($ret['table0']['Result']==1) $bravoerror = 0;
					if($ret['table0']['Result']==-2) $bravoerror = 23002;
					if($ret['table0']['Result']==-1) $bravoerror = 23003;
					if($ret['table0']['Result']==-13) $bravoerror = 23006;
					if($ret['table0']['Result']==-15) $bravoerror = 23005;
					if($ret['table0']['Result']==-16) $bravoerror = 23004;
					$this->items[$i] = new SOAP_Value(
						'items',
						'{urn:'. $class_name .'}'.$function_name.'Struct',
						array(
							'AccountNo'          => new SOAP_Value("AccountNo", "string", $result[$i]['accountno']),
							'Amount'             => new SOAP_Value("Amount", "string", $result[$i]['value']),
							'Fee'                => new SOAP_Value("Fee", "string", $result[$i]['fee']),
							'Bank'               => new SOAP_Value("Bank", "string", $result[$i]['bravocode']),
							'BravoError'         => new SOAP_Value("BravoError", "string", $bravoerror),
              'BankID'             => new SOAP_Value("BankID", "string", $result[$i]['bankid']),
              'OrderBankBravoCode' => new SOAP_Value("OrderBankBravoCode", "string", $result[$i]['orderbankbravocode']),
							)
						);
					$bravolist[$i] = array(
							'AccountNo'          => $result[$i]['accountno'],
							'Amount'             => $result[$i]['amount'],
							'Fee'                => $result[$i]['fee'],
							'Bank'               => $result[$i]['bravocode'],
							'BravoError'         => $bravoerror,
              'BankID'             => $result[$i]['bankid'],
              'OrderBankBravoCode' => $result[$i]['orderbankbravocode'],
							);
				}//$result[$i]['fee']
				if(count($bravolist)>0){
					$header = array('AccountNo', 'Amount', 'Fee', 'Bank', 'BravoError');
					csv_bank($bravolist,$TradingDate.'_PaidAdvanceForBravo',$header );
				}
			}
		}
		$this->write_my_log('MoneyBravo',$function_name.' '.$query.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
	}
	
	
	/**
	 * Function CloseBravoAccount	: update money --> bravo
	 * Input 				: $TradingDate
	 * OutPut 				: error code and items ( AccountNo, success or fail)
	 */
	function CloseBravoAccount($AccountNo) {	
		$class_name = $this->class_name;
		$function_name = 'CloseBravoAccount';
		
		if ( authenUser(func_get_args(), $this, $function_name) > 0 )
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );
		$this->items = array();
		
		$soap = &new Bravo();
		$this->_ERROR_CODE = $soap->closeCustomer($AccountNo);
		
		$this->write_my_log('MoneyBravo',$function_name.' AccountNo '.$AccountNo.' '.$date.'  varerror '.$this->_ERROR_CODE.' '.date('Y-m-d h:i:s'));
		return returnXML(func_get_args(), $this->class_name, $function_name, $this->_ERROR_CODE, $this->items, $this );		
	}
	
	function export_csv($TradingDate,$result,$type)
	{
		$bank_code = array();
		$csv_data = array();
		$header = array('TradingDate', 'AccountNo', 'Amount', 'Fee');		
		foreach ($result as $row)
		{
			if(!in_array($row['bravocode'],$bank_code)){
				$bank_code[] = $row['bravocode'];				
			}
			$j=count($csv_data[$row['bravocode']]);
			$csv_data[$row['bravocode']][$j]['TradingDate'] 	= $TradingDate;
			$csv_data[$row['bravocode']][$j]['AccountNo'] 		= $row['accountno'];
			$csv_data[$row['bravocode']][$j]['Amount'] 			= $row['value'];
			$csv_data[$row['bravocode']][$j]['Fee'] 			= $row['commission'];
		}
		$num_bank = count($bank_code);
		for($i=0; $i<$num_bank; $i++) {
			csv_bank($csv_data[$bank_code[$i]],$bank_code[$i].'_'.$type,$header );
		}
	}
	
	function write_my_log($filename,$content)
	{				
		$path =  '/home/vhosts/eSMSstorage/cron.d/logs/';
		$date_array = getdate();
		if (!is_dir($path)){
			mkdir( $path, 0755 ); 
		}
		$csv_dir = $path.$date_array['year'].'/';
		if (!is_dir($csv_dir)){
			mkdir( $csv_dir, 0755 ); 
		}
		$csv_dir = $csv_dir.$date_array['mon'].'/';
		if (!is_dir($csv_dir)){
			mkdir( $csv_dir, 0755 ); 
		}
		$filepath = $csv_dir.$date_array['year'].$date_array['mon'].$date_array['mday'].'_'.$filename.date('Y-m-d').'.txt';
		//$fp = fopen($filepath.'.txt', 'w');
		$message  = '';
	
			if ( ! file_exists($filepath))
			{
				$message .= "<!-- Log file ".$date_array['mon'].'-'.$date_array['year']." --!>\n\n";
			}
				
			if ( ! $fp = @fopen($filepath, "a"))
			{
				return FALSE;
			}
	
			$message .= ' --> '.$content."\n";
			
			//print_r($message);
			flock($fp, LOCK_EX);	
			fwrite($fp, $message);
			flock($fp, LOCK_UN);
			fclose($fp);
		
			@chmod($filepath, 0644); 		
			
	}

}
?>
