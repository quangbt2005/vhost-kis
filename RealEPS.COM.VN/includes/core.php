<?php
error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
session_start();
header("Cache-control: private");
define ( 'PARAM_STR', 	'STR' );
define ( 'PARAM_INT', 	'INT' );
define ( 'PARAM_FLOAT', 'FLOAT' );
define ( 'PARAM_OBJ', 	'OBJ' );
define ( 'PARAM_NONE', 	'NONE' );

//Duong dan toi thu vien
define ( '_INCLUDE_ABSPATH_', dirname( __FILE__ ) );
define ( '_LIB_ABSPATH_', _INCLUDE_ABSPATH_ . DIRECTORY_SEPARATOR . 'libs' );
//Duong dan toi goc
$path = str_replace( '\\', '/', dirname( $_SERVER[ 'PHP_SELF' ] ) ) ;
if ( TYPE == 'admin' ) $path = str_replace( '/cms', '', $path );
define ('_PATH_', $path  );
//Duong dan toi admin
define ( '_ADMIN_ABSPATH_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'cms' );
define ('_ADMIN_PATH_', _PATH_ . '/cms'  );
//Duong dan toi module
define ( '_MODULE_ABSPATH_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'modules' );
define ('_MODULE_PATH_', _PATH_ . '/modules'  );
//Duong dan toi thu muc hinh anh chung
define ( '_IMAGE_PATH_', _PATH_ . '/images' );
define ( '_PLUGIN_ABSPATH', _ABSPATH_ . DIRECTORY_SEPARATOR . 'plugins' );
define ( '_LANG_ABSPATH_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'languages' );
define ( '_UPLOAD_IMG_ABSPATH_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'image' );
define ( '_UPLOAD_FILE_ABSPATH_', _ABSPATH_ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'file' );

$_configs[ 'item_per_page' ] = intval( _db_option_value( 'item_per_page' ) );

function __autoload( $class_name ) {
	$sPath = _INCLUDE_ABSPATH_ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.php';
    require( $sPath );
}

function _fetch_post( &$names ){
	if ( empty( $_POST ) ) return false;
	foreach ( $names as $key => $value ){
		if ( !empty($_FILES[$key] ) && !empty( $_FILES[ $key ]['name']) )$names[ $key ] = $_FILES[$key]['name'];
		else{
			if ( isset( $_POST[ $key ] ) ){
				if ( is_array( $_POST[ $key ] ) ){
					$names[ $key ] = array();
					foreach ( $_POST[ $key ] as $value ){
						$names[ $key ][] = $value;
					}
				}else $names[ $key ] =  trim( $_POST[ $key ] );				
			}//if
		}//if
	}//foreach
	return true;
}

function _get_referer() {
	$ref = '';
	if ( ! empty( $_REQUEST[ '_http_referer' ] ) )
		$ref = $_REQUEST[ '_http_referer' ];
	else if ( ! empty( $_SERVER['HTTP_REFERER'] ) )
		$ref = $_SERVER['HTTP_REFERER'];

	if ( $ref !== $_SERVER['REQUEST_URI'] )
		return $ref;
	return false;
}

function _redirect( $location ) {
	/*if ($tk_start=strpos($location, 'token')){
		$tk_end=strpos($location, '&', $tk_start);
		if ($tk_end == false) $location=substr($location, 0, $tk_start - ($location[$tk_start-1]=='?'?0:1));
		else{
			$location=substr($location, 0, $tk_start - ($location[$tk_start-1]=='?'?0:1)) . substr($location, $tk_end);
		}
	}*/
	//die($location);
	//$location .= '&token=' . strtotime('now');
	header("Location: $location");
	exit(0);
}

function _format_db_date( $format, $sDate ){	
	$splits = explode( '-', $sDate );
	$date = @mktime( 0, 0, 0, $splits[ 1 ], $splits[ 2 ], $splits[ 0 ] );
	return date( $format, $date );
}
function _format_db_date_time( $format, $sDate ){	
	$splits = explode( ' ', $sDate );
	$spDate = explode('-', $splits[0]);
	$spTime = explode(':', $splits[1]);
	$date = @mktime($spTime[0], $spTime[1], $spTime[2], $spDate[ 1 ], $spDate[ 2 ], $spDate[ 0 ] );
	return date( $format, $date );
}
function _db( $db='' ){
	global $_configs;
	$prefix = '';	
	$dbinstance ='default';	
	if (!empty($db)) {
		$prefix = $db . '_';
		$dbinstance = $db; 
	}	
	return MySQL::singleton($dbinstance,$_configs[$prefix.'db_host'], $_configs[$prefix.'db_user'], $_configs[$prefix.'db_pass'], $_configs[$prefix.'db_name'], $_configs[$prefix.'db_prefix']);
}

//Vao : dd/mm/yyyy
function _db_date( $sDate ='', $sep='/'){
	$splits = explode( $sep, $sDate );
	$date = @mktime( 0, 0, 0, $splits[ 1 ], $splits[ 0 ], $splits[ 2 ] );
	if ($date) return date( 'Y-m-d', $date );
	return date('Y-m-d');
}
//vao : dd/mm/yyyy hh:mm:ss
function _db_date_time($sDate){
	$splits = explode(' ', $sDate);
	return _db_date($splits[0]) . ' ' . $splits[1];
}
function _result_per_page(){
	global $_configs;
	if ( $_configs[ 'item_per_page' ] <= 0 ){
		return 10;
	}
	return $_configs[ 'item_per_page' ];
}

function _display_page(){
	return 9;
}
$_values=array();
function _db_option_value( $name ){
    global $_values;
    if (empty($_values[$name])){
    	$sql = 'SELECT option_value FROM _prefix_options WHERE option_name = :OPT_NAME';
    	$db = _db();
    	$db->prepare( $sql );	
    	$db->bindValue( ':OPT_NAME', $name, PARAM_STR );	
    	$db->execute();
    	$values = '';	
    	if ( $value = $db->fetch() ) $value = $value[ 'option_value' ];
    	$_values[$name] = $value;	
    }else $value = $_values[$name];
	return $value;
}
$_date_format = _db_option_value( 'date_format' );
function _date_format(){
	global $_date_format;
	return $_date_format;
} 

function _checkLogin(){
	if ( !empty( $_SESSION['_user_id' ] ) ){
		$userId = $_SESSION[ '_user_id' ];
		$db = _db();
		$sql = 'SELECT * FROM _prefix_users WHERE user_id = :ID AND usergroup_id <= :REQUIRE_GROUP AND is_enabled = 1';
		$db->prepare( $sql );
		$db->bindValue( ':ID', $userId, PARAM_INT );
		$db->bindValue( ':REQUIRE_GROUP', REQUIRE_GROUP, PARAM_INT );
		$db->execute();
		if ( $user = $db->fetch() ){
			return $user;
		}
	}
	$_SESSION[ '_message' ] = null;
	$_SESSION[ '_user_id' ] = null;
	//session_destroy();
	return false;
}

$_allow_lang_code = array( 'vn', 'en' );

function _listenLangChange(){				
	if ( !empty( $_GET[ 'lang' ] ) ){ //Co bao doi lang
		global $_allow_lang_code;		
		$langCode =  $_GET[ 'lang' ];				
		//Lang phai nam trong code cho phep, va khac code mac dinh
		if ( in_array( $langCode, $_allow_lang_code ) && $langCode != $_allow_lang_code[0] ){			
			setcookie( '_lang', $langCode, time() + 60*60*24, '/' );				
		}else{
			setcookie( '_lang', '', time() - 6400, '/' );
		}
	}//if			
}

function _getLang(){
 	if ( isset( $_GET['lang'] ) ){
		global $_allow_lang_code;
		$langCode = $_GET[ 'lang' ];
		//Kiem tra lai lang code
		if ( in_array( $langCode, $_allow_lang_code ) && $langCode != $_allow_lang_code[0] ){
			return '_' . $langCode;
		} 					
	}else if ( isset( $_COOKIE[ '_lang' ] ) ){//Co luu trong cookie		
		global $_allow_lang_code;
		$langCode = $_COOKIE[ '_lang' ];
		//Kiem tra lai lang code
		if ( in_array( $langCode, $_allow_lang_code ) && $langCode != $_allow_lang_code[0] ){
			return '_' . $langCode;
		} 					
	}
	return '';
}

function _mod_lang( $name ){
	global $_mod_lang;	
	return $_mod_lang[$name];
}

function _lang($name){
	global $_lang;	
	return $_lang[$name];
}
function _num_format($number, $decimal=2){
	/*if (is_numeric($number)) { // a number
	    if (!$number) { // zero
	    	$money = ($decimal == 2 ? '0.00' : '0'); // output zero
	    } else { // value
	    	if (floor($number) == $number) { // whole number
	      		$money = number_format($number, ($decimal == 2 ? 2 : 0)); // format
	      	} else { // cents
	        	$money = number_format(round($number, 2), ($decimal == 0 ? 0 : 2)); // format
	      	} // integer or decimal
	    } // value
	    return $money;
  	} // numeric*/
	if (floatval($number) == 0) return '---';
	return number_format($number, $decimal, ',', '.');
}
function _format_date($date){
	$format='%d/%m/%y %H:%M';
	$timestamp=strtotime($date);
 	if (date('%y', $timestamp) == date('%y')){
    	$format='%d/%m';
    	if (date('%d',$timestamp) == date('%d')
    	&& date('%m',$timestamp) == date('%m')) $format='%H:%M';
    }
    return strftime($format, $timestamp);
}
?>