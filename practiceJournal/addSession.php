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
		$(".error").hide();

		var practiceItemCount = 0;
		$('#add').click(function(){
			var addText =  "<p>Title of practice item: <input type='text' name='title[]' /></p>\n";
			addText += "<p>Category: <select name='category[]'><option value=''></option>\n";
			<?php 
			foreach ($db->query("SELECT categoryId, categoryName FROM category") as $row) {
				echo "addText += \"<option value='" . $row["categoryId"] . "'>" . $row["categoryName"] . "</option>\";\n";
			}
			?>
			addText += "</select></p>\n";
			addText += "<div>Details: <br /><textarea name='content[]' rows='10' cols='40'></textarea><hr width='300'/>\n";
			$(this).before(addText);
		});

		$('form').submit(function() {
			var valid = true;
			$("input, select, textarea").each(function() {
				if ($(this).val() == "" || $(this).val() == null) {
					valid = false;
					$("#error").text("Please fill out all form elements");
					$("#error").show();
				}
			})

			if (isNaN($("#minutes").val())) {
				valid = false;
				$("#error").text("Practice time must be a number.");
				$("#error").show();
			}
			return valid;
		});
	});
	</script>
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<?php require 'header.php'; ?>
		<h2>Add New Session</h2>
		<hr width="300" />

		<form action='processAddSession.php' method='post'>
			<div><input type='button' id='add' value = 'Click to add a practice Item' /></div>
			<p>Total practice time (in minutes): <input type='text' name='minutes' id='minutes'/></p>
			<p><input type='submit' value='Save session' /></p>
		</form>
		<p id="error" class="error"></p>
		<?php 
			echo "<a class='add yellow' href='showJournal.php?" . $_SESSION["workingJournalId"] . "'>Back to Journal</a>\n";
		?>
</body>
</html>