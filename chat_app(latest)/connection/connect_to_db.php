<<<<<<< HEAD
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$hostname_db = "localhost";
$username_db = "root";
$password_db = "";
$database_db = "chat";

try {
    $conn = mysqli_connect($hostname_db, $username_db, $password_db, $database_db);
    // echo "connection created"
} catch (mysqli_sql_exception $e) {
    echo $e->getMessage();
}
=======
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$hostname_db = "localhost";
$username_db = "root";
$password_db = "";
$database_db = "chat";

try {
    $conn = mysqli_connect($hostname_db, $username_db, $password_db, $database_db);
    // echo "connection created"
} catch (mysqli_sql_exception $e) {
    echo $e->getMessage();
}
>>>>>>> 2bcff93a9faf9f104fc21887c240c5734d9dcd1c
