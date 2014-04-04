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
    
    $sql = "ALTER TABLE  `geraete` ADD FULLTEXT (`software`)";
    $objMySQL->Query($sql);
    
    echo "Scriptende";
?>
</body>
</html>