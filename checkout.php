<?php 
    $pageTitle = "Checkout";
    include 'includes/db.php';
    include 'includes/header.php'; 

    // 1. Force Login
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login to checkout.'); window.location.href='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $cartItems = [];
    $deliveryFee = 150;

    // 2. RECEIVE CART DATA (From cart.php)
    // If coming from cart.php, decode JSON. If refreshing page, use Session.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_data'])) {
        $cartItems = json_decode($_POST['cart_data'], true);
        $_SESSION['checkout_cart'] = $cartItems; // Save to session so it persists on reload
    } elseif (isset($_SESSION['checkout_cart'])) {
        $cartItems = $_SESSION['checkout_cart'];
    } else {
        // If no cart data, send them back
        echo "<script>window.location.href='cart.php';</script>";
        exit();
    }

    // Calculate Totals
    $subtotal = 0;
    if ($cartItems) {
        foreach ($cartItems as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
    }
    $grandTotal = $subtotal + $deliveryFee;

    // 3. PROCESS ORDER (Database Insertion)
    if (isset($_POST['place_order'])) {
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $payment = $conn->real_escape_string($_POST['payment_method']);
        
        // A. Insert into ORDERS table
        $sqlOrder = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, contact_number, status) 
                     VALUES ('$user_id', '$grandTotal', '$payment', '$address', '$phone', 'Pending')";
        
        if ($conn->query($sqlOrder) === TRUE) {
            $order_id = $conn->insert_id; // Get the ID of the order we just created

            // B. Insert into ORDER_ITEMS table
            $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlItem);

            foreach ($cartItems as $item) {
                // Ensure we have a valid ID (if missing, skip or default)
                $pid = isset($item['id']) ? $item['id'] : 0; 
                $qty = $item['quantity'];
                $price = $item['price'];
                
                $stmt->bind_param("iiid", $order_id, $pid, $qty, $price);
                $stmt->execute();
            }

            // C. Clean up and Success
            unset($_SESSION['checkout_cart']); // Clear PHP session cart
            echo "<script>window.location.href='success.php';</script>";
            exit();
        } else {
            echo "<div class='container' style='color:red; margin-top:20px;'>Error: " . $conn->error . "</div>";
        }
    }
?>

<section class="checkout" style="padding: 5rem 0; background: var(--parchment); min-height: 80vh;">
    <div class="container">
        <div class="section-header">
            <h2>Order Confirmation</h2>
            <p>Review details and place your order</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--olivewood); margin-bottom: 1.5rem;">Shipping Information</h3>
                
                <form method="POST" action="checkout.php" class="contact-form">
                    <label style="color: var(--sage); font-size: 0.9rem;">Full Delivery Address</label>
                    <textarea name="address" rows="3" required placeholder="House No, Street, Barangay, City, Province"></textarea>
                    
                    <label style="color: var(--sage); font-size: 0.9rem;">Contact Number</label>
                    <input type="text" name="phone" required placeholder="0912 345 6789">
                    
                    <label style="color: var(--sage); font-size: 0.9rem;">Payment Method</label>
                    <select name="payment_method" required>
                        <option value="COD">Cash on Delivery (COD)</option>
                        <option value="GCash">GCash (Manual Transfer)</option>
                    </select>

                    <div style="margin-top: 2rem;">
                        <button type="submit" name="place_order" class="btn btn-primary" style="width: 100%;">Confirm & Place Order</button>
                    </div>
                </form>
            </div>

            <div style="background: var(--sand); padding: 2rem; border-radius: 15px; height: fit-content;">
                <h3 style="color: var(--olivewood); margin-bottom: 1.5rem;">Your Order</h3>
                
                <div style="margin-bottom: 1rem; border-bottom: 1px solid white; padding-bottom: 1rem;">
                    <?php if(!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--bark);">
                            <span><?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($item['name']); ?></span>
                            <span>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Subtotal</span>
                    <span>₱<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Delivery Fee</span>
                    <span>₱<?php echo number_format($deliveryFee, 2); ?></span>
                </div>
                
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; color: var(--olivewood); border-top: 2px solid white; padding-top: 1rem;">
                    <span>Grand Total</span>
                    <span>₱<?php echo number_format($grandTotal, 2); ?></span>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>