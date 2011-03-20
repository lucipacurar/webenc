<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>WebEnc</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">
<link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Syncopate' rel='stylesheet' type='text/css'>
<link href='style.css' rel='stylesheet' type='text/css'>
</head>
    <body>
    	<?php
			if ($_POST) {
				$target_path = $_SERVER['DOCUMENT_ROOT']."/".basename( $_FILES['video']['name']);
				if(move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
    				echo "The file ".basename($_FILES['video']['name'])." has been uploaded\n";
				} else{
    				echo "There was an error uploading the file, please try again!\n";
				}
				$connection = mysql_connect('127.0.0.1', 'webenc', 'waterford');
				if (!$connection) {
					die('Cannot establish a connection'.mysql_error($connection));
				}
				else {
				echo("Connection established!\n");
				}
				mysql_select_db("webenc", $connection);
				$query = "INSERT INTO jobs SET filename='".$_FILES['video']['name']."'";
				mysql_query($query, $connection);
				mysql_close($connection);
				echo ("./encode.sh ".$_FILES['video']['name']." ".$_POST["bitrate"]." ".$_POST["profile"]." ".$_POST["preset"]." ".$_POST["tune"]." ".$_POST["width"]." ".$_POST["height"]." > /dev/null 2>&1 &");
				exec("./encode.sh ".$_FILES['video']['name']." ".$_POST["bitrate"]." ".$_POST["profile"]." ".$_POST["preset"]." ".$_POST["tune"]." ".$_POST["width"]." ".$_POST["height"]." > /dev/null 2>&1 &");
				header("Location: /status.php");
			}
		?>
		<div id="container">
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
				<fieldset>
					<input type="file" name="video" />
				</fieldset>
				<fieldset>
					<label for="bitrate">Bitrate (kbps):</label>
					<input type="text" name="bitrate" />
				</fieldset>
				<fieldset>
					<label for="profile">Profile:</label>
					<select name="profile">
						<option value="baseline">Baseline</option>
						<option value="main">Main</option>
						<option value="high">High</option>
					</select>
				</fieldset>
				<fieldset>
					<label for="preset">Preset:</label>
					<select name="preset">
						<option value="ultrafast">Ultra fast</option>
						<option value="superfast">Super fast</option>
						<option value="veryfast">Very fast</option>
						<option value="faster">Faster</option>
						<option value="fast">Fast</option>
						<option value="medium" selected="selected">Medium</option>
						<option value="slow">Slow</option>
						<option value="slower">Slower</option>
						<option value="veryslow">Very slow</option>
						<option value="placebo">Placebo</option>
					</select>
				</fieldset>
				<fieldset>
					<label for="tune">Tune:</label>
					<select name="tune">
						<option value="none">None</option>
						<option value="film">Film</option>
						<option value="animation">Animation</option>
						<option value="grain">Grain</option>
						<option value="stillimage">Still image</option>
						<option value="psnr">PSNR</option>
						<option value="ssim">SSIM</option>
						<option value="fastdecode">Fast decode</option>
						<option value="zerolatency">Zero latency</option>
					</select>
				</fieldset>
				<fieldset id="resize">
					<label>Resize</label>
					<label for="width">Width (px):</label>
					<input type="text" name="width" />
					<label for="height">Height (px):</label>
					<input type="text" name="height" />
				</fieldset>
				<fieldset id="encode">
					<input type="submit" value="Encode" />
				</fieldset>
		</form>
		</div>
    </body>
</html>