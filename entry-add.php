<?php
//Connect to Guest database
require("inc/guest_record.php");

$err_message = validate_entry($_POST["name"], $_POST["email"], $_POST["comment"]);

if(!isset($err_message)) {
		
	//Define posted variables by user
	add_entry( $_POST["name"], $_POST["email"], $_POST["comment"]);

	//Return to thank you page
	header("Location: visitor-thanks.php");

	} else {	
		header("Location: index.php?err_message=". $err_message);
}

?>
