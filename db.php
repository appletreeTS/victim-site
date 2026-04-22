<?php
$db_host = '127.0.0.1';
$db_user = 'victim';
$db_pass = 'victim';
$db_name = 'victim_db';
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die('DB connect failed: ' . mysqli_connect_error());
}
?>
