<?
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
*/
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");

$objTemplate=new Template("layout/edit_zugaenge.lay.php");
foreach($_GET as $key=>$value) 
{ 
        //echo $key." -> ".$value."<br>"; 
        $mode[$key]=$value;
} 
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   $objMySQL->Kill();
}
if($mode["mode"]=="edit")
{
    $arrData=$objMySQL->QuerySingleRowArray('SELECT * FROM '.TBL_ZUGAENGE.' WHERE kunde='.$mode["kunde"].' AND id='.$mode["id"].'',MYSQL_ASSOC);
} else{
    $arrData=FALSE;
}
if ($arrData!==FALSE) {
    if ($mode["mode"]=="edit") {
        $objTemplate->AssignArray($arrData);
        $objTemplate->display("zugaenge_edit");
        flush();ob_flush();flush();ob_flush();flush();
		// Datencache leeren
		$objTemplate->ClearAssign();
    }
    else{
        //objTemplate->display("nogeraete");
    }
        
}else{
    if ($mode["mode"]=="create") {  
        $objTemplate->AssignArray($mode);
        $objTemplate->display("zugaenge_create");
        flush();ob_flush();flush();ob_flush();flush();
		// Datencache leeren
		$objTemplate->ClearAssign();
    }
    else{
        //$mysqlfail="'SELECT * FROM '.TBL_GERAETE.' WHERE id='.$_GET['id'].' AND kunde='.$_GET['knd_id'],MYSQL_ASSOC";
        $objTemplate->display("nogeraete");
    } 
}
?>