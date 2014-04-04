<?

// Sortierung
if(isset($_SESSION['sort_name']))
{
    $old_sort_name=$_SESSION['sort_name'];
}
if (isset($_GET['sort_name'])) {
    $_SESSION['sort_name']=$_GET['sort_name'];
    $sort_name=$_GET['sort_name'];
}else{
    $_SESSION['sort_name']='name';
    $sort_name=$_SESSION['sort_name'];
}



// Wenn der Parameter "sort_order" gesetzt, und nicht leer ist, werden die entsprechenden variablen zugewiesen
if (isset($_GET['sort_order']) AND !empty($_GET['sort_order'])) {
    $sort_order=$_GET['sort_order'];
    $_SESSION['sort_order']=$_GET['sort_order'];
    if($_GET['sort_order']=="asc")
    {
        $objTemplate->Assign('sort_order','desc');
    }
    else {
        $objTemplate->Assign('sort_order','asc');
    }
} else {
    $_SESSION['sort_order']='asc';
    $sort_order='asc';
    $objTemplate->Assign('sort_order','desc');
}


require_once('include/config.inc.php');
// Schreibt alle Get Variablen in das Array mode. 
// z.B.:$mode['kategorie']; ergebnis: server
foreach($_GET as $key=>$value) 
{ 
    $mode[$key]=$value;
}  

// Sortierungspfeile....
$objTemplate->Assign($sort_name.'_IMG','<img src="syspics/'.$sort_order.'.gif" style="border:0;margin-left:10px;margin-top:3px;">');
$objTemplate->Assign($sort_name.'_sort_order','aktiv');
$Daten[1]['kunde']=$_SESSION['knd_id'];
$Daten[1]['kategorie']=$_SESSION['device_type'];
$yesterday=time() - (24*60*60); //aktuelle zeit minus 1 tag
// Wenn die Variable suche gesetzt ist (get) dann wird ein anderes SQL-Query erzeugt.
if(isset($mode['suche'])&&(!empty($mode['suche']))) {
    //Wenn nur lokal gesucht werden soll, steht lokal_suchen auf true. 
    // Dann wird nur innerhalb des spezifischen Kunden gesucht
    $suchbare_felder = "(`name`,`sn`,`system`,`bemerkung`,`produktnummer`,`pc`,`benutzer`,`software`)";
    if( $mode['lokal_suchen']==true)
    {
        // Sollten auch gelöschte Geräte angezeigt werden, wird in allen Geräten gesucht.
        // Ansonsten wird nur in den "nicht gelöschten" gesucht
        if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
        {
            $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kunde=".$_SESSION['knd_id']." AND MATCH ".$suchbare_felder." AGAINST ('".$mode['suche']."' IN BOOLEAN MODE)";
        }else {
            $sql = "SELECT * FROM ".TBL_GERAETE." WHERE kunde=".$_SESSION['knd_id']." AND loeschen='1' AND MATCH ".$suchbare_felder." AGAINST ('".$mode['suche']."' IN BOOLEAN MODE)";
        }
    }else
    {
        if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
        {
            $sql = "SELECT * FROM ".TBL_GERAETE." WHERE MATCH ".$suchbare_felder." AGAINST ('".$mode['suche']."' IN BOOLEAN MODE)";
        }else {
            $sql = "SELECT * FROM ".TBL_GERAETE." WHERE loeschen='1' AND MATCH ".$suchbare_felder." AGAINST ('".$mode['suche']."' IN BOOLEAN MODE)";
        }
    }
    //echo $sql."<br>";
} else {
    if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
    {
        $sql = 'SELECT * FROM '.TBL_GERAETE." WHERE kunde=".MySQL::SQLValue($_SESSION['knd_id']).' AND kategorie='.MySQL::SQLValue($_SESSION['device_type']).'ORDER BY '.$_SESSION['sort_name'].' '.$_SESSION['sort_order'];
    } else {
        $sql = 'SELECT * FROM '.TBL_GERAETE." WHERE loeschen='1' AND kunde=".MySQL::SQLValue($_SESSION['knd_id']).' AND kategorie='.MySQL::SQLValue($_SESSION['device_type']).'ORDER BY '.$_SESSION['sort_name'].' '.$_SESSION['sort_order'];

    }
}
// Liest die Daten aus.
$arrData=$objMySQL->QueryArray ($sql,MYSQL_ASSOC);
$Count=0;

if (is_array($arrData)) {
    $objTemplate->Display('Header');
    foreach ($arrData AS $Value) {
        $Value['ping']=$Value["adresse"];
        if ($Value['adresse']==NULL) {
            $Value['adresse'] = '<span class="keine_ip" title="Keine IP vorhanden!">------</span>';
        }
        //$Value['benutzer'] =  htmlentities($Value['benutzer']);
        // Hier wird die Anzeige der IP Adresse bestimmt.
        // Falls die IP Adresse Fest ist, wird sie grün eingefärbt.
        if (filter_var($Value['adresse'], FILTER_VALIDATE_IP)) {        
            $Value['ip_adresse'] = '<span style="color:green">'.$Value['adresse']." (fest)".'</span>';
        } else {
            
            //Falls die Sessionvariable "ipordns" dns lautet, werden nur dns namen angezeigt
            if(isset($_SESSION['ipordns'])&&$_SESSION['ipordns']=='ip')
            {
                if($Value['ipv4']==NULL || $Value['ipv4']=='0'  ) {
                    
                    // Falls nichts eingetragen ist
                    if($Value['adresse'] == '<span class="keine_ip" title="Keine IP vorhanden!">------</span>')
                    {
                        $Value['ip_adresse'] = $Value['adresse'];
                    } else {
                        if($Value['dnstimestamp']>$yesterday)
                        {
                            // Solange die DNS-Adresse nicht älter als ein Tag ist, wird sie Blau eingefärbt
                            $Value['ip_adresse'] = '<span style="color:blue">'.$Value['adresse'].'</span>';
                        } else {
                            // Ansonsten wird sie orange eingefärbt
                            $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgelöst werden" style="color:red">'.$Value['adresse'].'</span>';
                        }
                    }
                } else {
                    if($Value['dnstimestamp']>$yesterday) {
                        $Value['ip_adresse']='<span style="color:black">'.$Value['ipv4'].'</span>';
                    } else {
                     $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgelöst werden" style="color:red">'.$Value['ipv4'].'</span>';
                     }
                }
                
            } else {
                if($Value['adresse'] == '<span class="keine_ip" title="Keine IP vorhanden!">------</span>')
                {
                    $Value['ip_adresse'] = $Value['adresse'];
                } else {
                    if($Value['dnstimestamp']>$yesterday)
                    {
                        // Solange die DNS-Adresse nicht älter als ein Tag ist, wird sie Blau eingefärbt
                        $Value['ip_adresse'] = '<span style="color:blue">'.$Value['adresse'].'</span>';
                    } else {
                        // Ansonsten wird sie orange eingefärbt
                        $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgelöst werden" style="color:red">'.$Value['adresse'].'</span>';
                    }
                }
            }
        }
 
        if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
            $_SESSION['knd_id']=$Value['id'];
            session_commit();
        }
        // Time wird vor allem als Placebo- Parameter benötigt, um das caching zu umgehen
        $Value["time"]=time();
        
        // In dieser Variable "img_loeschen" wird der Bildpfadt zum entsprechenden Bild vermerkt.
        // Standard ist der Drop Button, aber wenn das geraet bereits im mülleimer liegt, 
        // wird das andere bild verwendet
        if(isset($Value['loeschen'])&&$Value['loeschen']=='0')
        {
            $Value['loeschen_img']="syspics/recycle-bin.png";
        }else {
            $Value['loeschen_img']="syspics/button_drop.png";
        }
        // Hier wird der löschen modus gesetzt. Wenn das gerät bereits im mülleimer ist, 
        // wird der modus auf renew (erneuern) gesetzt
        // Mit diesem modus kann ein gerät dann wieder hergestellt werden.
        if(isset($Value['loeschen'])&&$Value['loeschen']=='0')
        {
            $Value['loeschen_mode']="renew";
        }else {
            $Value['loeschen_mode']="delete";
        }
        // Datensatz dem Template zuweisen
        $objTemplate->AssignArray($Value);
        if(isset($Value['loeschen'])&&$Value['loeschen']=='0')
        {
            $objTemplate->Assign('LineClass','9');
        }else{
            $objTemplate->Assign('LineClass',$Count%2);
        }

        // Info-Tabelle einfügen
        $objTemplate->Assign('InfoTable',$objTemplate->DisplayToString('Info'));

        // Template anzeigen
        $objTemplate->Display('Data');
        flush();ob_flush();flush();ob_flush();flush();
        // Datencache leeren
        $objTemplate->ClearAssign();
        $Count++; 
    }
    foreach ($Daten AS $Value) {
        $Value['site']=$_SERVER['PHP_SELF'];
        $objTemplate->AssignArray($Value);
        $objTemplate->Display('Footer');
        if(!(isset($mode['suche'])&&(!empty($mode['suche'])))) {
            $objTemplate->Display('Footer2');
        }
    }
}else{
    
    // Falls keine Daten von MySQL zurückkommen.
    foreach ($Daten AS $Value) {
        if(!(isset($mode['suche'])&&(!empty($mode['suche'])))) {
            $sqldata=$objMySQL->QuerySingleRowArray('SELECT name FROM kategorien WHERE id='.$Value['kategorie'].'',MYSQL_ASSOC);
            $Value['show_kat']=$sqldata['name'];
            $objTemplate->AssignArray($Value);
            $objTemplate->Display('Keine_Daten');
        }
    }
}
unset($objTemplate);



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