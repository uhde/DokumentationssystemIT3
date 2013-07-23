<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
    require_once('include/config.inc.php');
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");
    echo randompassword();
?>