<?php
session_start();
include 'includes/config.php';

// Check if an order ID exists in the session (this is to ensure the page is visited only after an order has been placed)
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");  // Redirect to home page if no order ID is found
    exit;
}

$order_id = $_SESSION['order_id'];

// Retrieve order details from the database
$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = $db->query($sql);
$order = $result->fetch_assoc();

// Retrieve order items
$order_items_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$order_items_result = $db->query($order_items_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <!-- Header -->
    <header>
        <h1>সাজঘর</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="orders.php">Your Orders</a>
        </nav>
    </header>

    <!-- Order Confirmation -->
    <section class="order-confirmation">
        <h3>Order Confirmation</h3>

        <p>Thank you for your order! Your order has been placed successfully.</p>
        <h4>Order ID: <?php echo $order['id']; ?></h4>

        <h5>Shipping Details:</h5>
        <p>Name: <?php echo $order['name']; ?></p>
        <p>Email: <?php echo $order['email']; ?></p>
        <p>Address: <?php echo $order['address']; ?></p>
        <p>Phone: <?php echo $order['phone']; ?></p>

        <h5>Order Items:</h5>
        <table class="order-summary">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $total = 0;
            while ($item = $order_items_result->fetch_assoc()) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                echo "<tr>
                        <td>{$item['product_name']}</td>
                        <td>৳ {$item['price']}</td>
                        <td>{$item['quantity']}</td>
                        <td>৳ {$subtotal}</td>
                      </tr>";
            }
            ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td>৳ <?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>

        <p>If you have any questions about your order, please contact us at support@saajghar.com.</p>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 সাজঘর | All Rights Reserved</p>
    </footer>

</body>

</html>