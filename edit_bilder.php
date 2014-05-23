<?
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");

$objTemplate=new Template("layout/edit_bilder.lay.php");
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
    $arrData=$objMySQL->QuerySingleRowArray('SELECT * FROM '.TBL_BILDER.' WHERE kunde='.$mode["kunde"].' AND id='.$mode["id"].'',MYSQL_ASSOC);
} else{
    $arrData=FALSE;
}
if ($arrData!==FALSE) {
    if ($mode["mode"]=="edit") {
        $sql = "SELECT * FROM ".TBL_KUNDEN." ORDER BY name";
        $arrkunden_data =  $objMySQL->QueryArray($sql,MYSQL_ASSOC);  
        $arrData['kundenliste'] = MakeKundenAuswahl($arrData['kunde'],$arrkunden_data);
        $objTemplate->AssignArray($arrData);
        $objTemplate->display("bilder_edit");
    }
    else{
        //objTemplate->display("nogeraete");
    }
        
}else{
    if ($mode["mode"]=="create") {  
        $objTemplate->AssignArray($mode);
        $objTemplate->display("bilder_create");
    }
    else{
        //$mysqlfail="'SELECT * FROM '.TBL_GERAETE.' WHERE id='.$_GET['id'].' AND kunde='.$_GET['knd_id'],MYSQL_ASSOC";
        $objTemplate->display("nogeraete");
    }
}
?>