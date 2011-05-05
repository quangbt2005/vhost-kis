<?php
$_DocRoot = $_SERVER["DOCUMENT_ROOT"];
require_once($_DocRoot ."/dab/webservice.php");
include_once ( $_DocRoot .'/dab/my_helper.php');

class WS_Class {
    var $__dispatch_map = array();
    var $__typedef     = array();
	var $class_name;
	/*
		This is class contruction
		Input: mixed array(0 => $function_name, 1 => $input, 2 => $output)
		Output: NULL
		Purpose: initialize webservice function name and its input/output values


        * I use __typedef to describe userdefined Types in WSDL.
        * Structs and one-dimensional arrays are supported:
        * Struct example: 
		*	$this->__typedef['TypeName'] = array('VarName' => 'xsdType', ... );
        *    or $this->__typedef['TypeName'] = array('VarName' => '{namespace}SomeOtherType');

        * Array example: 
		*	$this->__typedef['TypeName'] = array(array('item' => 'xsdType'));
        *    or $this->__typedef['TypeName'] = array(array('item' => '{namespace}SomeOtherType'));
	*/

	function WS_Class($arr_function = array()) {
		//array of authen. info
		$arr_authen = array('AuthenUser' => 'string', 'AuthenPass' => 'string');
		while (list($function_name, $arr_IO) = each( $arr_function)) {
			//namespace
			$ns = '{urn:'. $this->class_name .'}';

			//struct
			$result_struct = $function_name ."Struct";
			$result_struct_ns = $ns . $result_struct;

			//array
			$result_array = $function_name ."Array";
			$result_array_ns = $ns . $result_array;
			
			//result
			$function_result = $function_name ."Result";
			$function_result_ns = $ns . $function_result;
			
			$input = genStruct($arr_IO['input']);
			$output = genStruct($arr_IO['output']);

			$this->__typedef[$result_struct] = $output;
			
											
			/*$this->__typedef[$result_array] = array(
													array(
														'item' => $result_struct_ns )
												);

			$this->__typedef[$function_result] = array(
														'error_code' => 'string',
														'items' => $result_array_ns
												);
			*/
			$this->__typedef[$result_array] = array(
													array(
														'item' => $result_struct_ns )
												);

			$this->__typedef[$function_result] = array( 'PersonalCard' => 'string',
														'Name' => 'string',														
														'Account' => 'string',
														'State' => 'string',
														'ResponseCode' => 'string',
														'RespString' => 'string',
														'OldNewAccount' => 'string'
												);
			//look
			//$arr_input = array_merge( $arr_IO['input'], $arr_authen );
			$arr_input = array_merge( $input, $arr_authen );

			//$this->__dispatch_map[$function_name] = array( 'in' => $input,
			$this->__dispatch_map[$function_name] = array( 'in' => $arr_input,
															'out' => array('return' => $function_result_ns ));
		}
	}

    function __dispatch($methodname) {
        if (isset($this->__dispatch_map[$methodname]))
            return $this->__dispatch_map[$methodname];
        return NULL;
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class WebServiceAPI {
    var $__dispatch_map = array();
    var $__typedef     = array();
	var $class_name;
	/*
		This is class contruction
		Input: mixed array(0 => $function_name, 1 => $input, 2 => $output)
		Output: NULL
		Purpose: initialize webservice function name and its input/output values


        * I use __typedef to describe userdefined Types in WSDL.
        * Structs and one-dimensional arrays are supported:
        * Struct example: 
		*	$this->__typedef['TypeName'] = array('VarName' => 'xsdType', ... );
        *    or $this->__typedef['TypeName'] = array('VarName' => '{namespace}SomeOtherType');

        * Array example: 
		*	$this->__typedef['TypeName'] = array(array('item' => 'xsdType'));
        *    or $this->__typedef['TypeName'] = array(array('item' => '{namespace}SomeOtherType'));
	*/

	function WebServiceAPI($arr_function = array()) {
		//array of authen. info
		$arr_authen = array('authen_user' => 'string', 'authen_pass' => 'string');
		while (list($function_name, $arr_IO) = each( $arr_function)) {
			//namespace
			$ns = '{urn:'. $this->class_name .'}';

			//struct
			$result_struct = $function_name ."Struct";
			$result_struct_ns = $ns . $result_struct;

			//array
			$result_array = $function_name ."Array";
			$result_array_ns = $ns . $result_array;
			
			//result
			$function_result = $function_name ."Result";
			$function_result_ns = $ns . $function_result;
			
			$input = genStruct($arr_IO['input']);
			$output = genStruct($arr_IO['output']);

			$this->__typedef[$result_struct] = $output;

			$this->__typedef[$result_array] = array(
														$function_result => $result_struct_ns 
												);

			//look
			$arr_input = array_merge( $arr_IO['input'], $arr_authen );

			$this->__dispatch_map[$function_name] = array( 'in' => $input,
															'out' => array('return' => $function_result_ns ));
		}
	}

    function __dispatch($methodname) {
        if (isset($this->__dispatch_map[$methodname]))
            return $this->__dispatch_map[$methodname];
        return NULL;
    }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class test extends WS_Class{
	var $mdb2;
	/*
		constructor
	$arr = array( 'getCompany' => array( 'input' => array( 'ID'),
										'output' => array( 'ID', 'CompanyName', 'Symbol', 'FaceValue'),
				'SayThisNTimes' => array( 'input' => array( 'SayWhat', 'Times'),
										'output' => array('SayThis')));

	*/
	function test() {
		//initialize MDB2
		$mdb2 = &MDB2::factory(DB_DNS);
		$mdb2->loadModule('Extended');
		$mdb2->loadModule('Date');
		$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
		$this->mdb2 = $mdb2 ;
		$this->class_name = get_class($this);

		$arr = array( 'getCompany' => array( 'input' => array( 'ID'),
											'output' => array( 'ID', 'CompanyName', 'Symbol', 'FaceValue')),
					'SayThisNTimes' => array( 'input' => array( 'SayWhat', 'Times'),
											'output' => array('SayThis')));

		parent::__construct($arr);
	}
	
    function SayThisNTimes($SayThis, $NTimes) {
		$ns = '{urn:'. $this->class_name .'}SayThisNTimesResult';
        for ($i = 0; $i<$NTimes; $i++) {
            $return[$i] = $SayThis . " $i";
        }
        return new SOAP_Value('return', $ns, $return);
    }

    function getCompany($cid) {
		$class_name = $this->class_name;
		$query = "SELECT ID, CompanyName, Symbol, FaceValue FROM company WHERE ID < $cid LIMIT 3";
		$result = $this->mdb2->extended->getAll($query);

        for($i=0; $i<count($result); $i++) {
            $this->items[$i] = new SOAP_Value(
                    'item',
                    '{urn:'. $class_name .'}getCompanyStruct',
                    array(
                        "ID"         => new SOAP_Value("ID", "string", $result[$i]['id']),
                        "CompanyName"        => new SOAP_Value("CompanyName", "string", $result[$i]['companyname']),
                        "Symbol"         => new SOAP_Value("Symbol", "string", $result[$i]['symbol']),
                        "FaceValue"    => new SOAP_Value("FaceValue", "string", $result[$i]['facevalue'])
                        )
                );
        }

		return new SOAP_Value('return','{urn:'. $class_name .'}getCompanyResult', array(
                    "items"   => new SOAP_Value('items', '{urn:'. $class_name .'}getCompanyArray', $this->items)
                    )
                );
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
$server = new SOAP_Server;
$server->_auto_translation = true;
$a  = new test();
$server->addObjectMap($a, 'urn:test');
//p($a->getCompany('12'));exit;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $server->service($HTTP_RAW_POST_DATA);
} else {
    require_once 'SOAP/Disco.php';
    $disco = new SOAP_DISCO_Server($server,"test");
    header("Content-type: text/xml");
    if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0) {
        echo $disco->getWSDL();
    } else {
        echo $disco->getDISCO();
    }
    exit;
}*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>