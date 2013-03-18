<?
// Klassen für DB-Zugriff linken
require_once("include/config.inc.php");
require_once("include/mysql.inc.php");

if (!isset($routerip)) {
// Objekt für DB-Zugriff
	$objMySQL=new MySQL();
// Verbindung zur DB aufbauene
	$objMySQL->connect($SERVER,$USER,$PASS,$DB,$resConn);
}


if (!empty($grt_id) AND (!isset($routerip) OR empty($routerip))) {
	$objMySQL->query("SELECT router FROM geraete WHERE id=$grt_id");
	if ($objMySQL->numrows()>0) {
	// Router-IP auslesen
		$arrData=$objMySQL->fetch_one("MYSQL_ASSOC");
		$routerip=$arrData["router"];
	}
}


// IP des FW-Routers holen
if (!empty($knd_id) AND (!isset($routerip) OR empty($routerip))) {
// Router-IP holen
	$objMySQL->query("SELECT routerip,dyndns_domain FROM kunden WHERE id=$knd_id");
// Falls Router-IP eingetragen
	if ($objMySQL->numrows()>0) {
// Router-IP auslesen
		$arrData=$objMySQL->fetch_one("MYSQL_ASSOC");
		if ($_GET["use_internet"]==0) {
			$routerip=$arrData["routerip"];
		}else{
			$routerip=$arrData["dyndns_domain"];
			$ip=$routerip;
		}
	}
}


// Router IP nicht leer
if (!empty($routerip)) {
	// Irgendwas machen....
}else{
// Router-IP leer - sofort zum Verbindungsaufbau zum Gerät
?>
<html>
<head>
	<title>Verbindungstest</title>
	<meta http-equiv="refresh" content="0; url=ping_pc.php5?ip=<?echo urlencode($ip);?>&prg_id=<?echo urlencode($prg_id);?>&knd_id=<?echo urlencode($knd_id);?>&grt_id=<?echo urlencode($grt_id);?>&port=<?echo urlencode($port);?>">
</head>
<body>
</body>
</html>
<?
// und Skript beenden
	exit;
}
// Starte Verbindungstest zum Router
?>
<html>
<head>
<LINK rel="stylesheet" href="css/styles.css">
<title>Verbindungstest</title>
<?
$count++;
// Nach 10 erfolglosen erbindungsversuchen Fehler ausgeben
if ($count>10) {
?>
	<script type="text/javascript" language="JScript"> 
	alert("Keine Verbindung zum Router <? echo $routerip;?> möglich!\n\n"+"Überprüfen Sie den Verbinungsaufbau.\n"+"Mögliche Fehler: \n"+"  - Alle Leitungen besetzt\n   - Gegenstelle antwortet nicht\n");
	parent.progress.location.href='leer.html'
	</script>
<?
// Script beenden
	exit;
}
// Befehlszeile für Ping bauen
	if ($_GET["use_internet"]==0) {
		$last_line = exec('ping '.$routerip.' -c 1 -W 1 -w 1',$dummy,$status);
	}else{
		//$status=checkPort($routerip,$port,1);
		$status=0;  // Mal immer ok annehmen
	}

	//if ($count==10) { $status=0; }
	
// Falls Ping nicht erfolgreich nochmals versuchen (Reload der Seite nach 1 Sekunde)
if ($status==1) {
?>
<meta http-equiv="refresh" content="1; url=ping.php5?count=<?echo $count;?>&ip=<?echo urlencode($ip);?>&prg_id=<?echo urlencode($prg_id);?>&knd_id=<?echo urlencode($knd_id);?>&grt_id=<?echo urlencode($grt_id);?>&routerip=<?echo urlencode($routerip);?>&port=<?echo urlencode($port);?>&use_internet=<?echo $_GET["use_internet"];?>">
<? 
// Falls Ping erfolgreich Verbindungstest beenden und zum Gerätetest wechseln
} else {
	$launch=true;
?>
		<meta http-equiv="refresh" content="0; url=ping_pc.php5?ip=<?echo urlencode($ip);?>&prg_id=<?echo urlencode($prg_id);?>&knd_id=<?echo urlencode($knd_id);?>&grt_id=<?echo urlencode($grt_id);?>&port=<?echo urlencode($port);?>&use_internet=<?echo $_GET["use_internet"];?>">
<?
	}
 ?>
</head>
<body style="margin:0px;padding:0px;background-color:#eeeeee;">
<?  
//if ($status==0) {
?>

<?// exit;} 
// Fortschrittsanzeige anzeigen

?>

<table width="100%" height="30">
<tr valign="middle">
<td width="10"></td>
<td valign="middle">
<?
$width=30*$count;
$percent=10*$count;

$color="CC6600";	
echo "<nobr><span style='font-size:8pt;font-weight:bold;font-family:verdana,arial;'>Verbinde zu Router: ".$routerip.": </span>";
echo "<span style='font-size:7pt;font-weight:bold;font-family:verdana,arial;background-color:#".$color.";width:".$width."px;height:13px;text-align:center;padding-top:0px;border:1px solid black;color:#ffffff;'>".$count."/10</span></nobr>";

function getGradient($startColor,$endColor,$parts) {

    $colors = array();
    $startDecColor = array();
    $endDecColor = array();

    $startDecColor['0'] = hexdec(substr($startColor, 0, 2));
    $startDecColor['1'] = hexdec(substr($startColor, 2, 2));
    $startDecColor['2'] = hexdec(substr($startColor, 4, 2));

    $endDecColor['0'] = hexdec(substr($endColor, 0, 2));
    $endDecColor['1'] = hexdec(substr($endColor, 2, 2));
    $endDecColor['2'] = hexdec(substr($endColor, 4, 2));

    $colors['1'] = '#'.$startColor;

    for($i = 2;$i <= ($parts - 1);$i++) {
        $color = array();
        $color['1'] = dechex(($endDecColor['0'] - $startDecColor['0']) / $parts * $i + $startDecColor['0']);
        if(strlen($color['1']) == 1)
            $color['1'] = str_repeat($color['1'],2);
        $color['2'] = dechex(($endDecColor['1'] - $startDecColor['1']) / $parts * $i + $startDecColor['1']);
        if(strlen($color['2']) == 1)
            $color['2'] = str_repeat($color['2'],2);
        $color['3'] = dechex(($endDecColor['2'] - $startDecColor['2']) / $parts * $i + $startDecColor['2']);
        if(strlen($color['3']) == 1)
            $color['3'] = str_repeat($color['3'],2);
        $colors[$i] = '#'.$color['1'].$color['2'].$color['3'];
    }

    $colors[$parts] = '#'.$endColor;

    return $colors;
}


function checkPort($dest,$port,$wait=1) {
	$fp = @fsockopen($dest, $port, $errno, $errstr, $wait);
	if (!$fp) {
	    return 1;
	} else {
	    fclose($fp);
		return 0;
	}
	exit;
}
?> 


</td>
<td width="160"><input type="button" onClick="javascript:location.href='leer.html';" value="Abbrechen" class="button_click" style="width:160px"></td>
<td width="10"></td>
</tr></table>
</body>
</html>

