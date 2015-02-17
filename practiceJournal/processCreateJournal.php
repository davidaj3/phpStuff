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

if (!isset($_SESSION["curUserId"])) {
	echo "SYSTEM ERROR";
	die();
}

$journalName = $_POST["journalName"];

$duplicate = false;
foreach ($db->query("SELECT name FROM journal WHERE userId=" . $_SESSION["curUserId"]) as $row) {
	if ($journalName == $row["name"]) {
		$duplicate = true;
	}
}

if ($duplicate) {
	$_SESSION["errorMsg"] = "You already have a journal with this name.";
} elseif (empty($journalName)) {
	$_SESSION["errorMsg"] = "Journal name is empty.";
} else {
	$_SESSION["errorMsg"] = null;
	$stmt = $db->prepare("INSERT INTO journal (name, userId) VALUES (:name, " . $_SESSION["curUserId"] . ")");
	$stmt->bindValue(":name", $journalName, PDO::PARAM_STR);
	$stmt->execute();
}

$url = "http://" . $_SERVER["HTTP_HOST"];
$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$url .= "/main.php";
header("Location: " . $url, 302);
die();

?>