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
 * XML/MXML/Controls/TextInput.php
 *
 * TextInput element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Core/UIComponent.php';


/**
 * XML/MXML/Controls/TextInput.php
 *
 * TextInput element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Controls_TextInput extends XML_MXML_Core_UIComponent
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'TextInput';

    /**
     * Since MXML version.
     *
     * @access public
     * @var    string
     */
    public $sinceMXMLVersion = '1.0';
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
            'editable' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'hPosition' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'htmlText' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'maxChars' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'maxHPosition' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'password' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'restrict' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'text' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'change' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'enter' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
    
    
    /**
     * Add text.
     *
     * @param   array   $item   attributes of the item
     * @return  object  XML_MXML_Controls_Text
     * @access  public
     * @throws  Exception
     */
    public function addText($item = array())
    {
        if (!is_object($item)) {
            try {
                $item = $this->getDocument()->createElement('text', $item);
            } catch (Exception $e) {
                // rethrow
                throw $e;
            }
        }
        
        $this->appendChild($item);
        return $item;
    }
}

?>
