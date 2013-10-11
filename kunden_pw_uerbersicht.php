<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=9">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link rel="stylesheet" href="css/reset.css" type="text/css" />
    </head>
<body>


<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
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
    $computer=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=3 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $drucker=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kategorie=4 AND kunde=".$kunden_id." AND loeschen=1 ORDER BY  name";
    $netzwerk=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    
    $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE kunde=".$kunden_id." AND loeschen=1 ORDER BY titel";
    $zugaenge=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
    
//$objTemplate->Display('Header');
    echo '<table>
            <colgroup width="150" span="3"></colgroup>
            <caption style="font-size:16px;font-weight:700;">SERVER</caption>
            <tr><th>Name</th><th>Passwörter</th></tr>
            ';
    
    foreach ($server AS $Value) {
        foreach($Value AS $Key=>$Value2)
        {
            $Value[$Key]=utf8_encode($Value2);
        }
        $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        if($Value['logins']!=false) {
            echo '<tr>
                    <td style="font-size:12px;font-weight:600;">
                        '.$Value['name']."
                    </td>
                    <td>
                        ".$Value['logins']."
                    </td>
                </tr>";
        }
    }
    echo "</table>";
    echo "<br><br><br><br>";
    echo "<h1>-------------------------</h1>
    <br><br>";
    
    echo '<table>
            <colgroup width="150" span="3"></colgroup>
            <caption style="font-size:16px;font-weight:700;">Computer</caption>
            <tr><th>Name</th><th>Passwörter</th></tr>
            ';
    
    foreach ($computer AS $Value) {
        foreach($Value AS $Key=>$Value2)
        {
            $Value[$Key]=utf8_encode($Value2);
        }
        $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        if($Value['logins']!=false) {
            echo '<tr>
                    <td style="font-size:12px;font-weight:600;">
                        '.$Value['name']."
                    </td>
                    <td>
                        ".$Value['logins']."
                    </td>
                </tr>";
        }
    }
    echo "</table>";
    echo "<br><br><br><br>";
    echo "<h1>-------------------------</h1>
    <br><br>";
    
    echo '<table>
            <colgroup width="150" span="3"></colgroup>
            <caption style="font-size:16px;font-weight:700;">Drucker</caption>
            <tr><th>Name</th><th>Passwörter</th></tr>
            ';
    
    foreach ($drucker AS $Value) {
        foreach($Value AS $Key=>$Value2)
        {
            $Value[$Key]=utf8_encode($Value2);
        }
        $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        if($Value['logins']!=false) {
            echo '<tr>
                    <td style="font-size:12px;font-weight:600;">
                        '.$Value['name']."
                    </td>
                    <td>
                        ".$Value['logins']."
                    </td>
                </tr>";
        }
    }
    echo "</table>";
    echo "<br><br><br><br>";
    echo "<h1>-------------------------</h1>
    <br><br>";
    
    echo '<table>
            <colgroup width="150" span="3"></colgroup>
            <caption style="font-size:16px;font-weight:700;">Netzwerkgeräte</caption>
            <tr><th>Name</th><th>Passwörter</th></tr>
            ';
    
    foreach ($netzwerk AS $Value) {
        foreach($Value AS $Key=>$Value2)
        {
            $Value[$Key]=utf8_encode($Value2);
        }
        $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        if($Value['logins']!=false) {
            echo '<tr>
                    <td style="font-size:12px;font-weight:600;">
                        '.$Value['name']."
                    </td>
                    <td>
                        ".$Value['logins']."
                    </td>
                </tr>";
        }
    }
    echo "</table>";
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
function MakeLoginTable($Data){
    if (is_array($Data)) {
        $daten_enthalten = false;
        $objTemplate=new Template("layout/geraete_general.lay.php");
        $str=$objTemplate->DisplayToString('Login_Header');
        foreach ($Data as $sqldata){
            // kodiert die Einträge in utf-8, da der dokumentenstandard ja ebenfalls hier utf-8 ist
            $sqldata['geraete_login'] = utf8_encode($sqldata['geraete_login']);
            $sqldata['geraete_pw'] = utf8_encode($sqldata['geraete_pw']);
            $sqldata['bemerkung'] = utf8_encode($sqldata['bemerkung']);
            
            if($sqldata['geraete_login']=="" AND $sqldata['geraete_pw']=="")
            {
            }
            else
            {
                // Da der TeamViewer-Lan sich immer auf die IP-Adresse verbindet, wird hier im Feld "geraete_login" die Ip-Adresse eingetragen.
                if($sqldata['programm_id']==16) {
                    if((isset($sqldata['geraete_ipv4'])&&$sqldata['geraete_ipv4']!=0)) {
                        $sqldata['geraete_login']=$sqldata['geraete_ipv4'];
                    } else { 
                        $sqldata['geraete_login']=$sqldata['geraete_adresse'];
                    }
                }
                $objTemplate->AssignArray($sqldata);
                $str.=$objTemplate->DisplayToString('Login_Main');
                $daten_enthalten = true;
                //$str.=implode('&nbsp;|&nbsp;',$sqldata)."<br />";
                $objTemplate->ClearAssign();
            }
        }
        $str.=$objTemplate->DisplayToString('Login_Footer');
        unset($objTemplate);
        if($daten_enthalten == false) {
            return false;
        }else {
            return $str;
        }
        //return $Data;
    }
    return FALSE;
}
?>
</body>
</html>