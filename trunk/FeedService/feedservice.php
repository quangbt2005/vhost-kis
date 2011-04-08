<?php
set_time_limit(0);
define( 'TYPE', 'feed' );
require( 'config.inc.php' );
require( 'includes/core.php' );
require( 'includes/eps.php' );

global $_GET;
if ($argv) { 
    foreach ($argv as $k=>$v) { 
        if ($k==0) continue; 
        $it = explode("=",$v); 
        if (isset($it[1])) $_GET[$it[0]] = $it[1]; 
    } 
} 

if ( !empty( $_GET[ 'mod' ] ) ){
	$mod = $_GET[ 'mod' ];
}else die();

$page = $mod;
if ( !empty ($_GET[ 'page' ])){
	$page = $_GET[ 'page' ];
}

$func = 'main';
if ( !empty( $_GET[ 'func' ] ) ){
	$func = $_GET[ 'func' ];
}

$sModPath = _MODULE_ABSPATH_ . DIRECTORY_SEPARATOR . $mod;
$sModFilePath = $sModPath . DIRECTORY_SEPARATOR . TYPE . '.' . $page . '.php';

//Kiem tra va require module
if (file_exists($sModFilePath)){
    
	$data = '';
	if ( file_exists( $sModFilePath ) ){
		require ( $sModFilePath );	
		//Kiem tra va goi function
		$sFuncName = $page . '_' . TYPE . '_' . $func;
		
		if ( function_exists( $sFuncName ) ) $data = call_user_func( $sFuncName );
	}
	echo $data;
}
?>
