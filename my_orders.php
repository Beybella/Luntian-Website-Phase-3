<?php 
    $pageTitle = "My Orders";
    include 'includes/db.php';
    include 'includes/header.php'; 

    if (!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
?>

<style>
    .order-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .order-header {
        background-color: var(--olivewood);
        color: var(--parchment);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-body {
        padding: 1.5rem;
    }
    .order-item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--parchment);
        padding: 1rem 0;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }
    .status-badge {
        background: var(--olive);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .order-meta {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid var(--parchment);
        color: var(--bark);
        font-size: 0.95rem;
    }
</style>

<section class="orders" style="min-height: 80vh; padding: 5rem 0; background-color: var(--parchment);">
    <div class="container">
        <div class="section-header">
            <h2>Order History</h2>
            <p>Track your purchases</p>
        </div>

        <div style="max-width: 800px; margin: 0 auto;">
            <?php 
            // 1. Fetch Main Orders
            $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0):
                while($order = $result->fetch_assoc()):
                    $order_id = $order['id'];
                    $formattedDate = date("F j, Y, g:i a", strtotime($order['order_date']));
            ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <strong>Order #<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></strong>
                            <span style="display: block; font-size: 0.85rem; opacity: 0.8;"><?php echo $formattedDate; ?></span>
                        </div>
                        <span class="status-badge"><?php echo htmlspecialchars($order['status']); ?></span>
                    </div>
                    
                    <div class="order-body">
                        <?php 
                        $sqlItems = "SELECT oi.quantity, oi.price_at_purchase, p.name, p.image 
                                     FROM order_items oi 
                                     JOIN products p ON oi.product_id = p.id 
                                     WHERE oi.order_id = ?";
                        $stmtItems = $conn->prepare($sqlItems);
                        $stmtItems->bind_param("i", $order_id);
                        $stmtItems->execute();
                        $resItems = $stmtItems->get_result();

                        while($item = $resItems->fetch_assoc()):
                        ?>
                            <div class="order-item">
                                <img src="<?php echo $item['image']; ?>" alt="Product" class="item-img">
                                <div style="flex-grow: 1;">
                                    <h4 style="margin: 0; color: var(--olivewood); font-size: 1.1rem;"><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <p style="margin: 0; color: var(--sage); font-size: 0.9rem;">
                                        Qty: <?php echo $item['quantity']; ?> x ₱<?php echo number_format($item['price_at_purchase'], 2); ?>
                                    </p>
                                </div>
                                <div style="font-weight: bold; color: var(--bark);">
                                    ₱<?php echo number_format($item['quantity'] * $item['price_at_purchase'], 2); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <div class="order-meta">
                            <div><strong>Payment:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></div>
                            <div style="margin-left: auto; font-size: 1.2rem; color: var(--olivewood);">
                                <strong>Total: ₱<?php echo number_format($order['total_amount'], 2); ?></strong>
                            </div>
                        </div>
                        
                        <div style="margin-top: 1rem; font-size: 0.9rem; color: var(--sage);">
                            <strong>Shipping to:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?>
                        </div>
                    </div>
                </div>
            
            <?php 
                endwhile;
            else: 
            ?>
                <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
                    <i class="fas fa-box-open" style="font-size: 4rem; color: var(--sand); margin-bottom: 1rem;"></i>
                    <p style="color: var(--bark); font-size: 1.2rem;">You haven't placed any orders yet.</p>
                    <a href="products.php" class="btn btn-primary" style="margin-top: 1rem;">Start Shopping</a>
                </div>
            <?php endif; ?>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="profile.php" class="btn btn-secondary">Back to Profile</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>