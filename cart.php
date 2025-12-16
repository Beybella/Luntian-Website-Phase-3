<?php 
    $pageTitle = "Shopping Cart";
    $activePage = "cart";
    include 'includes/header.php'; 
?>

    <section class="shopping-cart">
        <div class="container">
            <div class="section-header">
                <h2>Shopping Cart</h2>
                <p>Review your selected flowers</p>
            </div>

            <div class="cart-content">
                <div class="cart-items-wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartItemsTable">
                            </tbody>
                    </table>

                    <div id="emptyCartMessage" class="empty-cart-message">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Your cart is empty</p>
                        <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-card">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Fee:</span>
                            <span id="deliveryFee">₱150.00</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row total-row">
                            <span>Total:</span>
                            <span id="totalPrice">₱0.00</span>
                        </div>
                        
                        <form id="checkoutForm" action="checkout.php" method="POST">
                            <input type="hidden" name="cart_data" id="hiddenCartData">
                            
                            <button type="submit" class="btn btn-primary btn-checkout" id="checkoutBtn">Proceed to Checkout</button>
                        </form>

                        <a href="products.php" class="btn btn-secondary" style="width: 100%; text-align: center; margin-top: 10px;">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>