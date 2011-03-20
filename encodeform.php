<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Insert title here</title>
</head>
    <body>
    	<?php
			if ($_POST) {
				echo $_POST["file"];
				exec("./encode.sh ".$_POST["file"]." > /dev/null 2>&1 &");
			}
		?>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<input type="text" name="file" />
			<input type="submit" value="Encode" />
		</form>
    </body>
</html>