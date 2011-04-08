<?php
class Validator{
	private static $instance;
	private $errors; // Luu tru cac loi phat sinh
	public static function singleton( $keepolderror = false ){
		if ( self::$instance == null ){
			self::$instance = new Validator();
		}
		if ( !$keepolderror ){
			self::$instance->errors = null;
		}
		return self::$instance;
	}
	public function validate_general( $sInput, $sDesc = '' ){
		if ( trim( $sInput ) != "" ) {
			return true;
		}else{
			$this->errors[] = $sDesc;
			return false;
		}
	}
	public function validate_email( $sMail,$sDesc = '' ){
		$nResult = ereg ( "^[^@ ]+@[^@ ]+\.[^@ \.]+$", $sMail );
		if ( $nResult ){
			return true;
		}else{
			$this->errors[] = $sDesc;
			return false;
		}
	}

	public function validate_number( $sInput,$sDesc = '' ){
		if ( is_numeric( $sInput ) ) {
			return true;
		}else{
			$this->errors[] = $sDesc;
			return false;
		}
	}
	function validate_verify( $sInput, $sDesc = '' ){
		if ( ( md5( $sInput ) == $_COOKIE['_imagehash'] ) == true ){
			return true;
		}
		$this->errors[] = $sDesc;
		return false;
	}
	public function foundErrors() {
		if ( count($this->errors) > 0 ){
			return true;
		}else{
			return false;
		}
	}
	public function getErrors(){
		return $this->errors;
	}
	public function removeErrors(){
		$arr = $this->errors;
		unset( $this->errors );
		return $arr;
	}

	public function addError($sDesc){
		$this->errors[] = $sDesc;
	}


	public function validateInfo( $values, $errs ){
		foreach ( $errs as $name => $err ){
			$arr = split( '\.', $name );
			$type = '';
			if ( count( $arr ) > 1 ) {
				$type = $arr[ 0 ];
				//Kiem tra general truoc, ok moi kiem tra tiep theo
				if ( $this->validate_general( $values[ $arr[ 1 ] ], $err ) && $type != '' ){
					$method = 'validate_' . strtolower( $type );
					if ( method_exists( $this,  $method ) ) {
						$this->$method( $values[ $arr[ 1 ] ], $err );
					}
				}//if
			}else{
				$this->validate_general( $values[$name], $err );
			}

		}//foreach
		if ( empty( $this->errors ) ){
			return true;
		}
		return false;
	}
}
?>