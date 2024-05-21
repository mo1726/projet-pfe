<?php
// process.php - Handle the form submission.

include "connixen.php"; // Assuming connixen.php contains your database connection called $con

// Check if form was submitted:
if (isset($_POST['submit']) && isset($_POST['checkedRows'])) {
    $checkedRows = $_POST['checkedRows'];

    try {
        // Start a transaction
        $con->begin_transaction();

        foreach ($checkedRows as $rowId) {
            // Delete row from ramassage and insert it into the order table.
            $stmt = $con->prepare("INSERT INTO `order` (Id_commande, Full_name, Tele, Addrese, City, Botique, Prix) SELECT Id_commande, Full_name, Tele, Addrese, City, Botique, Prix FROM ramassage WHERE ID = ?");
            $stmt->bind_param("i", $rowId);
            $stmt->execute();

            // Delete row from ramassage.
            $stmt = $con->prepare("DELETE FROM ramassage WHERE ID = ?");
            $stmt->bind_param("i", $rowId);
            $stmt->execute();
        }
        
        // Commit the transaction.
        $con->commit();
        header('Location: orders.php'); // Redirect to a success page if all goes well.
    } catch (mysqli_sql_exception $e) {
        // An error occurred, rollback the transaction.
        $con->rollback();
        error_log($e->getMessage());
        header('Location: login.php'); // Redirect to an error page if something goes wrong.
    }
} else {
    header('Location: ramassage.php'); // Redirect if the form was not submitted correctly.
}
?>

