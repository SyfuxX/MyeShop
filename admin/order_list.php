<?php 
    require_once('./inc/header.php'); 
?>

<div style="overflow-y: scroll;">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Price</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = "SELECT * FROM `order`";
                        $result = $con->prepare($query);
                        $result->execute();
                        

                        $orders = $result->fetchAll();
                        
                        foreach ($orders as $order) {
                            echo '<form action="" method="post">';
                            echo '<tr>';
                            foreach ($order as $key => $value) {
                                if($key == "id_order") {
                                    echo '<td> <input readonly hidden type="text" name="id" value="' . $value . '" >' .  $value . ' </td>';
                                }
                                if($key == "status") {
                                    echo '<td>' . '<select name = "status" id = "status">';

                                    if($value == "pending") {

                                        echo '<option value = "pending" selected> pending </option>
                                        <option value = "sent"> sent </option>
                                        <option value = "cancelled"> cancelled </option>
                                        <option value = "delivered"> delivered </option>
                                        </select> ' . ' </td> ';
                                        

                                    } else if($value == "sent") {

                                        echo '<option value = "pending"> pending </option>
                                        <option value = "sent" selected> sent </option>
                                        <option value = "cancelled"> cancelled </option>
                                        <option value = "delivered"> delivered 
                                        </select>' . '</td>';

                                    } else if($value == "cancelled") {

                                        echo '<option value = "pending"> pending </option>
                                        <option value = "sent"> sent </option>
                                        <option value = "cancelled" selected> cancelled </option>
                                        <option value = "delivered"> delivered </option>
                                        </select>' . '</td>';

                                    } else if($value == "delivered") {

                                        echo '<option value = "pending"> pending </option>
                                        <option value = "sent" <> sent </option>
                                        <option value = "cancelled" > cancelled </option>
                                        <option value = "delivered" selected> delivered </option>
                                        </select>' . '</td>';

                                    }
                                    
                                        
                                } else {

                                    echo '<td>' . $value . '</td>';
                                }

                                
                            }
                            echo '<td><input class="btn btn-primary" type="submit" value="change status"></td>';
                            echo '</form>';
                            echo '</tr>';
                        }

                        // Modify on change
                        if(!empty($_POST["id"]) && isset($_POST["id"]) && !empty($_POST["status"]) && isset($_POST["status"])) {

                            $query = "UPDATE `order` SET status = :status WHERE id_order = :id_order";
                            $result = $con->prepare($query);
                            $result->bindValue(":status", $_POST["status"], PDO::PARAM_STR);
                            $result->bindValue(":id_order", $_POST["id"], PDO::PARAM_INT);
                            if($result->execute()) {

                                echo '<h1 style="margin-top: 1rem;" class=" btn-lg btn-success "> Order Updated</h1>';
                            }
                            else {

                                echo '<h1 style="margin-top: 1rem;" class=" btn-lg btn-danger "> Update failed. Please try again!</h1>';
                            }
                            unset($_POST);
                        }

                        ?>
                    </tbody>
                </table>
            </div>

<?php 
require_once('./inc/footer.php');
?>