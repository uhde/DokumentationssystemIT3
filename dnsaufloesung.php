
<?php
error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
//if($_GET["mode"]!="inc")

    require_once('include/config.inc.php');
    
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");

    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    //echo "Bitte Warten.....";
    $festeip=0;
    $guteip=0;
    $fehlerip=0;
    $daten = $objMySQL->QueryArray("SELECT id,adresse FROM ".TBL_GERAETE."",MYSQL_ASSOC);
    foreach($daten as $Value)
    {
    
        if (filter_var($Value['adresse'], FILTER_VALIDATE_IP)) {
            $sql = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE."` SET ";
            $sql = $sql." `ipv4` = '0' ";
            $sql = $sql."WHERE id=".$Value["id"];
            $objMySQL->Query($sql);
            //echo "<br>Feste IP = ".$Value['adresse']."<br>";
            $festeip++;
            //echo ":";
        } else {
            // Die Ip Adresse passend zum Hostnamen wird ermittelt, und in die Variable ip geschrieben
            $ip=gethostbyname($Value['adresse']);
            // Falls die Ip-Adresse mit dem DNS Name übereinstimmt, ist der DNS name eine feste IP-Adresse.
            // 
            if($Value['adresse']==$ip) {
                //echo "<br><h3>Fehler</h3>".$Value['adresse']." und die ip variable ist: ".$ip."<br>";
                $fehlerip++;
                
            } else {
                $timestamp=time();
                $sql = "UPDATE `".DB_DATABASE."`.`".TBL_GERAETE."` SET ";
                $sql = $sql." `ipv4` = '".$ip."', ";
                $sql = $sql." `dnstimestamp` = '".$timestamp."' ";
                $sql = $sql."WHERE id=".$Value["id"];
                //echo "<br>DNS name: ".$Value['adresse']." = ".$sql;
                //echo ".";
                $objMySQL->Query($sql);
                $guteip++;
            }
        }
    }
    echo "<br>Update der Adressen erfolgreich";
    echo "<br>Feste IPs = ".$festeip;
    echo "<br>Aufgelöste IPs = ".$guteip;
    echo "<br>Fehlerhafte IPs = ".$fehlerip;
    //if(isset($_SERVER['HTTP_REFERER'])){
        
    //} else {
    //    echo "<br>kein referer gesetzt";
    //}
    if(isset ($_GET["site"])&&!empty($_GET["site"]))
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
    }
?>
