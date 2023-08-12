<?php
require_once('../db/dbhelper.php');
$perPage = 8;

// Trang hiện tại, mặc định là 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính chỉ mục bắt đầu của dữ liệu trên trang hiện tại
$start = ($page - 1) * $perPage;



$status = isset($_GET['status']) ? $_GET['status'] : '';

$sql_transaction = "SELECT * FROM orders";

if (!empty($status)) {
    $sql_transaction .= " WHERE status = $status";
}

$sql_transaction .= " ORDER BY updated_at DESC LIMIT $start, $perPage";

$run_sql_transaction = executeResult($sql_transaction);

$transaction_status = executeResult("SELECT status FROM orders GROUP BY status");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">
    <br><br><br>

        <?php
        include('part/header.php');
        ?>
        
        <form method="GET" class="pull-right">
            <select name="status" id="status">
                <option value="">All</option>
                <?php
                foreach ($transaction_status as $statusOption) {
                    $selected = ($statusOption['status'] == $status) ? 'selected' : '';
                    switch ($statusOption['status']) {
                        case -2:
                            $status_select = 'Canceled';
                            break;
                        case -1:
                            $status_select = 'Cancellation in progress';
                            break;
                        case 1:
                            $status_select = "Place Order";
                            break;
                        case 2:
                            $status_select = "Processing";
                            break;
                        case 3:
                            $status_select = "Shipping";
                            break;
                        case 4:
                            $status_select = "Delivered";
                            break;
                        default:
                            $status_select = "Failed";
                            break;
                    }
                    echo '<option value="' . $statusOption['status'] . '" ' . $selected . '>' . $status_select . '</option>';
                }
                ?>
            </select>

            <noscript><input type="submit" value="Submit"></noscript>
        </form>
        <table class="table">

            <br><br><br>

            <div class="container-fluid">

                <h1>Orders List</h1>
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status </th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($run_sql_transaction != NULL) {
                        foreach ($run_sql_transaction as $transaction) {
                            $payment_status = $transaction['payment_status'];
                            $status = $transaction['status'];
                            $email = executeSingleResult("SELECT * FROM users WHERE user_id = {$transaction['user_id']}")['email'];

                            echo '
                                                            <tr>
                                                                <td>' . $transaction['order_id'] . '</td>
                                                                <td>' . $email . '</td>
                                                                <td>' . $transaction['payment_method'] . '</td>
                                                                <td>' . $payment_status . '</td>
                                                                <td class="order-status">' . $status . '</td>
                                                                <td><a class="btn btn-info" href="view-order.php?order_id=' . $transaction['order_id'] . '">View Order</a></td>
                                                            </tr>';
                        }
                    } else {
                        echo '  <tr>
                                                              <td style="text-align: center;" colspan="6">No transaction to display!</td>
                                                            </tr>';
                    }
                    ?>
                </tbody>
            </div>
        </table>
        <div class="pagination">
            <?php
            // Câu truy vấn SQL để lấy tổng số dòng dữ liệu
            $status = isset($_GET['status']) ? $_GET['status'] : '';

            $sql_count = "SELECT COUNT(*) AS total FROM orders";

            if (!empty($status)) {
                $sql_count .= " WHERE status = '$status'";
            }

            $result = executeSingleResult($sql_count);
            $totalRows = $result['total'];

            // Tính tổng số trang
            $totalPages = ceil($totalRows / $perPage);


            // Hiển thị các liên kết phân trang
            for ($i = 1; $i <= $totalPages; $i++) {
                $pageLink = '?page=' . $i;
                if (!empty($status)) {
                    $pageLink .= '&status=' . $status;
                }
                echo '<a class="btn btn-info" href="' . $pageLink . '">' . $i . '</a>';
            }

            ?>

        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#status').change(function() {
                $(this).closest('form').submit();
            });
        });
    </script>
    <script src="script.js"></script>

</body>

</html>