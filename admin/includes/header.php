<?php
session_start();
// Agar admin login nahi hai, toh wapas login page par bhej do
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Admin Panel</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Top Navbar -->
    <header class="admin-header">
        <div class="header-left">
            <h2><i class="fa-solid fa-car-rear"></i>Drive X</h2>
            <span class="admin-badge">ADMIN</span>
        </div>
        
        <div class="header-right">
            <div class="admin-profile">
                <div class="avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="profile-info">
                    <span class="greeting">Welcome back,</span>
                    <span class="name">Admin</span>
                </div>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </header>

    <!-- Main Container Shuru (Sidebar aur Main Content yahan se ek sath aayenge) -->
    <div class="admin-container">