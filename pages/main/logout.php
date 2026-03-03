<?
session_start();
require_once "../../support/inc.all.php";

add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Successfully Logged In Asset',$_SESSION['user']['level']);
session_destroy();
header("Location: ../index.php");
?>
