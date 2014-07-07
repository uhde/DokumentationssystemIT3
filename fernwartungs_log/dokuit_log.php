<?php
// In diesem Script wird das DokuIT_log in seine Einzelteile zerlegt und in eine Datenbank eingetragen.

// Syntax mit der dieses Script aufgerufen werden soll:
// [scriptpfad]?file=[name des teamviewer logs]
// Das Teamviewer log muss im dokuit verzeichnis /teamviewer liegen

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
    require_once('../include/config.inc.php');
    include_once("../include/mysql.class.php");
    include_once("../include/template.class.php");
    include_once("../include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    //"Datum";"Zeit";"Benutzer";"Ziel";"Partner";"Dauer";"Kunde";"Programm"
    //"02.01.2014";"08:32";"grueninger";......

    $count = 0;
    $filename = $_GET['file'];
    $log_tabelle = "fernwartungs_log";
    $zeile_verarbeitet = false;
    
    
    $zeilenummer = 1;
    // Zerlegt die CSV Datei
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($zeile = fgetcsv($handle, 300, ";",'"')) !== FALSE) {
            //Überprüft ob die Zeile vollständig ist, damit sie korrekt importiert werden kann
            $feldanzahl = count($zeile);
            if($feldanzahl!=8 && $zeilennummer!=1) 
            {
                echo "<h1>folgende Informationen wurden nicht gespeichert</h1><br>";
                echo "zeilennummer: ".$zeilenummer."<br>";
                for ($c=0; $c < $feldanzahl; $c++) {
                    echo $zeile[$c] . "<br />\n";
                }
            }
            else 
            {
                //zählen beginnt bei 0
                $datum          = explode('.',$zeile[0]);
                echo "<br>Datum = ".$datum.", zeile zum Datum = ". $zeile[0]; 
                $uhrzeit        = explode(':',$zeile[1]);
                $benutzer       = $zeile[2];
                $ziel           = $zeile[3];
                //"partner" wird ausgelassen
                $dauer          = $zeile[5];
                $kundenname     = $zeile[6];
                $programm       = $zeile[7];
                
                //Timestamps werden generiert
                $timestamp_anfang   = mktime(intval($uhrzeit1[0]),intval($uhrzeit1[1]),0,intval($datum1[1]),intval($datum1[0]),intval($datum1[2]));
                $timestamp_ende     = $timestamp_anfang + $dauer;
                
                
                foreach( $zeile as $logzeile )
                {
                    echo $logzeile.", ";
                }
                echo "<br>";
                $sql = "INSERT INTO `".DB_DATABASE."`.`".$log_tabelle."` SET ";
                $sql = $sql."ziel='".$ziel."' , start_zeit='".$timestamp_anfang."' , end_zeit='".$timestamp_ende."' , ";
                $sql = $sql."benutzer='".$benutzer."' , kunde='wird noch benötigt' , dauer='".$dauer."' , programm = '".$programm."'";
                echo $sql."<br>";
               
            }
             $zeilenummer++;
        }
        fclose($handle);
    }
    

    if ($zeile_verarbeitet == true)
        echo "Die Datei wurde erfolgreich eingelesen.";
    else
        echo "<h1>Die Datei konnte nicht gelesen werden.</h1>";
        
    echo "<br>Scriptende<br><br> ";
    echo "Aus der Datei: ".$filename." wurden ".$count." Einträge übernommenen.";
?>