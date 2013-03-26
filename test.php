
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
    //var xmlhttp = new ajaxRequest();
    var xmlHttpObject = false;

    // Überprüfen ob XMLHttpRequest-Klasse vorhanden und erzeugen von Objekte für IE7, Firefox, etc.
    if (typeof XMLHttpRequest != 'undefined') 
    {
        xmlHttpObject = new XMLHttpRequest();
    }

    // Wenn im oberen Block noch kein Objekt erzeugt, dann versuche XMLHTTP-Objekt zu erzeugen
    // Notwendig für IE6 oder IE5
    if (!xmlHttpObject) 
    {
        try 
        {
            xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e) 
        {
            try 
            {
                xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e) 
            {
                xmlHttpObject = null;
            }
        }
    }
    
    xmlHttpObject.onreadystatechange=function()
    {
        if (xmlHttpObject.readyState==4 && xmlHttpObject.status==200)
        {
            alert(Test);
            var aufzurufende_id;
            aufzurufende_id = "#"+Test;
           // $(aufzurufende_id).empty();
            $(aufzurufende_id).html(xmlHttpObject.responseText);
            //document.getElementById('trinfo5').innerHTML = xmlHttpObject.responseText;
            //document.getElementById('trinfo5').innerHTML = 'Fred Flinstone';
            alert(xmlHttpObject.responseText);
            alert("last");
        }
    }
    xmlHttpObject.open("GET","getsinglegeraet.php?id="+id,true);
    xmlHttpObject.send();
}
//http://forum.netzgemein.de/ftopic2826.html
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
<tr  class="TRInfo">
	<span id="trinfo5">
    </span>
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
