<?
//==================== BOF =====================
if($_SESSION['user_group']!='admin' && $_SESSION['user_group']!='cheif_acc') {
	echo '<script>alert("You are not authorized to access this!"); self.location="home.php"</script>';
	exit;
}
//====================== EOF ===================
include "../common/check.php";
require "../config/db_connect.php";
require "../common/all_functions.php";
?>