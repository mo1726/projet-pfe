<?php
$database = "localhost";
$username = "root";
$password = "";
$dbname = "delevry";

$con = new mysqli($database, $username, $password, $dbname);
if ($con->connect_error) {
    die("Error: " . $con->connect_error);
}
