<?php
    require_once ('./inc/header.php');
    $page = "Profile";


    if (!isConnect ())
    {
        header ('./login.php');
    }

    /*
        Messages
    */
    if (isset ($_GET['m']) && $_GET['m'] == 'fail')
    {
        $msg_error = "<div class='alert alert-danger'>
            Something went wrong, please contact our admin...
        </div>";
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


    /*
        Delete user
    */
    if(isset ($_GET['id']) && isset ($_GET['action']) && !empty ($_GET['id']) && !empty ($_GET['action']) && is_numeric ($_GET['id']) && $_GET['action'] == 'delete')
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

    
    

?>

    <h1><?= $page ?></h1>

    <h2><?= $msg_error?></h2>

    <?= $picture ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_pic">Choose a profile picture</label>
            <input class="btn btn-primary form-control-file" type="file" name="profile_pic" id="profile_pic">
        </div>
        <input class="btn btn-primary"type="submit">
    </form>
    
    <p>Please find your informations below:</p>

    <ul>
        <li>Firstname: <?= $_SESSION['user']['firstname']; ?></li>
        <li>Lastname: <?= $_SESSION['user']['lastname']; ?></li>
        <li>Email: <?= $_SESSION['user']['email']; ?></li>
    </ul>

    <?= $msg_error; ?>

    <div class="border container">
        <div>
            <h2 class="text-center">Danger zone <span class="badge badge-danger">be carefully</span></h2>
        
            <a href="?id=<?= $_SESSION['user']['id_user'] ?>&action=delete" class="btn btn-danger">Delete account</a>
        </div>
    </div>

<?php 
    require_once ('./inc/footer.php');
?>