<?php 

require_once('../inc/init.php');

if (!isAdmin()) {
  header('location:' . URL . 'index.php');
  exit();
}

if (isset($_GET['a']) && $_GET['a'] == 'logout') {
  unset($_SESSION['user']);
  header('location: ' . URL . 'index.php');
  exit();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">


  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= URL ?>">MyEshop.com</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="?a=logout">Sign out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="./product_list.php">
                  <span></span>
                  Dashboard
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="./product_form.php">
                  Add a product
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="./users_list.php">
                  <span></span>
                  User list
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./order_list.php">
                  <span></span>
                  Order list
                </a>
              </li>

            </ul>

          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">