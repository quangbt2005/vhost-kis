<?php
/**This is included from unit tests to skip the test if MDB2 is not available.
*
* LICENSE:
* This source file is subject to version 2.1 of the LGPL
* that is bundled with this package in the file LICENSE.
*
* COPYRIGHT:
* Empowered Media
* http://www.empoweredmedia.com
* 481 Eighth Avenue Suite 1530
* New York, NY 10001
*
* @copyright Empowered Media 2006
* @license http://www.gnu.org/copyleft/lesser.html  LGPL Version 2.1
* @author Lukas Feiler <lukas.feiler@lukasfeiler.com>
* @package XML_Query2XML
* @version $Id: MDB2_skipif.php,v 1.1 2008/04/18 23:50:25 lukasfeiler Exp $
*/

if (!@include_once 'MDB2.php') {
    print 'skip could not find MDB2.php';
    exit;
} else {
    require_once dirname(dirname(__FILE__)) . '/settings.php';
    $db = @MDB2::connect(DSN);
    if (PEAR::isError($db)) {
        print 'skip could not connect using DSN ' . DSN;
        exit;
    }
}
?>