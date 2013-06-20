<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../css/styles.css" type="text/css" />
<link rel="stylesheet" href="../css/reset.css" type="text/css" />
</head>
<body>
<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);*/
require_once('config.inc.php');
include_once("mysql.class.php");
include_once("template.class.php");
include_once("functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    $sqldata=$objMySQL->QuerySingleRowArray("Select * FROM ".TBL_PROGRAMME." WHERE id=".$_GET['id']);
    
    foreach($sqldata AS $Key=>$Value)
    {
        $sqldata[$Key]=utf8_encode($Value);
    }
    
    // Zeilenumbrüche in HTML Umbrüche Konvertieren
    $sqldata['bemerkung']=nl2br($sqldata['bemerkung']);
    

    
    echo '
    
        <table class="DeviceInfo">
            <tr>
                <td class="Key">Interner Name: </td>
                <td class="sqldata">'.$sqldata["name"].'</td>
            </tr>
            <tr>
                <td class="Key">Link: </td>
                <td class="Value">
                    <a href="'.$sqldata["url"].'" target="_blank">
                        <span title="'.$sqldata["url"].'">'.$sqldata["url"].'</span>
                    </a>
                </td>

            <tr>
                <td class="Key">Bemerkung: </td>
                <td class="sqldata" colspan="5">'.$sqldata["bemerkung"].'</td>
            </tr> 
     
        </table> 
    ';
?>
</body>
</html>