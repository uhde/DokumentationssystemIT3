
<html>
<head>
<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>
<script type='text/javascript'>
<!--
function ajaxRequest(){
    var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
    if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
        for (var i=0; i<activexmodes.length; i++){
            try{
                return new ActiveXObject(activexmodes[i])
            }
               catch(e){
                //suppress error
            }
        }
    }
    else if (window.XMLHttpRequest) // if Mozilla, Safari etc
        return new XMLHttpRequest()
    else
        return false
}
function loadXMLDoc(Test,id)
{
    var xmlhttp = new ajaxRequest();
    
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
</html>

<?php /*
<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>

<script type="text/javascript">
function changeText(){

            var aufzurufende_id;
            aufzurufende_id = "#boldStuff";

            $(aufzurufende_id).html('Fred Flinstone');

}
</script>
<p>Welcome to the site <b id='boldStuff'>dude</b> </p> 
<input type='button' onclick='changeText()' value='Change Text'/>

*/ ?>
