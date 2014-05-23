!#----- zugaenge_edit:Begin -----#!
<html>
<head>
    <title>Zugänge verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 
</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?&name=zugaenge&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Titel: </span></td>
    <td>
        <span class="StandardText">
            <input name="titel" type="text" size="50" maxlength="60" value="{$titel}" >
        </span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Kunde: </span></td>
    <td>
     {$kundenliste}   
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">URL: </span></td>
    <td>
        <span class="StandardText">
             <input name="url" type="text" size="50" accept="text/*" value="{$url}">
        </input></span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Login: </span></td>
    <td>
        <span class="StandardText">
             <input name="login" type="text" size="50" maxlength="200" value="{$login}">
        </input></span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Passwort: </span></td>
    <td>
        <span class="StandardText">
             <input name="passwort" type="text" size="50" maxlength="200" value="{$passwort}">
        </input></span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Zusatz: </span></td>
    <td colspan="3">
        <textarea name="zusatz" cols="74" rows="6" wrap="PHYSICAL" id="zusatz"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$zusatz}</textarea>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr >
    <td align="center" colspan="2">
        <input type="submit" value="Speichern und Schließen" class="button1">
        
    </td>
</tr>
</form>

</table>

</body>
</html>
!#----- zugaenge_edit:End -----#!


!#----- zugaenge_create:Begin -----#!
<html>
<head>
    <title>Zugänge verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2013-01-03">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?name=zugaenge&mode=create&kunde={$kunde}&id={$id}">
    <table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
        <tr class="Data0">
            <td align="right"><span class="LinkStyle">Titel: </span></td>
            <td>
                <span class="StandardText">
                    <input name="titel" type="text" size="50" maxlength="60" value="{$name}" >
                </span>
            </td>
        </tr>
        <tr class="Data0">
            <td align="right"><span class="LinkStyle">URL: </span></td>
            <td>
                <span class="StandardText">
                     <input name="url" type="text" size="50" accept="text/*" value="{$url}">
                </input></span>
            </td>
        </tr>
        <tr class="Data0">
            <td align="right"><span class="LinkStyle">Login: </span></td>
            <td>
                <span class="StandardText">
                     <input name="login" type="text" size="50" maxlength="200" value="{$login}">
                </input></span>
            </td>
        </tr>
        <tr class="Data0">
            <td align="right"><span class="LinkStyle">Passwort: </span></td>
            <td>
                <span class="StandardText">
                     <input name="passwort" type="text" size="50" maxlength="200" value="{$passwort}">
                </input></span>
            </td>
        </tr>
        <tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
        <tr class="Data0">
            <td align="right" valign="top"><span class="LinkStyle">Zusatz: </span></td>
            <td colspan="3">
                <textarea name="zusatz" cols="74" rows="6" wrap="PHYSICAL" id="zusatz"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$zusatz}</textarea>
            </td>
        </tr>
        <tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
        <tr >
            <td align="center" colspan="2">
                <input type="submit" value="Speichern und Schließen" class="button1">

            </td>
        </tr>
    </table>
</form>

</body>
</html>
!#----- zugaenge_create:End -----#!
