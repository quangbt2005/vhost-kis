<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

// {{{ license
// +----------------------------------------------------------------------+
// | PHP Version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Markus Nix <mnix@docuverse.de>                              |
// +----------------------------------------------------------------------+
// }}}


/**
 * XML/MXML/Compiler/Style.php
 *
 * Style element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Element.php';


/**
 * XML/MXML/Compiler/Style.php
 *
 * Style element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Compiler_Style extends XML_MXML_Element
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'Style';

    /**
     * Since MXML version.
     *
     * @access public
     * @var    string
     */
    public $sinceMXMLVersion = '1.0';
    // }}}
    
    
    // {{{ private properties
    /**
     * Array of css rules.
     *
     * @access private
     * @var    array
     */
    private $_css_rules = array();
    // }}}
    

    // {{{ Constructor
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct($attributes = array(), $cdata = null)
    {
        parent::__construct($attributes, $cdata);
        
        $this->addAttributeDefinitions(array(
            'source' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
    
    
    /**
     * Add css rule.
     *
     * @param  string  $identificator
     * @param  array   $properties
     * @return boolean
     * @access public
     */
    public function addRule($identificator, $properties)
    {
        $this->_css_rules[$identificator] = $properties;
    }
    
    /**
     * Remove css rule.
     *
     * @param  string  $identificator
     * @access public
     */
    public function removeRule($identificator)
    {
        if (isset($this->_css_rules[$identificator])) {
            unset($this->_css_rules[$identificator]);
        }
    }
    
    /**
     * Sets specified property of identificator to the value $value.
     *
     * @param  string $identificator Identificator name.
     * @param  string $property Property name.
     * @param  mixed  $value    Value of the property
     * @access public
     */                 
    public function setProperty($identificator, $property, $value)
    {
        if (isset($this->_css_rules[$identificator])) {
            $this->_css_rules[$identificator][$property] = $value;
        }        
    }

    /**
     * Gets the value of the specified property of the identificator.
     *
     * @param  string $identificator Identificator name.
     * @param  string $property    Property name.
     * @access public
     * @return mixed
     */                     
    public function getProperty($identificator, $property)
    {
        if (isset($this->_css_rules[$identificator])) {
            if (isset($this->_css_rules[$identificator][$property])) {
                return $this->_css_rules[$identificator][$property];
            }
        }
        
        return false;
    }
    
    /**
     * Serialize the element.
     *
     * @access public
     * @return string string representation of the element and all of its childNodes
     */
    public function serialize()
    {
        if (!isset($this->attributes['source'])) {
            $def = '';
            
            foreach ($this->_css_rules as $identificator => $properties) {
                if (is_array($properties) && count($properties) > 0) {
                    $def .= "$identificator\n{\n";
            
                    foreach ($properties as $name => $value) {
                        $def .= "    $name: $value;\n";
                    }
            
                    $def .= "}\n";
                }
            }
            
            $this->setCData($def);
        }
        
        return parent::serialize();
    }
}

?>
