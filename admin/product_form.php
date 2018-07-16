<?php 

require_once ('./inc/header.php'); 

if ($_POST)
{
    foreach ($_POST as $key => $value)
    {
        $_POST[$key] = addslashes ($value);
    }

    //debug ($_POST);
    //debug ($_FILES);

    if (!empty ($_FILES['product_picture']['name'])) // I'm checking if I got a result for the 1st picture
    {
        // I give a random name for my picture
        $picture_name = $_POST['title'] . '_ ' . $_POST['reference'] . '_' . time () . '_' . rand (1, 999) . '_' . $_FILES['product_picture']['name'];

        $picture_name = str_replace (' ', '-', $picture_name);

        // we register the path of my file
        $picture_path = ROOT_TREE . 'uploads/img/' . $picture_name;

        $max_size = 2000000;

        if ($_FILES['product_picture']['size'] > $max_size || empty ($_FILES['product_picture']['size']))
        {
            $msg_error = '<div class="alert alert-danger">
                Please select a 2MB file maximum !
            </div>';
        }

        $type_picture = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array ($_FILES['product_picture']['type'], $type_picture) || empty ($_FILES['product_picture']['type']))
        {
            $msg_error = '<div class="alert alert-danger">
                Please select a JPEG/JPG, a PNG or a GIF file.
            </div>';
        }
    }
    else if (isset ($_POST['actual_picture'])) // if I update a product, I target the new input created with my $update_product
    {
        $picture_name = $_POST['actual_picture'];
    }
    else 
    {
        $picture_name = 'default.jpg';
    }

    // OHTER CHECK POSSIBLE HERE

    if (empty ($msg_error)) 
    {
        if (!empty ($_POST['id_product'])) // we register the update
        {
            $res = $con->prepare ("UPDATE product SET reference = :reference, category = :category, title = :title, description = :description, color = :color, size = :size, gender = :gender, picture = :picture, picture2 = NULL, price = :price, stock = :stock WHERE id_product = :id_product");

            $res->bindValue (':id_product', $_POST['id_product'], PDO::PARAM_INT);
        }
        else // we register for the first tiem in the DTB
        {
            $res = $con->prepare ("INSERT INTO product (reference, category, title, description, color, size, gender, picture, picture2, price, stock) VALUES (:reference, :category, :title, :description, :color, :size, :gender, :picture, NULL, :price, :stock)");
        }        

        $res->bindValue (':reference', $_POST['reference'], PDO::PARAM_STR);
        $res->bindValue (':category', $_POST['category'], PDO::PARAM_STR);
        $res->bindValue (':title', $_POST['title'], PDO::PARAM_STR);
        $res->bindValue (':description', $_POST['description'], PDO::PARAM_STR);
        $res->bindValue (':color', $_POST['color'], PDO::PARAM_STR);
        $res->bindValue (':size', $_POST['size'], PDO::PARAM_STR);
        $res->bindValue (':gender', $_POST['gender'], PDO::PARAM_STR);
        $res->bindValue (':price', $_POST['price'], PDO::PARAM_STR);
        $res->bindValue (':stock', $_POST['stock'], PDO::PARAM_STR);

        $res->bindValue (':picture', $picture_name, PDO::PARAM_STR);

        if ($res->execute ()) // if request was inserted in the DTB
        {
            if (!empty ($_FILES['product_picture']['name']))
            {
                copy ($_FILES['product_picture']['tmp_name'], $picture_path);
            }
        }
    }
}

if (isset ($_GET['id']) && !empty ($_GET['id']) && is_numeric ($_GET['id']))
{
    $req = "SELECT * FROM product WHERE id_product = :id_product";

    $res = $con->prepare ($req);
    $res->bindValue (':id_product', $_GET['id'], PDO::PARAM_INT);

    $res->execute ();

    if ($res->rowCount () == 1)
    {
        $update_product = $res->fetch ();
    }
}

$reference = (isset ($update_product)) ? $update_product['reference'] : '';
$category = (isset ($update_product)) ? $update_product['category'] : '';
$title = (isset ($update_product)) ? $update_product['title'] : '';
$description = (isset ($update_product)) ? $update_product['description'] : '';
$color = (isset ($update_product)) ? $update_product['color'] : '';
$size = (isset ($update_product)) ? $update_product['size'] : '';
$gender = (isset ($update_product)) ? $update_product['gender'] : '';
$picture = (isset ($update_product)) ? $update_product['picture'] : '';
$price = (isset ($update_product)) ? $update_product['price'] : '';
$stock = (isset ($update_product)) ? $update_product['stock'] : '';

$id_product = (isset ($update_product)) ? $update_product['id_product'] : '';

$action = (isset ($update_product)) ? 'Update' : 'Add';


?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2"><?= $action ?> a product</h1>

            </div>

            <form action="" method="post" enctype="multipart/form-data">

                <?= $msg_error ?>

                <input type="hidden" name="id_product" value="<?= $id_product ?>">

                <div class="form-group">
                    <input type="text" class="form-control" name="reference" placeholder="Reference of the product..." value="<?= $reference ?>">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="category" placeholder="Category of the product..." value="<?= $category ?>">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Title of the product..." value="<?= $title ?>">
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="description" placeholder="Description of the product..."><?= $description ?></textarea>
                </div>
            
                <div class="form-group">
                    <select name="color" class="form-control">
                        <option disabled <?php if (!isset ($update_product)) { echo 'selected'; } ?>>Color of the product...</option>
                        <option <?php if ($color == 'black') { echo 'selected'; } ?>>black</option>
                        <option <?php if ($color == 'white') { echo 'selected'; } ?>>white</option>
                        <option <?php if ($color == 'red') { echo 'selected'; } ?>>red</option>
                        <option <?php if ($color == 'blue') { echo 'selected'; } ?>>blue</option>
                        <option <?php if ($color == 'orange') { echo 'selected'; } ?>>orange</option>
                        <option <?php if ($color == 'yellow') { echo 'selected'; } ?>>yellow</option>
                        <option <?php if ($color == 'green') { echo 'selected'; } ?>>green</option>
                        <option <?php if ($color == 'brown') { echo 'selected'; } ?>>brown</option>
                        <option <?php if ($color == 'pink') { echo 'selected'; } ?>>pink</option>
                        <option <?php if ($color == 'pruple') { echo 'selected'; } ?>>pruple</option>
                        <option <?php if ($color == 'indigo') { echo 'selected'; } ?>>indigo</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="size" class="form-control">
                        <option disabled <?php if (!isset ($update_product)) { echo 'selected'; } ?>>Size of the product...</option>
                        <option <?php if ($color == 'xs') { echo 'selected'; } ?>>xs</option>
                        <option <?php if ($color == 's') { echo 'selected'; } ?>>s</option>
                        <option <?php if ($color == 'm') { echo 'selected'; } ?>>m</option>
                        <option <?php if ($color == 'l') { echo 'selected'; } ?>>l</option>
                        <option <?php if ($color == 'xl') { echo 'selected'; } ?>>xl</option>
                        <option <?php if ($color == 'xxl') { echo 'selected'; } ?>>xxl</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="gender" class="form-control">
                        <option disabled <?php if (!isset ($update_product)) { echo 'selected'; } ?>>Public of the product...</option>
                        <option value="m"<?php if ($color == 'm') { echo 'selected'; } ?>>Men</option>
                        <option value="f"<?php if ($color == 'f') { echo 'selected'; } ?>>Women</option>
                        <option value="u"<?php if ($color == 'u') { echo 'selected'; } ?>>Undefined</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_picture">Product picture</label>
                    <input type="file" class="form-control-file" id="product_picture" name="product_picture">
                    <?php
                        if (isset ($update_product))
                        {
                            echo '<input name="actual_picture" value="' . $picture . '" type="hidden">';
                            echo '<img style="width: 25%";" src="' . URL . 'uploads/img/' . $picture . '">';
                        }
                    ?>

                </div>

                <div class="form-group">
                    <label for="product_picture2">Second product picture (optional)</label>
                    <input type="file" class="form-control-file" id="product_picture2" name="product_picture2">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="price" placeholder="Price of the product..." value="<?= $price ?>">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="stock" placeholder="Stock of the product..." value="<?= $stock ?>">
                </div>

                <input type="submit" value="<?= $action ?> a product" class="btn btn-info">
            
            </form>
          
        </main>
      </div>
    </div>

<?php require_once ('./inc/footer.php');
