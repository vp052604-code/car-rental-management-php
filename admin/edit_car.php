<?php 
// Include database and layout files
include('includes/db.php'); 
include('includes/header.php'); 
include('includes/sidebar.php'); 

// 1. Fetch existing car details to display in the form
if(isset($_GET['id'])){
    $car_id = $_GET['id'];
    $fetch_query = "SELECT * FROM cars WHERE id='$car_id'";
    $result = mysqli_query($conn, $fetch_query);
    $car = mysqli_fetch_assoc($result);
}

// 2. Handle the update process when the form is submitted
if(isset($_POST['update_car'])){
    $update_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $brand = $_POST['brand'];
    $price = $_POST['price_per_day'];
    
    // Check if a new image is uploaded
    if(isset($_FILES['car_image']) && $_FILES['car_image']['error'] == 0){
        $image_name = $_FILES['car_image']['name'];
        $tmp_name = $_FILES['car_image']['tmp_name'];
        $upload_path = "uploads/" . $image_name;
        
        if(move_uploaded_file($tmp_name, $upload_path)){
            // Query with image update
            $update_query = "UPDATE cars SET car_name='$car_name', brand='$brand', price_per_day='$price', image_path='$image_name' WHERE id='$update_id'";
        } else {
            echo "<script>alert('Failed to upload new image. Keeping old image.');</script>";
            $update_query = "UPDATE cars SET car_name='$car_name', brand='$brand', price_per_day='$price' WHERE id='$update_id'";
        }
    } else {
        // Query without image update
        $update_query = "UPDATE cars SET car_name='$car_name', brand='$brand', price_per_day='$price' WHERE id='$update_id'";
    }
    
    if(mysqli_query($conn, $update_query)){
        // Redirect back to manage_cars.php using JavaScript
        echo "<script>
                alert('Car Details Updated Successfully!');
                window.location.href='manage_cars.php';
              </script>";
    } else {
        echo "<script>alert('Error updating record.');</script>";
    }
}
?>

<main class="main-content">
    <h1>Edit Car Details</h1>
    
    <div class="add-form">
        <h3>Update <?php echo $car['car_name']; ?></h3><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Hidden input to send the ID -->
            <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
            
            <div class="form-group">
                <label>Car Name:</label><br>
                <!-- Value attribute pre-fills the current data -->
                <input type="text" name="car_name" value="<?php echo $car['car_name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Brand:</label><br>
                <input type="text" name="brand" value="<?php echo $car['brand']; ?>" required>
            </div>

            <div class="form-group">
                <label>Update Image (Leave blank to keep current):</label><br>
                <input type="file" name="car_image" accept="image/*">
            </div>

            <div class="form-group">
                <label>Price Per Day ($):</label><br>
                <input type="number" name="price_per_day" value="<?php echo $car['price_per_day']; ?>" required>
            </div>

            <button type="submit" name="update_car" class="btn-primary">Update Car</button>
            <a href="manage_cars.php" class="btn-danger ml-10">Cancel</a>
        </form>
    </div>
</main>

<?php include('includes/footer.php'); ?>