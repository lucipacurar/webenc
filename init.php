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
	$query = "INSERT INTO jobs SET filename='$argv[1]'";
	mysql_query($query, $connection);
	mysql_close($connection);
?>