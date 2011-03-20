#!/usr/bin/php
<?php
	$connection = mysql_connect('127.0.0.1', 'webenc', 'waterford');
	if (!$connection) {
		die('Cannot establish a connectin'.mysql_error($connection));
	}
	else {
		echo("Connection established!\n");
	}
	mysql_select_db("webenc", $connection);
	if ($argv[1] == "video") {
		$query = "UPDATE jobs SET video_progress=$argv[3], video_eta='$argv[4]' WHERE filename='$argv[2]'";
	}
	if ($argv[1] == "audio") {
		$query = "UPDATE jobs SET audio_progress=$argv[3] WHERE filename='$argv[2]'";
	}
	if ($argv[1] == "mux") {
		$query = "UPDATE jobs SET mux_progress='$argv[3]' WHERE filename='$argv[2]'";
	}
	if ($argv[1] == "mux" && $argv[3] == "Ended") {
		$query = "UPDATE jobs SET mux_progress='$argv[3]', complete=true WHERE filename='$argv[2]'";
	}
	mysql_query($query,$connection);
	mysql_close($connection);
?>