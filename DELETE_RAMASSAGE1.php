<?php
include "connixen.php";

// Check if the form is submitted
if(isset($_POST['Delete'])) {
    // Check if any checkbox is checked
    if(isset($_POST['checkedRows'])) {
        // Prepare the delete statement
        $stmt = $con->prepare("DELETE FROM ramassage WHERE ID = ?");
        if ($stmt) {
            // Bind the ID parameter
            $stmt->bind_param("i", $id);

            // Loop through the checked checkboxes
            foreach($_POST['checkedRows'] as $id) {
                // Execute the delete statement
                if ($stmt->execute()) {
                    continue;
                } else {
                    echo "Error deleting record with ID: $id - " . $stmt->error;
                }
            }

            // Close the statement
            $stmt->close();

            // Redirect to the same page after deletion
            header("Location: ramassage.php?success=1");
            exit();
        } else {
            echo "Error preparing statement: " . $con->error;
        }
    } else {
        echo "No rows selected for deletion";
    }
} else {
    // Redirect to the login page if the form is not submitted
    header("Location: login.php");
    exit();
}
?>
