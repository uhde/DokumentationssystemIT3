!#----- bilder_edit:Begin -----#!
<html>
<head>
	<title>Kunden verwalten</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="creation_date" content="2012-11-16">
	<meta name="revisit-after" content="5 days">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_bild.php?alturl={$url}&name=bilder&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
        </span>
	</td>
</tr>
<tr class="Data0">

	<td align="right"><span class="LinkStyle">Hochladen: </span></td>
	<td>
		<span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <input name="bild" type="file" size="50" accept="text/*">
        </input></span>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
	<td colspan="3">
		<textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr >
	<td align="center" colspan="2">
		<input type="submit" value="Speichern und Schließen" class="button1">
        
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
	</td>
</tr>
</form>

</table>

</body>
</html>
!#----- bilder_edit:End -----#!


!#----- bilder_create:Begin -----#!
<html>
<head>
	<title>Kunden verwalten</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="creation_date" content="2012-11-16">
	<meta name="revisit-after" content="5 days">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_bild.php?name=bilder&mode=create&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
        </span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Hochladen: </span></td>
	<td>
		<span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <input name="bild" type="file" size="50" accept="text/*">
        </input></span>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
	<td colspan="3">
		<textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr >
	<td align="center" colspan="2">
		<input type="submit" value="Speichern und Schließen" class="button1">
        
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
	</td>
</tr>
</form>

</table>

</body>
</html>
!#----- bilder_create:End -----#!
