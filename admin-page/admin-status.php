<?php
session_start();
require_once('../db/dbhelper.php');
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $sql = "SELECT * FROM users WHERE user_id = '$id'";
    $Crole = executeSingleResult($sql);
    $role = $Crole["role"];

    if($role == 2){
        $sql = "UPDATE users SET status = $status WHERE user_id = $id";
        execute($sql);
        
        header('location: admin.php');
    }    
    else{
        $sql = "UPDATE users SET status = $status WHERE user_id = $id";
        execute($sql);
        
        header('location: user.php');
    }

   
}
?>