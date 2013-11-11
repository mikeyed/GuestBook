<?php
//Connect to Guest database
require("inc/guest_record.php");

//Define posted variables by user
add_entry($_POST["name"], $_POST["email"], $_POST["comment"]);

//Return to thank you page
header("Location: visitor-thanks.php");

?>
