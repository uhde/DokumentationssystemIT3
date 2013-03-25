<?php
/*
<html>
<head>
<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>
<script>
<!--
function loadXMLDoc(Test,id)
{
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            alert(Test);
            var aufzurufende_id;
            aufzurufende_id = "#"+Test;
            //$(aufzurufende_id).empty();
            alert(id);
            //$(aufzurufende_id).html(xmlhttp.responseText);
            //document.getElementById('trinfo5').innerHTML = xmlhttp.responseText;
            document.getElementById('trinfo5').innerHTML = 'Fred Flinstone';
            alert(xmlhttp.responseText);
            alert("last");
        }
    }
    xmlhttp.open("GET","getsinglegeraet.php?id="+id,true);
    xmlhttp.send();
}
//-->
</script>
<title>Funktion bei Wechsel im Select-Feld ausführen (onChange)</title>
</head>
<body>

<form>
<div id="Buchungen">
<table>
<tr id="Info5" class="Data0" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data0'" >
    <td class="slider" value="#trinfo5" onclick="loadXMLDoc('trinfo5','5')">
        name
    </td>
</tr>
<tr id="trinfo5" class="TRInfo">
	<td>test</td>
</tr>

</table>

</div>

</body>
</html>*/
?>
<script type="text/javascript">
function loadXMLDoc(Test,id)
{
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            alert(Test);
            var aufzurufende_id;
            aufzurufende_id = "#"+Test;
            //$(aufzurufende_id).empty();
            alert(id);
            //$(aufzurufende_id).html(xmlhttp.responseText);
            //document.getElementById('trinfo5').innerHTML = xmlhttp.responseText;
            document.getElementById('trinfo5').innerHTML = 'Fred Flinstone';
            alert(xmlhttp.responseText);
            alert("last");
        }
    }
    xmlhttp.open("GET","getsinglegeraet.php?id="+id,true);
    xmlhttp.send();
}

</script>
<script type="text/javascript">
function changeText(){
	var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            alert(Test);
            var aufzurufende_id;
            aufzurufende_id = "#"+Test;
            document.getElementById('boldStuff').innerHTML = 'Fred Flinstone';

            alert(xmlhttp.responseText);
            alert("last");
        }
    }
    xmlhttp.open("GET","getsinglegeraet.php?id="+id,true);
    xmlhttp.send();
}
</script>
<p>Welcome to the site <b id='boldStuff'>dude</b> </p> 
<input type='button' onclick='changeText()' value='Change Text'/>
