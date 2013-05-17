<?
$objTemplate=new Template("layout/bilder.lay.php");

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

$Daten[1]['kunde']=$_SESSION['knd_id'];
$Daten[1]['kategorie']=$_SESSION['device_type'];
// Liest die Daten aus.
if(isset($_SESSION['wiederherstellen'])&&(!empty($_SESSION['wiederherstellen'])))
{
    $sql='SELECT * FROM '.TBL_BILDER.' WHERE kunde='.MySQL::SQLValue($_SESSION['knd_id']).' ORDER BY name '.$_SESSION['sort_order'];
} else {
    $sql='SELECT * FROM '.TBL_BILDER.' WHERE loeschen=1 AND kunde='.MySQL::SQLValue($_SESSION['knd_id']).' ORDER BY name '.$_SESSION['sort_order'];
}
$arrData=$objMySQL->QueryArray ($sql);
if ($arrData!==FALSE) {
    $Value["bemerkung"]=nl2br($Value["bemerkung"]);
    $objTemplate->Display('Header');
    foreach ($arrData AS $Value) {
        // Logins auslesen

        // Falls Session mit Kunden-ID nicht da: Setzen
        if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
            $_SESSION['knd_id']=$Value['id'];
            session_commit();
        }
        $big_url=preg_replace('/thumbnail/i','',$Value["url"]);
        $Value['bigurl']=$big_url;
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
    $objTemplate->AssignArray($Value);
    $objTemplate->Display('Footer');
}else{
    // Falls keine Daten von MySQL zurückkommen.
    foreach ($Daten AS $Value) {
        $objTemplate->AssignArray($Value);
        $objTemplate->Display('Keine_Daten');
    }
}
unset($objTemplate);
?>