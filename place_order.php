<style>
/* Main Container */
.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    font-family: "Roboto Mono", monospace;
}

/* Heading Styling */
h2 {
    color: #EBEAFF;
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
}

h3 {
    font-size: 22px;
    margin-bottom: 15px;
    color: #333;
}

/* Success Message */
.success-message {
    background-color: #4CAF50;
    color: #fff;
    padding: 15px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 20px;
}

.empty-message {
    background-color: #000;
    color: #fff;
    padding: 15px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 20px;
}

/* Order Details */
.order-details {
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 30px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.order-details ul {
    list-style-type: none;
}

.order-details li {
    padding: 10px 0;
    font-size: 16px;
}

.order-details li span {
    font-weight: bold;
}

/* Return Button */
.return-btn {
    display: block;
    width: 200px;
    margin: 0 auto;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.return-btn:hover {
    background-color: #45a049;
}

/* Footer */
footer {
    text-align: center;
    font-size: 14px;
    margin-top: 30px;
    color: #777;
}
</style>

<?php


session_start();

// Ensure the session has the cart
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {

    echo "<div class='container'>
            <div class='empty-message'>
                <h2>Your cart is empty.</h2>
                <p>Please add products to your cart before proceeding.</p>
            </div>
            <a href='products.php' class='return-btn'>Return to Products</a>
        </div>";
    exit;
}

// Create a connection to the database
include 'includes/config.php';

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// Calculate the total price of the cart items
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Insert the order into the database
$query = "INSERT INTO orders (name, email, address, phone, total) 
          VALUES (?, ?, ?, ?, ?)";

$stmt = $db->prepare($query);
$stmt->bind_param("ssssd", $name, $email, $address, $phone, $totalPrice);

if ($stmt->execute()) {
    // Successfully placed the order
    $orderId = $stmt->insert_id;

    // Optionally, empty the cart after the order is placed
    unset($_SESSION['cart']);

    echo "
        <div class='container'>
            <div class='success-message'>
                <h2>Thank you for your order!</h2>
                <p>Your order has been placed successfully. Your order ID is: $orderId</p>
                <p>You will receive an email confirmation shortly.</p>
            </div>
            <div class='order-details'>
                <h3>Order Details</h3>
                <ul>
                    <li><span>Name:</span> $name</li>
                    <li><span>Email:</span> $email</li>
                    <li><span>Address:</span> $address</li>
                    <li><span>Phone:</span> $phone</li>
                    <li><span>Total Price:</span> $totalPrice</li>
                </ul>
            </div>
            <a href='index.php' class='return-btn'>Return to Shop</a>
        </div>
    ";

} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the connection
$stmt->close();
$db->close();
?>