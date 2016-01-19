<?php
//https://regex101.com/r/rM9vN6/2
function test($email){
    $pattern = "^([a-zA-Z0-9]+[\._-]?)+\@([a-zA-Z0-9]+\.?)+\.[a-z]{2,3}$";
    if(mb_ereg_match($pattern, $email)){
        return "Ok";
    }
    return "nope";
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
        <?php echo(test("ksajdfhkh@googlelgijldsfjkljflkj.com")); ?>
    </body>
</html>