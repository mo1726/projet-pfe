<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="Style/report1.css">
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <style>
        #formMessage {
    margin-top: 10px;
    font-weight: bold;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}
tr{
    font-family: Arial, sans-serif;
    height: 1vh;
    
     margin: 0;
     padding: 0;
}
th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    white-space: nowrap; /* Prevent text wrapping */
    overflow: hidden;
    text-overflow: ellipsis; /* Display ellipsis for overflowed text */
    
}

th {
    background-color: #f2f2f2;
    text-align: center;
}
a img{
    width: 5%;
    position: relative;
    top:1%;
    
}
    </style>
</head>
<body>
<a href="admine.php"><img src="image/arrow-left-5-svgrepo-com.png" alt=""> </a>

<?php
// Include 'connixen.php' with your database connection details
include 'connixen.php';

// Use prepared statement to prevent SQL injection
$checkQuery = "SELECT id, Nom_botique, Email, Message FROM reports";

// Initialize the statement
if ($stmt = $con->prepare($checkQuery)) {
    // Execute the query
    if ($stmt->execute()) {
        // Get the result set
        $result = $stmt->get_result();

        // Check if there are rows in the result set
        if ($result->num_rows > 0) {
            // Display table headers
            echo "<table>";
            echo "<tr><th>ID</th><th>Nom Boutique</th><th>Email</th><th>Message</th></tr>";

            // Loop through results and display each row in a table
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['Nom_botique'];
                $email = $row['Email'];
                $message = $row['Message'];
                $limitedMessage = strlen($message) > 50 ? substr($message, 0, 50) . "..." : $message;
                echo "<tr><td>$id</td><td>$name</td><td>$email</td><td>$limitedMessage</td></tr>";
            }

            echo "</table>";
        } else {
            // Handle the case where no reports are found in the database
            echo "No reports found in the database.";
        }
    } else {
        // Handle query execution error
        echo "Error executing query: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle statement preparation error
    echo "Error preparing statement: " . $con->error;
}

// Close the database connection
$con->close();
?>






    

    
</body>
</html>
