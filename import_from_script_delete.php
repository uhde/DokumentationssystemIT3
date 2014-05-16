<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Loescht die Inventarisierungsdatei 
// Muss im sysinvent Verzeichnis des Inventarisierungssystems abgelegt werden.
    
    $rechner = $_GET['rechner'];
    // Rechner loeschen
    $loeschen_link = "./Scans/".$rechner.".txt";
    $loeschen_link = realpath($loeschen_link);
    unlink($loeschen_link);
    // Rechner verschieben
    /*
    $rechner_link = "./Scans/".$rechner.".txt";
    $rechner_link = realpath($rechner_link);
    $ziel_rechner_link = "./Scans/backup/".$rechner.".txt";
    $ziel_rechner_link = realpath($ziel_rechner_link);
    rename($rechner_link,$ziel_rechner_link);
    */
        
   
    $neue_liste = "";
    $url = "NeueRechner.txt";
    $pc_liste = file($url, FILE_IGNORE_NEW_LINES );
    foreach($pc_liste as $zeile)
    {
        if(trim($zeile) != trim($rechner))
        {
            $neue_liste = $neue_liste.$zeile."\n";
        }
        else {
            //echo "verweigert: ".$zeile."<br>";
            }
    }
    //echo $neue_liste;
    //echo $url;
    file_put_contents($url,$neue_liste);
    echo "Das System wurde aus der Liste entfernt";
    // q5mspyyc
?>
