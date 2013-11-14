<?php 
/* Grabs guest entry data (model) */
include('inc/guest_record.php');

$entry_single = get_guest_single($_GET["id"]);


if (empty($entry_single)) {
	header("Location: index.php");
	exit();
}

//page attributes, section>>title
$section = "guest";
$pageTitle = $entry_single["name"];

//header template file
include('inc/header.php'); 
?>

<div class="wrapper article_back">
	<div class="section page container">
		
		<!-- trail back to Guest Book -->
		<section class="persistent">
			<a href="index.php">Guest Book</a> &gt; <?php echo  $entry_single["name"]; ?>
		</section>
		
		<!-- Main Guest Detail Display -->
		<article class="scroll single">	
			<h1><?php echo $entry_single["name"]; ?></h1>
			
			<h2><?php echo $entry_single["email"]; ?></h1>
			
			<p><?php echo $entry_single["comment"]; ?></p>
		</article>
			
	</div>
</div>

<?php include('inc/footer.php'); ?>
