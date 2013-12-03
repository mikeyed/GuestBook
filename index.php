<?php 
//session_start();

//$err_message = $_SESSION["err_message"];

/* Controller code to retrieve data depending on ID provided */ 
if (isset($_GET["id"])) {
	$entry_id = intval($_GET["id"]);
	exit();
}

/* Grabs guest entry data (model) */
require_once('inc/guest_record.php');	
$entry_call = new Guest();	

$err_message = $_REQUEST['err_message']; //sets returned error message to variable

$current_page = check_page_call($_GET["pg"]); //checks for valid page call, returns 1 or current page number

//changes any none numerical page call to value, typically 0
$current_page = intval($current_page);

//calls count function, divides total items into a rounded set of pages
$total_entries = $entry_call->get_entry_count();
$entries_per_page = 6;
$page_total = ceil($total_entries / $entries_per_page); 

normalize_large_page_calls($current_page, $page_total); //sets any large page calls to page total

normalize_small_page_calls($current_page); //sets any page calls smaller than one to root

//determines start and stop of entry calls per page
$start = (($current_page - 1) * $entries_per_page) + 1;
$stop = $current_page * $entries_per_page;
if ($stop > $total_entries) {
	$stop = $total_entries;
}

$next = $current_page + 1;
$prev = $current_page - 1;

//sets entries for current page with entry range function
$entries = $entry_call->get_entry_range($start,$stop);


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
		
		<!-- Loop for links to paginated entries -->
		<div class="pagination">
			<?php include('partial/pagination-logic.html.php');?>
		</div>
		
		<!-- Loop through entries using function display -->
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
