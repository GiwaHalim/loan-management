<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
// define('DB_NAME', 'loan_repayment');
define('DB_NAME', 'login_demo');



/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($link === false) {
    die ("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS DB_NAME";
if (mysqli_query($link, $sql)) {
    // echo "Database created successfully<br>";
} else {
    // echo "Error creating database: " . $link->error;
}


$sql = "USE DB_NAME";

if (mysqli_query($link, $sql)) {
    // echo "Database selected successfully<br>";
} else {
    // echo "Error selecting database: " . $link->error;
}




?>