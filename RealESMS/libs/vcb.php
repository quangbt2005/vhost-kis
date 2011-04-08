<?php
require_once 'SOAP/Client.php';
//define("VCB_WEBSERVICE_URL", "http://192.168.137.27/Vcb_Services/Securities_Service.asmx?wsdl"); 
define("VCB_WEBSERVICE_URL", "http://192.168.137.33/EPS_Services/Securities_Service.asmx?wsdl");
//http://192.168.137.33/EPS_Services/Securities_Service.asmx?wsdl
//https://www.vietcombank.com.vn/secure/VCB_services/Securities_Service.asmx?wsdl");
define("VCB_P", "EPS592lsgj73gqz2f5"); 

class CVCB {
	var $url;
	var $error;
	var $soapClient;
	var $soapOptions;
	
	function CVCB() {
		$this->url = VCB_WEBSERVICE_URL;
		$soapClient = new SoapClient(VCB_WEBSERVICE_URL, array('trace' => 1) ); //new SOAP_Client($this->url, true);
		$this->soapClient = $soapClient;
	}


/*273087386  023985024
0000: bid successful 
9876: exception
*/
	function blockMoney($epsAccount, $orderID, $orderAmount) {
		$params["Reference_Number"] = $orderID;
		$params["Stock_Account"] = $epsAccount;
		$params["Amount"] = $orderAmount;		
		$params["Stock_Code"] = 'EPS'; 
		$params["Stock_Price"] = '1';
		$params["Quantity"] = '1';
		$params["Reserve_Code"] = '0200';
		$params["Transaction_Date"] = date('dmy');//'190407';//
		$params["Command_Code"] = 'O'; 
		$params["Command_Style"] = 'B';
		$params["Currency_Code"] = 'VND';
		$params["Securities_ID"] = 'EPSHCM';//'EPSHCM';  
		$params["Market_Command"] = 'MP';
		$params["Command_Language"] = "V";
		$params["Password"] = VCB_P; 
		try{
			$this->soapClient->Dat_Lenh($params);								 	
	
			$data = $this->soapClient->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
			//var_dump($params);	
			$ret = $xml->getUnserializedData(); 
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name blockMoney Input Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' ErrorCode' .$ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);
			if ($ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE']=='0000') return 0;
			return $ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'];//.' '.$ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['DESCRIPT'];
		}catch(Exception $e){
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name blockMoney ErrorCode 9876 Exception Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),VCB_PATH);
			return '9876';
		}
	}

/*
0000: bid successful 
9876: exception
*/
	function editBlockMoney($epsAccount, $orderID_Old, $orderID, $orderAmount_Old, $orderAmount) {
		try{
			$params["Reference_Number"] = $orderID_Old;
			$params["Stock_Account"] = $epsAccount;
			$params["Amount"] = $orderAmount_Old;		
			$params["Stock_Code"] = ''; 
			$params["Stock_Price"] = '';
			$params["Quantity"] = '';
			$params["Reserve_Code"] = '0200';
			$params["Transaction_Date"] = date('dmy');//'190407';//
			$params["Command_Code"] = 'O'; 
			$params["Command_Style"] = 'B';
			$params["Currency_Code"] = 'VND';
			$params["Securities_ID"] = 'EPSHCM';  
			$params["Market_Command"] = 'MP';
			$params["Command_Language"] = "V"; 
			$params["Password"] = VCB_P; 
			//ite_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name editBlockMoney huy Input Reference_Number ' .$orderID_Old. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' ErrorCode' .$ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);

			$this->soapClient->Huy_Lenh($params);								 	
	
			$data = $this->soapClient->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name editBlockMoney Huy Input Reference_Number ' .$orderID_Old. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount_Old.' ErrorCode' .$ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);
				
			if($ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE']=='0000'){
				$params["Reference_Number"] = $orderID;
				$params["Stock_Account"] = $epsAccount;
				$params["Amount"] = $orderAmount;		
				$params["Stock_Code"] = ''; 
				$params["Stock_Price"] = '';
				$params["Quantity"] = '';
				$params["Reserve_Code"] = '0200';
				$params["Transaction_Date"] = date('dmy');//'190407';//
				$params["Command_Code"] = 'O'; 
				$params["Command_Style"] = 'B';
				$params["Currency_Code"] = 'VND';
				$params["Securities_ID"] = 'EPSHCM';  
				$params["Market_Command"] = 'MP';
				$params["Command_Language"] = "V"; 
				$params["Password"] = VCB_P; 
				$this->soapClient->Dat_Lenh($params);								 	
		
				$data = $this->soapClient->__getLastResponse(); 
		
				$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
				$xml->unserialize($data, FALSE);
				$ret = $xml->getUnserializedData(); 
				write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name editBlockMoney Dat Input Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' ErrorCode' .$ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);			

				if ($ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE']=='0000') 
					return 0;
				else 
					return 'Lock_'. $ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'];

			} else {
				return 'Cancel_'. $ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE'];
			}

			//return $ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'];//.' '.$ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['DESCRIPT'];

		}catch(Exception $e){
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name editBlockMoney ErrorCode 9876 Exception Reference_Number_Old ' .$orderID_Old. ' Reference_Number ' .$orderID.' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),VCB_PATH);
			return '9876';
		}
	}
/*
0000: bid successful 
9876: exception
*/
	function cancelBlockMoney($epsAccount, $orderID, $orderAmount) {
		$params["Reference_Number"] = $orderID;
		$params["Stock_Account"] = $epsAccount;
		$params["Amount"] = $orderAmount;		
		$params["Stock_Code"] = ''; 
		$params["Stock_Price"] = '';
		$params["Quantity"] = '';
		$params["Reserve_Code"] = '0200';
		$params["Transaction_Date"] = date('dmy');//'190407';//
		$params["Command_Code"] = 'O'; 
		$params["Command_Style"] = 'B';
		$params["Currency_Code"] = 'VND';
		$params["Securities_ID"] = 'EPSHCM';  
		$params["Market_Command"] = 'MP';
		$params["Command_Language"] = "V"; 
		$params["Password"] = VCB_P; 
		try{
			$this->soapClient->Huy_Lenh($params);								 	
	
			$data = $this->soapClient->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name cancelBlockMoney Input Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' ErrorCode' .$ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);		
			if ($ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE']=='0000') return 0;			
			return $ret["soap:Body"]["Huy_LenhResponse"]["Huy_LenhResult"]['RESPONSE_CODE'];//.' '.$ret["soap:Body"]["Dat_LenhResponse"]["Dat_LenhResult"]['DESCRIPT'];
		}catch(Exception $e){
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name cancelBlockMoney ErrorCode 9876 Exception Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),VCB_PATH);
			return '9876';
		}
	}

/*
0000: bid successful 
9876: exception
*/
	function cutMoney($epsAccount, $orderID, $orderAmount) {
		$params["Reference_Number"] = $orderID;
		$params["Stock_Account"] = $epsAccount;
		$params["Amount"] = $orderAmount;		
		$params["Stock_Code"] = ''; 
		$params["Stock_Price"] = '';
		$params["Quantity"] = '';
		$params["Reserve_Code"] = '0200';
		$params["Transaction_Date"] = date('dmy');//'190407';//
		$params["Command_Code"] = 'M'; 
		$params["Command_Style"] = 'B';
		$params["Currency_Code"] = 'VND';
		$params["Securities_ID"] = 'EPSHCM';  
		$params["Market_Command"] = 'MP';
		$params["Command_Language"] = "V"; 
		$params["Password"] = VCB_P; 
		try{
			$this->soapClient->Khop_Lenh($params);								 	
	
			$data = $this->soapClient->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name cancelBlockMoney Input Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' ErrorCode' .$ret["soap:Body"]["Khop_LenhResponse"]["Dat_LenhResult"]['RESPONSE_CODE'].' '.date('Y-m-d h:i:s'),VCB_PATH);			
			if ($ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]['RESPONSE_CODE']=='0000') return 0;		
			return $ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]['RESPONSE_CODE'];//.' '.$ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]['DESCRIPT'];
		}catch(Exception $e){
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name cutMoney ErrorCode 9876 Exception Reference_Number ' .$orderID. ' Stock_Account '. $epsAccount. ' Amount '. $orderAmount.' Caught exception: '.$e->getMessage().' '.date('Y-m-d h:i:s'),VCB_PATH);
			return '9876';
		}
	}

	function getAvailBalance($epsAccount) {
		$params["Reference_Number"] = '';
		$params["Stock_Account"] = $epsAccount;
		$params["Amount"] = '';		
		$params["Stock_Code"] = ''; 
		$params["Stock_Price"] = '';
		$params["Quantity"] = '';
		$params["Reserve_Code"] = '';
		$params["Transaction_Date"] = date('dmy');//'190407';//
		$params["Command_Code"] = ''; 
		$params["Command_Style"] = '';
		$params["Currency_Code"] = 'VND';
		$params["Securities_ID"] = 'EPSHCM';  
		$params["Market_Command"] = '';
		$params["Command_Language"] = "V"; 
		$params["Password"] = VCB_P; 
		try{
			$this->soapClient->BALANCE($params);								 	
	
			$data = $this->soapClient->__getLastResponse(); 
	
			$xml = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$xml->unserialize($data, FALSE);
		
			$ret = $xml->getUnserializedData(); 
			$result = $ret["soap:Body"]["BALANCEResponse"]["BALANCEResult"];
		//	var_dump($result);
			$arr = explode("|", $result['DESCRIPT']);	
			//var_dump($arr);
		//	write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name getAvailBalance TK'. $epsAccount.' ' .date('Y-m-d h:i:s'),VCB_PATH);
			settype($arr[1], "double");			
			return $arr[1];
			//return $ret["soap:Body"]["BALANCEResponse"]["BALANCEResult"];//.' '.$ret["soap:Body"]["Khop_LenhResponse"]["Khop_LenhResult"]['DESCRIPT'];
		}catch(Exception $e){
			write_my_log_path('VCB-order',$_SERVER['REMOTE_ADDR'].' function_name getAvailBalance ErrorCode 9876 Exception'.' Caught exception: '.$e->getMessage().' ' .date('Y-m-d h:i:s'),VCB_PATH);
			return '0';
		}
	}

}



?>
