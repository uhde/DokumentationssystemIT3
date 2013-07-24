<?
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
include("include/config.inc.php");
include("include/mysql.class.php");
include("include/template.class.php");

$objTemplate=new Template("layout/edit_kunden.lay.php");
if (isset($_GET['edit'])) {
    $edit=true;
}
if (isset($_GET['save'])) {
    $save=true;
}
if (isset($_GET['create'])) {
    $create=true;
}
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   $objMySQL->Kill();
}
$knd_id=$_GET['knd_id'];
$arrData=$objMySQL->QuerySingleRowArray('SELECT * FROM '.TBL_KUNDEN.' WHERE id='.$_GET['knd_id'],MYSQL_ASSOC);

   

if ($arrData!==FALSE) {
    if($arrData["sichtbar"]==1) {
        $arrData['checked1']='checked';
    }
    else {
        $arrData['checked2']='checked';
    }
        print_r($arrData);
        $objTemplate2=new Template("layout/geraete_general.lay.php");
        $sqldata['bemerkung'] = "Route Setzten";
        $sqldata['activex'] = "route add ".$arrData['routepar']."";
        echo "<br>activex: ".$sqldata['activex']." aktivxende<br>";
        $objTemplate2->AssignArray($sqldata);
        $arrData['route_button'] = $objTemplate2->DisplayToString('Button_Main');
        //echo "route_button: ".$arrData['route_button']." route_button_ende";
        $objTemplate2->ClearAssign();
        unset($objTemplate2);
        //echo $arrData['route_button'];
    
    $objTemplate->AssignArray($arrData);
    
    if (isset($edit) AND $edit==true) {
        $objTemplate->display("kundeninfoedit");
    }else{
        $objTemplate->display("kundeninfo");
    }
        
}else{
    if (isset($create) AND $create==true) {
        $objTemplate->display("kundeninfocreate");
    }
    else{
        $objTemplate->display("nokundeninfo");
    }
}

?>


