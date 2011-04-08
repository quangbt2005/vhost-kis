<?php  
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 //------------------------------------------------------------------------
 /**
 * DFLogging Class
 * * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * Modified by Xuan Phuong from Log.php of Rick Ellis
 * Date: 20 Dec 2006
 */
class My_Log {

	var $log_path;
	var $_threshold	= 1;
	var $_date_fmt	= 'Y-m-d H:i:s';
	var $_enabled	= TRUE;
	var $_levels	= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	string	the log file path
	 * @param	string	the error threshold
	 * @param	string	the date formatting codes
	 */
	function My_Log()
	{
		$config =& get_config();
		
		$this->log_path = ($config['my_log_path'] != '') ? $config['my_log_path'] : BASEPATH.'my_logs/';
		
		if ( ! is_dir($this->log_path) OR ! is_writable($this->log_path))
		{
			$this->_enabled = FALSE;
		}

		if (is_numeric($config['my_log_threshold']))
		{
			$this->_threshold = $config['my_log_threshold'];
		}
			
		if ($config['log_date_format'] != '')
		{
			$this->_date_fmt = $config['log_date_format'];
		}
	}
	
	// --------------------------------------------------------------------
	
 	/** Write Log File
	 * Generally this function will be called using the global my_log() function
	 * This logs by user and date time.
	 *
	 * @access	public
	 * @param	int	user id
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 * 
	 */		
	function write_my_log($u_name,$level = 'error', $msg, $php_error = FALSE)
	{		
		//print_r('    write log of daiken    ');
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}
	
		$level = strtoupper($level);
		
		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}
	
		$date_array = getdate();
		$log_dir = $this->log_path.$date_array['mon'].'-'.$date_array['year'].'/';
		if (!is_dir($log_dir)){
			mkdir( $log_dir, 0777 ); 
		}
		$filepath = $log_dir.'log-user-'.$u_name.LOG;
		
		$message  = '';
		
		/*if ( ! file_exists($filepath)){
			touch($filepath);
		}*/
		
		if ( ! file_exists($filepath))
		{
			$message .= "<!-- Log file ".$u_name.$date_array['mon'].'-'.$date_array['year']." --!>\n\n";
		}
			
		if ( ! $fp = @fopen($filepath, "a"))
		{
			return FALSE;
		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";
		
		//print_r($message);
		flock($fp, LOCK_EX);	
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);
	
		@chmod($filepath, 0666); 		
		return TRUE;
	}

}
// END Log Class
?>