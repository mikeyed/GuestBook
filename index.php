<?php 

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$comment = trim($_POST["comment"]);
	
	if($name == "" OR $email_address == "" OR $comment == "") {
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
	
	
}
?>

<?php 
$pageTitle = "Guest Book";
$section = "guest_book";

include('inc/guest_record.php'); 
include('inc/header.php'); ?>

<div class="wrapper article_back">
		
	<div class="section page container">

	
	<?PHP
	if(isset($_GET["Status"]) AND $_GET["Status"] == "thanks") { ?>
	
	<p>Thanks for visiting our site. We'll be watching you! ;)</p>

	
	<?php } else {?>
	
	<section class="persistent">
	<form method="post" action="entry-add.php">
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
					<label for="comment">Comment</label>
				</th>
				<td>
					<textarea name="comment" id="comment"></textarea>
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
		<input  type="submit" value="Add Your Name">
	</form>
	</section>
	
	<?php } ?>
	
	<article class="scroll">
		<ul class="guests">
			<?php 
			foreach($entries as $entry_id => $entry) { 
				echo get_list_view_html( $entry_id, $entry );
			} 
			?>
		</ul>
	</article>
	</div>
</div>

<?php include('inc/footer.php'); ?>
