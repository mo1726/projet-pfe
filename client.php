<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    <style>
      /* styles.css */

/* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    text-align: left;
}

td {
    background-color: #fff;
}

.delete-btn, .edit-btn {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    display: grid;
    grid-template-columns: auto auto; /* Display as a grid with two columns */
    grid-gap: 5px;
}

.delete-btn {
    background-color: #e74c3c;
    color: #fff;
}

.edit-btn {
    background-color: #3498db;
    color: #fff;
}

.delete-btn:hover, .edit-btn:hover {
    background-color: #c0392b;
}

.edit-btn:hover {
    background-color: #2980b9;
}
img{
    width: 50px;
    position: relative;
    top: 50px;
    
}


    
    </style>
</head>
<body>
    <div>
    <a href="admine.php"><img src="image/arrow-left-5-svgrepo-com.png" alt=""></a><h3>Data from the Database:</h3></div>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
        <?php
        include 'connixen.php';

        $checkQuery = "SELECT * FROM client";
        $result = $con->query($checkQuery);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $email = $row['Email'];
                $password = $row['Password'];
                $username = $row['botique'];

                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$username</td>";
                echo "<td>$email</td>";
                echo "<td>$password</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='Id' value='$id'>";
                echo "<input type='submit' class='delete-btn' name='delete' value='Delete'>";
                echo "</form>";
                echo "<form method='POST' action='Edit_admin.php'>";
                echo "<input type='hidden' name='Id' value='$id'>";
                echo "<input type='submit' class='edit-btn' name='edit' value='Edit'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        if(isset($_POST['delete'])){
            $id = $_POST['id'];
            $deleteQuery = "DELETE FROM client WHERE id='$id'";
            if ($con->query($deleteQuery) === TRUE) {
                header('location:client.php');
            } else {
                echo "Error deleting record: " . $con->error;
            }
        }
    
        $con->close();
        ?>
    </table>
</body>
</html>