<?php
require_once('../db/dbhelper.php');
$sql = 'select * from about';
$abouts = executeResult($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin Dashboard Panel</title>
</head>
<style>
    td,
    tr {
        text-align: center;
    }
</style>

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

            <div class="container">

                <h1>about</h1>
                <thead>

                    <tr>
                        <th scope="col">Content</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Img</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($abouts != null) {
                        foreach ($abouts as $row) {
                    ?>
                            <tr>
                                <td><?php echo $row['content']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td>
                                    <img src="<?php echo $row['image']; ?>" width="200px" height="120px" alt="">
                                </td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a style="width: 100px;" href="about-edit.php?sid=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-info">edit
                                    </a>
                                </td>
                            </tr>

                        <?php
                        }
                    } else {
                        ?>
                        <p style="color:red;">no records found</p>
                    <?php
                    }
                    ?>


                </tbody>
            </div>

        </table>

    </section>

    <script src="script.js"></script>
</body>

</html>