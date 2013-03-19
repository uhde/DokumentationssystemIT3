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
if(isset($_POST['suchfeld'])&&!empty($_POST['suchfeld'])) {
   $mode['suche']=$_POST['suchfeld'];
}
// Sortierungspfeile....
$objTemplate->Assign($sort_name.'_IMG','<img src="syspics/'.$sort_order.'.gif" style="border:0;margin-left:10px;margin-top:3px;">');
$objTemplate->Assign($sort_name.'_sort_order','aktiv');
$Daten[1]['kunde']=$_SESSION['knd_id'];
$Daten[1]['kategorie']=$_SESSION['device_type'];
$yesterday=time() - (24*60*60); //aktuelle zeit minus 1 tag
// Wenn die Variable suche gesetzt ist (get) dann wird ein anderes SQL-Query erzeugt.
if(isset($mode['suche'])&&(!empty($mode['suche']))) {
    if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
    {
        $sql = "SELECT * FROM ".TBL_GERAETE." WHERE MATCH (`name`,`system`,`produktnummer`,`pc`,`benutzer`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE)";
    }else {
        $sql = "SELECT * FROM ".TBL_GERAETE." WHERE loeschen='1' AND MATCH (`name`,`system`,`produktnummer`,`pc`,`benutzer`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE)";
    }
   // echo $sql."<br>";
} else {
    if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
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
		// Logins auslesen, und in eine eigene Tabelle schreiben. Tabelle wird hierbei noch nicht dargestellt.
		// Logins werden nur in dem Info teil aufgerufen. Dort wird einfach die Variable '$logins' 
        // in die Tabelle geschrieben.
        if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
        {
            $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        }else {
            $Value['logins']=MakeLoginTable(GetGeraeteLogin($objMySQL,$Value['id'],1));
        }
        $Value['buttons']=MakeButtons(GetGeraeteprogramme($objMySQL,$Value['id']),$Value['adresse']);
		// Falls Session mit Kunden-ID nicht da: Setzen
		if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
			$_SESSION['knd_id']=$Value['id'];
			session_commit();
		}
        

		// Keine IP
		if ($Value['adresse']==NULL) {
			$Value['adresse'] = '<span class="keine_ip" title="Keine IP vorhanden!">------</span>';
		}else{
			// IP-String zu IP
			
            //StringtoIP($Value['adresse']);
		}   
        
        // Wenn der DNS Name mit dem ipv4 feld �bereinstimmt, steht in dem DNS Feld die IP-Adresse
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
                            // Solange die DNS-Adresse nicht �lter als ein Tag ist, wird sie Blau eingef�rbt
                            $Value['ip_adresse'] = '<span style="color:blue">'.$Value['adresse'].'</span>';
                        } else {
                            // Ansonsten wird sie orange eingef�rbt
                            $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgel�st werden" style="color:red">'.$Value['adresse'].'</span>';
                        }
                    }
                } else {
                    if($Value['dnstimestamp']>$yesterday) {
                        $Value['ip_adresse']='<span style="color:black">'.$Value['ipv4'].'</span>';
                    } else {
                     $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgel�st werden" style="color:red">'.$Value['ipv4'].'</span>';
                     }
                }
                
            } else {
                if($Value['adresse'] == '<span class="keine_ip" title="Keine IP vorhanden!">------</span>')
                {
                    $Value['ip_adresse'] = $Value['adresse'];
                } else {
                    if($Value['dnstimestamp']>$yesterday)
                    {
                        // Solange die DNS-Adresse nicht �lter als ein Tag ist, wird sie Blau eingef�rbt
                        $Value['ip_adresse'] = '<span style="color:blue">'.$Value['adresse'].'</span>';
                    } else {
                        // Ansonsten wird sie orange eingef�rbt
                        $Value['ip_adresse'] = '<span title="DNS Name konnte seit einem Tag nicht mehr aufgel�st werden" style="color:red">'.$Value['adresse'].'</span>';
                    }
                }
            }
        }
        // Achtung: Es gibt in der alten DB, die nun wieder benutzt wird, das feld IP_adresse nicht
        
        
		// Daten k�rzen
		if (strlen($Value['name'])>30) {
			$Value['name']='<span title="'.$Value['name'].'">'.substr($Value['name'],0,27).'...</span>';
		}

		if (strlen($Value['system'])>30) {
			$Value['system']='<span title="'.$Value['system'].'">'.substr($Value['system'],0,27).'...</span>';
		}
		if (strlen($Value['zimmer'])>30) {
			$Value['zimmer']='<span title="'.$Value['zimmer'].'">'.substr($Value['zimmer'],0,27).'...</span>';
		}

		// Datum + Zeit von der DNS-Abfrage
        if(!empty($Value['dnstimestamp']))
        {
            $Value['dnstimestamp']=date('d.m.Y, H:i',$Value['dnstimestamp']).' Uhr';
        } else {
            $Value['dnstimestamp']="DNS wurde nicht abgerufen.";
        }
		// Garantie pr�fen
		if (!empty($Value['garantie'])) {
			// Abgelaufen
			if ($Value['garantie']<time()) {
				$Value['garantie']='<span style="color:#f00" title="Garantie abgelaufen">'.date('d.m.Y',$Value['garantie']).'</span>';
			}
            else
            {
                // Garantie
                if ($Value['garantie']>time()) {
                    $Value['garantie']='<span style="color:#0f0" title="Garantie vorhanden">'.date('d.m.Y',$Value['garantie']).'</span>';
                }

            }
		}

		// Zeilenumbr�che in HTML Umbr�che Konvertieren
		$Value['bemerkung']=nl2br($Value['bemerkung']);

		// Datensatz dem Template zuweisen
		$objTemplate->AssignArray($Value);
		$objTemplate->Assign('LineClass',$Count%2);

		// Info-Tabelle einf�gen
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
    
    // Falls keine Daten von MySQL zur�ckkommen.
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