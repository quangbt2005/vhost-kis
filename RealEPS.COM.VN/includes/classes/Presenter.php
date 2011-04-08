<?phprequire ( _LIB_ABSPATH_ . DIRECTORY_SEPARATOR . 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php' );class Presenter {			private $layout;
	private $template;
		public function setLang($langCode, $globalLang, $modLang){		$this->template->assign("_lang_code", $langCode);		if (!empty($globalLang)) $this->template->assign("_lang", $globalLang);		if (!empty($modLang)) $this->template->assign("_mod_lang", $modLang);	}
	public function __construct( $module, $page , $type, $data, $layout, $mod_layout='',$user = false, $func='main' ){
		if ( $type == 'admin' ){			
			$abspath = _ADMIN_ABSPATH_;
		}else{			
			$abspath = _ABSPATH_;
		}		$sep = DIRECTORY_SEPARATOR;						
		//Thong tin ve module				
	
		//Thong tin ve data		$this->layout = $layout;
		$this->data = $data;
		$this->user = $user;
		//Khoi tao smarty
		$this->template = new Smarty();
		//$this->template->debugging = true;
		$this->template->template_dir 	= $abspath . $sep . 'templates';
		$this->template->compile_dir	= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'templates_c';
		$this->template->cache_dir 		= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'cache';
		$this->template->config_dir 	= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'config';				$this->template->assign( '_MODULE_PATH', _MODULE_PATH_ . '/' . $module  );				
		$this->template->assign( '_MODULE_ABSPATH', _MODULE_ABSPATH_ . $sep . $module );				if ($mod_layout == '') $this->template->assign( '_MODULE_TPL', $type . '.' . $page . '.tpl' );		else $this->template->assign( '_MODULE_TPL', $mod_layout );						$modHeadPath = _MODULE_ABSPATH_ . $sep  . $module . $sep . 'tpl' . $sep . TYPE . '.' . $page . '.head.tpl';		$headPath = $abspath . $sep . 'templates' . $sep . 'head.tpl';				if ( file_exists($modHeadPath) )			$this->template->assign( '_HEAD', $modHeadPath );		else if ( file_exists($headPath) )				$this->template->assign( '_HEAD', $headPath );				$modFootPath = _MODULE_ABSPATH_ . $sep  . $module . $sep . 'tpl' . $sep . TYPE . '.' . $page . '.foot.tpl';		$footPath = $abspath . $sep . 'templates' . $sep . 'foot.tpl';					if ( file_exists($modFootPath) )			$this->template->assign( '_FOOT', $modFootPath );		else if ( file_exists($footPath) )				$this->template->assign( '_FOOT', $footPath );		
		$this->template->assign( 'DIR_SEP', $sep );
		$this->template->assign( '_DATE_FORMAT', _date_format() );		if ( count( $this->user ) ){			$this->template->assign( 'user', $this->user );		}		$this->template->assign( 'message', Message::singleton() );		$this->template->assign( 'data', $this->data );		$this->template->assign( '_mod', $module );		$this->template->assign( '_page', $page );		$this->template->assign( '_type', TYPE );		$this->template->assign( '_func', $func );		$this->template->assign( 'get', $_GET );					
		$this->template->plugins_dir[] = _PLUGIN_ABSPATH;
	}
	public function display() {		
		$this->template->display( $this->layout );
	}
}?>