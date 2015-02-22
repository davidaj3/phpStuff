<?php 
session_start();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] === false) {
	$url = "http://" . $_SERVER["HTTP_HOST"];
	$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$url .= "/login.php";
	header("Location: " . $url, 302);
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create New Journal - Go Practice!</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css">
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.min.js'></script>
	<script>
	$(document).ready(function(){
		$('input[type="submit"]').attr('disabled', 'disabled');
		$('input[type="text"]').keyup(function() {
			if($(this).val() != '') {
				$('input[type="submit"]').removeAttr('disabled');
			}
		});
	});
	</script>
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<?php require 'header.php'; ?>
		<h2>Create New Journal</h2>
		<form action='processCreateJournal.php' method='post'>
			<p>New Journal Name: <input type='text' name='journalName' /></p>
			<p><input type='submit' value='Create Journal' /></p>
		</form>
		<a class='yellow add' href='main.php'>Back to Home</a>
	</div>
</body>
</html>