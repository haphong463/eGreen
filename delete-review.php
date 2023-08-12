<?php
require_once('db/dbhelper.php');
if (isset($_GET['review_id'])) {
    $id = $_GET['review_id'];
    
    $pid = isset($_GET['pid']) ? $_GET['pid'] : Null;

    //xoa trong db
    $sql = 'delete from review_table where review_id = "' . $id . '"';
    execute($sql);

    header('Location:product-detail.php?pid=' . $pid . '');
} 

if (isset($_GET['acc_review_id'])) {
    $id = $_GET['acc_review_id'];
    
    $pid = isset($_GET['pid']) ? $_GET['pid'] : Null;

    //xoa trong db
    $sql = 'delete from review_acc where review_id = "' . $id . '"';
    execute($sql);

    header('Location:acc-detail.php?pid=' . $pid . '');
} else {
    header('Location: index.php');
}
?>