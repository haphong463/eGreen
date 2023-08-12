<?php
require_once('../db/dbhelper.php');
$plants = executeResult("SELECT * FROM plants");
if (isset($_POST['update-price'])) {
    $new_price = $_POST['new_price'];
    $pid = $_POST['plant_id'];
    if($new_price == 0){
        execute("UPDATE plants SET sale = NULL WHERE plant_id = $pid");
        return;
    } 
    execute("UPDATE plants SET sale = $new_price WHERE plant_id = $pid");
    header('Location: plants.php');
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

        <?php
        include('part/header.php');
        ?>


        <table class="table">

            <br><br><br>
            <h1>Plants</h1>

            <div class="container">

                <h2 style="float: right;"><button type="button" class="btn btn-outline-info"><a href="plant-add.php">Add</a></button></h2>

                <thead>
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($plants as $plant) {
                        $cate_name = executeSingleResult("SELECT * FROM categories WHERE category_id = {$plant['category_id']}")['name'];
                        if ($plant['sale'] != null && $plant['sale'] > 0) {
                            $price = '<del style="text-decoration:line-through;">' . $plant['price'] . '</del> <span style="color:red">' . $plant['sale'] . '</span>';
                        } else {
                            $price = $plant['price'];
                        }
                        echo '
                        
                        <tr>
                        <th scope="row">' . $cate_name . '</th>
                        <td>' . $plant['name'] . '</td>
                        <td>' . $price . '</td>
                        <td>
                            <a href="plant-edit.php?id=' . $plant['plant_id'] . '"><button type="button" class="btn btn-secondary">Edit</button></a>
                           <a href="process/delete.php?delete_plant=' . $plant['plant_id'] . '"> <button type="button" class="btn btn-danger">Delete</button></a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-id="' . $plant['plant_id'] . '"  data-old-price="' . $plant['price'] . '"
                             data-target="#myModal">
                            Update Price
                          </button>
                        
                          <!-- The Modal -->
                         
                        </td>
                    </tr>

                        ';
                    }
                    ?>
                </tbody>
            </div>

        </table>
    </section>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="plant_id" id="plant_id">
                        <div class="form-group">
                            <label for="old_price">Old Price:</label>
                            <input type="text" class="form-control" id="old_price" value="" name="old_price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="new_price">New Price:</label>
                            <input type="text" class="form-control" id="new_price" name="new_price">
                        </div>
                        <button type="submit" name="update-price" class="btn btn-primary">Submit</button>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-primary[data-target="#myModal"]').on('click', function(event) {
                var button = $(this);
                var oldPrice = parseFloat(button.data('old-price'));
                var plantId = button.data('id');
                var newPrice = button.data('new-price');

                var modal = $('#myModal');
                modal.find('#plant_id').val(plantId);
                modal.find('#old_price').val(oldPrice);
                modal.find('#new_price').val(newPrice);
            });
        });
    </script>
    <script src="script.js"></script>
</body>

</html>