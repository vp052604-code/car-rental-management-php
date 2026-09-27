<?php 
include('includes/header.php'); 

// Agar URL mein ID nahi hai, toh home par bhej do
if(!isset($_GET['id'])){
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$car_id = $_GET['id'];
$query = "SELECT * FROM cars WHERE id='$car_id'";
$result = mysqli_query($conn, $query);

// Agar Database mein us ID ki gaadi nahi mili
if(mysqli_num_rows($result) == 0){
    echo "<div class='page-header'><h1>Car Not Found</h1></div>";
    echo "<div class='container text-center py-100'><a href='cars.php' class='btn btn-primary'>Browse Available Cars</a></div>";
    include('includes/footer.php');
    exit();
}

$car = mysqli_fetch_assoc($result);
$img = !empty($car['image_path']) ? "../admin/uploads/".$car['image_path'] : "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80";
?>

<div class="container pt-40 pb-80">
    <a href="cars.php" class="text-primary font-bold d-inline-flex items-center gap-8 mb-24 transition" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
        <i class="fa-solid fa-arrow-left"></i> Back to Fleet
    </a>
    
    <div class="bg-white rounded-lg shadow-xl border-light overflow-hidden d-flex flex-wrap" style="border: 1px solid rgba(0,0,0,0.05);">
        
        <!-- Left Side: Image -->
        <div class="position-relative" style="flex: 1.2; min-width: 320px;">
            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>" class="w-full d-block" style="height: 100%; object-fit: cover; min-height: 350px; max-height: 420px;">
            <?php if($car['status'] == 'Rented'): ?>
                <div class="badge rented shadow-md" style="top: 16px; left: 16px; right: auto; font-size: 13px; padding: 4px 16px;">Currently Rented</div>
            <?php else: ?>
                <div class="badge shadow-md" style="top: 16px; left: 16px; right: auto; font-size: 13px; padding: 4px 16px; color: #10b981; background: #dcfce7; border: 1px solid rgba(16,185,129,0.2);">Available</div>
            <?php endif; ?>
        </div>
        
        <!-- Right Side: Details -->
        <div class="p-24" style="flex: 1; min-width: 320px; display: flex; flex-direction: column;">
            <div class="d-inline-block bg-light text-main rounded-full font-bold mb-8 border-light" style="padding: 4px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                <?php echo htmlspecialchars($car['brand']); ?>
            </div>
            
            <h1 class="text-3xl text-dark mb-4" style="font-weight: 800; line-height: 1.2;">
                <?php echo htmlspecialchars($car['car_name']); ?>
            </h1>
            
            <div class="text-3xl font-extrabold text-primary mb-16 pb-16 d-flex items-baseline" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                $<?php echo htmlspecialchars($car['price_per_day']); ?>
                <span class="text-sm font-medium text-muted" style="margin-left: 8px;">/ day</span>
            </div>
            
            <div class="mb-16 flex-1">
                <h3 class="text-base font-bold text-dark mb-8">Premium Features</h3>
                <div class="d-flex flex-col gap-8">
                    <div class="d-flex items-center gap-12 p-8 rounded-md bg-light border-light transition" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='none'">
                        <i class="fa-solid fa-couch" style="color: var(--primary); width: 20px; text-align: center; font-size: 14px;"></i> 
                        <span class="font-medium text-dark" style="font-size: 14px;">Premium Interior & Comfort</span>
                    </div>
                    <div class="d-flex items-center gap-12 p-8 rounded-md bg-light border-light transition" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='none'">
                        <i class="fa-solid fa-shield-halved" style="color: var(--primary); width: 20px; text-align: center; font-size: 14px;"></i> 
                        <span class="font-medium text-dark" style="font-size: 14px;">Fully Insured Vehicle</span>
                    </div>
                    <div class="d-flex items-center gap-12 p-8 rounded-md bg-light border-light transition" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='none'">
                        <i class="fa-solid fa-headset" style="color: var(--primary); width: 20px; text-align: center; font-size: 14px;"></i> 
                        <span class="font-medium text-dark" style="font-size: 14px;">24/7 Roadside Assistance</span>
                    </div>
                    <div class="d-flex items-center gap-12 p-8 rounded-md bg-light border-light transition" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='none'">
                        <i class="fa-solid fa-gauge-high" style="color: var(--primary); width: 20px; text-align: center; font-size: 14px;"></i> 
                        <span class="font-medium text-dark" style="font-size: 14px;">Unlimited Mileage</span>
                    </div>
                </div>
            </div>
            
            <!-- Booking Actions -->
            <div class="mt-auto pt-16" style="border-top: 1px solid rgba(0,0,0,0.05);">
                <?php if($car['status'] == 'Available'): ?>
                    <?php if(isset($_SESSION['customer_id'])): ?>
                        <a href="book_car.php?car_id=<?php echo $car['id']; ?>" class="btn btn-primary d-flex w-full justify-center items-center gap-8 shadow-md" style="padding: 14px 20px;">
                            <i class="fa-solid fa-calendar-check"></i> Proceed to Booking
                        </a>
                    <?php else: ?>
                        <div class="text-center rounded-md p-16 mb-16" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                            <p class="font-medium text-sm m-0" style="color: #1e3a8a;">Log in to book this vehicle</p>
                        </div>
                        <div class="d-flex gap-12">
                            <a href="login.php" class="btn btn-primary flex-1 justify-center">Login</a>
                            <a href="register.php" class="btn btn-outline flex-1 justify-center">Sign Up</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="btn btn-dark d-flex w-full justify-center items-center gap-8 cursor-not-allowed opacity-70" disabled style="padding: 14px 20px;">
                        <i class="fa-solid fa-clock"></i> Currently Unavailable
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>