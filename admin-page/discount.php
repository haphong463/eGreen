<?php
require_once('../db/dbhelper.php');
$sql = "SELECT * FROM coupon";
$discount = executeResult($sql);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>


        <table class="table">

            <br><br><br>
            <h1>Coupon List</h1>

            <div class="container">

                <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a href="discount-add.php">Add</a></button></h2>

                <thead>
                                                <tr>
                                                    <th scope="col">Count</th>
                                                    <th scope="col">Coupon Code</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($discount != null) {
                                                    foreach ($discount as $d) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <span style="font-weight: bold;" id="countdown-<?php echo $d['coupon_code']; ?>"></span>
                                                                <script>
                                                                    // Đếm ngược thời gian
                                                                    var currentDate = new Date().getTime();
                                                                    var startDate<?php echo $d['coupon_code']; ?> = new Date("<?php echo $d['startDate']; ?>").getTime();
                                                                    var countdownDate<?php echo $d['coupon_code']; ?> = new Date("<?php echo $d['expiration_date']; ?>").getTime();
                                                                    var countdownElement<?php echo $d['coupon_code']; ?> = document.getElementById("countdown-<?php echo $d['coupon_code']; ?>");

                                                                    if (currentDate < startDate<?php echo $d['coupon_code']; ?>) {
                                                                        countdownElement<?php echo $d['coupon_code']; ?>.innerHTML = "Not started";
                                                                    } else {
                                                                        var countdownTimer<?php echo $d['coupon_code']; ?> = setInterval(function() {
                                                                            var now = new Date().getTime();
                                                                            var distance = countdownDate<?php echo $d['coupon_code']; ?> - now;

                                                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                            countdownElement<?php echo $d['coupon_code']; ?>.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                                                                            if (distance < 0) {
                                                                                clearInterval(countdownTimer<?php echo $d['coupon_code']; ?>);
                                                                                countdownElement<?php echo $d['coupon_code']; ?>.innerHTML = "Expired";
                                                                            }
                                                                        }, 1000);
                                                                    }
                                                                </script>
                                                            </td>
                                                            <td><?php echo $d['coupon_code'] ?></td>
                                                            <td><?php echo number_format($d['discount'], 0) ?>%</td>
                                                            <td><?php echo $d['quantity'] ?></td>
                                                            <td><a href="discount-edit.php?d_id=<?php echo $d['coupon_code'] ?>"><button class="btn btn-info"><i class="fas fa-pencil-square-o"></i></button></a> <a href="process/delete.php?id=<?php echo $d['coupon_code'] ?>"><button class="btn btn-danger"><i class="fas fa-times"></i></button></a> </td>

                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
            </div>

        </table>
    </section>

    <script src="script.js"></script>
</body>

</html>