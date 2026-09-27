<?php include('includes/header.php'); ?>

<div class="page-header">
    <div class="container">
        <h1>Our Premium 
            <span class="text-primary">Fleet</span></h1>
        <p class="text-lg text-white-muted mt-16">Choose from our wide range of luxury and comfortable vehicles designed for your perfect journey.</p>
    </div>
</div>

<div class="container py-80">
    <?php
    // Fetch all available cars
    $query = "SELECT * FROM cars WHERE status = 'Available' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $car_count = mysqli_num_rows($result);

    if($car_count > 0){
        $use_slider = ($car_count > 3);
        
        if($use_slider) {
            echo '<div class="swiper car-slider" style="padding-bottom: 50px;">';
            echo '<div class="swiper-wrapper">';
        } else {
            echo '<div class="grid">';
        }

        while($row = mysqli_fetch_assoc($result)){
            $img = !empty($row['image_path']) ? "../admin/uploads/".$row['image_path'] : "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80";
            
            // Add swiper-slide class if using slider
            $card_class = $use_slider ? 'card swiper-slide' : 'card';
            
            echo "<div class='$card_class' style='height: auto;'>";
            
            echo '<div class="badge text-white" style="background: #10b981; color: white !important;">Available</div>';
            
            echo '<div class="card-img-wrapper">';
            echo "<a href='car_details.php?id=" . $row['id'] . "'><img src='$img' class='card-img' alt='Car'></a>";
            echo '</div>';
            
            echo '<div class="card-content">';
            echo "<h3 class='card-title'>" . htmlspecialchars($row['car_name']) . "</h3>";
            echo "<div class='card-subtitle'>Brand: " . htmlspecialchars($row['brand']) . "</div>";
            echo "<div class='card-price'>$" . htmlspecialchars($row['price_per_day']) . "<span>/ day</span></div>";
            
            echo '<div class="card-actions">';
            echo "<a href='car_details.php?id=" . $row['id'] . "' class='btn btn-outline'>Details</a>";
            
            if(isset($_SESSION['customer_id'])){
                echo "<a href='book_car.php?car_id=" . $row['id'] . "' class='btn btn-primary'>Book Now</a>";
            } else {
                echo "<a href='login.php' class='btn btn-primary'>Login to Book</a>";
            }
            echo '</div>'; // card-actions
            
            echo '</div>'; // card-content
            echo '</div>'; // card
        }

        if($use_slider) {
            echo '</div>'; // swiper-wrapper
            echo '<div class="swiper-pagination"></div>';
            echo '</div>'; // swiper
            
            // Swiper Initialization Script
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    new Swiper(".car-slider", {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                            },
                            1024: {
                                slidesPerView: 3,
                            },
                        }
                    });
                });
            </script>';
        } else {
            echo '</div>'; // grid
        }

    } else {
        echo "<div class='grid'>";
        echo "<div class='empty-state' style='grid-column: 1/-1;'>";
        echo "<i class='fa-solid fa-car-burst text-muted mb-24' style='font-size: 48px;'></i>";
        echo "<h3 class='text-main text-2xl mb-12'>No vehicles available right now</h3>";
        echo "<p class='text-muted'>Please check back later or contact our support team.</p>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<?php include('includes/footer.php'); ?>