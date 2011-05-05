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
 * XML/MXML/Element.php
 *
 * Base class for all elements.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 * @todo     Validate against list of allowed child elements
 */


/**
 * XML/MXML/Element.php
 *
 * Base class for all elements.
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Element implements RecursiveIterator, ArrayAccess
{
    // {{{ public properties
    /**
     * Element name.
     *
     * @access public
     * @var    string
     */
    public $elementName;
    
    /**
     * Attributes of the element.
     *
     * @access public
     * @var    array
     */
    public $attributes = array();

    /**
     * Child nodes of the element.
     *
     * @access public
     * @var    array
     */
    public $childNodes = array();

    /**
     * CData of the element
     *
     * @access public
     * @var    string
     */
    public $cdata;
    
    /**
     * Indicates whether the element is the root element.
     *
     * @access public
     * @var    boolean
     */
    public $isRoot = false;
    
    /**
     * Flag to indicate whether xml entities should be replaced.
     *
     * @access public
     * @var    boolean
     */
    public $replaceEntities = true;
    
    /**
     * Wheter element is MXML element or not.
     *
     * @access public
     * @var    boolean
     */
    public $knownElement = true;
    // }}}
    
    // {{{ protected properties
    /**
     * Set of attributes for this element.
     *
     * @access protected
     * @var    array
     */
    protected $attributeDefinitions = array();
    
    /**
     * Set of allowed child elements for this element.
     *
     * @access protected
     * @var    array
     * @note   Not yet in use!
     */
    protected $allowedChilds = array();
    
    /**
     * Stores a reference to the document that created the
     * element.
     *
     * @access protected
     * @var    object XML_MXML_Document
     */
    protected $document;
    // }}}
    
    // {{{ private properties
    /**
     * Namespace for MXML elements.
     *
     * @access private
     * @var    string
     */
    private $_ns = 'mx';
    
    /**
     * Iteration counter.
     *
     * @access private
     * @var    int
     */
    private $_pos;
    // }}}
    
    // {{{ constants
    /**
     * Error constant for unknown attribute
     *
     * @var    int
     */ 
    const ERROR_ATTRIBUTE_UNKNOWN = 200;
 
    /**
     * Error constant for attribute is no integer
     *
     * @var    int
     */ 
    const ERROR_ATTRIBUTE_NO_INTEGER = 201;
 
    /**
     * Error constant for attribute is no integer
     *
     * @var    int
     */ 
    const ERROR_ATTRIBUTE_NO_BOOLEAN = 202;
 
    /**
     * Error constant for attribute contains invalid value
     *
     * @var    int
     */ 
    const ERROR_ATTRIBUTE_INVALID_VALUE = 203;
    
    /**
     * Maximum of allowed children of a specific type reached.
     *
     * @var    int
     */ 
    const ERROR_CHILDREN_COUNT_MAX = 204;
    
    /**
     * Version conflict.
     *
     * @var    int
     */ 
    const ERROR_VERSION = 205;
    // }}}

     
    // {{{ Constructor
    /**
     * Constructor
     *
     * @access public
     * @param  array   $attributes
     * @param  string  $cdata
     */
    public function __construct($attributes = array(), $cdata = null)
    {
        $this->attributes = $attributes;
        $this->cdata = $cdata;
        
        $this->rewind();
    }
    // }}}    

    // {{{ implementation of iterator methods
    // {{{ rewind
    /**
     * Rewind the Iterator to the first element.
     *
     * @access public
     */
    public function rewind()
    {
        $this->_pos = 0;
    }
    // }}}
    
    // {{{ current
    /** 
     * Return the current element.
     *
     * @access public
     */
    public function current()
    {
        return $this->childNodes[$this->_pos];
    }
    // }}}
    
    // {{{ key
    /** 
     * Return the key of the current element.
     *
     * @access public
     */
    public function key()
    {
        return $this->_pos;
    }
    // }}}
    
    // {{{ next
    /** 
     * Move forward to next element.
     *
     * @access public
     */
    public function next()
    {
        $this->_pos++;
    }
    // }}}
    
    // {{{ valid
    /** 
     * Check if there is a current element after calls to rewind() or next().
     *
     * @access public
     */
    public function valid()
    {
        return $this->_pos < count($this->childNodes);
    }
    // }}}
    
    // {{{ isLast
    /**
     * Check if current element is the last.
     *
     * @return bool
     * @access public
     */
    public function isLast()
    {
        return (count($this->childNodes) == $this->_pos);
    }
    // }}}
        
    // {{{ hasChildren
    /**
     * Return whether current element can be iterated itself.
     *
     * @return bool
     * @access public
     */
    public function hasChildren()
    {
        return (sizeof($this->childNodes) > 0)? true : false;
    }
    // }}}
    
    // {{{ getChildren
    /**
     * Returns an object that recursively iterates the current element.
     * This object must implement RecursiveIterator.
     *
     * @return object
     * @access public
     */
    public function getChildren()
    {
        return $this->childNodes;
    }
    // }}}
    // }}}

    // {{{ implementation of array access methods   
    // {{{ offsetExists
    /**
     * Check if attribute offset exists.
     *
     * @param  mixed  $offset
     * @return boolean
     * @access public
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }
    // }}}
    
    // {{{ offsetGet
    /**
     * Pick value from attributes.
     *
     * @param  mixed  $offset
     * @return mixed
     * @access public
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }
    // }}}
    
    // {{{ offsetSet
    /**
     * Set certain attributes value.
     *
     * @param  mixed  $offset
     * @param  mixed  $data
     * @access public
     */
    public function offsetSet($offset, $data)
    {
        $this->attributes[$offset] = $data;
    }

    // {{{ offsetUnset
    /**
     * Unset certain attributes value.
     *
     * @param  mixed  $offset
     * @access public
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
    // }}}
    // }}}
    
    // {{{ setDocument
    /**
     * Set the reference to the document.
     *
     * @access public
     * @param  object  $doc  XML_MXML_Document
     */
    public function setDocument($doc)
    {
        $this->document = $doc;
    }
    // }}}
    
    // {{{ getDocument
    /**
     * Set the reference to the document.
     *
     * @return object XML_MXML_Document
     * @access public
     */
    public function getDocument()
    {
        return $this->document;
    }
    // }}}
    
    // {{{ setNamespace
    /**
     * Set Namespace.
     *
     * @param  string $ns
     * @access public
     */
    public function setNamespace($ns)
    {
        $this->_ns = $ns;
    }
    // }}}
    
    // {{{ getId
    /**
     * Get the element's id.
     *
     * @access   public
     * @return   string  id of the element
     */
    public function getId()
    {
        if (isset($this->attributes['id'])) {
            return $this->attributes['id'];
        }
        
        return false;
    }
    // }}}
    
    // {{{ getElementName
    /**
     * Get the element's tag name.
     *
     * @access public
     * @return string  tag name of the element
     */
    public function getElementName()
    {
        return $this->elementName;
    }
    // }}}
    
    // {{{ setCData
    /**
     * Sets cdata of the element.
     *
     * @access public
     * @param  string  $cdata
     */
    public function setCData($cdata)
    {
        $this->cdata = $cdata;
    }
    // }}}
    
    // {{{ setCData
    /**
     * Add cdata.
     *
     * @access public
     * @param  string  $cdata
     */
    public function addCData($cdata)
    {
        $this->cdata .= $cdata;
    }
    // }}}
    
    // {{{ setAllowedChilds
    /**
     * Set allowed child elements.
     *
     * @param  miced  $childs  Either array of elements or null (no child allowed)
     * @access protected
     */
    public function setAllowedChilds($childs = array())
    {
        $this->allowedChilds = $childs;
    }
    // }}}
    
    // {{{ getAllowedChilds
    /**
     * Get allowed child elements.
     *
     * @return array
     * @access public
     */
    public function getAllowedChilds()
    {
        return $this->allowedChilds;
    }
    // }}}
    
    // {{{ setAttributes
    /**
     * Sets several attributes at once.
     *
     * @access public
     * @param  array  $attribs
     */
    public function setAttributes($attribs)
    {
        $this->attributes = array_merge($this->attributes, $attribs);
    }
    // }}}
    
    /**
     * Append structure to element.
     *
     * @param  array  $arr
     * @param  bool   $replaceEntities
     * @access public
     * @throws Exception
     */
    public function appendStructure($arr, $replaceEntities = true)
    {
        if (is_array($arr)) {
            foreach ($arr as $value) {
                try {
                    $element = $this->getDocument()->createElement($value['name'], $value['attributes'], isset($value['cdata'])? $value['cdata'] : null);
                } catch (Exception $e) {
                    // rethrow
                    throw $e;
                }

                $this->appendChild($element);

                if ($value['children']) {
                    try {
                        $element->appendStructure($value['children'], $replaceEntities);
                    } catch (Exception $e) {
                        // rethrow
                        throw $e;
                    }
                }
            }
        }
    }
    
    // {{{ setAttribute
    /**
     * Set an attribute.
     *
     * @access public
     * @param  string  $name
     * @param  mixed   $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    // }}}
    
    // {{{ getAttribute
    /**
     * Get an attribute.
     *
     * @access public
     * @param  string  $name
     * @return mixed   $value
     */
    public function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        
        return false;
    }
    // }}}
    
    // {{{ appendChild
    /**
     * Add a child object.
     *
     * @param  object  $obj
     * @access public
     */
    public function appendChild($obj)
    {
        $this->childNodes[] = $obj;
    }
    // }}}

    // {{{ getAvailableAttributes
    /**
     * Get available attributes.
     *
     * @return array
     * @access public
     */
    function getAvailableAttributes()
    {
        return $this->attributeDefinitions;
    }
    
    // }}}

    // {{{ toXML
    /**
     * Create a string representation of the element.
     * This is just an alias for serialize().
     *
     * @access public
     * @return string string representation of the element and all of its childNodes
     */
    public function toXML()
    {
        return $this->serialize();
    }
    // }}}
    
    // {{{ serialize
    /**
     * Serialize the element.
     *
     * @access public
     * @return string string representation of the element and all of its childNodes
     */
    public function serialize()
    {
        if (empty($this->_ns) || $this->knownElement === false) {
            $el = $this->elementName;
        } else {
            $el = sprintf('%s:%s', $this->_ns, $this->elementName);
        }
        
        if (!$this->hasChildren()) {
            if ($this->cdata !== null) {
                $content = $this->cdata;
                
                if ($this->replaceEntities) {
                    $content = XML_Util::replaceEntities($content);
                }
            }
        } else {
            $content = '';
            
            $rit = new RecursiveIteratorIterator($this, RIT_SELF_FIRST);
            while ($rit->getSubIterator()->valid()) {
                $content .= $rit->getSubIterator()->current()->serialize();
                $rit->getSubIterator()->next();
            }
        }
        
        if ($this->isRoot) {
            $nsUri = 'http://www.macromedia.com/2003/mxml';
        } else {
            $nsUri = null;
        }
        
        return XML_Util::createTag(
            $el,
            $this->attributes,
            $content,
            $nsUri,
            false
        );
    }
    // }}}
    
    // {{{ cloneElement
    /**
     * Clone the element.
     *
     * This method will return a copy of the element
     * without the id and the childNodes.
     *
     * @param  boolean $recursive whether children should be cloned, too.
     * @param  string  $id
     * @return object  XML_MXML_Element
     * @access public
     * @throws Exception
     */
    public function cloneElement($recursive = false, $id = '')
    {
        $atts = $this->attributes;
        
        if (!empty($id) && ($atts['id'] != $id)) {
            $atts['id'] = $id;
        } else {
            unset($atts['id']);
        }
    
        try {
            $copy = $this->getDocument()->createElement($this->elementName, $atts, $this->cdata);
        } catch (Exception $e) {
            // rethrow
            throw $e;
        }
        
        if ($recursive !== true) {
            return $copy;
        }
        
        // copy child nodes
        $cnt = count($this->childNodes);
        
        for ($i = 0; $i < $cnt; $i++) {
            try {
                $copy->appendChild($this->childNodes[$i]->cloneElement($recursive));
            } catch (Exception $e) {
                // rethrow
                throw $e;
            }
        }
        
        return $copy;
    }
    // }}}
    
    // {{{ getElementById
    /**
     * Get an element by its id.
     * You should not need to call this method directly.
     *
     * @access public
     * @param  string  $id
     * @return object  XML_MXML_Element or false if the element does not exist
     */
    public function getElementById($id)
    {
        if ($this->getId() == $id) {
            return $this;
        }
        
        $cnt = count($this->childNodes);
        
        if ($cnt == 0) {
            return false;
        }

        for ($i = 0; $i < $cnt; $i++) {
            $result = $this->childNodes[$i]->getElementById($id);
            
            if ($result === false) {
                continue;
            }
            
            return $result;
        }
        
        return false;
    }
    // }}}
    
    // {{{ getElementsByTagname
    /**
     * Get a nodelist of elements by their tagname.
     *
     * @access public
     * @param  string $tagname
     * @return array  array containing XML_MXML_Element objects
     */
    public function getElementsByTagname($tagname)
    {
        $nodeList = array();
        
        if ($this->elementName == $tagname) {
            $nodeList[] = $this;
        }

        $cnt = count($this->childNodes);

        if ($cnt == 0) {
            return $nodeList;
        }

        for ($i = 0; $i < $cnt; $i++) {
            $tmp  = $this->childNodes[$i]->getElementsByTagname($tagname);
            $cnt2 = count($tmp);
            
            for ($j = 0; $j < $cnt2; $j++) {
                $nodeList[] = $tmp[$j];
            }
        }
        
        return $nodeList;
    }
    // }}}
    
    // {{{ validate
    /**
     * Validate the element's attributes.
     *
     * Uses the definitions of common attributes as well as the
     * attribute definitions of the element.
     *
     * @access public
     * @param  boolean $caseInsensitive
     * @param  string  $version
     * @return boolean true on succes
     * @throws Exception
     */
    public function validate($caseInsensitive = true, $version = null)
    {
        if ($this->knownElement == false)
            return true;
            
        /*
        if (method_exists($this, 'customValidate')) {
            try {
                return $this->customValidate();
            } catch (Exception $e) {
                // rethrow
                throw $e;
            }
        }
        */
        
        // validate element version
        if ($this->_validateVersion) {
            if ((double)$version < (double)$this->sinceMXMLVersion) {
                throw new Exception($this->elementName . ' element is not supported in MXML' . $version . '.', XML_MXML_Element::ERROR_VERSION);
            }
        }
        
        foreach ($this->attributes as $name => $value) {
            // ignore namespace definitions
            if (preg_match('/xmlns:/', $name)) {
                continue;
            }
            
            if (isset($this->attributeDefinitions[$name])) {
                $def = $this->attributeDefinitions[$name];
            } else if ($caseInsensitive == true) {
                $found = false;
                
                foreach ($this->attributeDefinitions as $key => $val) {
                    if (strtolower($name) == $key) {
                        $found = true;
                        $def   = $val;
                    }
                }
                
                if (!$found) {
                    throw new Exception('Unknown attribute: ' . $name . ' in element ' . $this->elementName . '.', XML_MXML_Element::ERROR_ATTRIBUTE_UNKNOWN);
                }
            } else {
                throw new Exception('Unknown attribute: ' . $name . ' in element ' . $this->elementName . '.', XML_MXML_Element::ERROR_ATTRIBUTE_UNKNOWN);
            }
            
            // validate attribute version
            if ($this->_validateVersion) {
                if ((double)$version < (double)$def['since']) {
                    throw new Exception('Attribute ' . $name . ' of element ' . $this->elementName . ' is not supported in MXML' . $version . '.', XML_MXML_Element::ERROR_VERSION);
                }
            }
            
            switch ($def['type']) {
                // string
                case 'string':
                
                case 'text':
                
                case 'handler':
                    continue;
                    break;
                
                // integer
                case 'int':

                case 'integer':
                    if (!preg_match('°^[0-9]+$°', $value)) {
                        throw new Exception('Attribute \'' . $name . '\' must be integer.', XML_MXML_Element::ERROR_ATTRIBUTE_NO_INTEGER);
                    }
                    
                    break;
                
                // enumerated value
                case 'enum':
                
                case 'enumeration':
                    if (!in_array($value, $def['values'])) {
                        throw new Exception('Attribute \'' . $name . '\' must be one of ' . implode(', ', $def['values']) . '.', XML_MXML_Element::ERROR_ATTRIBUTE_INVALID_VALUE);
                    }
                    
                    break;
                
                // boolean
                case 'bool':
                
                case 'boolean':
                    if ($value != 'true' && $value != 'false') {
                        throw new Exception('Attribute \''.$name.'\' must be either \'true\' or \'false\'.', XML_MXML_Element::ERROR_ATTRIBUTE_NO_BOOLEAN);
                    }
                    
                    break;
            }
        }
        
        return true;
    }
    // }}}
    
    // {{{ firstChild
    /**
     * Get the first child of the element.
     * If the element has no childNodes, null will be returned.
     *
     * @access public
     * @return object XML_MXML_Element
     */
    public function firstChild()
    {
        if (isset($this->childNodes[0])) {
            return $this->childNodes[0];
        }
        
        $child = null;
        return $child;
    }
    // }}}
    
    // {{{ lastChild
    /**
     * Get last first child of the element.
     * If the element has no childNodes, null will be returned.
     *
     * @access public
     * @return object XML_MXML_Element
     */
    public function lastChild()
    {
        $cnt = count($this->childNodes);
        
        if ($cnt > 0) {
            return $this->childNodes[($cnt - 1)];
        }
        
        $child = null;
        return $child;
    }
    // }}}
    
    // {{{ dump
    /**
     * Get a debug info about the element as
     * string.
     *
     * Use this instead of a print_r on the tree.
     *
     * @param  integer $indent nesting depth, no need to pass this
     * @param  boolean $last
     * @param  boolean $availableAttributes
     * @param  boolean $allowedChildren
     * @return string
     * @access public
     */
    public function dump($indent = '', $last = false, $availableAttributes = false, $allowedChildren = false )
    {
        $name = $this->getElementName();
        $id   = $this->getId();
        
        if ($id !== false) {
            $name .= " [id=$id]";
        }
        
        if ($last) {
            $dump    = sprintf("%s   +-[%s]\n", $indent, $name);
            $indent .= '      ';
        } else {
            $dump    = sprintf("%s   +-[%s]\n", $indent, $name);
            $indent .= '   |  ';
        }
        
        // allowed child elements
        if ($allowedChildren) {
            $dump .= sprintf("%s+-allowed child elements:\n", $indent);
            
            if (!isset($this->allowedChilds)) {
                $dump .= sprintf("%s|    (%s)\n", $indent, 'none');
            } else if (is_array($this->allowedChilds) && !empty($this->allowedChilds)) {
                foreach ($this->allowedChilds as $ele) {
                    $dump .= sprintf("%s|    %s\n", $indent, $ele);
                }  
            } else {
                $dump .= sprintf("%s|    (%s)\n", $indent, 'all');
                
            }
        }
        
        // attributes set by user
        if (!empty($this->attributes)) {
            $dump .= sprintf("%s+-used attributes:\n", $indent);
            
            foreach ($this->attributes as $key => $value) {
                $dump .= sprintf("%s|    %s => %s\n", $indent, $key, $value);
            }
        }
        
        // all attributes available for element
        if ($availableAttributes) {
            $dump .= sprintf("%s+-available attributes:\n", $indent);
            
            ksort($this->attributeDefinitions);
            if (empty($this->attributeDefinitions)) {
                $dump .= sprintf("%s|    (%s)\n", $indent, 'none');
            } else {
                foreach ($this->attributeDefinitions as $key => $value) {
                    if ($value['type'] == 'enum') {
                        $dump .= sprintf("%s|    %s (%s: %s)\n", $indent, $key, $value['type'], implode(', ', $value['values']));
                    } else {
                        $dump .= sprintf("%s|    %s (%s)\n", $indent, $key, $value['type']);
                    }
                }
            }
        }
        
        // cdata
        if (!empty($this->cdata)) {
            $dump .= sprintf("%s+-cdata: %s\n", $indent, $this->cdata);
        } else {
            $dump .= sprintf("%s+-cdata: (none)\n", $indent);
        }
        
        // child elements
        if ($this->hasChildren()) {
            $dump .= sprintf("%s+-childNodes:\n", $indent);
            
            for ($i = 0; $i < count($this->childNodes); $i++) {
                if ($i == (count($this->childNodes) - 1)) {
                    $dump .= $this->childNodes[$i]->dump($indent, true);
                } else {
                    $dump .= $this->childNodes[$i]->dump($indent);
                }
            }
        }
        
        if (!$last) {
            $dump .= sprintf("%s\n", $indent);
        }
        
        return $dump;
    }
    // }}}
    
    
    // protected methods
    
    // {{{ addAttributeDefinitions
    /**
     * Add attribute definitions.
     *
     * @param  array $attr_def
     * @access protected
     */
    protected function addAttributeDefinitions($attr_def = array())
    {
        $this->attributeDefinitions = array_merge($this->attributeDefinitions, $attr_def);
    }
    // }}}
}

?>

