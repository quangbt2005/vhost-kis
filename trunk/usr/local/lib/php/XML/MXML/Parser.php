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
 * XML/MXML/Parser.php
 *
 * Parser that is able to parse MXML documents.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */


/**
 * use XML_Parser to parse the document
 */
require_once 'XML/Parser.php';
 

/**
 * XML/MXML/Parser.php
 *
 * Parser that is able to parse MXML documents.
 *
 * Currently the parser does not support namespaces, as XML_Parser
 * has no namespace support. This will hopefully change in future
 * releases.
 *
 * @package XML_MXML
 * @author  Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Parser extends XML_Parser
{
    // {{{ private properties
    /**
     * Tag stack
     *
     * @access private
     * @var    array
     */
    private $_tagStack = array();

    /**
     * CData
     *
     * @access private
     * @var    array
     */
    private $_cdata = array();

    /**
     * Depth
     *
     * @access private
     * @var    integer
     */
    private $_depth = 0;

    /**
     * Document object
     *
     * @access private
     * @var    object XML_MXML_Document
     */
    private $_doc;
    // }}}
    
    
    // {{{ Constructor
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->folding = false;
    }
    // }}}


    // {{{ loadFile
    /**
     * Parse a file.
     *
     * @param  string  $filename of the file to parse
     * @return object  XML_MXML_Document
     * @access public
     */
    public function loadFile($filename)
    {
        require_once 'XML/MXML/Document.php';

        $this->_doc = new XML_MXML_Document($filename);

        $this->XML_Parser();
        $this->setInputFile($filename);
        $result = $this->parse();
        
        if ($this->isError($result)) {
            return $result;
        }
        
        return $this->_doc;
    }
    // }}}
    
    // {{{ loadString
    /**
     * Parse a string.
     *
     * @param  string  string to parse
     * @return object  XML_MXML_Document
     * @access public
     */
    public function loadString($string)
    {
        require_once 'XML/MXML/Document.php';

        $this->_doc = new XML_MXML_Document();

        $this->XML_Parser();
        $result = $this->parseString($string);
        
        if ($this->isError($result)) {
            return $result;
        }
        
        return $this->_doc;
    }
    // }}}
    
    // {{{ startHandler
    /**
     * Start element handler.
     *
     * @param  object $parser  XML parser object
     * @param  string $name    XML element
     * @param  array  $atts    attributes of XML tag
     * @access protected
     */
    public function startHandler($parser, $name, $atts)
    {
        array_push($this->_tagStack, array(
            'name'       => $name,
            'atts'       => $atts,
            'childNodes' => array()
        ));
        
        $this->_depth++;
        $this->_cData[$this->_depth] = '';
    }
    // }}}
    
    // {{{ endHandler
    /**
     * End element handler
     *
     * @param  object $parser XML parser object
     * @param  string $name   XML element
     * @access protected
     */
    public function endHandler($parser, $name)
    {
        $cdata = $this->_cData[$this->_depth];
        $this->_depth--;
        $def = array_pop($this->_tagStack);

        try {
            // remove namespace prefix so we can properly create element from repository
            $name = str_replace('mx:', '', $def['name']);
            
            $el = $this->_doc->createElement($name, $def['atts'], $cdata);
            
            if (strtolower($el->elementName) == 'application') {
                $el->isRoot = true;
            }
        } catch (Exception $e) {
            // swallow
            return false;        
        }
        
        for ($i = 0; $i < count($def['childNodes']); $i++) {
            $el->appendChild($def['childNodes'][$i]);
        }
        
        $parent = array_pop($this->_tagStack);

        if (is_array($parent)) {
            array_push($parent['childNodes'], $el);
            array_push($this->_tagStack, $parent);
        } else {
            $this->_doc->addRoot($el);
        }
        
        return true;
    }
    // }}}
    
    // {{{ cdataHandler
    /**
     * Handler for character data.
     *
     * @param  object $parser XML parser object
     * @param  string $cdata  CDATA
     * @access protected
     */
    public function cdataHandler($parser, $cdata)
    {
        $cdata = trim($cdata);

        if (empty($cdata)) {
            return true;
        }
        
        $this->_cData[$this->_depth] .= $cdata;
    }
    // }}}
}

?>
