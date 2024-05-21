<?php
include 'connixen.php'; // Include database connection
session_start();
                if (isset($_SESSION['Email'])) {
                    $Email = $_SESSION['Email'];
// Default image path
$defaultImagePath = "C:/xampp/htdocs/project0/image/images__1_-removebg-preview.png"; // Update with the correct default image path

// Directory on the server to store uploaded images
$uploadDir = "update-img/";

// Check if the "uploads" directory exists, if not, create it
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
    die("Failed to create directory: $uploadDir");
}

// Check if the "uploads" directory is writable
if (!is_writable($uploadDir)) {
    die("Directory is not writable: $uploadDir");
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == 0) {
        $targetFile = $uploadDir . basename($_FILES["profileImage"]["name"]);

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
            // Insert file path into the database
            $filePath = $targetFile; // Assuming you're storing the full path

            // Prepare and bind the SQL statement
            $stmt = $con->prepare("UPDATE client SET image = ? WHERE Email=?");
            if ($stmt) {
                $stmt->bind_param("si", $filePath, $Email); // Assuming $id is the ID of the client
               
                $stmt->execute();
                $stmt->close();

                // Redirect to PAGE_Sitting.php
                header("Location: PAGE_Sitting.php");
                exit();
            } else {
                echo "Error: " . $con->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // No file uploaded, insert default image path into the database
        $stmt = $con->prepare("UPDATE client SET image = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $defaultImagePath, $id); // Assuming $id is the ID of the client
            $id = 2; // Example client ID
            $stmt->execute();
            $stmt->close();

            // Redirect to PAGE_Sitting.php
            header("Location: PAGE_Sitting.php");
            exit();
        } else {
            echo "Error: " . $con->error;
        }
    }
}}
$con->close(); // Close database connection
?>
