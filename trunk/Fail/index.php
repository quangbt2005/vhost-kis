<?php
define( 'TYPE', 'user' );
require( 'config.inc.php' );
require( 'includes/core.php' );
require( 'includes/eps.php' );

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

$sModPath = _MODULE_ABSPATH_ . DIRECTORY_SEPARATOR . $mod;
$sModFilePath = $sModPath . DIRECTORY_SEPARATOR . TYPE . '.' . $page . '.php';
$sModTplFilePath = $sModPath . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . TYPE . '.' . $page . '.tpl';

//Kiem tra va require module
if (file_exists($sModTplFilePath) || file_exists($sModFilePath)){
	$data = '';
	//Require ngon ngu
	$sModLangPath = $sModPath . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'lang' . _getLang() . '.php';
	$sLangPath = _LANG_ABSPATH_ . DIRECTORY_SEPARATOR . 'lang' . _getLang() . '.php';
	//Lay mang ngon ngu
	$_lang = array();
	$_mod_lang = array();
	if ( file_exists( $sLangPath ) ) require( $sLangPath );			
	if ( file_exists( $sModLangPath ) ) require( $sModLangPath );			
	
	if ( file_exists( $sModFilePath ) ){
		require ( $sModFilePath );	
		//Kiem tra va goi function
		$sFuncName = $page . '_' . TYPE . '_' . $func;			
		if ( function_exists( $sFuncName ) ) $data = call_user_func( $sFuncName );
	}
				
	$_layout = 'layout.tpl';
	if ( function_exists( $mod . '_' . TYPE . '_' . 'layout' ) )
		if ( $name = call_user_func( $mod . '_' . TYPE . '_' . 'layout' ) )
			$_layout = $name;

	$_mod_layout='';
	//news_user_mod_layout	
	if ( function_exists( $page . '_' . TYPE . '_' . 'mod_layout' ) )
		if ( $name = call_user_func( $page . '_' . TYPE . '_' . 'mod_layout' ) )
			$_mod_layout = $name;
				
	$presenter = new Presenter($mod, $page, TYPE, $data, $_layout, $_mod_layout, false, $func);
	
	//Dua va o template
	$presenter->setLang(_getLang(), $_lang, $_mod_lang );				
	$presenter->display();
}
?>
