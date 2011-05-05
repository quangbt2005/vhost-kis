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
 * XML/MXML.php
 *
 * Package to create MXML documents.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */


/**
 * XML/MXML.php
 *
 * Package to create MXML documents.
 *
 * To create a new document you have to call
 * createDocument() statically:
 *
 * <code>
 * require_once 'XML/MXML.php';
 *
 * $doc = XML_MXML::createDocument( 'myXML.mxml' );
 * </code>
 *
 * The document object provides methods to create and
 * add any element you like:
 *
 * <code>
 * try {
 *      $root = $doc->createElement('Application', array('application'=> 'Demo application for MXML'));
 *      $doc->addRoot($root);
 * } catch (Exception $e) {
 *      die($e->getMessage());
 * }
 * </code>
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 * @static
 */
class XML_MXML
{
    // {{{ createDocument
    /**
     * Create a MXML document.
     *
     * @access  public
     * @param   string  $filename
     * @return  object  Instance of XML_MXML_Document
     * @static
     */
    public function createDocument($filename = null)
    {
        require_once 'XML/MXML/Document.php';

        $doc = new XML_MXML_Document($filename);
        return $doc;
    }
    // }}}
    
    // {{{ loadFile
    /**
     * Load MXML document from file.
     *
     * @access  public
     * @param   string  $filename
     * @static
     */
    public function loadFile($filename)
    {
        require_once 'XML/MXML/Parser.php';

        $parser = new XML_MXML_Parser();
        $doc    = $parser->loadFile($filename);
        
        return $doc;
    }
    // }}}
    
    // {{{ loadString
    /**
     * Load MXML document from a string.
     *
     * @access  public
     * @param   string  $filename
     * @static
     */
    public function loadString($filename)
    {
        require_once 'XML/MXML/Parser.php';

        $parser = new XML_MXML_Parser();
        $doc    = $parser->loadString($filename);

        return $doc;
    }
    // }}}
    
    // {{{ apiVersion
    /**
     * Return API version.
     *
     * @access   public
     * @static
     * @return   string  $version API version
     */
    public static function apiVersion()
    {
        return '0.3.0';
    }
    // }}}
}

?>
