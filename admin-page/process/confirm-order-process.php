<?php
require_once '../../db/dbhelper.php';
require_once '../../carbon/autoload.php';
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql_update_status_transaction = "UPDATE orders SET status = 'Processing' WHERE order_id = '$order_id'";
    execute($sql_update_status_transaction);
    header('Location: ../orders.php');
}
if (isset($_GET['order_go'])) {
    $order_id = $_GET['order_go'];
    $sql_update_status_transaction = "UPDATE orders SET status = 'Shipping' WHERE order_id = '$order_id'";
    execute($sql_update_status_transaction);
    header('Location: ../orders.php');
}
if (isset($_GET['finish_order'])) {
    $order_id = $_GET['finish_order'];
    $sql_update_status_transaction = "UPDATE orders SET status = 'Delivered' WHERE order_id = '$order_id'";
    execute($sql_update_status_transaction);
    header('Location: ../orders.php');
}


if (!isset($_GET)) {
    header('Location: ../index.php');
}
