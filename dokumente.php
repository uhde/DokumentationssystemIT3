<?

$objTemplate=new Template("layout/dokumente.lay.php");
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
// Restliche Variablen
foreach($_GET as $key=>$value) 
{ 
    $mode[$key]=$value;
} 
if(isset($_POST['suchfeld'])&&!empty($_POST['suchfeld'])) {
   $mode['suche']=$_POST['suchfeld'];
}
$Daten[1]['kunde']=$_SESSION['knd_id'];
$Daten[1]['kategorie']=$_SESSION['device_type'];
// Liest die Daten aus.
if(isset($mode['suche'])&&(!empty($mode['suche']))) {
    $sql = "SELECT * FROM ".TBL_DOKUMENTE." WHERE MATCH (`name`,`bemerkung`) AGAINST ('".$mode['suche']."' IN BOOLEAN MODE)";
    //echo $sql."<br>";
} else {
    $sql = "SELECT * FROM ".TBL_DOKUMENTE." WHERE kunde=".MySQL::SQLValue($_SESSION['knd_id']).' ORDER BY name '.$_SESSION['sort_order'];
}
$arrData_dok=$objMySQL->QueryArray ($sql);
if ($arrData_dok!==FALSE) {
    $Value["bemerkung"]=nl2br($Value["bemerkung"]);
    $objTemplate->Display('Header');
    foreach ($arrData_dok AS $Value) {
        // Logins auslesen

        // Falls Session mit Kunden-ID nicht da: Setzen
        if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
            $_SESSION['knd_id']=$Value['id'];
            session_commit();
        }
        $Value['avtivexurl']=mysql_real_escape_string($Value['url']);
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
    foreach ($Daten AS $Value) {
        if(!(isset($mode['suche'])&&(!empty($mode['suche'])))) {
            $objTemplate->AssignArray($Value);
            $objTemplate->Display('Keine_Daten');
        }
    }
}
unset($objTemplate);
?>