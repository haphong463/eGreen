<?php
require('../../db/dbhelper.php');
$id = '';

if(isset($_GET['id'])){
    $id = $_GET['id'];


    //xoa trong db
    $sql = 'delete from comments where id = "'.$id.'"';
    execute($sql);

    header('Location:../comment.php');
}
?>