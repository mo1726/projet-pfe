<?php
include "connixen.php";

// Constants for pagination
$records_per_page = 10; // Number of records to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number, default to 1 if not set

// Calculate the offset
$offset = ($page - 1) * $records_per_page;

// Query to fetch data for the current page
$sql = "SELECT * FROM ramassage LIMIT $offset, $records_per_page";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th></th><th>ID COMMONDE</th>
        <th>Name</th>
        <th>Prénom</th>
        <th>Adress</th>
        <th>Ville</th>
        <th>Prix</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $id = $row['Id_commande'];
        $name = $row['Full_name'];
        $email = $row['Tele'];
        $message = $row['Addrese'];
        $limitedMessage = $row['City'];
        $prix = $row['Prix'];
        echo "<tr><td><input type='checkbox' name='check'></td><td>$id</td><td>$name</td><td>$email</td><td>$message</td><td>$limitedMessage</td><td>$prix</td></tr>";
    }

    echo "</table>";

    // Check if there are more records
    if ($result->num_rows == $records_per_page) {
        $nextPage = $page + 1;
        echo "<a href='ramassage_next.php?page=$nextPage'>Next Page</a>";
    }
} else {
    echo "No results found.";
}
?>
