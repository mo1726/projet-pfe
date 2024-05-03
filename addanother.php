<?php
// process.php - Handle the form submission.

include "connixen.php"; // Assuming connixen.php contains your database connection called $con

// Check if form was submitted:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkedRows'])) {
    $checkedRows = $_POST['checkedRows'];
    // $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE); // Start a transaction with read write flag

    try {
        foreach ($checkedRows as $rowId) {
            // Retrieve the row data before deleting it.
            $stmt = $con->prepare("SELECT Id_commande, Full_name, Tele, Addrese, City, Prix FROM ramassage WHERE ID = ?");
            $stmt->bind_param("i", $rowId);
            $stmt->execute();
            $rowData = $stmt->get_result()->fetch_assoc();

            // Delete row from ramassage.
            $stmt = $con->prepare("DELETE FROM ramassage WHERE ID = ?");
            $stmt->bind_param("i", $rowId);
            $stmt->execute();

            // If the row data is not empty, insert it into the order table.
            if ($rowData) {
                $stmt = $con->prepare("INSERT INTO `order` (Id_commande, Full_name, Tele, Addrese, City, Prix) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssd", 
                    $rowData['Id_commande'], 
                    $rowData['Full_name'], 
                    $rowData['Tele'], 
                    $rowData['Addrese'], 
                    $rowData['City'], 
                    $rowData['Prix']
                );
                $stmt->execute();
            }
        }
        
        // Commit the transaction.
        $con->commit();
        header('Location: orders.php'); // Redirect to a success page if all goes well.
        exit;
    } catch (mysqli_sql_exception $e) {
        // An error occurred, rollback the transaction.
        $con->rollback();
        error_log($e->getMessage());
        header('Location: login.php'); // Redirect to an error page if something goes wrong.
        exit;
    }
} else {
    header('Location: login.php'); // Redirect if the form was not submitted correctly.
    exit;
}
?>