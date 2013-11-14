<?php 
 
/* formats text for entry display */
function get_list_view_html($entry) {
	$output = "";
	
	$output = $output . '<li>';
	$output = $output . '<p><a href="single.php?id=' . $entry["id"] . '">' . $entry["name"] . ', ';
	$output = $output . $entry["email"] . '</a></p>';
	$output = $output . '<p>' . $entry["comment"] . '</p>';
	$output = $output . '</li>'; 
	 
 	return $output;
}

/* add a guest entry to the database */
function add_entry($name, $email, $comment) {
	require("inc/guest_dbconnect.php");
	
	try { 
		//State table and variables being inserted
		$stmt = $db->prepare("INSERT INTO GuestBook (name, email, comment) VALUES (:name, :email, :comment)");
		//Bind those variables inserted with the ones posted 
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':comment', $comment);
		//Execute the prepared statement
		$stmt->execute();
	} catch (Exception $e) {
			echo "Failed to add entry.";
			exit;	
	}
}

/* single guest display function, binds to entry 'id' unique variable
 */
function get_guest_single($entry_id) {
	require("inc/guest_dbconnect.php");
	
	try { 
		$result = $db->prepare("SELECT id, name, email, comment FROM GuestBook WHERE id = :id");
		$result->bindParam(':id',$entry_id);
		$result->execute();
	} catch (Exception $e) {
			echo "We are having trouble displaying this guest's information.";
			exit;	
	}

	$product = $result->fetch(PDO::FETCH_ASSOC);
		
	return $product;
}
 
 
/* Grabs entries from database as 'entries' variable */
function get_all_entries() {
/*
	$entries = array();
	$entries[101] = array(
		"name" => "Michael Davidson",
		"email" => "me@mikeyed.com",
		"comment" => "First!"
	);

	$entries[102] = array(
		"name" => "Brian Boitano",
		"email" => "whatwould@brianboitano.do",
		"comment" => "He'd kick an ass or two, cause that's what boitano'd do."
	);


	$entries[103] = array(
		"name" => "Khal Drogo",
		"email" => "moonstars@khal.eesi",
		"comment" => "Shadowland, b$@!#!"
	);
	*/

	require("inc/guest_dbconnect.php");
	
	try {
		$results = $db->query("SELECT id, name, email, comment FROM GuestBook ORDER BY id DESC");
	} catch (Exception $e) {
		echo "Could not retrieve the guest list, the party is over.";
		exit;
	}
	
	$entries = $results->fetchAll(PDO::FETCH_ASSOC);
	
	return $entries;

}

?>
