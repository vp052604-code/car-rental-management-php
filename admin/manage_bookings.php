<?php 
// Database connection include karein
include('includes/db.php'); 

$message = "";

// Nayi Booking Add karne ka logic
if(isset($_POST['add_booking'])){
    $car_id = $_POST['car_id'];
    $customer_id = $_POST['customer_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_price = $_POST['total_price'];
    
    // Database mein booking insert karne ki query
    $query = "INSERT INTO bookings (car_id, customer_id, start_date, end_date, total_price) 
              VALUES ('$car_id', '$customer_id', '$start_date', '$end_date', '$total_price')";
    
    if(mysqli_query($conn, $query)){
        // Booking successful hone par Car ka status 'Rented' update kar dein
        mysqli_query($conn, "UPDATE cars SET status='Rented' WHERE id='$car_id'");
        $message = "Car Booked Successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Layout files include karein
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<main class="main-content">
    <h1>Manage Bookings</h1>
    
    <?php if($message != "") { echo "<p class='success-msg'>$message</p>"; } ?>

    <!-- Booking Form -->
    <div class="add-form">
        <h3>Create New Booking</h3><br>
        <form action="" method="POST">
            
            <!-- Cars Dropdown -->
            <select name="car_id" id="car_id" required class="form-select" onchange="calculatePrice()">
                <option value="" data-price="0">-- Select Car --</option>
                <?php
                $cars = mysqli_query($conn, "SELECT * FROM cars WHERE status='Available'");
                while($c = mysqli_fetch_assoc($cars)){
                    echo "<option value='".$c['id']."' data-price='".$c['price_per_day']."'>".$c['car_name']." (".$c['brand'].") - ₹".$c['price_per_day']."/day</option>";
                }
                ?>
            </select>

            <!-- Customers Dropdown -->
            <select name="customer_id" required class="form-select">
                <option value="">-- Select Customer --</option>
                <?php
                $custs = mysqli_query($conn, "SELECT * FROM customers");
                while($cu = mysqli_fetch_assoc($custs)){
                    echo "<option value='".$cu['id']."'>".$cu['name']." (".$cu['phone'].")</option>";
                }
                ?>
            </select><br><br>

            <input type="date" name="start_date" id="start_date" required title="Start Date" onchange="calculatePrice()">
            <input type="date" name="end_date" id="end_date" required title="End Date" onchange="calculatePrice()">
            <input type="number" name="total_price" id="total_price" placeholder="Total Price (₹)" required readonly>
            
            <button type="submit" name="add_booking" class="btn-primary">Book Car</button>
        </form>
    </div>

    <!-- Bookings List Header -->
    <div class="section-header-row">
        <h3 class="section-title-marginless">All Bookings</h3>
        <a href="download_pdf.php" class="btn-success">Download PDF Report</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <!-- ID ki jagah Sr. No. kiya -->
                <th>Sr. No.</th> 
                <th>Car Name</th>
                <th>Customer Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Bill</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Pagination Logic
            $limit = 5; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            if($page < 1) $page = 1;
            $offset = ($page - 1) * $limit;

            // Get total records
            $total_query = "SELECT COUNT(*) as total FROM bookings";
            $total_result = mysqli_query($conn, $total_query);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_records = $total_row['total'];
            $total_pages = ceil($total_records / $limit);

            // JOIN query to fetch actual names with LIMIT
            $fetch_query = "
                SELECT bookings.*, cars.car_name, customers.name AS customer_name 
                FROM bookings 
                JOIN cars ON bookings.car_id = cars.id 
                JOIN customers ON bookings.customer_id = customers.id 
                ORDER BY bookings.id DESC
                LIMIT $limit OFFSET $offset
            ";
            $result = mysqli_query($conn, $fetch_query);

            if(mysqli_num_rows($result) > 0){
                
                $sr_no = $offset + 1; // 1. Variable yahan shuru kiya based on offset
                
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    
                    // 2. Database ID ki jagah Serial Number print kiya
                    echo "<td>" . $sr_no . "</td>"; 
                    
                    echo "<td>" . $row['car_name'] . "</td>";
                    echo "<td>" . $row['customer_name'] . "</td>";
                    echo "<td>" . date('d M Y', strtotime($row['start_date'])) . "</td>";
                    echo "<td>" . date('d M Y', strtotime($row['end_date'])) . "</td>";
                    echo "<td>₹" . $row['total_price'] . "</td>";
                    echo "</tr>";
                    
                    // 3. Har row ke baad number badhaya
                    $sr_no++;
                }
            } else {
                echo "<tr><td colspan='6'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <?php if(isset($total_pages) && $total_pages > 1): ?>
    <div class="pagination-container">
        <ul class="pagination">
            <?php if($page > 1): ?>
                <li><a href="?page=<?php echo $page-1; ?>">&laquo; Prev</a></li>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li><a href="?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            
            <?php if($page < $total_pages): ?>
                <li><a href="?page=<?php echo $page+1; ?>">Next &raquo;</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>
</main>

<script>
function calculatePrice() {
    var carSelect = document.getElementById("car_id");
    var selectedOption = carSelect.options[carSelect.selectedIndex];
    
    // Get the price per day from data attribute
    var pricePerDay = parseFloat(selectedOption.getAttribute("data-price")) || 0;
    
    var startDateStr = document.getElementById("start_date").value;
    var endDateStr = document.getElementById("end_date").value;
    
    // Only calculate if all fields are filled
    if (pricePerDay > 0 && startDateStr && endDateStr) {
        var start = new Date(startDateStr);
        var end = new Date(endDateStr);
        
        // Calculate difference in milliseconds
        var timeDiff = end.getTime() - start.getTime();
        
        // Convert to days
        var daysDiff = timeDiff / (1000 * 3600 * 24);
        
        if (daysDiff >= 0) {
            // If same day return, charge for at least 1 day
            var totalDays = (daysDiff === 0) ? 1 : daysDiff;
            
            var totalPrice = pricePerDay * totalDays;
            document.getElementById("total_price").value = totalPrice;
        } else {
            // Reset if end date is before start date
            document.getElementById("total_price").value = "";
        }
    }
}
</script>

<?php include('includes/footer.php'); ?>