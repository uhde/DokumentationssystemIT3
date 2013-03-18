<?php
/*
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

//ob_start("ob_gzhandler");
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");


// DB-Connect
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   echo $objMySQL->Error();
   $objMySQL->Kill();
}
*/
?>

<html>
<head>
<!--
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/frames.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link rel="stylesheet" href="css/topmenu.css" type="text/css" />

<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>
<link rel="stylesheet" href="js/boxy/stylesheets/boxy.css" type="text/css" />
<script type='text/javascript' src='js/boxy/javascripts/jquery.boxy.js'></script>

<script type='text/javascript'>

   
$(document).ready(function() {
        // Erstmal alle ausblende
        // Wird beim reload der Page angewendet
         $("#Buchungen .TRInfo").hide();
         $("#Buchungen .slider").click(function(){
            $(this).toggleClass("up");
            name=$(this).attr("value");

            $("#Buchungen .TRInfo").hide();
                $(name).show();
        });
        $("#Buchungen .slider2").click(function(){
            $(this).toggleClass("up");
            name=$(this).attr("value");
            $("#Buchungen .TRInfo").hide();
                $(name).show();
        });
        $("#Buchungen .TRInfoClose").click(function(){
            $(this).toggleClass("up");
            name=$(this).attr("value");
            $("#Buchungen .TRInfo").hide();
        });

});

</script>
-->
</head>
<body>

<?php 
    //$Daten[1]['kunde']=$_SESSION['knd_id'];

    $objTemplate=new Template("layout/verwaltung.lay.php");
    if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
    {
        $sql="SELECT * FROM ".TBL_PROGRAMME.' WHERE loeschen=0 ORDER BY id';
    } else{
        $sql="SELECT * FROM ".TBL_PROGRAMME.' ORDER BY id';
    }
    //echo $sql."<br>";
    $daten_prog=$objMySQL->QueryArray($sql,MYSQL_ASSOC);
    

    $Count=0;
    if ($daten_prog!==FALSE) {
        $objTemplate->Display('Header');
        foreach($daten_prog as $value)
        {
            foreach($value as $key=>$test)
            {
                //echo $key." -> ".$test."<br>";  
            }
            $objTemplate->AssignArray($value);    
            $objTemplate->Assign('LineClass',$Count%2);
            $objTemplate->Display('Data');
            flush();ob_flush();flush();ob_flush();flush();
            $objTemplate->ClearAssign();
            $Count++;
        }
        $objTemplate->Display('Footer');
        echo '<table><tr><td width="150px"> <b>STATUS</b> DNS-Auflösung</td><td>';
        include('dnsaufloesung.php');
        echo "</td></tr></table>";
        $Value['site']=$_SERVER['PHP_SELF'];
        $objTemplate->AssignArray($Value);
        $objTemplate->Display('Footer2');
$sql="SELECT COUNT(*) AS zaehlen FROM ".TBL_GERAETE.' ';
//echo $sql."<br>";
$daten_stat=$objMySQL->QueryArray($sql);
$sql="SELECT kat.name, COUNT(*) AS zaehlen FROM ".TBL_GERAETE.' AS g, kategorien AS kat WHERE g.kategorie=kat.id GROUP BY kat.name  ORDER BY kat.id';
$daten_stat2=$objMySQL->QueryArray($sql);
        echo "<br> Es werden ";
        echo $daten_stat[0]["zaehlen"]." Geraete verwaltet. <br><br>";
        echo 'Davon sind <table style=width:600px>';
        foreach($daten_stat2 as $value2)
        {
            echo '<tr><td style="width:100px">'.$value2["name"];
            echo "</td><td>".$value2["zaehlen"]."</td></tr>";
        }
        echo "</table>";
            
    }else{
    // Falls keine Daten von MySQL zurückkommen.
        foreach ($Daten AS $Value) {
            $objTemplate->AssignArray($Value);
            $objTemplate->Display('Keine_Daten');
    }
}

?>