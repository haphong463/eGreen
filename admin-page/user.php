<?php
session_start();
require_once('../db/dbhelper.php');
$sql = 'select * from users';
$slider = executeResult($sql);
// if(isset($_SESSION['admin'])){
//     $admin = $_SESSION['admin'];
// $role = $admin['role'];
// }else{
//     header('location:login-admin.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Admin Dashboard Panel</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/d792273ae6.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>
        <br><br><br><br><br><br>
        <div class="table-responsive">
        <i class="fa-solid fa-circle" style="color:lawngreen"></i>: Online<br> 
        <i class="fa-solid fa-circle" style="color:gray"></i>: Offline<br>
        <i class="fa-solid fa-circle" style="color:red"></i>: Don't Disturb <br>
           
            <div class="product-physical">
                <table class="table">
                    <thead>
                        <tr class="light">
                            <th scope="col">Id</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($slider != null) {
                            foreach ($slider as $row) {
                                if ($row['role'] == 3) {
                        ?>
                                <?php
                                $userStatus = $row['status'];
                                $userClass = ($userStatus == 1) ? 'user-info' : ''; ?>
                                <tr class="light">
                                    <td><?php echo $row['user_id']; ?></td>
                                    <?php 
// trạng thái hoạt động
                                                               date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                $dateString = strtotime($row['token_create_at']);
                                                                        $currentTime = time(); 
                                                                   $time = ($currentTime  -   $dateString)/60;
                                                                
                                                                    if($row['token']!=''&& $time <= 1){ ?>
                                                                         <td><i class="fa-solid fa-circle" style="color:lawngreen"></i><?php echo $row['email']; ?></td>
                                                                       <?php }elseif($row['token']!=''&& $time > 1){ ?>
                                                                        <td><i class="fa-solid fa-circle" style="color:red"></i><?php echo $row['email']; ?></td>
                                                                    <?php }else{?>
                                                                       <td><i class="fa-solid fa-circle" style="color:gray"></i><?php echo $row['email']; ?></td> 
                                                                        <?php } ?>
                                    
                                    <td><?php echo $row['phone']; ?> </td>   
                                    <td><?php echo $row['Type']; ?> </td> 
                                    <td>
                                        <!-- <a href="admin-edit.php?id=<?php echo $row['user_id']; ?>" class="btn btn-outline-primary"><i class="uil uil-edit"></i></a>
                                        <a onclick="return confirm('Do you want to delete this user?');" href="admin-delete.php?id=<?php echo $row['user_id']; ?>" class="btn btn-outline-danger"><i class="uil uil-trash-alt"></i></a> -->
                                        <a href="admin-view.php?id=<?php echo $row['user_id']; ?>" class="btn btn-outline-success"><i class="uil uil-eye"></i></a>
                                    </td>
                                    <td>
                                        <?php
                                        $newStatus = ($userStatus == 1) ? 0 : 1; // Toggles the status
                                        $statusText = ($userStatus == 1) ? 'Inactive' : 'Active'; // Text for status
                                        ?>
                                            <a href="admin-status.php?id=<?php echo $row['user_id']; ?>&status=<?php echo $newStatus; ?>" class="btn btn-outline-danger">
                                                <?php echo $statusText; ?>
                                            </a>
                                        
                                    </td>

                                </tr>
                            <?php
                            }
                        }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" style="color: red;">No records found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>



        <script src="script.js"></script>
</body>

</html>