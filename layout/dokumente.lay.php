!#----- Header:Begin -----#!
<div id="frame_devicenav">
    <table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
    <thead>
    <tr>
    <th style="width:100%px;" class="{$name_sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Titel</a></th>
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
<div id="Buchungen3">
<table style="width:98.18%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #eee;border-bottom:none;" id="DeviceData">
!#----- Header:End -----#!


!#----- Data:Begin -----#!
    <tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'">
        <td class="slider_invisible" value="#trinfo{$id}">
            &#160;
        </td>
        <td  class="slider2" value="#trinfo{$id}">
            {$name}
        </td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="edit_dokumente.php?kunde={$kunde}&id={$id}&mode=edit" >
            <img src="syspics/edit.png" alt="Eintrag bearbeiten">
            </a>
        </td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="auswertung_dokumente.php?name=dokumente&kunde={$kunde}&id={$id}&mode=delete" >
            <img src="syspics/button_drop.png" alt="Eintrag löschen">
            </a>
        </td>
    </tr>
    <tr id="trinfo{$id}" class="TRInfo">
        <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
        <td colspan="5" class="info_schatten4">
            <table class="DeviceInfo">
                <tr>
                    <td class="Key" style="width:90px;">Link: </td>
                    <td class="Value">
                    <input type="button" onClick='activex.run( "{$url}")' value="{$url}"></a></td>
                </tr>
                    <td class="Key">Bemerkung: </td>
                    <td class="Value" colspan="5">{$bemerkung}</td>
                </tr>
                </tr>
                    <td class="Key">URL: </td>
                    <td class="Value" colspan="5">{$url}</td>
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
<br>
    <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_dokumente.php?kunde={$kunde}&mode=create','Dokumente','710','270');">
        <img src="syspics/new_entry.png" alt="Dokument hinzufügen">Dokument hinzufügen
    </a>
   <br><br><br>
    Sollte der Button nicht funktionieren, kopieren sie die URL (aus dem Feld URL) <br>und fügen sie diese in die Adressleiste des Windows Datei-explorer ein.<br>
    Der Button könnte aus folgenden Gründen nicht funktionieren:<br><br>
    - Die URL ist ein UNC Pfadt<br>
    - In der URL befindet sich ein Leerzeichen
    
   
!#----- Footer:End -----#!

!#----- Footer2:Begin -----#!
</table>
</div>
<br>    
   
!#----- Footer2:End -----#!


!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine Dokumente bei diesem Kunden eingetragen!
<br /><br />
    <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_dokumente.php?kunde={$kunde}&mode=create','Dokumente','710','270');">
        <img src="syspics/new_entry.png" alt="Dokument hinzufügen"> Dokument hinzufügen
    </a>
</p>
!#----- Keine_Daten:End -----#!



<!-- Ende des Templates -->
