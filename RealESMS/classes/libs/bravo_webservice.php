<?php

define("VIRTUAL_BANK_BRAVO_BANKCODE", 61);
define( 'CSV_LOG_HEADER', 'Server IP,function_name,key,transactionID,TransactionType,TransactionDate,CustomerCode,DestCustomerCode,Amount,Fee,Notes,OrderBankBravoCode,BravoCode,bank_id,Chinhanh,TransID_Rollback,Executed time' );

class Bravo {
	var $soapclient;
	var $chk;

	function Bravo() {
		$this->chk = 0;
		if(WEBSERVICE_URL!=''){
			$this->soap_client = &new SoapClient(WEBSERVICE_URL, array('trace' => 1) );
			$this->chk = 1;
		}
	}

	function addNewCustomer($values) {
		write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name addNewCustomer AccountNo ' .$values["AccountNo"]. ' AccountName '. $values["AccountName"]. ' Address '. $values["Address"].' Investor Type '. $values["InvestorType"].' ContractNo '. $values["ContractNo"].' City '. $values["City"].' BankAccount '. $values["BankAccount"].' Bank '. $values["Bank"].' '.date('Y-m-d h:i:s'),VCB_PATH);
		if($this->chk == 1)
		{
			$params["key"] = BRAVO_KEY;
			$params["newCust"] = 'A';
			$params["customerCode"] = $values["AccountNo"];
			$params["customerName"] = $values["AccountName"];
			$params["address"] = $values["Address"];
			$params["dien_thoai"] = $values["Tel"];
			$params["Loai_hd"] = $values["InvestorType"];
			$params["sohopdong"] = $values["ContractNo"];
			$params["chinhanh"] = $values["City"];
			$params["so_tk_nh"] = $values["BankAccount"];
			$params["ngan_hang"] = $values["Bank"];
			$params["customerCode_Close"] = "";
			//var_dump($params);
			$this->soap_client->NewCustomer($params);

			$data = $this->soap_client->__getLastResponse();

			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			return $ret["soap:Body"]["NewCustomerResponse"]["NewCustomerResult"]["DS"];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function updateCustomer($values) {
		write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name updateCustomer AccountNo ' .$values["AccountNo"]. ' AccountName '. $values["AccountName"]. ' Address '. $values["Address"].' Investor Type '. $values["InvestorType"].' ContractNo '. $values["ContractNo"].' City '. $values["City"].' BankAccount '. $values["BankAccount"].' Bank '. $values["Bank"].' '.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
			$params["key"] = BRAVO_KEY;
			$params["newCust"] = 'E';
			$params["customerCode"] = $values["AccountNo"];
			$params["customerName"] = $values["AccountName"];
			$params["address"] = $values["Address"];
			$params["dien_thoai"] = $values["Tel"];
			$params["Loai_hd"] = $values["InvestorType"];
			$params["sohopdong"] = $values["ContractNo"];
			$params["chinhanh"] = $values["City"];
			$params["so_tk_nh"] = $values["BankAccount"];
			$params["ngan_hang"] = $values["Bank"];
			$params["customerCode_Close"] = "";
			//var_dump($params);
			$this->soap_client->NewCustomer($params);

			$data = $this->soap_client->__getLastResponse();
			//var_dump($data);
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			return $ret["soap:Body"]["NewCustomerResponse"]["NewCustomerResult"]["DS"];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function closeCustomer($account_no) {
		 write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name closeCustomer AccountNo ' .$account_no.' '.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
			$params["key"] = BRAVO_KEY;
			$params["newCust"] = '';
			$params["customerCode"] = "";
			$params["customerName"] = "";
			$params["address"] = "";
			$params["dien_thoai"] = "";
			$params["Loai_hd"] = "";
			$params["sohopdong"] = "";
			$params["chinhanh"] = "";
			$params["so_tk_nh"] = "";
			$params["ngan_hang"] = "";
			$params["customerCode_Close"] = $account_no;
			//var_dump($params);
			$this->soap_client->NewCustomer($params);

			$data = $this->soap_client->__getLastResponse();
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			return $ret["soap:Body"]["NewCustomerResponse"]["NewCustomerResult"]["DS"];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function deposit($values) {
    $log = $_SERVER['REMOTE_ADDR']
           .' function_name deposit'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: '     .$values["TransactionType"]
           .' TransactionDate: '     .$values["TradingDate"]
           .' CustomerCode: '        .$values["AccountNo"]
           .' DestCustomerCode: ""'
           .' Amount: '              .$values["Amount"]
           .' Fee: '                 .($values["Fee"]?$values["Fee"]:"0")
           .' Notes: '               .$values["Note"]
           .' Nganhang: '            .($values["Bank"]?$values["Bank"]:"")
           .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
           .' TransID_Rollback: ""'
           .' '
           .date('Y-m-d h:i:s');
    $csv_log = $_SERVER['REMOTE_ADDR']
              . ',deposit' . ','
              . BRAVO_KEY  . ','
              . '""'       . ','
              . $values["TransactionType"] . ','
              . $values["TradingDate"] . ','
              . $values["AccountNo"] . ','
              . '""' . ','
              . $values["Amount"] . ','
              . ($values["Fee"]?$values["Fee"]:"0") . ','
              . $values["Note"] . ','
              . ($values["Bank"]?$values["Bank"]:"") . ','
              . '"",'
              . ($values["Branch"]?$values["Branch"]:"") . ','
              . '""' . ','
              . date('Y-m-d h:i:s');

		// write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name deposit AccountNo ' .$values["AccountNo"]. ' TransactionType '. $values["TransactionType"]. ' TradingDate '. $values["TradingDate"].' Amount '. $values["Amount"].' Fee '. $values["Fee"].' Note '. $values["Note"].' Bank '. $values["Bank"].' Branch '. $values["Branch"].' '.date('Y-m-d h:i:s'),VCB_PATH);
    write_my_log_path('Bravo-log', $log, VCB_PATH);
    write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
		$params["key"] = BRAVO_KEY;
		$params["transactionID"] = "";
		$params["transactionType"] = $values["TransactionType"];
		$params["transactionDate"] = $values["TradingDate"];
		$params["customerCode"] = $values["AccountNo"];
		//$params["destCustomerCode"] = "";
		$params["amount"] = $values["Amount"];
		$params["fee"] = $values["Fee"]?$values["Fee"]:"0";
		$params["notes"] = $values["Note"];
		$params["nganhang"] = $values["Bank"]?$values["Bank"]:"";
		$params["chinhanh"] = $values["Branch"]?$values["Branch"]:"";
		$params["transID_Rollback"] = "";
		$this->soap_client->NewTransaction($params);
		//return transactionif using for rollback
		$data = $this->soap_client->__getLastResponse();
		$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
		$xml->unserialize($data, FALSE);

		$ret = $xml->getUnserializedData();
		return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];

		/*$ret['table1']['Id'] = 0;
		$ret['table0']['Result'] = 1;
		return $ret; */
	}

	function withdraw($values) {
    $log = $_SERVER['REMOTE_ADDR']
           .' function_name withdraw'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: '     .$values["TransactionType"]
           .' TransactionDate: '     .$values["TradingDate"]
           .' CustomerCode: '        .$values["AccountNo"]
           .' DestCustomerCode: ""'
           .' Amount: '              .$values["Amount"]
           .' Fee: '                 .($values["Fee"]?$values["Fee"]:"0")
           .' Notes: '               .($values["Note"]?$values["Note"]:"''")
           .' order_bravo_id: '      ."''"
           .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
           .' bank_id: '             ."''"
           .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
           .' TransID_Rollback: ""'
           .' '
           .date('Y-m-d h:i:s');
    write_my_log_path('Bravo-log', $log, VCB_PATH);

    $csv_log = $_SERVER['REMOTE_ADDR']
              . ',withdraw' . ','
              . BRAVO_KEY  . ','
              . '""'       . ','
              . $values["TransactionType"] . ','
              . $values["TradingDate"] . ','
              . $values["AccountNo"] . ','
              . '""' . ','
              . $values["Amount"] . ','
              . ($values["Fee"]?$values["Fee"]:"0") . ','
              . $values["Note"] . ','
              . '"",'
              . ($values["Bank"]?$values["Bank"]:"") . ','
              . '"",'
              . ($values["Branch"]?$values["Branch"]:"") . ','
              . '""' . ','
              . date('Y-m-d h:i:s');

 	  write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);

		$params["key"] = BRAVO_KEY;
		$params["transactionID"] = "";
		$params["transactionType"] = $values["TransactionType"];
		$params["transactionDate"] = $values["TradingDate"];
		$params["customerCode"] = $values["AccountNo"];
		$params["destCustomerCode"] = "";
		$params["amount"] = $values["Amount"];
		$params["fee"] = $values["Fee"]?$values["Fee"]:"0";
		$params["notes"] = $values["Note"];
		$params["nganhang"] = $values["Bank"]?$values["Bank"]:"";
		$params["chinhanh"] = $values["Branch"]?$values["Branch"]:"";
		$params["transID_Rollback"] = "";

		$this->soap_client->NewTransaction($params);
		// return transactionif using for rollback
		$data = $this->soap_client->__getLastResponse();
		$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
		$xml->unserialize($data, FALSE);

		$ret = $xml->getUnserializedData();
		return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];


		/*$ret['table1']['Id'] = 0;
		$ret['table0']['Result'] = 1;
		return $ret; */
	}

	function buyingstock($values) {
		// write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name buyingstock AccountNo ' .$values["AccountNo"]. ' TransactionType '. $values["Type"]. ' TradingDate '. $values["TradingDate"].' Amount '. $values["Amount"].' Fee '. $values["Fee"].' Note '. $values["Note"].' Bank '. $values["Bank"].' Branch '. $values["Branch"].' '.date('Y-m-d h:i:s'),VCB_PATH);
		if($this->chk == 1)
		{
      if((int)$values['Bank']==(int)VIRTUAL_BANK_BRAVO_BANKCODE){ // Ngan hang EPS - added 20100615
        // -------------------------------------------------------------------------------------- //
        // Ghi log
        // -------------------------------------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
           .' function_name buyingstock'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: '     .'M01.04'
           .' TransactionDate: '     .$values["TradingDate"]
           .' CustomerCode: '        .$values["AccountNo"]
           .' DestCustomerCode: ""'
           .' Amount: '              .$values["Amount"]
           .' Fee: '                 .$values["Amount"] // Theo yeu cau cua chi Minh Fee = Amount de bravo co the tach ra thanh 2 dinh khoan
           .' Notes: '               .($values["Note"]?$values["Note"]:"''")
           .' order_bravo_id: '      ."''"
           .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
           .' bank_id: '             ."''"
           .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
           .' TransID_Rollback: ""'
           .' '
           .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $log = $_SERVER['REMOTE_ADDR']
           .' function_name buyingstock'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: '     .'M01.05'
           .' TransactionDate: '     .$values["TradingDate"]
           .' CustomerCode: '        .$values["AccountNo"]
           .' DestCustomerCode: ""'
           .' Amount: '              .$values["Fee"] // Theo yeu cau cua chi Minh Amount = Fee de bravo co the tach ra thanh 2 dinh khoan
           .' Fee: '                 .$values["Fee"]
           .' Notes: '               .($values["Note"]?$values["Note"]:"''")
           .' order_bravo_id: '      ."''"
           .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
           .' bank_id: '             ."''"
           .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
           .' TransID_Rollback: ""'
           .' '
           .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
                . ',buyingstock' . ','
                . BRAVO_KEY  . ','
                . '""'       . ','
                . 'M01.04,'
                . $values["TradingDate"] . ','
                . $values["AccountNo"] . ','
                . '""' . ','
                . $values["Amount"] . ','
                . $values["Amount"] . ','
                . ($values["Note"] . '(Gia tri mua)') . ','
                . '"",'
                . ($values["Bank"]?$values["Bank"]:"") . ','
                . '"",'
                . ($values["Branch"]?$values["Branch"]:"") . ','
                . '""' . ','
                . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
                . ',buyingstock' . ','
                . BRAVO_KEY  . ','
                . '""'       . ','
                . 'M01.05,'
                . $values["TradingDate"] . ','
                . $values["AccountNo"] . ','
                . '""' . ','
                . ($values["Fee"]?$values["Fee"]:"0") . ','
                . ($values["Fee"]?$values["Fee"]:"0") . ','
                . ($values["Note"]. '(Phi mua)') . ','
                . '"",'
                . ($values["Bank"]?$values["Bank"]:"") . ','
                . '"",'
                . ($values["Branch"]?$values["Branch"]:"") . ','
                . '""' . ','
                . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // -------------------------------------------------------------------------------------- //
        // Het ghi log
        // -------------------------------------------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // M01.04
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = 'M01.04';
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Amount"];
        $params["fee"]              = $values["Amount"]; // Theo yeu cau cua chi Minh Fee = Amount de bravo co the tach ra thanh 2 dinh khoan
        $params["notes"]            = $values["Note"] . '(Gia tri mua)';
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";
        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // M01.05
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = 'M01.05';
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Fee"]; // Theo yeu cau cua chi Minh Amount = Fee de bravo co the tach ra thanh 2 dinh khoan
        $params["fee"]              = $values["Fee"];
        $params["notes"]            = $values["Note"] . '(Phi mua)';
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";
        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        //
        // -------------------------------------------------------------------------------------- //
        //return transaction if using for rollback
        $data = $this->soap_client->__getLastResponse();
        $xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
        $xml->unserialize($data, FALSE);

        $ret = $xml->getUnserializedData();
        return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      }
      else{ // Ngan hang khac ( khong co thay doi - 20100615 )
  			if($values["Type"]=='4' or $values["Type"]=='2'){
  				$transactionType="M01.02";// nha dau tu nuoc ngoai
  			}else{
  				$transactionType="M01.01";// nha dau tu trong nuoc va tu doanh (5)
  			}
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
           .' function_name buyingstock'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: '     .$transactionType
           .' TransactionDate: '     .$values["TradingDate"]
           .' CustomerCode: '        .$values["AccountNo"]
           .' DestCustomerCode: ""'
           .' Amount: '              .$values["Amount"]
           .' Fee: '                 .($values["Fee"]?$values["Fee"]:"0")
           .' Notes: '               .($values["Note"]?$values["Note"]:"''")
           .' order_bravo_id: '      ."''"
           .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
           .' bank_id: '             ."''"
           .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
           .' TransID_Rollback: ""'
           .' '
           .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
                . ',buyingstock' . ','
                . BRAVO_KEY  . ','
                . '""'       . ','
                . $transactionType . ','
                . $values["TradingDate"] . ','
                . $values["AccountNo"] . ','
                . '""' . ','
                . $values["Amount"] . ','
                . ($values["Fee"]?$values["Fee"]:"0") . ','
                . $values["Note"] . ','
                . '"",'
                . ($values["Bank"]?$values["Bank"]:"") . ','
                . '"",'
                . ($values["Branch"]?$values["Branch"]:"") . ','
                . '""' . ','
                . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
  			$params["transactionID"]    = "";
  			$params["transactionType"]  = $transactionType;
  			$params["transactionDate"]  = $values["TradingDate"];
  			$params["customerCode"]     = $values["AccountNo"];
  			$params["destCustomerCode"] = "";
  			$params["amount"]           = $values["Amount"];
  			$params["fee"]              = $values["Fee"]?$values["Fee"]:"0";
  			$params["notes"]            = $values["Note"];
  			$params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
  			$params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
  			$params["transID_Rollback"] = "";
  			$this->soap_client->NewTransaction($params);
  			//return transactionif using for rollback
  			$data = $this->soap_client->__getLastResponse();
  			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
  			$xml->unserialize($data, FALSE);

  			$ret = $xml->getUnserializedData();
  			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      } // End if bravo_code
    }else{
      $ret['table1']['Id'] = 0;
      $ret['table0']['Result'] = 1;
      return $ret;
    }
	}

	function sellingstock($values) {
		// write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name sellingstock AccountNo ' .$values["AccountNo"]. ' TransactionType '. $values["Type"]. ' TradingDate '. $values["TradingDate"].' Amount '. $values["Amount"].' Fee '. $values["Fee"].' Note '. $values["Note"].' Bank '. $values["Bank"].' Branch '. $values["Branch"].' '.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
      if((int)$values['Bank']==(int)VIRTUAL_BANK_BRAVO_BANKCODE){ // Ngan hang EPS - added 20100615
        if($values["TDate"]==0){
          $TransactionType1 = 'M02.03';
          // $TransactionType2 = 'M02.04'; // M02.04 da dc day qua roi ben classBravo
                                           // do ngay T0 gop Phi + Thue TNCN
        }
        else{
          $TransactionType1 = 'M03.03';
          $TransactionType2 = 'M03.04';   // Ngay T3 tach Phi va Thue.
                                          // Thue (M03.05) da dc classBravo day qua roi
        }
        // -------------------------------------------------------------------------------------- //
        // Ghi log
        // -------------------------------------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name sellingstock'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$TransactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .'0' // Khong co phi
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      ."''"
             .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
             .' bank_id: '             ."''"
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);
        if($values["TDate"]!=0)
        {
          $log = $_SERVER['REMOTE_ADDR']
               .' function_name sellingstock'
               .' key: '                 .BRAVO_KEY
               .' transactionID: ""'
               .' TransactionType: '     .$TransactionType2
               .' TransactionDate: '     .$values["TradingDate"]
               .' CustomerCode: '        .$values["AccountNo"]
               .' DestCustomerCode: ""'
               .' Amount: '              .($values["Fee"]?$values["Fee"]:"0") // Theo yeu cau cua chi Minh Amount = Fee de bravo co the tach ra thanh 2 dinh khoan
               .' Fee: '                 .($values["Fee"]?$values["Fee"]:"0")
               .' Notes: '               .($values["Note"]?$values["Note"]:"''")
               .' order_bravo_id: '      ."''"
               .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
               .' bank_id: '             ."''"
               .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
               .' TransID_Rollback: ""'
               .' '
               .date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log', $log, VCB_PATH);
        }
        $csv_log = $_SERVER['REMOTE_ADDR']
              . ',sellingstock' . ','
              . BRAVO_KEY  . ','
              . '""'       . ','
              . $TransactionType1 . ','
              . $values["TradingDate"] . ','
              . $values["AccountNo"] . ','
              . '""' . ','
              . $values["Amount"] . ','
              . '0,'
              . $values["Note"] . ','
              . '"",'
              . ($values["Bank"]?$values["Bank"]:"") . ','
              . '"",'
              . ($values["Branch"]?$values["Branch"]:"") . ','
              . '""' . ','
              . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        if($values["TDate"]!=0)
        {
          $csv_log = $_SERVER['REMOTE_ADDR']
                . ',sellingstock' . ','
                . BRAVO_KEY  . ','
                . '""'       . ','
                . $TransactionType2 . ','
                . $values["TradingDate"] . ','
                . $values["AccountNo"] . ','
                . '""' . ','
                . ($values["Fee"]?$values["Fee"]:"0") . ','
                . ($values["Fee"]?$values["Fee"]:"0") . ','
                . $values["Note"] . ','
                . '"",'
                . ($values["Bank"]?$values["Bank"]:"") . ','
                . '"",'
                . ($values["Branch"]?$values["Branch"]:"") . ','
                . '""' . ','
                . date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        }
        // -------------------------------------------------------------------------------------- //
        // Het ghi log
        // -------------------------------------------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // TransactionType1
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $TransactionType1;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Amount"];
        $params["fee"]              = '0'; // Khong co fee
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // $TransactionType2
        // -------------------------------------------------------------------------------------- //
        if($values["TDate"]!=0)
        {
          $params["key"]              = BRAVO_KEY;
          $params["transactionID"]    = "";
          $params["transactionType"]  = $TransactionType2;
          $params["transactionDate"]  = $values["TradingDate"];
          $params["customerCode"]     = $values["AccountNo"];
          $params["destCustomerCode"] = "";
          $params["amount"]           = ($values["Fee"]?$values["Fee"]:"0"); // Theo yeu cau cua chi Minh Amount = Fee de bravo co the tach ra thanh 2 dinh khoan
          $params["fee"]              = ($values["Fee"]?$values["Fee"]:"0");
          $params["notes"]            = $values["Note"]?$values["Note"]:"";
          $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
          $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
          $params["transID_Rollback"] = "";

          $this->soap_client->NewTransaction($params);
        }
        // -------------------------------------------------------------------------------------- //
        //
        // -------------------------------------------------------------------------------------- //
        // return transactionif using for rollback
        $data = $this->soap_client->__getLastResponse();
        $xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
        $xml->unserialize($data, FALSE);
        $ret = $xml->getUnserializedData();

        return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      }
      else{
  			if($values["TDate"]==0){

  				if($values["Type"]=='4' or $values["Type"]=='2'){
  					$transactionType="M02.02";//nha dau tu nuoc ngoai
  				}else{
  					$transactionType="M02.01";//nha dau tu trong nuoc va tu doanh(5)
  				}
  			}else{
  				if($values["Type"]=='4' or $values["Type"]=='2'){
  					$transactionType="M03.02";//nha dau tu nuoc ngoai
  				}else{
  					$transactionType="M03.01";//nha dau tu trong nuoc va tu doanh(5)
  				}
  			}
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name sellingstock'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .($values["Fee"]?$values["Fee"]:"0")
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      ."''"
             .' bravo_id'              .$values["Bank"]?$values["Bank"]:"''"
             .' bank_id: '             ."''"
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
              . ',sellingstock' . ','
              . BRAVO_KEY  . ','
              . '""'       . ','
              . $transactionType . ','
              . $values["TradingDate"] . ','
              . $values["AccountNo"] . ','
              . '""' . ','
              . $values["Amount"] . ','
              . $values["Fee"] . ','
              . $values["Note"] . ','
              . '"",'
              . ($values["Bank"]?$values["Bank"]:"") . ','
              . '"",'
              . ($values["Branch"]?$values["Branch"]:"") . ','
              . '""' . ','
              . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
  			$params["key"] = BRAVO_KEY;
  			$params["transactionID"] = "";
  			$params["transactionType"] = $transactionType;
  			$params["transactionDate"] = $values["TradingDate"];
  			$params["customerCode"] = $values["AccountNo"];
  			$params["destCustomerCode"] = "";
  			$params["amount"] = $values["Amount"];
  			$params["fee"] = $values["Fee"]?$values["Fee"]:"0";
  			$params["notes"] = $values["Note"]?$values["Note"]:"";
  			$params["nganhang"] = $values["Bank"]?$values["Bank"]:"";
  			$params["chinhanh"] = $values["Branch"]?$values["Branch"]:"";
  			$params["transID_Rollback"] = "";

  			$this->soap_client->NewTransaction($params);
  			// return transactionif using for rollback
  			$data = $this->soap_client->__getLastResponse();
  			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
  			$xml->unserialize($data, FALSE);

  			$ret = $xml->getUnserializedData();
  			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      } // End if bravo_code
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	/*function advanceMoney($values) {
		if($this->chk == 1)	{
      if((int)$values['Bank']==(int)VIRTUAL_BANK_BRAVO_BANKCODE){ // Ngan hang ao EPS
        $transactionType0 = '';
        $transactionType1 = '';
        $transactionType2 = '';
        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') // Ung truoc
        {
          if($values["BankID"] == TCDM_ID)
          {
            $transactionType0 = "M15.07";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.05";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.05";
        }
        elseif($values["transactionType"]=='2') // Tra no ung truoc
        {
          if($values["BankID"] == TCDM_ID) {
            $transactionType0 = "M15.08";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.04";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.06";
        }
        // Ghi log cho phan so tien ung --------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .$values["Amount"]
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' bravo_bank_id: '       .($values["Bank"]?$values["Bank"]:"")
             .' order_bank_id: '       .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
          $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType0 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . '0,'
            . $values["Note"] . ' - So tien ung,'
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        }

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . $values["Amount"] . ','
            . $values["Note"] . ' - So tien ung,'
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan so tien ung ----------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan so tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
        	$params["key"]              = BRAVO_KEY;
          $params["transactionID"]    = "";
          $params["transactionType"]  = $transactionType0;
          $params["transactionDate"]  = $values["TradingDate"];
          $params["customerCode"]     = $values["AccountNo"];
          $params["destCustomerCode"] = "";
          $params["amount"]           = $values["Amount"];
          $params["fee"]              = '0';
          $params["notes"]            = $values["Note"]?$values["Note"]:"";
          $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
          $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
          $params["transID_Rollback"] = "";
          $this->soap_client->NewTransaction($params);
        }

        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType1;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Amount"];
        $params["fee"]              = $values["Amount"];
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Phi ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.11";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.12";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.07";

          $Fee = '0';
        } elseif($values["transactionType"]=='2') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.10";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.09";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.06";

          $Fee = ($values["Fee"]?$values["Fee"]:"0");
        }
        // Ghi log cho phan phi ung ------------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .$Fee
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' bravo_bank_id: '       .($values["Bank"]?$values["Bank"]:"")
             .' order_bank_id: '       .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $Fee . ','
            . $values["Note"] . ' -  - Phi ung/lai ung,'
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan phi ung --------------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan phi ung
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = ($values["Fee"]?$values["Fee"]:"0");
        $params["fee"]              = $Fee;
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // ------------------------------------------------------------------------------------ //
        //
        // ------------------------------------------------------------------------------------ //
        // return transactionif using for rollback
        $data = $this->soap_client->__getLastResponse();
        $xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
        $xml->unserialize($data, FALSE);

        $ret = $xml->getUnserializedData();
        return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
        // -------------------------------------------------------------------------------------- //
        //
        // -------------------------------------------------------------------------------------- //
      }
      else{ // Ngan hang khac
  			if($values["BankID"] == EPS_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.01";// ung truoc
            $transactionType2="M15.11";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.02";// tra no ung truoc
            $transactionType2="M15.13";// lai ung truoc
  				}
  			} else if($values["BankID"] == TCDM_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.03";// ung truoc
            $transactionType2="M15.12";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.04";// tra no ung truoc
            $transactionType2="M15.14";// lai ung truoc
  				}
  			} else {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M11.01";// ung truoc
            $transactionType2="M11.07";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M11.02";// tra no ung truoc
            $transactionType2="M11.08";// lai ung truoc
  				}
  			}

        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .$values["Fee"]?$values["Fee"]:"0"
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' bravo_bank_id: '       .($values["Bank"]?$values["Bank"]:"")
             .' order_bank_id: '       .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $values["Note"] . ' - So tien ung,'
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
  			$params["key"]               = BRAVO_KEY;
  			$params["transactionID"]     = "";
  			$params["transactionType"]   = $transactionType1;
  			$params["transactionDate"]   = $values["TradingDate"];
  			$params["customerCode"]      = $values["AccountNo"];
  			$params["destCustomerCode"]  = "";
  			$params["amount"]            = $values["Amount"];
  			$params["fee"]               = ($values["Fee"]?$values["Fee"]:"0");
  			$params["notes"]             = $values["Note"]?$values["Note"]:"";
  			$params["nganhang"]          = $values["Bank"]?$values["Bank"]:"";
  			$params["chinhanh"]          = $values["Branch"]?$values["Branch"]:"";
  			$params["transID_Rollback"]  = "";

  			$this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // 20100615 - Yeu cau day them phi/lai ung
        // -------------------------------------------------------------------------------------- //
        $Fee = $values["transactionType"]=='1' ? '0' : ($values["Fee"]?$values["Fee"]:"0");
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .$Fee
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' bravo_bank_id: '       .($values["Bank"]?$values["Bank"]:"")
             .' order_bank_id: '       .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);
        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $Fee . ','
            . $values["Note"] . ' - Phi ung/lai ung,'
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Fee"]?$values["Fee"]:"0";
        $params["fee"]              = $Fee;
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Het 20100615 - Yeu cau day them phi ung
        // -------------------------------------------------------------------------------------- //
  			// return transactionif using for rollback
  			$data = $this->soap_client->__getLastResponse();
  			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
  			$xml->unserialize($data, FALSE);

  			$ret = $xml->getUnserializedData();
  			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      } // end if bravo_code
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}*/
	function advanceMoney_old($values) {
		if($this->chk == 1)	{
      if((int)$values["OrderBankBravoCode"]==(int)VIRTUAL_BANK_BRAVO_BANKCODE){ // Ngan hang ao EPS
        $transactionType0 = '';
        $transactionType1 = '';
        $transactionType2 = '';
        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') // Ung truoc
        {
          if($values["BankID"] == TCDM_ID)
          {
            $transactionType0 = "M15.07";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.05";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.05";
        }
        elseif($values["transactionType"]=='2') // Tra no ung truoc
        {
          if($values["BankID"] == TCDM_ID) {
            $transactionType0 = "M15.08";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.04";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.06";
        }
        // Ghi log cho phan so tien ung --------------------------------------------------------- //
        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
          $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType0
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .'0'
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log', $log, VCB_PATH);
        }
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .$values["Amount"]
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
          $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType0 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . '0,'
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        }

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . $values["Amount"] . ','
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''") . ','
            . ($values["BankID"]?$values["BankID"]:"''") . ','
            . ($values["Branch"]?$values["Branch"]:"''") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan so tien ung ----------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan so tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
        	$params["key"]              = BRAVO_KEY;
          $params["transactionID"]    = "";
          $params["transactionType"]  = $transactionType0;
          $params["transactionDate"]  = $values["TradingDate"];
          $params["customerCode"]     = $values["AccountNo"];
          $params["destCustomerCode"] = "";
          $params["amount"]           = $values["Amount"];
          $params["fee"]              = '0';
          $params["notes"]            = $values["Note"]?$values["Note"]:"";
          $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
          $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
          $params["transID_Rollback"] = "";
          $this->soap_client->NewTransaction($params);
        }

        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType1;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Amount"];
        $params["fee"]              = $values["Amount"];
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Phi ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.11";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.12";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.07";

          $Fee = '0';
        } elseif($values["transactionType"]=='2') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.10";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.09";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.06";

          $Fee = ($values["Fee"]?$values["Fee"]:"0");
        }
        // Ghi log cho phan phi ung ------------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .$Fee
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $Fee . ','
            . $values["Note"] . ' -  - Phi ung/lai ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:'') . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan phi ung --------------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan phi ung
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = ($values["Fee"]?$values["Fee"]:"0");
        $params["fee"]              = $Fee;
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // ------------------------------------------------------------------------------------ //
        //
        // ------------------------------------------------------------------------------------ //
        // return transactionif using for rollback
        $data = $this->soap_client->__getLastResponse();
        $xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
        $xml->unserialize($data, FALSE);

        $ret = $xml->getUnserializedData();
        return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
        // -------------------------------------------------------------------------------------- //
        //
        // -------------------------------------------------------------------------------------- //
      }
      else{ // Ngan hang khac
  			if($values["BankID"] == EPS_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.01";// ung truoc
            $transactionType2="M15.11";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.02";// tra no ung truoc
            $transactionType2="M15.13";// lai ung truoc
  				}
  			} else if($values["BankID"] == TCDM_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.03";// ung truoc
            $transactionType2="M15.12";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.04";// tra no ung truoc
            $transactionType2="M15.14";// lai ung truoc
  				}
  			} else {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M11.01";// ung truoc
            $transactionType2="M11.07";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M11.02";// tra no ung truoc
            $transactionType2="M11.08";// lai ung truoc
  				}
  			}

        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 ."0"
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . '0,'
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
  			$params["key"]               = BRAVO_KEY;
  			$params["transactionID"]     = "";
  			$params["transactionType"]   = $transactionType1;
  			$params["transactionDate"]   = $values["TradingDate"];
  			$params["customerCode"]      = $values["AccountNo"];
  			$params["destCustomerCode"]  = "";
  			$params["amount"]            = $values["Amount"];
  			// 20100618 ----------------------------------------------------------------------------- //
        // $params["fee"]               = ($values["Fee"]?$values["Fee"]:"0");
        $params["fee"]               = '0';
        // End 20100618 ------------------------------------------------------------------------- //
  			$params["notes"]             = $values["Note"]?$values["Note"]:"";
  			$params["nganhang"]          = $values["Bank"]?$values["Bank"]:"";
  			$params["chinhanh"]          = $values["Branch"]?$values["Branch"]:"";
  			$params["transID_Rollback"]  = "";

  			$this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // 20100615 - Yeu cau day them phi/lai ung
        // -------------------------------------------------------------------------------------- //
        $Fee = $values["transactionType"]=='1' ? '0' : ($values["Fee"]?$values["Fee"]:"0");
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .$Fee
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);
        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $Fee . ','
            . $values["Note"] . ' - Phi ung/lai ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Fee"]?$values["Fee"]:"0";
        $params["fee"]              = $Fee;
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = $values["Bank"]?$values["Bank"]:"";
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Het 20100615 - Yeu cau day them phi ung
        // -------------------------------------------------------------------------------------- //
  			// return transactionif using for rollback
  			$data = $this->soap_client->__getLastResponse();
  			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
  			$xml->unserialize($data, FALSE);

  			$ret = $xml->getUnserializedData();
  			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      } // end if bravo_code
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	
	function advanceMoney($values) {
		if($this->chk == 1)	{
      if((int)$values["OrderBankBravoCode"]==(int)VIRTUAL_BANK_BRAVO_BANKCODE){ // Ngan hang ao EPS
        $transactionType0 = '';
        $transactionType1 = '';
        $transactionType2 = '';
        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') // Ung truoc
        {
          if($values["BankID"] == TCDM_ID)
          {
            $transactionType0 = "M15.07";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.05";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.05";
        }
        elseif($values["transactionType"]=='2') // Tra no ung truoc
        {
          if($values["BankID"] == TCDM_ID) {
            $transactionType0 = "M15.08";
          } elseif($values["BankID"] == EXI_ID) {
            $transactionType0 = "M11.04";
          }
          if($values["BankID"] == TCDM_ID ||
             $values["BankID"] == EXI_ID ||
             $values["BankID"] == EPS_ID ) $transactionType1 = "M15.06";
        }
        // Ghi log cho phan so tien ung --------------------------------------------------------- //
        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
          $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType0
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .'0'
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log', $log, VCB_PATH);
        }
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 .$values["Amount"]
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
          $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType0 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . '0,'
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
          write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        }

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . $values["Amount"] . ','
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''") . ','
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"''") . ','
            . ($values["Branch"]?$values["Branch"]:"''") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan so tien ung ----------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan so tien ung
        // -------------------------------------------------------------------------------------- //
        if($values["BankID"] == TCDM_ID || $values["BankID"] == EXI_ID)
        {
        	$params["key"]              = BRAVO_KEY;
          $params["transactionID"]    = "";
          $params["transactionType"]  = $transactionType0;
          $params["transactionDate"]  = $values["TradingDate"];
          $params["customerCode"]     = $values["AccountNo"];
          $params["destCustomerCode"] = "";
          $params["amount"]           = $values["Amount"];
          $params["fee"]              = '0';
          $params["notes"]            = $values["Note"]?$values["Note"]:"";
          $params["nganhang"]         = ($values["Bank"]?$values["Bank"]:"");
          $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
          $params["transID_Rollback"] = "";
          $this->soap_client->NewTransaction($params);
        }

        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType1;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Amount"];
        $params["fee"]              = $values["Amount"];
        $params["notes"]            = $values["Note"]?$values["Note"]:"";
        $params["nganhang"]         = ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"");
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Phi ung
        // -------------------------------------------------------------------------------------- //
        if($values["transactionType"]=='1') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.11";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.12";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.07";

          $Fee  = '0';
        } elseif($values["transactionType"]=='2') {
          if($values["BankID"] == EPS_ID)
            $transactionType2 = "M15.10";
          elseif($values["BankID"] == TCDM_ID)
            $transactionType2 = "M15.09";
          elseif($values["BankID"] == EXI_ID)
            $transactionType2 = "M11.06";

          $Fee = ($values["Fee"]?$values["Fee"]:"0");
        }
        // Ghi log cho phan phi ung ------------------------------------------------------------- //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .$Fee
             .' Notes: '               .($values["Note"]?$values["Note"]:"''")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"''")
             .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"''")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"''")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . $Fee . ','
            . $values["Note"] . ' - Phi ung/lai ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:'') . ','
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log cho phan phi ung --------------------------------------------------------- //
        // -------------------------------------------------------------------------------------- //
        // call bravo ws cho phan phi ung
        // -------------------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = ($values["Fee"]?$values["Fee"]:"0");
        $params["fee"]              = $Fee;
        $params["notes"]            = $values["Note"].'-Lai ung truoc';
        $params["nganhang"]         = ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"");
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // ------------------------------------------------------------------------------------ //
        //
        // ------------------------------------------------------------------------------------ //
        // return transactionif using for rollback
        $data = $this->soap_client->__getLastResponse();
        $xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
        $xml->unserialize($data, FALSE);

        $ret = $xml->getUnserializedData();
        return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
        // -------------------------------------------------------------------------------------- //
        //
        // -------------------------------------------------------------------------------------- //
      }
      else{ // Ngan hang khac
  			if($values["BankID"] == EPS_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.01";// ung truoc
            $transactionType2="M15.11";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.02";// tra no ung truoc
            $transactionType2="M15.13";// lai ung truoc
  				}
  			} else if($values["BankID"] == TCDM_ID) {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M15.03";// ung truoc
            $transactionType2="M15.12";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M15.04";// tra no ung truoc
            $transactionType2="M15.14";// lai ung truoc
  				}
  			} else {
  				if($values["transactionType"]=='1') {
  					$transactionType1="M11.01";// ung truoc
            $transactionType2="M11.07";// fee ung truoc
  				} else if($values["transactionType"]=='2'){
  					$transactionType1="M11.02";// tra no ung truoc
            $transactionType2="M11.08";// lai ung truoc
  				}
  			}

        // -------------------------------------------------------------------------------------- //
        // Tien ung
        // -------------------------------------------------------------------------------------- //
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType1
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .$values["Amount"]
             .' Fee: '                 ."0"
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"")
             .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);

        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType1 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . $values["Amount"] . ','
            . '0,'
            . $values["Note"] . ' - So tien ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
  			$params["key"]               = BRAVO_KEY;
  			$params["transactionID"]     = "";
  			$params["transactionType"]   = $transactionType1;
  			$params["transactionDate"]   = $values["TradingDate"];
  			$params["customerCode"]      = $values["AccountNo"];
  			$params["destCustomerCode"]  = "";
  			$params["amount"]            = $values["Amount"];
  			// 20100618 ----------------------------------------------------------------------------- //
        // $params["fee"]               = ($values["Fee"]?$values["Fee"]:"0");
        $params["fee"]               = '0';
        // End 20100618 ------------------------------------------------------------------------- //
  			$params["notes"]             = $values["Note"]?$values["Note"]:"";
  			$params["nganhang"]          = ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"");
  			$params["chinhanh"]          = $values["Branch"]?$values["Branch"]:"";
  			$params["transID_Rollback"]  = "";

  			$this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // 20100615 - Yeu cau day them phi/lai ung
        // -------------------------------------------------------------------------------------- //
        // $Fee = $values["transactionType"]=='1' ? '0' : ($values["Fee"]?$values["Fee"]:"0");
        // Ghi log ------------------------------------------------------------------------------ //
        $log = $_SERVER['REMOTE_ADDR']
             .' function_name advanceMoney'
             .' key: '                 .BRAVO_KEY
             .' transactionID: ""'
             .' TransactionType: '     .$transactionType2
             .' TransactionDate: '     .$values["TradingDate"]
             .' CustomerCode: '        .$values["AccountNo"]
             .' DestCustomerCode: ""'
             .' Amount: '              .($values["Fee"]?$values["Fee"]:"0")
             .' Fee: '                 .'0'
             .' Notes: '               .($values["Note"]?$values["Note"]:"")
             .' order_bravo_id: '      .($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"")
             .' bravo_id'              .($values["Bank"]?$values["Bank"]:"''")
             .' bank_id: '             .($values["BankID"]?$values["BankID"]:"")
             .' Chinhanh: '            .($values["Branch"]?$values["Branch"]:"")
             .' TransID_Rollback: ""'
             .' '
             .date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log', $log, VCB_PATH);
        $csv_log = $_SERVER['REMOTE_ADDR']
            . ',advanceMoney' . ','
            . BRAVO_KEY  . ','
            . '""'       . ','
            . $transactionType2 . ','
            . $values["TradingDate"] . ','
            . $values["AccountNo"] . ','
            . '""' . ','
            . ($values["Fee"]?$values["Fee"]:"0") . ','
            . '0,'
            . $values["Note"] . ' - Phi ung/lai ung,'
            . ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"") . ','
            . ($values["Bank"]?$values["Bank"]:"") . ','
            . ($values["BankID"]?$values["BankID"]:"") . ','
            . ($values["Branch"]?$values["Branch"]:"") . ','
            . '""' . ','
            . date('Y-m-d h:i:s');
        write_my_log_path('Bravo-log-cvs', $csv_log, VCB_PATH);
        // Het ghi log -------------------------------------------------------------------------- //
        $params["key"]              = BRAVO_KEY;
        $params["transactionID"]    = "";
        $params["transactionType"]  = $transactionType2;
        $params["transactionDate"]  = $values["TradingDate"];
        $params["customerCode"]     = $values["AccountNo"];
        $params["destCustomerCode"] = "";
        $params["amount"]           = $values["Fee"]?$values["Fee"]:"0";
        $params["fee"]              = '0';
        $params["notes"]            = $values["Note"].'-Lai ung truoc';
        $params["nganhang"]         = ($values["OrderBankBravoCode"]?$values["OrderBankBravoCode"]:"");
        $params["chinhanh"]         = $values["Branch"]?$values["Branch"]:"";
        $params["transID_Rollback"] = "";

        $this->soap_client->NewTransaction($params);
        // -------------------------------------------------------------------------------------- //
        // Het 20100615 - Yeu cau day them phi ung
        // -------------------------------------------------------------------------------------- //
  			// return transactionif using for rollback
  			$data = $this->soap_client->__getLastResponse();
  			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
  			$xml->unserialize($data, FALSE);

  			$ret = $xml->getUnserializedData();
  			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
      } // end if bravo_code
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function rollback($transactionid, $date) {
		// write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name roolback Transactionid ' .$transactionid. ' date'.$date.' '.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
      $log = $_SERVER['REMOTE_ADDR']
           .' function_name roolback'
           .' key: '                 .BRAVO_KEY
           .' transactionID: ""'
           .' TransactionType: ""'
           .' TransactionDate: '     .$date
           .' CustomerCode: ""'
           .' DestCustomerCode: ""'
           .' Amount: ""'
           .' Fee: ""'
           .' Notes: ""'
           .' Nganhang: ""'
           .' Chinhanh: ""'
           .' TransID_Rollback: ' . $transactionid
           .' '
           .date('Y-m-d h:i:s');
      write_my_log_path('Bravo-log', $log, VCB_PATH);

			$params["key"] = BRAVO_KEY;
			$params["transactionID"] = "";
			$params["transactionType"] = "";
			$params["transactionDate"] = $date;
			$params["customerCode"] = "";
			$params["destCustomerCode"] = "";
			$params["amount"] = "";
			$params["fee"] = "";
			$params["notes"] = "";
			$params["transID_Rollback"] = $transactionid;

			$this->soap_client->NewTransaction($params);

			$data = $this->soap_client->__getLastResponse();
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			return $ret["soap:Body"]["NewTransactionResponse"]["NewTransactionResult"]["DS"];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function getBalance($values) {
		write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name getBalance AccountNo ' .$values["AccountNo"]. ' previewDate '. $values["TradingDate"]. ' TypeDataSet D'.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
			$params["key"] = BRAVO_KEY;
			$params["previewDate"] = $values["TradingDate"];
			$params["TypeDataSet"] = "D";
			$params["customerCode"] = $values["AccountNo"];
			//var_dump($params);
			$this->soap_client->NewDataSet($params);

			$data = $this->soap_client->__getLastResponse();
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			/*echo "<pre>";
			var_dump($ret);
			echo "</pre>";*/
			return $ret["soap:Body"]["NewDataSetResponse"]["NewDataSetResult"]['DS'];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}

	function getTrading($values) {
		write_my_log_path('Bravo-log',$_SERVER['REMOTE_ADDR'].' function_name getTrading AccountNo ' .$values["AccountNo"]. ' previewDate '. $values["TradingDate"]. ' TypeDataSet P'.date('Y-m-d h:i:s'),VCB_PATH);

		if($this->chk == 1)
		{
			$params["key"] = BRAVO_KEY;
			$params["previewDate"] = $values["TradingDate"];
			$params["TypeDataSet"] = "P";
			$params["customerCode"] = $values["AccountNo"];

			$this->soap_client->NewDataSet($params);

			$data = $this->soap_client->__getLastResponse();
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);

			$ret = $xml->getUnserializedData();
			return $ret["soap:Body"]["NewDataSetResponse"]["NewDataSetResult"]['DS'];
		}else{
			$ret['table1']['Id'] = 0;
			$ret['table0']['Result'] = 1;
			return $ret;
		}
	}
}
?>
