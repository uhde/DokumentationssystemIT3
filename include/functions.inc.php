<?


// Alle Logins eines Gerätes ermitteln
function GetGeraeteLogin($objMySQL,$id,$loeschen) {
    $sqlquery='SELECT '.TBL_GERAETE.'.ipv4 AS geraete_ipv4,  '.TBL_GERAETE.'.adresse AS geraete_adresse, '.TBL_GERAETE_LOGIN.'.geraete_id AS geraete_id, '.TBL_PROGRAMME.'.id AS programm_id, 
    '.TBL_GERAETE_LOGIN.'.login AS geraete_login,'.TBL_GERAETE_LOGIN.'.passwort AS geraete_pw, '.TBL_PROGRAMME.'.bemerkung FROM 
        '.TBL_GERAETE.', '.TBL_GERAETE_LOGIN.', '.TBL_PROGRAMME.' 
        WHERE  '.TBL_GERAETE_LOGIN.'.loeschen='.$loeschen.' AND geraete_id='.$id.' AND programm_id='.TBL_PROGRAMME.'.id AND '.TBL_GERAETE.'.id=geraete_id ';
    $arrData=$objMySQL->QueryArray($sqlquery,MYSQL_ASSOC);
    if ($objMySQL->RowCount()>0) {
        return $arrData;
    }else{
        return $sqlquery;
    }
}
function GetGeraeteprogramme($objMySQL,$id) {
    $sql = 'SELECT '.TBL_GERAETE_LOGIN.'.login AS geraete_login, geraete_id, '.TBL_GERAETE_LOGIN.'.passwort AS geraete_pw, '.TBL_GERAETE_LOGIN.'.aktiv, '
    .TBL_PROGRAMME.'.bemerkung, '.TBL_PROGRAMME.'.url, '
    .TBL_KUNDEN.'.name AS kunden_name, '
    .TBL_GERAETE.'.name AS geraete_name, '.TBL_GERAETE.'.benutzer AS benutzer, '.TBL_GERAETE.'.adresse AS geraete_adresse, '.TBL_GERAETE.'.kunde AS geraete_kunde, '.TBL_GERAETE.'.ftpdir AS ftpdir
    FROM '.TBL_GERAETE_LOGIN.', '.TBL_PROGRAMME.', '.TBL_GERAETE.', '.TBL_KUNDEN.' 
    WHERE  '.TBL_GERAETE_LOGIN.'.`loeschen` =1 AND '.TBL_KUNDEN.'.id='.TBL_GERAETE.'.kunde AND geraete_id='.$id.' AND programm_id='.TBL_PROGRAMME.'.id AND '.TBL_GERAETE.'.id='.$id.'';
    $arrData=$objMySQL->QueryArray($sql,MYSQL_ASSOC);
    if ($objMySQL->RowCount()>0) {
        return $arrData;
    }else{
     // echo $sql."<br>";
        return $sql;
    }
}
function GetKundenName($objMySQL,$id) {
    $sql = "SELECT name FROM ".TBL_KUNDEN.' WHERE id='.$id.'';
    $arrData=$objMySQL->QuerySingleRowArray($sql,MYSQL_ASSOC);
    if ($objMySQL->RowCount()>0) {
        return $arrData["name"];
    }else{
     // echo $sql."<br>";
        return $sql;
    }
}

/* Geraete Tabelle kann mit 
CREATE TABLE `".DB_DATABASE."`.`geraete_login` (
`id` INT NOT NULL AUTO_INCREMENT ,
`geraete_id` INT NOT NULL ,
`programm_id` INT NOT NULL ,
`login` VARCHAR( 30 ) NOT NULL ,
`passwort` VARCHAR( 40 ) NULL ,
`aktiv` BOOLEAN NOT NULL ,
`bemerkung` TEXT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

erstellt werden*/

?>