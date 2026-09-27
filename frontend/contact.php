<?php 
include('includes/header.php'); 

$success_message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_contact'])){
    // For now, we just simulate a successful message send.
    // In a real application, you'd insert this into a database or send an email.
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $success_message = "<div class='alert alert-success mb-24'><i class='fa-solid fa-circle-check'></i> Thank you, $name! Your message has been sent successfully. We will get back to you soon.</div>";
}
?>

<div class="page-header">
    <div class="container">
        <h1>Contact 
            <span class="text-primary">Us</span></h1>
        <p class="text-lg text-white-muted mt-16">We'd love to hear from you. Get in touch with our team for any inquiries.</p>
    </div>
</div>

<div class="container py-80">
    
    <div class="d-grid gap-40" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
        
        <!-- Contact Info Side -->
        <div class="bg-white p-40 rounded-lg shadow-sm border-light">
            <h2 class="text-3xl mb-24">Get In Touch</h2>
            <p class="text-muted mb-40 text-lg">Whether you have a question about our fleet, pricing, or anything else, our team is ready to answer all your questions.</p>
            
            <div class="d-flex items-center gap-20 mb-32">
                <div class="rounded-full bg-light d-flex items-center justify-center text-primary text-xl" style="width: 50px; height: 50px; flex-shrink: 0; background: rgba(249, 115, 22, 0.1);">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h4 class="text-lg mb-8">Our Address</h4>
                    <p class="text-muted" style="font-size: 15px;">123 Premium Street<br>New York, NY 10001</p>
                </div>
            </div>
            
            <div class="d-flex items-center gap-20 mb-32">
                <div class="rounded-full bg-light d-flex items-center justify-center text-primary text-xl" style="width: 50px; height: 50px; flex-shrink: 0; background: rgba(249, 115, 22, 0.1);">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <h4 class="text-lg mb-8">Email Us</h4>
                    <p class="text-muted" style="font-size: 15px;">support@drivex.com<br>info@drivex.com</p>
                </div>
            </div>
            
            <div class="d-flex items-center gap-20">
                <div class="rounded-full bg-light d-flex items-center justify-center text-primary text-xl" style="width: 50px; height: 50px; flex-shrink: 0; background: rgba(249, 115, 22, 0.1);">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h4 class="text-lg mb-8">Call Us</h4>
                    <p class="text-muted" style="font-size: 15px;">+1 (555) 123-4567<br>Mon-Fri, 9am - 6pm</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Form Side -->
        <div class="bg-white p-40 rounded-lg shadow-lg border-light">
            <h2 class="text-3xl mb-8">Send a Message</h2>
            <p class="text-muted mb-24" style="font-size: 15px;">Fill out the form below and we will contact you shortly.</p>
            
            <?php echo $success_message; ?>
            
            <form action="" method="POST">
                <div class="d-grid gap-20 mb-20" style="grid-template-columns: 1fr 1fr;">
                    <div>
                        <label class="d-block mb-8 font-medium text-main" style="font-size: 14px;">Your Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div>
                        <label class="d-block mb-8 font-medium text-main" style="font-size: 14px;">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                </div>
                
                <div class="mb-20">
                    <label class="d-block mb-8 font-medium text-main" style="font-size: 14px;">Subject</label>
                    <input type="text" name="subject" class="form-control" required placeholder="How can we help you?">
                </div>
                
                <div class="mb-24">
                    <label class="d-block mb-8 font-medium text-main" style="font-size: 14px;">Message</label>
                    <textarea name="message" class="form-control" rows="5" required placeholder="Write your message here..."></textarea>
                </div>
                
                <button type="submit" name="submit_contact" class="btn btn-primary w-full">Send Message</button>
            </form>
        </div>
        
    </div>
</div>

<?php include('includes/footer.php'); ?>
