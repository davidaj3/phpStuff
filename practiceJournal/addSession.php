<?php  
session_start();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] === false) {
	$url = "http://" . $_SERVER["HTTP_HOST"];
	$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$url .= "/login.php";
	header("Location: " . $url, 302);
	die();
}

require "loadDatabase.php";

try {
	$db = loadDatabase();
} catch (PDOException $ex) {
	echo "DATABASE ERROR!";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Practice Session - Go Practice</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css" />
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.min.js'></script>
	<script>
	$(document).ready(function(){
		var practiceItemCount = 0;
		$('button').click(fucntion(){
			var addText =  "<p>Title: <input type='text' name='title[]' /></p>\n";
			addText += "<p>Category: <select name='category[]'>\n";
			<?php 
			foreach ($db->query("SELECT categoryId, name FROM category") as $row) {
				echo "addText += '<option value='" . $row["categoryId"] . "'>" . $row["name"] . "</option>\n';\n";
			}
			?>
			addText += "</select></p>\n"
			$(this).before(addText);
		});

		$('form').submit(function() {
			return false;
		});
	});
	</script>
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<?php require 'header.php'; ?>
		<h2>Add New Session</h2>

		<form action='processAddSession.php' method='post'>
			<div><button>Click to add a practice Item</button></div>
			<p>Total practice time (in minutes): <input type='text' name='minutes' /></p>
			<p><input type='submit' value='Save session' /></p>
		</form>
</body>
</html>