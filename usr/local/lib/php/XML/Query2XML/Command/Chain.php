<?php
/**
 * This file contains the class XML_Query2XML_Command_Chain.
 *
 * PHP version 5
 *
 * @category  XML
 * @package   XML_Query2XML
 * @author    Lukas Feiler <lukas.feiler@lukasfeiler.com>
 * @copyright 2006 Lukas Feiler
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL Version 2.1
 * @version   CVS: $Id: Chain.php,v 1.3 2007/11/19 01:43:44 lukasfeiler Exp $
 * @link      http://pear.php.net/package/XML_Query2XML
 * @access    private
 */

/**
* XML_Query2XML_Command_Chain implements the interface XML_Query2XML_Callback.
*/
require_once 'XML/Query2XML/Callback.php';

/**
 * Abstract class extended by all command classes that are part of the
 * XML_Query2XML package.
 *
 * @category  XML
 * @package   XML_Query2XML
 * @author    Lukas Feiler <lukas.feiler@lukasfeiler.com>
 * @copyright 2006 Lukas Feiler
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL Version 2.1
 * @version   Release: 1.7.0
 * @link      http://pear.php.net/package/XML_Query2XML
 * @access    private
 * @since     Release 1.5.0RC1
 */
abstract class XML_Query2XML_Command_Chain implements XML_Query2XML_Callback
{
    /**
     * Another instance of XML_Query2XML_Command_Chain to process before this one.
     * @var XML_Query2XML_Command_Chain
     */
    protected $preProcessor = null;
    
    /**
     * The configuration path; it is used for exception messages
     * @var string
     */
    protected $configPath = '';
    
    /**
     * Constructor
     *
     * @param XML_Query2XML_Command_Chain $preProcessor The pre-processor to be used.
     *                                                  This argument is optional.
     * @param string                      $configPath   The configuration path within
     *                                                  the $options array. This
     *                                                  argument is optional.
     */
    public function __construct(XML_Query2XML_Command_Chain $preProcessor = null,
                                $configPath = '')
    {
        $this->preProcessor = $preProcessor;
        $this->configPath   = $configPath;
        if ($this->configPath) {
            $this->configPath .= ': ';
        }
    }
    
    /**
     * Allows the pre-processor to be set (or changed) after an instance was created.
     *
     * @param XML_Query2XML_Command_Chain $preProcessor The pre-processor to be used.
     *
     * @return void
     */
    public function setPreProcessor(XML_Query2XML_Command_Chain $preProcessor)
    {
        $this->preProcessor = $preProcessor;
    }
    
    /**
     * Runs the pre-processor if one was defined and returns it's return value.
     *
     * @param array $record The record to process - this is an associative array.
     *
     * @return mixed Whatever was returned by the pre-processor
     * @throws XML_Query2XML_ConfigException If no pre-processor was defined.
     */
    protected function runPreProcessor(array $record)
    {
        if (!is_null($this->preProcessor)) {
            return $this->preProcessor->execute($record);
        } else {
            include_once 'XML/Query2XML.php';
            throw new XML_Query2XML_ConfigException(
                $this->configPath . get_class($this) . ' requires a pre-processor.'
            );
        }
    }
    
    /**
     * Returns the first pre-processor in the chain.
     *
     * This will be the innerst one when using the following notation:
     * <code>
     * new XML_Query2XML_Command_Base64(new XML_Query2XML_Command_Static('test'))
     * </code>
     * If there is no pre-processor, $this is returned.
     *
     * @return XML_Query2XML_Command_Chain
     */
    public function getFirstPreProcessor()
    {
        if (!is_null($this->preProcessor)) {
            return $this->preProcessor->getFirstPreProcessor();
        }
        return $this;
    }
    
    /**
     * Returns a textual representation of this instance.
     * This might be useful for debugging.
     *
     * @return string
     */
    public function toString()
    {
        $str = get_class($this) . '(';
        if (!is_null($this->preProcessor)) {
            $str .= $this->preProcessor->toString();
        }
        return $str . ')';
    }
}
?>