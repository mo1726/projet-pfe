<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Style/platform2.css"> 
    <link rel="website icon"  type="png" href="image/MD-removebg-preview.png">
    <link rel="stylesheet" href="css/all.min.css"> 
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300&display=swap');
</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script>
    $(document).ready(function(){
      $('#email,#password').focus(function(){
        $(this).css('text-align', 'left');
      });

  
    });
 </script>
</head>
<body>
    <div class="box">
        <img src="image/MD-removebg-preview.png" alt="">
        
        <form  method="post">
            <!-- <label for="email">Email:</label> -->
            <input type="email" name="email" id="email" placeholder="Email">
            
            <input type="password" name="password" id="password" placeholder="Password"><br>
            <label for="check">Remember me 
                <input type="checkbox" name="remember" id="check">
            </label>
            <a href="#" class="login">Forgot password</a><br><br>
            <input type="submit" value="Login" name="btn">
        </form>
    </div>
    <div class="boox">
        
        <a href="platform.php.#conneion">Sign Up</a>
    </div>
    <?php
// login.php (or the file where you have your login logic)

include "connixen.php";

if (isset($_POST['btn'])) {
    $Email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM client WHERE Email=? AND Password=?");
    $stmt->bind_param("ss", $Email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($Email == "mlahrech123@gmail.com" && $password == 260100) {
        // If the user is an admin
        session_start();
        $_SESSION['admin'] = true;
        header("Location: admine.php");
        exit();
    } elseif ($result->num_rows > 0) {
        // If the user is a regular user
        session_start();
        $_SESSION['Email'] = $Email; // Store Email in session
        header("Location: dashbord.php");
        exit();
    }

    $stmt->close();
    $con->close();
}
?>


</body>
</html>
