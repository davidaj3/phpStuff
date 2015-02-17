<?php 
session_start();

require 'loadDatabase.php';

if($_SERVER["REQUEST_METHOD"] != "POST") {
	echo "<p>Sorry, something went wrong.</p>";
	die();
}

try {
	$db = loadDatabase();
} catch (PDOException $ex) {
	echo "DATABASE ERROR!";
	die();
}

$username = $_POST["username"];
$password = $_POST["password"];

$duplicate = false;

foreach ($db->query("SELECT username, password FROM user") as $row) {
	if ($username == $row["username"]) {
		$duplicate = true;
	}
}

if ($duplicate) {
	$_SESSION["errorMsg"] = "User $username already exists!";
} elseif (empty($username) || empty($password)) {
	$_SESSION["errorMsg"] =  "Username or password is blank.";
} else {
	$_SESSION["errorMsg"] = null;
	$stmt = $db->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
	$stmt->bindValue(":username", $username, PDO::PARAM_STR);
	$stmt->bindValue(":password", $password, PDO::PARAM_STR);
	$stmt->execute();
}

$url = "http://" . $_SERVER["HTTP_HOST"];
$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$url .= "/confirmCreateAccount.php";
header("Location: " . $url, 302);
die();

?>