<?php 
session_start();

if (isset($_SESSION["loggedIn"]) &&  $_SESSION["loggedIn"] === true) {
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
	<title>Login - Go practice!</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css">
</head>
<body>
	<div class='main'>
		<div class='form'>
			<h1>Go Practice!</h1>
			<h2>Login</h2>
			<?php 
			if (isset($_SESSION["invalid"]) && $_SESSION["invalid"] === true) {
				echo "<p style='color:red'>Invalid username or password</p>\n";
				$_SESSION["invalid"] = false;
			}
			
			?>

			<form action='authenticate.php' method='post'>
				<p>Username: <input type="text" name="username" /></p>
				<p>Password: <input type="password" name="password" /></p>
				<p><input type='submit' value='Log In' /></p>
			</form>
		</div>
	</div>
</body>
</html>