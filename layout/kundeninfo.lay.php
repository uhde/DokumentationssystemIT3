!#----- kundeninfoedit:Begin -----#!
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


<body style="margin:0;padding:0;" >
<form name="Form1" method="post" action="auswertung.php?name=kunde&mode=edit&id={$id}">
<table width="710" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText">{$name}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Kürzel: </span></td>
	<td>
		<span class="StandardText">{$kuerzel}</span>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<!--
<tr class="Data0">
	<td align="right"><span class="LinkStyle">UNC-Pfad: </span></td>
	<td>
		<span class="StandardText">{$starturl}</span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
-->
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Router-IP: </span></td>
	<td>
		<span class="StandardText">{$routerip}</span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr class="Data0">
	<td align="right"><span class="LinkStyle">Strasse / Nr.: </span></td>
	<td>
		<span class="StandardText"><input name="strasse" type="text" size="30" maxlength="30" value="{$strasse}"></input> <input name="hausnummer" type="text" size="5" maxlength="5" value="{$hausnummer}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">PLZ / Ort: </span></td>
	<td>
		<span class="StandardText"><input name="plz" type="text" size="30" maxlength="30" value="{$plz}"> <input name="ort" type="text" size="30" maxlength="30" value="{$ort}"></span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="telefon" type="text" size="30" maxlength="30" value="{$telefon}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Fax: </span></td>
	<td>
		<span class="StandardText"><input name="fax" type="text" size="30" maxlength="30" value="{$fax}"></input></span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 1: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_name" type="text" size="30" maxlength="30" value="{$asp1_name}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_telefon" type="text" size="30" maxlength="30" value="{$asp1_telefon}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">E-Mail: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_mail" type="text" size="30" maxlength="30" value="{$asp1_mail}"></input></span>
	</td>
</tr>
<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 2: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_name" type="text" size="30" maxlength="30" value="{$asp2_name}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_telefon" type="text" size="30" maxlength="30" value="{$asp2_telefon}"></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">E-Mail: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_mail" type="text" size="30" maxlength="30" value="{$asp2_mail}"></input></span>
	</td>
</tr>


<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Wartungsdaten: </span></td>
	<td colspan="3">
		<textarea     name="wartung" cols="74" rows="8" wrap="PHYSICAL" id="wartung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$wartung}</textarea>
	</td>
    <!-- Wenn doch noch keine direkte editmöglichkeit gewünscht ist, einfach ein readonly=readonly argument hinzufügen -->
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
	<td colspan="3">
		<textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
	</td>
</tr>


<tr height="14"><td colspan="2" align="center"></td></tr>

<tr class="footer">
	<td align="center" colspan="2">
		<input type="submit" value="Speichern und Schließen" class="button1">
		
	</td>
    <td align="center" colspan="2">
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
	</td>
</tr>
</form>

</table>

</body>
</html>
!#----- kundeninfoedit:End -----#!





!#----- kundeninfo:Begin -----#!
<html>
<head>
	<title>Kunden verwalten</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="creation_date" content="2002-07-21">
	<meta name="revisit-after" content="5 days">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">
<form name="Form1">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText">{$name}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Kürzel: </span></td>
	<td>
		<span class="StandardText">{$kuerzel}</span>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<!--
<tr class="Data0">
	<td align="right"><span class="LinkStyle">UNC-Pfad: </span></td>
	<td>
		<span class="StandardText">{$starturl}</span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
-->
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Router-IP (Feld entfernen?) : </span></td>
	<td>
		<span class="StandardText">{$routerip}</span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr class="Data0">
	<td align="right"><span class="LinkStyle">Strasse / Nr.: </span></td>
	<td>
		<span class="StandardText">{$strasse} {$hausnummer}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">PLZ / Ort: </span></td>
	<td>
		<span class="StandardText">{$plz} {$ort}</span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText">{$telefon}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Fax: </span></td>
	<td>
		<span class="StandardText">{$fax}</span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 1: </span></td>
	<td>
		<span class="StandardText">{$asp1_name}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText">{$asp1_telefon}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">E-Mail: </span></td>
	<td>
		<span class="StandardText">{$asp1_mail}</span>
	</td>
</tr>
<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 2: </span></td>
	<td>
		<span class="StandardText">{$asp2_name}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText">{$asp2_telefon}</span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">E-Mail: </span></td>
	<td>
		<span class="StandardText">{$asp2_mail}</span>
	</td>
</tr>


<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Wartungsdaten: </span></td>
	<td colspan="3">
		<textarea     name="wartung" cols="74" rows="8" wrap="PHYSICAL" id="wartung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$wartung}</textarea>
	</td>
    <!-- Wenn doch noch keine direkte editmöglichkeit gewünscht ist, einfach ein readonly=readonly argument hinzufügen -->
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
	<td colspan="3">
		<textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
	</td>
</tr>


<tr height="14"><td colspan="2" align="center"></td></tr>

<tr class="footer">
	<td align="center" colspan="2">
        <!--<a href="javascript:void(top.Boxy.linkedTo( top.$('#boxyfoo')[0]).hide());">Close</a> -->
		<input type="button" value="Schließen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
		
	</td>
    <td align="center" >
		<input type="button" value="Editieren" onClick="javascript:location.replace('kundeninfo.php?knd_id={$id}&edit=true')" class="button1">
	</td>
    <td align="center">
        <input type="button" value="Kunden Löschen" onClick="javascript:location.replace('kundenloeschen.php?id={$id}')" class="button1" />
    </td>
</tr>
</form>
<!--
    <td style="text-align:center;vertical-align:middle;width:30px;border-left:1px solid #aaa;border-top:1px solid #ccc;">
        <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','auswertung.php?name=geraete&kunde={$kunde}&id={$id}&mode=delete','Kundeninfo','720','200');">
        <img src="syspics/button_drop.png" alt="Eintrag löschen">
        </a>
    </td>
    -->


</table>

</form>
</body>
</html>
!#----- kundeninfo:End -----#!

!#----- kundeninfocreate:Begin -----#!
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
<form name="Form2" method="post" action="auswertung.php?name=kunde&mode=create">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText"><input name="name" type="text" size="30" maxlength="30" ></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Kürzel: </span></td>
	<td>
		<span class="StandardText"><input name="kuerzel" type="text" size="30" maxlength="30" ></span>
	</td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<!--
<tr class="Data0">
	<td align="right"><span class="LinkStyle">UNC-Pfad: </span></td>
	<td>
		<span class="StandardText">{$starturl}</span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
-->
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Router-IP: </span></td>
	<td>
		<span class="StandardText"><input name="routerip" type="text" size="30" maxlength="30" ></span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr class="Data0">
	<td align="right"><span class="LinkStyle">Strasse / Nr.: </span></td>
	<td>
		<span class="StandardText"><input name="strasse" type="text" size="30" maxlength="30" ></input> <input name="hausnummer" type="text" size="5" maxlength="5" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">PLZ / Ort: </span></td>
	<td>
		<span class="StandardText"><input name="plz" type="text" size="30" maxlength="30" value="{$plz}"> <input name="ort" type="text" size="30" maxlength="30" ></span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="telefon" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">Fax: </span></td>
	<td>
		<span class="StandardText"><input name="fax" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 1: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_name" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_telefon" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">E-Mail: </span></td>
	<td>
		<span class="StandardText"><input name="asp1_mail" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Anspr.-Partner 2: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_name" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">Telefon: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_telefon" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle"">E-Mail: </span></td>
	<td>
		<span class="StandardText"><input name="asp2_mail" type="text" size="30" maxlength="30" ></input></span>
	</td>
</tr>


<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Wartungsdaten: </span></td>
	<td colspan="3">
		<textarea     name="wartung" cols="74" rows="8" wrap="PHYSICAL" id="wartung"   onFocus="this.className='aktiv'" onBlur="this.className='text'"></textarea>
	</td>
    <!-- Wenn doch noch keine direkte editmöglichkeit gewünscht ist, einfach ein readonly=readonly argument hinzufügen -->
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
	<td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
	<td colspan="3">
		<textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'"></textarea>
	</td>
</tr>


<tr height="14"><td colspan="2" align="center"></td></tr>

<tr class="footer">
	<td align="center" colspan="2">
		<input type="submit" value="Speichern und Schließen" class="button1">
		
	</td>
    <td align="center" colspan="2">
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
	</td>
</tr>
</form>

</table>

</body>
</html>
!#----- kundeninfocreate:End -----#!


!#----- nokundeninfo:Begin -----#!
<html>
<head>
	<title>Kunden verwalten</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="creation_date" content="2002-07-21">
	<meta name="revisit-after" content="5 days">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<LINK rel="stylesheet" href="css/styles.css"> 
</head>


<body leftmargin="20" marginwidth="20">
<p id="NewsHeader" style="margin-top:10px;padding-left:10px;"> Keine Daten vorhanden...</p>
</body>
</html>
!#----- nokundeninfo:End -----#!


<!-- Ende des Templates -->