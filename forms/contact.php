<?php
// contact.php

// Set your email address where you want to receive messages
$to = "noorfaiyaz317@gmail.com";  // Change this to your email

// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize form data
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Please fill in all fields.";
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

    // Prepare the email content
    $email_subject = "Portfolio Contact Form: $subject";
    $email_body    = "Name: $name\n";
    $email_body   .= "Email: $email\n\n";
    $email_body   .= "Message:\n$message\n";

    // Email headers
    $headers  = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Your message has been sent successfully!";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
