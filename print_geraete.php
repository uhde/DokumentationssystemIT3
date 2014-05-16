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
    session_start() ;
    require_once('include/config.inc.php');
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");
        $objMySQL = new MySQL();
        if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
           echo $objMySQL->Error();
           $objMySQL->Kill();
        }
    $objTemplate=new Template("layout/geraete_general.lay.php");
    include ("include/geraete.inc.php");


    ?>
    <a href="index.php">Zurück...</a>
    </body>
</html>