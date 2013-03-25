!#----- geraeteedit:Begin -----#!
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

<form name="Form1" method="post" action="auswertung.php?name=geraete&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText"><input name="name" type="text" size="30" maxlength="30" value="{$name}" ></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Kategorie: </span></td>
	<td>
        <select name="kategorie"> 
             <option {$kat_active_server} value="1">Server</option>
             <option {$kat_active_pc} value="2">Computer</option>
             <option {$kat_active_drucker} value="3">Drucker</option>
             <option {$kat_active_netzwerk} value="4">Netzwerk</option>
        </select>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">IP: </span></td>
	<td>
		<span class="StandardText"><input name="adresse" type="text" size="30" maxlength="30" value="{$adresse}" ></span>
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
	<td align="right"><span class="LinkStyle">System-Beschreibung </span></td>
	<td>
		<span class="StandardText"><input name="system" type="text" size="30" maxlength="30" value="{$system}"  ></span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr class="Data0">
	<td align="right"><span class="LinkStyle">Betriebssystem </span></td>
	<td>
		<span class="StandardText"><input name="bs" type="text" size="30" maxlength="30" value="{$bs}" ></span>
	</td>
	<td align="right"><span class="LinkStyle">PC-Typ </span></td>
	<td>
		<span class="StandardText"><input name="pc" type="text" size="30" maxlength="30" value="{$pc}" > </span>
	</td>
</tr>
<tr>
    <td align="right"><span class="LinkStyle">Produktnummer </span></td>
    <td>
        <span class="StandardText"><input name="produktnummer" type="text" size="30" maxlength="20" value="{$produktnummer}" > </span>
    </td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Seriennummer</span></td>
	<td>
		<span class="StandardText"><input name="sn" type="text" size="30" maxlength="30" value="{$sn}" ></input></span>
	</td>
	<td align="right"><span class="LinkStyle">Garantie<br>(dd/mm/yyyy) </span></td>
	<td>
		<span class="StandardText">
        <input name="garantied" type="text" size="2" maxlength="2" value="{$garantied}"></input>
        <input name="garantiem" type="text" size="2" maxlength="2" value="{$garantiem}"></input>
        <input name="garantiey" type="text" size="4" maxlength="4" value="{$garantiey}"></input></span>
        <!--<a href="#" onclick="document.Form1.garantied.value='{$garantied_set}';document.Form1.garantiem.value='{$garantiem_set}';document.Form1.garantiey.value='{$garantiey_set}';">Garantie auf 3 Jahre setzten.</a>-->
	</td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Benutzer</span></td>
	<td>
		<span class="StandardText"><input name="benutzer" type="text" size="30" maxlength="30" value="{$benutzer}" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Zimmer: </span></td>
	<td>
		<span class="StandardText"><input name="zimmer" type="text" size="30" maxlength="30" value="{$zimmer}" ></input></span>
	</td>

	<td align="right"><span class="LinkStyle">Drucker </span></td>
	<td>
		<span class="StandardText"><input name="drucker" type="text" size="30" maxlength="30" value="{$drucker}" ></input></span>
	</td>
</tr>
<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Router </span></td>
	<td>
		<span class="StandardText"><input name="router" type="text" size="30" maxlength="30" value="{$router}" ></input></span>
	</td>

	<td align="right"><span class="LinkStyle">Irdpport </span></td>
	<td>
		<span class="StandardText"><input name="irdpport" type="text" size="30" maxlength="30" value="{$irdpport}" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Ftpdir </span></td>
	<td>
		<span class="StandardText"><input name="ftpdir" type="text" size="30" maxlength="30" value="{$ftpdir}" ></input></span>
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

<tr>
    {$login_edit}
</tr>

<tr>
    <td>
        Bei dem Programm "Teamviewer Lan" wird das Login Feld nicht übernommen.<br>
    </td>
</tr>

<tr >
	<td align="center" colspan="2">
    
		<input type="submit" value="Speichern" >
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" >
	</td>
    <td>
        <input type="submit"  value="Neues Programm hinzufügen" onclick="javascript: form.action='auswertung.php?name=geraete&mode=edit&kunde={$kunde}&id={$id}&prog_add=5';" />
    </td>
</tr>
</form>

</table>

</body>
</html>
!#----- geraeteedit:End -----#!





!#----- geraetecreate:Begin -----#!
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

<form name="Form4" method="post" action="auswertung.php?name=geraete&mode=create&kunde={$kunde}&kategorie={$kategorie}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Name: </span></td>
	<td>
		<span class="StandardText"><input name="name" type="text" size="30" maxlength="30" value="" ></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">IP: </span></td>
	<td>
		<span class="StandardText"><input name="adresse" type="text" size="30" maxlength="30" value="{$adresse}" ></span>
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
	<td align="right"><span class="LinkStyle">System-Beschreibung </span></td>
	<td>
		<span class="StandardText"><input name="system" type="text" size="30" maxlength="30" value="{$system}"  ></span>
	</td>
</tr>

<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr class="Data0">
	<td align="right"><span class="LinkStyle">Betriebssystem </span></td>
	<td>
		<span class="StandardText"><input name="bs" type="text" size="30" maxlength="30" value="{$bs}" ></span>
	</td>
	<td align="right"><span class="LinkStyle">PC-Typ </span></td>
	<td>
		<span class="StandardText"><input name="pc" type="text" size="30" maxlength="30" value="{$pc}" > </span>
	</td>
</tr>
<tr>
    <td align="right"><span class="LinkStyle">Produktnummer </span></td>
    <td>
        <span class="StandardText"><input name="produktnummer" type="text" size="30" maxlength="20" value="{$produktnummer}" > </span>
    </td>
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Seriennummer</span></td>
	<td>
		<span class="StandardText"><input name="sn" type="text" size="30" maxlength="30" value="{$sn}" ></input></span>
	</td>
	<td align="right"><span class="LinkStyle">Garantie<br></span></td>
	<td>
		<span class="StandardText">
        <input name="garantied" type="text" size="2" maxlength="2" value="{$garantied}"></input>
        <input name="garantiem" type="text" size="2" maxlength="2" value="{$garantiem}"></input>
        <input name="garantiey" type="text" size="4" maxlength="4" value="{$garantiey}"></input></span>
        <!--<a href="#" onclick="document.Form1.garantied.value='{$garantied_set}';document.Form1.garantiem.value='{$garantiem_set}';document.Form1.garantiey.value='{$garantiey_set}';">Garantie auf 3 Jahre setzten.</a>-->
	</td>

    
</tr>

<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Benutzer</span></td>
	<td>
		<span class="StandardText"><input name="benutzer" type="text" size="30" maxlength="30" value="{$benutzer}" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Zimmer: </span></td>
	<td>
		<span class="StandardText"><input name="zimmer" type="text" size="30" maxlength="30" value="{$zimmer}" ></input></span>
	</td>

	<td align="right"><span class="LinkStyle">Drucker </span></td>
	<td>
		<span class="StandardText"><input name="drucker" type="text" size="30" maxlength="30" value="{$drucker}" ></input></span>
	</td>
</tr>
<tr height="6" class="Data0"><td colspan="4" align="center"></td></tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Router </span></td>
	<td>
		<span class="StandardText"><input name="router" type="text" size="30" maxlength="30" value="{$router}" ></input></span>
	</td>

	<td align="right"><span class="LinkStyle">Irdpport </span></td>
	<td>
		<span class="StandardText"><input name="irdpport" type="text" size="30" maxlength="30" value="{$irdpport}" ></input></span>
	</td>
</tr>
<tr class="Data0">
	<td align="right"><span class="LinkStyle">Ftpdir </span></td>
	<td>
		<span class="StandardText"><input name="ftpdir" type="text" size="30" maxlength="30" value="{$ftpdir}" ></input></span>
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
<tr>
        <table class="Logins_Table" name="asd" align="center">
            <tr >
                <td></td>
            </tr>
        </table>

</tr>

<tr>
    
    <td colspan="4">
       Klicken sie auf den Button: "Programm hinzufügen" um ein, oder mehrere Programme einzupflegen.<br>
    </td>
</tr>

<tr >
	<td align="center" colspan="2">
		<input type="submit" value="Speichern" class="button1">
        
        <input type="button" value="Abbrechen" onClick="javascript:void(top.Boxy.linkedTo( top.$('#kundenwahl')[0]).hide());" class="button1">
	</td>
     <td>
        <input type="submit"  class="button1" value="Speichern und Neues Programm hinzufügen" onclick="javascript: form.action='auswertung.php?name=geraete&mode=create&kunde={$kunde}&kategorie={$kategorie}&prog_add=5';" />
    </td>
</tr>
</form>

</table>

</body>
</html>
<head>
	<title>Kunden verwalten</title>
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="creation_date" content="2012-11-16">
	<meta name="revisit-after" content="5 days">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<LINK rel="stylesheet" href="css/styles.css"> 
</head>

</html>
!#----- geraetecreate:End -----#!



!#----- nogeraete:Begin -----#!
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
<br>

</body>
</html>
!#----- nogeraete:End -----#!

!#----- Login_Header:Begin -----#!
<table class="Logins_Table" name="LoginTable" align="center">
<tr style="background-color:#666;">
	<th>Typ</th>
	<th>Login</th>
	<th>Passwort</th>
    <th></th>
    <th>Aktiv?</th>
</tr>
!#----- Login_Header:End -----#!

!#----- Login_Main:Begin -----#!
<tr>
	<td class="Key"><select name="programm_id{$runde}" size="1">{$prog_list}  </select>  </td>
	<td class="Value"><span id="geratelogin"> <input name="login{$runde}" type="text" size="25"  value="{$geraete_login}" ></input></span></td>
	<td class="Value"><input name="passwort{$runde}" type="text" size="25" maxlength="40" value="{$geraete_pw}" ></input></td>
    <td style="text-align:center;"><a href="auswertung.php?name=geraete&prog_del=1&geraete_login_id={$geraete_login_id}&id={$geraet_id}&kunde={$kunden_id}" title="Löschen"   >
        <img src="syspics/button_drop.png" style="border:none:width:12px;height:12px;" alt="Programm löschen"></a></td>
    <td class="Value">
        <input name="prog_aktiv{$runde}" title="Checkbox die darstellt das der Button angezeigt werden soll." type="checkbox" {$aktive}></input>
    </td>
</tr>
!#----- Login_Main:End -----#!

!#----- Login_Footer:Begin -----#!
</table>
<br />
!#----- Login_Footer:End -----#!

!#----- Prog_liste:Begin -----#!
 <option value="{$id}">{$bemerkung}</option>
!#----- Prog_liste:End -----#!

!#----- Prog_selected_liste:Begin -----#!
<option selected value="{$id}">{$bemerkung}</option>
!#----- Prog_selected_liste:End -----#!
