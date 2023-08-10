<?php
require('../../db/dbhelper.php');
$id = '';

if(isset($_GET['review_id'])){
    $id = $_GET['review_id'];


    //xoa trong db
    $sql = 'delete from review_table where review_id = "'.$id.'"';
    execute($sql);

    header('Location:../review.php');
}
?>