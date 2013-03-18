Bitte warten....
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

    if(isset($_SESSION['ipordns'])&&$_SESSION['ipordns']=='ip'){
        $_SESSION['ipordns']='dns';
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BENUTZER."` SET einstellung_dns='dns' WHERE id=".$_SESSION['nutzerid']."";
    } else {
        $_SESSION['ipordns']='ip';
        $sql = "UPDATE `".DB_DATABASE."`.`".TBL_BENUTZER."` SET einstellung_dns='ip' WHERE id=".$_SESSION['nutzerid']."";
    }
    $objMySQL->Query($sql);
    
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
        echo "<a href=index.php> hier klicken um zurückzukommen </a>";
    }
?>


