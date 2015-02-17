<?php 
session_start();

require 'loadDatabase.php';

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] === false) {
	$url = "http://" . $_SERVER["HTTP_HOST"];
	$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$url .= "/login.php";
	header("Location: " . $url, 302);
	die();
}

try {

	$db = loadDatabase();
	
	$valid = false;

	foreach ($db->query("SELECT username, journalId FROM journal j JOIN user u ON j.userId = u.userId WHERE journalId = " . $_GET["journalId"]) as $row) {
		if ($row["username"] == $_SESSION["currentUser"]) {
			$valid = true;
		}
	}
	

	if (!$valid) {
		$url = "http://" . $_SERVER["HTTP_HOST"];
		$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$url .= "/main.php";
		header("Location: " . $url, 302);
		die();
	}

	$_SESSION["workingJournalId"] = $_GET["journalId"];

	$stmt = $db->prepare("SELECT sessionId, `date`, minutes FROM `session` WHERE journalId = :journal GROUP BY `date` DESC");
	$stmt->bindValue(':journal', $_GET["journalId"], PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $ex) {
	echo "DATABASE ERROR";
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Journal Display</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css">
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<?php require 'header.php' ?>
		<h2>'<?php foreach ($db->query("SELECT name FROM journal WHERE journalId = " . $_GET["journalId"]) as $row) { echo $row["name"]; } ?>'</h2>
		<?php 
		if (empty($rows)) {
			echo "<p>You don't have any recorded practice sessions yet.</p>\n";
		} else {
			echo "<h4>Sessions: </h4>\n";
			foreach($rows as $row) {
				echo "<table>\n
						<caption>Session Date: " . $row['date'] . "</caption>\n
						<tr>\n
						  <th>Category</th>\n
						  <th>Title</th>\n
						  <th>Details</th>\n
						</tr>\n";

				foreach($db->query("SELECT pi.title, c.categoryName, pi.details FROM practiceItem pi JOIN category c ON pi.category = c.categoryId
					    WHERE pi.sessionId = " . $row['sessionId']) as $piRow) {
					echo "<tr>\n
						    <td>" . $piRow["categoryName"] . "</td>\n
						    <td>" . $piRow["title"] . "</td>\n
						    <td>" . $piRow["details"] . "</td>\n
						  </tr>\n";
				}
				echo "</table>\nPractice time: " . $row["minutes"] . " minutes<br /><br />\n";
			}
		}
		?>

		<p><a href="addSession.php" class="add">Add a practice session</a></p>
		<p><a href="main.php" class="add yellow">Back to journal list</a></p>
		<p><a href="logout.php" class="add yellow">Logout</a></p>
	</div>
</body>
</html>