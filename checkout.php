<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - সাজঘর</title>
    <link rel="stylesheet" href="assets/style.css">
    <!-- Google Font Link -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
    .checkout-container {
        font-family: "Roboto Mono", monospace;
    }
    </style>
</head>

<body>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <!-- Check if cart is empty -->
        <?php if (count($_SESSION['cart']) == 0): ?>
        <p class="alert">Your cart is empty. Please add some products to your cart.</p>
        <?php else: ?>
        <h3>Cart Items</h3>
        <table class="cart-table">
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
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $item):
                    $totalPrice += $item['price'] * $item['quantity'];
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>৳ <?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>৳ <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td>৳ <?php echo number_format($totalPrice, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Checkout Form -->
        <form action="place_order.php" method="POST" class="checkout-form">
            <label for="name">Full Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="address">Shipping Address</label>
            <input type="text" name="address" required>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" required>

            <button type="submit">Place Order</button>
        </form>
        <?php endif; ?>
    </div>

</body>

</html>