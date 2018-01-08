<?php

session_start();

unset($_SESSION["cart"]);

unset($_SESSION["sess_username"]);

header("location:index.php");

?>