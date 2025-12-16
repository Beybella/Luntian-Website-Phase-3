<?php 
    $pageTitle = "Sign Up";
    $activePage = "login"; 
    include 'includes/db.php';
    include 'includes/header.php'; 

    $message = "";
    
    // Initialize variables to hold previous input (default is empty)
    $nameValue = "";
    $emailValue = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 1. Capture the input so we can put it back in the form if there's an error
        $nameValue = $_POST['name'];
        $emailValue = $_POST['email'];

        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // 2. Check Password Length
        if (strlen($password) < 8) {
            $message = "<div style='color: red; margin-bottom: 1rem;'>Password must be at least 8 characters long!</div>";
        } 
        // 3. Check if Passwords Match
        elseif ($password !== $confirm_password) {
            $message = "<div style='color: red; margin-bottom: 1rem;'>Passwords do not match!</div>";
        } else {
            // Check if email already exists
            $checkEmail = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($checkEmail);

            if ($result->num_rows > 0) {
                $message = "<div style='color: red; margin-bottom: 1rem;'>Email already registered!</div>";
            } else {
                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Registration Successful! Please Login.'); window.location.href='login.php';</script>";
                } else {
                    $message = "Error: " . $conn->error;
                }
            }
        }
    }
?>

<section class="contact" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="section-header">
            <h2>Create Account</h2>
            <p>Join the Luntian family</p>
        </div>
        
        <div class="contact-form-wrapper" style="max-width: 450px;">
            <div style="text-align: center; margin-bottom: 1rem;">
                <?php echo $message; ?>
            </div>
            <form class="contact-form" method="POST" action="signup.php">
                <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($nameValue); ?>" required>
                
                <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($emailValue); ?>" required>
                
                <input type="password" name="password" placeholder="Password (Min. 8 chars)" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Sign Up</button>
                
                <p style="text-align: center; margin-top: 1rem; color: var(--bark);">
                    Already have an account? <a href="login.php" style="color: var(--olive); font-weight: bold; text-decoration: none;">Login here</a>
                </p>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>