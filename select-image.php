<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}
include 'connixen.php'; // Include database connection

$email = $_SESSION['Email']; // Retrieve email from session

// Initialize $imagePath variable
$imagePath = "C:/xampp/htdocs/project0/image/images__1_-removebg-preview.png"; // Default image path

// Retrieve image path from the database
$sql = "SELECT image FROM client WHERE Email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = $row["image"];
}

$stmt->close();
$con->close();
?>
