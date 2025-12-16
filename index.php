<?php 
    $pageTitle = "Home";
    $activePage = "home";
    include 'includes/header.php'; 
?>

    <section id="home" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Fresh Blooms, Delivered with Love</h1>
            <p class="hero-subtitle">Premium fresh flowers for Metro Manila and nearby areas</p>
            <div class="hero-buttons">
                <a href="products.php" class="btn btn-primary">Shop Now</a>
                <a href="#contact" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-card">
                    <i class="fa-solid fa-seedling fa-4x" style="color: var(--sage);"></i>            
                    <div class="flower">
                        <h3>Fresh Daily</h3>
                        <p>Sourced daily from trusted local suppliers</p>
                    </div>
                </div>
                <div class="feature-card">
                    <i class="fa fa-truck fa-4x" style="color: var(--sage);"></i>  
                    <div class="truck">                  
                        <h3>Same-Day Delivery</h3>
                        <p>Quick delivery across Metro Manila</p>
                    </div>
                </div>
                <div class="feature-card">
                    <i class="fa fa-map-pin fa-4x" style="color: var(--sage);"></i>    
                    <div class="pin">               
                        <h3>Pickup Available</h3>
                        <p>Convenient pickup location</p>
                    </div>  
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-coins fa-4x" style="color: var(--sage);"></i>  
                    <div class="money">
                        <h3>Affordable Prices</h3>
                        <p>Quality flowers at great value</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="map" class="map-section">
        <div class="container">
            <div class="map-container">
                <div class="map-image">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.28!2d120.99!3d14.6044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8d8d8d8d8d9%3A0x1265doscatillas!2s1265%20Dos%20Castillas%20Street%2C%20Manila%201008!5e0!3m2!1sen!2sph!4v1733745600000" width="100%" height="400" style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="map-address" style="transition-delay: 0.2s;">
                    <h3>Visit Us</h3>
                    <div class="address-details">
                        <p><strong>Luntian Flower Shop</strong></p>
                        <p><a href="#" class="address-link"><i class="fas fa-map-marker-alt"></i> 1265 Dos Castillas Street Corner Laon Laan Road Sampaloc 490 Zone 48 Manila 1008, Metro Manila</a></p>
                        <p class="phone"><a href="tel:+639123456789"><i class="fas fa-phone"></i> +63 912 345 6789</a></p>
                        <p class="email"><a href="mailto:hello@luntian.ph"><i class="fas fa-envelope"></i> hello@luntian.ph</a></p>
                        <p class="Facebook"><a href="https://www.facebook.com/luntianflowershop" target="_blank"><i class="fab fa-facebook-f"></i> Luntian Flower Shop</a></p>
                        <p class="Instagram"><a href="https://www.instagram.com/luntianflowershop" target="_blank"><i class="fab fa-instagram"></i> luntianflowershop</a></p>
                        <p class="TikTok"><a href="https://www.tiktok.com/@luntianflowershop" target="_blank"><i class="fab fa-tiktok"></i> luntianflowershop</a></p>
                        <p class="hours"><strong>Business Hours:</strong></p>
                        <p>Monday - Sunday: 9:00 AM - 6:00 PM</p>
                        <p class="note">For special orders, please contact us 24 hours in advance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Contact Us</h2>
                <p>We'd love to hear from you</p>
            </div>
            
            <div class="contact-form-wrapper" style="transition-delay: 0.2s;">
                <form class="contact-form" id="contactForm">
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <input type="tel" placeholder="Your Phone">
                    <select required>
                        <option value="">Select Subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="order">Product Question</option>
                        <option value="custom">Custom Order</option>
                        <option value="feedback">Feedback</option>
                    </select>
                    <textarea rows="5" placeholder="Your Message" required></textarea>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>
<?php include 'includes/footer.php'; ?>