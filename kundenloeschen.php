
<?php 
    echo '<form name="Form2" method="post" action="auswertung.php?name=kunde&id='.$_GET['id'].'&mode=delete">';
?>

    <h2 style="color:red;">Wollen sie den Kunden wirklich löschen?</h2><br>
    <br>
    Mit dem Kunden werden auch automatisch alle Einträge, die mit diesem Kunden verknüpft sind gelöscht. (Geräte, Zugänge, Dokumente, Bilder)
    <br><br>
    <h1>
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1"></h1>
    <br><br>
        <input type="submit" value="Kunde Löschen" class="button1">
</form>