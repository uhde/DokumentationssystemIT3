<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);*/
require_once('include/config.inc.php');
include_once("include/mysql.class.php");
include_once("include/template.class.php");
include_once("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    $sqldata=$objMySQL->QuerySingleRowArray("Select * FROM ".TBL_GERAETE." WHERE id=".$_GET['id']);
    if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
    {
        $sqldata['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$sqldata['id'],0));
    }else {
        $sqldata['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$sqldata['id'],1));
    }
    $sqldata['buttons']=MakeButtons(GetGeraeteprogramme($objMySQL,$sqldata['id']),$sqldata['adresse']);
    
    echo '
    
        <table class="DeviceInfo">
            <tr>
                <td class="Key" >DNS-Name: </td>
                <td class="Value">'.$sqldata["adresse"].'</td>
                <td class="Key" >DNS-Stand: </td>
                <td colspan="3" class="Value">'.$sqldata["dnstimestamp"].'</td>
            </tr>
            <tr>
                <td class="Key" >Ger?te-Typ:</td>
                <td class="Value" >'.$sqldata["pc"].'</td>
                <td class="Key" >System-Beschreibung:</td>
                <td class="Value">'.$sqldata["system"].'</td>     
                <td style="width:90px;"></td>
                <td class="Value" style="width:20px;"></td>    
            </tr>
            <tr>
                <td class="Key" >Betriebssystem: </td>
                <td class="Value">'.$sqldata["bs"].'</td>
                <td class="Key">Drucker: </td>
                <td  style="width:50;">'.$sqldata["drucker"].'</td> 
            </tr>
            <tr>
                <td class="Key" >Standort: </td>
                <td class="Value">'.$sqldata["zimmer"].'</td>
                <td class="Key" >Produktnummer: </td>
                <td class="Value" >'.$sqldata["produktnummer"].'</td>
            </tr>
            <tr>
                <td class="Key" >SN:</td>
                <td class="Value" >'.$sqldata["sn"].'</td>
                <td class="Key" >Garantie bis:</td>
                <td class="Value" >'.$sqldata["garantie"].'</td>   
            </tr>
            <tr>
                <td class="Key" style="vertical-align:top;">Logins: </td>
                <td class="Value" colspan="5">'.$sqldata["logins"].'</td>
            </tr>
            <tr>
                <td class="Key">Bemerkung: </td>
                <td class="Value" colspan="5">'.$sqldata["bemerkung"].'</td>
            </tr>
            <tr>
                <td class="Key" style="vertical-align:top;">Aktionen: </td>
                <td class="Value" colspan="5">'.$sqldata["buttons"].'</td>
            </tr> 
            
        </table> 
        ';
        
        
        
        
        
        
function MakeLoginTable($Data){
	if (is_array($Data)) {
		$objTemplate=new Template("layout/server.lay.php");
		$str=$objTemplate->DisplayToString('Login_Header');
		foreach ($Data as $Value){
            if($Value['geraete_login']=="" AND $Value['geraete_pw']=="")
            {
            }
            else
            {
                // Da der TeamViewer-Lan sich immer auf die IP-Adresse verbindet, wird hier im Feld "geraete_login" die Ip-Adresse eingetragen.
                if($Value['programm_id']==16) {
                    if((isset($Value['geraete_ipv4'])&&$Value['geraete_ipv4']!=0)) {
                        $Value['geraete_login']=$Value['geraete_ipv4'];
                    } else { 
                        $Value['geraete_login']=$Value['geraete_adresse'];
                    }
                }
                $objTemplate->AssignArray($Value);
                $str.=$objTemplate->DisplayToString('Login_Main');
                //$str.=implode('&nbsp;|&nbsp;',$Value)."<br />";
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
		$objTemplate=new Template("layout/geraete_general.lay.php");
        $str="";
		foreach ($Data as $Value){
            if($Value['aktiv']=='0')
            {
            
            }
            else
            {
                // Syntax:  $ausgabe=preg_replace($suchmuster,$ersetzung,$zeichenkette);
                $ausgabe=$Value["url"];
        
                $ausgabe=str_replace('{geraete_login}',$Value['geraete_login'],$ausgabe);
                $ausgabe=str_replace('{geraete_pw}',$Value['geraete_pw'],$ausgabe);
                $ausgabe=str_replace('{adresse}',$Value['geraete_adresse'],$ausgabe);
                $ausgabe=str_replace('{name}',$Value['geraete_name'],$ausgabe);
                $ausgabe=str_replace('{benutzer}',$Value['benutzer'],$ausgabe);
                $ausgabe=str_replace('{kunde}',$Value['kunden_name'],$ausgabe);
                $ausgabe=str_replace('{benutzer}',$_SERVER['PHP_AUTH_USER'],$ausgabe);
                $ausgabe=str_replace('{ftpdir}',$Value['ftpdir'],$ausgabe);
                
                
                
                /*$benutzer="%ProgramFiles%/TeamViewer/Version5/Teamviewer.exe";
                $adresse="192.168.200.4";
                $geraete_login=$Value['geraete_login'];
                $geraete_pw=$Value['geraete_pw'];
                $ausgabe="";*/
                
                $Value['activex']=$ausgabe;

                $objTemplate->AssignArray($Value);
                $str.=$objTemplate->DisplayToString('Button_Main');
                //$str.=implode('&nbsp;|&nbsp;',$Value)."<br />";
                $objTemplate->ClearAssign();
            }
		}
        $Value['bemerkung']="Ping";
        $ausgabe="ping.exe -n 9 ".$adresse;
        $Value['activex']=$ausgabe;
        $objTemplate->AssignArray($Value);
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