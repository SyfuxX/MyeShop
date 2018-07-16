<?php
    require_once ('./inc/header.php');
    $page = "Profile";

    if (!isConnect ())
    {
        header ('./login.php');
    }

    /*
        Order status
    */
    /*
    $uid = $_SESSION['user']['id_user'];
    $query = "SELECT * FROM user WHERE id_user = :id";
    $result = $con->prepare($query);
    $result->bindValue("id", $uid, PDO::PARAM_STR);
    $result->execute();

    foreach($result->fetchAll() as $row)
    {    
        //echo '<div class="order">$row["order_status"]</div>';
        echo $row[username];
    }
    */

    /*
        Messages
    */
    if (isset ($_GET['m']) && $_GET['m'] == 'fail')
    {
        $msg_error = "<div class='alert alert-danger'>
            Something went wrong, please contact our admin...
        </div>";
    }

    /*
        Delete user
    */
    if (isset ($_GET['id']) && isset ($_GET['action']) && !empty ($_GET['id']) && !empty ($_GET['action']) && is_numeric ($_GET['id']) && $_GET['action'] == 'delete')
    {
        // show yes or cancel ?>
        <div style="position: absolute; width: 75%;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete account</h5>
                        <a href="./profile.php" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to leave our store? :c</p>
                    </div>
                    <div class="modal-footer">
                        <form action="" method="POST">
                            <input name="btn-delete" type="submit" value="Yes" class="btn btn-danger">
                            <a href="./profile.php" class="btn btn-success">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // if yes was pressed
        if (isset ($_POST['btn-delete']))
        {   
            $id_user = $_SESSION['user']['id_user'];

            $del = $con->exec ("DELETE FROM user WHERE id_user = $id_user");

            if ($del)
            {
                // successfully deleted
                header ('location: ./logout.php');
            }
            else
            {
                header ('location: ./profile.php?m=fail');
            }
            
        }
    }
    
    // ADD PROFILE PICTURE 
    
    if (!empty($_FILES['profile_pic']["name"])) {

        $picture_name = $_SESSION["user"]["username"] . '_ ' . '_' . time() . '_' . rand(1, 999) . '_' . $_FILES['profile_pic']['name'];
        $picture_name = str_replace(' ', '-', $picture_name);

            // we register the path of my file
        $picture_path = ROOT_TREE . 'uploads/profile_pictures/' . $picture_name;

        $max_size = 2000000;

        if ($_FILES['profile_pic']['size'] > $max_size || empty($_FILES['profile_pic']['size'])) {
            $msg_error = '<div class="alert alert-danger">
                    Please select a 2MB file maximum !
                </div>';
        }

        $type_picture = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($_FILES['profile_pic']['type'], $type_picture) || empty($_FILES['profile_pic']['type'])) {
            $msg_error = '<div class="alert alert-danger">
                    Please select a JPEG/JPG, a PNG or a GIF file.
                </div>';
        } else {

            $query = "UPDATE user SET picture = :picture WHERE id_user = :id_user";
            $result = $con->prepare($query);
            $result->bindValue(":id_user", $_SESSION['user']['id_user'], PDO::PARAM_STR);
            $result->bindValue(":picture", $picture_name, PDO::PARAM_STR);
            if ($result->execute()) // if request was inserted in the DTB
            {
                if (!empty($_FILES['profile_pic']['name'])) {
                    copy($_FILES['profile_pic']['tmp_name'], $picture_path);
                    $_SESSION["user"]["picture"] = $picture_name;
                    header("location: profile.php");
                }
            }
        }
    }

    // Display picture

    $path = 'uploads/profile_pictures/';
    $image = $_SESSION["user"]["picture"];
    $picture = "<img src='" . $path . $image . "'alt='image'>";

    // ADD PROFILE PICTURE 
    
    if (!empty($_FILES['profile_pic']["name"])) {

        $picture_name = $_SESSION["user"]["username"] . '_ ' . '_' . time() . '_' . rand(1, 999) . '_' . $_FILES['profile_pic']['name'];
        $picture_name = str_replace(' ', '-', $picture_name);

		// we register the path of my file
        $picture_path = ROOT_TREE . 'uploads/profile_pictures/' . $picture_name;

        $max_size = 2000000;

        if ($_FILES['profile_pic']['size'] > $max_size || empty($_FILES['profile_pic']['size'])) {
            $msg_error = '<div class="alert alert-danger">
                    Please select a 2MB file maximum !
                </div>';
        }

        $type_picture = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($_FILES['profile_pic']['type'], $type_picture) || empty($_FILES['profile_pic']['type'])) {
            $msg_error = '<div class="alert alert-danger">
                    Please select a JPEG/JPG, a PNG or a GIF file.
                </div>';
        } else {

            $query = "UPDATE user SET picture = :picture WHERE id_user = :id_user";
            $result = $con->prepare($query);
            $result->bindValue(":id_user", $_SESSION['user']['id_user'], PDO::PARAM_STR);
            $result->bindValue(":picture", $picture_name, PDO::PARAM_STR);
            if ($result->execute()) // if request was inserted in the DTB
            {
                if (!empty($_FILES['profile_pic']['name'])) {
                    copy($_FILES['profile_pic']['tmp_name'], $picture_path);
                    $_SESSION["user"]["picture"] = $picture_name;
                    header("location: profile.php");
                }
            }
        }
    }

    // Display picture

    $path = 'uploads/profile_pictures/';
    $image = $_SESSION["user"]["picture"];
    $picture = "<img src='" . $path . $image . "'alt='image' style='height: 250px'>";

    /*
        Get order history/list
    */
    // pending orders
    $req = $con->prepare ("SELECT * FROM `order` WHERE id_user = :id_user AND status = :status");
    $req->bindValue (':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
    $req->bindValue (':status', 'pending', PDO::PARAM_STR);
    $req->execute ();

    $pending = $req->rowCount ();

    // orders sent
    $req = $con->prepare ("SELECT * FROM `order` WHERE id_user = :id_user AND status = :status");
    $req->bindValue (':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
    $req->bindValue (':status', 'sent', PDO::PARAM_STR);
    $req->execute ();

    $sent = $req->rowCount ();

    // cancelled orders
    $req = $con->prepare ("SELECT * FROM `order` WHERE id_user = :id_user AND status = :status");
    $req->bindValue (':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
    $req->bindValue (':status', 'cancelled', PDO::PARAM_STR);
    $req->execute ();

    $cancelled = $req->rowCount ();

    // delivered orders
    $req = $con->prepare ("SELECT * FROM `order` WHERE id_user = :id_user AND status = :status");
    $req->bindValue (':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
    $req->bindValue (':status', 'delivered', PDO::PARAM_STR);
    $req->execute ();

    $delivered = $req->rowCount ();

?>

    <h1><?= $page ?></h1>

    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profile_pic">Choose a profile picture</label>
                <input class="btn btn-primary form-control-file" type="file" name="profile_pic" id="profile_pic">
            </div>
            <input class="btn btn-primary" type="submit" value="Upload picture">
        </form>
    </div>
    
    <h4>Please find your informations below:</h4>

    <?= $msg_error?>

    <div class="row">
        <div class="col-sm-6">

            <div class="card" style="width: 20rem;">
                <img class="card-img-top" src="./uploads/img/<?= $_SESSION['user']['picture']; ?>" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title"><?= $_SESSION['user']['username']; ?></h3>

                    <p class="card-text">
                        Get informations about your profile and also be able to edit or delete your profile.
                    </p>
                </div>

                <div class="card-body">
                    <h6 class="card-title">Personal:</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Firstname: <strong><?= $_SESSION['user']['firstname']; ?></strong></li>
                    <li class="list-group-item">Lastname: <strong><?= $_SESSION['user']['lastname']; ?></strong></li>
                    <li class="list-group-item">Gender: <strong><?php if ($_SESSION['user']['gender'] == 'm') { echo 'Male'; } else if ($_SESSION['user']['gender'] == 'f') { echo 'Women'; } else if ($_SESSION['user']['gender'] == 'o') { echo 'Other'; } ?></strong></li>
                    <li class="list-group-item">Email: <strong><?= $_SESSION['user']['email']; ?></strong></li>
                </ul>

                <div class="card-body">
                    <h6 class="card-title">Address:</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Street: <strong><?= $_SESSION['user']['address']; ?></strong></li>
                    <li class="list-group-item">Zip-code: <strong><?= $_SESSION['user']['zip_code']; ?></strong></li>
                    <li class="list-group-item">City: <strong><?= $_SESSION['user']['city']; ?></strong></li>
                </ul>

                <div class="card-body">
                    <h6 class="card-title">Profile actions:</h6>
                    <a href="./profile_settings.php" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                    <a href="./logout.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <a href="?id=<?= $_SESSION['user']['id_user'] ?>&action=delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                </div>
            </div>

    <div class="row">
        <div class="col-sm-6">

            <div class="card" style="width: 20rem;">
                <img class="card-img-top" src="./uploads/profile_pictures/<?= $_SESSION['user']['picture']; ?>" alt="Card image cap">

                <div class="card-body">
                    <h3 class="card-title"><?= $_SESSION['user']['username']; ?></h3>

                    <p class="card-text">
                        Get informations about your profile and also be able to edit or delete your profile.
                    </p>
                </div>

                <div class="card-body">
                    <h6 class="card-title">Personal:</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Firstname: <strong><?= $_SESSION['user']['firstname']; ?></strong></li>
                    <li class="list-group-item">Lastname: <strong><?= $_SESSION['user']['lastname']; ?></strong></li>
                    <li class="list-group-item">Gender: <strong><?php if ($_SESSION['user']['gender'] == 'm') { echo 'Male'; } else if ($_SESSION['user']['gender'] == 'f') { echo 'Women'; } else if ($_SESSION['user']['gender'] == 'o') { echo 'Other'; } ?></strong></li>
                    <li class="list-group-item">Email: <strong><?= $_SESSION['user']['email']; ?></strong></li>
                </ul>

                <div class="card-body">
                    <h6 class="card-title">Address:</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Street: <strong><?= $_SESSION['user']['address']; ?></strong></li>
                    <li class="list-group-item">Zip-code: <strong><?= $_SESSION['user']['zip_code']; ?></strong></li>
                    <li class="list-group-item">City: <strong><?= $_SESSION['user']['city']; ?></strong></li>
                </ul>

                <div class="card-body">
                    <h6 class="card-title">Profile actions:</h6>
                    <a href="./profile_settings.php" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                    <a href="./logout.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <a href="?id=<?= $_SESSION['user']['id_user'] ?>&action=delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="card" style="width: 20rem;">
                
                <div class="card-body">
                    <h3 class="card-title">Order list</h3>

                    <p class="card-text">
                        All informations about your order history/list in one view.
                    </p>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Orders pending: <strong><?= $pending ?></strong></li>
                    <li class="list-group-item">Orders sent: <strong><?= $sent ?></strong></li>
                    <li class="list-group-item">Orders cancelled: <strong><?= $cancelled ?></strong></li>
                    <li class="list-group-item">Orders delivered: <strong><?= $delivered ?></strong></li>
                </ul>

                <div class="card-body">
                    <h6 class="card-title">Orders action:</h6>
                    <a href="./order_list.php" class="btn btn-success"><i class="fas fa-eye"></i> Show list</a>
                </div>
            </div>
        </div>
    </div>

<?php 
    require_once ('./inc/footer.php');
?>
