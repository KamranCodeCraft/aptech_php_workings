<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
session_destroy();
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Location: /vaccination_system/login.php');
exit();
?>