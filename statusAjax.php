<?php
	$connection = mysql_connect('127.0.0.1', 'webenc', 'waterford');
	if (!$connection) {
		die('Cannot establish a connection'.mysql_error($connection));
	}
	mysql_select_db("webenc", $connection);
	$query = "SELECT * FROM jobs";
	$result = mysql_query($query, $connection);
	$tablerows = '<?xml version="1.0" encoding="UTF-8" ?>';
	$tablerows .= "<results>\r\n";
	$downloadLink = "";
	while ($row = mysql_fetch_assoc($result)) {
		if ($row["complete"] == true) {
			$encodedFile = explode(".", $row['filename']);
			$downloadLink = "<a href=\"/".$encodedFile[0].".mp4\">Download</a>";
		} else {
			$downloadLink = "";
		}
		//$tablerows .= "<tr><td>".$row['filename']."</td><td>".$row['video_progress']."%</td><td>".$row['video_eta']."</td><td>".$row['audio_progress']."%</td><td>".$row['mux_progress']."</td><td>".$downloadLink."</td></tr>";
		$tablerows .= "<video>\r\n<id>".$row['ID']."</id>\r\n";
		$tablerows .= "<filename>".$row['filename']."</filename>\r\n";
		$tablerows .= "<videoprogress>".$row['video_progress']."%</videoprogress>\r\n";
		$tablerows .= "<videoeta>".$row['video_eta']."</videoeta>\r\n";
		$tablerows .= "<audioprogress>".$row['audio_progress']."%</audioprogress>\r\n";
		$tablerows .= "<muxprogress>".$row['mux_progress']."</muxprogress>\r\n";
		$tablerows .= "<encoded>".$encodedFile[0].".mp4</encoded>\r\n</video>\r\n";
	}
	$tablerows .= "</results>\r\n";
	$file = fopen("results.xml", "w");
	fwrite($file, $tablerows);
	fclose($file);
	header("Location: /results.xml");
	mysql_close($connection); 
?>