<?php
// Include database connection
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Simple validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Prepare and insert message into the database (Optional)
        $sql = "INSERT INTO contact_form (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if ($db->query($sql)) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $db->error;
        }
    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <section class="contact-section">
        <h2>Contact Us</h2>
        <p class="section-description">We would love to hear from you! Please fill out the form below to get in touch
            with us.</p>

        <form action="contact.php" method="POST" class="contact-form">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required class="form-input">
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required class="form-input">
            </div>

            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required class="form-input">
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required class="form-input"></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </section>


</body>

</html>