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
    $url = "http://uhdsrv14.uhde.de/systeminvent/Scans/MUTWS036";
    
    // Gibt ein Feld  mit den inventarisierten DAten aus
    $invent_row =  @fopen ($url,"r");
    /* Das Feld ist folgendermaßen aufgebaut:
    - Pro Zeile (und damit pro Feld gibt es eine Option
    - Die Zeilen sind:
    Rechnername, System-Typ , Seriennummer, Mac Adresse, Teamviewer ID
    */
    $rechnername=$invent_row[0];
    $systemtyp=$invent_row[1];
    $seriennummer=$invent_row[2];
    
    echo "rechnername = ".$rechnername."<br>";
    echo "seriennummer = ".$seriennummer."<br>";
    echo $invent_row;
    
    //$objMySQL->Query($sql);
?>
</body>
</html>