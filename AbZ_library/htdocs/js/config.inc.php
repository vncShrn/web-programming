<?php

$db_username = 'root';
$db_password = 'root';
$db_name = 'test';
$db_host = 'localhost';
$item_per_page = 5;


$connecDB = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('could not connect to database');
?>