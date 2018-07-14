<!-- The client want a page called “users_list.php” in the /admin/ folder. He wants to be able to manage users, change the privilege and all the others informations (Update). -->
<?php

require_once ('./inc/header.php'); 

if (isset ($_GET['m']))
{
    switch ($_GET['m']) 
    {
        case 'update':
            $msg_error = "<div class='alert alert-success'>
                User got updated...
            </div>";
        break;
        case 'delete':
            $msg_error = "<div class='alert alert-success'>
                User got successfully deleted !
            </div>";
        break;
        case 'fail':
            $msg_error = "<div class='alert alert-danger'>
                Something went wrong...
            </div>";
        break;
        default:
            $msg_error = "<div class='alert alert-danger'>
                Something went wrong...
            </div>";
        break;
    }
}

    // if update btn is triggered
if (isset ($_GET['id']) && $_GET['action'] == 'edit' && !empty ($_GET['id']) && is_numeric ($_GET['id']))
{

    $req = $con->prepare ("SELECT * FROM user WHERE id_user = :id_user");
    $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);

    $req->execute ();
    $result = $req->fetch ();

    if ($_POST)
    {
        if (isset ($_POST['update-user']))
        {
            $req = $con->prepare ("UPDATE user SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, gender = :gender, city = :city, zip_code = :zip_code, address = :address, privilege = :privilege WHERE id_user = :id_user");

            $req->bindValue (':username', $_POST['username'], PDO::PARAM_STR);
            $req->bindValue (':firstname', $_POST['firstname'], PDO::PARAM_STR);
            $req->bindValue (':lastname', $_POST['lastname'], PDO::PARAM_STR);
            $req->bindValue (':email', $_POST['email'], PDO::PARAM_STR);
            $req->bindValue (':gender', $_POST['gender'], PDO::PARAM_STR);
            $req->bindValue (':city', $_POST['city'], PDO::PARAM_STR);
            $req->bindValue (':zip_code', $_POST['zip_code'], PDO::PARAM_STR);
            $req->bindValue (':address', $_POST['address'], PDO::PARAM_STR);
            $req->bindValue (':privilege', $_POST['privilege'], PDO::PARAM_INT);

            $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);

            $req->execute ();

            if ($req)
            {
                header ('location: ./users_list.php?m=update');
            }
            else
            {
                header ('location: ./users_list.php?m=fail');
            }
        }
    }
    ?>

    <!-- EDIT FORM -->
    <div id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="position: absolute; width: 75%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update user</h5>
                    <a class="close" href="./users_list.php">
                        <span aria-hidden="true">&times;</span>
                    </a>    
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username" value="<?= $result['username']; ?>" name="username">
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-form-label">Firstname:</label>
                            <input type="text" class="form-control" id="firstname" value="<?= $result['firstname']; ?>" name="firstname">
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="col-form-label">Lastname:</label>
                            <input type="text" class="form-control" id="lastname" value="<?= $result['lastname']; ?>" name="lastname">
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="email" value="<?= $result['email']; ?>" name="email">
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-form-label">Gender:</label>
                            <select id="gender" class="form-control" name="gender">
                                <option disabled selected hidden>Choose a gender..</option>
                                <option value="m" <?php if ($result['gender'] == 'm') { echo 'selected'; } ?>>Men</option>
                                <option value="f" <?php if ($result['gender'] == 'f') { echo 'selected'; } ?>>Women</option>
                                <option value="o" <?php if ($result['gender'] == 'o') { echo 'selected'; } ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city" class="col-form-label">City:</label>
                            <input type="text" class="form-control" id="city" value="<?= $result['city']; ?>" name="city">
                        </div>

                        <div class="form-group">
                            <label for="zip_code" class="col-form-label">Zip code:</label>
                            <input type="text" class="form-control" id="zip_code" value="<?= $result['zip_code']; ?>" name="zip_code">
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-form-label">Address:</label>
                            <input type="text" class="form-control" id="address" value="<?= $result['address']; ?>" name="address">
                        </div>

                        <div class="form-group">
                            <label for="privilege" class="col-form-label">Privilege:</label>
                            <input type="number" max="1" min="0" class="form-control" id="privilege" value="<?= $result['privilege']; ?>" name="privilege">
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-secondary" href="./users_list.php">Cancel</a>
                            <input type="submit" class="btn btn-primary" name="update-user" value="Update user">
                        </div>

                    </form>
                </div>                                        
            </div>
        </div>
    </div>

<?php 
}
// if delete btn is triggered
if (isset ($_GET['id']) && $_GET['action'] == 'delete' && !empty ($_GET['id']) && is_numeric ($_GET['id']))
{
    if ($_POST)
    {
        if (isset ($_POST['delete-user']))
        {
            $req = $con->prepare ("DELETE FROM user WHERE id_user = :id_user");
            $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);

            $del = $req->execute ();

            if ($del)
            {
                header ('location: ./users_list.php?m=delete');
            }
            else
            {
                header ('location: ./users_list.php?m=fail');
            }
        }
    }

    ?>
    <!-- DELETE FORM -->
    <div id="deleteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="position: absolute; width: 75%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this user ?</h5>
                    <a class="close" href="./users_list.php">
                        <span aria-hidden="true">&times;</span>
                    </a>  
                </div>
                <div class="modal-body">
                    <form method="post">

                        <a class="btn btn-success" href="./users_list.php">No</a>
                        <input type="submit" class="btn btn-danger" name="delete-user" value="Yes">

                    </form>
                </div>                                        
            </div>
        </div>
    </div>
    <?php
 
}

?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2">List of users</h1>

            </div>

            <?= $msg_error ?>

            <div style="overflow-y: scroll;">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">City</th>
                            <th scope="col">Zip code</th>
                            <th scope="col">Address</th>
                            <th scope="col">Privilege</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                            $req = $con->query ("SELECT * FROM user");
                            $res = $req->fetchAll (); ?>

                            <?php foreach ($res as $result)
                            {
            
                                echo '<tr>';
                                foreach ($result as $key => $value)
                                {
                                    
                                    if ($key != 'password')
                                    {
                                        echo "<td>$value</td>";
                                    }

                                }

                                echo "<td>
                                    <a href='?id=$result[id_user]&action=edit'>
                                        <i class=\"fas fa-pencil-alt\" style='color: blue;'></i>
                                    </a>
                                    <a href='?id=$result[id_user]&action=delete'>
                                        <i class=\"fas fa-trash-alt\" style='color: red;'></i>
                                    </a>
                                </td>";

                                echo '</tr>';                     

                            } 
                            ?>

                    </tbody>
                </table>
            </div>
          
        </main>
      </div>
    </div>

<?php require_once ('./inc/footer.php');
