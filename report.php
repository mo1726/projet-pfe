<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="Style/report1.css">
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <style></style>
</head>
<body>
    <h1>Contact Us</h1>
    
            <a href="dashbord.php"><img src="image/arrow-left-5-svgrepo-com.png" alt=""> </a>
        
            <form id="contactForm" method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit" name="btn">Submit</button>
        <div id="formMessage"></div>
    </form>
    


<?php
    session_start();

    // Check if the Email is set in the session
    if (isset($_SESSION['Email'])) {
        $Email = $_SESSION['Email'];
        // Now you can use $Email in this page

        include 'connixen.php';

        // Use prepared statement to prevent SQL injection
        $checkQuery = "SELECT * FROM reports WHERE Email = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nom Boutique</th><th>Email</th><th>Message</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['Nom_botique'];
                $email = $row['Email'];
                $message = $row['Message'];
                $limitedMessage = strlen($message) > 50 ? substr($message, 0, 50) . "..." : $message;
                echo "<tr><td>$id</td><td>$name</td><td>$email</td><td>$limitedMessage</td></tr>";
            }

            echo "</table>";
        }

        $stmt->close();
        $con->close();

    } else {
        // Redirect or handle the case where the Email is not set
        header("Location: login.php");
        exit();
    }
    ?>




    

    <script>
        function submitForm() {
            // Fetch form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            const formMessage = document.getElementById('formMessage');

            // Simple form validation
            if (!name || !email || !message) {
                formMessage.innerText = 'Please fill in all fields.';
                formMessage.style.color = 'red';
                return;
            }

            formMessage.innerText = 'Form submitted successfully.';
            formMessage.style.color = 'green';
            $document.ready()
        }
    </script>

    <?php
    include "connixen.php";

    if (isset($_POST['btn'])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $stmt = $con->prepare("INSERT INTO reports (Nom_botique, Email, Message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            
            echo '<script>
                document.getElementById("formMessage").innerText = "Form submitted successfully.";
                document.getElementById("formMessage").style.color = "green";
                $(document).ready()
            </script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>
</body>
</html>
