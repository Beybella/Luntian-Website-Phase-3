<?php 
    $pageTitle = "Products";
    $activePage = "products";
    include 'includes/db.php'; // Make sure this path is correct
    include 'includes/header.php'; 
?>

    <section id="products" class="products">
        <div class="container">
            <div class="section-header">
                <h2>Our Products</h2>
                <p>Beautiful arrangements for every occasion</p>
            </div>
            
            <div class="product-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="birthday">Birthday</button>
                <button class="filter-btn" data-filter="anniversary">Anniversary</button>
                <button class="filter-btn" data-filter="sympathy">Sympathy</button>
            </div>

            <div class="product-grid">
                <?php 
                // FETCH PRODUCTS FROM DATABASE
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0):
                    while($product = $result->fetch_assoc()): 
                ?>
                <div class="product-card" data-category="<?php echo $product['category']; ?>" data-id="<?php echo $product['id']; ?>">
                    <div class="product-image">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['description']; ?></p>
                        <div class="product-price">₱<?php echo number_format($product['price'], 2); ?></div>
                        <button class="btn btn-small add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
                <?php 
                    endwhile; 
                else:
                    echo "<p>No products found.</p>";
                endif;
                ?>
            </div>
        </div>
    </section>

    <div id="inquiryModal" class="modal-overlay">
        <div class="modal-card">
            <span class="close-btn" id="closeModal">×</span>
            <h3 id="modalProductName">Product</h3>
            <p class="modal-price" id="modalProductPrice">₱0</p>
            <p class="modal-message"></p>
            <div class="modal-actions">
                <button id="modalOkBtn" class="ok-btn">OK</button>
                <a href="cart.php" class="contact-btn">View Cart</a> 
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>