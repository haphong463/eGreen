<?php
session_start();
require_once('../db/dbhelper.php');

if(isset($_SESSION['admin'])){
    $user = $_SESSION['admin'];
    $user_id = $user['user_id'];
    $sql = "UPDATE users
SET token_create_at = '', lasttimeOnl = now() WHERE user_id = '$user_id'  " ;
execute($sql);
unset($_SESSION['admin']);
}
// session_destroy();
header("location:login.php");
?>