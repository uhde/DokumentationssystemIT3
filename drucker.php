<?

$objTemplate=new Template("layout/geraete_general.lay.php");

// Bindet geraete.inc.php ein, in dem der Gro�teil der n�tigen Funktionen liegen soll.
// Diese Funktionen werden ausgelagert, da sie mehrmals ben�tigt werden, und Redundanz in diesem Fall 
// der Wartung und Fehlersuche entgegenstehen.
include("include/geraete.inc.php");

?>