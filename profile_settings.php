<?php

require_once ('./inc/header.php');

    $page = "Profile Settings";

    if (!isConnect ()) {

        header ('./login.php');
    }

    // explode $_GET 
    // 
    // display existing adress, pseudo
    // 

    // useful functions: rowCount (), $forbidden_mails, password_hash ($_POST['password'], PASSWORD_BCRYPT);

    // on account settings check for $_SESSIOn creation date if > 1 day, ask for new login new login will send to account_settings
      
    /// IMPORTANT DO UPDATE THE $_SESSION AFTER EACH CHANGE

    if(isset($_SESSION) && !empty($_SESSION)) {

        
        $req = "SELECT * FROM user WHERE username = :pseudo AND email = :email";
        $result = $con->prepare($req);  
        $result->bindValue(":pseudo", $_SESSION["user"]["username"], PDO::PARAM_STR);
        $result->bindValue(":email", $_SESSION["user"]["email"], PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch ();

        // debug($result->rowCount());

        if($result->rowCount() == 1) {

            //debug($_POST);
        
        

        // write UPDATE so i can bind every value based on what needs to be changed


            if(isset($_POST) && !empty($_POST)) {

                // CHANGE EMAIL
                if (!empty ($_POST['email']) && !empty ($_POST['rEmail'])) {

                    $email_verif = filter_var ($_POST['email'], FILTER_VALIDATE_EMAIL); 

                    $forbidden_mails = [
                        'mailinator.com',
                        'yopmail.com',
                        'mail.com'
                    ];

                    $email_domain = explode ('@', $_POST['email']); 


                    if (!$email_verif || in_array ($email_domain[1], $forbidden_mails)) {

                        $msg_error = "<div class=\"alert alert-danger\">
                            Please enter a valid email.
                        </div>";
                    }
                    else if($_POST['email'] != $_POST['rEmail']) {

                        $msg_error = "<div class=\"alert alert-danger\">
                            The emails you entered are not the same, please try again.
                        </div>";
                    }
                    else {

                        $req_email = "UPDATE user SET email = :email WHERE id_user = :id_user";
                        $result_email = $con->prepare($req_email);
                        $result_email->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
                        $result_email->bindValue(":id_user", $_SESSION["user"]["id_user"]);
                        $result_email->execute();
                        if($result_email) {

                            $_SESSION["user"]["email"] = $_POST['email'];
                        }
                    }
                }

                // CHANGE PASSWORD (only tests done)
                if (!empty ($_POST['password']) && !empty ($_POST['nPassword']) && !empty ($_POST['rPassword'])) {
                    
                    $password_verif = preg_match ('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'\?$@%_])([-+!*\?$\'@%_\w]{6,15})$#', $_POST['nPassword']);
            
                    if (!$password_verif) {
                        $msg_error = "<div class=\"alert alert-danger\">
                            Your password should countain between 6 and 15 characters with at least 1 uppercase, 1 lowercase, 1 number and 1 symbol.
                        </div>";
                    }
                    else {
                        if(password_verify($_POST['password'], $user['password']) && $_POST['nPassword'] == $_POST['rPassword']) {

                            $hashed_pass = password_hash ($_POST['nPassword'], PASSWORD_BCRYPT);
                            $req = "UPDATE user SET password = :password WHERE id_user = $user[id_user]";
                            $result_password = $con->prepare($con);
                            $result_password->bindValue(":password", $hashed_pass, PDO::PARAM_STR);

                        }
                        else {
                            $msg_error = "<div class=\"alert alert-danger\">
                            Some of the information could not be verified, please try again!
                            </div>";
                        }
                        // $req = "SELECT * FROM user WHERE username = :username AND password = :passwordx";
                        // $result = $con->prepare($req);
                        // $result->bindValue(":username", $_SESSION["user"]["username"]);
                        // $result->bindValue(":passwordx", $_POST["password"]);
                        // $result->execute();
                    }

                    
                }

                if(isset($_POST["pseudo"]) && !empty($_POST["pseudo"]) && isset($_POST["rPseudo"]) && !empty($_POST["rPseudo"])) {

                    if($_POST["pseudo"] == $_POST["rPseudo"]) {

                        $req_username = "UPDATE user SET username = :username WHERE id_user = :id_user";
                        $result_username = $con->prepare($req_username);
                        $result_username->bindValue(":username", $_POST['rPseudo'], PDO::PARAM_STR);
                        $result_username->bindValue(":id_user", $_SESSION["user"]["id_user"]);
                        $result_username->execute();
                    } else {

                        $msg_error = "<div class=\"alert alert-danger\">
                               Usernames do not check out!
                            </div>";
                    }
                    
                    if ($result_username) {

                        $_SESSION["user"]["username"] = $_POST['rPseudo'];
                    }
                }

                if(isset($_POST["address"]) && !empty($_POST["address"]) && isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["Zip-Code"]) && !empty($_POST["Zip-Code"])) {

                    $req_address = "UPDATE user SET address = :address, city = :city, zip_code = :zp WHERE id_user = :id_user";
                    $result_address = $con->prepare($req_address);
                    $result_address->bindValue(":address", $_POST['address'], PDO::PARAM_STR);
                    $result_address->bindValue(":city", $_POST['city'], PDO::PARAM_STR);
                    $result_address->bindValue(":city", $_POST['city'], PDO::PARAM_STR);
                    $result_address->bindValue(":zp", $_POST['Zip-Code'], PDO::PARAM_STR);
                    $result_address->bindValue(":address", $_POST['address'], PDO::PARAM_STR);
                    $result_address->bindValue(":id_user", $_SESSION["user"]["id_user"]);
                    $result_address->execute();
                    if($result_address) {

                        $_SESSION["user"]["address"] = $_POST['address'];
                        $_SESSION["user"]["city"] = $_POST['city'];
                        $_SESSION["user"]["zip_code"] = $_POST['Zip-Code'];
                    }
                    else {

                        $msg_error = "<div class=\"alert alert-danger\">
                              Error updating address. Please try again later!
                            </div>";
                    }
                }
            }
        }
    }
    else {

        header("location:login.php");
    }
    
  

?>
<?= $msg_error ?>
 <!-- CHANGE ACCOUNT INFORMATION -->

 <!-- EMAIL -->
 <h3>Change your email adress</h3>
<form method="post">
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="rEmail">Retype email adress</label>
    <input type="email" id="rEmail" name="rEmail" class="form-control"placeholder="Retype Email">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- PASSWORD -->
<!-- hash new password 
    check old one before submiting
-->

<hr>
<h3>Change your password</h3>
<form method="post">
  <div class="form-group">
    <label for="password">Old Password</label>
    <input type="password" id="password" name="password"  class="form-control" placeholder="Enter old password">
  </div>
  <div class="form-group">
    <label for="nPassword">New Password</label>
    <input type="text" class="form-control" id="nPassword" name="nPassword"  placeholder="Enter new password">
  </div>
  <div class="form-group">
    <label for="rPassword">Re-type New Password</label>
    <input type="text" class="form-control" id="rPassword" name="rPassword"  placeholder="Retype old password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- PSEUDO -->
<hr>
 <h3>Change your username</h3>
<form method="post">
  <div class="form-group">
    <label for="pseudo">Username</label>
    <input type="text"  id="pseudo" name="pseudo" class="form-control" placeholder="Enter Pseudo">
  </div>
  <div class="form-group">
    <label for="rPseudo">Retype new username</label>
    <input type="text" id="rPseudo" name="rPseudo"  class="form-control" placeholder="Retype Pseudo">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>





<!-- ADRESS -->
<hr>
<h3>Change your address</h3>
<form method="post">
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" id="address"  name="address" class="form-control" placeholder="Enter street">
  </div>
  <div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" id="city" name="city"  placeholder="Enter city">
  </div>
  <div class="form-group">
    <label for="Zip-Code">Zip-Code</label>
    <input type="text" class="form-control" id="Zip-Code" name="Zip-Code"  placeholder="Enter old Zip-Code">
  </div>
  <button type="submit" class="btn btn-primary" style="margin-bottom: 2rem; ">Submit</button>
</form>





<?php 
    require_once ('./inc/footer.php');
?>