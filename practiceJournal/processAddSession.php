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

if (!isset($_SESSION["curUserId"]) || !isset($_SESSION["workingJournalId"])) {
	echo "SYSTEM ERROR";
	die();
}

$practiceTime = $_POST["minutes"];
$pItemTitles = $_POST["title"];
$pItemCategories = $_POST["category"];
$pItemContents = $_POST["content"];


$_SESSION["success"] = false;
if (count($pItemTitles) != count($pItemCategories) || count($pItemCategories) != count($pItemContents)) {
	$_SESSION["errorMsg"] = "No form fields should be left blank.";
} elseif (is_nan($practiceTime)) {
	$_SESSION["errorMsg"] = "Practice time must be a number";
} else {
	$_SESSION["errorMsg"] = null;
	$_SESSION["success"] = true;

	$stmt = $db->prepare("INSERT INTO session (date, journalId, minutes) VALUES (NOW(), :id, :minutes)");
	$stmt->bindValue(":id", $_SESSION["workingJournalId"], PDO::PARAM_INT);
	$stmt->bindValue(":minutes", $practiceTime, PDO::PARAM_INT);
	$stmt->execute();
	$sessionId = $db->lastInsertId();
}

for ($i = 0; $i < count($pItemTitles); $i++) {
	$title = $pItemTitles[$i];
	$category = $pItemCategories[$i];
	$content = $pItemContents[$i];

	if (empty($title) || empty($category) || empty($content)) {
		$_SESSION["errorMsg"] = "No form fields should be left blank.";
		$_SESSION["success"] = false;
	} else {
		$_SESSION["errorMsg"] = null;
		$stmt = $db->prepare("INSERT INTO practiceItem (sessionId, category, title, details) VALUES ($sessionId, :category, :title, :details)");
		$stmt->bindValue(":category", $category, PDO::PARAM_INT);
		$stmt->bindValue(":title", $title, PDO::PARAM_STR);
		$stmt->bindValue(":details", $content, PDO::PARAM_STR);
		$stmt->execute();
	}
}

$url = "http://" . $_SERVER["HTTP_HOST"];
$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$url .= "/showJournal.php?journalId=" . $_SESSION["workingJournalId"];
header("Location: " . $url, 302);
die();

?>