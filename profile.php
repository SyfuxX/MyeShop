<?php
    require_once ('./inc/header.php');

    $page = "Profile";

    if (!isConnect ())
    {
        header ('./login.php');
    }

?>

    <h1><?= $page ?></h1>
    
    <p>Please find your informations below:</p>

    <ul>
        <li>Firstname: <?= $_SESSION['user']['firstname']; ?></li>
        <li>Lastname: <?= $_SESSION['user']['lastname']; ?></li>
        <li>Email: <?= $_SESSION['user']['email']; ?></li>
    </ul>

<?php 
    require_once ('./inc/footer.php');
?>