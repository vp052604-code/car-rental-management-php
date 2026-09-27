<?php 
include('includes/db.php'); 

// Agar admin login ka system banaya hai, toh uski checking yahan aayegi
// if(!isset($_SESSION['admin_logged_in'])){ header("Location: login.php"); }

include('includes/header.php'); 
include('includes/sidebar.php'); 

// 1. Total Cars Count Karein
$cars_query = mysqli_query($conn, "SELECT COUNT(*) AS total_cars FROM cars");
$total_cars = mysqli_fetch_assoc($cars_query)['total_cars'];

// 2. Total Customers Count Karein
$cust_query = mysqli_query($conn, "SELECT COUNT(*) AS total_cust FROM customers");
$total_customers = mysqli_fetch_assoc($cust_query)['total_cust'];

// 3. Total Earnings (Kamai) Calculate Karein
$earning_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_earning FROM bookings");
$total_earning = mysqli_fetch_assoc($earning_query)['total_earning'];
if($total_earning == "") { $total_earning = 0; } // Agar koi booking na ho
?>

<main class="main-content">
    <h1>Dashboard Overview</h1>
    
    <div class="dashboard-cards">
        <!-- Card 1: Total Cars -->
        <div class="dashboard-card card-blue">
            <div>
                <h3>Total Cars</h3>
                <p class="dashboard-card-value"><?php echo $total_cars; ?></p>
            </div>
            <i class="fa-solid fa-car fa-3x"></i>
        </div>

        <!-- Card 2: Total Customers -->
        <div class="dashboard-card card-green">
            <div>
                <h3>Registered Customers</h3>
                <p class="dashboard-card-value"><?php echo $total_customers; ?></p>
            </div>
            <i class="fa-solid fa-users fa-3x"></i>
        </div>

        <!-- Card 3: Total Revenue -->
        <div class="dashboard-card card-yellow">
            <div>
                <h3>Total Earnings</h3>
                <p class="dashboard-card-value">₹<?php echo $total_earning; ?></p>
            </div>
            <i class="fa-solid fa-indian-rupee-sign fa-3x"></i>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>