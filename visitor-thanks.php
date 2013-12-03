<?php 
$pageTitle = "thank_you";
$section = "thanks";

require_once('inc/guest_record.php');	
$entry = new Guest();
$entries = Guest::get_all_entries(); 
$err_message = $_REQUEST['err_message'];

include('inc/header.php'); ?>

<div class="wrapper article_back">
		
	<div class="section page container">
	
	<section class="persistent">
		<h2>Que bueno!</h2>
	
		<p>Thank you for signing our guest book.</p>
	</section>
	
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
