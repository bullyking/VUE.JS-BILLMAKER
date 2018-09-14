<?php
$host = "127.0.0.1"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "billmaker"; /* Database name */
$charset = "utf8";

$con = mysqli_connect($host, $user, $password, $dbname);
$con->set_charset($charset);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$res = array('error' => false);
$con->close();

header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *");
?>
