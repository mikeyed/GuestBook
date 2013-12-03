<?php 
 
  /* start of Guest as class */
 class Guest {
	public $name;
	public $email;
	public $comment;
	
	public function __construct($name, $email, $comment) {
		$this->name = $name;
		$this->name = $email;
		$this->name = $comment;
	}
	 
	public static function add($name, $email, $comment) {
		require("inc/guest_dbconnect.php");
		
		//entry's status for being entered into the database
		$entry_state = "";
		
		try { 
			//State table and variables being inserted
			$stmt = $db->prepare("INSERT INTO GuestBook (name, email, comment) VALUES (:name, :email, :comment)");
			//Bind those variables inserted with the ones posted 
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':comment', $comment);
			//Execute the prepared statement
			$stmt->execute();
			
			$entry_state = "Thank you for signing our guest book.";
			return $entry_state;
			
		} catch (Exception $e) {
				$entry_state = "Something happened. We failed to add your entry.";
				return $entry_state;
				exit;	
		}
	}
	
	/* single guest display function, binds to entry 'id' unique variable */
	function get_single($entry_id) {
		require("inc/guest_dbconnect.php");
		
		try { 
			$result = $db->prepare("SELECT id, name, email, comment FROM GuestBook WHERE id = :id");
			$result->bindParam(':id',$entry_id);
			$result->execute();
		} catch (Exception $e) {
				echo "We are having trouble displaying this guest's information.";
				exit;	
		}

		$entry = $result->fetch(PDO::FETCH_ASSOC);
			
		return $entry;
	}
	
	/* reviews form submission for errors, omissions, or bots */
	public function validate_entry($name, $email, $comment) {
		// define variables and set to empty values
		$name = $email = $comment = "";
				
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$name =  trim($_POST["name"]);
			$email = trim($_POST["email"]);
			$comment = trim($_POST["comment"]);
			
			//empty values submitted will return an error
			if($name == "" OR $email == "" OR $comment == "") {
				$err_message = "You must specify a value for name, email, and comment.";
				return $err_message;
			}
			
			// hidden form value, if filled will send back an error
			if($_POST["address"] != "") {
					$err_message = "Your form submission has an error.";
					return $err_message;
			}		
		}
	} 
	
	/* Grabs entries from database as 'entries' variable */
	public function get_all_entries() {
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

	public function get_entry_count() {
		$total_entries = count($this->get_all_entries());
		return $total_entries;
	}

	public function get_entry_range($entryStart, $entryStop) {
		$range = array();
		$all_entries = $this->get_all_entries();
		
		$position = 0;
		foreach($all_entries as $entry) {
			$position += 1;
			if ($position >= $entryStart && $position <= $entryStop) {
				$range[] = $entry;
			}
		}
		return $range;
	}

}


/* formats text for entry display */
function get_list_view_html($entry) {
	//uses make_excerpt function to cut comments displayed to 15 characters
	$excerpt = make_excerpt($entry["comment"], 15, $entry["id"]);
	
	//output for each entry passed through
	$output = "";
	
	$output = $output . '<li>';
	$output = $output . '<p><a href="single.php?id=' . $entry["id"] . '" class="contact">' . $entry["name"] . ', ';
	$output = $output . $entry["email"] . '</a></p>';
	$output = $output . '<p>' . $excerpt . '</p>';
	$output = $output . '</li>'; 
	 
 	return $output;
}

/* cleans form submission values */
function clean_val($value) {
	$value_clean = trim($value);
	$value_clean = stripslashes($value_clean);
	$value_clean = htmlspecialchars($value_clean);
	
	return $value_clean;
}


/* reviews form submission for errors, omissions, or bots */
function validate_entry($name, $email, $comment) {
	// define variables and set to empty values
	$name = $email = $comment = "";
			
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$name =  trim($_POST["name"]);
		$email = trim($_POST["email"]);
		$comment = trim($_POST["comment"]);
		
		//empty values submitted will return an error
		if($name == "" OR $email == "" OR $comment == "") {
			$err_message = "You must specify a value for name, email, and comment.";
			return $err_message;
		}
		
		// hidden form value, if filled will send back an error
		if($_POST["address"] != "") {
				$err_message = "Your form submission has an error.";
				return $err_message;
		}		
	}
} 

/* cuts text passed through to max character count adding a link using the id passed through */
function make_excerpt($text, $max_char, $id) {
	if (strlen($text) > $max_char) {
		$text = substr($text, 0, $max_char);
		$text = substr($text,0,strrpos($text," "));
		$etc = " <a href='single.php?id=" . $id . "'>(...)</a>"; 
		$text = $text.$etc;
	}
	return $text;
}

function check_page_call($get_var) {
	// checks for page setting, returns to first if none
	if(empty($_GET["pg"])) {
		return $current_page = 1;
		} else { 
		return $current_page = $_GET["pg"];
	}
}

function normalize_large_page_calls($current_page, $page_total) {
	//page calls higher than last go to last page
	if ($current_page > $page_total) {
		header("Location: ./?pg=" . $page_total);
	}
}

function normalize_small_page_calls($current_page) {
	//if page call lower than one, go to root
	if ($current_page < 1) {
		header("Location: ./");
	}
}

?>
