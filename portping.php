<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title>Portping</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<style type=text/css> 
	.progressbar {
		display: table-cell;
		text-align:center;
		vertical-align:middle;
		background-color:#600;
	}
	.progressbar .progress_text{
		color:#fff;
		font-weight:bold;
		font-family:Verdana,Arial;
		font-size:10pt;
	}

	</style>
	
	</head>
<body>

<?php

$Host=urldecode($_GET['Host']);
$Port=urldecode($_GET['Port']);
$ShowType=urldecode($_GET['ShowType']);
$Timeout=urldecode($_GET['Timeout']);
$MaxCount=urldecode($_GET['MaxCount']);
$Width=urldecode($_GET['Width']);
$Height=urldecode($_GET['Height']);
$Sleep=urldecode($_GET['Sleep']);
$Count=urldecode($_GET['Count']);

$Router='uhdsrv04';

$Host='uhdsrv04';
$Port=5900;

$Status=fnProgressBar($Router);
if ($Status['Status']===FALSE) {
	echo 'Keine Verbindung zu Router'.$Status['Host'].' auf Port '.$Status['Port'].' möglich!';
	exit;
}

$Status=fnProgressBar($Host,Port);
if ($Status['Status']===FALSE) {
	echo 'Keine Verbindung zu '.$Status['Host'].' auf Port '.$Status['Port'].' möglich!';
	exit;
}else{
	echo 'Starte Fernwartung';
}




function fnProgressBar($Host,$Port=25,$MaxCount=10,$Width=500,$Height=26,$ShowType='',$StepCount,$Sleep=1,$Timeout=2) {
	
	$RedirectURL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	// Zähler setzen
	$Count=$_GET['Count'];
	$Count++;
	$RedirectURL.='?Count='.urlencode($Count);


	// Return-Daten
	$arrReturn['Host']=$Host;
	$arrReturn['Port']=$Port;
	$arrReturn['Count']=$Host;
	$arrReturn['MaxCount']=$Port;
	$arrReturn['Text']='';
	$arrReturn['Status']=FALSE;

	
	// Host prüfen
	if (!isset($Host) OR empty($Host)) {
		$arrReturn['Text']='Kein Host angegeben';
		return $arrReturn;
	}else{
		$RedirectURL.='&Host='.urlencode($Host);
	}
	// Port
	if (!isset($Port) OR empty($Port) OR !is_numeric($Port)) {
		$Port=23;
	}else{
		$Port=$Port;
		$RedirectURL.='&Port='.urlencode($Port);
	}
	// Breite
	if (!isset($Width) OR empty($Width)) {
		$Width=500;
	}else{
		$Width=$Width;
		$RedirectURL.='&Width='.urlencode($Width);
	}
	// Höhe
	if (!isset($Height) OR empty($Height)) {
		$Height=30;
	}else{
		$Height=$Height;
		$RedirectURL.='&Height='.urlencode($Height);
	}
	// Max. Count
	if (!isset($MaxCount) OR empty($MaxCount) OR !is_numeric($MaxCount)) {
		$MaxCount=10;
	}else{
		$MaxCount=$MaxCount;
		$RedirectURL.='&MaxCount='.urlencode($MaxCount);
	}
	// Sleep
	if (!isset($Sleep) OR empty($Sleep) OR !is_numeric($Sleep)) {
		$Sleep=1;
	}else{
		$Sleep=$Sleep;
		$RedirectURL.='&Sleep='.urlencode($Sleep);
	}
	// ShowType prüfen
	if (!isset($ShowType) OR empty($ShowType)) {
		$ShowType='Percent';
	}else{
		$ShowType=$ShowType;
		$RedirectURL.='&ShowType='.urlencode($ShowType);
	}

	
	$SegmentSize=round($Width/$MaxCount)*$Count;
	$Percent=round(($Count/$MaxCount)*100);
	if ($Count<=$MaxCount) {
		$handle=fsockopen($Host, $Port, $errno, $errstr, 2);
		if (!$handle) {
			echo '<div style="display:block;width:'.$Width.'px;border:1px solid black;height:'.$Height.'px">';
				echo '<div class="progressbar" style="width:'.$SegmentSize.'px;height:'.$Height.'px;">';
					echo '<div class="progress_text">';
					switch ($ShowType) {
						case 'Percent':
							echo $Percent.'%';
							break;
						case 'Step':
							echo $Count;
							break;
						case 'StepCount':
							echo $Count.'/'.$MaxCount;
							break;
						default:
					}
					echo '</div>';
				echo '</div>';
			echo '</div>';
			
			sleep($Sleep);
			echo '<script>document.location.replace("'.$RedirectURL.'");</script>';
		}else{
			stream_set_timeout($handle, $Timeout); 
			fclose($handle);
			$arrReturn['Status']=TRUE;
			return $arrReturn;
		}
	}else{
		$arrReturn['Status']=FALSE;
		return $arrReturn;
	}
}
	
?>

</body>
</html>