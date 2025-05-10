<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$hostname = "localhost";
$username = "root";
$password = "";
$database = "evening";

try {
    $conn = mysqli_connect($hostname, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    echo $e->getMessage();
}
