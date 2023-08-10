<?php
require_once("../db/dbhelper.php");

if (isset($_GET['review_id'])) {
    $id = $_GET['review_id'];
    $review = "SELECT * FROM review_table where review_id = $id";
    $result = executeSingleResult($review);

    if (!$result) {
        header('Location: index.php');
    }
}

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

            <div class="">

                <h1>Change Status</h1>
                <form action="process/review-update-process.php" method="post" id="form" class="row" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="form-group">
                        <input type="checkbox" name="active" <?php if ($result['status'] == 0) {
                                                                    $status = "Active";
                                                                    echo 'checked';
                                                                } else {
                                                                    $status = "Inactive";
                                                                } ?>>
                        <label for="active"><?php echo $status ?></label>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="user_name">User Name</label>
                        <input type="text" value="<?php echo $result['user_name'] ?>" readonly class="form-control" id="user_name" name="user_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="user_rating">User Rating: </label>
                        <input type="text" value="<?php echo $result['user_rating'] ?>" readonly class="form-control" id="user_rating" name="user_rating">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="user_review">User Review: </label><br>
                        <input type="text" class="form-control" id="user_review" name="user_review" readonly value="<?php echo $result['user_review'] ?>">
                    </div>

                    <button type="submit" class="btn btn-info col-md-6">Update Review</button>

                </form>
            </div>
        </table>
    </section>


    <script src="script.js"></script>
</body>

</html>