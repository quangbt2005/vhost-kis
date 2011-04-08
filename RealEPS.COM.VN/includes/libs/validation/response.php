<?PHP
include ('globals.php');
session_start();

if (md5($_REQUEST['code_check'])==$_COOKIE[$site_cookie_verifyimage_name]) {
	echo "Success";
} else {
	echo "Failure";
}
?>
