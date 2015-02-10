<?php 
session_start();

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
	$url = "http://" . $_SERVER["HTTP_HOST"];
	$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$url .= "/main.php";
	header("Location: " . $url, 302);
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Go Practice! An Online Practice Journal</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css">
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<h2>An Online Practice Journal</h2>
		<blockquote>
			"Music is a proud, temperamental mistress. 
			Give her the time and attention she deserves, and she is yours. 
			Slight her and there will come a day when you call and she will not answer. 
			So I began sleeping less to give her the time she needed."<br />
			--Patrick Rothfuss, <span class="italics">The Name of the Wind</span>
		</blockquote>
		<p><img src='journalPic.jpg' alt = 'Practice Journal' /></p>
		<p><a class='add' href='login.php'>Sign in</a></p>
		<p><a class='add' href='createNewAccount.php'>Create An Account</a></p>
	</div>
</body>
</html>