<?php
// Session start karna zaroori hai taaki login ke baad user ki details yaad rakhi ja sake
session_start();

// Database connection file include karein
include('includes/db.php');

$error = ""; // Error message dikhane ke liye khali variable

// Jab user 'Login' button par click karega
if(isset($_POST['login_btn'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database mein check karne ke liye SQL query
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Agar username aur password match ho jata hai (yani 1 row mil gayi)
    if(mysqli_num_rows($result) == 1){
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        // Login success hone par Dashboard (index.php) par bhej dein
        header("Location: index.php");
        exit();
    } else {
        $error = "Galat Username ya Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Car Rental</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">

<div class="login-container">
    <div class="login-header">
        <div class="login-logo">
            <i class="fa-solid fa-car-rear"></i>
        </div>
        <h2>Drive X Admin</h2>
        <p>Enter your credentials to access the panel</p>
    </div>
    
    <!-- Agar error ho toh yahan dikhayega -->
    <?php if($error != "") { ?>
        <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
    <?php } ?>

    <!-- Login Form -->
    <form action="" method="POST">
        <div class="form-group">
            <label>Username</label>
            <div class="input-icon-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" required placeholder="Enter Username">
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-icon-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" required placeholder="Enter Password">
            </div>
        </div>
        <button type="submit" name="login_btn" class="login-btn"><i class="fa-solid fa-right-to-bracket"></i> Secure Login</button>
    </form>
</div>

</body>
</html>