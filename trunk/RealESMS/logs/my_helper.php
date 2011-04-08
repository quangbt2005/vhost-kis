<?php 
include ("adodb-time.inc.php");
define ('EXT','.php');
define ('LOG','.log');
define ('APPPATH', $_SERVER['DOCUMENT_ROOT']. 'logs');
define ('BASEPATH', $_SERVER['DOCUMENT_ROOT']. 'logs');

 /**
* Error Handler
*
* This function lets us invoke the exception class and
* display errors using the standard error template located
* in application/errors/errors.php
* This function will send the error page directly to the
* browser and exit.
*
* @access	public
* @return	void
*/
function show_error($message)
{
	echo 'An Error Was Encountered. '.$message;
	exit;
}

/**
* Gets a config item
*
* @access	public
* @return	mixed
*/
function config_item($item)
{
	static $config_item = array();

	if ( ! isset($config_item[$item]))
	{
		$config =& get_config();
		
		if ( ! isset($config[$item]))
		{
			return FALSE;
		}
		$config_item[$item] = $config[$item];
	}

	return $config_item[$item];
}


/**
* Class registry
*
* This function acts as a singleton.  If the requested class does not
* exist it is instantiated and set to a static variable.  If it has
* previously been instantiated the variable is returned.
*
* @access	public
* @param	string	the class name being requested
* @param	bool	optional flag that lets classes get loaded but not instantiated
* @return	object
*/
function &load_class($class, $instantiate = TRUE)
{
	static $objects = array();

	// Does the class exist?  If so, we're done...
	if (isset($objects[$class]))
	{
		return $objects[$class];
	}
			
	// If the requested class does not exist in the application/libraries
	// folder we'll load the native class from the system/libraries folder.	
	if (file_exists(config_item('subclass_prefix').$class.EXT))
	{
		require_once($_SERVER["DOCUMENT_ROOT"] .'/logs/'. $class.EXT);	
		require_once($_SERVER["DOCUMENT_ROOT"] .'/logs/'. config_item('subclass_prefix').$class.EXT);
		$is_subclass = TRUE;	
	}
	else
	{
		if (file_exists($_SERVER["DOCUMENT_ROOT"] .'/logs/'. $class.EXT))
		{
			require_once($_SERVER["DOCUMENT_ROOT"] .'/logs/'. $class.EXT);	
			$is_subclass = FALSE;	
		}
		else
		{
			require_once($_SERVER["DOCUMENT_ROOT"] .'/logs/'. $class.EXT);
			$is_subclass = FALSE;
		}
	}

	if ($instantiate == FALSE)
	{
		$objects[$class] = TRUE;
		return $objects[$class];
	}
		
	if ($is_subclass == TRUE)
	{
		$name = config_item('subclass_prefix').$class;
		$objects[$class] =& new $name();
		return $objects[$class];
	}

	$name = ($class != 'Controller') ? 'CI_'.$class : $class;
	//Richie
	$name = ($class == 'Controller') ? 'CI_'.$class : $class;

	$objects[$class] =& new $name();
	return $objects[$class];
}

/**
* Loads the main config.php file
*
* @access	private
* @return	array
*/
function &get_config()
{	
	$config_file_name = $_SERVER["DOCUMENT_ROOT"] .'/logs/config';
	static $main_conf;
		
	if ( ! isset($main_conf))
	{
		if ( ! file_exists($config_file_name.EXT))
		{
			show_error('The configuration file '.$config_file_name .EXT.' does not exist.');
		}
		
		require($config_file_name .EXT);
		
		if ( ! isset($config) OR ! is_array($config))
		{
			show_error('Your config file does not appear to be formatted correctly.');
		}

		$main_conf[0] =& $config;
	}
	return $main_conf[0];
}

 /*
  * Usage: get_current_time($format_string);
  * */
 function get_current_time($format_string="Y-m-d"){
 	$dt=adodb_date($format_string,time());
 	return $dt;
 }

/**
 * Project Error Logging Interface
 * We use this as a simple mechanism to access the logging
 * 		class and send messages to be logged.
 * Name: my_log
 */
 
 function my_log($u_name,$level = 'error', $message, $php_error = FALSE)
{
	static $MYLOG;
	$config =& get_config();
	if ($config['my_log_threshold'] == 0)
	{
		return;
	}
	$MYLOG =& load_class('My_Log');	
	$MYLOG->write_my_log($u_name,$level, $message, $php_error);
}
/** 
	Description: merge array;
	param: array
	return array
*/
/*function arrayMerge( $a1, $a2 ) {
	foreach ($a2 as $k => $v) {
		$a1[$k] = $v;
	}
	return $a1;
}*/
		
?>
