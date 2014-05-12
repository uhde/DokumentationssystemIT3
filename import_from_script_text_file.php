<html><head></head>
<body>
<?php
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    // Dieses Script liest Textdateien, welche vom installationsscript erstellt wurden, aus
    // und fügt diese in das DOKUIT system ein
    // DOGE: WOW, Much programming, such nice, cool 
    
    
    // Für das unten stehende Script werden folgende Daten benötigt:
    // kunde, kategorie, systemname
    
    $basis_url = "http://uhdsrv14.uhde.de/systeminvent/Scans/";
    $url = $basis_url.$systemname.".txt";
    // Gibt ein Feld  mit den inventarisierten DAten aus
    $invent_row =  file($url, FILE_IGNORE_NEW_LINES );
    /* Das Feld ist folgendermaßen aufgebaut:
    - Pro Zeile (und damit pro Feld gibt es eine Option
    - Die Zeilen sind:
    Rechnername, System-Typ , Seriennummer, Mac Adresse, Teamviewer ID
    */
    $rechnername=$invent_row[0];
    $systemtyp=$invent_row[1];
    $seriennummer=$invent_row[2];
    $mac=$invent_row[3];
    $teamviewer_id=$invent_row[4];
    $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
    $sqlquery=$sqlquery."`name` = '".$rechnername."' ";
    $sqlquery=$sqlquery."`kunde` = '".$kunde."' ";
    $sqlquery=$sqlquery."`kategorie` = '".$kategorie."' ";
    $sqlquery=$sqlquery."`system` = '".$systemtyp."' ";
    $sqlquery=$sqlquery."`sn` = '".$seriennummer."' ";
    $sqlquery=$sqlquery."`mac_adresse` = '".$mac."' ";
    
    
    echo $sqlquery;
    
    //$objMySQL->Query($sqlquery);
?>
</body>
</html>