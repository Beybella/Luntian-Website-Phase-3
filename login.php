<?php 
    $pageTitle = "Login";
    $activePage = "login";
    include 'includes/db.php';
    include 'includes/header.php'; 

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify Password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role']; // <--- ADD THIS LINE
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    echo "<script>window.location.href='admin_orders.php';</script>";
                } else {
                    echo "<script>window.location.href='index.php';</script>";
                }
            } else {
                $message = "<div style='color: red; margin-bottom: 1rem;'>Invalid password!</div>";
            }
        } else {
            $message = "<div style='color: red; margin-bottom: 1rem;'>User not found!</div>";
        }
    }
?>

<section class="contact" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="section-header">
            <h2>Welcome Back</h2>
            <p>Login to your Luntian account</p>
        </div>
        
        <div class="contact-form-wrapper" style="max-width: 450px;">
            <div style="text-align: center; margin-bottom: 1rem;">
                <?php echo $message; ?>
            </div>
            <form class="contact-form" method="POST" action="login.php">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                
                <p style="text-align: center; margin-top: 1rem; color: var(--bark);">
                    Don't have an account? <a href="signup.php" style="color: var(--olive); font-weight: bold; text-decoration: none;">Sign up here</a>
                </p>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>