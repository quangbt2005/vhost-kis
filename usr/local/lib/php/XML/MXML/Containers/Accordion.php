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
 * XML/MXML/Containers/Accordion.php
 *
 * Accordion element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Containers/Container.php';


/**
 * XML/MXML/Containers/Accordion.php
 *
 * Accordion element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Containers_Accordion extends XML_MXML_Containers_Container
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'Accordion';

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
            'headerHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'historyManagement' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'marginTop' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'marginBottom' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'openDuration' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'selectedIndex' => array(
                'required' => false,
                'type'     => 'int', // ???
                'since'    => '1.0'
            ),
            'textSelectedColor' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'verticalGap' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>