<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=9">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link rel="stylesheet" href="css/reset.css" type="text/css" />
    </head>
    <body>

    <?php 
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    require_once('config.inc.php');
    include_once("mysql.class.php");
    include_once("template.class.php");
    include_once("functions.inc.php");
        $objMySQL = new MySQL();
        if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
           echo $objMySQL->Error();
           $objMySQL->Kill();
        }
    include ("geraete.inc.php");


    ?>
    <a href="index.php">Zurück...</a>
    </body>
</html>