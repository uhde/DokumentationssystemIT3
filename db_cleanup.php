<html>
<head>
<?php
// Mithilfe dieses Scriptes werden Einträge, die schon ein Jahr lang als gelöscht markiert sind, auch tatsächlich gelöscht
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
?>
</head>
<body>
    <?php 
    // Zeitstempel mit der Zeit von vor einem Jahr
    $timestamp = time()-(365*24*60*60);
    $sql = "DELETE * FROM ".TBL_GERAETE." WHERE loeschen=0 AND loeschentime<".$timestamp;
    $objMySQL->Query($sql);
    $sql = "DELETE * FROM ".TBL_ZUGAENGE." WHERE loeschen=0 AND loeschentime<".$timestamp;
    $objMySQL->Query($sql);
    $sql = "DELETE * FROM ".TBL_GERAETE_LOGIN." WHERE loeschen=0 AND loeschentime<".$timestamp;
    $objMySQL->Query($sql);
    $sql = "DELETE * FROM ".TBL_DOKUMENTE." WHERE loeschen=0 AND loeschentime<".$timestamp;
    $objMySQL->Query($sql);
    $sql = "DELETE * FROM ".TBL_BILDER." WHERE loeschen=0 AND loeschentime<".$timestamp;
    $objMySQL->Query($sql);
    
    echo "Scriptende";
    ?>
</body>