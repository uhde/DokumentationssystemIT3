<?php
require('../include/config.inc.php');
include("../include/mysql.class.php");
include("../include/template.class.php");
include("../include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    $sql = "CREATE TABLE IF NOT EXISTS `teamviewer_log` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `teamviewer_id` int(11) NOT NULL,
      `start_zeit` int(11) NOT NULL,
      `end_zeit` int(11) NOT NULL,
      `benutzer` varchar(20) NOT NULL,
      `kunde` int(11) NOT NULL,
      `dauer` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
    
    $objMySQL->Query($sql);
    echo "Scriptende";
?>