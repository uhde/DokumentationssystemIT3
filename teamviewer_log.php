<?php
// In diesem Script wird der Teamviewer log aus appdata in seine Einzelteile zerlegt und in eine Datenbank eingetragen.
$logzeile = "216541686                       29-01-2013 13:40:11             29-01-2013 14:54:33             grueninger                      RemoteControl                   {EF6362C2-8AC6-461F-A566-418BEF30E1EE}";
$logteile = explode(" ",$logzeile);
foreach($logteile as $temp)
{
    echo $temp."<br>";
}

?>