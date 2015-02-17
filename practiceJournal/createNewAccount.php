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
	<title>Create New Account - Go Practice!</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css" />
	<script src ="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.min.js"></script>
	<script>
	$(document).ready(function(){
		$(".error").hide();
		$("form").submit(function() {
			var username = document.getElementById("username");
			var pass = document.getElementById("password");
			var rePass = document.getElementById("rePass");
				if (username.value == "") {
				$("#userError").show();
				return false;
			}
				if (pass.value == "") {
				$("#passError").show();
				return false;
			}
				if (rePass.value == "" || rePass.value != pass.value) {
				$("#rePassError").show();
				return false;
			}
				return true;
		});
	});
	</script>
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<h2>Create an Account</h2>
		<form action='processCreateAccount.php' method='post'>
			<p>Username: <input id='username' type='text' name='username' /></p><p id='userError' class='error'>This field is required.</p>
			<p>Password: <input id='password' type='password' name='password' /></p><p id='passError' class='error'>This field is required.</p>
			<p>Confirm password: <input id='rePass' type='password' /></p><p id='rePassError' class='error'>Passwords must match.</p>
			<input type='submit' value='Create Account'/>
		</form>
		<p><a href="home.php" class="add yellow">Back to Home</a></p>
	</div>
</body>
</html>
