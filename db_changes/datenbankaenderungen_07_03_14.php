<html><head></head>
<body>
working....
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
    
    $sql = "ALTER TABLE `geraete` ADD FULLTEXT (`sn`)";
    $sql2 = "ALTER TABLE `geraete` ADD FULLTEXT (`produktnummer`)";
    $objMySQL->Query($sql);
    $objMySQL->Query($sql2);
    
    echo "Scriptende";
?>
</body>
</html>