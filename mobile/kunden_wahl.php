<?
/*
    Benutzt mobile_kunden_wahl.lay.php als Layout, um die gesamte Linke Kundenbox darzustellen.

*/
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
*/
session_start();
require_once('../include/config.inc.php');
include_once("../include/mysql.class.php");
include_once("../include/template.class.php");
include_once("../include/functions.inc.php");
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   echo $objMySQL->Error();
   $objMySQL->Kill();
}

$objTemplate=new Template("../layout/mobile_kunden_wahl.lay.php");

$sqldata = $objMySQL->QueryArray('SELECT * FROM '.TBL_KUNDEN.' ORDER BY name');


    //zeigt die Überschrift "Kunden" an, nötig für Tabellenstruktur
    $objTemplate->Display('Header');
    $Count=0;
    foreach ( $sqldata as $value) {
        
        $objTemplate->AssignArray($value);
        $objTemplate->Assign('LineClass',$Count%2);
        $objTemplate->Display('Main');
        $Count++;
        
        $objTemplate->ClearAssign();
        
    }
    $objTemplate->Display('Footer');

unset($objTemplate);

?>