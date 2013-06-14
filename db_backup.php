<?php
require_once('include/config.inc.php');
// entnommen von http://www.php-einfach.de/codeschnipsel_926.php 
@set_time_limit(0);
//Verbindung zur Datenbank
$verbindung = mysql_connect(DB_SERVER,DB_USER,DB_PASSWORD) or die("Username/Passwort falsch");

// MySQL Datenbanken
$dbname = array();
$dbname[]= DB_DATABASE;

//Speicherart
//0: Nur Server speichern
//1: Zusätzlich per Email versenden
$send = 0;

//Email-Adresse f&uuml;r Backup
$email = "email@adresse";

// 0: Normale Datei
// 1: GZip-Datei
$compression = 0;

//Falls Gzip nicht vorhanden, kein Gzip
if(!extension_loaded("zlib"))
   $compression = 0;

// Pfad zur aktuellen Datei
$path = ereg_replace ("\\\\","/",__FILE__);
$path = dirname ($path);
$path = trim($path);

// Pfad zum Backup
$path .= "/backup/";




//Dateityp
if ($compression==1) $filetype = "sql.gz";
else $filetype = "sql";

//Dateieigenschaften
$cur_time=date("d.m.Y H:i");
$cur_date=date("Y-m-d");

//Pfade zu den neuen Backup-Dateien (fur den Mailversand)
//__Nicht verändern___
$backup_pfad = array();





//Erstelle Struktur von Datenbank
function get_def($dbname, $table) {
    global $verbindung;
    $def = "";

    $def .= "CREATE TABLE $table (\n";
    $result = mysql_db_query($dbname, "SHOW FIELDS FROM $table",$verbindung);
    while($row = mysql_fetch_array($result)) {
        $def .= "    $row[Field] $row[Type]";
        if ($row["Default"] != "") $def .= " DEFAULT '$row[Default]'";
        if ($row["Null"] != "YES") $def .= " NOT NULL";
        if ($row[Extra] != "") $def .= " $row[Extra]";
        $def .= ",\n";
    }
    $def = ereg_replace(",\n$","", $def);
    $result = mysql_db_query($dbname, "SHOW KEYS FROM $table",$verbindung);
    while($row = mysql_fetch_array($result)) {
          $kname=$row[Key_name];
          if(($kname != "PRIMARY") && ($row[Non_unique] == 0)) $kname="UNIQUE|$kname";
          if(!isset($index[$kname])) $index[$kname] = array();
          $index[$kname][] = $row[Column_name];
    }
    while(list($x, $columns) = @each($index)) {
          $def .= ",\n";
          if($x == "PRIMARY") $def .= "  PRIMARY KEY (" . implode($columns, ", ") . ")";
          else if (substr($x,0,6) == "UNIQUE") $def .= "  UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
          else $def .= "  KEY $x (" . implode($columns, ", ") . ")";
    }

    $def .= "\n);";
    return (stripslashes($def));
}

//Erstelle Eintäge von Tabelle
function get_content($dbname, $table) {
    global $verbindung;
    $content="";
    $result = mysql_db_query($dbname, "SELECT * FROM $table",$verbindung);
    while($row = mysql_fetch_row($result)) {
        $insert = "INSERT INTO $table VALUES (";
        for($j=0; $j<mysql_num_fields($result);$j++) {
            if(!isset($row[$j])) $insert .= "NULL,";
            else if($row[$j] != "") $insert .= "'".addslashes($row[$j])."',";
            else $insert .= "'',";
        }
        $insert = ereg_replace(",$","",$insert);
        $insert .= ");\n";
        $content .= $insert;
    }
    return $content;
}

//Funktion um Backup auf dem Server zu speichern
function write_backup($val,$newfile,$newfile_data)
   {
   global $compression,$path,$cur_date,$filetype,$backup_pfad;

   $backup_pfad[] = $path.$val."_structur_".$cur_date.".".$filetype;
   $backup_pfad[] = $path.$val."_data_".$cur_date.".".$filetype;

   if ($compression==1)
      {
      $fp = gzopen($path.$val."_structur_".$cur_date.".".$filetype,"w9");
      gzwrite ($fp,$newfile);
      gzclose ($fp);


      $fp = gzopen($path.$val."_data_".$cur_date.".".$filetype,"w9");
      gzwrite ($fp,$newfile_data);
      gzclose ($fp);
      }
   else
      {
      $fp = fopen ($path.$val."_structur_".$cur_date.".".$filetype,"w");
      fwrite ($fp,$newfile);
      fclose ($fp);


      $fp = fopen($path.$val."_data_".$cur_date.".".$filetype,"w");
      fwrite ($fp,$newfile_data);
      fclose ($fp);
      }
   }
//Backup per Email verschicken
function mail_att($to, $from, $subject, $message) {
    // $to Empfänger
    // $from Absender ("email@domain.de" oder "Name <email@domain.de>")
    // $subject Betreff
    // $message Inhalt der Email
    global $backup_pfad; //Die Pfade zu den Dateien


    if(is_array($backup_pfad) AND count($backup_pfad) > 0)
       {
       $mime_boundary = "-----=" . md5(uniqid(rand(), 1));


      $header = "From: ".$from."\r\n";
      $header.= "MIME-Version: 1.0\r\n";
      $header.= "Content-Type: multipart/mixed;\r\n";
      $header.= " boundary=\"".$mime_boundary."\"\r\n";

      $content = "This is a multi-part message in MIME format.\r\n\r\n";
      $content.= "--".$mime_boundary."\r\n";
      $content.= "Content-Type: text/plain charset=\"iso-8859-1\"\r\n";
      $content.= "Content-Transfer-Encoding: 7bit\r\n\r\n";
      $content.= $message."\r\n";

      //Dateien anhaengen
      foreach($backup_pfad AS $file)
          {
          $name = basename($file);
         $data = chunk_split(base64_encode(implode("", file($file))));
         $len = filesize($file);
         $content.= "--".$mime_boundary."\r\n";
         $content.= "Content-Disposition: attachment;\r\n";
         $content.= "\tfilename=\"$name\";\r\n";
         $content.= "Content-Length: .$len;\r\n";
         $content.= "Content-Type: application/x-gzip; name=\"".$file."\"\r\n";
         $content.= "Content-Transfer-Encoding: base64\r\n\r\n";
         $content.= $data."\r\n";
          }

      if(mail($to, $subject, $content, $header)) return true;
      else return false;
      }

   return false;
   }


//Backup erstellen
while (list(,$val) = each($dbname))
   {
   $newfile="# Strukturbackup: $cur_time \r\n# www.php-einfach.de \r\n";
   $newfile_data="# Datenbackup: $cur_time \r\n# www.php-einfach.de \r\n";

   //backup schreiben
   $tables = mysql_list_tables($val,$verbindung);
   $num_tables = @mysql_num_rows($tables);
   $i = 0;
   while($i < $num_tables)
      {
      $table = mysql_tablename($tables, $i);

      $newfile .= "\n# ----------------------------------------------------------\n#\n";
      $newfile .= "# structur for Table '$table'\n#\n";
      $newfile .= get_def($val,$table);
      $newfile .= "\n\n";


      $newfile_data .= "\n# ----------------------------------------------------------\n#\n";
      $newfile_data .= "#\n# data for table '$table'\n#\n";
      $newfile_data .= get_content($val,$table);
      $newfile_data .= "\n\n";
      $i++;
      }

   write_backup($val,$newfile,$newfile_data);
   } //End: while




//Backup per Email senden
if($send == 1)
   {
   $text="Datenbank-Backup vom: ".date("d.m.Y H:i")."\n\n\n w";
   $from = "backup@server.de";

   if(!mail_att($email, $from, "Datenbank-Backup ".date("Y-m-d"), $text))
      echo "Es konnte <b>keine</b> Email gesendet werden<br>";

   }


echo "<h3>Backup ist fertig</h3>";
?> 