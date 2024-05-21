<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
   

    <link rel="stylesheet" href="Style/ramassage0.css">

   
</head>
<body>
<div class="contner">
    <div class="nav-bar" id="navBar">
        <img src="image/MD-removebg-preview.png" alt="" class="nav-logo">

        <ul>
            <li ><a href="dashbord.php"  class="disactive">HOME</a></li>
            <li ><a href="orders.php" class="disactive">Orders</a></li>
            <li class="active"><a href="ramassage.php" >Ramassage</a></li>
            <li><a href="report.php" class="disactive">Reports</a></li>
        </ul>
    </div>
    <div class="hedbar">
        
    
    <div class="barx">
    
    <?php
    session_start();
    
    // Check if 'Email' session variable is set
    if (isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email'];
        include 'connixen.php'; // Include database connection
        
        // Prepare SQL statement
        $sql = "SELECT name, Prenom FROM  client WHERE Email=?";
        $stmt = $con->prepare($sql);
        
        if ($stmt) {
            // Bind parameters and execute
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            
            // Get result set
            $result = $stmt->get_result();
            
            // Check if any rows are returned
            if ($result->num_rows > 0) {
                // Fetch row
                $row = $result->fetch_assoc();
                
                // Output welcome message
                echo "<h4>Welcome " . $row["name"] . ' ' . $row['Prenom'] . "</h4>";
            } else {
                // No user found
                echo "<h4>Welcome Guest</h4>";
            }
            
            // Close result set
            $result->close();
        } else {
            // Error in preparing SQL statement
            echo "Error in preparing SQL statement.";
        }
    }
        
        
    
    ?>


        <div class="profile">
        <a href="PAGE_Sitting.php"><img src='<?php include 'select-image.php';  echo $imagePath; ?>' alt='' ></a>
        </div></div>
    </div></div>
    <div class="table-ram">
    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="success-message"> deleted successfully!</div>';
    }
    ?>
        <div class="nav-inp">
           <button onclick="openPopup()" id="create" class="element-to-animate" >CREATE RAMASSAGE</button>
           
            
           <form action="addanother.php" method="post">
        <input type="submit" name="submit" class="element-to-animate" value="CREATE BON DE RAMASSAGE">
        <!-- <form action="DELETE_RAMASSAGE1.php" method="post">
        <input type="submit" name="Delete" class="element-to-animate" value="Delete  RAMASSAGE"> -->
   
               </div>

            <table>
    <tr><th></th><th>ID COMMONDE</th>
        <th>Name</th>
        <th>Prénom</th>
        <th>Adress</th>
        <th>Ville</th>
        <th>Botique</th>
        <th>Prix</th></tr>
        <?php
include "connixen.php";

// Constants for pagination


// Query to fetch data for the current page
$sql = "SELECT * FROM ramassage ";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    

    while ($row = $result->fetch_assoc()) {
        $id=$row["ID"];
        $Id_commande = $row['Id_commande'];
        $name = $row['Full_name'];
        $email = $row['Tele'];
        $message = $row['Addrese'];
        $limitedMessage = $row['City'];
        $Botique=$row['Botique'];
        $prix = $row['Prix'];
        echo "<tr> <td><input type='checkbox' name='checkedRows[]' value='{$id}'></td></td><td>$Id_commande</td><td>$name</td><td>$email</td><td>$message</td><td>$limitedMessage</td><td>$Botique</td><td>$prix</td></tr>";

    }}
    else {
        echo "<tr><td colspan='8'>Aucune donnée trouvée</td></tr>";
    }

    
    ?>
    </form></form></table>
<?php

$records_per_page = 9; // Number of records to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number, default to 1 if not set

// Calculate the offset
$offset = ($page - 1) * $records_per_page;

$sql = "SELECT * FROM ramassage LIMIT $offset, $records_per_page";
$result = $con->query($sql);
    // Pagination links
    $sql = "SELECT COUNT(*) AS total FROM ramassage";
    $result_count = $con->query($sql);
    $row_count = $result_count->fetch_assoc()['total'];

    // Check if there are more records
    if ($row_count > $records_per_page * $page) {
        $nextPage = $page + 1;
        $lastPage = $page - 1;

        if($lastPage==0){
            echo "<a href='ramassage.php?page=$lastPage' id='last' style='display: inline-block; padding: 8px 16px; text-decoration: none; color: #fff; background-color: #007bff; border: 1px solid #007bff; border-radius: 4px; margin: 10px 5px;pointer-events: none; /* désactive les événements de souris */
            cursor: not-allowed;' >$lastPage Last Page</a>";
        }
        echo "<a href='ramassage.php?page=$nextPage' id='next' style='display: inline-block; padding: 8px 16px; text-decoration: none; color: #fff; background-color: #007bff; border: 1px solid #007bff; border-radius: 4px; margin: 10px 5px;'>$nextPage Next Page</a>";

    }



?>






    </div>
    



    <div class="popup-container" id="popup">
    <h2>CREATE RAMASSAGE</h2>
    <form action="insert.php" id="formid" method="post">
        <input type="text" id="name" name="name" required placeholder="FULL NAME"><br>
        <input type="text" id="Botique" name="Botique" required placeholder="Botique"><br>
        <input type="text" id="tele" name="tele" required placeholder="PHONE NUMBER"><br>
        <select name="city" id="city" name='city'>
                        <option value="">CITY</option>
                        <option value="Agadir">Agadir</option>
                        <option value="Al Hoceima">Al Hoceima</option>
                        <option value="Azrou">Azrou</option>
                        <option value="Beni Mellal">Beni Mellal</option>
                        <option value="Berkane">Berkane</option>
                        <option value="Casablanca">Casablanca</option>
                        <option value="Chefchaouen">Chefchaouen</option>
                        <option value="Dakhla">Dakhla</option>
                        <option value="El Jadida">El Jadida</option>
                        <option value="Errachidia">Errachidia</option>
                        <option value="Essaouira">Essaouira</option>
                        <option value="Fes">Fes</option>
                        <option value="Guelmim">Guelmim</option>
                        <option value="Ifrane">Ifrane</option>
                        <option value="Kénitra">Kénitra</option>
                        <option value="Khemisset">Khemisset</option>
                        <option value="Khenifra">Khenifra</option>
                        <option value="Khouribga">Khouribga</option>
                        <option value="Laayoune">Laayoune</option>
                        <option value="Larache">Larache</option>
                        <option value="Marrakech">Marrakech</option>
                        <option value="Meknès">Meknès</option>
                        <option value="Mohammedia">Mohammedia</option>
                        <option value="Nador">Nador</option>
                        <option value="Ouarzazate">Ouarzazate</option>
                        <option value="Oujda">Oujda</option>
                        <option value="Rabat">Rabat</option>
                        <option value="Safi">Safi</option>
                        <option value="Salé">Salé</option>
                        <option value="Settat">Settat</option>
                        <option value="Sidi Ifni">Sidi Ifni</option>
                        <option value="Sidi Kacem">Sidi Kacem</option>
                        <option value="Sidi Slimane">Sidi Slimane</option>
                        <option value="Sidi Yahya El Gharb">Sidi Yahya El Gharb</option>
                        <option value="Skhirate-Témara">Skhirate-Témara</option>
                        <option value="Tanger">Tanger</option>
                        <option value="Taourirt">Taourirt</option>
                        <option value="Taounate">Taounate</option>
                        <option value="Taroudant">Taroudant</option>
                        <option value="Taza">Taza</option>
                        <option value="Tétouan">Tétouan</option>
                        <option value="Tiznit">Tiznit</option>
                        <option value="Zagora">Zagora</option>
                    </select><br>
        <input type="text" id="prix" name="prix" required placeholder="PRICE"><br>
        <input type="text" id="adresse" name="adresse" required placeholder="ADDRESS"><br>
        <button type="submit" name="btn1">Submit</button>
    </form>
    <button onclick="closePopup()">Close</button>
</div>



    








<script>
    if(document.getElementById('popup').style.display = 'block'){
        document.getElementById('popup').style.display = 'none';
        
    }
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        document.querySelector("body").style.opacity=0;
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>
</body>
</html>