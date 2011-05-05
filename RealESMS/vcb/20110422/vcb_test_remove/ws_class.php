<?php

class WS_Class {
    var $__dispatch_map = array();
    var $__typedef     = array();

	/*
		This is class contruction
		Input: mixed array(0 => $function_name, 1 => $input, 2 => $output)
		Output: NULL
		Purpose: initialize webservice function name and its input/output values
	*/
	function WS_Class() {
		$arr_authen = array('authen_user' => 'string', 'authen_pass' => 'string');
		for($i=0; $i< func_num_args(); $i++) {
			$arg  = func_get_arg($i);
			$function_name = $arg[0];
			
			$input = array_merge($arr_authen, $arg[1]);
			
			$output = $arg[2];

			$this->__dispatch_map[$function_name] =
						array(
							'in' => $input,
							'out' => $output
						);
		}
	}

    function __dispatch($methodname) {
        if (isset($this->__dispatch_map[$methodname]))
            return $this->__dispatch_map[$methodname];
        return NULL;
    }
	
	function xmlreturn($class_name, $functionname, $errorcode, $items)
	{
		new SOAP_Value('return','{urn:'. $class_name .'}'.$functionname.'Result', array(
						"errorcode" => $errorcode, 
						"items"   => new SOAP_Value('items', '{urn:'. $class_name .'}'.$functionname.'Array', $items))
					);
	}

}
?>