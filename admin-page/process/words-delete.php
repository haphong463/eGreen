<?php
require('../../db/dbhelper.php');
$id = '';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    //xoa file anh vat ly
    // $sql2 = 'SELECT * FROM `forbidden_words` where id =' .$id;
    // $user = executeSingleResult($sql2);
    // unlink('../'.$user['avatar']);

    //xoa trong db
    $sql = 'DELETE FROM `forbidden_words` where id ="'.$id.'"';
    execute($sql);

    header('Location:../words.php');
}
?>