<?php
/**
 * This file contains the class XML_Query2XML_Command_CDATA.
 *
 * PHP version 5
 *
 * @category  XML
 * @package   XML_Query2XML
 * @author    Lukas Feiler <lukas.feiler@lukasfeiler.com>
 * @copyright 2006 Lukas Feiler
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL Version 2.1
 * @version   CVS: $Id: CDATA.php,v 1.3 2007/11/19 01:43:44 lukasfeiler Exp $
 * @link      http://pear.php.net/package/XML_Query2XML
 * @access    private
 */

/**
 * XML_Query2XML_Command_CDATA extends the class XML_Query2XML_Command_Chain.
 */
require_once 'XML/Query2XML/Command/Chain.php';

/**
 * Command class that creates a CDATA section around the string returned by
 * a pre-processor.
 *
 * XML_Query2XML_Command_CDATA only works with a pre-processor
 * that returns a string.
 *
 * usage:
 * <code>
 * $commandObject = new XML_Query2XML_Command_CDATA(
 *   new XML_Query2XML_Command_ColumnValue('name')  //pre-processor
 * );
 * </code>
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
class XML_Query2XML_Command_CDATA extends XML_Query2XML_Command_Chain
{
    /**
     * Called by XML_Query2XML for every record in the result set.
     * This method will return an instance of DOMCDATASection or null
     * if an empty string was returned by the pre-processor.
     *
     * @param array $record An associative array.
     *
     * @return DOMCDATASection
     * @throws XML_Query2XML_ConfigException If the pre-processor returns
     *                      something that cannot be converted to a string (i.e. an
     *                      array or an object) or if no pre-processor was set.
     */
    public function execute(array $record)
    {
        $doc  = new DOMDocument();
        $data = $this->runPreProcessor($record);
        if (is_array($data) || is_object($data)) {
            throw new XML_Query2XML_ConfigException(
                $this->configPath . 'XML_Query2XML_Command_CDATA: string expected '
                . 'from pre-processor, but ' . gettype($data) . ' returned.'
            );
        }
        if (strlen($data) > 0) {
            return $doc->createCDATASection($data);
        } else {
            return null;
        }
    }
}
?>