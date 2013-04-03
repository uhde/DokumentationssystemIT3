
<html>
<head>
<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>+
<link rel="stylesheet" href="js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
<script type='text/javascript' src='js/fancyapps-fancyBox-0ffc358/source/jquery.fancybox.js'></script>
<script type='text/javascript'>
$(document).ready(function() {
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>

<title>Testseite</title>
</head>
<body>

<form>
<div id="Buchungen">
<table>
<tr id="Info5" class="Data0" onmouseover="this.className='Aktiv'"  onmouseout="this.className='Data0'" >
    <td style="text-align:center;vertical-align:middle;width:4%;border-top:1px solid #ccc;">
        <a href="#" id="boxyfoo" onclick="showboxy('kundenwahl','geraeteedit.php?kunde={$kunde}&id={$id}&mode=edit','Geräte bearbeiten','720','720');">
        <img src="syspics/edit.png" alt="Eintrag bearbeiten">
        </a>
        <a class="fancybox" rel="gallery1" href="http://farm9.staticflickr.com/8200/8207750975_bd288a2a1f_b.jpg" title="Templanza (Chico Team)">
            <img src="http://farm9.staticflickr.com/8200/8207750975_bd288a2a1f_m.jpg" alt="" />
        </a>
    </td> 
</tr>


</table>

</div>

</body>
</html>

