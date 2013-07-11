<?
$objTemplate=new Template("layout/zugaenge.lay.php");
// Sortierreihenfolge
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

$browser = "C:\Program Files (x86)\Mozilla Firefox\firefox.exe";

$Daten[1]['kunde']=$_SESSION['knd_id'];
$Daten[1]['kategorie']=$_SESSION['device_type'];
// Liest die Daten aus.
if(isset($mode['suche'])&&(!empty($mode['suche']))) {
    if( $mode['lokal_suchen']==true)
    {
        if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
        {
            $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE loeschen=1 AND  MATCH (`titel`,`zusatz`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE ) ORDER BY titel ";
        }else{
            $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE MATCH (`titel`,`zusatz`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE ) ORDER BY titel ";
        }
    }else
    {
            if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
        {
            $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE MATCH (`titel`,`zusatz`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE ) ORDER BY titel ";
        }else{
            $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE MATCH (`titel`,`zusatz`) AGAINST ('".$mode['suche']."*' IN BOOLEAN MODE ) ORDER BY titel ";
        }
    }
    echo $sql."<br>";
} else {
    if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
    {
        $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE kunde=".MySQL::SQLValue($_SESSION['knd_id'])." ORDER BY titel ".$_SESSION['sort_order'];
   }else{
        $sql = "SELECT * FROM ".TBL_ZUGAENGE." WHERE kunde=".MySQL::SQLValue($_SESSION['knd_id'])." ORDER BY titel ".$_SESSION['sort_order'];
   }
   // echo $sql;
}
$arrData_zugaenge=$objMySQL->QueryArray ($sql);
if ($arrData_zugaenge!==FALSE) {
    $objTemplate->Display('Header');
    foreach ($arrData_zugaenge AS $Value) {
        // Logins auslesen
        $Value["zusatz"]=nl2br($Value["zusatz"]);
        // Falls Session mit Kunden-ID nicht da: Setzen
        if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
            $_SESSION['knd_id']=$Value['id'];
            session_commit();
        }
        // Dies hier stellt sicher, dass die links immer mit http:// oder https beginnen, da sie sonst wie interne links behandelt werden.
        if(!empty($Value['url']))
        {
            if(substr($Value['url'], 0, 4) != 'ftp:')
            {
                if(substr($Value['url'], 0, 7) != 'http://')
                {
                    if(substr($Value['url'], 0, 8) != 'https://')
                    {
                        $Value['url']='http://'.$Value['url'];
                    }
                }
            }
        }
        
        // Hier wird festgelegt, aus welchem Browser der Link gestartet werden soll.
        $Value['ax_link']='activex.run("'.$browser.' '.$Value['url'].'");';
        // Setzt die Time Variable, um ein caching in der ***HTA-Anwendung zu verhindern
        $Value['time']=time();
        if (strlen($Value['url'])>50) {
            $Value['url_text']=substr($Value['url'],0,47).'...';
        } else {
            $Value['url_text']=$Value['url'];
        }
        if(isset($mode['suche'])&&(!empty($mode['suche'])))
        {
            $Value['suche_kunde']='<td class="slider2" value="#trinfo{$id}">'.GetKundenName($objMySQL,$Value["kunde"]).'</td>';
           // $Value['suche_titel']='<th style="width=10%">Kunde</th>';            
        }
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
        // Template anzeigen
        $objTemplate->Display('Data');
        flush();ob_flush();flush();ob_flush();flush();
        // Datencache leeren
        $objTemplate->ClearAssign();
        $Count++;
    }
     if(!(isset($mode['suche'])&&(!empty($mode['suche'])))) {
        $objTemplate->AssignArray($Value);
        $objTemplate->Display('Footer');
    } else {
        $objTemplate->AssignArray($Value);
        $objTemplate->Display('Footer2');
        }
}else{
    // Falls keine Daten von MySQL zurückkommen.
    if(!(isset($mode['suche'])&&(!empty($mode['suche'])))) {
        foreach ($Daten AS $Value) {
            $objTemplate->AssignArray($Value);
            $objTemplate->Display('Keine_Daten');
        }
    }
}
unset($objTemplate);
?>