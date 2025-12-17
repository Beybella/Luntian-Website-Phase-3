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

<!-- Signup Section -->
<section class="auth-section">
    <div class="auth-wrapper">
        <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-user-plus auth-icon"></i>
                    <h2>Create Account</h2>
                    <p>Join Luntian and start your flower journey</p>
                </div>

                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <?php echo $message; ?>
                </div>

                <form class="auth-form" id="signupForm" method="POST" action="signup.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" id="firstName" name="name" placeholder="Full name" value="<?php echo htmlspecialchars($nameValue); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="signupEmail"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" id="signupEmail" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="signupPassword"><i class="fas fa-lock"></i> Password</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="signupPassword" name="password" placeholder="Create a password" required>
                            <button type="button" class="toggle-password" id="toggleSignupPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="password-hint">Must be at least 8 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"><i class="fas fa-lock"></i> Confirm Password</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                            <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" required>
                            <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth">Create Account</button>

                    <div class="auth-divider">
                        <span>OR</span>
                    </div>

                    <div class="social-login">
                        <button type="button" class="btn-social btn-google">
                            <i class="fab fa-google"></i> Sign up with Google
                        </button>
                        <button type="button" class="btn-social btn-facebook">
                            <i class="fab fa-facebook-f"></i> Sign up with Facebook
                        </button>
                    </div>

                    <div class="auth-footer">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </form>
            </div>

            <div class="auth-image">
                <div class="auth-image-overlay">
                    <h3>Why Join Luntian?</h3>
                    <p>Create your account and enjoy exclusive benefits</p>
                    <ul class="benefits-list">
                        <li><i class="fas fa-check-circle"></i> Fast and easy checkout</li>
                        <li><i class="fas fa-check-circle"></i> Track your orders in real-time</li>
                        <li><i class="fas fa-check-circle"></i> Save your favorite arrangements</li>
                        <li><i class="fas fa-check-circle"></i> Get exclusive member discounts</li>
                        <li><i class="fas fa-check-circle"></i> Receive special occasion reminders</li>
                        <li><i class="fas fa-check-circle"></i> Priority customer support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PASSWORD TOGGLE SCRIPT -->
<script>
document.addEventListener("click", function (e) {
    const toggleBtn = e.target.closest(".toggle-password");
    if (!toggleBtn) return;

    const wrapper = toggleBtn.closest(".password-input-wrapper");
    if (!wrapper) return;

    // Find the input that is immediately before the button
    const input = wrapper.querySelector("input");
    const icon = toggleBtn.querySelector("i");

    if (!input || !icon) return;

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
});
</script>

<?php include 'includes/footer.php'; ?>