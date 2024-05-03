<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            width: 150px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            background: red;
            border: none;
            border-radius: 5px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
            background: #e62222;
        }

        button, button span {
            transition: 200ms;
        }

        button .text {
            transform: translateX(35px);
            color: white;
            font-weight: bold;
        }

        button .icon {
            position: absolute;
            border-left: 1px solid #c41b1b;
            transform: translateX(110px);
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button svg {
            width: 15px;
            fill: #eee;
        }

        button:hover {
            background: #ff3636;
        }

        button:hover .text {
            color: transparent;
        }

        button:hover .icon {
            width: 150px;
            border-left: none;
            transform: translateX(0);
        }

        button:focus {
            outline: none;
        }

        button:active .icon svg {
            transform: scale(0.8);
        }

        .Btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 100px;
            height: 40px;
            border: none;
            padding: 0px 20px;
            background-color: green;
            color: white;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 5px 5px 0px black;
            transition-duration: .3s;
        }

        .svg {
            width: 13px;
            position: absolute;
            right: 0;
            margin-right: 20px;
            fill: white;
            transition-duration: .3s;
        }

        .Btn:hover {
            color: transparent;
        }

        .Btn:hover svg {
            right: 43%;
            margin: 0;
            padding: 0;
            border: none;
            transition-duration: .3s;
        }

        .Btn:active {
            transform: translate(3px, 3px);
            transition-duration: .3s;
            box-shadow: 2px 2px 0px rgb(140, 32, 212);
        }
        
        /* Optional: Add some basic styling for the search bar */
        
    
    </style>
</head>
<body>

    <?php
     include 'connixen.php';

     $checkQuery = "SELECT * FROM client";
     $result = $con->query($checkQuery);
 
     if ($result->num_rows > 0) {
         echo "<h3>Data from the Database:</h3>";
         echo "<table>";
         echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>DELETE</th><th>Edit</th></tr>";
 
         while ($row = $result->fetch_assoc()) {
             $id = $row['id'];
             $email = $row['Email'];
             $password = $row['Password'];
             $username = $row['botique'];
 
             echo "<tr><td>$id</td><td>$username</td><td>$email</td><td>$password</td>
                 <td>
                 <form method='POST'>
                 <input type='hidden' name='Id' value='$id'>
                 <button class='noselect' name='sup'><span class='text'>Delete</span><span class='icon'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z'></path></svg></span></button>
                 </form>
                 </td>
                 <td>
                 <form method='POST' action='regist.php' >
                 <input type='hidden' name='Id' value='$id'>
                 <button class='Btn' name='edit' type='submit'>Edit 
                 <svg class='svg' viewBox='0 0 512 512'>
                     <path d='M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z'></path>
                 </svg>
               </button>
                 </form>
                 </td></tr>";
         }
 
         echo "</table>";
     }
 
     if(isset($_POST['sup'])){
         $id = $_POST['Id'];
         $sql = "DELETE FROM client WHERE id = '$id'";
         $results = $con->query($sql);
 
         if($results){
             echo "<p>Deletion successful!</p>";
             echo "<script>$(document).ready(function() {
                 alert('Deletion successful');
             });</script>";
         } else {
             echo "<p>Deletion failed.</p>";
         }
     }
 
     if(isset($_POST['edit'])){
         $id = $_POST['id'];
         $username = $_POST['username'];  // Assuming you have an input field with name 'username'
         $password = $_POST['password'];  // Assuming you have an input field with name 'password'
         $email = $_POST['email'];        // Assuming you have an input field with name 'email'
 
         $sql = "UPDATE client SET Username='$username', Password='$password', Email='$email' WHERE id = '$id'";
         $results = $con->query($sql);
 
         if($results){
             echo "<p>Edit successful!</p>";
             echo "<script>$(document).ready(function() {
                 alert('Edit successful');
             });</script>";
         } else {
             echo "<p>Edit failed.</p>";
         }
     }
     $con->close();
    ?>

</body>
</html>