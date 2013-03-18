<?php
    session_start() ;
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);

    require_once('../include/config.inc.php');
    
    include_once("../include/mysql.class.php");
    include_once("../include/template.class.php");
    include_once("../include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    foreach($_GET as $key=>$value) 
    { 
        //echo $key." -> ".$value."<br>"; 
        $mode[$key]=$value;
    } 

    $sql = "SELECT bke.id AS bkeid, sichtbar,kundenid, benutzerid FROM ".TBL_BKE." AS bke, ".TBL_BENUTZER." As be WHERE kundenid=".$mode['knd_id']." AND benutzerid=be.id AND be.benutzername='".$_SERVER['PHP_AUTH_USER']."'";
  //  $sql = "select * from benutzer";
    echo $sql."<br>";
    $test = $objMySQL->QuerySingleRowArray($sql,MYSQL_ASSOC);
    $tabelle = TBL_BKE;
    if (is_array($test))
    {
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".$tabelle."` SET ";
        echo $test["bkeid"]."<br>";
        if($test["sichtbar"]==1) {
            $sqlquery = $sqlquery." `sichtbar`='0'";
        } else {
            $sqlquery = $sqlquery." `sichtbar`='1'";
        }
        $sqlquery = $sqlquery." WHERE `id`='".$test["bkeid"]."'";
    } else {
        $sql = "SELECT id FROM ".TBL_BENUTZER." WHERE benutzername='".$_SERVER['PHP_AUTH_USER']."'";
        echo $sql."<br>";
        $nutzerid = $objMySQL->QuerySingleRowArray($sql,MYSQL_ASSOC);
        $sqlquery = "INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
        $sqlquery = $sqlquery." `sichtbar`='0', ";
        $sqlquery = $sqlquery." `benutzerid`='".$nutzerid["id"]."', ";
         $sqlquery = $sqlquery." `kundenid`='".$mode['knd_id']."'";
    }
     echo $sqlquery;
    $objMySQL->Query($sqlquery);
    
    if(isset ($_GET["site"]))
    {
        $seite = "http://".$_SERVER['SERVER_NAME'].$_GET["site"];
        echo '<meta http-equiv="refresh" content="0; URL="'.$seite.'">';
        echo "</head><body> ";
        echo "<br>".$seite."</body>";
        
        echo '  <script type="text/javascript">
                <!--
                document.location.href = "'.$seite.'"
                //-->
                </script> ';//
    } else {
        echo "<a href=../index.php> hier klicken um zurückzukommen</a>";
    }
   
?>