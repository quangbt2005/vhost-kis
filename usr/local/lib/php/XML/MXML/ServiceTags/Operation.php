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
 * XML/MXML/ServiceTags/Operation.php
 *
 * Operation element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Element.php';


/**
 * XML/MXML/ServiceTags/Operation.php
 *
 * Operation element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_ServiceTags_Operation extends XML_MXML_Element
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'operation'; // lowercase!

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
            'concurrency' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('multiple', 'single', 'last'),
                'since'    => '1.0'
            ),
            'fault' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'name' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'result' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'resultFormat' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('object','xml'),
                'since'    => '1.0'
            )
        ));
    }
    // }}}
    
    
    /**
     * Add a new request.
     *
     * @param   array   $item   attributes of the item
     * @return  object  XML_MXML_ServiceTags_Request
     * @access  public
     * @throws  Exception
     */
    public function addRequest($item = array())
    {
        static $count = 0;
        
        if ($count == 1) {
            throw new Exception('Operation can only have a single Request tag.', XML_MXML_Element::ERROR_CHILDREN_COUNT_MAX);
        }
        
        if (!is_object($item)) {
            try {
                $item = $this->getDocument()->createElement('request', $item);
            } catch (Exception $e) {
                // rethrow
                throw $e;
            }
        }
        
        $this->appendChild($item);
        $count++;
        
        return $item;
    }
}

?>
