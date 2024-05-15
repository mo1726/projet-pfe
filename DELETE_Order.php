<?php
include "connixen.php";

// Check if the form is submitted
if(isset($_POST['Delete'])) {
    // Check if any checkbox is checked
    if(isset($_POST['checkedRows'])) {
        // Prepare the delete statement
        $stmt = $con->prepare("DELETE FROM `order` WHERE ID = ?");
        if($stmt) {
            // Bind parameters and execute the statement for each checked row
            foreach($_POST['checkedRows'] as $id) {
                $stmt->bind_param("i", $id); // Assuming ID is integer
                if ($stmt->execute()) {
                    header("Location: orders.php?success=1");
                    exit();
                } else {
                    echo "Error deleting record: " . $stmt->error;
                }
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $con->error;
        }
    } else {
        echo "No rows selected for deletion";
    }
} else {
    // Redirect with a message indicating unauthorized access
    header("Location: orders.php?Fatal=1");
    exit();
}
?>
