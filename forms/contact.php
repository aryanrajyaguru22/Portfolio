<?php
/**
 * Receives form data, validates it, and sends it as an email.
 */

// IMPORTANT: Replace this with your own email address.
$recipient_email = "aryanrajyaguru22@gmail.com";

// Check if the form was submitted using the POST method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Sanitize and retrieve form data
    // Use filter_input to get and sanitize variables from the form.
    $name    = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // 2. Validate form data
    // Check for empty fields and valid email format.
    if (empty($name) || empty($subject) || empty($message)) {
        // Stop the script and send an error message if any text fields are empty.
        http_response_code(400); // Bad Request
        die("Please fill in all the required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Stop the script and send an error message if the email is invalid.
        http_response_code(400); // Bad Request
        die("Please enter a valid email address.");
    }

    // 3. Construct the email
    // This is the subject line that will appear in your inbox.
    $email_subject = "New Contact Form Submission: " . $subject;

    // This is the body of the email.
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Here are the details:\n\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";

    // These are the email headers.
    // The 'From' header shows the sender's name and email.
    // The 'Reply-To' header allows you to click "Reply" in your email client
    // and have the reply go directly to the person who filled out the form.
    $headers = "From: " . $name . " <" . $email . ">\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 4. Send the email
    // The mail() function returns true if the email was accepted for delivery, false otherwise.
    if (mail($recipient_email, $email_subject, $email_body, $headers)) {
        // If the email sends successfully, send a 200 OK status.
        // The front-end JavaScript will see this and show the success message.
        http_response_code(200);
        echo "Your message has been sent. Thank you!";
    } else {
        // If the email fails to send, send a 500 Internal Server Error status.
        http_response_code(500);
        die("Sorry, there was an error sending your message. Please try again later.");
    }

} else {
    // If the script is accessed directly without a POST request, send a 403 Forbidden status.
    http_response_code(403);
    die("There was a problem with your submission, please try again.");
}
?>