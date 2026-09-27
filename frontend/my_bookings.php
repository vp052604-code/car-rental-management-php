<?php 
include('includes/header.php'); 

if(!isset($_SESSION['customer_id'])){
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$customer_id = $_SESSION['customer_id'];
?>

<div class="page-header">
    <div class="container">
        <h1>My <span class="text-primary"> Bookings</span></h1>
        <p class="text-lg text-white-muted mt-16">Manage and view your current and past trip details.</p>
    </div>
</div>

<div class="container py-80">
    
    <div class="bg-white p-40 rounded-lg shadow-sm border-light my-bookings-container">
        
        <h2 class="text-dark text-3xl mb-32 pb-16 d-flex items-center gap-12 booking-history-title">
            <i class="fa-solid fa-clock-rotate-left text-primary"></i> Booking History
        </h2>
        
        <?php
        $query = "SELECT bookings.*, cars.car_name, cars.brand 
                  FROM bookings 
                  JOIN cars ON bookings.car_id = cars.id 
                  WHERE bookings.customer_id = '$customer_id' 
                  ORDER BY bookings.id DESC";
                  
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <div class="border-light rounded-md p-24 mb-24 d-flex justify-between items-center flex-wrap gap-24 bg-light booking-card">
                    
                    <div>
                        <h3 class="text-dark text-xl mb-8 d-flex items-center gap-8">
                            <?php echo htmlspecialchars($row['car_name']); ?> 
                            <span class="font-medium bg-white border-light rounded-full text-muted px-12 py-2 booking-brand-badge"><?php echo htmlspecialchars($row['brand']); ?></span>
                        </h3>
                        <p class="text-muted mb-8 booking-id-text"><i class="fa-solid fa-hashtag text-muted"></i> Booking ID: #<?php echo htmlspecialchars($row['id']); ?></p>
                        <p class="text-main font-medium booking-dates-text"><i class="fa-regular fa-calendar-days text-primary booking-calendar-icon"></i> Trip Dates: <?php echo date('d M Y', strtotime($row['start_date'])); ?> <span class="text-muted booking-date-separator">to</span> <?php echo date('d M Y', strtotime($row['end_date'])); ?></p>
                    </div>
                    
                    <div class="text-right d-flex flex-col items-center gap-16 booking-action-col">
                        <div class="text-3xl font-extrabold booking-price">
                            $<?php echo htmlspecialchars($row['total_price']); ?>
                        </div>
                        <a href="download_receipt.php?id=<?php echo $row['id']; ?>" class="btn btn-dark d-inline-flex items-center gap-8 btn-download-receipt">
                            <i class="fa-solid fa-file-pdf"></i> Download Receipt
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='empty-state'>";
            echo "<i class='fa-solid fa-receipt text-muted mb-24 empty-state-icon'></i>";
            echo "<h3 class='text-dark mb-12'>You haven't booked any cars yet.</h3>";
            echo "<p class='text-muted mb-24'>Explore our premium fleet and start your journey today!</p>";
            echo "<a href='cars.php' class='btn btn-primary'>Browse Fleet</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>