<html><head></head>
<body>


<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Diese Seite gibt alle Passwörter eines Kunden aus (Zugaenge und Geräte)
$kunden_id=3; //Es geht nur um einen speziellen Kunden. 


require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    // Liest alle Geraete aus
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=1 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $server=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=2 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $pcs=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=3 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $drucker=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=4 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $netzwerk=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    
    $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE kunde=".$kunden_id." AND loeschen=1 ORDER BY titel";
    $zugaenge=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    
//$objTemplate->Display('Header');
    echo "<table>
            <caption>SERVER</caption>
            <tr><th>Name</th><th>Passwöter</th>
            ";
    foreach ($server AS $Value) {
        $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        echo "<tr>
                <td>
                    ".$Value['name']."
                </td>
                <td>
                    ".$Value['logins']."
                </td>
            </tr>";
    }
    echo "</table>";

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    echo "Scriptende";
?>
</body>
</html>