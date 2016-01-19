<?php
function test(){
    return "<p>Hallo!</p>";
}
?>
<html>
    <head>
        <title>Index</title>
    </head>
    <body>
        <h1>
            PHP-Projekt
        </h1>
        <?php echo(test()); ?>
    </body>
</html>