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
    
    $systemname = $_GET['rechner'];
    $kategorie = $_GET['kategorie'];
    $kunde = $_GET['kunde'];
    $tv_prog_id = 15;
    $bios_prog_id = 22;
    $geraetepw_prog_id = 20;
    
    $kundenkuerzel = substr($systemname,0,3);
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
    $bs=$invent_row[5];             //Betriebssystem
    $sqlquery="INSERT INTO `".DB_DATABASE."`.`".TBL_GERAETE."` SET ";
    $sqlquery=$sqlquery."`name` = '".$rechnername."', ";
    $sqlquery=$sqlquery."`kunde` = '".$kunde."', ";
    $sqlquery=$sqlquery."`kategorie` = '".$kategorie."', ";
    $sqlquery=$sqlquery."`system` = '".$systemtyp."', ";
    $sqlquery=$sqlquery."`sn` = '".$seriennummer."', ";
    $sqlquery=$sqlquery."`mac_adresse` = '".$mac."', ";
    $sqlquery=$sqlquery."`garantie` = '".time() + (3*365*24*60*60)."', "; //Garantie auf jetzt + 3 Jahre gesetzt
    $sqlquery=$sqlquery."`bs` = '".$bs."' ";
    $geraete_einfuegen = $sqlquery; // Zu Übersichtszwecken
    
    $objMySQL->Query($geraete_einfuegen);
    $geraete_id = mysql_insert_id(); //Die Geräte ID wird geholt
    
//    http://dev.mysql.com/doc/refman/5.1/de/information-functions.html
    $sql="INSERT INTO `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET ";
    $sql=$sql."`geraete_id` = '".$geraete_id."', ";
    $sql=$sql."`programm_id` = '".$tv_prog_id."', ";
    $sql=$sql."`login` = '".$teamviewer_id."', ";
    $sql=$sql."`passwort` = 'UHDETV', ";
    $sql=$sql."`aktiv` = '1' ";
    $teamviewer_insert = $sql;
    
    $sql="INSERT INTO `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET ";
    $sql=$sql."`geraete_id` = '".$geraete_id."', ";
    $sql=$sql."`programm_id` = '".$bios_prog_id."', ";
    $sql=$sql."`login` = '', ";
    $sql=$sql."`passwort` = '$".$kundenkuerzel."bios%"."', ";
    $sql=$sql."`aktiv` = '0' ";
    $bios_insert = $sql;
    
    $sql="INSERT INTO `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET ";
    $sql=$sql."`geraete_id` = '".$geraete_id."', ";
    $sql=$sql."`programm_id` = '".$geraetepw_prog_id."', ";
    $sql=$sql."`login` = '".$kundenkuerzel."wsadmin', ";
    $sql=$sql."`passwort` = '$".$kundenkuerzel."wslan%"."', ";
    $sql=$sql."`aktiv` = '0' ";
    $geraetepw_insert = $sql; //Lokaler Login
    
    $objMySQL->Query($teamviewer_insert);
    $objMySQL->Query($bios_insert);
    $objMySQL->Query($geraetepw_insert);
    echo "Geraete Einfuegen SQL: ".$geraete_einfuegen."<br>";  
    echo "Geraete ID: ".$geraete_id."<br>";
    echo $teamviewer_insert."<br>";  
    echo $bios_insert."<br>"; 
    echo $geraetepw_insert."<br>"; 
    //DEBUG Ausgaben
    
    
    //$objMySQL->Query($sqlquery);
?>
</body>
</html>