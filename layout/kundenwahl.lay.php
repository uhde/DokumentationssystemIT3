!#----- Header:Begin -----#!
<p class="Kundenwahl">&nbsp;Kunden</p>
<table width="100%" border="0" cellspacing="0"  align="left">
<style>
.K_change_bt {
    border-style:groove;
    border-width:4px;
    border-color:green;
    padding-left=6px;
    border-top-width:0px;
}
</style>
!#----- Header:End -----#!


!#----- Main:Begin -----#!
<tr class="Data{$LineClass}">

	<td align="left">
		<a href="index.php?knd_id={$id}" target="_top">{$name}</a>
	</td>
    <td align="left" style="padding-left:3px;padding-top:3px;padding-bottom:3px;" title="Kunde Verstecken">
		<a href="userconf/kunden_benutzerdefiniert_verstecken.php?knd_id={$id}&site=/dokuit3/index.php">
            <img src="syspics/user_invisible.png" style="border:none:width:12px;height:12px;" alt="Kunde Verstecken"></a>
    </td>
    <td align="left" style="padding-left:3px;padding-top:3px;padding-bottom:3px;">
        <a class="edit" data-fancybox-type="iframe" href="edit_kunden.php?knd_id={$id}" >
            <img src="syspics/info.png" style="border:none:width:12px;height:12px;" alt="Kundeninfo">
        </a>
    </td>
</tr>
<tr><td colspan="2" height="5"></td></tr>
!#----- Main:End -----#!

!#----- Footer:Begin -----#!
<tr>
    <td>
        <a class="K_change_bt" data-fancybox-type="iframe" href="edit_kunden.php?create=true">
            <img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
        </a>
    
        <a href="userconf/kunden_anzeigen.php?site=/dokuit3/index.php" class="K_change_bt" > 
            <img src="syspics/kunde.png" style="width:24px;height:20px;border:none" alt="Alle Kunden anzeigen" title="Kunden anzeigen/verstecken">
            <img src="syspics/switch.png" style="width:24px;height:20px;border:none" alt="Alle Kunden anzeigen" title="Kunden anzeigen/verstecken">
        </a>
    </td>
</tr>
</table>

!#----- Footer:End -----#!
<!-- Ende des Templates -->
