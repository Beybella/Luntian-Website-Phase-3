<?php 
    $pageTitle = "Admin Dashboard";
    include 'includes/db.php';
    include 'includes/header.php'; 

    // 1. SECURITY CHECK: Only Admins Allowed
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "<script>window.location.href='index.php';</script>";
        exit();
    }

    // 2. HANDLE STATUS UPDATE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['status'];

        $updateSql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $new_status, $order_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Order #$order_id updated to $new_status'); window.location.href='admin_orders.php';</script>";
        } else {
            echo "<script>alert('Error updating order');</script>";
        }
    }
?>

<style>
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .admin-table th {
        background: var(--olivewood);
        color: var(--parchment);
        padding: 1rem;
        text-align: left;
    }
    .admin-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        color: var(--bark);
    }
    .admin-table tr:hover {
        background-color: #f9f9f9;
    }
    .status-select {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid var(--sage);
    }
    .update-btn {
        background: var(--olive);
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }
    .update-btn:hover {
        background: var(--olivewood);
    }
</style>

<section style="min-height: 80vh; padding: 5rem 0; background-color: var(--parchment);">
    <div class="container">
        <div class="section-header">
            <h2>Admin Dashboard</h2>
            <p>Manage customer orders</p>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Address</th>
                        <th>Items</th> <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Fetch orders JOIN users to get the customer name
                    $sql = "SELECT orders.*, users.full_name 
                            FROM orders 
                            JOIN users ON orders.user_id = users.id 
                            ORDER BY orders.order_date DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0):
                        while($order = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($order['full_name']); ?></strong><br>
                            <small><?php echo htmlspecialchars($order['contact_number']); ?></small>
                        </td>
                        <td><?php echo date("M j, Y", strtotime($order['order_date'])); ?></td>
                        <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td style="max-width: 200px; font-size: 0.9rem;"><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                        
                        <td>
                            <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem;">
                                <?php
                                $oid = $order['id'];
                                $itemSql = "SELECT p.name, oi.quantity FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $oid";
                                $itemRes = $conn->query($itemSql);
                                while($item = $itemRes->fetch_assoc()){
                                    echo "<li>{$item['quantity']}x {$item['name']}</li>";
                                }
                                ?>
                            </ul>
                        </td>

                        <td>
                            <span style="
                                padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;
                                background-color: <?php 
                                    if($order['status']=='Pending') echo '#f1c40f'; 
                                    elseif($order['status']=='Processing') echo '#3498db'; 
                                    elseif($order['status']=='Shipped') echo '#9b59b6'; 
                                    elseif($order['status']=='Completed') echo '#2ecc71'; 
                                    else echo '#e74c3c'; 
                                ?>;
                                color: white;">
                                <?php echo $order['status']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="admin_orders.php">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="status" class="status-select">
                                    <option value="Pending" <?php if($order['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Processing" <?php if($order['status']=='Processing') echo 'selected'; ?>>Processing</option>
                                    <option value="Shipped" <?php if($order['status']=='Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Completed" <?php if($order['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                    <option value="Cancelled" <?php if($order['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status" class="update-btn">Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>