!#----- Header:Begin -----#!
<div id="frame_devicenav">
	<table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
	<thead>
	<tr>
	<th style="width:190px;" class="{$name_sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Name</a>{$name_IMG}</th>
	<th style="width:190px;" class="{$ip_adresse_sort_order}"><a href="index.php?sort_name=adresse&sort_order={$sort_order}">IP-Adresse</a>{$ip_adresse_IMG}</th>
	<th style="width:200px;" class="{$system_sort_order}"><a href="index.php?sort_name=system&sort_order={$sort_order}">Systemtyp</a>{$system_IMG}</th>
	<th style="width:176px;" class="{$zimmer_sort_order}"><a href="index.php?sort_name=zimmer&sort_order={$sort_order}">Standort</a>{$zimmer_IMG}</th>
	<!--
	<th class="{$sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Name</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=adresse&sort_order={$sort_order}">Adresse</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=system&sort_order={$sort_order}">Systemtyp</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=zimmer&sort_order={$sort_order}">Standort</a></th>
	-->
	<th style="width:3.8%;">&nbsp;</th>
    <th style="width:4%;">&nbsp;</th>
	</tr>
	</thead>
	</table>
</div>
<div id="Buchungen">
<table style="width:99.2%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #eee;border-bottom:none;" id="DeviceData">
!#----- Header:End -----#!


!#----- Data:Begin -----#!
	<tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'">
		<td style="width:190px;" class="slider" value="#trinfo{$id}">
			{$name}
		</td>
		<td style="width:190px;" class="slider" value="#trinfo{$id}">
			{$ip_adresse}
		</td>
		<td style="width:200px;"  class="slider" value="#trinfo{$id}">
			{$system}
		</td>
		<td style="width:176px;" class="slider" value="#trinfo{$id}">
			{$zimmer}
		</td>

		<td style="text-align:center;vertical-align:middle;width:30px;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&id={$id}&mode=edit','Kundeninfo','710','800');">
			<img src="syspics/edit.png" alt="Eintrag bearbeiten">
			</a>
		</td>
        <td style="text-align:center;vertical-align:middle;width:30px;border-left:1px;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','auswertung.php?kunde={$kunde}&id={$id}&mode=delete','Kundeninfo','710','800');">
			<img src="syspics/button_drop.png" alt="Eintrag bearbeiten">
			</a>
		</td>
	</tr>
 

	<tr id="trinfo{$id}" class="TRInfo">
		<!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
		<td colspan="6" class="info_schatten4">
			{$InfoTable}
		</td>
	</tr>

!#----- Data:End -----#!


!#----- Footer:Begin -----#!
</table>
</div>
<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}','Kundeninfo','710','800');">
	<img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
!#----- Footer:End -----#!


!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine {$show_kat} bei diesem Kunden eingetragen!
<br /><br />
<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}','Kundeninfo','710','800');">
	<img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
</p>
!#----- Keine_Daten:End -----#!


!#----- Info:Begin -----#!
<table class="DeviceInfo">
	<tr>
		<td class="Key" style="width:90px;">DNS-Name: </td>
		<td class="Value">{$adresse}</td>
		<td class="Key" style="width:90px;">DNS-Stand: </td>
		<td colspan="3" class="Value">{$ts_ip_adresse}</td>
	</tr>
	<tr>
		<td class="Key" style="width:90px;">Ger&auml;te-Typ:</td>
		<td class="Value" style="width:140px;">{$pc}</td>
		<td class="Key" style="width:90px;">SN:</td>
		<td class="Value" style="width:140px;">{$sn}</td>
		<td class="Key" style="width:90px;">Garantie bis:</td>
		<td class="Value" style="width:140px;">{$garantie}</td>        
	</tr>
    <tr>
		<td class="Key" style="width:90px;">Betriebssystem: </td>
		<td class="Value">{$bs}</td>
		<td class="Key" style="width:90px;">Drucker: </td>
		<td colspan="3" class="Value">{$drucker}</td>
	</tr>
	<tr>
		<td class="Key" style="vertical-align:top;">Logins: </td>
		<td class="Value" colspan="5">{$logins}</td>
	</tr>
	<tr>
		<td class="Key">Bemerkung: </td>
		<td class="Value" colspan="5">{$bemerkung}</td>
	</tr>
    <tr>
		<td class="Key" style="vertical-align:top;">Buttons: </td>
		<td class="Value" colspan="5">{$buttons}</td>
	</tr>
    <tr id="TRInfoClose{$id}" class="TRInfoClose">
		<!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
		<td colspan="6" style="text-align:right;">
			<input type="button" value="Info Schließen" onClick="#"></input>
		</td>
	</tr>
</table>
!#----- Info:End -----#!


!#----- Login_Header:Begin -----#!
<table class="Logins_Table">
<tr style="background-color:#666;">
	<th>Typ</th>
	<th>Login</th>
	<th>Passwort</th>
</tr>
!#----- Login_Header:End -----#!


!#----- Login_Main:Begin -----#!
<tr>
	<td class="Key">{$bemerkung}</td>
	<td class="Value">{$geraete_login}</td>
	<td class="Value">{$geraete_pw}</td>
	<!-- <td class="Value" style="text-align:left;">{$bemerkung}</td> -->
</tr>
!#----- Login_Main:End -----#!


!#----- Login_Footer:Begin -----#!
</table>
<br />
!#----- Login_Footer:End -----#!

!#----- Button_Header:Begin -----#!


!#----- Button_Header:End -----#!


!#----- Button_Main:Begin -----#!

	<input type="button" onClick='activex.run("{$activex}");' value='{$bemerkung}'>
    
!#----- Button_Main:End -----#!


!#----- Button_Footer:Begin -----#!

<br />
!#----- Button_Footer:End -----#!
<!-- Ende des Templates -->
