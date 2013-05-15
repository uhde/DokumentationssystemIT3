!#----- Header:Begin -----#!
<div id="frame_devicenav">
    <table style="width:98%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #ddd;" id="DeviceData">
    <thead>
    <tr>
    <th  class="{$name_sort_order}"><a href="index.php?sort_name=name&sort_order={$sort_order}">Titel</a></th>
    <th style="width:25%;">&nbsp;</th>
    <th style="width:25%;">&nbsp;</th>
    <th style="width:25%;">&nbsp;</th>
    
    {$suche_titel}
    <th style="width:4%;">&nbsp;</th>
    <th style="width:4%;">&nbsp;</th>
    </tr>
    </thead>
    </table>
</div>
<div id="Buchungen2">
<table style="width:98.18%;border:none;background-color:#666;border-collapse:collapse;border:1px solid #eee;border-bottom:none;" id="DeviceData">
!#----- Header:End -----#!


!#----- Data:Begin -----#!
    <tr id="Info{$id}" class="Data{$LineClass}" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data{$LineClass}'">
        
        <td class="slider3" value="#trinfo{$id}" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
                {$titel}
        </td>
        <td class="slider3" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$login}
        </td>
        <td class="slider3" onclick="loadXMLDoc('include/getsinglegeraet.php','trinfo{$id}','{$id}','{$time}')">
            {$passwort}
        </td>
        {$suche_kunde}
        <td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="edit_zugaenge.php?kunde={$kunde}&id={$id}&mode=edit" >
            <img src="syspics/edit.png" alt="Eintrag bearbeiten">
            </a>
        </td>
        <td style="text-align:center;vertical-align:middle;width:4%;border-left:1px solid #aaa;border-top:1px solid #ccc;">
            <a class="edit" data-fancybox-type="iframe" href="auswertung_dokumente.php?name=zugaenge&kunde={$kunde}&id={$id}&mode=delete" >
            <img src="syspics/button_drop.png" alt="Eintrag löschen">
            </a>
        </td>
    </tr>
    <tr id="trinfo{$id}" class="TRInfo">
        <!--<td colspan="5" style="background-color:#fff;border-bottom:1px solid #333;padding-left:0px;padding-right:0px;padding-bottom:0px;border-top:1px solid #ddd;">-->
        <td colspan="5" class="info_schatten4">
            
        </td>
    </tr>
    
!#----- Data:End -----#!


!#----- Footer:Begin -----#!
</table>
</div>
<a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','edit_zugaenge.php?mode=create&kunde={$kunde}','Zugänge','700','300');">
<!--<a href="index.php?page=<?php  /*if (file_exists($add_page)) { echo $add_page; } */?> ">-->
    <img src="syspics/new_entry.png" style="width:24px;height:20px;border:none" alt="Neuer Eintrag" title="Neuer Eintrag">
</a>
!#----- Footer:End -----#!
!#----- Footer2:Begin -----#!
</table>
</div>

!#----- Footer2:End -----#!


!#----- Keine_Daten:Begin -----#!
<p class="Keine_Daten">
Es sind keine Zugang bei diesem Kunden eingetragen!
<br /><br />
<a href="#">
<img src="syspics/edit.png" alt="Neuen Zugang erfassen">&nbsp;&nbsp;Neuen Zugang erfassen
</a>
</p>
!#----- Keine_Daten:End -----#!



<!-- Ende des Templates -->
