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

        <?php 
        // 1. Pagination Logic
        $limit = isset($_GET['show']) ? (int)$_GET['show'] : 9;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $limit;

        // 2. Get Total Count
        $total_sql = "SELECT COUNT(*) FROM products";
        $total_result = $conn->query($total_sql);
        $total_rows = $total_result->fetch_row()[0];
        $total_pages = ceil($total_rows / $limit);

        // 3. Fetch Paginated Products
        $sql = "SELECT * FROM products LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);
        ?>

        <div class="product-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while($product = $result->fetch_assoc()): ?>
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
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div> <div class="pagination-container">
            <div class="page-numbers">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?p=<?php echo $i; ?>&show=<?php echo $limit; ?>" 
                       class="page-link <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>

            <div class="show-per-page">
                <span>Show:</span>
                <a href="?p=1&show=9" class="<?php echo ($limit == 9) ? 'active' : ''; ?>">9</a>
                <a href="?p=1&show=12" class="<?php echo ($limit == 12) ? 'active' : ''; ?>">12</a>
                <a href="?p=1&show=18" class="<?php echo ($limit == 18) ? 'active' : ''; ?>">18</a>
            </div>
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