<?php
define( 'TYPE', 'admin' );
define( 'REQUIRE_GROUP', 2 );
require( '../config.inc.php' );
require( '../includes/core.php' );

if ( $_user = _checkLogin() ){
	$mod = 'welcome';
	if ( !empty( $_GET[ 'mod' ] ) ){
		$mod = $_GET[ 'mod' ];
	}

	$page = $mod;
	if ( !empty ($_GET[ 'page' ])){
		$page = $_GET[ 'page' ];
	}
	$func = 'main';
	if ( !empty( $_GET[ 'func' ] ) ){
		$func = $_GET[ 'func' ];
	}
}else{
	$mod = 'user';
	$page = 'login';
	$func = 'main';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$s = print_r($_POST, true);
	$logmsg = sprintf("%s %s %s\n%s------------------------------------------\n", $_SERVER['REMOTE_ADDR'], date('H:m:s'), $_SESSION['_user_id'], $s);
	$fname  = sprintf("./logs/post_log_%s.txt", date('Ymd'));
	$fp = @fopen($fname, 'a');
	
	if($fp){
		flock($fp, LOCK_EX);
		fwrite($fp, $logmsg);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, 0644);
	}
}

$sModPath = _MODULE_ABSPATH_ . DIRECTORY_SEPARATOR . $mod;
$sModFilePath = $sModPath . DIRECTORY_SEPARATOR . TYPE . '.' . $page . '.php';

//Kiem tra va require module
if ( file_exists( $sModFilePath ) ){
	require ( $sModFilePath );
	if ( defined( 'MOD_REQUIRE_GROUP' ) ) {
		$_usergroup = intval( $_user[ 'usergroup_id' ] );
		if (  $_usergroup == 0 || $_usergroup > MOD_REQUIRE_GROUP ) die();
	}
	//Kiem tra va goi function
	$sFuncName = $page . '_' . TYPE . '_' . $func;
	$data = '';
	if ( function_exists( $sFuncName ) ){
		$data = call_user_func( $sFuncName );
	}
	$layout = 'layout.tpl';

	if ( function_exists( $page . '_' . TYPE . '_' . 'layout' ) ){
		if ( $name = call_user_func( $page . '_' . TYPE . '_' . 'layout' ) ){
			$layout = $name;
		}
	}	
	$presenter = new Presenter( $mod, $page, TYPE, $data, $layout, '',$_user, $func );
	$presenter->display();
}
?>
























































