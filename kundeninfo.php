<?
include("include/config.inc.php");
include("include/mysql.class.php");
include("include/template.class.php");

$objTemplate=new Template("layout/kundeninfo.lay.php");
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
	$objTemplate->AssignArray($arrData);
    
    
    if (isset($edit) AND $edit==true) {
        $objTemplate->display("kundeninfoedit");
    }else{
        if (isset($save) AND $save==true) {
            $objTemplate->display("kundeninfosave");
        }else{
            $objTemplate->display("kundeninfo");
        }
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


