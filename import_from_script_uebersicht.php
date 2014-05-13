<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    
    $datei = "NeueRechner";
    $basis_url = "http://uhdsrv14.uhde.de/systeminvent/";
    $url = $basis_url.$datei.".txt";
    $liste =  file($url, FILE_IGNORE_NEW_LINES );
    //echo $liste;
?>
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=9">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link rel="stylesheet" href="css/reset.css" type="text/css" />
    </head>
<body>
    <h1>TESTBETRIEB<h1>
    <table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
        <?php
            foreach($liste as $rechner)
            {
                echo '<tr class="Data0"><td>'.$rechner."</td>";
                    echo '<td><a href="import_from_script_text_file.php?rechner='.$rechner.'&kunde='.$_GET['kunde'].'&kategorie='.$_GET['kategorie'].' ">hinzufügen</td>';
                    //echo '<td><a href="'.$basis_url.'loeschen.php?rechner='.$rechner.'">TODO LINK loeschen</td>';
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>