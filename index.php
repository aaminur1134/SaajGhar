<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সাজঘর | Home</title>

    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri&family=Roboto+Mono&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>


<?php
include 'includes/config.php';
$sql = "SELECT * FROM products LIMIT 12";
$result = $db->query($sql);
?>

<body>
    <header>
        <h1>সাজঘর</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
        </nav>
    </header>

    <section class="banner">
        <h2>Welcome to সাজঘর!</h2>
        <h4>"প্রত্যেক শাড়িতে একটুকু গল্প, আপনার সৌন্দর্যেই আমাদের গর্ব।"</h4>
        <p>প্রতিটি শাড়িতে লুকিয়ে রয়েছে ঐতিহ্য ও আধুনিকতার চমৎকার সমন্বয়। আমাদের সংগ্রহে রয়েছে এমন শাড়ি, যা আপনার প্রতিটি
            মুহূর্তকে করে তুলবে স্মরণীয় এবং আপনাকে দেবে এক অনন্য শৈলী। আমাদের শাড়ি সংগ্রহে আপনি পাবেন ঐতিহ্যবাহী
            ব্যানারসি, রাজকীয় সিল্ক, আরামদায়ক কটন, এবং আরও অনেক ধরনের শাড়ি, যা আপনার সৌন্দর্য এবং শৈলীকে নতুন রূপে
            উপস্থাপন করবে। প্রতিটি শাড়ি বিশেষভাবে ডিজাইন করা হয়েছে, যাতে তা আপনার প্রতিদিনের জীবনে আভিজ্ঞান,
            স্বাচ্ছন্দ্য এবং গ্ল্যামারের মিশ্রণ এনে দেয়। আমাদের শাড়ি শুধু পোশাক নয়, এটি আপনার ব্যক্তিত্বের একটি নিখুঁত
            প্রতিফলন।</p>
    </section>

    <section class="featured-products">
        <h2>Featured Sarees</h2>
        <div class="product-list">
            <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h4>' . $row['name'] . '</h4>';
                echo '<p>৳ ' . $row['price'] . '</p>';
                echo '<a href="product_details.php?id=' . $row['id'] . '" class="btn">View Details</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found!</p>';
        }
        ?>
        </div>
    </section>

    <footer>
        <p>© 2024 সাজঘর. All rights reserved.</p>
    </footer>
</body>

</html>