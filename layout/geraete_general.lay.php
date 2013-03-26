!#----- Header:Begin -----#!
<div id="frame_devicenav">
	<table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
	<thead>
	<tr>
	<th style="width:23%;text-align:center;vertical-align:middle;" class="{$name_sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Name</a>{$name_IMG}</th>
	<th style="width:23%;text-align:center;vertical-align:middle;" class="{$adresse_sort_order}"><a href="index.php?sort_name=adresse&sort_order={$sort_order}">IP-Adresse</a>{$ip_adresse_IMG}</th>
	<th style="width:23%;text-align:center;vertical-align:middle;" class="{$system_sort_order}"><a href="index.php?sort_name=system&sort_order={$sort_order}">Systemtyp</a>{$system_IMG}</th>
	<th style="width:23%;text-align:center;vertical-align:middle;" class="{$benutzer_sort_order}"><a href="index.php?sort_name=benutzer&sort_order={$sort_order}">Benutzer</a>{$zimmer_IMG}</th>

	<th style="width:4%;">&nbsp;</th>
    <th style="width:4%;">&nbsp;</th>
	</tr>
	</thead>
	</table>
</div>
<div id="Buchungen">
<table style="width:98.18%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #eee;border-bottom:none;" id="DeviceData">
!#----- Header:End -----#!


!#----- Data:Begin -----#!
	<tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'" >
		<td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('trinfo{$id}','{$id}')">
			{$name}
		</td>
		<td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('trinfo{$id}','{$id}')">
			{$ip_adresse}
		</td>
		<td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('trinfo{$id}','{$id}')">
			{$system}
		</td>
		<td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('trinfo{$id}','{$id}')">
			{$benutzer}
		</td>

		<td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&id={$id}&mode=edit','Ger�te bearbeiten','720','720');">
			<img src="syspics/edit.png" alt="Eintrag bearbeiten">
			</a>
		</td>        
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','auswertung.php?name=geraete&kunde={$kunde}&id={$id}&mode=delete&askuser=true','Ger�t l�schen','720','200');">
			<img src="syspics/button_drop.png" alt="Eintrag l�schen">
			</a>
		</td>
	</tr>
	<tr >
        <td colspan=6 >
            <span id="trinfo{$id}" class="TRInfo">
            
            </span>
        </td>
	</tr>

!#----- Data:End -----#!




!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine {$show_kat}-Ger�te bei diesem Kunden eingetragen!
<br /><br />
<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}','Ger�t eintragen','720','720');">
	<img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
</p>
!#----- Keine_Daten:End -----#!


!#----- Info:Begin -----#!
 
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

!#----- Button_Main:Begin -----#!

	<input type="button" onClick='activex.run("{$activex}");' value='{$bemerkung}'>
    
!#----- Button_Main:End -----#!
!#----- Button_ping:Begin -----#!

	<span style="float:right;padding-right:10px;"><input type="button" onClick='activex.run("{$activex}");' value='{$bemerkung}'></span>
    
!#----- Button_ping:End -----#!

!#----- Login_Footer:Begin -----#!
</table>
<br />
!#----- Login_Footer:End -----#!
!#----- Footer:Begin -----#!
</table>
<span class="TRInfoCloseall" style="padding-right:10px;">
    <input type="button"  value="Alle Infos schlie�en" onClick="ClearAllLoad()"></input>
</span>
</div>

!#----- Footer:End -----#!
!#----- Footer2:Begin -----#!

<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}','Ger�t eintragen','720','720');">
	<img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
<span style="">
    <a href="dnsaufloesung.php?site={$site}" id="boxyfoo" > <!--onclick="showboxy('kundenwahl','dnsaufloesung.php','DNS Aufl�sung','400','200');" -->
        <img src="syspics/button_refresh.png" style="width:24px;height:20px;border:none" alt="DNS Refresh" title="IP Adressen aktualisieren">
    </a>
</span>
<span style="">
    <a href="userconf/ipordns.php?site={$site}" id="boxyfoo" > 
        <img src="syspics/switch.png" style="width:24px;height:20px;border:none" alt="DNS to IP" title="DNS/IP Name anezeigen">
    </a>
</span>
    <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
!#----- Footer2:End -----#!


<!-- Ende des Templates -->
