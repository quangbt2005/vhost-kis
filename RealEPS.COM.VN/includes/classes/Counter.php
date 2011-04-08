<?php

//Sercurity session + Counter

class Counter{

	//1 ngafy
	public static $time_to_live = 180;

	public static function vistitor_listener(){
		if ( !isset( $_COOKIE[ 'visited' ] ) ){
			setcookie( 'visited', strtotime( 'now' ) , time() + 60*60*24, '/' );
			$sql = 'UPDATE options SET option_value = option_value + 1  WHERE option_name = "visitor"';
			$db = _db();
			$db->query( $sql );

		}

	}

	public static function useronline_listener(){

		$sSessionId = session_id();

		$db = _db();

		$sql = 'DELETE FROM session WHERE :NOW - start_time > :TIME_TO_LIVE AND session_id <> :SESSION_ID';

		$db->prepare( $sql );

		$db->bindValue( ':TIME_TO_LIVE', self::$time_to_live, PARAM_INT );

		$db->bindValue( ':NOW', strtotime( 'now' ), PARAM_INT );

		$db->bindValue( ':SESSION_ID', $sSessionId, PARAM_STR );

		$db->execute();

		$sIp = $_SERVER[ 'REMOTE_ADDR' ];

		$sPath = $_SERVER[ 'PHP_SELF' ];

		$sql = 'SELECT * FROM session WHERE session_id = :SESSION_ID';

		$db->prepare( $sql );

		$db->bindValue( ':SESSION_ID', $sSessionId, PARAM_STR );

		$db->execute();

		$bNewSession = true;



		if ( $session = $db->fetch() ){

			//IP <> session : truong hop fake session cua nguoi khac

			if ( $session[ 'ipaddress' ] != $sIp || ( strtotime( 'now' ) - $session[ 'start_time' ] > self::$time_to_live ) ){

				$sql = 'DELETE FROM session WHERE session_id = :SESSION_ID';

				$db->prepare( $sql );

				$db->bindValue( ':SESSION_ID', $sSessionId, PARAM_STR );

				$db->execute();

				//Sinh lai session id

				//session_regenerate_id  ( true );

				$sSessionId = session_id();

				//IP == session

			}else{

				$sql = 'UPDATE session SET

						path = :PATH,

						last_time = :LAST_TIME

						WHERE session_id = :SESSION_ID';

				$db->prepare( $sql );

				$db->bindValue( ':SESSION_ID', $sSessionId, PARAM_STR );

				$db->bindValue( ':PATH', $sPath, PARAM_STR );

				$db->bindValue( ':LAST_TIME', strtotime( 'now' ), PARAM_INT );

				//die( $db->getSQL() );

				$db->execute();

				$bNewSession = false;

			}



		}



		if ( $bNewSession ){

			$sql = 'INSERT INTO session ( session_id, ipaddress, path, start_time, last_time )

					VALUES ( :SESSION_ID, :IPADDRESS, :PATH, :START_TIME, :LAST_TIME )';

			$db->prepare( $sql );

			$db->bindValue( ':SESSION_ID', $sSessionId, PARAM_STR );

			$db->bindValue( ':IPADDRESS', $sIp, PARAM_STR );

			$db->bindValue( ':PATH', $sPath, PARAM_STR );

			$db->bindValue( ':START_TIME', strtotime( 'now' ), PARAM_INT );

			$db->bindValue( ':LAST_TIME', strtotime( 'now' ), PARAM_INT );

			$db->execute();

		}

	}



	public static function listener(){

		self::useronline_listener();

		self::vistitor_listener();

	}



	public static function online(){

		$db = _db();

		$sql = 'SELECT COUNT(*) as user_online FROM session';

		$db->query( $sql );

		$db->execute();

		$useronline = $db->fetch();

		$useronline = $useronline[ 'user_online' ];

		$min = _db_option_value( 'default_visitor_online' );

		if (  $min > $useronline ){

			$useronline = $min;

		}

		return $useronline;

	}

}

?>