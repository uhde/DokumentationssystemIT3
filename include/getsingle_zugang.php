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

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
require_once('config.inc.php');
include_once("mysql.class.php");
include_once("template.class.php");
include_once("functions.inc.php");
$browser = "C:\\Program Files (x86)\\Mozilla Firefox\\firefox.exe";
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    $sqldata=$objMySQL->QuerySingleRowArray("Select * FROM ".TBL_ZUGAENGE." WHERE id=".$_GET['id']);
    
    foreach($sqldata AS $Key=>$Value)
    {
        $sqldata[$Key]=utf8_encode($Value);
    }
    
    // Zeilenumbrüche in HTML Umbrüche Konvertieren
    $sqldata['zusatz']=nl2br($sqldata['zusatz']);
    
    // Dies hier stellt sicher, dass die links immer mit ftp:, http:// oder https beginnen, 
    // da sie sonst wie interne links behandelt werden.
    if(!empty($sqldata['url']))
    {
        if(substr($sqldata['url'], 0, 4) != 'ftp:')
        {
            if(substr($sqldata['url'], 0, 7) != 'http://')
            {
                if(substr($sqldata['url'], 0, 8) != 'https://')
                {
                    $sqldata['url']='http://'.$sqldata['url'];
                }
            }
        }
    }
    $ax_link2 = 'F:\\Fernwartung\\DokuIT_Log\\DokuIT_Log.exe -ziel=\"{name}\" -prg=\"c:\\progra~1\\intern~1\\iexplore.exe\" -arg=\"google.de\" -kunde=\"5\" ';
    $ax_link = 'F:\\Fernwartung\\DokuIT_Log\\DokuIT_Log.exe -ziel=\"test\" -prg=\"c:\\progra~2\\Mozilla Firefox\\firefox.exe\" -arg=\"http://www.google.de\" -kunde=\"5\"  -partner=\"5\"';
    // Sollte eine URL länger als 50 Zeichen lang sein , wird der sichtbare Bereich aus Layoutgründen
    // auf 47 Zeichen gefolgt von einem ... begrenzt.
    if (strlen($sqldata['url'])>50) {
        $sqldata['url_text']=substr($sqldata['url'],0,47).'...';
        $gekuerzed = true;
    } else {
        $sqldata['url_text']=$sqldata['url'];
        $gekuerzed = false;
    }
    $button = MakeButtons($ax_link);
    echo '
    
        <table class="DeviceInfo">
            <tr>
                <td class="Key">Login: </td>
                <td class="sqldata">'.$sqldata["login"].'</td>
                <td class="Key">Passwort: </td>
                <td colspan="3" class="sqldata">'.$sqldata["passwort"].'</td>
            </tr>
            <tr>
                <td class="Key">Link: </td>
                <td class="Value">
                    <a href="#" onClick=\'activex.run("'.$ax_link.'");\'>
                        <span title="'.$sqldata["url"].'">'.$sqldata["url_text"].'</span>
                    </a>
                </td>

            </tr>
            
            ';
    echo '<tr><td>'
    echo $button.'</tr></td>';
    if($gekuerzed) {
        echo '<tr>
                <td class="Key">Link (kopieren): </td>
                <td class="Value">
                    <input type="text" value="'.$sqldata["url"].'"></input>
                </td>
            </tr>';
    }
            
    echo '
        <tr>
                <td class="Key">Bemerkung: </td>
                <td class="sqldata" colspan="5">'.$sqldata["zusatz"].'</td>
            </tr> 
     
        </table> 
    ';
    
?>

<?php
function MakeButtons($ausgabe){

    $objTemplate=new Template("../layout/geraete_general.lay.php");

    $sqldata['activex']=$ausgabe;

    $objTemplate->AssignArray($sqldata);
    $str=$objTemplate->DisplayToString('Button_Main');
    //$str.=implode('&nbsp;|&nbsp;',$sqldata)."<br />";
    $objTemplate->ClearAssign();
    
    unset($objTemplate);
   // echo $str."<br>";
    //return $str;
    //return $Data;
    return "test";
}
?>
</body>
</html>