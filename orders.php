<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style/orders3.css">
    <link rel="website icon" type="png" href="image/MD-removebg-preview.png">
</head>

<body>
    <div class="contner">
        <div class="nav-bar" id="navBar">
            <img src="image/MD-removebg-preview.png" alt="" class="nav-logo">
            <ul>
                <li><a href="dashbord.php" class="disactive">HOME</a></li>
                <li class="active"><a href="orders.php">Orders</a></li>
                <li><a href="ramassage.php" class="disactive">Ramassage</a></li>
                <li><a href="" class="disactive">Products</a></li>
                <li><a href="report.php" class="disactive">Reports</a></li>
            </ul>
        </div>
        <div class="hedbar">
            <div class="barx">
                <?php
                session_start();
                if (isset($_SESSION['Email'])) {
                    $Email = $_SESSION['Email'];
                    include 'connixen.php';
                    $sqll = "SELECT name, Prenom, botique FROM client WHERE Email=?";
                    $add = $con->prepare($sqll);
                    $add->bind_param("s", $Email);
                    $add->execute();
                    $result_client = $add->get_result();
                    $row_client = $result_client->fetch_assoc();
                    $client_botique = $row_client['botique'];
                    $sql_orders = "SELECT * FROM `order` WHERE botique = ?";
                    $stmt_orders = $con->prepare($sql_orders);
                    $stmt_orders->bind_param("s", $client_botique);
                    $stmt_orders->execute();
                    $result_orders = $stmt_orders->get_result();}
                    ?>
                    <h4>Welcome <?php echo $row_client["name"] . ' ' . $row_client['Prenom']; ?></h4>
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
        echo '<div class="Fatal-message"> deleted successfully!</div>';
    }
    ?>
        <div class="nav-inp">
            <form action="DELETE_Order.php" method="post">
        <button type="submit" name="Delete" class='element-to-animate'>DELETE THE ORDER</button>
        <form action="" method="post">
            <input type="submit" name="submit" class="element-to-animate" value="CREATE BON RAMASSAGE"> 
            
            
        </div>
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
                    echo "<td>" . $row['Statu'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Aucune donnée trouvée</td></tr>";
            }
            ?>
       </form></form> </table>
    </div>
    
</body>

</html>
