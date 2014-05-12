<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

    
    $datei = "NeueRechner";
    $basis_url = "http://uhdsrv14.uhde.de/systeminvent/";
    $url = $basis_url.$datei.".txt";
    $liste =  file($url, FILE_IGNORE_NEW_LINES );
    echo $liste;
?>
<html><head></head>
<body>
<h1>TESTBETRIEB<h1>
<table>
<?php

    foreach($liste as $rechner)
    {
        echo "<tr><td>".$rechner."</td>";
            echo '<td><a href="import_from_script_text_file.php?rechner='.$rechner.'&kunde='.$_GET['kunde'].'&kategorie='.$_GET['kategorie'].' ">hinzufügen</td>';
            echo '<td><a href="uhdsr.php?rechner='.$rechner.'">TODO LINK loeschen</td>';
        echo "</tr>";
    }
?>
</table>
</body>
</html>