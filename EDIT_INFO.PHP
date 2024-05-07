<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="Style/Edit-info.css">
    <link rel="icon" href="image/MD-removebg-preview.png">
</head>

<body>


    <div class="contener">
        <div class="image">
            <img src="image/images.png" alt="">
            <div class="nav_cantent">
                <a href="PAGE_Sitting.php" class="desibled">
                    <h3>Information</h3>
                </a>
                <a href="EDIT_INFO.PHP" class="Active">
                    <h3><span>Edit Info</span></h3>
                </a>
                <a href="EDIT_PASSWORD.php" class="desibled">
                    <h3>Edit Password</h3>
                </a>
            </div>
        </div>

        <div class="info">
            <h1>Edit Info</h1>

            <?php 
            session_start();
            if (!isset($_SESSION['Email'])) {
                // If not logged in, redirect to login page
                header('Location: login.php');
                exit;
            }
                $Email = $_SESSION['Email'];
                include 'connixen.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Edit'])) {
                    $Name = $_POST['Name'];
                    $Prenom = $_POST['Prenom'];
                    $Tele = $_POST['Tele'];
                    $City = $_POST['City'];

                    $sql = "UPDATE client SET name=?, Prenom=?, phone=?, City=? WHERE Email=?";
                    $stmt = $con->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("sssss", $Name, $Prenom, $Tele, $City, $Email);
                        if ($stmt->execute()) {
                            // Check if the update was successful
                            if ($stmt->affected_rows > 0) {
                                echo '<div class="message success">Information updated successfully</div>';
                            } else {
                                echo '<div class="message error">Failed to update information</div>';
                            }
                        } else {
                            echo '<div class="message error">Failed to execute statement</div>';
                        }
                    } else {
                        echo '<div class="message error">Failed to prepare statement</div>';
                    }
                }

                // Fetch user data for pre-filling the form
                $sql = "SELECT * FROM client WHERE Email=?";
                $stmt = $con->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("s", $Email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    } else {
                        echo '<div class="message error">User not found</div>';
                    }
                } else {
                    echo '<div class="message error">Failed to prepare statement</div>';
                }
            
            ?>
            <div class="all-info">
                
                <div class="info3">
   
                <form method="POST" id="deleteForm">
                    <h6>First Name:</h6>
                    <input type="text" valu=""  name="Name" >
                    <h6>Email:</h6>
                    <input type="text" value="<?php echo $row["Email"]; ?>"  name="Email" disabled>
                    <h6>Botique Name:</h6>
                    <input type="text" value="<?php echo $row["botique"]; ?>"  name="Botique" disabled>
                </div>
                <div class="info4">
                    <h6>Last Name:</h6>
                    <input type="text" value="" name="Prenom"  >
                    <h6>Telephone:</h6>
                    <input type="text" value="" name="Tele"  >
                    <h6>City:</h6>
                    <input type="text" valu="" name="City"  >
                </div>
                
            </div>
            <div class="hello">
            <input type="submit" value="SUBMIT EDIT " name="Edit" >
               
            </div>
            </form>
            <img src="image/Vector 1.svg" alt="" class='svg'>
            <form action="" method="POST">
    <button class="logout" name="logout">Logout</button>
</form>

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

        </div>


    </div>
</div>



</body>

</html>
