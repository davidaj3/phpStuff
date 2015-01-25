<?php
session_start();

$file = fopen("surveyResults.txt", 'r') or die("Error opening results file");
$line = "";


//read results file
for($i = 0; $i < 5; $i++) {
	$line = fgets($file);
	$lines = explode(':', $line);
	$instrResults[$lines[0]] = intval($lines[1]);
}

for($i = 0; $i < 7; $i++) {
	$line = fgets($file);
	$lines = explode(':', $line);
	$periodResults[$lines[0]] = intval($lines[1]);	
}

for($i = 0; $i < 7; $i++) {
	$line = fgets($file);
	$lines = explode(':', $line);
	$russianResults[$lines[0]] = intval($lines[1]);
}

for ($i = 0; $i < 10; $i++) {
	$line = fgets($file);
	$lines = explode(':', $line);
	$mahlerResults[$lines[0]] = intval($lines[1]);
}

fclose($file);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$instrFamily = $_POST["instrFamily"];
	$period = $_POST["period"];
	$russian = $_POST["russian"];
	$mahler = $_POST["mahler"];

	$instrResults[$instrFamily] += 1;
	$periodResults[$period] += 1;
	$russianResults[$russian] += 1;
	$mahlerResults[$mahler] += 1;

	$_SESSION["voted"] = true; //Current user has voted; question page will redirect.

	//update results file
	$file = fopen("surveyResults.txt", 'w') or die("Error writing to results file");
	foreach ($instrResults as $key => $value) {
		$text = $key . ':' . $value . "\n";
		fwrite($file, $text);
	}
	foreach ($periodResults as $key => $value) {
		$text = $key . ':' . $value . "\n";
		fwrite($file, $text);
	}
	foreach ($russianResults as $key => $value) {
		$text = $key . ':' . $value . "\n";
		fwrite($file, $text);
	}
	foreach($mahlerResults as $key => $value) {
		$text = $key . ':' . $value . "\n";
		fwrite($file, $text);
	}
	fclose($file);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Survey Results</title>
	<link rel="stylesheet" type="text/css" href="indexStyle.css">
</head>
<body>
	<div class="main">
		<h1>Survey Results</h1>
		<h4>Favorite Instrument Group</h4>
		<?php
		foreach ($instrResults as $key => $value) {
			echo "$key: $value votes<br />";
		}
		?>
		<h4>Favorite Musical Historical Period</h4>
		<?php
		foreach ($periodResults as $key => $value) {
			echo "$key: $value votes<br />";
		}
		?>
		<h4>Favorite Russian Composer</h4>
		<?php
		foreach ($russianResults as $key => $value) {
			echo "$key: $value votes<br />";
		}
		?>
		<h4>Favorite Mahler Symphony</h4>
		<?php
		foreach ($mahlerResults as $key => $value) {
			echo "Symphony $key: $value votes<br />";
		}
		?>
</body>
</html>
