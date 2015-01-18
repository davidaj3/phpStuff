<!DOCTYPE html>
<html>
	<head>
		<title>David A. Jones's compositions</title>
		<link rel="stylesheet" type="text/css" href="indexStyle.css" />
	</head>
	<body>
		<div class="main">
			<h1>Compositions</h1>
			<p>Here are recordings to a few of my best works.  I hope you enjoy them.</p>
			<div><a href = "index.html">Home</a></div>
			<hr />
			<?php
			$first = "<iframe width='100%' height='166' scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/";
			$last = "&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false'></iframe>";
			$recordings[] = "tracks/176185926"; //Aswang
			$recordings[] = "tracks/176152488"; //Trance
            $recordings[] = "playlists/59032491"; //Incarnation
            $recordings[] = "tracks/176184828"; //Tinalikuran
            $recordings[] = "playlists/58707190"; //Leviathan

            foreach ($recordings as $recording) {
            	echo "<div>$first$recording$last</div><hr />\n";
            }
            ?>
        </div>
    </body>
</html>
