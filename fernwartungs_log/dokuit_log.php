In diesem Script wird das DokuIT_log in seine Einzelteile zerlegt und in eine Datenbank eingetragen.<br>
<h2>Bitte Warten...</h2>
<?php
// In diesem Script wird das DokuIT_log in seine Einzelteile zerlegt und in eine Datenbank eingetragen.

// Syntax mit der dieses Script aufgerufen werden soll:
// [scriptpfad]?file=[name des teamviewer logs]
// Das Teamviewer log muss im dokuit verzeichnis /teamviewer liegen

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
    //"Datum";"Zeit";"Benutzer";"Ziel";"Partner";"Dauer";"Kunde";"Programm"
    //"02.01.2014";"08:32";"grueninger";......
    $ordner = "dokuit_log";
    $alledateien = scandir($ordner); //Ordner "files" auslesen
$gesamt_count = 0;
$gesamt_zeilen = 0;
$teamviewer_eintraege = 0;
$uebersprungen = 0;
$starttime = time();
$fehler = 0;

echo "<br>Es koennte einige Minuten dauern, bis das Script durch ist<br>";

     
foreach ($alledateien as $datei) { // Dateien werden durchlaufen
  if(($datei != '.' && $datei != '..') && substr($datei, -3)=="csv" )
  {
    $filename = $ordner."/".$datei;
    $count = 0;
    
    //$filename = $_GET['file'];
    $log_tabelle = "fernwartungs_log";
    $zeile_verarbeitet = false;

    $zeilennummer = 1;
    // Zerlegt die CSV Datei
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($zeile = fgetcsv($handle, 300, ";",'"')) !== FALSE) {
            $zeile_verarbeitet  = true;
            
            //Überprüft ob die Zeile vollständig ist, damit sie korrekt importiert werden kann
            $feldanzahl = count($zeile);
            // Bricht ab, wenn eine Linie in der CSV Zeile nicht vollständig ist, oder wenn es die erste zeile ist.
            if($feldanzahl!=8 || $zeilennummer==1 || $zeile[0]=="Datum") 
            {
                $fehler++;
                /*echo "<b>folgende Informationen wurden nicht gespeichert: </b><br>";
                echo "zeilennummer: ".$zeilennummer."<br>";
                echo "Daten: ";
                for ($c=0; $c < $feldanzahl; $c++) {
                    echo $zeile[$c] . " ;  ";
                }
                echo "<br>";*/ 
            }
            else 
            {
                //zählen beginnt bei 0
                $datum          = explode('.',$zeile[0]);
                $uhrzeit        = explode(':',$zeile[1]);
                $benutzer       = $zeile[2];
                $ziel           = $zeile[3];
                //"partner" wird ausgelassen
                $dauer          = $zeile[5];
                $kundenname     = $zeile[6];
                $programm       = $zeile[7];
                
                //Timestamps werden generiert
                $timestamp_anfang   = mktime(intval($uhrzeit[0]),intval($uhrzeit[1]),0,intval($datum[1]),intval($datum[0]),intval($datum[2]));
                $timestamp_ende     = $timestamp_anfang + $dauer;
                
                if(strtolower($programm) == "teamviewer.exe")
                    $teamviewer_eintraege++;
                    
                $sql = 'SELECT * FROM '.DB_DATABASE.".".$log_tabelle." WHERE ziel = '".$ziel."' AND start_zeit='".$timestamp_anfang."' AND benutzer='".$benutzer."'";
                $test = $objMySQL->Query($sql);
                // Wenn die Zeile nicht schon vorhanden ist, wird sie eingefügt
                if(intval(mysql_num_rows($test))<1) {
                    if(strlen($ziel)==9 && ctype_digit($ziel))
                    {
                        // Falls eine Teamviewer Web verbindung vorlag, wird dieser Code Teil ausgeführt
                        $sql = "SELECT gr.kunde FROM geraete AS gr, geraete_login AS gl WHERE gl.login='".$ziel."' AND gl.geraete_id=gr.id";
                        $tempdata = $objMySQL->QuerySingleRowArray($sql);
                        $kunde = $tempdata['kunde'];
                    }
                    else {
                        $sql = "SELECT gr.kunde FROM geraete AS gr WHERE `adresse` REGEXP '".$ziel.".*' OR `name` REGEXP '".$ziel.".*'";
                        $tempdata = $objMySQL->QuerySingleRowArray($sql);
                        $kunde = $tempdata['kunde'];
                    }
                    if (empty($kunde))
                    {
                        $sql = "SELECT id FROM kunden WHERE `name` REGEXP '".$kundenname.".*' ";
                        $tempdata = $objMySQL->QuerySingleRowArray($sql);
                        $kunde = $tempdata['id'];
                    }
                    if (empty($kunde))
                        $kunde = -1;
                
                    $sql = "INSERT INTO `".DB_DATABASE."`.`".$log_tabelle."` SET ";
                    $sql = $sql."ziel='".$ziel."' , start_zeit='".$timestamp_anfang."' , end_zeit='".$timestamp_ende."' , ";
                    $sql = $sql."benutzer='".$benutzer."' , kunde='".$kunde."' , dauer='".$dauer."' , programm = '".$programm."'";
                    $objMySQL->Query($sql);
                    $count++;
                }
                else {
                    $uebersprungen++;
                    /*echo "zeilennummer: ".$zeilennummer."<br>";
                    echo "Daten: ";
                    for ($c=0; $c < $feldanzahl; $c++) {
                        echo $zeile[$c] . " ;  ";
                    }
                    echo "<br>".$sql."<br>";*/
                }
                //}
               
            }
            $zeilennummer++;
        }
        fclose($handle);
    }
    $zeilennummer = $zeilennummer - 1;
    echo "<br><br>";
    if ($zeile_verarbeitet == true)
        echo "Die Datei wurde erfolgreich eingelesen.";
    else
        echo "<h1>Die Datei konnte nicht gelesen werden.</h1>";
        
    echo "<br>Scriptende<br> ";
    echo "Aus der Datei: ".$filename." wurden ".$count." von ".$zeilennummer." Eintraege uebernommenen.";
    $gesamt_count = $gesamt_count + $count;
    $gesamt_zeilen = $gesamt_zeilen + $zeilennummer;
  }
};
$endtime = time();
echo "<br><br>Es wurden insgesamt ".$gesamt_count." von ".$gesamt_zeilen." Zeilen verarbeitet. Davon waren ".$teamviewer_eintraege." Teamviewer Eintraege.<br> ".$uebersprungen." Eintraege waren schon vorhanden und wurden uebersprungen";
echo "<br> Es gab ".$fehler."(".($gesamt_zeilen-$gesamt_count-$uebersprungen).") Fehlerhafte Zeilen";
echo "<br><br> Die Abfrage dauerte ".($endtime-$starttime)." Sekunden.";
?>