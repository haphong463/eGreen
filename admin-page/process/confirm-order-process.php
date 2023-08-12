<?php
require_once '../../db/dbhelper.php';
require_once '../../carbon/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

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
    $sql_update_status_transaction = "UPDATE orders SET status = 'Delivered', updated_at = NOW() WHERE order_id = '$order_id'";
    execute($sql_update_status_transaction);


    $sql_orders_query = "SELECT sum(quantity) as quantity FROM order_details WHERE order_id = '$order_id'";
    $quantity_order = executeSingleResult($sql_orders_query)['quantity'];


    $sql_transaction_query = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $sql_transaction_result = executeSingleResult($sql_transaction_query);


    $amount = $sql_transaction_result['total_amount'];

    $statistical = "SELECT * FROM statistical WHERE date = '$now'";
    $statistical_result = executeSingleResult($statistical);

    if ($now == $statistical_result['date']) {
        $sql_update_transaction = "UPDATE statistical SET quantity =  quantity + $quantity_order, revenue = revenue + $amount, orders = orders + 1 WHERE date = '$now'";
    } else {
        $sql_update_transaction = "INSERT INTO statistical (date, orders, revenue, quantity) VALUES ('$now', 1, $amount, $quantity_order)";
    }

    execute($sql_update_transaction);
    header('Location: ../orders.php');
}


if (!isset($_GET)) {
    header('Location: ../index.php');
}
