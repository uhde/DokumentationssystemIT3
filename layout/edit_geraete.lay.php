!#----- geraeteedit:Begin -----#!
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Kunden verwalten</title>
    
    <meta http-equiv="x-ua-compatible" content="ie=8">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 
    
    <script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
    <script type='text/javascript' src='js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.js'></script>
    <script src="js/ckeditor/ckeditor.js"></script>
    
    <link href="js/ckeditor/skins/moono/editor_ie.css?t=D5AC" rel="stylesheet"/>
    <script src="js/ckeditor/styles.js?t=D5AC" type="text/javascript"></script>
    <script src="js/ckeditor/lang/de.js?t=D5AC" type="text/javascript"></script>
    <style data-cke-temp="1">CSS-Stylesheet</style>
    <style id="cke_ui_color" type="text/css">CSS-Stylesheet</style>
    
    
    
    <script>
    window.onload = function() {
        CKEDITOR.replace( 'bemerkung', {
            on: {
                instanceReady: function( ev ) {
                this.dataProcessor.writer.lineBreakChars = '\n';
                // Output paragraphs as <p>Text</p>.
                    
                }
            }
        }
        );
        CKEDITOR.replace( 'software', {
            on: {
                instanceReady: function( ev ) {
                this.dataProcessor.writer.lineBreakChars = '\n';
                // Output paragraphs as <p>Text</p>.
                    
                }
            }
        }
        );
    };

    </script>
    
</head>


<body style="margin:0;padding:0;">

<form name="Form1" method="post" action="auswertung_kunden_geraete.php?name=geraete&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Name: </span></td>
    <td>
        <span class="StandardText"><input name="name" type="text" size="30" maxlength="30" value="{$name}" ></span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Kunde: </span></td>
    <td>
     {$kundenliste}   
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
    <td align="right"><span class="LinkStyle">IP/DNS Adresse: </span></td>
    <td>
        <span class="StandardText"><input name="adresse" type="text" size="30" maxlength="100" value="{$adresse}" ></span>
    </td>
    <td align="right"><span class="LinkStyle">MAC-Adresse </span></td>
    <td>
        <span class="StandardText"><input name="mac_adresse" type="text" size="17" maxlength="17" value="{$mac_adresse}" > </span>
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
    <td align="right"><span class="LinkStyle">System-Typ </span></td>
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
    <td align="right"><span class="LinkStyle">Ger�te-Typ </span></td>
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
    <td align="right"><span class="LinkStyle">Garantie<br>(TT/MM/JJJJ) </span></td>
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
    <td align="right"><span class="LinkStyle">Standort: </span></td>
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
    <td align="right"><span class="LinkStyle">Irdpport </span></td>
    <td>
        <span class="StandardText"><input name="irdpport" type="text" size="30" maxlength="30" value="{$irdpport}" ></input></span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
    <td colspan="3">
        <textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung_1">
        {$bemerkung}</textarea>
    </td>
</tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Software: </span></td>
    <td colspan="3">
        <textarea name="software" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung_1">
        {$software}</textarea>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

<tr>
    {$login_edit}
</tr>

<tr>
    <td>
        <span class="StandardText">
            Bei dem Programm "Teamviewer Lan" wird das Login Feld nicht �bernommen.<br>
        </span>
    </td>
</tr>

<tr >
    <td align="center" colspan="2">
    
        <input type="submit" value="Speichern" >
    </td>
    <td>
        <input type="submit"  value="Neues Programm hinzuf�gen" onclick="javascript: form.action='auswertung_kunden_geraete.php?name=geraete&mode=edit&kunde={$kunde}&id={$id}&prog_add=5';" />
    </td>
    <td>
        <input type="submit"  value="Kopie des Ger�tes Speichern" onclick="javascript: form.action='auswertung_kunden_geraete.php?name=geraete&mode=create&kunde={$kunde}&kategorie={$kategorie}&kopieren=1';" />
    </td>
</tr>
</form>
<br>

<tr class="Data0">
    <span style="padding-left:35%">
        <td align="right" valign="top"><span class="LinkStyle">Zuf�lliges Passwort: </span></td>
        <td colspan="3">
            <input type="text" value="{$randompassword}">
        </td>
    </span>
</tr>
</table>

</body>
</html>
!#----- geraeteedit:End -----#!





!#----- geraetecreate:Begin -----#!
<html>
<head>
    <title>Kunden verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 
    
    <script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
    <script type='text/javascript' src='js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.js'></script>
    <script src="js/ckeditor/ckeditor.js"></script>
    
    <link href="js/ckeditor/skins/moono/editor_ie.css?t=D5AC" rel="stylesheet"/>
    <script src="js/ckeditor/styles.js?t=D5AC" type="text/javascript"></script>
    <script src="js/ckeditor/lang/de.js?t=D5AC" type="text/javascript"></script>
    <style data-cke-temp="1">CSS-Stylesheet</style>
    <style id="cke_ui_color" type="text/css">CSS-Stylesheet</style>
    
    <script>
    window.onload = function() {
        CKEDITOR.replace( 'bemerkung', {
            on: {
                instanceReady: function( ev ) {
                this.dataProcessor.writer.lineBreakChars = '\n';
                // Output paragraphs as <p>Text</p>.
                    
                }
            }
        }
        );
        CKEDITOR.replace( 'software', {
            on: {
                instanceReady: function( ev ) {
                this.dataProcessor.writer.lineBreakChars = '\n';
                // Output paragraphs as <p>Text</p>.
                    
                }
            }
        }
        );
    };
    </script>
    
</head>


<body style="margin:0;padding:0;">

<form name="Form4" method="post" action="auswertung_kunden_geraete.php?kopieren=0&name=geraete&mode=create&kunde={$kunde}&kategorie={$kategorie}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Name: </span></td>
    <td>
        <span class="StandardText"><input name="name" type="text" size="30" maxlength="30" value="" ></span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">IP/DNS Adresse: </span></td>
    <td>
        <span class="StandardText"><input name="adresse" type="text" size="30" maxlength="100" value="{$adresse}" ></span>
    </td>
    <td align="right"><span class="LinkStyle">MAC-Adresse </span></td>
    <td>
        <span class="StandardText"><input name="mac_adresse" type="text" size="17" maxlength="17" value="{$mac_adresse}" > </span>
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
    <td align="right"><span class="LinkStyle">System-Typ </span></td>
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
    <td align="right"><span class="LinkStyle">Ger�te-Typ </span></td>
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
    <td align="right"><span class="LinkStyle">Garantie<br>(TT/MM/JJJJ) </span></td>
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
    <td align="right"><span class="LinkStyle">Standort: </span></td>
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
    <td align="right"><span class="LinkStyle">Irdpport </span></td>
    <td>
        <span class="StandardText"><input name="irdpport" type="text" size="30" maxlength="30" value="{$irdpport}" ></input></span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
    <td colspan="3">
        <textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
    </td>
</tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Software: </span></td>
    <td colspan="3">
        <textarea name="software" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung_1">
        {$software}</textarea>
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
        <span class="StandardText">
            Klicken sie auf den Button: "Programm hinzuf�gen" um ein, oder mehrere Programme einzupflegen.<br>
        </span>
    </td>
</tr>

<tr >
    <td align="center" colspan="2">
        <input type="submit" value="Speichern" class="button1">
        </td>
     <td>
        <input type="submit"  class="button1" value="Speichern und Neues Programm hinzuf�gen" onclick="javascript: form.action='auswertung_kunden_geraete.php?kopieren=0&name=geraete&mode=create&kunde={$kunde}&kategorie={$kategorie}&prog_add=5';" />
    </td>
</tr>
</form>
<tr class="Data0">
    <span style="padding-left:35%">
        <td align="right" valign="top"><span class="LinkStyle">Zuf�lliges Passwort: </span></td>
        <td colspan="3">
            <input type="text" value="{$randompassword}">
        </td>
    </span>
</tr>
</table>

</body>
</html>

!#----- geraetecreate:End -----#!



!#----- nogeraete:Begin -----#!
<html>
<head>
    <title>Kunden verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 
    
    <script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
    <script type='text/javascript' src='js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.js'></script>
    <script src="js/ckeditor/ckeditor.js"></script>
    
    <link href="js/ckeditor/skins/moono/editor_ie.css?t=D5AC" rel="stylesheet"/>
    <script src="js/ckeditor/styles.js?t=D5AC" type="text/javascript"></script>
    <script src="js/ckeditor/lang/de.js?t=D5AC" type="text/javascript"></script>
    <style data-cke-temp="1">CSS-Stylesheet</style>
    <style id="cke_ui_color" type="text/css">CSS-Stylesheet</style>
    
    <script>
    window.onload = function() {
        CKEDITOR.replace( 'bemerkung', {
            on: {
                instanceReady: function( ev ) {
                this.dataProcessor.writer.lineBreakChars = '\n';
                // Output paragraphs as <p>Text</p>.
                    
                }
            }
        }
        );
    };
    </script>
    
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
    <th>Button?</th>
</tr>
!#----- Login_Header:End -----#!

!#----- Login_Main:Begin -----#!
<tr>
    <td class="Key"><select name="programm_id{$runde}" size="1">{$prog_list}  </select>  </td>
    <td class="Value"><span id="geratelogin"> <input name="login{$runde}" type="text" size="25"  value="{$geraete_login}" ></input></span></td>
    <td class="Value"><input name="passwort{$runde}" type="text" size="25" maxlength="40" value="{$geraete_pw}" ></input></td>
    <td style="text-align:center;"><a href="auswertung_kunden_geraete.php?name=geraete&prog_del=1&geraete_login_id={$geraete_login_id}&id={$geraet_id}&kunde={$kunden_id}" title="L�schen"   >
        <img src="syspics/button_drop.png" style="border:none:width:12px;height:12px;" alt="Programm l�schen"></a></td>
    <td class="Value">
        <input name="prog_aktiv{$runde}" title="Checkbox die darstellt, dass der Button angezeigt werden soll." type="checkbox" {$aktive}></input>
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


!#----- kunden_liste_start:Begin -----#!
<select name="kunde" size="1">
!#----- kunden_liste_start:End -----#!
!#----- kunden_liste_selected:Begin -----#!
<option selected value="{$id}">{$name}</option>
!#----- kunden_liste_selected:End -----#!
!#----- kunden_liste:Begin -----#!
<option value="{$id}">{$name}</option>
!#----- kunden_liste:End -----#!
!#----- kunden_liste_end:Begin -----#!
</select>
!#----- kunden_liste_end:End -----#!

