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
 * XML/MXML/Core/UIComponent.php
 *
 * UIComponent element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Core/UIObject.php';


/**
 * XML/MXML/Core/UIComponent.php
 *
 * UIComponent element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
abstract class XML_MXML_Core_UIComponent extends XML_MXML_Core_UIObject
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'UIComponent';

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
            'enabled' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'errorString' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'tabEnabled' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'tabIndex' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'focusInEffect' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'focusOutEffect' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundDisabledColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundImage' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'backgroundAlpha' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'backgroundSize' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'barColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'borderCapColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'buttonColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'borderStyle' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'disabledColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'errorColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'highlightColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'lineHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'modalTransparency' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'scrollTrackColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'shadowColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'shadowCapColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'symbolColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'symbolBackgroundColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'symbolBackgroundDisabledColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'symbolBackgroundPressedColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'symbolDisabledColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'themeColor' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'focusIn' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'focusOut' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'hide' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'keyDown' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'keyUp' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'resize' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'show' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'valid' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'valueCommitted' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
