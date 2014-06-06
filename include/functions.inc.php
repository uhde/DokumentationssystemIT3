<?

function link_klickbar_machen($text) {
//http://www.php-einfach.de/tuts_php_links.php
    //Aus http://url wird [URL]http://url[/URL]
    // aus \\\\\\\\ wird \\ (man muss wegen php das einmal escapen, und noch einmal wegen regxp)
    $urlsuch[]="/([a-z]:\\\\)([^\r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
    $urlsuch[]="/([^]_a-z0-9-=\"'\/])((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
    //$urlsuch[]="/^((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
    $urlreplace[]="\\3[URL]\\1\\2[/URL]";
    $urlreplace[]="\\1[URL]\\2\\4[/URL]";
    //$urlreplace[]="[URL]\\1\\3[/URL]";
    //Aus klaus@mustermann.de wird [EMAIL]klaus@mustermann.de [/EMAIL]
    $emailsuch[]="/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 
    $emailsuch[]="/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 
    $emailreplace[]="\\1[EMAIL]\\2[/EMAIL]";
    $emailreplace[]="[EMAIL]\\0[/EMAIL]";
    $text = preg_replace($urlsuch, $urlreplace, $text);
    //return $text; //Für Debug möglichkeiten
    if (strpos($text, "@"))
    {
    $text = preg_replace($emailsuch, $emailreplace, $text);
    }
    //Die URL's werden zu Links
    $text = preg_replace("/\[URL\]www.(.*?)\[\/URL\]/si", "<a target=\"_blank\" href=\"http://www.\\1\">www.\\1</a>", $text); 
    $text = preg_replace("/\[URL\](.*?)\[\/URL\]/si", "<a target=\"_blank\" href=\"\\1\">\\1</a>", $text); 
    $text = preg_replace("/\[URL=www.(.*?)\](.*?)\[\/URL\]/si", "<a target=\"_blank\" href=\"http://www.\\1\">\\2</a>", $text); 
    $text = preg_replace("/\[URL=(.*?)\](.*?)\[\/URL\]/si", "<a target=\"_blank\" href=\"\\1\">\\2</a>", $text); 
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
    WHERE geraete_id='.$id.' AND programm_id='.TBL_PROGRAMME.'.id AND '.TBL_GERAETE.'.id=geraete_id ';
    if($loeschen==1) {
        $sqlquery = $sqlquery.'AND '.TBL_GERAETE_LOGIN.'.loeschen='.$loeschen.' ';
    }
    $arrData=$objMySQL->QueryArray($sqlquery,MYSQL_ASSOC);
    return $sqlquery;
    if ($objMySQL->RowCount()>0) {
        return $arrData;
    }else{
        return $sqlquery;
    }
}
function GetGeraeteprogramme($objMySQL,$id) {
    $sql = 'SELECT '.TBL_GERAETE_LOGIN.'.login AS geraete_login, programm_id, geraete_id, '.TBL_GERAETE_LOGIN.'.passwort AS geraete_pw, '.TBL_GERAETE_LOGIN.'.aktiv, '
    .TBL_PROGRAMME.'.bemerkung, '.TBL_PROGRAMME.'.url, '
    .TBL_KUNDEN.'.name AS kunden_name, '.TBL_KUNDEN.'.dyndns_domain AS dyndns_domain, '
    .TBL_GERAETE.'.irdpport AS irdpport, '.TBL_GERAETE.'.name AS geraete_name, '.TBL_GERAETE.'.benutzer AS benutzer, '.TBL_GERAETE.'.adresse AS geraete_adresse, '.TBL_GERAETE.'.kunde AS geraete_kunde
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
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789@!$%&+#?ß";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

// Folgende Funktion erstellt eine Kundenliste für ein Drop Down Menü
function MakeKundenAuswahl($kunde_aktuell, $arr_kundendata)
{
    $objTemplate=new Template("layout/edit_geraete.lay.php");
    $tempstring = "";
    if (is_array($arr_kundendata))
    {
        $tempstring=$objTemplate->DisplayToString('kunden_liste_start');
        foreach ($arr_kundendata as $Value)
        {
            $objTemplate->AssignArray($Value);
            if($Value['id']==$kunde_aktuell)
            {
                $tempstring.=$objTemplate->DisplayToString('kunden_liste_selected');
            } else {
                $tempstring.=$objTemplate->DisplayToString('kunden_liste');
            }
        }
        $tempstring.=$objTemplate->DisplayToString('kunden_liste_end');
    }else {
        $tempstring = " ERROR: Die Kundenliste konnte nicht erstellt werden.";
    }
    return $tempstring;
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