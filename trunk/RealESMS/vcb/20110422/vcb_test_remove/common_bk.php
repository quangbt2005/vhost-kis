<?php
/**
	Print debug
*/
function p($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function parseDate($date) {
        $reArr = array();
        $reArr = explode("-", $date);
        return $reArr;
}

function parseDateTime($datetime) {
        $reArr = array();
        $timeArr = array();
        list($date, $time) = explode(" ", $datetime);
        $reArr = parseDate($date);
        $timeArr = explode(":", $time);
        $reArr = array_merge($reArr, $timeArr);
        return $reArr;
}

/**
 * Required
 *
 * @access	public
 * @param	string
 * @return	bool
 */
function required($str)
{
	if ( ! is_array($str))
	{
		return (trim($str) == '') ? FALSE : TRUE;
	}
	else
	{
		return ( ! empty($str));
	}
}

/**
 * Minimum Length
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function min_length($str, $val)
{
	if ( ! is_numeric($val))
	{
		return FALSE;
	}

	return (strlen($str) < $val) ? FALSE : TRUE;
}

/**
 * Max Length
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function max_length($str, $val)
{
	if ( ! is_numeric($val))
	{
		return FALSE;
	}

	return (strlen($str) > $val) ? FALSE : TRUE;
}

/**
 * Exact Length
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function exact_length($str, $val)
{
	if ( ! is_numeric($val))
	{
		return FALSE;
	}

	return (strlen($str) != $val) ? FALSE : TRUE;
}

/**
 * Valid Email
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function valid_email($str)
{
	/*return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;*/
	return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+([a-z0-9])/ix", $str)) ? FALSE : TRUE;
}

/**
 * Valid Phone
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function valid_phone($str)
{
	return ( ! preg_match("/^[\(\+?0-9\)\._-]+$/", $str)) ? FALSE : TRUE;
}

/**
 * Validate IP Address
 *
 * @access	public
 * @param	string
 * @return	string
 */
function valid_ip($ip)
{
	return ( ! preg_match( "/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $ip)) ? FALSE : TRUE;
}

/**
 * Alpha
 *
 * @access	public
 * @param	string
 * @return	bool
 */		
function alpha($str)
{
	return ( ! preg_match("/^([-a-z])+$/i", $str)) ? FALSE : TRUE;
}

/**
 * Alpha-numeric
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function alpha_numeric($str)
{
	return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
}

/**
 * Alpha-numeric with underscores and dashes
 *
 * @access	public
 * @param	string
 * @return	bool
 */	
function alpha_dash($str)
{
	return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
}


/**
 * Numeric
 *
 * @access	public
 * @param	int
 * @return	bool
 */	
function numeric($str)
{
	return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
}

/**
 * Is userpass
 * Created by: Le Chi
 * Date 12/3/2007
 * @access	public
 * @param	string
 * @return	bool
 */	
function userpass($str)
{
	//return ( ! preg_match("/^([-a-z0-9!@#\$%^&*._-])+$/i", $str)) ? FALSE : TRUE;
	$strl=strlen($str);
	$flag=true;
	for ($i=0;$i<=$strl-1;$i++) { 
		if  ( (ord($str[$i]) >= 32)&&(ord($str[$i]) <= 126)&&(ord($str[$i]) != 39)&&(ord($str[$i]) != 34)&&(ord($str[$i]) != ' ') &&(ord($str[$i]) != 92)) { 
			  $flag=true;
		}else{
			  $flag=false;
			  break;
		}
	}
	return $flag;
}

/**
 * Is unsigned number
 * Created by: Le Chi
 * Date 12/13/2007
 * @access	public
 * @param	string
 * @return	bool
 */	
function unsigned($str)
{
	if(!is_numeric($str))
	{
		return false;
	} else {
		if ($str<=0) 
			return false;				
	}
	return true;
}

/**
 * Is valid date
 * Created by: Le Chi
 * Date 20/3/2007
 * @access	public
 * @param	string format date (dd/mm/yyyy or dd.mm.yyyy or dd-mm-yyyy)
 * @return	bool
 */	
function valid_date1($str)
{
	$date_arr = split('[/.-]', $str);
	//echo count($date_arr);
	//var_dump($date_arr);
	if(count($date_arr)!=3) return false;
	else{
	//checkdate ( int month, int day, int year )
		return checkdate($date_arr[1],$date_arr[0],$date_arr[2]);
	}
	return true;
}

/**
 * Is valid date
 * Created by: Le Chi
 * Date 13/09/2007
 * @access	public
 * @param	string format date (yyyymmdd)
 * @return	bool
 */	
function dateStr($str)
{
	//echo count($date_arr);
	//var_dump($date_arr);
	if(strlen($str)!=8 || !is_numeric($str)) return false;
	else{
	//checkdate ( int month, int day, int year )	
		return checkdate(substr($str,4,2),substr($str,6,2),substr($str,0,4));
	}
	return true;
}
/**
 * Is valid date
 * Created by: Le Chi
 * Date 20/3/2007
 * @access	public
 * @param	string format date (yyyy-mm-dd)
 * @return	bool
 */	
function valid_date($str)
{
	$date_arr = split('-', $str);
	//echo count($date_arr);
	//var_dump($date_arr);
	if(count($date_arr)!=3) return false;
	else{
	//checkdate ( int month, int day, int year )
		return checkdate($date_arr[1],$date_arr[2],$date_arr[0]);
	}
	return true;
}

/** 
	Description: merge array;
	param: array
	return array
*/
function arrayMerge( $a1, $a2 ) 
{
	foreach ($a2 as $k => $v) 
	{
		$a1[$k] = $v;
	}
	return $a1;
}

/** 
	Description: ;
	input: classname,$functionname,$errorcode, items
	return array
*/
function returnXML($arrArgs, $class_name, $function_name, /*$PersonalCard, $Name, $Account, $State, $ResponseCode, $RespString, $OldNewAccount,*/$array_input, $obj=NULL) {
	$count = count($arrArgs);
	$user = $arrArgs[$count-2];
	if (strpos($obj->_MDB2->last_query, "sp_ServiceLogin") > 0)
		my_log($user, 'INFO', $obj->_MDB2->last_query);

	if ( $obj->_MDB2_WRITE->last_query != "" ) {
		$kind = $class_name ."->". $function_name;
		$detail = $obj->_MDB2_WRITE->last_query ." --> ". $error_code;
		my_log($user, 'ALL', $detail);
	}

	$result = "{urn:". $class_name ."}". $function_name ."Result";
	$array = "{urn:". $class_name ."}". $function_name ."Array";
	/*return new SOAP_Value('return', $result, array(
					"error_code" => new SOAP_Value('error_code', 'string', $error_code), 
						  "items"   => new SOAP_Value('items', $array, $items)
						  )
					 );*/
	return new SOAP_Value('return', $result, $array_input/*array(
					'PersonalCard' => new SOAP_Value('PersonalCard', 'string', $PersonalCard),
					"Name" => new SOAP_Value('Name', 'string', $Name), 					
					'Account' => new SOAP_Value('Account', 'string', $Account),
					'State' => new SOAP_Value('State', 'string', $State),
					'ResponseCode' => new SOAP_Value('ResponseCode', 'string', $ResponseCode),
					'RespString' => new SOAP_Value('RespString', 'string', $RespString),
					'OldNewAccount' => new SOAP_Value('OldNewAccount', 'string', $OldNewAccount)
						  )*/
					 );
}

/** 
	Description: init DB for SELECT only;
	input: null
	return db object
*/
function initDB()
{
	//initialize MDB2
	$mdb2 = &MDB2::factory(DB_DNS);
	//var_dump($mdb2);
	$mdb2->loadModule('Extended');
	$mdb2->loadModule('Date');
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	return $mdb2;
}

/** 
	Description: init DB for WRITE;
	input: null
	return db object
*/
function initWriteDB()
{
	//initialize MDB2
	$mdb2 = &MDB2::factory(DB_DNS_WRITE);
	$mdb2->loadModule('Extended');
	$mdb2->loadModule('Date');
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	return $mdb2;
}

/**
validate IP
*/
function addZeroCharacter($bin_string,$maxlen = 8) {
	while (strlen($bin_string) < $maxlen) {
		$bin_string = "0" . $bin_string; 
	}
	return $bin_string;
}

function ip2decimal($ip) {
	$arr = explode(".", $ip);
	$part0 = addZeroCharacter(decbin(intval($arr[0])),8);
	$part1 = addZeroCharacter(decbin(intval($arr[1])),8);
	$part2 = addZeroCharacter(decbin(intval($arr[2])),8);
	$part3 = addZeroCharacter(decbin(intval($arr[3])),8);

	return $dec_value = bindec("$part0 . $part1 . $part2 . $part3");
}

/**
 * Function name: validateIP
 * Description: 
 * Access: public
 * Input:
 *	- $ip: IP need validated
 *	- $fromip: start from ip
 *	- $toip: end from ip
 *	- $type: allowed / denied
 * Output: boolean
 */
function validateIP($ip, $fromip, $toip, $type='allowed') {
	$dec_ip = ip2decimal($ip);
	$dec_fromip = ip2decimal($fromip);
	$dec_toip = ip2decimal($toip);
	
	if ($dec_fromip <= $dec_ip && $dec_ip <= $dec_toip) {
		if ($type == 'allowed')
			return true;  
		else 
			return false; 
	}
	else {
		if ($type == 'allowed')
			return false;
		else
			return true; 
	}		
}		

/**
	Author: Ly Duong Duy Trung
	Description: IP & User authentication
	Input: list arguments, class object
	Output: error code / continue
*/
function authenUser($list_args, &$obj, $function_name="") {
	$mdb2 = initDB();
	//$struct = '{urn:'. $obj->class_name .'}'. $function_name . 'Struct';

	if ( $obj->_ERROR_CODE > 0)
		return $obj->_ERROR_CODE;

	$count = count($list_args);
	$authen_query = sprintf( "CALL sp_ServiceLogin('%s', '%s')", $list_args[$count-2], $list_args[$count-1] );
	$result = $mdb2->extended->getAll($authen_query);
	if ($result[0]['varerror'] < 0) {
		$obj->_ERROR_CODE = 10014;
		$mdb2->disconnect();
		return 10014;
	} else {
		/*$obj->items[0] = new SOAP_Value(
							'item',
							$struct,
							array(
								"ID"    => new SOAP_Value( "ID", "string", $result[0]['varerror'] )
								)
						);*/
		$mdb2->disconnect();
		return 0; // authen successful
	}
}

function validRemoteIP($remote_ip) {
	$mdb2 = initDB();

	//return 0;	
	$deny_query = sprintf( "SELECT * FROM %s WHERE Deleted='0'", TBL_IP_DENIED);
	$result = $mdb2->extended->getAll($deny_query);
	for($i=0; $i<count($result); $i++) {
		if (!validateIP($remote_ip, $result[$i]['fromaddress'], $result[$i]['toaddress'], 'denied'))
			return 10013;
	}	
	$allow_query = sprintf( "SELECT * FROM %s WHERE Deleted='0'", TBL_IP_ALLOWED);
	$result = $mdb2->extended->getAll($allow_query);
	//$error_code = 10013;
	for($i=0; $i<count($result); $i++) {
		//echo $remote_ip;
		//echo $result[$i]['fromaddress'];
		if (validateIP($remote_ip, $result[$i]['fromaddress'], $result[$i]['toaddress'], 'allowed'))
			return 0;
	}
	$mdb2->disconnect();

	return 10013; // valid IP
}

/**
	Description: get timezon from db
	Input: 
	Output: timezon
*/
function get_timezon()
{
	$mdb2 = initDB();

	$query = sprintf( "select f_getSystemTimeZone()");
	$result = $mdb2->extended->getAll($query);	
	$mdb2->disconnect();
	return $result[0]['f_getsystemtimezone()'];
}

/**
	Description: is admin or not
	Input: EmployeeID
	Output: 
*/
function checkIsAdmin($EmployeeID)
{
	$mdb2 = initDB();
	$query = sprintf( "SELECT UserName
					 FROM %s
					 WHERE Deleted='0'
					 AND ID=%u", TBL_EMPLOYEE, $EmployeeID);
	$result = $mdb2->extended->getAll($query);
	if ( $result[0]['username'] == ADMIN_USER ) {
		return true;
		$mdb2->disconnect();
	} else {
		return false;
		$mdb2->disconnect();	
	}
}

function my_format_number($value, $language='vi', $decimal=0) {
	switch(strtolower($language)) {
		case "vi":			
			return number_format($value, $decimal, ".", ",");
			break;
		case "en":
		case "jp":
		default:
			return number_format($value, $decimal);
			break;
	}
}

function getAccountNo($ID,$table)
{
	$mdb2 = initDB();

	$query = sprintf( "select a.AccountNo as AccountNo from account a, %s b where a.ID=b.AccountID and a.Deleted='0' and (isnull(a.`CloseDate`) or (a.`CloseDate` = '')) and b.Deleted='0'and b.ID=%s",$table,$ID);
	$result = $mdb2->extended->getAll($query);	
	$num_row = count($result);	
	$mdb2->disconnect();
	if($num_row>0) return $result[0]['accountno'];
	return 0;
}

function getInvestorType($AccountNo)
{
	$mdb2 = initDB();

	$query = sprintf( "select a.InvestorType from account a, Investor i where i.ID=a.InvestorID and a.Deleted='0' and (isnull(a.`CloseDate`) or (a.`CloseDate` = '')) and b.Deleted='0'and a.AccountNo='%s'",$AccountNo);
	$result = $mdb2->extended->getAll($query);	
	$num_row = count($result);	
	$mdb2->disconnect();
	if($num_row>0) return $result[0]['investortype'];
	return '0';
}

/**
	 * Generate CSV 
	 *
	 * @access	public
	 * @param	array	result 
	 * @param	string	filename
	 * @param	array	header 
	 * @param	string	The delimiter - tab by default
	 * @param	string	The newline character - \n by default
	 * write file 
	 */
function csv_bank($result, $filename, $header="", $delim = "\t", $newline = "\n")
{			
	//$out = array();
	$path =  CSV_PATH;
	$date_array = getdate();
	$csv_dir = $path.$date_array['year'].'/';
	if (!is_dir($csv_dir)){
		mkdir( $csv_dir, 0777 ); 
	}
	$csv_dir = $csv_dir.$date_array['mon'].'/';
	if (!is_dir($csv_dir)){
		mkdir( $csv_dir, 0777 ); 
	}
	$fp = fopen($csv_dir.$date_array['year'].$date_array['mon'].$date_array['mday'].'_'.$filename.'.csv', 'w');
	// Header
	if($header!='' && is_array($header)){										
		fputcsv($fp, $header);
	}
	// record
	foreach ($result as $row)
	{
		if($row){
			fputcsv($fp, $row);
		}
	}
	
	fclose($fp);
}

function mailSMTP($from_name,$from,$to,$cc,$bcc,$subject,$message)
{			
	include ("class.phpmailer.php");
	$mail = new PHPMailer();
	
	$mail->IsSMTP();                                   // send via SMTP
	$mail->Host     = "mail.eps.com.vn"; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = 'webmaster';  // SMTP username
	$mail->Password = 'alibabama'; // SMTP password
	
	$mail->From     = $from;
	$mail->FromName = $fromname;
	$mail->ClearAddresses(); 
	$mail->AddAddress($to); 
	if($cc!=''){
		$mail->AddAddress($cc); 
	}
	if($bcc!=''){
		$mail->AddAddress($bcc); 
	}
	$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML(true);            
	$mail->CharSet = "UTF-8"; 
	$mail->Subject  =  $subject;
	$mail->Body     =  $message;
	$ok = $mail->Send();
	//if($ok) echo 'phpmailer 1233';
	//else echo 'phpmailer 3445';
	$mail->SmtpClose();
	return $ok;
}

function write_my_log($filename,$content)
{				
	$path =  '/home/vhosts/eSMS/htdocs/vcb/logs/';
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

?>
