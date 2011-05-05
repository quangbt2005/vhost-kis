<?php
require_once 'SOAP/Client.php';
require '../includes.php';
$options = array('cache_wsdl' => WSDL_CACHE_NONE);
$soapclient = new SoapClient('http://202.87.214.213/ws/order.php?WSDL',$options);

  $params = array(
                   // 'DABAccount'     => '0101000890',
                   // 'AccountNo'      => '057C006733',
                   'DABAccount'     => '0101369354',
                   'AccountNo'      => '057C000195',
                   'AuthenUser'     => 'ba.nd',
                   'AuthenPass'     => md5('hsc080hsc'));

  $re1 = $soapclient->__soapCall( 'getAvailBalanceFromDAB', $params );
  p($re1);
  $re2 = $soapclient->__soapCall( 'getRealBalanceFromDAB', $params );
  p($re2);
?>