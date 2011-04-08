<?phpdefine ( 'FETCH_ASSOC', 'assoc' );define ( 'FETCH_NUM', 	'num' );define ( 'FETCH_BOTH', 	'both' );define ( 'FETCH_OBJ', 	'obj' );define ( 'AUTO_INCREMENT', 'auto_increment' );
class MySQL{
	/// {{{ properties
	private static $instance = array();
	private $dbhost;
	private $dbuser;
	private $dbpass;
	public $dbname;
	public $conn;
	private $sql;
	private $fetchMode = FETCH_ASSOC;
	private $result;	private $prefix;
	/// }}}
	/// {{{ __construct
	/**
	 * __construct
	 *
	 * Ham khoi tao mac dinh.
	 *
	 * @access public
	 */
	public function __construct( $dbhost, $dbuser, $dbpass, $dbname, $tbl_prefix ) {
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->dbname = $dbname;		$this->prefix = $tbl_prefix;
		$this->conn	  = null;
		$this->sql    = null;
		$this->result = null;
	}
	/// }}}
	/// {{{ singleton
	/**
	 * singleton
	 *
	 * Tao instance cua lop MySQL.
	 *
	 * @access public
	 * @return mixed
	 */
	public static function singleton($db_instance,$db_host, $db_user, $db_pass, $db_name, $tbl_prefix) {		
		if ( empty( self::$instance[$db_instance] ) ){			
			self::$instance[$db_instance] = new MySQL($db_host,$db_user,$db_pass,$db_name,$tbl_prefix);			
			self::$instance[$db_instance]->connect();					
		}		
		return self::$instance[$db_instance];
	}
	/// }}}	
	/// {{{ connect
	/**
	 * connect
	 *
	 * Thuc hien ket noi toi database
	 *
	 * @access public
	 * @return boolean
	 */
	public function connect() {			@mysql_close($this->conn);	
		if ( $this->conn = @mysql_connect( $this->dbhost, $this->dbuser, $this->dbpass,true,131072) ){						
			if ( @mysql_select_db( $this->dbname, $this->conn ) ) {				mysql_query("SET NAMES 'utf8'");							return true;						}
			else die( '<!-- Database '.$this->dbname.' tren '.$this->dbhost.' khong hop le -->' );			
		}else die( '<!-- Khong ket noi DB Sever : '.$this->dbhost.' -->' );
		return false;
	}
	/// }}}

	/// {{{ setFetchMode
	/**
	 * setFetchMode
	 *
	 * Dat kieu fetch du lieu.
	 *
	 * @access public
	 */
	public function setFetchMode( $mode ) {
		$this->fetchMode = $mode;
	}
	/// }}}
	/// {{{ bindValue
	/**
	 * bindValue
	 *
	 * Gan gia tri cho cau sql.
	 *
	 * @access public
	 */
	public function bindValue( $name, $value, $type ) {
		if( get_magic_quotes_gpc() ) $value = stripslashes( $value );
		switch( $type ){
			case PARAM_STR:
				$this->sql = str_replace( $name, '\'' . mysql_real_escape_string($value). '\'' , $this->sql );
			break;
			case PARAM_INT:
				$this->sql = str_replace( $name, intval( $value ), $this->sql );
			break;
			case PARAM_FLOAT:
				$this->sql = str_replace( $name,floatval($value), $this->sql );
				break;
			case PARAM_OBJ:
				$this->sql = str_replace( $name,'`' . mysql_real_escape_string($value) . '`', $this->sql );
			break;
			case PARAM_NONE :
				$this->sql = str_replace( $name, mysql_real_escape_string( $value ), $this->sql );
			break;
		}
	}
	/// }}}
	/// {{{ prepare
	/**
	 * prepare
	 *
	 * Truyen vao cau sql.
	 *
	 * @access public
	 * @return boolean
	 */
	public function prepare( $sql ) {			$sql = str_replace( '_prefix_', $this->prefix, $sql);		
		if ( $sql != "" ){			
			if ( $this->conn ){
				$this->sql = $sql;
				return true;
			}
		}
		return false;
	}
	/// }}}

	/// {{{ execute
	/**
	 * execute
	 *
	 * Thuc hien cau truy van.
	 *
	 * @access public
	 * @return boolean
	 */
	public function execute() {
		if ( $this->sql != "" ){						$this->result = @mysql_query( $this->sql, $this->conn );			if (mysql_error($this->conn))							echo $this->sql . ' - ' . mysql_error($this->conn) . '<br/>';
			if ( $this->result ){				$this->sql = NULL;				return true;				
			}							}
		return false;
	}
	/// }}}
	/// {{{ query
	/**
	 * query
	 *
	 * Thuc hien cau truy van truc tiep voi cau sql.
	 *
	 * @access public
	 */
	public function query( $sql ) {		$sql = str_replace( '_prefix_', $this->prefix, $sql);
		$this->sql = $sql;
		return $this->execute();
	}
	/// }}}
	/// {{{ fetch
	/**
	 * fetch
	 *
	 * Truy van don result.
	 *
	 * @access public
	 */
	public function fetch( $classname = 'stdClass', $free_result = true ) {
		if( $this->result ){
			switch( $this->fetchMode ){
				case FETCH_ASSOC: $row = @mysql_fetch_assoc( $this->result ); break;
				case FETCH_NUM: $row =  @mysql_fetch_row( $this->result ); break;
				case FETCH_BOTH: $row = @mysql_fetch_array( $this->result ); break;
				case FETCH_OBJ: $row =  @mysql_fetch_object( $this->result, $classname );break;				
			}//switch						
			if( $free_result ) @mysql_free_result($this->result);			if (!empty($row)) return $row;
		}
		return false;
	}
	/// }}}
	/// {{{ fetchAll
	/**
	 * fetchAll
	 *
	 * Truy van toan bo result.
	 *
	 * @access public
	 */
	public function fetchAll( $classname = 'stdClass' ) {
		if( $this->result ){
			$objs = NULL;
			while( $rs = $this->fetch( $classname, false ) ) $objs[] = $rs;
			@mysql_free_result($this->result);
			if ( !empty( $objs ) ) return $objs;			
		}//if
		return false;
	}
	/// }}}
	/// {{{ getSQL
	/**
	 * getSQL
	 *
	 * Lay cau lenh sql
	 *
	 * @access public
	 * @return string
	 */
	public function getSQL(   ) {
		return $this->sql;
	}
	/// }}}
	/// {{{ rowCount
	/**
	 * rowCount
	 *
	 * Lay tong so record cua lan truy van cuoi.
	 *
	 * @access public
	 */
	public function rowCount( ) {
		return @mysql_affected_rows($this->conn);
	}
	/// }}}
	public function lastInsertId(){
		return @mysql_insert_id($this->conn);
	}
	public function totalRecord( $table ){		$table = str_replace( '_prefix_', $this->prefix, $table);
		$sql = 'SHOW TABLE STATUS LIKE :TABLE';
		$this->prepare( $sql );
		$this->bindValue( ':TABLE', $table, PARAM_STR );
		$this->execute();
		if ( $row = $this->fetch() )  return intval( $row[ 'Rows' ] );				return 0;
	}
	public function nextId( $table ){		$table = str_replace( '_prefix_', $this->prefix, $table);
		$sql = 'SHOW TABLE STATUS LIKE :TABLE';
		$this->prepare( $sql );
		$this->bindValue( ':TABLE', $table, PARAM_STR );
		$this->execute();
		if ($row = $this->fetch()) return intval( $row[ 'Auto_increment' ] );		return 0;
	}
	public function truncate( $table ){		$table = str_replace( '_prefix_', $this->prefix, $table);
		$sql = 'TRUNCATE TABLE :TABLE';
		$this->prepare( $sql );
		$this->bindValue( ':TABLE', $table, PARAM_OBJ );
		$this->execute();
	}
	public function total_last_limit_query(){		
		$sql = 'SELECT FOUND_ROWS() AS FOUND_ROWS';
		$this->query( $sql );
		$obj = $this->fetch();
		return intval( $obj[ 'FOUND_ROWS' ] );
	}	public function error(){		return mysql_error($this->conn);	}	public function errorno(){		return mysql_errno($this->conn);	}
}
?>