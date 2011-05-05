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
 * XML/MXML/Containers/Container.php
 *
 * Container element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Core/View.php';


/**
 * XML/MXML/Containers/Container.php
 *
 * Container element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
abstract class XML_MXML_Containers_Container extends XML_MXML_Core_View
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'Container';

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
            'autoLayout' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'clipContent' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'creationPolicy' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('auto', 'all', 'none'),
                'since'    => '1.0'
            ),
            'defaultButton' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'hLineScrollSize' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'hPageScrollSize' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'hPosition' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'hScrollPolicy' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('auto', 'on', 'off'),
                'since'    => '1.0'
            ),
            'icon' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'vLineScrollSize' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'vPageScrollSize' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'vPosition' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'vScrollPolicy' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('auto', 'on', 'off'),
                'since'    => '1.0'
            ),
            // not documented
            'label' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
