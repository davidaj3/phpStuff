<?php
session_start();

if (isset($_SESSION["voted"]) && $_SESSION["voted"] === true) {
	$url = "http://" . $_SERVER["HTTP_HOST"];
	$url .= rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$url .= "/surveyResults.php";
	header("Location: " . $url, 302);
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Survey</title>
	<link rel="stylesheet" type="text/css" href="indexStyle.css">
</head>
<body>
	<div class="main">
		<h1>Music Survey</h1>
		<p>Since I'm such a classical music nerd, here's a nerdy music survey.</p>
		<p><a href="surveyResults.php">Skip to results</a>
		<hr />
		<form method="post" action="surveyResults.php">
			<h4>What is your favorite instrument family?</h4>
			<input type="radio" name="instrFamily" value="strings" checked="checked" /><label>Strings</label><br />
			<input type="radio" name="instrFamily" value="woodwinds" /><label>Woodwinds</label><br />
			<input type="radio" name="instrFamily" value="brass" /><label>Brass</label><br />
			<input type="radio" name="instrFamily" value="percussion" /><label>Percussion</label><br />
			<input type="radio" name="instrFamily" value="voice" /><label>Voice</label><br />
			<br />
			
			<h4>What is your favorite musical historical period?</h4>
			<input type="radio" name="period" value="antiquity" checked="checked" /><label>Antiquity</label><br />
			<input type="radio" name="period" value="medieval" /><label>Medieval</label><br />
			<input type="radio" name="period" value="renaissance" /><label>Renaissance</label><br />
			<input type="radio" name="period" value="baroque" /><label>Baroque</label><br />
			<input type="radio" name="period" value="classic" /><label>Classic</label><br />
			<input type="radio" name="period" value="romantic" /><label>Romantic</label><br />
			<input type="radio" name="period" value="20th century" /><label>20th Century</label><br />
			<br />

			<h4>Who is your favorite Russian composer?</h4>
			<input type="radio" name="russian" value="Tchaikovsky" checked="checked" /><label>Pyotr Tchaikovsky</label><br />
			<input type="radio" name="russian" value="Mussorgsky" /><label>Modest Mussorgsky</label><br />
			<input type="radio" name="russian" value="Shostakovich" /><label>Dmitri Shostakovich</label><br />
			<input type="radio" name="russian" value="Rachmaninoff" /><label>Sergei Rachmaninoff</label><br />
			<input type="radio" name="russian" value="Stravinsky" /><label>Igor Stravinsky</label><br />
			<input type="radio" name="russian" value="Prokofiev" /><label>Sergei Prokofiev</label><br />
			<input type="radio" name="russian" value="Borodin" /><label>Alexander Borodin</label><br />
			<br />

			<h4>Which is your favorite Mahler symphony?</h4>
			<?php
			for ($i = 1; $i < 11; $i++) {
				echo "<input type='radio' name='mahler' value='$i' ";
				if ($i == 1) {
					echo "checked='checked' ";
				}
				echo "/><label>Symphony no. $i</label><br />";
			}
			?>
			<br />
			<input type="submit" value="Submit" />
		</form>
	</div>
</body>
</html>