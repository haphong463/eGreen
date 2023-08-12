<?php
require_once '../../db/dbhelper.php';

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : header('Location: ../orders.php');

$sql = "UPDATE cancel_order SET isAccept = 1 WHERE order_id = '$order_id'";
execute($sql);

$sql = "UPDATE orders SET status = 'Canceled', updated_at = NOW() WHERE order_id = '$order_id'";
execute($sql);







header('Location: ../orders.php');
