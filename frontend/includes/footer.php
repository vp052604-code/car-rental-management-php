</div> <!-- End of main-content -->

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h2><i class="fa-solid fa-car-side" style="color: var(--primary);"></i> Drive<span>X</span></h2>
                <p>Experience the ultimate drive with our premium car rental service. We offer a wide range of luxury, sports, and comfortable family vehicles.</p>
            </div>
            
            <div>
                <h3 class="footer-heading">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="cars.php">Car Fleet</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-heading">Legal</h3>
                <ul class="footer-links">
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cancellation Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="footer-heading">Contact Us</h3>
                <ul class="footer-contact">
                    <li><i class="fa-solid fa-location-dot"></i> 123 Premium Street, NY 10001</li>
                    <li><i class="fa-solid fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fa-solid fa-envelope"></i> support@drivex.com</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> DriveX Car Rentals. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    // Mobile Menu Toggle
    document.addEventListener("DOMContentLoaded", function() {
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const navMenu = document.getElementById("nav-menu");
        
        if (mobileMenuBtn && navMenu) {
            mobileMenuBtn.addEventListener("click", function() {
                navMenu.classList.toggle("active");
                const icon = mobileMenuBtn.querySelector("i");
                if (navMenu.classList.contains("active")) {
                    icon.classList.remove("fa-bars");
                    icon.classList.add("fa-xmark");
                } else {
                    icon.classList.remove("fa-xmark");
                    icon.classList.add("fa-bars");
                }
            });
        }
    });
</script>
</body>
</html>
