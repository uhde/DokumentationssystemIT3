<?php
// In diesem Script wird der Teamviewer log aus appdata in seine Einzelteile zerlegt und in eine Datenbank eingetragen.
$logzeile = "216541686                       29-01-2013 13:40:11             29-01-2013 14:54:33             grueninger                      RemoteControl                   {EF6362C2-8AC6-461F-A566-418BEF30E1EE}";
$logteile =  preg_split("/[\s,]+/",$logzeile);
foreach($logteile as $temp)
{
    echo $temp."<br>";
}
$datum1 = explode('-',$logteile[1]);
$uhrzeit1 = explode(':',$logteile[2]);
echo "d:".$datum1[0]." month:".$datum1[1]." year:".$datum1[2].'<br>';
echo "h:".$uhrzeit1[0]."   m:".$uhrzeit1[1]."  s:".$uhrzeit1[2];

?>