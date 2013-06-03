<html>
<head>
<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);*/
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    
    $tabelle="";
    
    // Damit werden die Get Variablen geholt, und in das Array "mode" gespeichert.
    foreach($_GET as $key=>$value) 
    { 
        echo "MODE: ".$key." -> ".$value."<br>"; 
        $mode[$key]=mysql_real_escape_string($value);
    }     
    // Damit werden die Post Variablen geholt, und in das Array "daten" gespeichert.
    foreach($_POST as $key=>$value) 
    { 
        if(isset($_Post['kunde']))
        {
            $kunde_post = true;
        } else {
            $kunde_post = false;
        }
        $value=mysql_real_escape_string($value);
        echo "POST: ".$key." -> ".$value."<br>"; 
        //echo $key." -> ".$value."<br>";
        if(strpos($key,'programm_id')!==false) {
            // Hier wird zuerst die Zählvariable ausgelesen
            $count=preg_replace('/programm_id/i',"",$key);
            // Anschließend wird die Zählvariable vom Key abtgezogen
            $key=preg_replace('/'.$count.'/i',"",$key);
            // Hier wird dann ein zweidiminsionales Array gebildet.
            // Als Schlüssel kommt die Zählvariable und der Schlüssel zum Einsatz
            $prog[$count][$key]=$value;
             //echo "count= ".$count." ->".$key." = ".$value." <br>";
        }
        else {
            if(strpos($key,'login')!==false) {
            $count=preg_replace('/login/i',"",$key);
            $key=preg_replace('/'.$count.'/i',"",$key);
            $prog[$count]["login"]=$value;
            }
            else{
                if(strpos($key,'passwort')!==false) {
                    $count=preg_replace('/passwort/i',"",$key);
                    $key=preg_replace('/'.$count.'/i',"",$key);
                    $prog[$count]["passwort"]=$value;
                }
                else {
                    if(strpos($key,'prog_aktiv')!==false) {
                        $count=preg_replace('/prog_aktiv/i',"",$key);
                        $key=preg_replace('/'.$count.'/i',"",$key);

                        //if($value=="on") {
                            $prog[$count]["prog_aktiv"]=1;
                        //}
                    }
                    else {
                        if(strpos($key,'garantie')!==false) {
                            //in count wird der buchstabe (d für day, m für month, y für year) gespeichert
                            $count=preg_replace('/garantie/i',"",$key);
                            $garantie[$count]=$value;
                        } 
                        else{
                                // Hier werden dann die übrigen Daten ausgelesen, und in ein Array geschrieben.
                                $daten[$key]=$value;
                                //echo $key." -> ".$value."<br>";
                        }
                    }
                }
            }
        }
    }
    if(isset($garantie)) {
        if(!empty($garantie["m"])&&!empty($garantie["d"])&&!empty($garantie["y"]))
        {
            $daten['garantie']=mktime(0, 0, 0, intval($garantie["m"]), intval($garantie["d"]),intval($garantie["y"]));
        } else {
            $daten['garantie']="";
        }
    }
    if ($mode["name"]=="kunde")
    {
        $tabelle=TBL_KUNDEN;
    }
    if ($mode["name"]=="geraete")
    {
        $tabelle=TBL_GERAETE;
    }
    // Falls entweder nur ein Programm gelöscht, oder weitere Programme angezeigt werden sollen, wird man gleich wieder auf die Seite zurückgeleitet
    if((isset($mode['prog_add'])&&(!empty($mode['prog_add'])))&&$mode["mode"]!="create") {
        echo '<meta http-equiv="refresh" content="0; URL=edit_geraete.php?kunde='.$mode["kunde"].'&id='.$mode["id"].'&prog_add='.$mode["prog_add"].'&mode=edit">';
    }  
    if(isset($mode['prog_del'])&&(!empty($mode['prog_del']))) {
        echo '<meta http-equiv="refresh" content="0; URL=edit_geraete.php?kunde='.$mode["kunde"].'&id='.$mode["id"].'&mode=edit">';
    }  

    
?>
</head>


<body style="margin:0;padding:0;text-align:center;">
<?php
    
/*if(isset($mode["askuser"])) {
    echo "Möchten sie die Löschung wirklich vornehmen?";
    echo '<input type="button" onClick="window.location.reload();">';
} else {*/
    
    //echo '<a href="edit_geraete.php?kunde='.$mode["kunde"].'&id='.$mode["id"].'&prog_add='.$mode["prog_add"].'&mode=edit"> testtasdasdkhjg</a>';
    
    //---------------- Falls nur Werte geändert werden sollen. $tabelle muss gesetzt sein. ------------------- 
    if ($mode["mode"]=="edit")
    {
        $firstrun=true;
        $sqlquery="UPDATE `".DB_DATABASE."`.`".$tabelle."` SET ";
        foreach($daten as $key=>$value)
        {
            if ($firstrun==true)
            {
                $sqlquery=$sqlquery."`".$key."` = '".$value."' ";
                $firstrun=false;
            }
            else{
                $sqlquery=$sqlquery.", `".$key."` = '".$value."' ";
            }
        }
        if ($mode["name"]=="kunde")
        {
            $sqlquery=$sqlquery." WHERE id=".$mode['id'];
        }
        // In den Tabellen "kunde" und "geraete" gibt es verschieden Spaltennamen für die kundennummer.
        // Deswegen hier immer die Differenz zwischen Kunde und Geraete
        if ($mode["name"]=="geraete")
        {
            $sqlquery=$sqlquery." WHERE id=".$mode['id']." AND kunde=".$mode['kunde'];
        }
        
        //$sqlquery=mysql_real_escape_string($sqlquery);
        //echo "<h3>Hier ist der SQL-Update Befehl.</h3><br>".$sqlquery;
        $objMySQL->Query($sqlquery);
         echo "<h2>Der Eintrag wurde aktualisiert</h2>";
    }
        
    
    //---------------- Falls ein neuer Eintrag gemacht soll. --------------------
    if ($mode["mode"]=="create")
    {
        $firstrun=true;
        $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
        foreach($daten as $key=>$value)
        {
            if ($firstrun==true)
            {
                $sqlquery=$sqlquery."`".$key."` = '".$value."' ";
                $firstrun=false;
            }
            else{
                $sqlquery=$sqlquery.", `".$key."` = '".$value."' ";
            }
        }
        if ($mode["name"]=="geraete" AND $kunde_post == false)
        {
            $sqlquery=$sqlquery.", `kunde` = '".$mode['kunde']."' ";
            $sqlquery=$sqlquery.", `kategorie` = '".$mode['kategorie']."' ";
        }
        echo "<h1>Hier ist der SQL-Update Befehl.</h1><br>".$sqlquery."<br>";
        $objMySQL->Query($sqlquery);
        $mode['id']=mysql_insert_id();
         echo "<h2>Der Eintrag wurde erstellt</h2>";
    }
    if ($mode["name"]=="geraete")
    {  
        if(isset($prog)) {
        if(is_array($prog))
        {
            $prog_written=array();
            foreach($prog as $value)
            {
                if(isset($value['prog_aktiv'])&&(!empty($value['prog_aktiv']))) {
                    $value['aktiv']=1;
                }else{
                    $value['aktiv']=0;
                }
                
                // Solange entweder die Variable login, passwort oder aktiv gesetzt ist, wird das folgende ausgeführt.
                if((isset($value['login'])&&(!empty($value['login'])))||(isset($value['passwort'])&&(!empty($value['passwort'])))||(isset($value['prog_aktiv'])&&(!empty($value['prog_aktiv']))))
                {
                    $writemode=1;
                    $written=false;
                    $sqlquery="SELECT * FROM geraete_login WHERE geraete_id=".$mode['id']." AND programm_id=".$value['programm_id']." ";
                    $sqloutput=$objMySQL->Query($sqlquery);
                    //echo $sqloutput."<br>";
                    //echo $sqlquery."<br>";
                    while($row=mysql_fetch_assoc($sqloutput)){
                        $writemode=1;
                        foreach($prog_written AS $prog_written_value) {
                            if($prog_written_value==$row['id'] AND ($row['programm_id']==$value['programm_id'])) {
                                //Falls ein Eintrag zweimal vorkommt, wird dieser Fall abgearbeitet
                                $writemode=2;
                            }
                        }
                        if($row['programm_id']==$value['programm_id'])
                        {
                            //WriteMode 0=>nichts machen, 1=>Update, 2=>Insert
                            if($writemode==1 AND $written==false) {
                                $sqlquery="UPDATE `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET ";
                                $sqlquery=$sqlquery."`login` = '".$value['login']."', ";
                                $sqlquery=$sqlquery."`passwort` = '".$value['passwort']."', ";
                                $sqlquery=$sqlquery."`aktiv` = '".$value['aktiv']."' ";
                                $sqlquery=$sqlquery."WHERE id=".$row['id'];
                                //echo $sqlquery."<br>";
                                $objMySQL->Query($sqlquery);
                                $temp=count($prog_change[$row['programm_id']]);
                                $prog_change[$row['programm_id']][$temp]=$row['id'];
                                $written=true;
                                $temp=count($prog_written);
                                // Hierbei wird nichts zu dem gezählten dazugefügt, da das Array bei 0 beginnt, und gezählt wird ja immer die Anzahl der Einträge (beginnt bei eins)
                                $prog_written[$temp]=$row['id'];
                            }
                        }
                        
                    }
                    if($written==false) {
                        $sqlquery="INSERT INTO `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET ";
                        $sqlquery=$sqlquery."`geraete_id` = '".$mode['id']."', ";
                        $sqlquery=$sqlquery."`programm_id` = '".$value['programm_id']."', ";
                        $sqlquery=$sqlquery."`login` = '".$value['login']."', ";
                        $sqlquery=$sqlquery."`passwort` = '".$value['passwort']."', ";
                        $sqlquery=$sqlquery."`aktiv` = '".$value['aktiv']."' ";
                        //echo $sqlquery."<br>";
                        $objMySQL->Query($sqlquery);
                        $written=true;
                        $temp=count($prog_written);
                        $prog_written[$temp]=mysql_insert_id();
                        
                    }
                        
                    //echo "Das Programm mit den Werten: login:".$value['login'].", passwort: ".$value['passwort'].", aktiv: ".$value['prog_aktiv']." wurde gespeichert.<br>";
                }
                else {
                    //echo "-------------Das Programm mit den Werten: login:".$value['login'].", passwort: ".$value['passwort'].", aktiv: ".$value['prog_aktiv']." wurde nicht gespeichert.<br>";
                }
            }
        }}
        //echo "<h2>Die Daten wurden gespeichert</h2>";
    }
    if (($mode["prog_del"]=='1')&&($mode["name"]=="geraete")) {
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `".TBL_GERAETE_LOGIN."`.`id` = ".$mode['geraete_login_id'];
        //$sqlquery="DELETE FROM `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` WHERE `".TBL_GERAETE_LOGIN."`.`id` = ".$mode['geraete_login_id'];
        echo "Programm wurde gelöscht.";
        $objMySQL->Query($sqlquery);
    }
    if (($mode["mode"]=='delete')&&($mode["name"]=="geraete")) {
        //Hier wurde bereits die Routine für das verzögerte Löschen hinzugefügt
        //$sqlquery="DELETE FROM `".DB_DATABASE."`.`".TBL_GERAETE."` WHERE `".TBL_GERAETE."`.`id` = ".$mode['id'];
        $sqlquery = "UPDATE `".DB_DATABASE."`.`geraete` SET `loeschen` = '0', `loeschentime` = '".time()."'  WHERE `geraete`.`id` = ".$mode['id'];
        echo "<h2>Das Gerät wurde gelöscht</h2>";
        $objMySQL->Query($sqlquery);
        //$sql = "DELETE FROM `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` WHERE `".TBL_GERAETE_LOGIN."`.`geraete_id` = ".$mode['id'];
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET `loeschen` = '0', `loeschentime` = '".time()."'  WHERE `geraete_id` = ".$mode['id'];
        $objMySQL->Query($sqlquery);
    }
    if (($mode["mode"]=='renew')&&($mode["name"]=="geraete")) {
        // Hier wird ein Objekt aus dem Papierkorb zurückgeholt
        $sqlquery = "UPDATE `".DB_DATABASE."`.`geraete` SET `loeschen` = '1', `loeschentime` = NULL  WHERE `geraete`.`id` = ".$mode['id'];
        echo "<h2>Das Gerät wurde wiederhergestellt</h2>";
        $objMySQL->Query($sqlquery);
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET `loeschen` = '1', `loeschentime` = NULL  WHERE `geraete_id` = ".$mode['id'];
        $objMySQL->Query($sqlquery);
    }
    if (($mode["mode"]=='delete')&&($mode["name"]=="kunde")) {
    
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BILDER."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_DOKUMENTE."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_ZUGAENGE."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`routing` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_ZUGAENGE."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE_LOGIN."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `".TBL_GERAETE."`.`kunde` = '".$mode['id']."' AND `".TBL_GERAETE_LOGIN."`.geraete_id=`".TBL_GERAETE."`.id  ";
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_ZUGAENGE."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_KUNDEN."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `id` = ".$mode['id'];
        $objMySQL->Query($sql);
        
        /*
        $sql="DELETE FROM `".DB_DATABASE."`.`".TBL_BILDER."` WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql="DELETE FROM `".DB_DATABASE."`.`".TBL_DOKUMENTE."` WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql="DELETE FROM `".DB_DATABASE."`.`".TBL_ZUGAENGE."` WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql="DELETE FROM `".DB_DATABASE."`.`routing` WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sql="DELETE FROM `".TBL_GERAETE_LOGIN."`, `".TBL_GERAETE."` WHERE `".TBL_GERAETE."`.`kunde` = '".$mode['id']."' AND `".TBL_GERAETE_LOGIN."`.geraete_id=`".TBL_GERAETE."`.id  ";
        $objMySQL->Query($sql);
        $sql="DELETE FROM `".DB_DATABASE."`.`".TBL_GERAETE."` WHERE `kunde` = ".$mode['id'];
        $objMySQL->Query($sql);
        $sqlquery="DELETE FROM `".DB_DATABASE."`.`".TBL_KUNDEN."` WHERE `".TBL_KUNDEN."`.`id` = ".$mode['id'];
        $objMySQL->Query($sql);*/
        echo "<h2>Der Kunde wurde gelöscht</h2><br>";
        $objMySQL->Query($sqlquery);
    }
     if((isset($mode['prog_add'])&&(!empty($mode['prog_add'])))&&$mode["mode"]=="create") {
        echo '<meta http-equiv="refresh" content="0; URL=edit_geraete.php?kunde='.$mode["kunde"].'&id='.$mode["id"].'&prog_add='.$mode["prog_add"].'&mode=edit">';
    } 
//}
?>
   <!-- 
   <div style="height:33px;width:200px;">
        <div style="position:relative;top:4px;left:90%;">
            <input type="button" value="Schließen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide(window.parent.location.reload(true)));" class="button1">
        </div>
    </div>
    -->
</body>
</html>