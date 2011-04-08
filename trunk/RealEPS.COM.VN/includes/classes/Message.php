<?php
class Message{
	private static $instance = null;
	/// {{{ singleton
	public static function singleton(){
		if ( !isset( self::$instance ) ){
			self::$instance = new Message();
		}
		return self::$instance;
	}
	/// }}}
	/// {{{ display
	public function display( ){
		$html = '';
		if ( !empty( $_SESSION[ '_message' ] )){
			$html = '<div class="message">';
			$html .= '<ul>';
			foreach ( $_SESSION[ '_message' ] as $msg ){
				$html .= '<li>' . $msg . '</li>';
			}
			$html .= '</ul>';
			$html .= '</div>';			//die($_SERVER[REQUEST_URI]);
			$_SESSION[ '_message' ] = null;
		}
		return $html;
	}
	/// }}}
	/// {{{ addMessage
	public function addMessage( $msg, $hightlight = false ){
		if ( $msg != '' ){
			if ( $hightlight ){
				$_SESSION[ '_message' ][] = '<span class="hightlight">' . $msg . '</span>';
			}else{
				$_SESSION[ '_message' ][] = $msg;	
			}
		}
	}
	/// }}}
}?>