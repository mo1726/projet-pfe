<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="Style/PAGE_SETTING.css">
    <link rel="icon" href="image/MD-removebg-preview.png">
</head>

<body>
<?php 
    session_start();
    if (isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email'];
        include 'connixen.php';
        
        $sql = "SELECT * FROM client WHERE Email=?";
        $stmt = $con->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
?>
    <div class="contener">
        <div class="image">
            <img src="image/images.png" alt="">
            <div class="nav_cantent">
                <a href="" class="Active">
                    <h3><span>Information</span></h3>
                </a>
                <a href="" class="desibled">
                    <h3>Edit Info</h3>
                </a>
                <a href="" class="desibled">
                    <h3>Edit Password</h3>
                </a>
            </div>
        </div>

        <div class="info">
            <h1>Information</h1>
            <div class="all-info">
                <div class="info3">
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    <h6>First Name:</h6>
                    <input type="text" value="<?php echo $row["name"]; ?>" disabled>
                    <h6>Email:</h6>
                    <input type="text" value="<?php echo $row["Email"]; ?>" disabled>
                    <h6>Botique Name:</h6>
                    <input type="text" value="<?php echo $row["botique"]; ?>" disabled>
                </div>
                <div class="info4">
                    <h6>Last Name:</h6>
                    <input type="text" value="<?php echo $row["Prenom"]; ?>" disabled>
                    <h6>Telephone:</h6>
                    <input type="text" value="<?php echo $row["phone"]; ?>" disabled>
                    <h6>City:</h6>
                    <input type="text" value="<?php echo $row["City"]; ?>" disabled>
                </div>
                
            </div>
            <div class="hello">
            <a href="login.php">Edit Info</a>
               <input type="submit" value="DELETE ACC" name='DELETE'>
               <input type="hidden" name="confirm" value="yes">
            </div>
            </form>
            <img src="image/Vector 1.svg" alt="" class='svg'>
        <button class="logout">Logout</button>
        </div>

    <?php 

if (isset($_POST['DELETE']) && isset($_SESSION['Email'])) {
    // Check if confirmation is received
    $confirm = $_POST['confirm']; // Assuming you have a form input with name 'confirm'

    // Ensure both 'DELETE' and 'Email' session variable are set
    if ($confirm && $confirm === "yes") {
        // Retrieve the email address from the session
        $Email = $_SESSION['Email'];

        // Prepare the SQL statement to delete the row from the client table
        $sql = "DELETE FROM client WHERE Email = ?";

        // Prepare and execute the SQL statement
        $stmt = $con->prepare($sql);
        if ($stmt) {
            // Bind the email parameter
            $stmt->bind_param("s", $Email);

            // Execute the statement
            if ($stmt->execute()) {
                // Row deleted successfully
                header('location:login.php');
            } else {
                // Error executing the statement
                echo "Error deleting record: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error preparing the statement
            echo "Error in preparing SQL statement: " . $con->error;
        }
    } else {
        // Confirmation not received or not confirmed
        echo "Confirmation not received or not confirmed.";
    }
}}}}
?>
    </div>
</div>



</body>

</html>
