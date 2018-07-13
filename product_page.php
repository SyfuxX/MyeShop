<?php
    require_once ('./inc/header.php');

    if (isset ($_GET['id']) && !empty ($_GET['id']) && is_numeric ($_GET['id']))
    {
        $res = $con->prepare ("SELECT * FROM product WHERE id_product = :id_product");

        $res->bindValue (':id_product', $_GET['id'], PDO::PARAM_INT);

        $res->execute ();

        if ($res->rowCount () == 1)
        {
            $product_details = $res->fetch ();

            extract ($product_details);
        }
        else
        {   
            header ('location: eshop.php?m=error');
        }
    }
    else
    {   
        header ('location: eshop.php?m=error');
    }

    $page = "$title";
?>

    <h1><?= $page ?></h1>

    <img src="uploads/img/<?= $picture ?>" alt="<?= $title ?>" style="width: 20%;">


    <p>Product Details</p>
    <ul>
        <li>Reference: <strong><?= $reference ?></strong></li>
        <li>Category: <strong><?= $category ?></strong></li>
        <li>Color: <strong><?= $color ?></strong></li>
        <li>Size: <strong><?= $size ?></strong></li>
        <li>Gender: <strong><?= $gender ?></strong></li>
        <li>Price: <strong stlye="color: darkblue;"><?= $price ?> €</strong><br><em>all taxes includes</em></li>
    </ul>
    

<?php 
    require_once ('./inc/footer.php');
?>