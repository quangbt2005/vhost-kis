<?
/**
 * SMTP client.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 2.02 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is available at
 * through the world-wide-web at http://www.php.net/license/2_02.txt.  If you
 * did not receive a copy of the PHP license and are unable to obtain it
 * through the world-wide-web, please send a note to license@php.net so we can
 * mail you a copy immediately.
 *
 * @category   Web Services
 * @package    SOAP
 * @author     Shane Caraveo <Shane@Caraveo.com>   Port to PEAR and more
 * @author     Jan Schneider <jan@horde.org>       Maintenance
 * @copyright  2003-2007 The PHP Group
 * @license    http://www.php.net/license/2_02.txt  PHP License 2.02
 * @link       http://pear.php.net/package/SOAP
 */

/* Include SOAP_Client class. */
require_once 'SOAP/Client.php';
$soapclient = new SOAP_Client('mailto:user@domain.com');

$options = array('namespace' => 'http://soapinterop.org/',
                 'from' => 'user@domain.com',
                 'host' => 'localhost');
$return = $soapclient->call('echoString',
                            array('inputString' => 'this is a test'),
                            $options);
$return = $soapclient->call('echoStringArray',
                            array('inputStringArray' => array('good', 'bad', 'ugly')),
                            $options);

/* Don't expect much of a result! */
print_r($return);
echo $soapclient->wire;

