!#----- dokumente_edit:Begin -----#!
<html>
<head>
    <title>Dokumente verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?name=dokumente&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Name: </span></td>
    <td>
        <span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
        </span>
    </td>
</tr>
<tr class="Data0">

    <td align="right"><span class="LinkStyle">Dokumentpfadt: </span></td>
    <td>
        <span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <input name="url" type="text" size="50" accept="text/*" value="{$url}">
        </input></span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
    <td colspan="3">
        <textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
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
!#----- dokumente_edit:End -----#!


!#----- dokumente_create:Begin -----#!
<html>
<head>
    <title>Dokumente verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2013-01-03">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?name=dokumente&mode=create&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Name: </span></td>
    <td>
        <span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
        </span>
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Dokumentpfadt: </span></td>
    <td>
        <span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <input name="url" type="text" size="50" accept="text/*">
        </input></span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Bemerkung: </span></td>
    <td colspan="3">
        <textarea name="bemerkung" cols="74" rows="6" wrap="PHYSICAL" id="bemerkung"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$bemerkung}</textarea>
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
!#----- dokumente_create:End -----#!

!#----- prog_edit:Begin -----#!
<html>
<head>
    <title>Programme verwalten</title>
    <meta name="robots" content="INDEX,FOLLOW">
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?&name=prog&mode=edit&kunde={$kunde}&id={$id}">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Angezeigter Name: </span></td>
    <td colspan="3">
        <input name="bemerkung" type="text" size="50" accept="text/*" value="{$bemerkung}">
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Interner Name: </span></td>
    <td>
        <span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
               Dieser Name wird nur Datenbankintern verwendet<br>Bitte ohne Leer- und Sonderzeichen
        </span>
    </td>
</tr>
<tr class="Data0">

    <td align="right"><span class="LinkStyle">Programmbefehl: </span></td>
    <td>
        <span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <textarea name="url" cols="74" rows="6" wrap="PHYSICAL" id="url"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$url}</textarea>

             </span>
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
!#----- prog_edit:End -----#!


!#----- prog_create:Begin -----#!
<html>
<head>
    <title>Programme verwalten</title>
    <meta http-equiv="x-ua-compatible" content="ie=9">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="creation_date" content="2012-11-16">
    <meta name="revisit-after" content="5 days">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <LINK rel="stylesheet" href="css/styles.css"> 

</head>


<body style="margin:0;padding:0;">

<form name="Form1" enctype="multipart/form-data" method="post" action="auswertung_dokumente.php?&name=prog&mode=create">
<table width="700" border="0" cellpadding="4" cellspacing="0"  align="center" bgcolor="#eeeeee">
<tr class="Data0">
    <td align="right" valign="top"><span class="LinkStyle">Angezeigter Name: </span></td>
    <td colspan="3">
        <input name="bemerkung" type="text" size="50" accept="text/*" value="{$bemerkung}">
    </td>
</tr>
<tr class="Data0">
    <td align="right"><span class="LinkStyle">Interner Name: </span></td>
    <td>
        <span class="StandardText">
            <input name="name" type="text" size="30" maxlength="30" value="{$name}" >
            <br> Dieser Name wird nur Datenbankintern verwendet<br>Bitte ohne Leer- und Sonderzeichen
        </span>
    </td>
</tr>
<tr class="Data0">

    <td align="right"><span class="LinkStyle">Programmbefehl: </span></td>
    <td>
        <span class="StandardText">
           <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
             <textarea name="url" cols="74" rows="6" wrap="PHYSICAL" id="url"   onFocus="this.className='aktiv'" onBlur="this.className='text'">{$url}</textarea>
        </span>
    </td>
</tr>
<tr height="14"><td colspan="4" align="center"><hr style="height:1px; color:#cccccc; width:90%"></td></tr>

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
!#----- prog_create:End -----#!

