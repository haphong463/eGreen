<?php
session_start();
require_once('../db/dbhelper.php');
unset($_SESSION['admin']);
// session_destroy();
header("location:../login.php");
?>