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
    if(isset($_GET["format"])&&!empty($_GET["format"])) {
        $format = $_GET['format'];
    } else {
        $format = "csv";
    }
    
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
    
    if($format == "csv")
    {
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
    }else {
        echo '<table border="1" width="100%">';
        foreach($arr_data as $zeile)
        {   
            echo "<tr>";
            $zeile["start_zeit"]=date("d.m.Y H:i:s",$zeile["start_zeit"]);
            $zeile["end_zeit"]=date("d.m.Y H:i:s",$zeile["end_zeit"]);
            $zeile["dauer"]=intval($zeile["dauer"]/60).":".$zeile['dauer']%60;
            unset($zeile['kunde']);
            foreach($zeile as $eintrag)
            {
                echo '<td>'.$eintrag.'</td>';
            }
            echo "</tr>";
        }
        echo "</table";
    }
    
?>