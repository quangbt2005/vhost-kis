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
 * XML/MXML/Document.php
 *
 * Document object
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */


require_once 'XML/Util.php';
require_once 'XML/MXML/Element.php';


/**
 * XML/MXML/Document.php
 *
 * Document object
 *
 * @package  XML_MXML
 * @author   Markus Nix <mnix@docuverse.de>
 */
class XML_MXML_Document
{
    // {{{ protected properties    
    /**
     * Root element.
     * Should be an Application element.
     *
     * @access protected
     * @var    object  XML_MXML_Element
     */
    protected $root;
    // }}}
    
    // {{{ private properties
    /**
     * Filename
     *
     * @access private
     * @var    string
     */
    private $_filename;

    /**
     * Namespace for MXML elements.
     *
     * @access private
     * @var    string
     */
    private $_ns = 'mx';
    
    /**
     * Flag to indicate whether element attributes should validate.
     *
     * @access private
     * @var    boolean
     */
    private $_autoValidate = false;
    
    /**
     * Wheter to validate attributes case sensitive or not.
     *
     * @access private
     * @var    boolean
     */
    private $_validateCaseInsensitive = true;
    
    /**
     * MXML version to validate against.
     *
     * @access private
     * @var    string
     */
    private $_validateVersion;
    // }}}
    
    /**
     * Array of Element aliases.
     *
     * @access private
     * @var    array
     */
    private $_element_aliases = array(
        // Compiler
        'array'                     => 'Compiler/XML_MXML_Compiler_Array',
        'binding'                   => 'Compiler/XML_MXML_Compiler_Binding',
        'columns'                   => 'Compiler/XML_MXML_Compiler_Columns',
        'dataprovider'              => 'Compiler/XML_MXML_Compiler_DataProvider',
        'metadata'                  => 'Compiler/XML_MXML_Compiler_MetaData',
        'model'                     => 'Compiler/XML_MXML_Compiler_Model',
        'object'                    => 'Compiler/XML_MXML_Compiler_Object',
        'script'                    => 'Compiler/XML_MXML_Compiler_Script',
        'style'                     => 'Compiler/XML_MXML_Compiler_Style',
        'xml'                       => 'Compiler/XML_MXML_Compiler_XML',

        // Containers
        'accordion'                 => 'Containers/XML_MXML_Containers_Accordion',
        'box'                       => 'Containers/XML_MXML_Containers_Box',
        'canvas'                    => 'Containers/XML_MXML_Containers_Canvas',
        /* ABSTRACT
        'container'                 => 'Containers/XML_MXML_Containers_Container',
        */
        'controlbar'                => 'Containers/XML_MXML_Containers_ControlBar',
        'dividedbox'                => 'Containers/XML_MXML_Containers_DividedBox',
        'form'                      => 'Containers/XML_MXML_Containers_Form',
        'formheading'               => 'Containers/XML_MXML_Containers_FormHeading',
        'formitem'                  => 'Containers/XML_MXML_Containers_FormItem',
        'grid'                      => 'Containers/XML_MXML_Containers_Grid',
        'griditem'                  => 'Containers/XML_MXML_Containers_GridItem',
        'gridrow'                   => 'Containers/XML_MXML_Containers_GridRow',
        'hbox'                      => 'Containers/XML_MXML_Containers_HBox',
        'hdividedbox'               => 'Containers/XML_MXML_Containers_HDividedBox',
        'linkbar'                   => 'Containers/XML_MXML_Containers_LinkBar',
        /* ABSTRACT
        'navbar'                    => 'Containers/XML_MXML_Containers_NavBar',
        */
        'panel'                     => 'Containers/XML_MXML_Containers_Panel',
        'tabbar'                    => 'Containers/XML_MXML_Containers_TabBar',
        'tabnavigator'              => 'Containers/XML_MXML_Containers_TabNavigator',
        'tile'                      => 'Containers/XML_MXML_Containers_Tile',
        'tilewindow'                => 'Containers/XML_MXML_Containers_TileWindow',
        'vbox'                      => 'Containers/XML_MXML_Containers_VBox',
        'vdividedbox'               => 'Containers/XML_MXML_Containers_VDividedBox',
        'viewstack'                 => 'Containers/XML_MXML_Containers_ViewStack',

        // Controls
        'button'                    => 'Controls/XML_MXML_Controls_Button',
        'checkbox'                  => 'Controls/XML_MXML_Controls_CheckBox',
        /* ABSTRACT
        'combobase'                 => 'Controls/XML_MXML_Controls_ComboBase',
        */
        'combobox'                  => 'Controls/XML_MXML_Controls_ComboBox',
        'datagrid'                  => 'Controls/XML_MXML_Controls_DataGrid',
        'datechooser'               => 'Controls/XML_MXML_Controls_DateChooser',
        'datefield'                 => 'Controls/XML_MXML_Controls_DateField',
        'hrule'                     => 'Controls/XML_MXML_Controls_HRule',
        'hscrollbar'                => 'Controls/XML_MXML_Controls_HScrollBar',
        'hslider'                   => 'Controls/XML_MXML_Controls_HSlider',
        'image'                     => 'Controls/XML_MXML_Controls_Image',
        'label'                     => 'Controls/XML_MXML_Controls_Label',
        'link'                      => 'Controls/XML_MXML_Controls_Link',
        'list'                      => 'Controls/XML_MXML_Controls_List',
        'loader'                    => 'Controls/XML_MXML_Controls_Loader',
        'mediacontroller'           => 'Controls/XML_MXML_Controls_MediaController',
        'mediadisplay'              => 'Controls/XML_MXML_Controls_MediaDisplay',
        'mediaplayback'             => 'Controls/XML_MXML_Controls_MediaPlayback',
        'menubar'                   => 'Controls/XML_MXML_Controls_MenuBar',
        'numericstepper'            => 'Controls/XML_MXML_Controls_NumericStepper',
        'progressbar'               => 'Controls/XML_MXML_Controls_ProgressBar',
        'radiobutton'               => 'Controls/XML_MXML_Controls_RadioButton',
        'radiobuttongroup'          => 'Controls/XML_MXML_Controls_RadioButtonGroup',
        'simplebutton'              => 'Controls/XML_MXML_Controls_SimpleButton',
        'spacer'                    => 'Controls/XML_MXML_Controls_Spacer',
        'text'                      => 'Controls/XML_MXML_Controls_Text',
        'textarea'                  => 'Controls/XML_MXML_Controls_TextArea',
        'textinput'                 => 'Controls/XML_MXML_Controls_TextInput',
        'tree'                      => 'Controls/XML_MXML_Controls_Tree',
        'vrule'                     => 'Controls/XML_MXML_Controls_VRule',
        'vscrollbar'                => 'Controls/XML_MXML_Controls_VScrollBar',
        'vslider'                   => 'Controls/XML_MXML_Controls_VSlider',
        'datagridcolumn'            => 'Controls/GridClasses/XML_MXML_Controls_GridClasses_DataGridColumn',
        /* ABSTRACT
        'scrollselectlist'          => 'Controls/ListClasses/XML_MXML_Controls_ListClasses_ScrollSelectList',
        */
        'scrollbar'                 => 'Controls/ScrollClasses/XML_MXML_Controls_ScrollClasses_ScrollBar',
        /* ABSTRACT
        'slider'                    => 'Controls/SliderClasses/XML_MXML_Controls_SliderClasses_Slider',
        */

        // Core
        'repeater'                  => 'Core/XML_MXML_Core_Repeater',
        /* ABSTRACT
        'scrollview'                => 'Core/XML_MXML_Core_ScrollView',
        'uicomponent'               => 'Core/XML_MXML_Core_UIComponent',
        'uiobject'                  => 'Core/XML_MXML_Core_UIObject',
        'view'                      => 'Core/XML_MXML_Core_View',
        */
        'application'               => 'Core/XML_MXML_Core_Application',
        
        // Effects
        /* ABSTRACT
        'compositeeffect'           => 'Effects/XML_MXML_Effects_CompositeEffect',
        */
        'effect'                    => 'Effects/XML_MXML_Effects_Effect',
        'fade'                      => 'Effects/XML_MXML_Effects_Fade',
        /* ABSTRACT
        'maskeffect'                => 'Effects/XML_MXML_Effects_MaskEffect',
        */
        'move'                      => 'Effects/XML_MXML_Effects_Move',
        'parallel'                  => 'Effects/XML_MXML_Effects_Parallel',
        'pause'                     => 'Effects/XML_MXML_Effects_Pause',
        'resize'                    => 'Effects/XML_MXML_Effects_Resize',
        'sequence'                  => 'Effects/XML_MXML_Effects_Sequence',
        /* ABSTRACT
        'tweeneffect'               => 'Effects/XML_MXML_Effects_TweenEffect',
        */
        'wipedown'                  => 'Effects/XML_MXML_Effects_WipeDown',
        'wipeleft'                  => 'Effects/XML_MXML_Effects_WipeLeft',
        'wiperight'                 => 'Effects/XML_MXML_Effects_WipeRight',
        'wipeup'                    => 'Effects/XML_MXML_Effects_WipeUp',
        'zoom'                      => 'Effects/XML_MXML_Effects_Zoom',

        // Formatters
        'currencyformatter'         => 'Formatters/XML_MXML_Formatters_CurrencyFormatter',
        'dateformatter'             => 'Formatters/XML_MXML_Formatters_DateFormatter',
        /* ABSTRACT
        'formatter'                 => 'Formatters/XML_MXML_Formatters_Formatter',
        */
        'numberformatter'           => 'Formatters/XML_MXML_Formatters_NumberFormatter',
        'phoneformatter'            => 'Formatters/XML_MXML_Formatters_PhoneFormatter',
        'zipcodeformatter'          => 'Formatters/XML_MXML_Formatters_ZipCodeFormatter',

        // ServiceTags
        'argument'                  => 'ServiceTags/XML_MXML_ServiceTags_Argument',
        'httpservice'               => 'ServiceTags/XML_MXML_ServiceTags_HTTPService',
        'method'                    => 'ServiceTags/XML_MXML_ServiceTags_Method',
        'operation'                 => 'ServiceTags/XML_MXML_ServiceTags_Operation',
        'remoteobject'              => 'ServiceTags/XML_MXML_ServiceTags_RemoteObject',
        'request'                   => 'ServiceTags/XML_MXML_ServiceTags_Request',
        'webservice'                => 'ServiceTags/XML_MXML_ServiceTags_WebService',

        // Styles
        'cssstyledeclaration'       => 'Styles/XML_MXML_Styles_CSSStyleDeclaration',

        // Validators
        'creditcardvalidator'       => 'Validators/XML_MXML_Validators_CreditCardValidator',
        'datevalidator'             => 'Validators/XML_MXML_Validators_DateValidator',
        'emailvalidator'            => 'Validators/XML_MXML_Validators_EmailValidator',
        'numbervalidator'           => 'Validators/XML_MXML_Validators_NumberValidator',
        'phonenumbervalidator'      => 'Validators/XML_MXML_Validators_PhoneNumberValidator',
        'socialsecurityvalidator'   => 'Validators/XML_MXML_Validators_SocialSecurityValidator',
        'stringvalidator'           => 'Validators/XML_MXML_Validators_StringValidator',
        'validator'                 => 'Validators/XML_MXML_Validators_Validator',
        'zipcodevalidator'          => 'Validators/XML_MXML_Validators_ZipCodeValidator'
    );
    
    // {{{ constants
    /**
     * Error constant for unknown element
     *
     * @var    int
     */
    const ERROR_ELEMENT_NOT_FOUND = 100;

    /**
     * Error constant for no filename given
     *
     * @var    int
     */
    const ERROR_NO_FILENAME = 101;
 
    /**
     * Error constant for file not writeable
     *
     * @var    int
     */
    const ERROR_NOT_WRITEABLE = 102;
    // }}}

    
    // {{{ Constructor
    /**
     * Constructor
     *
     * @param  string  $filename
     * @access public
     */
    public function __construct($filename = null)
    {
        $this->_filename = $filename;
    }
    // }}}


    // {{{ enableValidation
    /**
     * Enable validation.
     *
     * @param  boolean  $enable
     * @param  boolean  $caseInsensitive
     * @access public
     */
    public function enableValidation($enable = true, $caseInsensitive = true)
    {
        $this->_autoValidate = $enable;
        $this->_validateCaseInsensitive = $caseInsensitive;
    }
    // }}}
    
    // {{{ forceVersion
    /**
     * Force MXML version.
     *
     * @param  string  $version
     * @access public
     */
    public function forceVersion($version)
    {
        $this->_validateVersion = $version;
    }
    
    // {{{ addRoot
    /**
     * Add the root element.
     *
     * @param  object  $el  root element
     * @access public
     */
    public function addRoot( $el )
    {
        $el->isRoot = true;
        $el->setNamespace($this->_ns);
        
        $this->root = $el;
    }
    // }}}
    
    // {{{ validateDocument
    /**
     * Validate document.
     *
     * @return boolean
     * @access public
     * @throws Exception
     */
    public function validateDocument()
    {
        try {
            $result = $this->root->validate($this->_validateCaseInsensitive, $this->_validateVersion);
        } catch (Exception $e) {
            // rethrow
            throw $e;
        }
        
        return $result;
    }
        
    // {{{ send
    /**
     * Send the document to the output stream.
     *
     * @access public
     */
    public function send()
    {
        header('Content-type: text/xml');
        echo $this->serialize();
    }
    // }}}
    
    // {{{ save
    /**
     * Write the document to a file.
     *
     * You may specify a filename to override the filename passed in
     * the constructor.
     *
     * @access public
     * @param  string  $filename
     * @throws Exception
     */
    public function save($filename = null)
    {
        if ($filename == null) {
            $filename = $this->_filename;
        }

        if (empty($filename)) {
            throw new Exception('No filename specified to write document to.', XML_MXML_Document::ERROR_NO_FILENAME);
        }

        $fp = @fopen($filename, 'wb');
        
        if (!$fp) {
            throw new Exception('Could not write destination file.', XML_MXML_Document::ERROR_NOT_WRITEABLE );
        }
        
        flock($fp, LOCK_EX);
        fputs($fp, $this->serialize());
        flock($fp, LOCK_UN);
        fclose( $fp );

        return true;
    }
    // }}}
    
    // {{{ serialize
    /**
     * Serialize the document.
     *
     * @access public
     * @return string
     */
    public function serialize()
    {
        $doc  = XML_Util::getXMLDeclaration('1.0', 'utf-8') . "\n\n";
        $doc .= $this->root->serialize();
        
        return $doc;
    }
    // }}}
    
    // {{{ createElement
    /**
     * Create any MXML element.
     *
     * @param  string  $name
     * @param  array   $attributes
     * @param  string  $cdata
     * @return object  XML_MXML_Element
     * @access public
     * @throws Exception
     */
    public function createElement($name, $attributes = array(), $cdata = null, $replaceEntities = true)
    {
        $name = strtolower($name);
        
        if (isset($this->_element_aliases[$name])) {
            $alias = $this->_element_aliases[$name];
            
            $slashpos  = strrpos($alias, '/');
            $path      = 'XML/MXML/' . substr($alias, 0, $slashpos + 1);
            $classname = substr($alias, $slashpos + 1);
            $classfile = substr($classname, strrpos($classname, '_') + 1);
            $file      = $path . $classfile . '.php';
            
            if (@include_once $file) {
                $el = new $classname($attributes, $cdata);
            } else {
                throw new Exception('Element not found.', XML_MXML_Document::ERROR_ELEMENT_NOT_FOUND);
            }
        } else {
            $el = new XML_MXML_Element($attributes, $cdata);
            $el->elementName  = $name;
            $el->knownElement = false;                
        }
        
        $el->setDocument($this);
        $el->replaceEntities = $replaceEntities;
        
        if ($this->_autoValidate) {
            try {
                $result = $el->validate($this->_validateCaseInsensitive, $this->_validateVersion);
            } catch (Exception $e) {
                // rethrow
                throw $e;
            }
        }
        
        return $el;
    }
    // }}}
    
    // {{{ getElementById
    /**
     * Get an element by its id.
     *
     * @param  string  $id
     * @return object  XML_MXML_Element
     * @access public
     */
    public function getElementById($id)
    {
        return $this->root->getElementById($id);
    }
    // }}}
    
    // {{{ getElementsByTagname
    /**
     * Get a nodelist of elements by their tagname.
     *
     * @param  string  $tagname
     * @return array   array containing XML_MXML_Element objects
     * @access public
     */
    public function getElementsByTagname($tagname)
    {
        return $this->root->getElementsByTagname( $tagname );
    }
    // }}}
    
    // {{{ getDebug
    /**
     * Get debug info about the document as
     * string.
     *
     * Use this instead of a print_r on the tree.
     *
     * @return string
     * @param  boolean $availableAttributes
     * @access public
     */
    public function dump($availableAttributes = true)
    {
        $dump  = "XML_MXML_Document\n";
        $dump .= " +-namespace: {$this->_ns}\n";
        $dump .= " +-childNodes\n";
        $dump .= $this->root->dump(' ', true, $availableAttributes);
        
        return $dump;
    }
    // }}}
}

?>
