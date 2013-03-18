<html>
<head>


<?php
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
    $objMySQL = new MySQL();
    if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
       echo $objMySQL->Error();
       $objMySQL->Kill();
    }
    
    
    $tabelle="";
    
    // Damit werden die Get Variablen geholt, und in das Array "mode" gespeichert.
    foreach($_GET as $key=>$value) 
    { 
        //echo $key." -> ".$value."<br>"; 
        $mode[$key]=$value;
    }     
    // Damit werden die Post Variablen geholt, und in das Array "daten" gespeichert.
    echo "<br>";
    foreach($_POST as $key=>$value) 
    { 
        // Hier werden dann die übrigen Daten ausgelesen, und in ein Array geschrieben.
        $daten[$key]=mysql_real_escape_string($value);
        //echo $key." -> ".$value."<br>";
    }

    if ($mode["name"]=="dokumente")
    {
        $tabelle=TBL_DOKUMENTE;

    }
    if ($mode["name"]=="zugaenge")
    {
        $tabelle=TBL_ZUGAENGE;
    }
    if ($mode["name"]=="prog")
    {
        $tabelle=TBL_PROGRAMME;
    }
?>
</head>


<body style="margin:0;padding:0;">
<?php

    //echo '<a href="geraeteedit.php?kunde='.$mode["kunde"].'&id='.$mode["id"].'&prog_add='.$mode["prog_add"].'&mode=edit"> testtasdasdkhjg</a>';
    
    //---------------- Falls nur Werte geändert werden sollen. $tabelle muss gesetzt sein. ------------------- 
    
    
    if ($mode["mode"]=="edit")
    {
        $firstrun=true;
        $sqlquery="UPDATE `".DB_DATABASE."`.`".$tabelle."` SET ";
        foreach($daten as $key=>$value)
        {
            if ($firstrun==true)
            {
                $sqlquery=$sqlquery."`".$key."` = '".$value."' ";
                $firstrun=false;
            }
            else{
                $sqlquery=$sqlquery.", `".$key."` = '".$value."' ";
            }
        }
        $sqlquery=$sqlquery." WHERE `id` = '".$mode['id']."' ";
       // echo "<h1>Hier ist der SQL-Update Befehl.</h1><br>".$sqlquery;
        $objMySQL->Query($sqlquery);
        echo "Eintrag gespeichert <br><br>";
    }
        
    
    //---------------- Falls ein neuer Eintrag gemacht soll. --------------------
    if ($mode["mode"]=="create")
    {
        $firstrun=true;
        $sqlquery="INSERT INTO `".DB_DATABASE."`.`".$tabelle."` SET ";
        foreach($daten as $key=>$value)
        {
            if ($firstrun==true)
            {
                $sqlquery=$sqlquery."`".$key."` = '".$value."' ";
                $firstrun=false;
            }
            else{
                $sqlquery=$sqlquery.", `".$key."` = '".$value."' ";
            }
        }
        if ($mode["name"]!="prog")
        {
            $sqlquery=$sqlquery.", `kunde` = '".$mode['kunde']."' ";
        }
        
        //echo "<h1>Hier ist der SQL-Update Befehl.</h1><br>".$sqlquery;
        $objMySQL->Query($sqlquery);
        echo "Eintrag gespeichert <br><br>";
    }
    //---------------- Falls ein Eintrag gelöscht werden soll. --------------------
    if ($mode["mode"]=='delete') {
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".$tabelle."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `id` = ".$mode['id'];
        //$sqlquery="DELETE FROM `".DB_DATABASE."`.`".$tabelle."` WHERE `".$tabelle."`.`id` = ".$mode['id'];
        $objMySQL->Query($sqlquery);
        echo "Der Eintrag wurde gelöscht.";
    }
    
  
?>
    <!--<br><br>Die Daten wurden gespeichert.<br><br>-->
    <br>
    <div style="height:33px;width:200px;">
        <div style="position:relative;top:4px;left:90%;">
            <input type="button" value="Schließen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide(window.parent.location.reload(true)));" class="button1">
        </div>
    </div>
    

</body>
</html>