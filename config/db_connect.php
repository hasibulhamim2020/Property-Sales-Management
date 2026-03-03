<?php
session_start();

$link 	= mysql_connect('localhost', $_SESSION['db_user'], $_SESSION['db_pass']);
mysql_select_db($_SESSION['db_name']);

if (!$link) die('Could not connect: ' . mysql_error());
?>
