<?php 
include('includes/header.php'); 

// Agar user login nahi hai, toh login page par bhej do
if(!isset($_SESSION['customer_id'])){
    echo "<script>alert('Please login to book a car.'); window.location.href='login.php';</script>";
    exit();
}

// Agar URL mein car_id nahi hai, toh cars page par bhej do
if(!isset($_GET['car_id'])){
    echo "<script>window.location.href='cars.php';</script>";
    exit();
}

$car_id = $_GET['car_id'];
$customer_id = $_SESSION['customer_id'];

// Car ki details fetch karein
$car_query = mysqli_query($conn, "SELECT * FROM cars WHERE id='$car_id'");
if(mysqli_num_rows($car_query) == 0){
    echo "<div class='container text-center py-100'><h2>Car not found!</h2></div>";
    include('includes/footer.php');
    exit();
}
$car = mysqli_fetch_assoc($car_query);

// Agar car already rented hai, toh rok dein
if($car['status'] != 'Available'){
    echo "<div class='container text-center py-100'><h2>Sorry, this car is currently rented.</h2><a href='cars.php' class='btn btn-primary mt-20'>Browse other cars</a></div>";
    include('includes/footer.php');
    exit();
}

$message = "";

// Booking Process
if(isset($_POST['confirm_booking'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    // Dates validation
    if($start_date < date('Y-m-d') || $end_date < $start_date){
        $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Invalid dates selected. Please choose correct dates.</div>";
    } else {
        // Calculate Total Price
        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->days;
        
        // Agar same day book kar raha hai, toh kam se kam 1 din ka charge lagega
        if($days == 0){ $days = 1; }
        
        $total_price = $days * $car['price_per_day'];
        
        // Insert into database
        $query = "INSERT INTO bookings (car_id, customer_id, start_date, end_date, total_price) 
                  VALUES ('$car_id', '$customer_id', '$start_date', '$end_date', '$total_price')";
                  
        if(mysqli_query($conn, $query)){
            // Update car status
            mysqli_query($conn, "UPDATE cars SET status='Rented' WHERE id='$car_id'");
            echo "<script>alert('Booking Confirmed! Total Bill: $$total_price'); window.location.href='my_bookings.php';</script>";
            exit();
        } else {
            $message = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Something went wrong!</div>";
        }
    }
}
?>

<style>
    body {
        background-color: #faf8f5 !important;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0.5;
        cursor: pointer;
    }
    .booking-btn:hover {
        background: var(--primary-hover) !important;
    }
    .py-60 {
        padding-top: 60px;
        padding-bottom: 60px;
    }
    .pb-80 {
        padding-bottom: 80px;
    }
</style>

<div class="container text-center py-60">
    <h1 style="font-size: 3.5rem; font-weight: 900; color: #1a1a1a; letter-spacing: -1px; margin-bottom: 15px;">Complete Your Reservation</h1>
    <p style="font-size: 1.1rem; color: #4a4a4a; margin-bottom:20px;">Review your selection and choose your dates to finalize the booking.</p>
</div>

<div class="container pb-80">
    <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap; max-width: 950px; margin: 0 auto;">
        
        <!-- Left Card (Car Details) -->
        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%; max-width: 400px; border: 1px solid #f0f0f0;">
            <div style="background: #f8f9fa; border-radius: 8px; padding: 30px 20px; text-align: center; margin-bottom: 24px;">
                <?php $img = !empty($car['image_path']) ? "../admin/uploads/".$car['image_path'] : "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80"; ?>
                <img src="<?php echo $img; ?>" alt="Car" style="max-width: 100%; border-radius: 4px; object-fit: contain;">
            </div>
            <h3 style="font-size: 1.6rem; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;"><?php echo htmlspecialchars($car['car_name']); ?></h3>
            <p style="color: #777; margin-bottom: 24px; font-size: 1rem;"><?php echo htmlspecialchars($car['brand']); ?></p>
            
            <hr style="border: 0; border-top: 1px solid #eaeaea; margin-bottom: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #666; font-weight: 500; font-size: 1.05rem;">Rate</span>
                <span><strong style="font-size: 1.25rem; color: #1a1a1a; font-weight: 800;">$<?php echo htmlspecialchars($car['price_per_day']); ?></strong> <span style="color: #888; font-size: 0.9rem;">/ day</span></span>
            </div>
        </div>

        <!-- Right Card (Booking Form) -->
        <div style="background: white; border-radius: 12px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%; max-width: 500px; border: 1px solid #f0f0f0;">
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 28px; display: flex; align-items: center; gap: 8px;">
                📅 Dates & Timing
            </h3>
            
            <?php echo $message; ?>
            
            <form action="" method="POST">
                <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Pickup Date</label>
                        <input type="date" name="start_date" id="start_date" required min="<?php echo date('Y-m-d'); ?>" style="width: 100%; padding: 14px 16px; border: 1px solid #e4e4e4; border-radius: 8px; font-size: 1rem; color: #333; outline: none; box-shadow: 0 2px 5px rgba(0,0,0,0.01);">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Return Date</label>
                        <input type="date" name="end_date" id="end_date" required min="<?php echo date('Y-m-d'); ?>" style="width: 100%; padding: 14px 16px; border: 1px solid #e4e4e4; border-radius: 8px; font-size: 1rem; color: #333; outline: none; box-shadow: 0 2px 5px rgba(0,0,0,0.01);">
                    </div>
                </div>
                
                <div style="background: #f8f9fb; border-radius: 10px; padding: 24px; margin-bottom: 30px;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #333; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        💳 Payment Summary
                    </h4>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="color: #666; font-size: 0.95rem; font-weight: 500;">Total Days</span>
                        <span style="color: #333; font-weight: 700; font-size: 0.95rem;" id="summary_days">0 days</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                        <span style="color: #666; font-size: 0.95rem; font-weight: 500;">Price per Day</span>
                        <span style="color: #333; font-weight: 700; font-size: 0.95rem;">$<?php echo htmlspecialchars($car['price_per_day']); ?></span>
                    </div>
                    
                    <hr style="border: 0; border-top: 1px dashed #d0d0d0; margin-bottom: 20px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #1a1a1a; font-weight: 800; font-size: 1.15rem;">Total Amount</span>
                        <span style="color: #FA8230; font-weight: 900; font-size: 1.3rem;" id="summary_total">$0</span>
                    </div>
                </div>
                
                <button type="submit" name="confirm_booking" class="booking-btn" style="width: 100%; background: #FA8230; color: white; padding: 16px; border: none; border-radius: 8px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: background 0.3s; box-shadow: 0 4px 10px rgba(199, 62, 29, 0.2);">Confirm Reservation</button>
            </form>
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const summaryDays = document.getElementById('summary_days');
    const summaryTotal = document.getElementById('summary_total');
    const pricePerDay = <?php echo floatval($car['price_per_day']); ?>;

    function calculatePrice() {
        const startDateVal = startDateInput.value;
        const endDateVal = endDateInput.value;

        if (startDateVal && endDateVal) {
            const start = new Date(startDateVal);
            const end = new Date(endDateVal);
            
            // Set time to 0 to avoid timezone issues
            start.setHours(0, 0, 0, 0);
            end.setHours(0, 0, 0, 0);

            if (end < start) {
                summaryDays.innerHTML = '<span style="color: #c73e1d;">Invalid</span>';
                summaryTotal.innerHTML = '<span style="color: #c73e1d; font-size: 1rem;">Invalid dates</span>';
                return;
            }

            const diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 0) {
                diffDays = 1; // Minimum 1 day charge
            }

            const totalPrice = diffDays * pricePerDay;
            
            summaryDays.textContent = diffDays + (diffDays === 1 ? ' day' : ' days');
            summaryTotal.textContent = '$' + totalPrice.toFixed(0);
        } else {
            summaryDays.textContent = '0 days';
            summaryTotal.textContent = '$0';
        }
    }

    startDateInput.addEventListener('change', calculatePrice);
    endDateInput.addEventListener('change', calculatePrice);
});
</script>

<?php include('includes/footer.php'); ?>