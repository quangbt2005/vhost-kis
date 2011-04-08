<?php 
define('_NUSOAP_ABSPATH_', _LIB_ABSPATH_  . DIRECTORY_SEPARATOR . 'nusoap'. DIRECTORY_SEPARATOR );
define('_NUSOAP_CACHE_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'wsdlcache');

function _feed_stockbiz($method, $url, $params, $debug = true){
	global $_services;

	require_once(_NUSOAP_ABSPATH_ .'nusoap.php');
	require_once(_NUSOAP_ABSPATH_ .'class.wsdlcache.php');
	
	$cache = new wsdlcache( _NUSOAP_CACHE_, 0);
	$wsdl = $cache->get($url);

	if (is_null($wsdl)) {
		$wsdl = new wsdl($url);	
		$cache->put($wsdl);
	}else $wsdl->clearDebug();
	
	$client = new nusoap_client($wsdl, true);
	$client->decode_utf8 = false;	
	$client->setUseCurl(false);	
	
	$result = $client->call($method, $params);
	
	if ($client->fault) {
		if ($debug){
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}	
	} else {		
		if ($err = $client->getError()){
			if ($debug) echo '<h2>Error</h2><pre>' . $err . '</pre>';
		}else if (!empty($result)) {	
			return $result;
		}
	}	
	return false;
}

$_maxTradingDate = '';
function maxTradingDate($date='NULL'){
	global $_maxTradingDate;
	if ($_maxTradingDate == ''){
		$db = _db('eps');
		$db->connect();
		if ($date == 'NULL'){
			$db->query('call sp_getMaxTradingDate_Security(NULL)');
			$result = $db->fetch();
			$_maxTradingDate = $result['max_trading_date'];
		}else{
			$db->query('call sp_getMaxTradingDate_Security(\''.$date.'\')');
			$result = $db->fetch();
			$_maxTradingDate = $result['last_max_trading_date'];
		}
		//reset lai de o ngoai khong phai connect
		$db->connect();
	}
	return $_maxTradingDate;
}

$_session=-1;
function currentSession($date){
	global $_session;
	if ($_session == -1){
		$db = _db('eps');
		$db->query('call sp_getSession_MarketStat('.maxTradingDate($date).');');
		$result = $db->fetch();
		$_session = $result['Session'];
		//reset lai de o ngoai khong phai connect
		$db->connect();
	}
	return $_session;
}

function buildInsertSQL($table, $obj){
	if (!empty($obj)){		
		$field='';
		$value='';
		foreach ($obj as $key => $data){
			if (is_null($data)) $val= 'NULL';
			else $val = '\'' . mysql_real_escape_string($data). '\'';
			if ($field == '' ){				
				$field = $key;
				$value = $val;
			}else{
				$field .= ',' . $key;
				$value .= ',' . $val;
			}
		}
		$sql = 'INSERT INTO ' . $table . ' ('.$field.') VALUES('.$value.')';
		return $sql;
	}
	return false;
}

function buildUpdateSQL($table, $obj, $where){
	if (!empty($obj) && $where != ''){		
		$field='';
		foreach ($obj as $key => $data){
			$val = '\'' . mysql_real_escape_string($data). '\'';
			if ($field == '' ) $field = $key . '=' . $val;
			else $field .= ',' . $key . '=' . $val;				
		}
		$sql = 'UPDATE ' . $table . ' SET ' . $field . ' WHERE ' . $where ;
		return $sql;
	}
	return false;
}
?>
