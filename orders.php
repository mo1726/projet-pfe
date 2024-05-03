<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style/orders2.css">
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">


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
                <!-- <h3>Overview</h3> -->
                <?php
                session_start();
                if (isset($_SESSION['Email'])) {
                    $Email = $_SESSION['Email'];
                    include 'connixen.php';
                    $sqll = "SELECT name, Prenom FROM client WHERE Email=?";
                    $add = $con->prepare($sqll);
                    $add->bind_param("s", $Email);
                    $add->execute();
                    $result = $add->get_result();

                    // Fetching the row from the result set
                    $row = $result->fetch_assoc();
                }
                ?>
                <h4>Welcome <?php echo $row["name"] . ' ' . $row['Prenom']; ?></h4>
                <div class="profile">
                    <a href=""><img src="image/images.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
    <div class="buttons2">
        <button type="submit" class='element-to-animate'>DELETE THE ORDER</button>
        <input type="button" value="hello">
    </div>
    <div class="table-ram">
        <div class="nav-inp">

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
            </tr>
           
            <?php
            include 'connixen.php';

            $sql = "SELECT * FROM `order`";
            $result = $con->query($sql);
            ?>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='checkedRows[]' value='" . $row['ID'] . "'></td>";
                    echo "<td>" . $row['Id_commande'] . "</td>";
                    echo "<td>" . $row['Full_name'] . "</td>";
                    echo "<td>" . $row['Tele'] . "</td>";
                    echo "<td>" . $row['Addrese'] . "</td>";
                    echo "<td>" . $row['City'] . "</td>";
                    echo "<td>" . $row['Prix'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucune donnée trouvée</td></tr>";
            }
            ?>
        </table>

    </div>





</body>

</html>