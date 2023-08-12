<?php
require_once '../../db/dbhelper.php';
require_once '../../sendmail.php';

$order_id = isset($_GET['return_order']) ? $_GET['return_order'] : header('Location: ../orders.php');

$sql = "UPDATE returns SET isAccept = 1 WHERE order_id = '$order_id'";
execute($sql);

$sql = "UPDATE orders SET status = 'Returned', updated_at = NOW() WHERE order_id = '$order_id'";
execute($sql);
$order = executeSingleResult("SELECT * FROM orders WHERE order_id = '$order_id'");
$users = executeSingleResult("SELECT * FROM users WHERE user_id = {$order['user_id']}");
$email = $users['email'];
$title = 'Notice: ORDER #' . $order_id . '';
$content = '<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            background-color: #fff;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                        }

                        a.tab-button {
                            text-decoration: none;
                            font-size: 14px;
                            font-weight: 600;
                            position: relative;
                            letter-spacing: .02em;
                            display: block;
                            padding: 10px 25px;
                            outline: none;
                            background: #eee;
                            color: #333;
                            border: none;
                        }
                        a.tab-button.active,
                        a.tab-button:hover {
                            transition: .5s;
                            opacity: 1;
                            text-decoration: none;
                            background-color: #fff;
                            color: #000;
                        }

                        h1 {
                            color: #333;
                            font-size: 24px;
                        }
                        p {
                            font-size: 16px;
                            line-height: 24px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Return Approved</h1>
                        <p>Dear ' . $users['fullname'] . ',</p>
                        <p>Thank you for placing an order with our store. Your order has been received and is being processed.</p>

                        <p>We are excited to let you know that our team is working diligently to prepare your items for shipment. Once your order has been shipped, we will send you a notification with the tracking details.</p>

                        <p>Please take a moment to review your order details below:</p>


                                        <p>If you have any questions or need further assistance, please don\'t hesitate to contact our customer support team at support@plantnest.com.</p>

                                        <p>
                                            <a class="tab-button" href="localhost/egreen/order-details.php?order_id=' . $order_id . '">View Order</a>
                                            <a class="tab-button" href="localhost/egreen">Visit Website</a>
                                        </p>

                                        <p>Once again, thank you for choosing our store. We truly appreciate your business!</p>

                                        <p>Sincerely,</p>
                                        <p>Web Application PlantNest</p>
                                    </div>
                                </body>
                            </html>';




$mailer = new Mailer();
$mailer->dathangmail($title, $content, $email);

header('Location: ../orders.php');
