<?php
session_start();
require_once('db/dbhelper.php');
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
    $sql = "UPDATE users
SET token = '', token_create_at = null, lasttimeOnl = now() WHERE user_id = '$user_id'  " ;
execute($sql);
unset($_SESSION['user']);
}elseif (isset($_SESSION['user_token'])) {
    $token = $_SESSION['user_token'];
    $sql = "SELECT * FROM users WHERE token = '$token'";
    $user=executeSingleResult($sql);
    $user_id = $user['user_id'];
    $sql = "UPDATE users
    SET token_create_at ='' WHERE user_id = '$user_id'  " ;
    execute($sql);
    unset($_SESSION['user_token']);
}

// session_destroy();
header("location:index.php");
?>