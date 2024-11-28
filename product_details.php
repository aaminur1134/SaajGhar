<?php
include 'includes/config.php';

// Get product ID from URL parameter
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($product_id) {
    // Fetch product details from database
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $db->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo 'Product not found!';
        exit;
    }
} else {
    echo 'Invalid product ID!';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <!-- Header -->
    <header>
        <h1>সাজঘর</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <!-- Product Details Section -->
    <section class="product-details">
        <div class="product-image">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </div>

        <div class="product-info">
            <h2><?php echo $product['name']; ?></h2>
            <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
            <p><strong>Price:</strong> ৳ <?php echo $product['price']; ?></p>

            <!-- Quantity Control -->
            <div class="quantity-control">
                <button class="quantity-btn minus" data-id="<?php echo $product['id']; ?>">-</button>
                <input type="number" class="quantity-input" data-id="<?php echo $product['id']; ?>" value="1" min="1"
                    step="1">
                <button class="quantity-btn plus" data-id="<?php echo $product['id']; ?>">+</button>
            </div>
            <br>
            <!-- Update Cart URL with selected quantity -->
            <a href="cart.php?add=<?php echo $product['id']; ?>&quantity=1" class="btn add-to-cart-btn"
                data-id="<?php echo $product['id']; ?>">Add to Cart</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 সাজঘর | All Rights Reserved</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const minusButtons = document.querySelectorAll('.quantity-btn.minus');
        const plusButtons = document.querySelectorAll('.quantity-btn.plus');
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');

        // Handle minus button click
        minusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = button.nextElementSibling; // Get the next sibling input
                let quantity = parseInt(input.value);
                if (quantity > 1) { // Don't allow negative or zero quantity
                    input.value = quantity - 1;
                    updateCartUrl(input);
                }
            });
        });

        // Handle plus button click
        plusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = button.previousElementSibling; // Get the previous sibling input
                let quantity = parseInt(input.value);
                input.value = quantity + 1;
                updateCartUrl(input);
            });
        });

        // Update the "Add to Cart" URL based on the input value
        function updateCartUrl(input) {
            const quantity = input.value;
            const productId = input.getAttribute('data-id');
            const addToCartBtn = document.querySelector(`.add-to-cart-btn[data-id="${productId}"]`);
            if (addToCartBtn) {
                addToCartBtn.setAttribute('href', `cart.php?add=${productId}&quantity=${quantity}`);
            }
        }

        // Handle direct input change (if user manually changes the value)
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (parseInt(input.value) < 1) {
                    input.value = 1; // Prevent invalid quantity
                }
                updateCartUrl(input);
            });
        });
    });
    </script>
</body>

</html>