<?php 
    $pageTitle = "My Profile";
    $activePage = ""; 
    include 'includes/db.php';
    include 'includes/header.php'; 

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $userData = null;
    $passMessage = "";

    // Initialize variables to hold input values
    $currentPassValue = "";
    $newPassValue = "";
    $confirmPassValue = "";

    // --- HANDLE PASSWORD UPDATE LOGIC ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
        $currentPassValue = $_POST['current_password'];
        $newPassValue = $_POST['new_password'];
        $confirmPassValue = $_POST['confirm_new_password'];

        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $sqlPass = "SELECT password FROM users WHERE id = ?";
        $stmtPass = $conn->prepare($sqlPass);
        $stmtPass->bind_param("i", $user_id);
        $stmtPass->execute();
        $resPass = $stmtPass->get_result();
        $rowPass = $resPass->fetch_assoc();

        if ($rowPass) {
            if (password_verify($current_password, $rowPass['password'])) {
                if (strlen($new_password) < 8) {
                    $passMessage = "<div style='color: red; margin-bottom: 1rem;'>New password must be at least 8 characters!</div>";
                } elseif ($new_password !== $confirm_new_password) {
                    $passMessage = "<div style='color: red; margin-bottom: 1rem;'>New passwords do not match!</div>";
                } else {
                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $updateSql = "UPDATE users SET password = ? WHERE id = ?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bind_param("si", $new_hashed_password, $user_id);
                    
                    if ($updateStmt->execute()) {
                        $passMessage = "<div style='color: green; margin-bottom: 1rem;'>Password updated successfully!</div>";
                        $currentPassValue = "";
                        $newPassValue = "";
                        $confirmPassValue = "";
                    } else {
                        $passMessage = "<div style='color: red; margin-bottom: 1rem;'>Error updating password.</div>";
                    }
                }
            } else {
                $passMessage = "<div style='color: red; margin-bottom: 1rem;'>Incorrect current password!</div>";
            }
        }
    }

    // --- FETCH USER DETAILS ---
    $sql = "SELECT full_name, email, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    }
?>

<section class="contact" style="min-height: 80vh; padding: 5rem 0;">
    <div class="container">
        <div class="section-header">
            <h2>My Profile</h2>
            <p>Your account information</p>
        </div>
        
        <div class="contact-form-wrapper" style="max-width: 600px; background: white; padding: 3rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <?php if ($userData): ?>
                
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="width: 100px; height: 100px; background: var(--olive); color: var(--olivewood); font-size: 3rem; font-weight: bold; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-family: 'Playfair Display', serif;">
                        <?php echo strtoupper(substr($userData['full_name'], 0, 1)); ?>
                    </div>
                    <h3 style="color: var(--olivewood);"><?php echo htmlspecialchars($userData['full_name']); ?></h3>
                    <p style="color: var(--sage);">Member since <?php echo date("F Y", strtotime($userData['created_at'])); ?></p>
                </div>

                <div style="border-top: 1px solid var(--sand); padding-top: 2rem; margin-bottom: 2rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: var(--sage); font-size: 0.9rem; margin-bottom: 0.5rem;">Full Name</label>
                        <div style="font-size: 1.1rem; color: var(--bark); font-weight: 500;">
                            <?php echo htmlspecialchars($userData['full_name']); ?>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: var(--sage); font-size: 0.9rem; margin-bottom: 0.5rem;">Email Address</label>
                        <div style="font-size: 1.1rem; color: var(--bark); font-weight: 500;">
                            <?php echo htmlspecialchars($userData['email']); ?>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--sand); padding-top: 2rem;">
                    <h4 style="color: var(--olivewood); margin-bottom: 1rem;">Change Password</h4>
                    <?php echo $passMessage; ?>
                    <form method="POST" action="profile.php" class="contact-form">
                        <input type="password" name="current_password" placeholder="Current Password" value="<?php echo htmlspecialchars($currentPassValue); ?>" required style="padding: 0.8rem; font-size: 0.95rem;">
                        <input type="password" name="new_password" placeholder="New Password (Min. 8 chars)" value="<?php echo htmlspecialchars($newPassValue); ?>" required style="padding: 0.8rem; font-size: 0.95rem;">
                        <input type="password" name="confirm_new_password" placeholder="Confirm New Password" value="<?php echo htmlspecialchars($confirmPassValue); ?>" required style="padding: 0.8rem; font-size: 0.95rem;">
                        <button type="submit" name="update_password" class="btn btn-primary" style="margin-top: 0.5rem;">Update Password</button>
                    </form>
                </div>

                <div style="margin-top: 3rem; text-align: center; border-top: 1px solid var(--sand); padding-top: 2rem;">
                    <a href="my_orders.php" class="btn btn-primary" style="background-color: var(--olive); border: none; margin-right: 1rem;">
                        <i class="fas fa-box-open"></i> View Order History
                    </a>
                    <a href="index.php" class="btn btn-secondary">Back to Home</a>
                </div>

            <?php else: ?>
                <p>User information not found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>