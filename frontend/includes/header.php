<?php
session_start();
include('../admin/includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Car Rental</title>
    <!-- New Premium CSS -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>
<body>

<nav class="navbar">
    <div class="container nav-container">
        <a href="index.php" class="nav-logo">
            <i class="fa-solid fa-car-side" style="color: var(--primary);"></i>
            Drive<span>X</span>
        </a>

        <div class="mobile-menu-btn" id="mobile-menu-btn">
            <i class="fa-solid fa-bars"></i>
        </div>

        <div class="nav-menu" id="nav-menu">
            <ul class="nav-links">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="about.php" class="nav-link">About Us</a></li>
                <li><a href="cars.php" class="nav-link">Car Fleet</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
            <div class="nav-actions">
                <?php if(isset($_SESSION['customer_id'])): ?>
                    <a href="my_bookings.php" class="nav-link">My Bookings</a>
                    <span class="user-greeting">Hi, <?php echo $_SESSION['customer_name']; ?></span>
                    <a href="logout.php" class="btn btn-outline" >Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link" style="margin-right: 16px;">Login</a>
                    <a href="register.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">