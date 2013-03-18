<?
/*
    Benutzt kundenwahl.lay.php als Layout, um die gesamte Linke Kundenbox darzustellen.

*/
$objMySQL2 = new MySQL();
if (!$objMySQL2->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   echo $objMySQL2->Error();
   $objMySQL2->Kill();
}
$objTemplate=new Template("layout/kundenwahl.lay.php");

$objMySQL->Query('SELECT * FROM '.TBL_KUNDEN.' ORDER BY name');

if ($objMySQL->RowCount()>0) {
    //zeigt die Überschrift "Kunden" an, nötig für Tabellenstruktur
	$objTemplate->Display('Header');
	$Count=0;
	while ($Data = $objMySQL->Row()) {
		// Falls Session mit Kunden-ID nicht da: Setzen
		if (!isset($_SESSION['knd_id']) OR empty($_SESSION['knd_id'])) {
			$_SESSION['knd_id']=$Data->id;
			session_commit();
		}
        // Hier werden die Daten abgerufen, die benötigt werden um die Sichtbarkeit der Kunden zu managen
        $sql = "SELECT sichtbar FROM ".TBL_BKE." WHERE kundenid='".$Data->id."' AND benutzerid='".$_SESSION['nutzerid']."'";
        $test = $objMySQL2->QuerySingleRowArray($sql,MYSQL_ASSOC);   
        
        
		// Hier ist mancher Code doppelt. Vor allem um sicherzustellen, das die Kunden weiterhin abwechselnd eingefärbt werden
        // Und hier nicht auch die "versteckten" kunden mitbeachtet werden.
        
        if(isset($test["sichtbar"]))
        {
            if($test["sichtbar"]==1) {
                $objTemplate->Assign('id',$Data->id);
                $objTemplate->Assign('name',$Data->name);
                $objTemplate->Assign('LineClass',$Count%2);
                
                // Gewählten Kunden markieren
                if ($Data->id==$_SESSION['knd_id']) {
                    $objTemplate->Assign('LineClass','_Selected');
                }
                $objTemplate->Display('Main');
                $Count++;
            } else {
                if($_SESSION['allekunden']=='TRUE')
                {
                    $objTemplate->Assign('id',$Data->id);
                    $objTemplate->Assign('name',$Data->name);
                    $objTemplate->Assign('LineClass','_versteckt');
                    $objTemplate->Display('Main');
                }
            }
        } else {
            $objTemplate->Assign('id',$Data->id);
            $objTemplate->Assign('name',$Data->name);
            $objTemplate->Assign('LineClass',$Count%2);
            
            // Gewählten Kunden markieren
            if ($Data->id==$_SESSION['knd_id']) {
                $objTemplate->Assign('LineClass','_Selected');
            }
           /* if ($Data->sichtbar!=1) {
                $objTemplate->Assign('LineClass','_versteckt');
            }*/
            $objTemplate->Display('Main');
            $Count++;
            
        }
		$objTemplate->ClearAssign();
		
	}
	$objTemplate->Display('Footer');
}else{
	echo 'Keine Kunden vorhanden!<br />';
}
unset($objTemplate);

?>


