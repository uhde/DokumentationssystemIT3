<?php

/**
 * Auslesen der IP-Adressen aller Geräte
 *
 * @version $Id$
 * @copyright 2010
 */

// Benötigte Dateien includen
require_once("include/config.inc.php");
require_once("include/mysql.class.php");
require_once('include/functions.inc.php');

// DB-Connect
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
	echo $objMySQL->Error();
	$objMySQL->Kill();
}

// Alle Geräte auslesen
$arrData=$objMySQL->QueryArray('SELECT id,adresse FROM '.TBL_GERAETE,MYSQL_ASSOC);

// IPs ermitteln und DB updaten
if ($objMySQL->RowCount()>0) {
	foreach ($arrData as $Data){
		// Falls Adresse vorhanden IP ermitteln
		if (!empty($Data['adresse'])) {
			$IP=fnGetIP($Data['adresse']);
			if (isIP($IP)===FALSE) {
				$IP=NULL;
			}else{
				$IP=IPtoString($IP);
			};
			ob_flush();flush();
			$Filter['id']=MySQL::SQLValue($Data['id']);
			$Update['ip_adresse']=MySQL::SQLValue($IP);
			$Update['ts_ip_adresse']=MySQL::SQLValue(mktime());
			$objMySQL->UpdateRows(TBL_GERAETE,$Update ,$Filter );
			if ($objMySQL->Error()) {
				//echo 'Update ID '.$Data['id'].': Update Error<br />';
			}else{
				//echo 'Updated ID '.$Data['id'].' with IP '.$IP.'<br />';
			}
		}
	}
	echo date('d.m.Y, H:i').' Uhr: IP-Erstellung beendet...';
}

?>