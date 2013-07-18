<?php
// In diesem Script wird der Teamviewer log aus appdata in seine Einzelteile zerlegt und in eine Datenbank eingetragen.
    require_once('include/config.inc.php');
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    //$logzeile = "216541686                       29-01-2013 13:40:11             29-01-2013 14:54:33             grueninger                      RemoteControl                   {EF6362C2-8AC6-461F-A566-418BEF30E1EE}";
    $log = file("teamviewer_log/test1");
    foreach( $log as $logzeile ) 
    {
        // Hier wird eine Zeile des Logs aufgesplittet. Struktur: 0=tv-id 1=datum1 2=uhrzeit1
        $logteile =  preg_split("/[\s,]+/",$logzeile);
        /*foreach($logteile as $temp)
        {
            echo $temp."<br>";
        }*/
        $datum1 = explode('-',$logteile[1]);
        $uhrzeit1 = explode(':',$logteile[2]);
        //echo "d:".$datum1[0]." month:".$datum1[1]." year:".$datum1[2].'<br>';
        //echo "h:".$uhrzeit1[0]."   m:".$uhrzeit1[1]."  s:".$uhrzeit1[2].'<br>';
        $timestamp_anfang = mktime($uhrzeit1[0],$uhrzeit1[1],$uhrzeit1[2],$datum1[1],$datum1[0],$datum1[2]);
        echo $timestamp_anfang.'<br>';
        //echo "<br>".date(DATE_RFC822,$timestamp_anfang);
        $datum2 = explode('-',$logteile[3]);
        $uhrzeit2 = explode(':',$logteile[4]);
        $timestamp_ende = mktime($uhrzeit2[0],$uhrzeit2[1],$uhrzeit2[2],$datum2[1],$datum2[0],$datum2[2]);
        echo $timestamp_ende.'<br>';
        $benutzer = $logteile[5];
        $teamviewer_id = $logteile[0];
        echo "----------------<br>";
        
        $dauer = $timestamp_ende - $timestamp_anfang;
        $sql = 'SELECT * FROM '.DB_DATABASE.'.'.TBL_TEAMVIEWER_LOG.' WHERE id = '.$teamviewer_id;
        $test = $objMySQL->Query($sql);
        if(mysql_num_rows($sql
       
        
    }
?>