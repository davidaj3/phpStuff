<?php 
session_start();

require 'loadDatabase.php';
require 'password.php';

if($_SERVER["REQUEST_METHOD"] != "POST") {
	echo "<p>Sorry, something went wrong.</p>";
	die();
}

try {
	$db = loadDatabase();

	$statement = $db->prepare("SELECT userId, username, password FROM user WHERE username=:user");
	$statement->bindValue(":user", $_POST["username"], PDO::PARAM_STR);
	$statement->execute();

	$valid = false;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		if (password_verify($_POST["password"], $row["password"])) {
			$valid = true;
			$_SESSION["curUserId"] = $row["userId"];
			$_SESSION["currentUser"] = $row["username"];
		}
	}

	if ($valid) {
		$_SESSION["loggedIn"] = true;
		$_SESSION["invalid"] = false;

		$url = "http://" . $_SERVER["HTTP_HOST"];
		$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$url .= "/main.php";
		header("Location: " . $url, 302);
		die();
	} else {
		$_SESSION["invalid"] = true;

		$url = "http://" . $_SERVER["HTTP_HOST"];
		$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$url .= "/login.php";
		header("Location: " . $url, 302);
		die();
	}

} catch (PDOException $ex) {
	echo "DATABASE ERROR!";
	die();
}


?>