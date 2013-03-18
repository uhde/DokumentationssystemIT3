<?
// Ist String eine IP
function isIP($string) {
	if (eregi('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$string)) {
		return true;
	}else{
		return false;
	}
}

// IP über Hostname ermitteln  (NICHT VERWENDEN!!!)
function getAddrByHost($host, $timeout = 3) {
   $query = `nslookup -timeout=$timeout -retry=1 $host`;
	if(preg_match('/\nAddress: (.*)\n/', $query, $matches))
	return trim($matches[1]);
   return $host;
}

// DNS-Abfrage für Hostname
function fnGetIP($name) {
	$ip="";
	if ($ip=="" and file_exists("/usr/bin/dig")) {
		exec("/usr/bin/dig $name A +short",$arrIP);
	//// !!!!!!!!!!!!! Array durchlaufen und IP suchen
		$ip=$arrIP[0];
		if (!eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}",$ip)) $ip="";
	}
	if ($ip=="") {
		$ip=$name;
	}
	return $ip;
}

// IP-Fomat: xxx.xxx.xxx.xxx
function IPtoString($string){
	if (isIP($string)) {
		$arrIP=explode('.',$string);
		return str_repeat('0',3-strlen($arrIP[0])).$arrIP[0].'.'.str_repeat('0',3-strlen($arrIP[1])).$arrIP[1].'.'.str_repeat('0',3-strlen($arrIP[2])).$arrIP[2].'.'.str_repeat('0',3-strlen($arrIP[3])).$arrIP[3];
	}else{
		return FALSE;
	}
}

// IP-Fomat: xxx.xxx.xxx.xxx
function StringtoIP($string){
	if (isIP($string)) {
		$arrIP=explode('.',$string);
		return (int)$arrIP[0].'.'.(int)$arrIP[1].'.'.(int)$arrIP[2].'.'.(int)$arrIP[3];
	}else{
		return FALSE;
	}
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
    WHERE '.TBL_KUNDEN.'.id='.TBL_GERAETE.'.kunde AND geraete_id='.$id.' AND programm_id='.TBL_PROGRAMME.'.id AND '.TBL_GERAETE.'.id='.$id.'';
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
CREATE TABLE `dokuit3`.`geraete_login` (
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