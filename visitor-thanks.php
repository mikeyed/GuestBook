<?php 
$pageTitle = "thank_you";
$section = "thanks";

include('inc/guest_record.php'); 
$entries = get_all_entries(); 

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
