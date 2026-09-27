<?php 
session_start();
include('../admin/includes/db.php');

$message = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email'");
    if(mysqli_num_rows($check_email) > 0){
        $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Email already registered! Please login.</div>";
    } else {
        // Password ko secure hash mein convert karein
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO customers (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$hashed_password')";
        if(mysqli_query($conn, $query)){
            echo "<script>alert('Registration Successful! Please Login.'); window.location.href='login.php';</script>";
            exit();
        } else {
            $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Something went wrong!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Premium Car Rental</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card auth-card-wide">
        <h2>Create Account</h2>
        <p class="text-center text-muted mb-32 mt-neg-24">Join us and experience the premium drive.</p>
        
        <?php echo $message; ?>
        
        <form action="" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" name="name" class="form-control with-icon" required placeholder="John Doe">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-phone input-icon"></i>
                        <input type="text" name="phone" class="form-control with-icon" required placeholder="Enter mobile number">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control with-icon" required placeholder="name@example.com">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control with-icon" required placeholder="Create a strong password">
                    </div>
                </div>
            </div>
            
            <button type="submit" name="register" class="btn btn-primary mt-16 w-full">Sign Up</button>
        </form>
        
        <div class="auth-links">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</div>

</body>
</html>