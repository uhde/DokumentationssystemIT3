<?php
// In diesem Script wird der Teamviewer log aus appdata in seine Einzelteile zerlegt und in eine Datenbank eingetragen.

// Syntax mit der dieses Script aufgerufen werden soll:
// [scriptpfad]?file=[name des teamviewer logs]
// Das Teamviewer log muss im gleichen verzeichnis wie das script liegen

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
    require_once('../include/config.inc.php');
    include_once("../include/mysql.class.php");
    include_once("../include/template.class.php");
    include_once("../include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
  $ordner       = "teamviewer_log";
  $alledateien  = scandir($ordner); //Ordner "files" auslesen
$gesamt_count = 0;
     
foreach ($alledateien as $datei) { // Dateien werden durchlaufen
  if(($datei != '.' && $datei != '..') && substr($datei, -3)=="txt" )
  {
    $filename = $ordner."/".$datei;
    
    
    $count = 0;
    //$filename = $_GET['file'];
    $log = file($filename);
    $log_tabelle = "fernwartungs_log";
    $zeile_verarbeitet = false;
    foreach( $log as $logzeile ) 
    {
        $zeile_verarbeitet = true;
        // Hier wird eine Zeile des Logs aufgesplittet. Struktur: 0=tv-id 1=datum1 2=uhrzeit1
        $logteile =  preg_split("/[\s,]+/",$logzeile);
        /*foreach($logteile as $temp)
        {
            echo $temp."<br>";
        }*/
        $datum1 = explode('-',$logteile[1]);
        $uhrzeit1 = explode(':',$logteile[2]);
        //echo "d:".$datum1[0]." month:".$datum1[1]." year:".$datum1[2].'<br>';
        //echo "h:".$uhrzeit1[0]."   m:".$uhrzeit1[1]."  s:".$uhrzeit1[2].'<br>';
        $timestamp_anfang = mktime(intval($uhrzeit1[0]),intval($uhrzeit1[1]),intval($uhrzeit1[2]),intval($datum1[1]),intval($datum1[0]),intval($datum1[2]));
        //echo $timestamp_anfang.'<br>';
        //echo "<br>".date(DATE_RFC822,$timestamp_anfang);
        $datum2 = explode('-',$logteile[3]);
        $uhrzeit2 = explode(':',$logteile[4]);
        $timestamp_ende = mktime(intval($uhrzeit2[0]),intval($uhrzeit2[1]),intval($uhrzeit2[2]),intval($datum2[1]),intval($datum2[0]),intval($datum2[2]));
        //echo $timestamp_ende.'<br>';
        $benutzer = $logteile[5];
        $teamviewer_id = $logteile[0];
        
        $dauer = $timestamp_ende - $timestamp_anfang;
        $sql = 'SELECT * FROM '.DB_DATABASE.".".$log_tabelle." WHERE ziel = '".$teamviewer_id."' AND start_zeit='".$timestamp_anfang."' AND end_zeit='".$timestamp_ende."' AND benutzer='".$benutzer."'";
        $test = $objMySQL->Query($sql);
        //echo $sql."<br>";
        
        //echo intval(mysql_num_rows($test))."<br>";
        if(intval(mysql_num_rows($test))<1) {
            if(!empty($teamviewer_id)){
                // Wenn der Datensatz nicht vorhanden sein sollte, wird dieser Teil der if anweisung ausgeführt.
                //Sucht die Kundennummer raus.
                
                //Prüft ob eine Teamviewer-Lan verbindung vorlag, oder nicht
                if(strlen($teamviewer_id)==9 && ctype_digit($teamviewer_id))
                {
                    // Falls eine Teamviewer Web verbindung vorlag, wird dieser Code Teil ausgeführt
                    $sql = "SELECT gr.kunde FROM geraete AS gr, geraete_login AS gl WHERE gl.login='".$teamviewer_id."' AND gl.geraete_id=gr.id";
                    $tempdata = $objMySQL->QuerySingleRowArray($sql);
                    
                    $kunde = $tempdata['kunde'];
                    $programm = "Teamviewer - Web";
                    
                }
                else {
                    $sql = "SELECT gr.kunde FROM geraete AS gr WHERE gr.adresse='".$teamviewer_id."' ";
                    $tempdata = $objMySQL->QuerySingleRowArray($sql);
                    
                    $kunde = $tempdata['kunde'];
                    $programm = "Teamviewer - LAN";
                }
                // Falls kein Kunde gefunden werden kann, wird er auf minus 1 gesetzt
                if (empty($kunde))
                    $kunde = -1;
                // Debug-Ausgabe
                //echo "<br>".$sql." : <br>";
                
                $sql = "INSERT INTO `".DB_DATABASE."`.`".$log_tabelle."` SET ";
                $sql = $sql."ziel='".$teamviewer_id."' , start_zeit='".$timestamp_anfang."' , end_zeit='".$timestamp_ende."' , ";
                $sql = $sql."benutzer='".$benutzer."' , kunde='".$kunde."' , dauer='".$dauer."' , programm = '".$programm."'";
                $objMySQL->Query($sql);
                //echo $sql."<br>";
                $count ++;
            }
        }
       //echo "----------------<br>";
        
        
    }
    if ($zeile_verarbeitet == true)
        echo "Die Datei wurde erfolgreich eingelesen.";
    else
        echo "<h1>Die Datei konnte nicht gelesen werden.</h1>";
        
    echo "<br>Scriptende<br><br> ";
    echo "Aus der Datei: ".$filename." wurden ".$count." Einträge übernommenen.";
    $gesamt_count = $gesamt_count + $count;
  }
};
echo "<br><br>Es wurden insgesamt ".$gesamt_count." Zeilen verarbeitet.";
?>