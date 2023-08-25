<html>
    <head>
        <title>
        </title>
    </head>
    <body>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=supermomo", 'root', '');
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

$unbufferedResult = $pdo->query("SELECT * FROM links");
foreach ($unbufferedResult as $row) {
    echo '<a href="'.$_SERVER["SERVER_NAME"]."/".$row['url_key'].'">'.$row['title'].'</a><br />';
}
?>
    </body>
</html>