<?php 

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];
$email_body = "";
$email_body = $email_body . "Name: " . $name . "\n". "Email: " . $email . "\n" . "Message: " . $message;

//TODO: Send Email

header("Location: contact-thanks.php");

?>