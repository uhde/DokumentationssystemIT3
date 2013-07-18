<?php
// In diesem Script wird der Teamviewer log aus appdata in seine Einzelteile zerlegt und in eine Datenbank eingetragen.
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
    echo "----------------<br>";
}
?>