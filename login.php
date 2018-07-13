<?php
    require_once ('./inc/header.php');

    $page = "Login";

    if ($_POST)
    {
        $req = "SELECT * FROM user WHERE username = :username";

        $res = $con->prepare ($req);
        $res->bindValue (':username', $_POST['username'], PDO::PARAM_STR);

        $res->execute ();

        if ($res->rowCount () > 0) // if we select a iserma,e om the DTB
        {
            $user = $res->fetch ();

            if (password_verify ($_POST['password'], $user['password'])) // function password_verify () is link to password_hash (). It allows us to check the correspondance between 2 values: 1rst argument will be the value to check, 2nd argument will be the match value
            {
                foreach ($user as $key => $value)
                {
                    if ($key != 'password')
                    {
                        $_SESSION['user'][$key] = $value;

                        header ('location:profile.php');
                    }
                }
            }
            else 
            {
                $msg_error = "<div class=\"alert alert-danger\">
                    Identification error, please try again.
                </div>";
            }
        }
        else 
        {
            $msg_error = "<div class=\"alert alert-danger\">
                Identification error, please try again.
            </div>";
        }
    }

?>

    <h1><?= $page ?></h1>
    
    <form action="" method="post">
    
        <?= $msg_error ?>
        
        <div class="form-group">
            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="Your username...">
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Your password...">
            </div>

            <input class="btn btn-success" type="submit" value="Login">
        </div>
    </form>

<?php 
    require_once ('./inc/footer.php');
?>