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
 * XML/MXML/Core/UIObject.php
 *
 * UIObject element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/MXML/Element.php';


/**
 * XML/MXML/Core/UIObject.php
 *
 * UIObject element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
abstract class XML_MXML_Core_UIObject extends XML_MXML_Element
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'UIObject';

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
            'color' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'creationComplete' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'creationCompleteEffect' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'dragComplete' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'dragDrop' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'dragEnter' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'dragExit' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'dragOver' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'draw' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'effectEnd' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'effectStart' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'fontFamily' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'fontSize' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'fontStyle' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('normal', 'italic'),
                'since'    => '1.0'
            ),
            'fontWeight' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('normal', 'bold'),
                'since'    => '1.0'
            ),
            'height' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'heightFlex' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'hideEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'id' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'initialize' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'load' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'marginLeft' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'marginRight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'maxHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'maxWidth' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'minHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'minWidth' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'mouseChangeSomewhere' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseDown' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseDownEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'mouseDownSomewhere' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseMove' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseMoveSomewhere' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseOut' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseOutEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'mouseOver' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseOverEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'mouseUp' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'mouseUpEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'mouseUpSomewhere' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'move' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'moveEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'nestLevel' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'preferredWidth' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'preferredHeight' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'resize' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'resizeEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'scaleX' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'scaleY' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'showEffect' => array(
                'required' => false,
                'type'     => 'string', // ???
                'since'    => '1.0'
            ),
            'styleName' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'tabEnabled' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'textAlign' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('left', 'right', 'center'),
                'since'    => '1.0'
            ),
            'textDecoration' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('none', 'underline'),
                'since'    => '1.0'
            ),
            'textIndent' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'toolTip' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'unload' => array(
                'required' => false,
                'type'     => 'string',
                'since'    => '1.0'
            ),
            'visible' => array(
                'required' => false,
                'type'     => 'boolean',
                'since'    => '1.0'
            ),
            'width' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'widthFlex' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'x' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            ),
            'y' => array(
                'required' => false,
                'type'     => 'int',
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
