<html><head></head>
<body>
<?php
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    
    $datei = "NeueRechner";
    $basis_url = "http://uhdsrv14.uhde.de/systeminvent/";
    $url = $basis_url.$datei.".txt";
?>
<h1>TESTBETRIEB<h1>
<table>
<?php
    for $rechner in $liste
    {
        echo "<tr><td>".$rechner."</td>";
            echo '<td><a href="import_from_script_text_file.php?rechner='.$rechner.'&kunde='.$_GET['kunde'].'&kategorie='.$_GET['kategorie'].' ">hinzufügen</td>';
            echo '<td><a href="uhdsr.php?rechner='.$rechner.'">TOIDO LINK loeschen</td>';
        echo "</tr>";
    }
?>
</table>
</body>
</html>