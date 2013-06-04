<?

function link_klickbar_machen($text) {
//http://www.php-einfach.de/tuts_php_links.php
    //Aus http://url wird [URL]http://url[/URL]
    $urlsuch[]="/([^]_a-z0-9-=\"'\/])((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
    $urlsuch[]="/^((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
    $urlreplace[]="\\1[URL]\\2\\4[/URL]";
    $urlreplace[]="[URL]\\1\\3[/URL]";
    //Aus klaus@mustermann.de wird [EMAIL]klaus@mustermann.de [/EMAIL]
    $emailsuch[]="/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 
    $emailsuch[]="/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 
    $emailreplace[]="\\1[EMAIL]\\2[/EMAIL]";
    $emailreplace[]="[EMAIL]\\0[/EMAIL]";
    $text = preg_replace($urlsuch, $urlreplace, $text);
    if (strpos($text, "@"))
    {
    $text = preg_replace($emailsuch, $emailreplace, $text);
    }
    //Die URL's werden zu Links
    $text = preg_replace("/\[URL\]www.(.*?)\[\/URL\]/si", "<span style=\"color:red\"><a target=\"_blank\" href=\"http://www.\\1\">www.\\1</a></span>", $text); 
    $text = preg_replace("/\[URL\](.*?)\[\/URL\]/si", "<span style=\"color:red\"><a target=\"_blank\" href=\"\\1\">\\1</a></span>", $text); 
    $text = preg_replace("/\[URL=www.(.*?)\](.*?)\[\/URL\]/si", "<span style=\"color:red\"><a target=\"_blank\" href=\"http://www.\\1\">\\2</a></span>", $text); 
    $text = preg_replace("/\[URL=(.*?)\](.*?)\[\/URL\]/si", "<span style=\"color:red\"><a target=\"_blank\" href=\"\\1\">\\2</a></span>", $text); 
    //E-Mail Adressen werden zu links
    $text = preg_replace("/\[EMAIL\](.*?)\[\/EMAIL\]/si", "<a href=\"mailto:\\1\">\\1</a>", $text); 
    $text = preg_replace("/\[EMAIL=(.*?)\](.*?)\[\/EMAIL\]/si", "<a href=\"mailto:\\1\">\\2</a>", $text); 
    return $text;
}

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