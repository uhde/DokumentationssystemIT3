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
    $sqldata=$objMySQL->QuerySingleRowArray("Select * FROM ".TBL_GERAETE." WHERE id=".$_GET['id']);
    
    foreach($sqldata AS $Key=>$Value)
    {
        $sqldata[$Key]=utf8_encode($Value);
    }
    
    // Logins auslesen, und in eine eigene Tabelle schreiben. Tabelle wird hierbei noch nicht dargestellt.
    // Logins werden nur in dem Info teil aufgerufen. Dort wird einfach die Variable '$logins' 
    // in die Tabelle geschrieben.
    if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
    {
        $sqldata['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$sqldata['id'],0));
    }else {
        $sqldata['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$sqldata['id'],1));
    }
    $sqldata['buttons']=MakeButtons(GetGeraeteprogramme($objMySQL,$sqldata['id']),$sqldata['adresse']);
    
    // #### Hier kommen Bearbeitungen die die Optische Anzeige betreffen... z.b. wird die IP Adresse farblich anders dargestellt
    if ($sqldata['adresse']==NULL) {
        $sqldata['adresse'] = '<span class="keine_ip" title="Keine IP vorhanden!">------</span>';
    }
    
    
    // Hier werden die angezeigten Feldinhalte gekürzt, sollten sie besonders lang sein.
    // Dies wird benutzt, damit besonders lange Inhalte nicht das Layout sprengen
    if (strlen($sqldata['name'])>30) {
        $sqldata['name']='<span title="'.$sqldata['name'].'">'.substr($sqldata['name'],0,27).'...</span>';
    }

    if (strlen($sqldata['system'])>30) {
        $sqldata['system']='<span title="'.$sqldata['system'].'">'.substr($sqldata['system'],0,27).'...</span>';
    }
    if (strlen($sqldata['zimmer'])>30) {
        $sqldata['zimmer']='<span title="'.$sqldata['zimmer'].'">'.substr($sqldata['zimmer'],0,27).'...</span>';
    }
    
    // Hier wird das Datum (+Zeit) der letzten erfolgreichen DNS Abfrage(bezüglich diesen PCs) lesbar gemacht.
    // Falls kein Datum vorhanden ist, wird nichts eingetragen
    if(!empty($sqldata['dnstimestamp']))
    {
        $sqldata['dnstimestamp']=date('d.m.Y, H:i',$sqldata['dnstimestamp']).' Uhr';
    } else {
        $sqldata['dnstimestamp']="DNS wurde nicht abgerufen.";
    }
    // Garantie prüfen
    if (!empty($sqldata['garantie'])) {
        // Abgelaufen
        if ($sqldata['garantie']<time()) {
            $sqldata['garantie']='<span style="color:#f00" title="Garantie abgelaufen">'.date('d.m.Y',$sqldata['garantie']).'</span>';
        }
        else
        {
            // Garantie
            if ($sqldata['garantie']>time()) {
                $sqldata['garantie']='<span style="color:#0f0" title="Garantie vorhanden">'.date('d.m.Y',$sqldata['garantie']).'</span>';
            }

        }
    }    
    
    // Zeilenumbrüche in HTML Umbrüche Konvertieren
    
    $sqldata['bemerkung']=link_klickbar_machen($sqldata['bemerkung']);
    
    $sqldata['bemerkung']=nl2br($sqldata['bemerkung']);
    
    echo '
    
        <table class="DeviceInfo">
            <tr>
                <td class="Key" >DNS-Name: </td>
                <td class="sqldata">'.$sqldata["adresse"].'</td>
                <td class="Key" >DNS-Stand: </td>
                <td colspan="3" class="sqldata">'.$sqldata["dnstimestamp"].'</td>
            </tr>
            <tr>
                <td class="Key" >MAC-Adresse: </td>
                <td class="Value">'.$sqldata["mac_adresse"].'</td>
            <tr>
                <td class="Key" >Geräte-Typ:</td>
                <td class="sqldata" >'.$sqldata["pc"].'</td>
                <td class="Key" >System-Beschreibung:</td>
                <td class="sqldata">'.$sqldata["system"].'</td>     
                <td style="width:90px;"></td>
                <td class="sqldata" style="width:20px;"></td>    
            </tr>
            <tr>
                <td class="Key" >Betriebssystem: </td>
                <td class="sqldata">'.$sqldata["bs"].'</td>
                <td class="Key">Drucker: </td>
                <td  style="width:50;">'.$sqldata["drucker"].'</td> 
            </tr>
            <tr>
                <td class="Key" >Standort: </td>
                <td class="sqldata">'.$sqldata["zimmer"].'</td>
                <td class="Key" >Produktnummer: </td>
                <td class="sqldata" >'.$sqldata["produktnummer"].'</td>
            </tr>
            <tr>
                <td class="Key" >SN:</td>
                <td class="sqldata" >'.$sqldata["sn"].'</td>
                <td class="Key" >Garantie bis:</td>
                <td class="sqldata" >'.$sqldata["garantie"].'</td>   
            </tr>
            <tr>
                <td class="Key" style="vertical-align:top;">Logins: </td>
                <td class="sqldata" colspan="5">'.$sqldata["logins"].'</td>
            </tr>
            <tr>
                <td class="Key">Bemerkung: </td>
                <td class="sqldata" colspan="5">'.$sqldata["bemerkung"].'</td>
            </tr>
            <tr>
                <td class="Key" style="vertical-align:top;">Aktionen: </td>
                <td class="sqldata" colspan="5">'.$sqldata["buttons"].'</td>
            </tr> 
            
            
        </table> 
        ';
        
        
  
        
        
function MakeLoginTable($Data){
    if (is_array($Data)) {
        $objTemplate=new Template("../layout/geraete_general.lay.php");
        $str=$objTemplate->DisplayToString('Login_Header');
        foreach ($Data as $sqldata){
            // kodiert die Einträge in utf-8, da der dokumentenstandard ja ebenfalls hier utf-8 ist
            $sqldata['geraete_login'] = utf8_encode($sqldata['geraete_login']);
            $sqldata['geraete_pw'] = utf8_encode($sqldata['geraete_pw']);
            
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
                //$str.=implode('&nbsp;|&nbsp;',$sqldata)."<br />";
                $objTemplate->ClearAssign();
            }
        }
        $str.=$objTemplate->DisplayToString('Login_Footer');
        unset($objTemplate);
        return $str;
        //return $Data;
    }
    return FALSE;
}

function MakeButtons($Data, $adresse){
    if (is_array($Data)) {
        $objTemplate=new Template("../layout/geraete_general.lay.php");
        $str="";
        foreach ($Data as $sqldata){
            if($sqldata['aktiv']=='0')
            {
            
            }
            else
            {
                // Syntax:  $ausgabe=preg_replace($suchmuster,$ersetzung,$zeichenkette);
                $ausgabe=$sqldata["url"];
        
                $ausgabe=str_replace('{geraete_login}',$sqldata['geraete_login'],$ausgabe);
                $ausgabe=str_replace('{geraete_pw}',$sqldata['geraete_pw'],$ausgabe);
                $ausgabe=str_replace('{adresse}',$sqldata['geraete_adresse'],$ausgabe);
                $ausgabe=str_replace('{name}',$sqldata['geraete_name'],$ausgabe);
                $ausgabe=str_replace('{benutzer}',$sqldata['benutzer'],$ausgabe);
                $ausgabe=str_replace('{kunde}',$sqldata['kunden_name'],$ausgabe);
                $ausgabe=str_replace('{benutzer}',$_SERVER['PHP_AUTH_USER'],$ausgabe);
                $ausgabe=str_replace('{ftpdir}',$sqldata['ftpdir'],$ausgabe);
                $ausgabe=str_replace('{dyndns_domain}',$sqldata['dyndns_domain'],$ausgabe);
                $ausgabe=str_replace('{irdpport}',$sqldata['irdpport'],$ausgabe);
                
                
                /*$benutzer="%ProgramFiles%/TeamViewer/Version5/Teamviewer.exe";
                $adresse="192.168.200.4";
                $geraete_login=$sqldata['geraete_login'];
                $geraete_pw=$sqldata['geraete_pw'];
                $ausgabe="";*/
                
                $sqldata['activex']=$ausgabe;

                $objTemplate->AssignArray($sqldata);
                $str.=$objTemplate->DisplayToString('Button_Main');
                //$str.=implode('&nbsp;|&nbsp;',$sqldata)."<br />";
                $objTemplate->ClearAssign();
            }
        }
        $sqldata['bemerkung']="Ping";
        $ausgabe="ping.exe -n 9 ".$adresse;
        $sqldata['activex']=$ausgabe;
        $objTemplate->AssignArray($sqldata);
        $str.=$objTemplate->DisplayToString('Button_ping');
        $objTemplate->ClearAssign();
        
        unset($objTemplate);
       // echo $str."<br>";
        return $str;
        //return $Data;
    }
    return FALSE;
    
}
?>
</body>
</html>