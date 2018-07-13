<?php
    require_once ('./inc/header.php');

    $page = "Signup";

    if ($_POST)
    {
        // check username
        if (!empty ($_POST['username']))
        {
            $username_verif = preg_match ('#^[a-zA-Z0-9-._]{3,20}$#', $_POST['username']);
            // function preg_match () allows me to check what info will be be allowed in a result. It takes 2 arguments: REGEX + the result to check. At the end, I will have a TRUE or FALSE condition

            if (!$username_verif)
            {
                $msg_error = "<div class=\"alert alert-danger\">
                    Your username should countain letters (upper/lower) and numbers. It should be between 3 and 20 characters and only '.' and '_' are accepted. Please try again !
                </div>";
            }
        }
        else 
        {
            $msg_error = "<div class=\"alert alert-danger\">
                    Please enter a valid username.
                </div>";
        }

        // check password
        if (!empty ($_POST['password']))
        {
            $password_verif = preg_match ('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'\?$@%_])([-+!*\?$\'@%_\w]{6,15})$#', $_POST['password']);
            // it means we ask between 6 to 15 characters + 1 UPPER + 1 LOWER + 1 number + 1 symbol

            if (!$password_verif)
            {
                $msg_error = "<div class=\"alert alert-danger\">
                    Your password should countain between 6 and 15 characters with at least 1 uppercase, 1 lowercase, 1 number and 1 symbol.
                </div>";
            }
        }
        else 
        {
            $msg_error = "<div class=\"alert alert-danger\">
                    Please enter a valid password.
                </div>";
        }

        // check email
        if (!empty ($_POST['email']))
        {
            $email_verif = filter_var ($_POST['email'], FILTER_VALIDATE_EMAIL); // function filter_var () allows us to check a result (STR -> email, URL ...). It takes 2 arguments: the result to check + the method. It returns a BOOLEAN

            $forbidden_mails = [
                'mailinator.com',
                'yopmail.com',
                'mail.com'
            ];

            $email_domain = explode ('@', $_POST['email']); // function explode() allows me to explode a result into 2 parts regarding the element I've chosen

            // debug ($email_domain);

            if (!$email_verif || in_array ($email_domain[1], $forbidden_mails))
            {
                $msg_error = "<div class=\"alert alert-danger\">
                    Your email should countain between 6 and 15 characters with at least 1 uppercase, 1 lowercase, 1 number and 1 symbol.
                </div>";
            }
        }
        else 
        {
            $msg_error = "<div class=\"alert alert-danger\">
                    Please enter a valid email.
                </div>";
        }

        if (!isset ($_POST['gender']) || ($_POST['gender'] != 'm' && $_POST['gender'] != 'f' && $_POST['gender'] != 'o'))
        {
            $msg_error = "<div class=\"alert alert-danger\">
                    Choose a valid gender.
                </div>";
        }

        // OTHER CHECKS POSSIBLE

        if (empty ($msg_error))
        {
            // check if username is free
            $res = $con->prepare ("SELECT username FROM user WHERE username = :username");
            
            $res->bindValue (':username', $_POST['username'], PDO::PARAM_STR);

            $res->execute ();

            if ($res->rowCount () == 1)
            {
                $msg_error = "<div class=\"alert alert-danger\">
                    The username " . $_POST['username'] ." is already taken, please choose another one.
                </div>";
            }
            else 
            {
                $res = $con->prepare ("INSERT INTO user (username, password, firstname, lastname, email, gender, city, zip_code, address, privilege) VALUES (:username, :password, :firstname, :lastname, :email, :gender, :city, :zip_code, :address, 0)");

                $hashed_pass = password_hash ($_POST['password'], PASSWORD_BCRYPT); // function password_has () allows us to encrypt the password in a much secure way than md5. It takes 2 arguments: the result to hash, the method

                $res->bindValue (':username', $_POST['username'], PDO::PARAM_STR);
                $res->bindValue (':firstname', $_POST['firstname'], PDO::PARAM_STR);
                $res->bindValue (':lastname', $_POST['lastname'], PDO::PARAM_STR);
                $res->bindValue (':email', $_POST['email'], PDO::PARAM_STR);
                $res->bindValue (':gender', $_POST['gender'], PDO::PARAM_STR);
                $res->bindValue (':city', $_POST['city'], PDO::PARAM_STR);
                $res->bindValue (':address', $_POST['address'], PDO::PARAM_STR);
                $res->bindValue (':zip_code', $_POST['zip_code'], PDO::PARAM_STR);

                $res->bindValue (':password', $hashed_pass, PDO::PARAM_STR);

                if ($res->execute ())
                {
                    header ('location:login.php');
                }

            }
        }
    }

    // Reload the values entered by the user if problem during the page reloading
    $username = (isset ($_POST['username'])) ? $_POST['username'] : '';
    $firstname = (isset ($_POST['firstname'])) ? $_POST['firstname'] : ''; 
    $lastname = (isset ($_POST['lastname'])) ? $_POST['lastname'] : ''; 
    $email = (isset ($_POST['email'])) ? $_POST['email'] : '';
    $address = (isset ($_POST['address'])) ? $_POST['address'] : ''; 
    $zip_code = (isset ($_POST['zip_code'])) ? $_POST['zip_code'] : '';
    $city = (isset ($_POST['city'])) ? $_POST['city'] : '';

?>

    <h1><?= $page ?></h1>
    
    <form action="" method="post">
    
        <?= $msg_error ?>

        <div class="form-group">
            <small class="form-text text-muted">
                We will never use your datas for commercial use.
            </small>

            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="Choose a username..." value="<?= $username ?>">
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Choose a password...">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="firstname" placeholder="Your firstname..." value="<?= $firstname ?>">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="lastname" placeholder="Your lastname..." value="<?= $lastname ?>">
            </div>

            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Your email..." value="<?= $email ?>">
            </div>

            <div class="form-group">
                <select class="form-control" name="gender">
                    <option value="" disabled selected>Choose your gender...</option>
                    <option value="m">Men</option>
                    <option value="f">Women</option>
                    <option value="o">Other</option>
                </select>
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="address" placeholder="Your Address..." value="<?= $address ?>">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="zip_code" placeholder="Your zip code..." value="<?= $zip_code ?>">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="city" placeholder="Your city..." value="<?= $city ?>">
            </div>

            <input class="btn btn-success" type="submit" value="Send">
        </div>
    </form>

<?php 
    require_once ('./inc/footer.php');
?>