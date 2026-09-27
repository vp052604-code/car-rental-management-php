<?php 
// Database connection include karein
include('includes/db.php'); 

$message = "";

// Naya Customer Add karne ka logic
if(isset($_POST['add_customer'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    // Database mein customer insert karne ki query
    $query = "INSERT INTO customers (name, phone, email) VALUES ('$name', '$phone', '$email')";
    if(mysqli_query($conn, $query)){
        $message = "New Customer Added Successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Layout files include karein
include('includes/header.php'); 
include('includes/sidebar.php'); 
?>

<main class="main-content">
    <h1>Manage Customers</h1>
    
    <!-- Success ya Error Message -->
    <?php if($message != "") { echo "<p class='success-msg'>$message</p>"; } ?>

    <!-- Customer Add karne ka Form -->
    <div class="add-form">
        <h3>Add New Customer</h3><br>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Full Name (e.g. Rahul Kumar)" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" name="add_customer" class="btn-primary">Add Customer</button>
        </form>
    </div>

    <!-- Customers List Dikhane wali Table -->
    <h3>All Customers</h3>
    <table class="data-table">
        <thead>
            <tr>
                <!-- ID ko hata kar Sr. No. kar diya -->
                <th>Sr. No.</th> 
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
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
            $total_query = "SELECT COUNT(*) as total FROM customers";
            $total_result = mysqli_query($conn, $total_query);
            $total_row = mysqli_fetch_assoc($total_result);
            $total_records = $total_row['total'];
            $total_pages = ceil($total_records / $limit);

            // Database se customers fetch karne ki query with LIMIT
            $fetch_query = "SELECT * FROM customers ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $fetch_query);

            if(mysqli_num_rows($result) > 0){
                
                $sr_no = $offset + 1; // 1. Variable yahan se shuru kiya based on offset
                
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    
                    // 2. Database ID ki jagah variable print kiya
                    echo "<td>" . $sr_no . "</td>"; 
                    
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                    
                    // 3. Har loop ke baad number ko 1 badha diya
                    $sr_no++; 
                }
            } else {
                echo "<tr><td colspan='4'>No customers found in database.</td></tr>";
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