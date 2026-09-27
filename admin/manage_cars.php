<?php 
include('includes/db.php'); 

// Naya Logic: Gaadi wapas aane par status 'Available' karna
if(isset($_GET['return_id'])){
    $return_id = $_GET['return_id'];
    mysqli_query($conn, "UPDATE cars SET status='Available' WHERE id='$return_id'");
    header("Location: manage_cars.php"); 
    exit();
}

// Delete Logic
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM cars WHERE id='$delete_id'");
    header("Location: manage_cars.php"); 
    exit();
}

$message = "";

// Nayi Car Add karne ka logic (Updated with Error Handling)
if(isset($_POST['add_car'])){
    $car_name = $_POST['car_name'];
    $brand = $_POST['brand'];
    $price = $_POST['price_per_day'];
    
    // Check karein ki kya array exist karta hai aur file aayi hai
    if(isset($_FILES['car_image']) && $_FILES['car_image']['error'] == 0){
        $image_name = $_FILES['car_image']['name'];
        $tmp_name = $_FILES['car_image']['tmp_name'];
        $upload_path = "uploads/" . $image_name;
        
        // Move the file to the uploads folder
        if(move_uploaded_file($tmp_name, $upload_path)){
            $query = "INSERT INTO cars (car_name, brand, image_path, price_per_day, status) VALUES ('$car_name', '$brand', '$image_name', '$price', 'Available')";
            if(mysqli_query($conn, $query)){
                $message = "New Car Added Successfully with Image!";
            } else {
                $message = "Database Error: " . mysqli_error($conn);
            }
        } else {
            $message = "Failed to move uploaded image to folder.";
        }
    } else {
        $message = "Please select a valid image file.";
    }
}

include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<main class="main-content">
    <h1>Manage Cars</h1>
    
    <?php if($message != "") { echo "<p class='success-msg'>$message</p>"; } ?>

    <!-- Car Add Form -->
    <div class="add-form">
        <h3>Add New Car</h3><br>
        <form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="car_name" placeholder="Car Name" required>
    <input type="text" name="brand" placeholder="Brand" required>
    <input type="file" name="car_image" accept="image/*" required class="mb-15">
            <div class="price-input-row">
                <input type="number" name="price_per_day" placeholder="Price/Day ($)" required class="price-input">
                <button type="submit" name="add_car" class="btn-primary btn-add-car">Add Car</button>
            </div>
</form>
    </div>

    <!-- Cars Table -->
    <h3>All Cars</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Sr. No.</th> <!-- ID ki jagah Sr. No. kiya -->
                <th>Car Name</th>
                <th>Brand</th>
                <th>Price/Day</th>
                <th>Status</th>
                <th>Action</th>
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
            $total_query = "SELECT COUNT(*) as total FROM cars";
            $total_result = mysqli_query($conn, $total_query);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_records = $total_row['total'];
            $total_pages = ceil($total_records / $limit);

            // Fetch query with LIMIT
            $fetch_query = "SELECT * FROM cars ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $fetch_query);

            if(mysqli_num_rows($result) > 0){
                $sr_no = $offset + 1; // Counter yahan se shuru hoga based on page
                
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>" . $sr_no . "</td>"; // Database ID ki jagah counter print kiya
                    echo "<td>" . $row['car_name'] . "</td>";
                    echo "<td>" . $row['brand'] . "</td>";
                    echo "<td>₹" . $row['price_per_day'] . "</td>";
                    $current_status = empty($row['status']) ? 'Available' : $row['status'];
                    
                    // Alag-alag status ke liye css classes
                    $badge_class = ($current_status == 'Rented') ? 'status-badge rented' : 'status-badge';
                    echo "<td><span class='$badge_class'>" . $current_status . "</span></td>";
                    
                    // Action Column ke Buttons
                    echo "<td>";
                    
                    // Agar gaadi rented hai, tabhi Return button dikhao
                    if($current_status == 'Rented'){
                        echo "<a href='manage_cars.php?return_id=" . $row['id'] . "' class='btn-warning'>Return</a> ";
                    }
                    
                    // Edit Button (Passes the car ID to edit_car.php)
                    echo "<a href='edit_car.php?id=" . $row['id'] . "' class='btn-info'>Edit</a> ";

                    // Delete button hamesha dikhega
                    echo "<a href='manage_cars.php?delete_id=" . $row['id'] . "' class='btn-danger' onclick=\"return confirm('Kya aap sach mein is gaadi ko delete karna chahte hain?');\">Delete</a>";
                    
                    echo "</td>";
                    echo "</tr>";
                    
                    $sr_no++; // Har row ke baad counter 1 badh jayega
                }
            } else {
                echo "<tr><td colspan='6'>No cars found in database.</td></tr>";
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

<?php include('includes/footer.php'); ?>