<?php
class SOAPStruct {
    var $varString;
    var $varInt;
    var $varFloat;

    function SOAPStruct($s = null, $i = null, $f = null)
    {
        $this->varString = $s;
        $this->varInt = $i;
        $this->varFloat = $f;
    }
    
    function &__to_soap($name = 'inputStruct') {
        $inner[] =& new SOAP_Value('varString', 'string', $this->varString);
        $inner[] =& new SOAP_Value('varInt', 'int', $this->varInt);
        $inner[] =& new SOAP_Value('varFloat', 'float', $this->varFloat);

        $value =& new SOAP_Value($name,'{http://soapinterop.org/xsd}SOAPStruct', $inner);
        return $value;
    }
}
