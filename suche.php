<span id="suche"> Es wird gesucht....</span>
<?
    //error_reporting(E_ALL);
    //ini_set('display_errors', TRUE);
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
   // Verarbeitung der Übergeben Variablen
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
    if(isset($_POST['suchfeld'])&&!empty($_POST['suchfeld'])) {
        $mode['suche']=$_POST['suchfeld'];
        $temp = explode(" ",$mode['suche']);
        $mode['suche']="";
        foreach( $temp as $key =>$value){
            $mode['suche'] = $mode['suche']." +".$temp[$key];
        }
        $mode['suche'] = $mode['suche'].'*';  
    }
    if(isset($_POST['lokal_suchen'])&&!empty($_POST['lokal_suchen'])) {
       $mode['lokal_suchen']=true;
    }else {
        $mode['lokal_suchen']=false;
    }
    
    // Überprüfung ob Haken für lokale Suche gesetzt ist. Wenn ja, wird eine Session Variable gesetzt und es wird in die Benutzerdatenbank geschrieben.
    
    if($mode['lokal_suchen']){
        $_SESSION['lokal_suchen']='yes';
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BENUTZER."` SET lokal_suchen='yes' WHERE id=".$_SESSION['nutzerid']."";
    } else {
        $_SESSION['lokal_suchen']='no';
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BENUTZER."` SET lokal_suchen='no' WHERE id=".$_SESSION['nutzerid']."";
    }
    $objMySQL->Query($sql);
    //echo $sql."<br>";
    
    // Ende der Lokale Suche Überprüfung
    
    
    if(!empty($mode['suchfeld']))
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
         echo "<br><br>Suche Abgeschlossen. ";
        
        $time_stop=microtime(true);
        $time_used=$time_stop-$time_start;
        echo "<br>Die Suchanfrage wurde in ".round($time_used,2)." Sekunden bearbeitet. ";
    }else {
        echo '<h1 style="font-weight:bold;color:rgb(153,0,0);font-size:16pt;margin-top:20px;margin-left:20px;">Bitte geben sie einen Suchtext ein</h1>';
        $_SESSION['device_type']=1;
        $_SESSION['page']=$arrTopmenu[1]['file'];
    }
    echo " <br><br>Erläuterung: <br>Es kann bei den Geräten(Server, Computer, Durcker, Netzwerk) in den Feldern: <br><b>Name, Bemerkung, Seriennummer, Produktnummer, PC-Typ, Geräte-Typ</b> und <b>Benutzer</b> gesucht werden.";
    echo "<br>Bei den Restlichen Punkten (Dokumente, Zugänge, Bilder) können die Felder <b>Name</b> und <b>Bemerkung</b> durchsucht werden";
    echo "<br>Groß- und Kleinschreibung werden sind nicht relevant.";

?>
<script type="text/javascript">
document.getElementById('suche').style.visibility='hidden';
</script>