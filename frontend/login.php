<?php 
session_start();
include('../admin/includes/db.php');

// Agar user pehle se login hai toh usko index.php par bhej do
if(isset($_SESSION['customer_id'])){
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$message = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM customers WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        // Hashed password verify karna
        if(password_verify($password, $row['password'])){
            $_SESSION['customer_id'] = $row['id'];
            $_SESSION['customer_name'] = $row['name'];
            echo "<script>window.location.href='index.php';</script>";
            exit();
        } else {
            $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Incorrect Password!</div>";
        }
    } else {
        $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Email not found! Please register first.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Premium Car Rental</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <?php echo $message; ?>
        
        <form action="" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <div class="position-relative">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control with-icon" required placeholder="Enter your email">
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="position-relative">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control with-icon" required placeholder="Enter your password">
                </div>
            </div>
            
            <div class="d-flex justify-between items-center mb-24">
                <label class="d-flex items-center gap-8 font-light m-0 text-14">
                    <input type="checkbox" class="w-auto m-0"> Remember me
                </label>
                <a href="#" class="text-primary font-medium text-14">Forgot Password?</a>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary w-full">Login to Account</button>
        </form>
        
        <div class="auth-links">
            Don't have an account? <a href="register.php">Sign Up</a>
        </div>
    </div>
</div>

</body>
</html>