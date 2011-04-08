<?php
function welcome_admin_main(){
	$data[ 'name' ] = _db_option_value( 'name' );
	return $data;
}
?>