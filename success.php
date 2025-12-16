<?php 
    $pageTitle = "Order Success";
    include 'includes/header.php'; 
?>

<section style="height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; background: var(--parchment);">
    <div class="container">
        <div style="background: white; padding: 4rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <i class="fas fa-check-circle" style="font-size: 5rem; color: var(--olive); margin-bottom: 1.5rem;"></i>
            <h1 style="color: var(--olivewood); margin-bottom: 1rem;">Order Placed Successfully!</h1>
            <p style="color: var(--bark); font-size: 1.2rem; margin-bottom: 2rem;">
                Thank you for shopping with Luntian. <br>
                We are preparing your flowers with love.
            </p>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</section>

<script>
    // CLEAR LOCAL STORAGE CART
    localStorage.removeItem('luntianCart');
    console.log('Cart cleared successfully.');
</script>

<?php include 'includes/footer.php'; ?>