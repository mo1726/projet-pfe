<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Delete Client Data</title>
    <style>
        /* styles.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    text-align: center;
}

form {
    margin-top: 20px;
}

form label {
    display: block;
    margin-bottom: 5px;
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <h3>Edit/Delete Client Data</h3>
    <?php
    include 'connixen.php';

    if(isset($_POST['edit'])){
        $id = $_POST['Id'];
        $editQuery = "SELECT * FROM client WHERE id='$id'";
        $result = $con->query($editQuery);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['botique'];
            $email = $row['Email'];
            $password = $row['Password'];
            echo "<form method='POST' >";
            echo "<input type='hidden' name='Id' value='$id'>";
            echo "<label>Username:</label>";
            echo "<input type='text' name='username' value='$username'><br>";
            echo "<label>Email:</label>";
            echo "<input type='email' name='email' value='$email'><br>";
            echo "<label>Password:</label>";
            echo "<input type='password' name='password' value='$password'><br>";
            echo "<input type='submit' class='update-btn' name='update' value='Update'>";
            echo "</form>";
        }}
            $con->close();
    ?>
    <?php
include 'connixen.php';

if(isset($_POST['update'])){
    $id = $_POST['Id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $updateQuery = "UPDATE client SET botique='$username', Email='$email', Password='$password' WHERE id='$id'";
    if ($con->query($updateQuery) === TRUE) {
        header('location:client.php');
    } else {
        echo "Error updating record: " . $con->error;
    }
}
$con->close();
?>
</body>
</html>