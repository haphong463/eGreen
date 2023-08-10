<?php
session_start();
require_once('db/dbhelper.php');
unset($_SESSION['user']);
// session_destroy();
header("location:user-login.php");
?>