<?php 
//session_start();

//$err_message = $_SESSION["err_message"];

/* Controller code to retrieve data depending on ID provided */ 
if (isset($_GET["id"])) {
	$entry_id = intval($_GET["id"]);
	exit();
}

/* Grabs guest entry data (model) */
include('inc/guest_record.php');	
$entry = new Guest();
$entries = Guest::get_all_entries(); 
$err_message = $_REQUEST['err_message'];

/* Page view definitions w/ header include (view)*/
$pageTitle = "Guest Book";
$section = "guest_book";

include('inc/header.php'); 
?>

<div class="wrapper article_back">
	<div class="section page container">
	
	<!-- Form submission section -->
	<section class="persistent"> 
		
	<?php 
		if(!isset($err_message)) {
			echo '<p>Sign our guest book please.</p>';
		} else {
			echo'<p>' . $err_message . '</p>';
		}
	?>
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
	
	
	<!-- Past guest entry display scroll portion -->
	<article class="scroll">
		<ul class="guest_list">
			<?php 
			foreach($entries as $entry) { 
				echo get_list_view_html( $entry );
			} 
			?>
		</ul>
	</article>
	
	</div>
</div>

<?php include('inc/footer.php'); ?>
