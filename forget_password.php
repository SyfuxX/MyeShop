<?php
    require_once ('./inc/header.php');

    $page = "Password reset request";

    /*
        Messages
    */
    if (isset ($_GET['m']) && !empty ($_GET['m']))
    {
        switch ($_GET['m'])
        {
            case 'changed';
                $msg_error = "<div class='alert alert-success'>
                    Password has successfully updated !
                </div>";
            break;
            default:
                $msg_error = "<div class='alert alert-danger'>
                    Invalid request !
                </div>";
            break;
        }
    }

    if ($_POST)
    {
        // if button 'send email' was pressed
        if (isset ($_POST['btn-forget-password']))
        {
            
            // check if there this username exist in the DTB
            // if not check if the email exist in the DTB
            $req = $con->prepare ("SELECT id_user, email FROM user WHERE username = :username OR email = :email");
            $req->bindValue (':username', $_POST['userfield'], PDO::PARAM_STR);
            $req->bindValue (':email', $_POST['userfield'], PDO::PARAM_STR);

            $req->execute ();
            $check = $req->rowCount ();
            $res = $req->fetch ();
            
            
            if ($check == 1)
            {
                // if email was found
                // generate a md5 key
                $key = md5 (rand (000, 999999));

                // insert the key into the database
                $req = $con->prepare ("INSERT INTO reset_request (id_user, `key`) VALUES (:id_user, :key)");
                $req->bindValue (':id_user', $res['id_user'], PDO::PARAM_INT);
                $req->bindValue (':key', $key, PDO::PARAM_STR);
                $result = $req->execute ();

                if ($result)
                {
                    // if succefully inserted into the DTB
                    // send a mail to the user
                    $to = $res['email'];
                    $subject = 'Password reset request';
                    $message = "<html>
                    <head>
                    
                        <title>Password reset request</title>

                    </head>
                    <body>

                        <h1>Password reset</h1>

                        <p>Please click on the following link to reset your password:</p>

                        <a href='". URL ."/forget_password.php?id=". $res['id'] ."&key=". $key ."'></a>

                    </body>
                    </html>";
                    $header = "From: noreply@myeshop.com" . "\r\n";
                    $header .= "MIME-Version: 1.0" . "\r\n";
                    $header .= "Content-type: text/html; charset=utf-8" . "\r\n";
                    $header .= "X-Mailer: PHP/" . phpversion ();
                    

                    $sendMail = mail ($to, $subject, $message, $header);

                    if ($sendMail)
                    {
                        // email successfully send
                        $msg_error = "<div class='alert alert-success'>
                            An email was successfully send !
                        </div>";
                    }
                    else
                    {
                        // there went something wrong...
                        $msg_error = "<div class='alert alert-danger'>
                            Something went wrong ... Contact the Admin, please !
                        </div>";
                    }
                }
                else
                {
                    $msg_error = "<div class='alert alert-danger'>
                        Something went wrong ... Contact the Admin, please !
                    </div>";
                }
            }
            else
            {
                // if email was not found by username or email
                $msg_error = "<div class='alert alert-success'>
                    An email was successfully send !
                </div>";
            }

        }

        // if password reset request
        if (isset ($_POST['btn-change-password']))
        {

            // check if password field is not empty
            if (!empty ($_POST['password']) && !empty ($_POST['password-re']))
            {

                // check if password is the same the second one
                if ($_POST['password'] == $_POST['password-re'])
                {
                    // password is the same
                    $password_verif = preg_match ('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'\?$@%_])([-+!*\?$\'@%_\w]{6,15})$#', $_POST['password']); // it means we ask between 6 to 15 characters + 1 UPPER + 1 LOWER + 1 number + 1 symbol

                    if (!$password_verif)
                    {
                        // if password verification was failed
                        $msg_error = "<div class='alert alert-danger'>
                            Your password should countain between 6 and 15 characters with at least 1 uppercase, 1 lowercase, 1 number and 1 symbol.
                        </div>";
                    }
                    else
                    {
                        // crypt password
                        $hashed_password = password_hash ($_POST['password'], PASSWORD_BCRYPT);

                        // update password
                        $req = $con->prepare ("UPDATE user SET password = :password WHERE id_user = :id_user");

                        $req->bindValue (':password', $hashed_password, PDO::PARAM_STR);
                        $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);

                        $check = $req->execute ();
                        
                        if ($check)
                        {
                            // if password got updated
                            // set status to 1
                            $req = $con->prepare ("UPDATE reset_request SET status = 1 WHERE id_user = :id_user");

                            $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);
                            $check = $req->execute ();

                            if ($check)
                            {
                                // if everything was successfully
                                header ('location: ./forget_password.php?m=changed');  
                            }
                            else 
                            {
                                // status can't updated
                                $msg_error = "<div class='alert alert-danger'>
                                    Something went wrong ...
                                </div>";
                            }

                        }
                        else
                        {
                            // password was not updated
                            $msg_error = "<div class='alert alert-danger'>
                                Something went wrong ...
                            </div>";
                        }

                    }
                }
                else 
                {
                    // password is not the same
                    $msg_error = "<div class='alert alert-danger'>
                        Both passwords need to match each other !
                    </div>";
                }
            
            }

        }

    }

?>

    <h1><?= $page ?></h1>

    <?= $msg_error ?>

    <?php // if password forget
    if (isset ($_GET['action']) && $_GET['action'] == 'forgetPassword' && !empyt ($_GET['action'])) : ?>
    
        <form action="" method="post">

            <?= $msg_error ?>
            
            <div class="form-group">
                <div class="form-group">
                    <input class="form-control" type="text" name="userfield" placeholder="Username or email...">
                </div>

                <input class="btn btn-success" name="btn-forget-password" type="submit" value="Send email">
            </div>
            
        </form>

    <?php elseif (isset ($_GET['id']) && isset ($_GET['key']) && !empty ($_GET['id']) && !empty ($_GET['key']) && is_numeric ($_GET['id'])) : 
    
    // check if the key and id is correct
    $req = $con->prepare ("SELECT * FROM reset_request WHERE id_user = :id_user");
    $req->bindValue (':id_user', $_GET['id'], PDO::PARAM_INT);
    $req->execute ();
    $check = $req->rowCount ();
    $res = $req->fetch ();

    if ($check == 1)
    {
        // if a row was found with this id_user
        // check if the key is the same as the key from the DTB
        if ($res['key'] == $_GET['key'])
        {
            // key is valid
            // check if the key is already used
            if ($res['status'] != 0)
            {
                // key is used
                $msg_error = "<div class='alert alert-danger'>
                    This is not a valid key !
                </div>";
            }

        }
        else
        {
            // key was not found
            $msg_error = "<div class='alert alert-danger'>
                This is not a valid key !
            </div>";
        }
    }
    else 
    {
        // if there is no row with this id
        $msg_error = "<div class='alert alert-danger'>
            This is not a valid key !
        </div>";
    }
    
    ?>

        <form action="" method="post">

            <?= $msg_error ?>
            
            <div class="form-group">
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Enter new password...">
                </div>

                <div class="form-group">
                    <input class="form-control" type="password" name="password-re" placeholder="Retype your password...">
                </div>

                <input class="btn btn-success" name="btn-change-password" type="submit" value="Change password">
            </div>
        
    </form>

    <?php endif; ?>

<?php 
    require_once ('./inc/footer.php');
?>