<?php

    session_start() ;
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
 
    $sql = "SELECT * FROM ".TBL_BENUTZER." As be WHERE be.benutzername='".$_SERVER['PHP_AUTH_USER']."'";
    //echo $sql."<br>";
    $test = $objMySQL->QuerySingleRowArray($sql,MYSQL_ASSOC);
    if (is_array($test))
    {
        $_SESSION['ipordns']=$test["einstellung_dns"];
        $_SESSION['nutzerid']=$test["id"];
        $_SESSION['allekunden']=$test["allekunden_sichtbar"];
        $_SESSION['letzer_kunde']=$test["letzer_kunde"];
        // Hier noch nutzersichtbar id einfügen!!!
    } else {
        $sql = "INSERT INTO `".DB_DATABASE."`.`".TBL_BENUTZER."` SET ";
        $sql = $sql."`benutzername`='".$_SERVER['PHP_AUTH_USER']."', ";
        $sql = $sql."`einstellung_dns`='".$_SESSION['ipordns']."' ";
        //echo $sql;
        $objMySQL->Query($sql);
    }
    $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BENUTZER."` SET `letzer_kunde` = '".$_SESSION['knd_id']."' WHERE id=1";
    echo $sql;
    $objMySQL->Query($sql);
    unset($objMySQL);
    unset($test);
    unset($sql);
?>