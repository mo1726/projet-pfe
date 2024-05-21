<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style/orders_admin1.css">
    <link rel="website icon" type="png" href="image/MD-removebg-preview.png">
</head>

<body>






    <div class="contner">
        <div class="nav-bar" id="navBar">
            <img src="image/MD-removebg-preview.png" alt="" class="nav-logo">
            <ul>
                <li><a href="admine.php" class="disactive">HOME</a></li>
                <li class="active"><a href="Order_admin.php">Orders</a></li>
                <li><a href="" class="disactive">Trafic</a></li>
                <li><a href="reportadmin.php" class="disactive">Reports</a></li>
            </ul>
        </div>
        <div class="hedbar">
            <div class="barx">
                <?php
                session_start();
                if (isset($_SESSION['Email'])) {
                    $Email = $_SESSION['Email'];
                    include 'connixen.php';

                    $sql_orders = "SELECT * FROM `order` ";
                    $stmt_orders = $con->prepare($sql_orders);

                    $stmt_orders->execute();
                    $result_orders = $stmt_orders->get_result();
                }



                // Your PHP code for establishing database connection and fetching orders comes here

                // Check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   include 'connixen.php';
                    if (isset($_POST['update_status'])) {
                        // Get the selected status and the order ID from the form submission
                        $status = $_POST['status'];
                        $order_id = $_POST['order_id'];
                        
                        // Update the status of the order in the database
                        $update_query = "UPDATE `order` SET Statu = ? WHERE ID = ?";
                        $stmt_update = $con->prepare($update_query);
                        $stmt_update->bind_param("si", $status, $order_id);
                        $stmt_update->execute();

                        // Redirect to the same page to avoid resubmission of form data
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    }
                }

                ?>
                <h4>Welcome ,Admin</h4>
                <div class="profile">
                    <a href="PAGE_Sitting.php"><img src="image/images.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="table-ram">
    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="success-message"> deleted successfully!</div>';
    }
    ?>
        <?php
    if(isset($_GET['Fatal']) && $_GET['Fatal'] == 1) {
        echo '<div class="Fatal-message"> deleted Fatal!</div>';
    }
    ?>


<div class="forms">
    <form method="GET" action="" class="searsh">
        <input type="text" name="search_query" placeholder="Search by boutique or ID">
        <input type="submit" value="Search">
    </form>
       <div class="nav-inp">
    <form action="create_bon_ramassage.php" method="post">
        <input type="submit" name="submit" class="element-to-animate" value="CREATE BON RAMASSAGE"> 
    </form>
    <form action="DELETE_Order1.php" method="post">
        <button type="submit" name="Delete" class='element-to-animate'>DELETE THE ORDER</button>
    
    
</div></div>

        <table>
            <tr>
                <th></th>
                <th>ID COMMONDE</th>
                <th>Name</th>
                <th>Prénom</th>
                <th>Adress</th>
                <th>Ville</th>
                <th>Prix</th>
                <th>Botique</th>
                <th>Statu</th>
            </tr>
            <?php
            include 'connixen.php';

            // Check if search query parameter is set
            if (isset($_GET['search_query'])) {
                // Sanitize the search query to prevent SQL injection
                $search_query = mysqli_real_escape_string($con, $_GET['search_query']);

                // Prepare SQL statement to fetch orders based on search query
                $sql_orders = "SELECT * FROM `order` WHERE botique LIKE '%$search_query%' OR Id_commande LIKE '%$search_query%'";
            } else {
                // If search query is not set, fetch all orders
                $sql_orders = "SELECT * FROM `order`";
            }

            // Prepare and execute the SQL statement
            $stmt_orders = $con->prepare($sql_orders);
            $stmt_orders->execute();

            // Get the result set
            $result_orders = $stmt_orders->get_result();
            if ($result_orders->num_rows > 0) {
                while ($row = $result_orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='checkedRows[]' value='" . $row['ID'] . "'></td>";
                    echo "<td>" . $row['Id_commande'] . "</td>";
                    echo "<td>" . $row['Full_name'] . "</td>";
                    echo "<td>" . $row['Tele'] . "</td>";
                    echo "<td>" . $row['Addrese'] . "</td>";
                    echo "<td>" . $row['City'] . "</td>";
                    echo "<td>" . $row['Prix'] . "</td>";
                    echo "<td>" . $row['botique'] . "</td>";
                    echo "<td>";echo "</form>";
                    echo "<form method='POST' action='{$_SERVER['PHP_SELF']}' class='status-form'>";
                    echo "<input type='hidden' name='order_id' value='" . $row['ID'] . "'>";
                    echo "<select name='status'>";
                    echo "<option value='Ramasse'" . ($row['Statu'] == 'Ramasse' ? ' selected' : '') . ">Ramasse</option>";
                    echo "<option value='Expede'" . ($row['Statu'] == 'Expede' ? ' selected' : '') . ">Expede</option>";
                    echo "<option value='Livree'" . ($row['Statu'] == 'Livree' ? ' selected' : '') . ">Livree</option>";
                    echo "<option value='Annule'" . ($row['Statu'] == 'Annule' ? ' selected' : '') . ">Annule</option>";
                    echo "</select>";

                    echo "<input type='submit' name='update_status' value='Update'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Aucune donnée trouvée</td></tr>";
            }
            ?>
       </table>
    </div>

</body>

</html>