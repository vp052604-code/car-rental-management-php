<?php include('includes/header.php'); ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fa-solid fa-star"></i> Top Rated Car Rental
            </div>
            <h1>Experience The Ultimate <span>Drive</span></h1>
            <p>Premium cars for your every need. Book instantly, travel safely, and hit the road in style.</p>
            <div class="hero-btns">
                <a href="#search" class="btn btn-primary">Book Now</a>
                <a href="cars.php" class="btn btn-outline" style="color: white; border-color: white;">View Fleet</a>
            </div>
        </div>
    </div>
</section>

<!-- Floating Search Bar -->
<div class="container" id="search">
    <div class="search-wrapper">
        <div class="search-input-group">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" placeholder="Pickup Location">
        </div>
        <div class="search-input-group">
            <i class="fa-regular fa-calendar-days"></i>
            <input type="date">
        </div>
        <div class="search-input-group">
            <i class="fa-regular fa-calendar-days"></i>
            <input type="date">
        </div>
        <button type="button" class="btn btn-primary search-btn" onclick="window.location.href='cars.php'">Search</button>
    </div>
</div>


<!-- How It Works Section -->
<section class="process-section">
    <div class="container">
        <h4 class="process-subtitle">SIMPLE PROCESS</h4>
        <h2 class="process-title">How It Works</h2>
        <p class="process-desc">Renting a premium car has never been this simple, easy and secure.</p>
        
        <div class="process-grid">
            <div class="process-card">
                <div class="process-number">01</div>
                <h3>Choose Your Car</h3>
                <p>Browse our collection of premium vehicles and find the perfect match for your journey, tailored to your exact needs.</p>
            </div>
            
            <div class="process-card">
                <div class="process-number">02</div>
                <h3>Reserve Online</h3>
                <p>Select your dates and locations, then easily reserve your car using our secure 100% online booking system.</p>
            </div>
            
            <div class="process-card">
                <div class="process-number">03</div>
                <h3>Pick Up & Drive</h3>
                <p>Your vehicle will be prepped, detailed and ready for you upon arrival. Simply grab the keys and hit the open road.</p>
            </div>
        </div>
    </div>
</section>

<!-- Premium Difference Section -->
<section class="difference-section">
    <div class="container">
        <h4 class="process-subtitle" style="text-align: center;">OUR PREMIUM DIFFERENCE</h4>
        <h2 class="difference-title">Built for Modern Drivers</h2>
        
        <div class="difference-grid">
            <div class="difference-card">
                <div class="difference-icon">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
                <h3>100% Digital Experience</h3>
                <p>Skip long lines at the counter. Our advanced process lets you easily manage your trip online.</p>
            </div>
            
            <div class="difference-card">
                <div class="difference-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3>Seamless Drop-offs</h3>
                <p>Easily return your car at any of our authorized drop-off zones, designed to fit your busy schedule.</p>
            </div>
            
            <div class="difference-card">
                <div class="difference-icon">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <h3>No Hidden Fees</h3>
                <p>Clear prices and straightforward policies. What you see on the screen is exactly what you pay.</p>
            </div>
            
            <div class="difference-card">
                <div class="difference-icon">
                    <i class="fa-solid fa-rotate-right"></i>
                </div>
                <h3>Flexible Cancellations</h3>
                <p>Plans change. Easily cancel or modify your reservation within 24 hours of pick up.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="testimonial-section">
    <div class="container">
        <h4 class="process-subtitle" style="text-align: center;">VERIFIED REVIEWS</h4>
        <h2 class="difference-title">Loved by Drivers Worldwide</h2>
        
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="review-text">"Absolutely phenomenal service. The whole process was seamless and the car was in flawless condition. I'll certainly use them again."</p>
                <div class="divider"></div>
                <div class="reviewer-info">
                    <h4>Alex Harrison</h4>
                    <p>Rented Tesla Model 3 — New York</p>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="review-text">"They made renting a high-end luxury car so easy. Customer support was incredibly helpful in answering all my questions."</p>
                <div class="divider"></div>
                <div class="reviewer-info">
                    <h4>Sarah Lee</h4>
                    <p>Rented BMW 5 Series — Los Angeles</p>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="review-text">"The best car rental experience I've ever had. No hidden fees, great app interface, and the Porsche Macan was a dream to drive."</p>
                <div class="divider"></div>
                <div class="reviewer-info">
                    <h4>Marcus Sterling</h4>
                    <p>Rented Porsche Macan — Miami</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3 class="stat-number">1500+</h3>
                <p class="stat-title">Happy Customers</p>
            </div>
            <div class="stat-card">
                <h3 class="stat-number">50+</h3>
                <p class="stat-title">Premium Cars</p>
            </div>
            <div class="stat-card">
                <h3 class="stat-number">10+</h3>
                <p class="stat-title">Years Experience</p>
            </div>
            <div class="stat-card">
                <h3 class="stat-number">24/7</h3>
                <p class="stat-title">Support Available</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-container">
            <div class="faq-item" style="animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; animation-delay: 0.1s;">
                <div class="faq-question">
                    What do I need to rent a car?
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>To rent a car, you will need a valid driver's license, a credit or debit card in your name for the deposit, and you must be at least 21 years old.</p>
                </div>
            </div>
            
            <div class="faq-item" style="animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; animation-delay: 0.2s;">
                <div class="faq-question">
                    Is insurance included in the rental price?
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Basic comprehensive insurance is included with every rental. We also offer premium insurance packages at the counter for additional peace of mind.</p>
                </div>
            </div>
            
            <div class="faq-item" style="animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; animation-delay: 0.3s;">
                <div class="faq-question">
                    Can I return the car to a different location?
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer one-way rentals! Please note that an additional drop-off fee may apply depending on the return location you choose.</p>
                </div>
            </div>
            
            <div class="faq-item" style="animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both; animation-delay: 0.4s;">
                <div class="faq-question">
                    What happens if I return the car late?
                    <i class="fa-solid fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p>We offer a 1-hour grace period for all returns. After that, you may be charged for an additional day at the standard daily rate.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => {
                // Close other open items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
                // Toggle current item
                item.classList.toggle('active');
            });
        });
    });
</script>

<?php include('includes/footer.php'); ?>