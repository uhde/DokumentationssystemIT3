!#----- Header:Begin -----#!
<div id="frame_devicenav">
	<table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
	<thead>
	<tr>
	<th style="width:92%;" class="{$name_sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Name</a></th>
	
	<!--
	<th class="{$sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Name</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=adresse&sort_order={$sort_order}">Adresse</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=system&sort_order={$sort_order}">Systemtyp</a></th>
	<th class="{$sort_order}"><a href="index.php?sort_name=zimmer&sort_order={$sort_order}">Standort</a></th>
	-->
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
	<tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'">
		<td class="slider_invisible" value="#trinfo{$id}">
            &#160;
        </td>
        <td class="slider2" value="#trinfo{$id}">
			{$name}
		</td>


		<td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
			<a class="edit" data-fancybox-type="iframe" href="edit_bilder.php?kunde={$kunde}&id={$id}&mode=edit">
			<img src="syspics/edit.png" alt="Eintrag bearbeiten">
			</a>
		</td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
			<a class="edit" data-fancybox-type="iframe" href="auswertung_bild.php?kunde={$kunde}&id={$id}&mode=delete&url={$url}" >
			<img src="syspics/button_drop.png" alt="Eintrag löschen">
			</a>
		</td>
	</tr>
    <tr id="trinfo{$id}" class="TRInfo">
		<!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
		<td colspan="5" class="info_schatten4">
            
            <br>
            <table class="DeviceInfo">
                <tr>
                    <td>
                        <a href="#" onClick="showboxy('kundenwahl','{$bigurl}','{$name}','990','735');"><img src="{$url}" alt="Bild kann nicht angezeigt werden, der Pfadt ist folgender: {$url}"></a>
                    <td>
                </tr>

                <tr>
                    <td>Bemerkung: {$bemerkung} </td>
                </tr>
                <tr value="#trinfo{$id}" class="TRInfoClose">
                    <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
                    <td colspan="6" style="text-align:right;">
                        <input type="button" value="Info Schließen" onClick=""></input>
                    </td>
                </tr>
                <tr>
                   <td> URL: {$url}</td>
                </tr>
                
            </table>
		</td>
	</tr>
	
!#----- Data:End -----#!


!#----- Footer:Begin -----#!
</table>
</div>
<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_bilder.php?kunde={$kunde}&mode=create','Bilder','710','270');">
		<img src="syspics/new_entry.png" alt="Neues Bild eintragen">&nbsp;&nbsp;Neues Bild hochladen.
</a>
!#----- Footer:End -----#!


!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine Bilder bei diesem Kunden eingetragen!
<br /><br />
    <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_bilder.php?kunde={$kunde}&mode=create','Bilder','710','270');">
		<img src="syspics/new_entry.png" alt="Neues Bild eintragen">&nbsp;&nbsp;Neues Bild hochladen.
    </a>
</p>
!#----- Keine_Daten:End -----#!



<!-- Ende des Templates -->
