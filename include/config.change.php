<?
// DB-Server
define('DB_SERVER','localhost');
define('DB_USER','');
define('DB_PASSWORD','');
define('DB_DATABASE','dokuit3');

// DB-Tabellen
define('TBL_KUNDEN','kunden');
define('TBL_GERAETE','geraete');
define('TBL_ZUGAENGE','zugangsdaten');
define('TBL_GERAETE_LOGIN','geraete_login');
define('TBL_PROGRAMME','programme');
define('TBL_BILDER','bilder');
define('TBL_DOKUMENTE','dokumente');
define('TBL_BKE','benutzer_kunden_einstellung');
define('TBL_BENUTZER','benutzer');

// Menü setzen
$arrTopmenu[1]['title']='Server';
$arrTopmenu[1]['file']='server';

$arrTopmenu[2]['title']='Computer';
$arrTopmenu[2]['file']='computer';

$arrTopmenu[3]['title']='Drucker';
$arrTopmenu[3]['file']='drucker';

$arrTopmenu[4]['title']='Netzwerk';
$arrTopmenu[4]['file']='netzwerk';

$arrTopmenu[5]['title']='Dokumente';
$arrTopmenu[5]['file']='dokumente';

$arrTopmenu[6]['title']='Bilder';
$arrTopmenu[6]['file']='bilder';

$arrTopmenu[7]['title']='Zugänge';
$arrTopmenu[7]['file']='zugaenge';



?>