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
 * XML/MXML/Controls/Tree.php
 *
 * Tree element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Controls/List.php';


/**
 * XML/MXML/Controls/Tree.php
 *
 * Tree element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Controls_Tree extends XML_MXML_Controls_List
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'Tree';

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
            'alternatingRowColors' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'defaultLeafIcon' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'depthColors' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'firstVisibleNode' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'folderOpenIcon' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'folderClosedIcon' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'indentation' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'openDuration' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'openEasing' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'rollOverColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'selectedNode' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'selectionColor' => array(
                'required' => false,
                'type'     => 'string',
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
            'change' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'nodeClose' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'nodeOpen' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
