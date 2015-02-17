<?php 
session_start();

$_SESSION["loggedIn"] = false;
$_SESSION["currentUser"] = null;
$_SESSION["curUserId"] = null;
$_SESSION["workingJournalId"] = null;

$url = "http://" . $_SERVER["HTTP_HOST"];
$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$url .= "/home.php";
header("Location: " . $url, 302);
die();

?>