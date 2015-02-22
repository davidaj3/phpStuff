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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home - Go Practice!</title>
	<link rel="stylesheet" type="text/css" href="journalStyle.css">
</head>
<body>
	<div class='main'>
		<h1>Go Practice!</h1>
		<?php 
		require 'header.php'; 
		if (isset($_SESSION["errorMsg"])) {
			echo "<p class='error'>" . $_SESSION["errorMsg"] . "</p>\n";
			$_SESSION["errorMsg"] = null;
		} elseif (isset($_SESSION["success"]) && $_SESSION["success"] === true) {
			echo "<p class='success'>Journal created successfully</p>";
			$_SESSION["success"] = null;
		}
		
		try {
			$db = loadDatabase();

			$stmt = $db->prepare("SELECT `journalId`, `name` FROM `journal` WHERE userId = (SELECT userId FROM user WHERE username=:name)");
			$stmt->bindValue(':name', $_SESSION["currentUser"], PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


			if (empty($rows)) {
				echo "<p>You don't have any journals yet.</p>\n";
			}
			else {
				echo "<h4>Your journals: </h4>\n";

				foreach($rows as $row) {
					echo "<p><a href='showJournal.php?journalId=" . $row["journalId"] . "'>" . $row["name"] . "</a></p>\n"; 
				}
			}

		} catch (PDOException $ex) {
			echo "DATABASE ERROR";
			die();
		}
		?>

		<p><a href="createJournal.php" class="add">Create a new journal</a></p>
		<p><a href="logout.php" class="add yellow">Logout</a></p>
	</div>
</body>
</html>
