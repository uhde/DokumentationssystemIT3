<?
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");

$objTemplate=new Template("layout/geraeteedit.lay.php");
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
    $arrData=$objMySQL->QuerySingleRowArray('SELECT * FROM '.TBL_GERAETE.' WHERE kunde='.$mode["kunde"].' AND id='.$mode["id"].'',MYSQL_ASSOC);
} else{
    $arrData=FALSE;
}
    if(isset($mode['wiederherstellen'])&&(!empty($mode['wiederherstellen'])))
    {
        $sql='SELECT '.TBL_GERAETE_LOGIN.'.id AS geraete_login_id,'.TBL_GERAETE_LOGIN.'.login AS geraete_login,'.TBL_GERAETE_LOGIN.'.passwort AS geraete_pw, '.TBL_GERAETE_LOGIN.'.aktiv  , 
                '.TBL_PROGRAMME.'.id AS  prog_id, '.TBL_PROGRAMME.' .bemerkung 
                FROM '.TBL_GERAETE_LOGIN.', '.TBL_PROGRAMME.' 
                WHERE '.TBL_GERAETE_LOGIN.'.loeschen=0 AND geraete_id='.$mode["id"].' AND programm_id='.TBL_PROGRAMME.'.id ';
    } else {
        $sql='SELECT '.TBL_GERAETE_LOGIN.'.id AS geraete_login_id,'.TBL_GERAETE_LOGIN.'.login AS geraete_login,'.TBL_GERAETE_LOGIN.'.passwort AS geraete_pw, '.TBL_GERAETE_LOGIN.'.aktiv  , 
                '.TBL_PROGRAMME.'.id AS  prog_id, '.TBL_PROGRAMME.' .bemerkung 
                FROM '.TBL_GERAETE_LOGIN.', '.TBL_PROGRAMME.' 
                WHERE '.TBL_GERAETE_LOGIN.'.loeschen=1 AND geraete_id='.$mode["id"].' AND programm_id='.TBL_PROGRAMME.'.id ';
    }
    $arrData2=$objMySQL->QueryArray($sql,MYSQL_ASSOC);
    $arrData3=$objMySQL->QueryArray('SELECT *
                FROM '.TBL_PROGRAMME.' ORDER BY id
                ',MYSQL_ASSOC);            
//	$arrData4=$objMySQL->QueryArray('SELECT * FROM '.TBL_GERAETE_LOGIN.' WHERE geraete_id='.$mode['id'].' ',MYSQL_ASSOC);  
                 
// Wenn die get Variable prog_add gesetzt ist,                  
if((isset($mode['prog_add'])&&(!empty($mode['prog_add'])))||$mode["mode"]=="create")
{
    $prog_add=$mode['prog_add'];
} else {
    $prog_add=-1;
    }
                
if ($arrData!==FALSE) {
    switch( $arrData["kategorie"] ) {
        case 1:
            $arrData["kat_active_server"]="selected";
            break;
        case 2:
            $arrData["kat_active_pc"]="selected";
            break;
        case 3:
            $arrData["kat_active_drucker"]="selected";
            break;
        case 4:
            $arrData["kat_active_netzwerk"]="selected";
            break;
        default: 
            $arrData["kat_active_server"]="selected";
            break;
    }
    if ($mode["mode"]=="edit") {
        
        $arrData['login_edit']=MakeLoginTable($arrData2,$arrData3,$prog_add,$mode["id"],$mode["kunde"]);
        $arrData['garantied']=date("d",$arrData['garantie']);
        $arrData['garantiem']=date("m",$arrData['garantie']);
        $arrData['garantiey']=date("Y",$arrData['garantie']);
        // Wenn die Garantie auf heute in 3 Jahren gesetzt werden soll.
        $arrData['garantied_set']=date("d");
        $arrData['garantiem_set']=date("m");
        $arrData['garantiey_set']=date("Y")+3;
        
        $objTemplate->AssignArray($arrData);
        $objTemplate->display("geraeteedit");
    }
    else{
        //objTemplate->display("nogeraete");
    }
        
}else{
    if ($mode["mode"]=="create") {
        $mode['garantied_set']=date("d");
        $mode['garantiem_set']=date("m");
        $mode['garantiey_set']=date("Y")+3;
        $mode['login_edit']=MakeLoginTable($arrData2,$arrData3,$prog_add,$mode["id"],$mode["kunde"]);
        $objTemplate->AssignArray($mode);
        $objTemplate->display("geraetecreate");
    }
    else{
        //$mysqlfail="'SELECT * FROM '.TBL_GERAETE.' WHERE id='.$_GET['id'].' AND kunde='.$_GET['knd_id'],MYSQL_ASSOC";
        $objTemplate->display("nogeraete");
    }
}


function MakeLoginTable($Data,$Data2,$prog_add,$geraet_id,$kunden_id){
	if ($Data!==FALSE) {
        $runde=1;
		$objTemplate=new Template("layout/geraeteedit.lay.php");
		$str=$objTemplate->DisplayToString('Login_Header');
		foreach ($Data as $Value){
            $Value['runde']=$runde;
            $Value['prog_list']=MakeProgList($Data2,$Value['prog_id']);
            $Value['aktive']=MakeProgAktiv($Data,$Value['prog_id'],$runde);
            $Value['geraet_id']=$geraet_id;
            $Value['kunden_id']=$kunden_id;
            $objTemplate->AssignArray($Value);
            if(!(isset($Value['passwort']))) {
                $str.=$objTemplate->DisplayToString('Login_Main');
            }
            $objTemplate->ClearAssign();
            $runde++;
		}
        
        //Die Variablen müssen hier auf "" gesetzt werden, da sonst die Werte des letzten durchlaufes übernommen werden.
        $test=array();
        $test['geraete_login']="";$test['geraete_pw']="";$test['geraete_login']="";$test['aktiv']="0";
        // Falls leere Programmfelder zugewiesen werden sollen...
        for ($i=0;$i<=$prog_add;$i++)  {
            $test['runde']=$runde;
            $test['prog_list']=MakeProgList($Data2,"20");
            $test['aktive']=MakeProgAktiv($Data,"20",$runde);
            $objTemplate->AssignArray($test);
            $str.=$objTemplate->DisplayToString('Login_Main');
            $objTemplate->ClearAssign();
            $runde++;
		}
            
            
		$str.=$objTemplate->DisplayToString('Login_Footer');
		unset($objTemplate);
		return $str;
        //return $Data;
	}
        $runde=1;
		$objTemplate=new Template("layout/geraeteedit.lay.php");
        $str=$objTemplate->DisplayToString('Login_Header');
        $test['geraete_login']="";$test['geraete_pw']="";$test['geraete_login']="";$test['aktiv']="0";
        for ($i=0;$i<=$prog_add;$i++)  {
            $test['runde']=$runde;
            $test['prog_list']=MakeProgList($Data2,"20");
            $test['aktive']=MakeProgAktiv($Data,"20",$runde);
            $objTemplate->AssignArray($test);
            $str.=$objTemplate->DisplayToString('Login_Main');
            $objTemplate->ClearAssign();
            $runde++;
		}
        $str.=$objTemplate->DisplayToString('Login_Footer');
		unset($objTemplate);
        return $str;
        
    return FALSE;
}

// MakeProgList macht Dropdownliste der Programme, die in MakeLoginTable dann verwendet wird
function MakeProgList($Data,$programm_id){
	if ($Data!==FALSE) {
        $runde=1;
		$objTemplate=new Template("layout/geraeteedit.lay.php");
		$str="";
		foreach ($Data as $Value){
            $Value['runde']=$runde;
            $objTemplate->AssignArray($Value);
            if($Value['id']==$programm_id)
            {
                $str.=$objTemplate->DisplayToString('Prog_selected_liste');
            }
            else
            {
                $str.=$objTemplate->DisplayToString('Prog_liste');
            }
            
            $objTemplate->ClearAssign();
            $runde++;
		}
		unset($objTemplate);
		return $str;
        //return $Data;
	}
    return FALSE;
}


function MakeProgAktiv($Data,$programm_id,$runde){
	if ($Data!==FALSE) {
		$objTemplate=new Template("layout/geraeteedit.lay.php");
        $first=false;
        if($programm_id != '20')
        {
            foreach ($Data as $Value){
                if($Value["prog_id"]==$programm_id AND $first==false){
                    $Value["runde"]=$runde;
                    $objTemplate->AssignArray($Value);
                     if($Value['aktiv']=='0') {
                    
                        $str="";
                    }else{
                        $str="checked";
                    }
                    $first=true;
                    $objTemplate->ClearAssign();
                }
            }
        }
		unset($objTemplate);
		return $str;
        //return $Data;
	}
    return FALSE;   
}

?>


