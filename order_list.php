<?php
    require_once ('./inc/header.php');

    $page = "Order list";

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
    
    <div class="accordion" id="accordionExample">

        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Orders pending: <?= $pending ?>
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Orders sent: <?= $sent ?>
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Orders cancelled: <?= $cancelled ?>
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Orders delivered: <?= $delivered ?>
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>

<?php 
    require_once ('./inc/footer.php');
?>