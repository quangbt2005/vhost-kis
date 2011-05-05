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
 * XML/MXML/Effects/CompositeEffect.php
 *
 * CompositeEffect element.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 * @abstract
 */


require_once 'XML/MXML/Effects/Effect.php';


/**
 * XML/MXML/Effects/CompositeEffect.php
 *
 * CompositeEffect element.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 * @abstract
 */
abstract class XML_MXML_Effects_CompositeEffect extends XML_MXML_Effects_Effect
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName = 'CompositeEffect';

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
            'align' => array(
                'required' => false,
                'type'     => 'enum',
                'values'   => array('baseline', 'center', 'end', 'start', 'stretch'),
                'since'    => '1.0'
            )
        ));
    }
    // }}}
}

?>
