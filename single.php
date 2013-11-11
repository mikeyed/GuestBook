<?php 
//calls guest listing
include('inc/guest_record.php');

if (isset($_GET["id"])) {
	//from index.php call, assigns entry's id to page variable
	$entry_id = $_GET["id"];
	if (isset($entries[$entry_id])) {
	$entry = $entries[$entry_id];
	}
}

if (!isset($entry_id)) {
	header("Location: index.php");
	exit();
}

//page attributes, section>>title
$section = "guest";
$pageTitle = $entry["name"];

//header template file
include('inc/header.php'); 
?>

<div class="wrapper article_back">
	<div class="section page container">
		
		<!-- trail back to Guest Book -->
		<section class="persistent">
			<a href="index.php">Guest Book</a> &gt; <?php echo $name; ?>
		</section>
		
		<!-- Main Guest Detail Display -->
		<article class="scroll">
			<h1><?php echo $entries["name"]; ?></h1>
			
			<h2><?php echo $entry["email"]; ?></h1>
			
			<p><?php echo $entry["comment"]; ?></p>
		</article>
			
	</div>
</div>

<?php include('inc/footer.php'); ?>
