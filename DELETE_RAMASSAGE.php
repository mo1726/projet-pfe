
<?php
include "connixen.php";

// Check if the form is submitted
if(isset($_POST['Delete'])) {
    // Check if any checkbox is checked
    if(isset($_POST['checkedRows'])) {
        // Loop through the checked checkboxes
        foreach($_POST['checkedRows'] as $id) {
            // Perform the delete query
            $sql = "DELETE FROM ramassage WHERE ID = $id";
            if ($con->query($sql) === TRUE) {
                header("Location: Ramassage.php?success=1");
            } else {
                echo "Error deleting record: " . $con->error;
            }
        }
    } else {
        echo "No rows selected for deletion";
    }
} else {
    // Redirect or handle other actions if needed when the form is not submitted
    // For example, redirect to another page
    header("Location: login.php");
    exit();
}
?>
