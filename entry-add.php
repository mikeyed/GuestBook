<?php
//Connect to Guest database
require("inc/guest_record.php");

$name = clean_val($_POST["name"]);
$email = clean_val($_POST["email"]);
$comment = clean_val($_POST["comment"]);

$err_message = validate_entry($name, $email, $comment);

if(!isset($err_message)) {
		
	//Define posted variables by user
	//add_entry( $_POST["name"], $_POST["email"], $_POST["comment"]);
	add_entry($name, $email, $comment);

	//Return to thank you page
	header("Location: visitor-thanks.php");

	} else {	
		header("Location: index.php?err_message=". $err_message);
}

?>
