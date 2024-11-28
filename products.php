<?php
// Database connection
include 'includes/config.php';

// Fetch all products
$query = "SELECT * FROM products";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | সাজঘর</title>
    <link rel="stylesheet" href="assets/style.css">
    <!-- Google Font Link -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <header>
        <h1>Welcome to সাজঘর</h1>
    </header>

    <div class="products-container">
        <?php
    // Check if any products exist
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
        <div class="product-card">
            <?php 
            echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
            ?>
            <h2><?php echo $row['name']; ?></h2>
            <p class="product-price">৳<?php echo $row['price']; ?></p>
            <?php
            echo '<a href="product_details.php?id=' . $row['id'] . '" class="btn">View Details</a>';
            ?>
        </div>
        <?php
        }
    } else {
        echo "<p>No products available at the moment.</p>";
    }
    ?>
    </div>

    
</body>

</html>

<?php
// Close the database connection
$db->close();
?>