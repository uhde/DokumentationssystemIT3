<span id="suche"> Es wird gesucht....</span>
<?
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    //if($_GET["mode"]!="inc")
    //session_start();
    require_once('include/config.inc.php');
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    //$objTemplate=new Template("layout/suche.lay.php");

    $Daten[1]['kunde']=$_SESSION['knd_id'];
    $Daten[1]['kategorie']=$_SESSION['device_type'];
   
   foreach($_GET as $key=>$value) 
    { 
        //echo $key." -> ".$value." get<br>"; 
        $mode[$key]=$value;
    } 
    foreach($_POST as $key=>$value) 
    {
        //echo $key." -> ".$value." post<br>"; 
        $mode[$key]=$value;
    }
    if(!empty($mode['suche']))
    {
        $time_start=microtime(true);
        //$mode['suche']=$_POST['suchfeld'];
        $objTemplate=new Template("layout/geraete_general.lay.php");
        include('include/geraete.inc.php'); 
        echo '<div id="topmenuline">&nbsp;</div>';
        include('dokumente.php');
        echo '<div id="topmenuline">&nbsp;</div>';
        include('zugaenge.php');
        
        // name`,`system`,`produktnummer`,`pc`,`benutzer`
         echo "<br><br>Suche Abgeschlossen. <br><br>";
        echo " Erläuterung: Es kann bei den Geräten in den Feldern: Name, Produktnummer, PC-Typ, Geräte-Typ und Benutzer gesucht werden.";
        echo "<br>Bei den Restlichen Punkten (Dokumente, Zugänge, Bilder) können die Felder Name und Bemerkung durchsucht werden";

        $time_stop=microtime(true);
        $time_used=$time_stop-$time_start;
        echo "<br>Die Suchanfrage wurde in ".$time_used." Sekunden bearbeitet. ";
    }else {
        echo "Bitte geben sie einen Suchtext ein";
        $_SESSION['device_type']=1;
        $_SESSION['page']=$arrTopmenu[1]['file'];
    }
?>
<script type="text/javascript">
document.getElementById('suche').style.visibility='hidden';
</script>