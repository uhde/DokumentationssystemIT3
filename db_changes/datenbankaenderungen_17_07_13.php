<html><head></head>
<body>
working....

<?php 
// Dieses Script liest alle Gerätebeschreibungen aus, und 
// konvertiert die Zeilenumbrüche in html umbrüche
// Fügt außerdem ein Feld für eine Softwareliste ein.
// Löscht nicht mehr benötigte Spalten in "geraete"
   // error_reporting(E_ALL);
   // ini_set('display_errors', TRUE);

require('../include/config.inc.php');
include("../include/mysql.class.php");
include("../include/template.class.php");
include("../include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    $sql = "SELECT id, bemerkung FROM geraete ";
    
    $arrData=$objMySQL->QueryArray($sql,MYSQL_ASSOC);
    $sql ="";
    $i = 0;
    foreach($arrData as $Value) {
        //$Value['bemerkung'] = nl2br($Value['bemerkung']);
        $Value['bemerkung'] = str_replace(array("\r\n", "\r", "\n"), "<br />", $Value['bemerkung']); 
        $sql = "UPDATE `".DB_DATABASE."`.`geraete` SET ";
        $sql = $sql." bemerkung = '".mysql_real_escape_string($Value['bemerkung'])."' WHERE id=".$Value['id']."";
        echo $sql."<br>";
        $objMySQL->Query($sql);
        $i++;
        echo '.';
        if($i%100==0){
            echo "<br>";
        }
    }
    echo "<br>Schleife fertig durchlaufen<br>";
    $sql = "ALTER TABLE `geraete`  ADD `software` TEXT NOT NULL AFTER `bemerkung`";
    $objMySQL->Query($sql);
    
    // Löscht die alten und nicht mehr benötigten Spalten in geräte
    $sql = "ALTER TABLE `geraete` DROP `programme`, DROP `vncpasswort`, DROP `login`, DROP `passwort`, DROP `ftplogin`, DROP `ftppasswort`, DROP `tv_id`, DROP `tv_pwd`, DROP `xurl`;";
    $objMySQL->Query($sql);
    
    echo "Es wurde ".$i." Eintraege abgearbeitet.<br><br>";
    echo "Scriptende";
?>
</body>
</html>