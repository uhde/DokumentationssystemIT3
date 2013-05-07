<?
//ob_start('ob_gzhandler');
require("include/config.inc.php5");
include("include/mysql.inc.php5");
include("include/template.inc.php5");
//$arrTemplate=fnMakeTemplate("layout/aktuelles.lay.php");
//$objTemplate=new Template("layout/fernwartung.lay.php");

$objMySQL=new MySQL();
$objMySQL->connect($SERVER,$USER,$PASS,$DB,$resConn);

if (!isset($ktg_id)) $ktg_id=1;
if (!isset($knd_id)) {
    $objMySQL->query("SELECT id FROM kunden ORDER BY name");
    if ($objMySQL->numrows()>0) {
        $arrData=$objMySQL->fetch_one("MYSQL_ASSOC");
        $knd_id=$arrData["id"];
    }else{
        $knd_id=1;
    }
}

if (file_exists("layout/fernwartung_".$ktg_id.".lay.php")) {
    $objTemplate=new Template("layout/fernwartung_".$ktg_id.".lay.php");
}else{
    $objTemplate=new Template("layout/fernwartung.lay.php");
}

// Verfügbare Programme ermitteln
    $objMySQL->query("SELECT * FROM programme");
    $arrData=$objMySQL->fetch_all("MYSQL_ASSOC");
    for ($i=0;$i<count($arrData);$i++) {
//        $arrProgramme[$arrData[$i]["name"]]["url"]=str_replace("\\","/",stripslashes($arrData[$i]["url"]));
        $arrProgramme[$arrData[$i]["name"]]["url"]=addslashes($arrData[$i]["url"]);
        $arrProgramme[$arrData[$i]["name"]]["bemerkung"]=$arrData[$i]["bemerkung"];
        $arrProgramme[$arrData[$i]["name"]]["id"]=$arrData[$i]["id"];
        $arrProgramme[$arrData[$i]["name"]]["port"]=$arrData[$i]["port"];
        $arrProgramme[$arrData[$i]["name"]]["use_internet"]=$arrData[$i]["use_internet"];
        $arrProgramme[$arrData[$i]["name"]]["repeater_port"]=$arrData[$i]["repeater_port"];
    }
//    echo "<pre>";    print_r($arrProgramme);    echo "</pre>";
    unset($arrData);

    $arrData["knd_id"]=$knd_id;
    
    $arrData["kategorien"]=$kategorien;
    $arrData["ktg_id"]=$ktg_id;
    
    $objTemplate->assign("header",$arrData);
    $objTemplate->make("header");
    $objTemplate->display("header");

    if (!isset($order)) $order="name";
    if (!isset($ascdesc)) $ascdesc="asc";

    // Kundenname ermitteln
/*
    $objMySQL->query("SELECT name FROM kunden WHERE id=$knd_id");
    if ($objMySQL->numrows()==1) {
        $arrKunde=$objMySQL->fetch_one("MYSQL_ASSOC");
        $Kunde_Name=$arrKunde['name'];
    }
*/    
    $objMySQL->query("SELECT * FROM geraete WHERE kunde=$knd_id AND kategorie=$ktg_id ORDER BY $order $ascdesc");
    $Position=0;
    $Anzahl=$objMySQL->numrows();
    if ($Anzahl>0) {
        $LineClass=-1;
        while ($arrData=$objMySQL->fetch_one("MYSQL_ASSOC")) {
            $ip="";
            $disabled="";
            $SpecialButtons="";
            $LineClass=~$LineClass;
            $Position++;
    // Allgemeine Angaben
            $arrData["knd_id"]=$knd_id;
            $arrData["ktg_id"]=$ktg_id;
            //$arrData["kunde"]=$Kunde_Name;
// IP ermitteln
            $disabled="";
            if (!empty($arrData["adresse"])) {
                if (!eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}",$arrData["adresse"])) {
                    $ip=fnGetIP($arrData["adresse"]);
                    $SpecialButtons="<input type='button' onClick=\"Ping('$ip');\" value=' Ping ' class='Fernwart' >";
                    $arrData["ip"]=$ip;
                    if ($ip==$arrData["adresse"]) {
                        $ip="<span id='IPError'>$ip</span>";
                        $disabled="disabled";
                        $SpecialButtons="<input type='button' value=' Ping ' class='Fernwart' disabled>";
                    }
                }else{
                    $ip=$arrData["adresse"];
                    $arrData["ip"]=$ip;
                    $SpecialButtons="<input type='button' onClick=\"Ping('$ip');\" value=' Ping ' class='Fernwart' >";
                    $ip="$ip <span id='IPError'>(fest)</span>";
                }                
            }else{
                $ip="Keine IP vorhanden";
            }
            $arrData["ip_text"]=$ip;
// Anker ermitteln
//            if (!empty($arrData["adresse"]) OR !eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}",$arrData["adresse"])) {
//                if (strpos($arrData["adresse"],".")>0) {
//                    $arrData["anker"]=substr($arrData["adresse"],0,strpos($arrData["adresse"],"."));
//                }else{
//                    $arrData["anker"]="id".$arrData["id"];
//                }

//            }else{
                $arrData["anker"]="id".$arrData["id"];
//            }
// Name ermitteln
            if (empty($arrData["adresse"])) $arrData["adresse"]=$arrData["name"];
// Programmliste erzeugen
            if (!empty($arrData["programme"])) {
                $Programme="";
                $arrPrg=explode(",",$arrData["programme"]);
                for ($j=0;$j<count($arrPrg);$j++) {
                    if(array_key_exists($arrPrg[$j],$arrProgramme)) {

                    // Daten für Programmaufruf gernerieren
                        $prg=$arrProgramme[$arrPrg[$j]]["url"];
                        $prg_id=$arrProgramme[$arrPrg[$j]]["id"];
                        $prg_port=$arrProgramme[$arrPrg[$j]]["port"];
                        //$prg_use_internet=$arrProgramme[$arrPrg[$j]]["use_internet"];
                        
                        foreach ($arrData as $strKey => $strValue) {
                            $prg=str_replace("{".$strKey."}",$strValue,$prg);
                        }
                        $prg=stripslashes(stripslashes($prg));
                        $prg=$arrProgramme[$arrPrg[$j]]["id"];
//                        $Programme.="<input type='button' onClick=\"OpenProg('$prg');\" value='".$arrProgramme[$arrPrg[$j]]["bemerkung"]."' class='Fernwart' $disabled>";
                        if ($arrProgramme[$arrPrg[$j]]["use_internet"]==1) {
               $Programme.="<input type='button' onClick=\"javascript:parent.progress.location.href='ping.php5?prg_id=$prg_id&ip=".strip_tags($arrData["ip"])."&knd_id=$knd_id&grt_id=".$arrData["id"]."&port=".$prg_port."&use_internet=".$arrProgramme[$arrPrg[$j]]["use_internet"]."';\" value='".$arrProgramme[$arrPrg[$j]]["bemerkung"]."' class='Fernwart'>";
            }else{
               $Programme.="<input type='button' onClick=\"javascript:parent.progress.location.href='ping.php5?prg_id=$prg_id&ip=".strip_tags($arrData["ip"])."&knd_id=$knd_id&grt_id=".$arrData["id"]."&port=".$prg_port."&use_internet=".$arrProgramme[$arrPrg[$j]]["use_internet"]."';\" value='".$arrProgramme[$arrPrg[$j]]["bemerkung"]."' class='Fernwart' $disabled>";
            }
                        $Programme.="&nbsp;&nbsp;&nbsp;&nbsp;";
                        
                    }
                }
                $arrData["Programme"]=trim($Programme);
            }

// Garantie prüfen
            if (!empty($arrData["garantie"])) {
                if ($arrData["garantie"]>time()) {
                    $arrData["GarantieCheck"]="color:#006600;";
                }else{
                    $arrData["GarantieCheck"]="color:#ff0000;";
                }
                $arrData["garantie"]=date("d.m.Y",$arrData["garantie"]);
            }
            $arrData["SpecialButtons"]=$SpecialButtons;
            $arrData["StyleClass"]=abs($LineClass);
            //$arrData["bemerkung"]=stripslashes($arrData["bemerkung"]);
            $arrData["bemerkung"]=nl2br(stripslashes($arrData["bemerkung"]));

            if ($arrData["anker"]!=$show) {
                $objTemplate->clear_assign("mainlist");
                $objTemplate->assign("mainlist",$arrData);
                $objTemplate->make("mainlist");
                $objTemplate->display("mainlist");
            }else{
// Sprungposition für Anker            
                 if ($Anzahl>10 AND $Position<$Anzahl-5) {
                    $arrData["Spacer"]="<p style='padding-top:60px;'></p>";
                }else{
                    $arrData["Spacer"]="";
                }
                $arrData["ScrollPos"]=400+(64*$Position);
                $objTemplate->clear_assign("main");
                $objTemplate->assign("main",$arrData);
                $objTemplate->make("main");
                $objTemplate->display("main");
                unset($arrData);
            }
        }
        
        
    } else {
        $objTemplate->display("nodata");
    }
    $objTemplate->display("footer");
//ob_end_flush();


function fnGetIP($name) {
    $ip="";
/*
    if (function_exists("dns_get_record")) {
        $result = dns_get_record(trim($name));
        $ip=$result[count($result)-1]["ip"];
    }
*/
    if ($ip=="" and file_exists("/usr/bin/dig")) {
        exec("/usr/bin/dig $name A +short",$arrIP);
        $ip=$arrIP[0];
        if (!eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}",$ip)) $ip="";
    }
/*
    if ($ip=="" and file_exists(addslashes(getenv("systemroot")."\\system32\\nslookup.exe"))) {
        exec(getenv("systemroot")."\\system32\\nslookup.exe -retry=1 -timeout=0 $name",$arrIP);
        for ($i=0;$i<count($arrIP);$i++) {
            if (eregi("^Name:",$arrIP[$i])) {
                $i++;
                break;
            }
        }
        $ip=trim(str_replace("Address:","",$arrIP[$i]));
    }
*/
    if ($ip=="") {
        $ip=$name;
    }
    return $ip;
}


?>


