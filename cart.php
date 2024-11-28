<?php
session_start();
include 'includes/config.php';

// If the "add" parameter is set, add the product to the cart
if (isset($_GET['add'])) {
    $product_id = $_GET['add'];

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Check if the product is already in the cart
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
                'image' => $product['image']
            ];
        } else {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        }
    }
}

// If the "remove" parameter is set, remove the product from the cart
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
}

// Display cart items
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <!-- Header -->
    <header>
        <h1>সাজঘর</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <!-- Cart Section -->
    <section class="cart">
        <h3>Your Cart</h3>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) : ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product) {
                    $subtotal = $product['price'] * $product['quantity'];
                    $total += $subtotal;
                    echo "<tr>
                            <td><img src='{$product['image']}' alt='{$product['name']}' width='50'></td>
                            <td>{$product['name']}</td>
                            <td>৳ {$product['price']}</td>
                            <td>{$product['quantity']}</td>
                            <td>৳ {$subtotal}</td>
                            <td><a href='cart.php?remove={$product['id']}' class='btn'>Remove</a></td>
                          </tr>";
                }
                ?>
                <tr>
                    <td colspan="4"><strong>Total:</strong></td>
                    <td>৳ <?php echo $total; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php else: ?>
        <p>Your cart is empty!</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 সাজঘর | All Rights Reserved</p>
    </footer>

</body>

</html>