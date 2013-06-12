!#----- Header:Begin -----#!
<div id="frame_devicenav">
    <table style="padding-right:20px;width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
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
<table style="width:100%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #eee;border-bottom:none;" id="DeviceData">
!#----- Header:End -----#!


!#----- Data:Begin -----#!
    <tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'" >
        <td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$name}
        </td>
        <td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$ip_adresse}
        </td>
        <td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$system}
        </td>
        <td class="slider" value="#trinfo{$id}" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$benutzer}
        </td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
            <a href="#" onclick="activex.run('ping.exe -n 9 {$adresse}');">
                <img src="syspics/Actions-go-next-view-icon.png" alt="Ping" width="11" height="13">
            </a>
        </td>

        <td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="edit_geraete.php?kunde={$kunde}&id={$id}&mode=edit" >
            <img src="syspics/edit.png" alt="Eintrag bearbeiten">
            </a>
        </td>        
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="auswertung_kunden_geraete.php?name=geraete&kunde={$kunde}&id={$id}&mode={$loeschen_mode}&askuser=true" >
                <img src="{$loeschen_img}" alt="Eintrag löschen" width="11" height="13">
            </a>
        </td>
    </tr>
    <tr >
        <td colspan=6 class="info_schatten4">
            <span id="trinfo{$id}" class="TRInfo">
            
            </span>
        </td>
    </tr>
!#----- Data:End -----#!




!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine {$show_kat}-Geräte bei diesem Kunden eingetragen!
<br /><br />
<a class="footer_bt" data-fancybox-type="iframe" href="edit_geraete.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}">
    <img src="syspics/new_entry.png" class="footer_img" alt="Neuer Eintrag" title="Neuer Eintrag">
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
!#----- Button_ping:Begin -----#!

    <span style="float:right;padding-right:10px;"><input type="button" onClick='activex.run("{$activex}");' value='{$bemerkung}'></span>
    
!#----- Button_ping:End -----#!
!#----- Button_Main:Begin -----#!

    <input type="button" onClick='activex.run("{$activex}");' value='{$bemerkung}'>
    
!#----- Button_Main:End -----#!
!#----- Login_Footer:Begin -----#!
</table>
<br />
!#----- Login_Footer:End -----#!
!#----- Footer:Begin -----#!
</table>
    <span class="TRInfoCloseall" style="padding-right:10px;">
        <input type="button"  value="Alle Infos schließen" onClick="ClearAllLoad()"></input>
    </span>
</div>

!#----- Footer:End -----#!
!#----- Footer2:Begin -----#!

<a class="footer_bt" data-fancybox-type="iframe" href="edit_geraete.php?kunde={$kunde}&mode=create&name=geraete&kategorie={$kategorie}">
    <img src="syspics/new_entry.png" class="footer_img" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
<span style="paddin:4px;">&nbsp;</span>
<a class="footer_bt" href="dnsaufloesung.php?site={$site}" id="boxyfoo" > <!--onclick="showboxy('kundenwahl','dnsaufloesung.php','DNS Auflösung','400','200');" -->
    <img src="syspics/button_refresh.png" class="footer_img" alt="DNS Refresh" title="IP Adressen aktualisieren">
</a>
<span style="paddin:4px;">&nbsp;</span>
<a class="footer_bt" href="userconf/ipordns.php?site={$site}" id="boxyfoo" > 
    <img src="syspics/switch.png" class="footer_img" alt="DNS to IP" title="DNS/IP Name anezeigen">
</a>

    <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
!#----- Footer2:End -----#!


<!-- Ende des Templates -->
