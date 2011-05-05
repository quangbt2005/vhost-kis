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
 * XML/MXML/Controls/DataGrid.php
 *
 * DataGrid element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Controls/List.php';


/**
 * XML/MXML/Controls/DataGrid.php
 *
 * DataGrid element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Controls_DataGrid extends XML_MXML_Controls_List
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'DataGrid';

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
            'columns' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'columnName' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'editable' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'focusedCell' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'headerColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'headerHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'headerStyle' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'hGridLineColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'hGridLines' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'resizableColumns' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'showHeaders' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'sortableColumns' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'vGridLineColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'vGridLines' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'cellEdit' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'cellFocusIn' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'cellFocusOut' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'cellPress' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'columnStretch' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'headerRelease' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
