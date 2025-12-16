<?php 
$pageTitle = "Contact Us";
include 'includes/header.php'; 
?>

    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Contact Us</h2>
                <p>We'd love to hear from you</p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-item">
                        <h3>Phone</h3>
                        <p>+63 912 345 6789</p>
                    </div>
                    <div class="info-item">
                        <h3>Email</h3>
                        <p>hello@luntian.ph</p>
                    </div>
                    <div class="info-item">
                        <h3>Location</h3>
                        <p>Metro Manila, Philippines</p>
                    </div>
                    <div class="info-item">
                        <h3>Hours</h3>
                        <p>Mon-Sun: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
                
                <form class="contact-form" id="contactForm" action="contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="tel" name="phone" placeholder="Your Phone">
                    <select name="subject" required>
                        <option value="">Select Subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="order">Product Question</option>
                        <option value="custom">Custom Order</option>
                        <option value="feedback">Feedback</option>
                    </select>
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>