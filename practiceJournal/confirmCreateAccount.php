<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Created! - Go Practice</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css" />
</head>
<body>
	<div class="main">
		<h1>Go Practice!</h1>
		<?php 
		if (isset($_SESSION["errorMsg"])) {
			echo "<h2 class='error'>ERROR!</h2>\n";
			echo "<p class='error'>" . $_SESSION["errorMsg"] . "</p>\n";
		} else {
			echo "<h2 class='success'>Success!</h2>\n";
			echo "<p>Your account has successfully been created.</p>\n";
		}
		$_SESSION["errorMsg"] = null;
		?>
		<p><a class = "add yellow" href="home.php">Back to Home</a></p>
	</div>
</body>
</html>