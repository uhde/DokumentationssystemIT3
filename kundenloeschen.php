
<?php 
    echo '<form name="Form2" method="post" action="auswertung.php?name=kunde&id='.$_GET['id'].'&mode=delete">';
?>

    <h2 style="color:red;">Wollen sie den Kunden wirklich l�schen?</h2><br>
    <br>
    Mit dem Kunden werden auch automatisch alle Eintr�ge, die mit diesem Kunden verkn�pft sind gel�scht. (Ger�te, Zug�nge, Dokumente, Bilder)
    <br><br>
    <h1>
       Falls sie den Kunden nicht l�schen wollen, k�nnen sie dieses Fenster einfach wieder schlie�en.
       </h1>
    <br><br>
        <input type="submit" value="Kunde L�schen" class="button1">
</form>