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
    if (!isset($_SESSION['Email'])) {
        // If not logged in, redirect to login page
        header('Location: login.php');
        exit;
    }
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
                <a href="PAGE_Sitting.php" class="Active">
                    <h3><span>Information</span></h3>
                </a>
                <a href="EDIT_INFO.PHP" class="desibled">
                    <h3>Edit Info</h3>
                </a>
                <a href="EDIT_PASSWORD.php" class="desibled">
                    <h3>Edit Password</h3>
                </a>
            </div>
        </div>

        <div class="info">
            <h1>Information</h1>
            <div class="all-info">
                <div class="info3">
                <form method="POST" id="deleteForm">
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
                    <input type="text" value="<?php echo "0".$row["phone"]; ?>" disabled>
                    <h6>City:</h6>
                    <input type="text" value="<?php echo $row["City"]; ?>" disabled>
                </div>
                
            </div>
            <div class="hello">
            <a href="EDIT_INFO.PHP">Edit Info</a>
               <input type="submit" value="DELETE ACC" name='DELETE'>
               <input type="hidden" name="confirm" value="yes">
            </div>
            </form>
            <img src="image/Vector 1.svg" alt="" class='svg'>
            <form action="" method="POST">
    <button class="logout" name="logout">Logout</button>
</form>
       

    <?php 

if (isset($_POST['DELETE']) && isset($_SESSION['Email'])) {
    
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
    } 
}}
?>
<script type="text/javascript">
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            var confirmBox = confirm("Are you sure you want to delete your account?");
            if (confirmBox != true) {
                event.preventDefault();
            }
        });
    </script>
    </div>
</div>
<?php
    if(isset($_POST['logout'])){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();

        session_destroy();

        header('Location: login.php');
        exit;
    }
?>



</body>

</html>
