<?php
// Dieses Script hat den Zweck die Logdaten auszugeben


//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
    require_once('../include/config.inc.php');
    include_once("../include/mysql.class.php");
    include_once("../include/template.class.php");
    include_once("../include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
   }

    $kunde = $_GET["kunde"];
    $starttime = $_GET["starttime"];
    $endtime = $_GET["endtime"];
    
    $sql = "SELECT * FROM fernwartungs_log WHERE ";
    $sql = $sql."kunde='".$kunde."'";
    if(!empty($endtime))
        $sql = $sql." AND start_zeit<'".$endtime."' ";
    if(!empty($starttime))
        $sql = " AND ".$sql."start_zeit>'".$starttime."'";
    $sql = $sql.";";
    //echo "sql: ".$sql."<br>";

    $arr_data =  $objMySQL->QueryArray($sql,MYSQL_ASSOC);
        //echo '<pre>';
        //print_r($arr_data);
        //echo  '</pre>'; 
  
    foreach($arr_data as $zeile)
    {
        $zeile["start_zeit"]=date("d.m.Y H:i:s",$zeile["start_zeit"]);
        $zeile["end_zeit"]=date("d.m.Y H:i:s",$zeile["end_zeit"]);
        unset($zeile['kunde']);
        foreach($zeile as $eintrag)
        {
            echo '"'.$eintrag.'";';
        }
        echo "<br>";
    }
    
?>