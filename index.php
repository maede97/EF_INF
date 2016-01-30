<!DOCTYPE html>
<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("#header").load("header.php");
		$("#footer").load("footer.php");
		$("#menu").load("menu.php");
	});
</script>

<?php
function fill(){
	$out = "";
	for($i = 1; $i<=50; $i++){
		$out .= $i . "<br />";
	}
	return $out;
}
?>

<link rel="stylesheet" href="styles/style.css">
<html>
    <head>
        <title>SchoolTool - Vocabular</title>
    </head>
    <body>
		<div id="menu"></div>
		<div id="header"></div>
		<div id="main">
			<h1>Herzlich Willkommen!</h1>
			<h2>Dies ist eine Begrüssung! :-)</h2>
			<?php echo fill(); ?>
			<h1>Dies ist das Ende der Seite.</h1>
		</div>
		<div id="footer"></div>
    </body>
</html>