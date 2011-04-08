<?php 

$config['subclass_prefix'] = '';

/*
|   0 = Disables daiken logging
| 	0 = Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
*/
$config['my_log_threshold'] = 4;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| my_logs/ folder.  Use a full server path with trailing slash.
|
*/
$config['my_log_path'] = '/home/vhosts/eSMSstorage/logs/user_log/';//$_SERVER["DOCUMENT_ROOT"] .'/logs/my_logs/';


/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

?>
