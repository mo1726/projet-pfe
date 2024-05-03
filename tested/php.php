<?php
// Step 1: Generate a random number
$randomNumber = rand(1000000,99999999);

// Step 2: Store the random number in the database
include "connixen.php"; // Include your database connection file

// Insert the random number into the database
$stmt = $con->prepare("INSERT INTO client (reand) VALUES (?)");
$stmt->bind_param("s", $randomNumber); // Binding one parameter
if ($stmt->execute()) { // Use $stmt to execute the statement
    echo "Random number stored successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Step 3: Retrieve the random number from the database
$sql = "SELECT * FROM client ORDER BY id DESC LIMIT 1"; // Assuming you have an 'id' column
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $retrievedNumber = $row['reand']; // Adjust column name to match your table
} else {
    $retrievedNumber = "No random number found.";
}

$con->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Number Example</title>
</head>
<body>
    <div class="random-number">
        Random Number from Database: <?php echo $retrievedNumber; ?>
    </div>
</body>
</html>
