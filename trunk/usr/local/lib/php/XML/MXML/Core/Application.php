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
 * XML/MXML/Core/Application.php
 *
 * Application element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Containers/Box.php';


/**
 * XML/MXML/Core/Application.php
 *
 * Application element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Core_Application extends XML_MXML_Containers_Box
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'Application';

    /**
     * Since MXML version.
     *
     * @access public
     * @var    string
     */
    public $sinceMXMLVersion = '1.0';
    
    /**
     * Array of namespaces.
     *
     * @access public
     * @var    array
     */
    public $namepaces = array();
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
            'application' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundImage' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundSize' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'frameRate' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'height' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'horizontaAlign' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('center', 'left', 'right'),
                'since'    => '1.0'
            ),
            'pageTitle' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'preloader' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'resetHistory' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'scriptRecursionLimit' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'scriptTimeLimit' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'selfContained' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'theme' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'usePreloader' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'width' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
