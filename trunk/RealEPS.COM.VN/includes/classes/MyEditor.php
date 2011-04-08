<?php
require(  _LIB_ABSPATH_ . DIRECTORY_SEPARATOR . 'fckeditor' . DIRECTORY_SEPARATOR . 'fckeditor.php' );
class MyEditor {	private static $instance;	public $name;	public $value;	public $width = 100;	public $height = 100;	public $toolbar = 'UserToolBar';
	public function __construct( $name, $value ) {		$this->name = $name;		$this->value = $value;	}	public static function singleton( $name, $value = '' ){		if ( !isset( self::$instance ) ){			self::$instance = new MyEditor( $name, $value );		}		self::$instance->toolbar = 'UserToolBar';		return self::$instance;	}

	public function __toString() {		$oFCKeditor = new FCKeditor( $this->name ) ;				$oFCKeditor->BasePath	= '/includes/libs/fckeditor/' ;		if (_PATH_ != '/' ) $oFCKeditor->BasePath = _PATH_ . '/includes/libs/fckeditor/' ;		$oFCKeditor->Value		= $this->value;		$oFCKeditor->ToolbarSet = $this->toolbar;		$oFCKeditor->Width = $this->width;
		$oFCKeditor->Height = $this->height;

		return $oFCKeditor->CreateHtml();
	}

}

?>
