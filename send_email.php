<?php
// Enable error reporting (for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check for POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $fullName = htmlspecialchars(trim($_POST['fullName'] ?? ''));
    $email    = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $subject  = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message  = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validate required fields
    if (empty($fullName) || empty($email) || empty($phone) || empty($subject)) {
        echo "error: Please fill in all required fields.";
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error: Invalid email format.";
        exit;
    }

    // Email configuration
    $to = "hanna.ecraftz@gmail.com";
    $email_subject = "Contact Form: $subject";
    $email_body = "You have received a new message from the contact form:\n\n";
    $email_body .= "Name: $fullName\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Message:\n$message\n";

    // Email headers
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send mail
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "success";
    } else {
        echo "error: Failed to send email.";
    }
} else {
    echo "invalid access";
}
?>
