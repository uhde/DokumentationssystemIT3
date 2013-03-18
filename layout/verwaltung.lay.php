!#----- Header:Begin -----#!
<div id="frame_devicenav">
	<table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
	<thead>
	<tr>
	<th style="width:92%;" class="{$name_sort_order}">Name</th>

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
    <tr id="Info{$id}" class="Data{$LineClass}" >
        <td class="slider_invisible">
            &#160;
        </td>
		<td class="slider2" value="#trinfo{$id}">
			{$bemerkung}
		</td>
		<td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_prog.php?kunde={$kunde}&id={$id}&mode=edit','Programm Verwaltung','710','270');">
			<img src="syspics/edit.png" alt="Eintrag bearbeiten">
			</a>
		</td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
			<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','auswertung_dokumente.php?name=prog&kunde={$kunde}&id={$id}&mode=delete','Programm Verwaltung','400','200');">
			<img src="syspics/button_drop.png" alt="Eintrag löschen">
			</a>
		</td>
          
	</tr>
  
    <tr id="trinfo{$id}" class="TRInfo">
		<!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
		<td colspan="5" class="info_schatten4">
			<table class="DeviceInfo">
                <tr>
                    <td class="Key" style="width:90px;">Name: </td>
                    <td class="Value">{$name} </td>
                </tr>
                    <td class="Key">URL: </td>
                    <td class="Value" colspan="5">{$url}</td>
                </tr>
                </tr>
                    <td class="Key">ID: </td>
                    <td class="Value" colspan="5">{$id}</td>
                </tr>
                <tr value="#trinfo{$id}" class="TRInfoClose">
                    <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
                    <td colspan="6" style="text-align:right;">
                        <span style="padding-right:10px;"><input type="button"  value="Info Schließen" onClick=""></input></span>
                    </td>
                </tr>
            </table>
		</td>
	</tr>
	
!#----- Data:End -----#!


!#----- Footer:Begin -----#!
</table>
</div>


<br><br><br>
!#----- Footer:End -----#!


!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine Programme eingetragen!
<br /><br />
    <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_prog.php?&mode=create','Programm Verwaltung','710','270');">
		<img src="syspics/new_entry.png" alt="Neues Programm eintragen">&nbsp;&nbsp;Neues Programm eintragen.
    </a>
    <br>
</p>
!#----- Keine_Daten:End -----#!

!#----- Footer2:Begin -----#!
<br /><br />
    <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_prog.php?&mode=create','Programm Verwaltung','710','270');">
		<img src="syspics/new_entry.png" alt="Neues Programm eintragen">&nbsp;&nbsp;Neues Programm eintragen.
    </a>
    <br>
<br><br>
<a href="db_umstellung.php" target="_blank">DB umstellungsscript... Nur bei der Übernahme der alten Datenbank benutzen</a>
<br>
<br>
<table >
    <tr>
        <td>
            <span style="">
                <a href="userconf/ipordns.php?site={$site}" id="boxyfoo" > 
                    <img src="syspics/switch.png" style="width:24px;height:20px;border:none" alt="DNS to IP" title="DNS Name anezeigen">
                </a>
            </span></td>
        <td>    
            : Zeigt DNS-Namen statt IP-Adressen an. Bei einem zweiten Klick wird dies wieder rückgängig gemacht</td>
    </tr>
    <tr>
        <td>
            <br>
            <span style="text-align: center;">
                <a href="userconf/kunden_anzeigen.php?site={$site}" id="boxyfoo" > 
                    <img src="syspics/kunde.png" style="width:24px;height:20px;border:none" alt="Alle Kunden anzeigen" title="Alle Kunden anzeigen">
                    <img src="syspics/switch.png" style="width:24px;height:20px;border:none" alt="Alle Kunden anzeigen" title="Alle Kunden anzeigen">
                </a>
            </span>
        </td>
        <td style="text-align: center;vertical-align: bottom;">
           : Zeigt die "versteckten" Kunden an. Falls diese schon angezeigt werden, werden sie wieder ausgeblendet.
        </td>
    </tr>
</table>
<br><br><br>
!#----- Footer2:End -----#!


<!-- Ende des Templates -->
