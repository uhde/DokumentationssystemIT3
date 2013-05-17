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
        $mode[$key]=mysql_real_escape_string($value);
    }     
    // Damit werden die Post Variablen geholt, und in das Array "daten" gespeichert.

    foreach($_POST as $key=>$value) 
    { 
        // Hier werden dann die übrigen Daten ausgelesen, und in ein Array geschrieben.
        $daten[$key]=mysql_real_escape_string($value);
        //echo $key." -> ".$value."<br>";
    }

    if ($mode["name"]=="bilder")
    {
        $tabelle=TBL_BILDER;
    }
   

    if(isset($_FILES['bild']['name'])&&(!empty($_FILES['bild']['name']))) {
    // Hier "soll" das Bild aus dem Temporärenerzeichniss geholt werden, und anschließend in ein Bild Verzeichniss gepackt werden.
        $uploaddir = 'bildtest/';
        $uploadfile = $uploaddir . basename($_FILES['bild']['name']);
        echo '<pre>';
        $uploaded_file_name=$uploadfile;
        if(file_exists($uploaded_file_name)) {
            $uploaded_file_name=$uploaded_file_name.time(); 
        }
        if (move_uploaded_file($_FILES['bild']['tmp_name'], $uploaded_file_name)) {
            echo "Datei wurde erfolgreich hochgeladen.\n";
        } else {
            echo "<h2>\n UPLOAD FEHLGESCHLAGEN\n</h2>";
        }

        //echo 'Weitere Debugging Informationen:';
        //print_r($_FILES);

        print "</pre>";
        
        $new_uploadfile=$uploaded_file_name."thumbnail";
        
        resizeImage($uploadfile,$new_uploadfile);
        
        //echo "<img src=\"".$new_uploadfile."\" >";
        
        $daten["url"]=$new_uploadfile;
        // siehe http://php.net/manual/de/features.file-upload.post-method.php
    }
        
    
?>
</head>


<body style="margin:0;padding:0;text-align:center;">
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
        if ($mode["name"]=="bilder")
        {
            $sqlquery=$sqlquery." WHERE id=".$mode['id'];
        }
        // Falls ein neues Bild hinzugefügt wird, wird das alte gelöscht.
        if(isset($_FILES['bild']['name'])&&(!empty($_FILES['bild']['name']))) {
            $big_url=preg_replace('/thumbnail/i','',$mode["alturl"]);
            unlink($bigurl);
            unlink($mode["alturl"]);
            //echo "<h1>Hier ist der SQL-Update Befehl.</h1><br>".$sqlquery;
        }
        $objMySQL->Query($sqlquery);
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
        $sqlquery=$sqlquery.", `kunde` = '".$mode['kunde']."' ";
        
        //echo "<h1>Hier ist der SQL-Update Befehl.</h1><br>".$sqlquery;
        $objMySQL->Query($sqlquery);
    }
    //---------------- Falls ein Eintrag gelöscht werden soll. --------------------
    if ($mode["mode"]=='delete') {
    /*
        $big_url=preg_replace('/thumbnail/i','',$mode["url"]);
        unlink($bigurl);
        unlink($mode["url"]);
        $sqlquery="DELETE FROM `".DB_DATABASE."`.`".TBL_BILDER."` WHERE `".TBL_BILDER."`.`id` = ".$mode['id'];*/
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".$tabelle."` SET `loeschen` = '0', `loeschentime` = '".time()."' WHERE `".TBL_BILDER."`.`id` = ".$mode['id'];
        echo "Das Bild wurde gelöscht.";
        $objMySQL->Query($sqlquery);
    }
    if ($mode["mode"]=='renew') {
        $sqlquery = "UPDATE `".DB_DATABASE."`.`".$tabelle."` SET `loeschen` = '1', `loeschentime` = NULL WHERE `".TBL_BILDER."`.`id` = ".$mode['id'];
        echo "Das Bild wurde wiederhergestellt.";
        $objMySQL->Query($sqlquery);
    }
    
  
?>
    <!--<br><br>Die Daten wurden gespeichert.<br><br>-->

    
<?php
 function resizeImage ($filepath_old, $filepath_new) {
    // Image_dimension ändern, um die größe der Thumbnails zu bestimmen
    $image_dimension = 600;
    $scale_mode = 0;
    if (!(file_exists($filepath_old)) || file_exists($filepath_new)) return false;

    $image_attributes = getimagesize($filepath_old);
    $image_width_old = $image_attributes[0];
    $image_height_old = $image_attributes[1];
    $image_filetype = $image_attributes[2];

    if ($image_width_old <= 0 || $image_height_old <= 0) return false;
    $image_aspectratio = $image_width_old / $image_height_old;

    if ($scale_mode == 0) {
        $scale_mode = ($image_aspectratio > 1 ? -1 : -2);
    } elseif ($scale_mode == 1) {
        $scale_mode = ($image_aspectratio > 1 ? -2 : -1);
    }

    if ($scale_mode == -1) {
        $image_width_new = $image_dimension;
        $image_height_new = round($image_dimension / $image_aspectratio);
    } elseif ($scale_mode == -2) {
        $image_height_new = $image_dimension;
        $image_width_new = round($image_dimension * $image_aspectratio);
    } else {
    return false;
    }

    switch ($image_filetype) {
    case 1:
        $image_old = imagecreatefromgif($filepath_old);
        $image_new = imagecreate($image_width_new, $image_height_new);
        imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
        imagegif($image_new, $filepath_new);
    break;

    case 2:
        $image_old = imagecreatefromjpeg($filepath_old);
        $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
        imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
        imagejpeg($image_new, $filepath_new);
    break;

    case 3:
    $image_old = imagecreatefrompng($filepath_old);
    $image_colordepth = imagecolorstotal($image_old);

    if ($image_colordepth == 0 || $image_colordepth > 255) {
        $image_new = imagecreatetruecolor($image_width_new, $image_height_new);
    } else {
        $image_new = imagecreate($image_width_new, $image_height_new);
    }

    imagealphablending($image_new, false);
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $image_width_new, $image_height_new, $image_width_old, $image_height_old);
    imagesavealpha($image_new, true);
    imagepng($image_new, $filepath_new);
    break;

    default:
    return false;
    }

    imagedestroy($image_old);
    imagedestroy($image_new);
    return true;
 }
?>
</body>
</html>