<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['Email'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Include database connection
include 'connixen.php';

// Initialize variables
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SUBMIT_Password'])) {
    // Retrieve form data
    $Email = $_SESSION['Email'];
    $OldPassword = $_POST['Old'];
    $NewPassword = $_POST['Password'];
    $NewPasswordAgain = $_POST['Password_Again'];

    // Fetch the current password from the database
    $stmt = $con->prepare("SELECT Password FROM client WHERE Email=?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $CurrentPassword = $row['Password'];

        // Verify if the old password matches the current password
        if ($OldPassword === $CurrentPassword) {
            // Check if the new password matches the confirmation
            if ($NewPassword === $NewPasswordAgain) {
                // Update the password in the database
                // Update the password and confirm fields in the database
$updateSql = "UPDATE client SET Password=?, Confirm=? WHERE Email=?";
$updateStmt = $con->prepare($updateSql);

if ($updateStmt) {
    $updateStmt->bind_param("sss", $NewPassword, $NewPasswordAgain, $Email);
    if ($updateStmt->execute()) {
        // Password updated successfully
        $message = '<div class="message success">Password updated successfully</div>';
    } else {
        $message = '<div class="message error">Failed to update password</div>';
    }
} else {
    $message = '<div class="message error">Failed to prepare statement</div>';
}}}}}

// Logout functionality
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Info</title>
    <link rel="stylesheet" href="Style/PAssword_edit.css">
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
            <?php echo $message; ?>
            <div class="all-info">
                <div class="info3">
                    <form method="POST" id="Change_Password">
                        <div class="inputForm">
                            <h6>Old Password :</h6>
                            <input type="password" class="input" name="Old" id="oldPassword" >
                            <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="togglePassword" data-target="oldPassword"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                        </div>
                        <div class="inputForm">
                            <h6>New Password :</h6>
                            <input type="password" class="input" name="Password" id="newPassword" >
                            <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="togglePassword" data-target="newPassword"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                        </div>
                        <div class="inputForm">
                            <h6>New Password Again :</h6>
                            <input type="password" class="input" name="Password_Again" id="confirmPassword"  >
                            <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="togglePassword" data-target="confirmPassword"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                        </div>

            <div class="hello">
                <input type="submit" value="SUBMIT" name="SUBMIT_Password">
            </div>
            </form>
            <img src="image/Vector 1.svg" alt="" class='svg'>
            <form action="" method="POST">
                <button class="logout" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <script>
    // JavaScript to toggle password visibility and style input[type="text"]
    const togglePasswordButtons = document.querySelectorAll('.togglePassword');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const svgElement = this.querySelector('svg');
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                targetInput.classList.add('revealed');
                svgElement.classList.remove('eye-slash');
                svgElement.classList.add('eye');
            } else {
                targetInput.type = 'password';
                targetInput.classList.remove('revealed');
                svgElement.classList.remove('eye');
                svgElement.classList.add('eye-slash');
            }
        });
    });

    // Adding event listener to the input[type="text"] to remove the styling when clicked
    const textInputs = document.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.addEventListener('click', function() {
            this.classList.remove('revealed');
        });
    });
</script>


</body>

</html>
