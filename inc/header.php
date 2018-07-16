<?php require_once ('./inc/init.php'); ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>Starter Template for Bootstrap</title>

        <!-- Bootstrap core CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="./css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    </head>

    <body>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="<?= URL ?>">MyEshop.com</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>eshop.php">eShop</a>
                    </li>

                    <?php if (!isConnect ()) : ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Connect</a>

                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?= URL ?>login.php">Login</a>
                            <a class="dropdown-item" href="<?= URL ?>signup.php">Signup</a>
                        </div>
                    </li>

                    <?php else : ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hello <?= $_SESSION['user']['username']; ?></a>

                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= URL ?>profile.php">Profile</a>
                            <a class="dropdown-item" href="<?= URL ?>profile_settings.php">Settings</a>
                            <a class="dropdown-item" href="<?= URL ?>logout.php">Logout</a>
                        </div>
                    </li>

                    <?php endif; ?>
                    <?php if (isAdmin ()) : ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>admin/">Admin Panel</a>
                    </li>

                    <?php endif; ?>

                    <li>
                        <a class="nav-link" href="<?=URL?>cart.php"><i class="fas fa-shopping-cart"></i><?php if(productNumber()){echo'<span class="bubble">' . productNumber() . '</span>';} ?></a>
                    </li>

                </ul>

                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <main role="main" class="container">