<html>
<head>
<?php
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
?>
</head>


<body style="margin:0;padding:0;"> 
<h2>Die Programme Tabelle muss umgestaltet werden... die Variablen geraete_login und geraete_pw müssen eingepflegt werden."</h2>
<br>Damit meine ich dass die variablen die momentan für login-name, und login-pw stehen (zb. tv-id) mit diesen Variablen ersetzt werden müssen.<br><br>
<?php
    /*$sql = "ALTER TABLE `programme` ADD `prg_pfadt` TEXT NOT NULL AFTER `url`, ADD `par_adresse` TEXT NOT NULL AFTER `prg_pfadt`,  ADD `par_login` TEXT NOT NULL AFTER `par_adresse`, ADD `par_passwort` TEXT NOT NULL AFTER `par_login`, ADD `par_weitere_Optionen` TEXT NOT NULL AFTER `par_passwort`"; 
    echo "Falls die Programm Tabelle noch nicht erweitert wurde, bitte folgenden Befehl ausgeben: <br>".$sql;
    echo "<br>Vergessen sie danach nicht, die notwendigen Informationen in die Datenbank einzutragen.<br><br>";
    *///Überprüft ob schon die Datenbank incl Datensätze vorhanden ist
    
    
    if(($arrData=$objMySQL->QueryArray("SHOW TABLES FROM ".TBL_GERAETE_LOGIN.""))==false)
    {   
        // Wenn nicht schon vorhanden, wird die Tabelle erstellt 
        $arrData=$objMySQL->QueryArray('CREATE TABLE `'.DB_DATABASE.'`.`'.TBL_GERAETE_LOGIN.'` (`id` INT NOT NULL AUTO_INCREMENT ,`geraete_id` INT NOT NULL ,`programm_id` INT NOT NULL ,`login` VARCHAR( 30 ) NOT NULL ,`passwort` VARCHAR( 40 ) NULL ,`aktiv` BOOLEAN NOT NULL ,`bemerkung` TEXT NULL ,PRIMARY KEY ( `id` )) ENGINE = MYISAM ;');
    }
    echo "Folgende Daten wurden übernommen:";
    $tabelle=TBL_GERAETE_LOGIN;
    
    $arrData=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.TBL_GERAETE.'` ');
    foreach($arrData as $Value)
    {   
        // Dies wird gemacht, um Fehler bei der Übertragen der Daten an die MYSQL Datenbank zu verhindern.
        // Ansonsten werden spezielle Sonderzeichen wie \ nicht, oder gar falsch eingetragen
        foreach($Value as $temp=>$data)
        {
            $Value[$temp]=mysql_real_escape_string($data);
        }
        $Value['programme']=str_replace(',',' ',$Value['programme']);
        
        // Die Felder Login und Passwort werden übernommen.
        if($Value['login']||$Value['passwort'])
        {
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".mysql_real_escape_string($Value['id'])."' ,";
            $sqlquery=$sqlquery."`programm_id` = '20' ,";
            $sqlquery=$sqlquery."`login` = '".$Value['login']."' ,";
            $sqlquery=$sqlquery."`passwort` = '".$Value['passwort']."' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '0' ";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=20');
            if($test==FALSE)
            {
                //$sqlquery=mysql_real_escape_string($sqlquery);
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                } else {
                    echo "<br><b>Fehler</b>: ".$sqlquery;
                }
                
                
            }
        } 
        
        //Trägt Web-Teamviewer Verbindungen ein
 
        if($Value['tv_id']||$Value['tv_pwd'])
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '15' ,";
            $sqlquery=$sqlquery."`login` = '".$Value['tv_id']."' ,";
            $sqlquery=$sqlquery."`passwort` = '".$Value['tv_pwd']."' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            if(strpos($Value['programme'],'Web-Teamviewer')===false) {
                $sqlquery=$sqlquery."`aktiv` = '0' ";
            } else {
                $sqlquery=$sqlquery."`aktiv` = '1' ";
            }
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=16');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
    
        //Trägt Lan-Teamviewer verbindungen ein.
        if($Value['tv_id']||$Value['tv_pwd'])
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '16' ,";
            $sqlquery=$sqlquery."`login` = 'Nichts Eintragen' ,";
            $sqlquery=$sqlquery."`passwort` = '".$Value['tv_pwd']."' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            if(strpos($Value['programme'],'LAN-Teamviewer')===false) {
                $sqlquery=$sqlquery."`aktiv` = '0' ";
            } else {
                $sqlquery=$sqlquery."`aktiv` = '1' ";
            }
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=16');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        
        if($Value['ftplogin']||$Value['ftppasswort'])
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '4' ,";
            $sqlquery=$sqlquery."`login` = '".$Value['ftplogin']."' ,";
            $sqlquery=$sqlquery."`passwort` = '".$Value['ftppasswort']."' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            if(strpos($Value['programme'],'ftp')===false) {
                $sqlquery=$sqlquery."`aktiv` = '0' ";
            } else {
                $sqlquery=$sqlquery."`aktiv` = '1' ";
            }
 
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=4');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(($Value['vncpasswort'])||(!(strpos($Value['programme'],'vnc')===false)))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '1' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '".$Value['vncpasswort']."' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            if(strpos($Value['programme'],'vnc')===false) {
                $sqlquery=$sqlquery."`aktiv` = '0' ";
            } else {
                $sqlquery=$sqlquery."`aktiv` = '1' ";
            }
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=1');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if($Value['xurl'])
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '18' ,";
            $sqlquery=$sqlquery."`login` = '".$Value['xurl']."' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            if(strpos($Value['programme'],'URL')===false) {
                $sqlquery=$sqlquery."`aktiv` = '0'";
            } else {
                $sqlquery=$sqlquery."`aktiv` = '1'";
            }
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=18');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'rdesktop')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '2' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            
                
            
                $sqlquery=$sqlquery."`aktiv` = '1'";
            
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=2');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'telnet')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '3' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            
                $sqlquery=$sqlquery."`aktiv` = '1'";
            
            
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=3');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'vnc_lx')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '6' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=6');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'http')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '7' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=7');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'mnf')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '8' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=8');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'ssh')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '9' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=9');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'https')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '10' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=10');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'ultravnc')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '12' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=12');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'irdesktop')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '13' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=13');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'TeraTerm')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '14' ,";
            $sqlquery=$sqlquery."`login` = '' ,";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=14');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
        if(!(strpos($Value['programme'],'gdc232')===false))
        {   
            $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
            $sqlquery=$sqlquery."`geraete_id` = '".$Value['id']."' ,";
            $sqlquery=$sqlquery."`programm_id` = '19' ,";
            $sqlquery=$sqlquery."`login` = '".$Value['xurl']."',";
            $sqlquery=$sqlquery."`passwort` = '' ,";
            $sqlquery=$sqlquery."`bemerkung` = '' ,";
            $sqlquery=$sqlquery."`aktiv` = '1'";
            $test=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.$tabelle.'` WHERE geraete_id='.$Value["id"].' AND programm_id=19');
            if($test==FALSE)
            {
                $zwischenspeicher=$objMySQL->Query($sqlquery); 
                if($zwischenspeicher!==FALSE)
                {
                    echo "<br>".$sqlquery;
                }
            }
        }
    }
    // Hier wird das neue Programmfeld erzeugt.
    $sql = "INSERT INTO `dokuit3`.`programme` SET `name` = 'lokalerLogin', `url` = '', `bemerkung` = 'Lokaler Login', `id`='20';";
    $objMySQL->Query($sql);
    $sql = "INSERT INTO `dokuit3`.`programme` SET `name` = 'domaenenLogin', `url` = '', `bemerkung` = 'Domänen Login', `id`='21';"; 
    $objMySQL->Query($sql);
    // Hier wird ein IPv4 Feld und ein Feld für ein Zeitstempel erzeugt.
    $sql = "ALTER TABLE `geraete` ADD `ipv4` VARCHAR( 17 ) NULL AFTER `adresse` ";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `geraete` ADD `dnstimestamp` VARCHAR( 12 ) NULL AFTER `ipv4` ";
    $objMySQL->Query($sql);
    // Hier wird noch ein Feld für Produktnummern erzeugt.
    $sql = "ALTER TABLE `geraete`  ADD `produktnummer` VARCHAR(20) NULL AFTER `sn`";
    $objMySQL->Query($sql);
    
    
    
    // Das ADD FULLTEXT fügt einen Volltextindize hinzu
    $sql = "ALTER TABLE `geraete` ADD FULLTEXT(`name`,`system`,`produktnummer`,`pc`,`benutzer`)";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `dokumente` ADD FULLTEXT(`name`,bemerkung)";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `zugangsdaten` ADD FULLTEXT(`titel`,`zusatz`)";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `bilder` ADD FULLTEXT(`name`,bemerkung)";
    $objMySQL->Query($sql);
    
    // Hier zwei spalten um die Löschaktionen kontrolliert ablaufen zu lassen
    // Das eine Feld ist ein boolisches. Hier soll gespeichert werden ob das gerät zur löschung markiert ist oder nicht
    // In dem zweiten soll ein Timestamp gespeichert werden, sobald auf löschen geklickt wird.
    $sql = "ALTER TABLE `geraete`  ADD `loeschen` TINYINT(1) NOT NULL DEFAULT '1',  ADD `loeschentime` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.'";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `geraete_login`  ADD `loeschen` TINYINT(1) NOT NULL DEFAULT '1',  ADD `loeschentime` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.'";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `bilder`  ADD `loeschen` TINYINT(1) NOT NULL DEFAULT '1',  ADD `loeschentime` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.'";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `zugangsdaten`  ADD `loeschen` TINYINT(1) NOT NULL DEFAULT '1',  ADD `loeschentime` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.'";
    $objMySQL->Query($sql);
    $sql = "ALTER TABLE `dokumente`  ADD `loeschen` TINYINT(1) NOT NULL DEFAULT '1',  ADD `loeschentime` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.'";
    $objMySQL->Query($sql);
    
    // --------Benutzerverwaltung ANFANG ---------------//
    $sql = "CREATE TABLE `dokuit3`.`benutzer` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `benutzername` VARCHAR(30) NOT NULL, `einstellung_dns` VARCHAR(3) NOT NULL DEFAULT 'ip') ENGINE = MyISAM;";
    $objMySQL->Query($sql);
    
    $sql = "CREATE TABLE `dokuit3`.`benutzer_kunden_einstellung` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `benutzerid` INT NOT NULL, `kundenid` INT NOT NULL DEFAULT '1', `sichtbar` TINYINT(1) NOT NULL DEFAULT '1', PRIMARY KEY (`id`)) ENGINE = MyISAM COMMENT = 'Zum Speichern, ob ein Kunde bei einem bestimmten Benutzer angezeigt werden kann';";
    $objMySQL->Query($sql);
    
    $sql = "ALTER TABLE `benutzer`  ADD `allekunden_sichtbar` VARCHAR(5) NOT NULL DEFAULT 'FALSE' AFTER `einstellung_dns`";
    $objMySQL->Query($sql);
    
    $sql = "ALTER TABLE `benutzer`  ADD `allegeraete_sichtbar` VARCHAR(5) NOT NULL DEFAULT 'FALSE'";
    $objMySQL->Query($sql);
    // --------Benutzerverwaltung ENDE ---------------//
    $daten=$objMySQL->QueryArray('Select * from `'.DB_DATABASE.'`.`'.TBL_PROGRAMME.'` ');
    foreach($daten as $Value)
    {
        $ausgabe=$Value["url"];
        $ausgabe=preg_replace('/{tv_id}/i','{geraete_login}',$ausgabe);
        $ausgabe=preg_replace('/{tv_pwd}/i','{geraete_pw}',$ausgabe);
        //$ausgabe=preg_replace('/-tvid=\\\"{geraete_login}\\\"/i','',$ausgabe);
        $ausgabe=preg_replace('/{xurl}/i','{geraete_login}',$ausgabe);
        $ausgabe=preg_replace('/{vncpasswort}/i','{geraete_pw}',$ausgabe);
        $ausgabe=preg_replace('/{ftplogin}/i','{geraete_login}',$ausgabe);
        $ausgabe=preg_replace('/{ftppasswort}/i','{geraete_pw}',$ausgabe);
        $ausgabe=preg_replace('/{login}/i','{geraete_login}',$ausgabe);
        $ausgabe=preg_replace('/{passwort}/i','{geraete_pw}',$ausgabe);
        $ausgabe = mysql_real_escape_string($ausgabe);
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_PROGRAMME."` SET ";
        
        $sql = $sql." `url`='".$ausgabe."' WHERE id=".$Value['id'];
        echo "<br>".$sql;
        $objMySQL->Query($sql);
    }
    include('dnsaufloesung.php');
    /* 
    Benutzerverwaltung: 
    Die Benutzer sollen, falls sie nicht schon in der Datenbank stehn, in eine Datenbank eingetragen werden.
    In dieser Tabelle steht der Benutzername und eine eindeutige id (Primärkey).
    Des Weiteren werden in diese Tabelle noch einmalige Einstellungen eingetragen, die pro Benutzer gesetzt werden können. (z.B.: OP ip oder DNS name angezeigt wird.)
    table benutzer: id, name, einstellung_dns, einstellung_kunden
    Soll eine Einstellung pro kunde und pro benutzer gesetzt werden können, wird eine "zwischentabelle" erstellt (benutzerid, kundenid, zustand)
    */
?>
<br>Hier ist das ende
</body>