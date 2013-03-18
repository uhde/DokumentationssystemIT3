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
$arrData=$objMySQL->QueryArray('SELECT * FROM '.TBL_GERAETE,MYSQL_ASSOC);

// IPs ermitteln und DB updaten
if ($objMySQL->RowCount()>0) {
	foreach ($arrData as $Data){
		// VNC
		if (!empty($Data['vncpasswort'])) {
			$Update['titel']=MySQL::SQLValue('VNC');
			$Update['login']=MySQL::SQLValue(NULL);
			$Update['pwd']=MySQL::SQLValue($Data['vncpasswort']);
			$Update['bemerkung']=MySQL::SQLValue('Passwort für VNC');
			$Update['geraete_id']=MySQL::SQLValue($Data['id']);
			$objMySQL->InsertRow(TBL_GERAETE_LOGIN,$Update );
			unset($Update);
		}
		// Teamviewer
		if (!empty($Data['tv_id'])) {
			$Update['titel']=MySQL::SQLValue('Teamviewer');
			$Update['login']=MySQL::SQLValue($Data['tv_id']);
			$Update['pwd']=MySQL::SQLValue($Data['tv_pwd']);
			$Update['bemerkung']=MySQL::SQLValue('Login für Teamviewer');
			$Update['geraete_id']=MySQL::SQLValue($Data['id']);
			$objMySQL->InsertRow(TBL_GERAETE_LOGIN,$Update );
			unset($Update);
		}
		// FTP
		if (!empty($Data['ftplogin'])) {
			$Update['titel']=MySQL::SQLValue('FTP');
			$Update['login']=MySQL::SQLValue($Data['ftplogin']);
			$Update['bemerkung']=MySQL::SQLValue('Login für FTP');
			$Update['geraete_id']=MySQL::SQLValue($Data['id']);
			$objMySQL->InsertRow(TBL_GERAETE_LOGIN,$Update );
			unset($Update);
		}
		// Login
		if (!empty($Data['login'])) {
			$Update['titel']=MySQL::SQLValue('System');
			$Update['login']=MySQL::SQLValue($Data['login']);
			$Update['pwd']=MySQL::SQLValue($Data['passwort']);
			$Update['bemerkung']=MySQL::SQLValue('Admin-Login für System');
			$Update['geraete_id']=MySQL::SQLValue($Data['id']);
			$objMySQL->InsertRow(TBL_GERAETE_LOGIN,$Update );
			unset($Update);
		}

	}
	echo date('d.m.Y, H:i').' Uhr: Migration beendet...';
}

?>