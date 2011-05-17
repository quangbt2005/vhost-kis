<?php
	private $template;
	
	public function __construct( $module, $page , $type, $data, $layout, $mod_layout='',$user = false, $func='main' ){
		if ( $type == 'admin' ){			
			$abspath = _ADMIN_ABSPATH_;
		}else{			
			$abspath = _ABSPATH_;
		}
		//Thong tin ve module				
	
		//Thong tin ve data
		$this->data = $data;
		$this->user = $user;
		//Khoi tao smarty
		$this->template = new Smarty();
		//$this->template->debugging = true;
		$this->template->template_dir 	= $abspath . $sep . 'templates';
		$this->template->compile_dir	= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'templates_c';
		$this->template->cache_dir 		= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'cache';
		$this->template->config_dir 	= $abspath . $sep . 'cache' . $sep . 'templates' . $sep . 'config';
		$this->template->assign( '_MODULE_ABSPATH', _MODULE_ABSPATH_ . $sep . $module );
		$this->template->assign( 'DIR_SEP', $sep );
		$this->template->assign( '_DATE_FORMAT', _date_format() );
		$this->template->plugins_dir[] = _PLUGIN_ABSPATH;
	}
	public function display() {		
		$this->template->display( $this->layout );
	}
}