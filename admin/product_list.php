<?php 

require_once ('./inc/header.php'); 

$req = $con->query ("SELECT * FROM product");

// if delete request
if (isset ($_GET['id']) && !empty ($_GET['id']) && is_numeric ($_GET['id']))
{
    $request = "SELECT * FROM product WHERE id_product = :id_product";

    $result = $con->prepare ($request);
    $result->bindValue (':id_product', $_GET['id'], PDO::PARAM_INT);

    $result->execute ();

    if ($result->rowCount () == 1) {
        $product = $result->fetch ();

        $delete_req = "DELETE FROM product WHERE id_product = $product[id_product]";

        $delete_res = $con->exec ($delete_req);

        if ($delete_res)
        {
            $picture_path = ROOT_TREE . 'uploads/img/' . $product['picture'];

            if (file_exists ($picture_path) && $product['picture'] != 'default.jpg') // function file_exists () allows us to be sure that we got this picture registered on the server
            {
                unlink ($picture_path); // function unlink () allows us to delete a file from the server
            }

            header ('location: product_list.php?m=success');
        }
        else 
        {
            header ('location: product_list.php?m=fail');
        }
    }
    else 
    {
        header ('location: product_list.php?m=fail');
    }
}

// show messages 
if (isset ($_GET['m']) && !empty ($_GET['m']))
{
    switch ($_GET['m'])
    {
        case 'success':
            $msg_error = '<div class="alert alert-success">
                You successfully deleted this shity product !
            </div>';
        break;
        case 'fail':
            $msg_error = '<div class="alert alert-danger">
                There is something wrong...
            </div>';
        break;
        case 'update':
            $msg_error = '<div class="alert alert-success">
                The shity product is now not anymore shit. Successfully updated !
            </div>';
        break;
        default:
            $msg_error = '<div class="alert alert-secondary">
                Please try again...
            </div>';
        break;
    }

}

?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2">List of products</h1>

            </div>

            <?= $msg_error ?>

            <div style="overflow-y: scroll;">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Category</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Color</th>
                            <th scope="col">Size</th>
                            <th scope="col">Public</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Picture2</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $res = $con->query ("SELECT * FROM product");
                        $products = $res->fetchAll ();

                        foreach ($products as $product)
                        {
                            echo '<tr>';
                            foreach ($product as $key => $value)
                            {
                                if ($key == 'picture')
                                {
                                    echo '<td><img height="100" src="' . URL . 'uploads/img/' . $product['picture'] . '" alt="' . $product['title'] . '">';
                                }
                                else
                                {
                                    echo '<td>' . $value . '</td>';
                                }
                            }
                            echo '<td>
                                <a href="' . URL . '/admin/product_form.php?id=' . $product['id_product'] . '"><i class="fas fa-pencil-alt" style="color: blue;"></i></a>
                                <a href="?id=' . $product['id_product'] . '"><i class="fas fa-trash-alt" style="color: red;"></i></a>
                            </td>';
                            echo '</tr>';
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
          
        </main>
      </div>
    </div>

<?php require_once ('./inc/footer.php');
