<html>
<head>
</head>
<body>
test
<?php
echo "test2";
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
//db_umstellungsfix
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    echo "test3";
    
    $sql = 'Select * from `'.DB_DATABASE.'`.`'.TBL_GERAETE.'` ';
    echo $sql;
    //Mit einer schleife durchlaufen, und jede Variable abrüfen, ob sie unter 30 zeichen lang ist
    //strlen(variable) gibt die stringlänge zurück
    $arrData=$objMySQL->QueryArray($sql,MYSQL_ASSOC);
    
    echo $arrData;
    $i=0;
    
    foreach($arrData as $Value)
    {
        // die login Variable durfte 30 zeichen lang sein, die Passwort 40 Zeichen lang
        if(strlen($Value['login'])>30)
        {
            echo "<br>".$Value['name']." ist in der Variable login zu lang:".$Value['login'];
            $i++;
        }
        if(strlen($Value['passwort'])>40)
        {
            echo "<br>".$Value['name']." ist in der Variable passwort zu lang:".$Value['passwort'];
            $i++;
        }
        if(strlen($Value['ftplogin'])>30)
        {
            echo "<br>".$Value['name']." ist in der Variable ftplogin zu lang:".$Value['ftplogin'];
            $i++;
        }
        if(strlen($Value['ftppasswort'])>40)
        {
            echo "<br>".$Value['name']." ist in der Variable ftppasswort zu lang:".$Value['ftppasswort'];
            $i++;
        }
        if(strlen($Value['vncpasswort'])>40)
        {
            echo "<br>".$Value['name']." ist in der Variable vncpasswort zu lang:".$Value['vncpasswort'];
            $i++;
        }
        if(strlen($Value['xurl'])>30)
        {
            echo "<br>".$Value['name']." ist in der Variable xurl zu lang:".$Value['xurl'];
            $i++;
        }
        
    }
    echo "<br><br> Es sind insgesamt ".$i." Fehler gefunden  worden.";
    
    ?>
    
</body>
</html>
    