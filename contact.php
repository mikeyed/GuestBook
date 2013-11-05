<?php 

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);
	
	if($name == "" OR $email_address == "" OR $message == "") {
		echo "You must specify a value for name, email, and message.";
		exit;
	}
	
	foreach($_POST as $value ) {
		if( stripost($value, "Content-Type:") != FALSE ) {
			echo "There was a problem with the information you entered.";
			exit;	
		}
	}
	
	if($_POST["address"] != "") {
			echo "Your form submission has an error.";
			exit;
	}	
	
	require_once("inc/phpmailer/class.phpmailer.php");
	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	if($mail = ValidateAddress($email)) {
		echo "This email won't work, sorry!";
		exit;
	}
	
	$email_body = "";
	$email_body = $email_body . "Name: " . $name . "<br>";
	$email_body = $email_body . "Email: " . $email . "<br>";
	$email_body = $email_body . "Message: " . $message;
	
//	$body             = file_get_contents('contents.html');
//	$body             = preg_replace('/[\]/','',$body);

	$mail->SetFrom($email, $name);
	$address = "whoto@otherdomain.com";
	$mail->AddAddress($address, "John Doe");
	$mail->Subject = "Shirts 4 Mike Contact Form Submission | " . $name;

//	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$mail->MsgHTML($email_body);
//	$mail->AddAttachment("images/phpmailer.gif");      // attachment
//	$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

	if(!$mail->Send()) {
	  echo "There was a problem sending the message: " . $mail->ErrorInfo;
	  exit;
	}
//	 else {
//	  echo "Message sent!";
//	}
	
	header("Location: contact.php?status=thanks");
	exit;
}
?>

<?php 
$pageTitle = "Contact Mike";
$section = "contact";
include('inc/header.php'); ?>

<div class="section page">

	<div class="wrapper">
	<h1>Contact</h1>
	
	<?PHP
	if(isset($_GET["Status"]) AND $_GET["Status"] == "thanks") { ?>
	
	<p>Thank you for the email. We'll reply soon, we swear.</p>

	
	<?php } else {?>
	
	<p>
	
	<form method="post" action="contact-process.php">
		<table>
			<tr>
				<th>
					<label for="name">Name</label>
				</th>
				<td>
					<input type="text" name="name" id="name">
				</td>
			</tr>
			<tr>
				<th>
					<label for="email">Email</label>
				</th>
				<td>
					<input type="text" name="email" id="email">
				</td>
			</tr>
			<tr>
				<th>
					<label for="message">Message</label>
				</th>
				<td>
					<textarea name="message" id="message"></textarea>
				</td>
			</tr>
			<tr style="display:none;">
				<th>
					<label for="address">Address</label>
				</th>
				<td>
					<input type="text" name="address" id="address">
					<p> Human! Leave this blank!</p>
				</td>
			</tr>
		</table>
		<input  type="submit" value="Send">
	</form>
	
	
	<?php } ?>
	
	</div>
</div>

<?php include('inc/footer.php'); ?>
