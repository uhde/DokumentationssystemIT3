<?
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
*/
session_start();
//ob_start("ob_gzhandler");
require('include/config.inc.php');
include("include/mysql.class.php");
include("include/template.class.php");
include("include/functions.inc.php");
include("userconf/benutzer_verwaltung.php"); 


// DB-Connect
$objMySQL = new MySQL();
if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
   echo $objMySQL->Error();
   $objMySQL->Kill();
}


// Ger�tetyp setzen
if (isset($_GET['device_type']) AND !empty($_GET['device_type'])) {
	$_SESSION['device_type']=$_GET['device_type'];
}else{
	if (!isset($_SESSION['device_type']) OR empty($_SESSION['device_type'])) {
		$_SESSION['device_type']=1;
	}
}


// Kunden-ID setzen
if (isset($_GET['knd_id'])) {
	$_SESSION['knd_id']=$_GET['knd_id'];
	if (isset($_SESSION['old_knd_id'])) {
		$_SESSION['old_knd_id']=$_GET['knd_id'];
	}

	/*if ($_SESSION['knd_id']<>$_SESSION['old_knd_id']) {
		$_SESSION['device_type']=1;
	}*/
}



// Seite setzen
$page=$arrTopmenu[1]['file'];

if (isset($_POST['page']) AND !empty($_POST['page'])) {
	$page=$_POST['page'];
    $_SESSION["page"]=$_POST['page'];
}else{
	if (isset($_GET['page']) AND !empty($_GET['page'])) {
		$page=$_GET['page'];
        $_SESSION["page"]=$_GET['page'];
	}else{
        if (!(isset($_SESSION['page']) AND !empty($_SESSION['page']))) {
            // Das hier wird gesetzt damit beim ersten �ffnen keine 404-Seite auftaucht.
            $_SESSION['page']=$arrTopmenu[1]['file'];
            $page=$_SESSION['page'];
        }else{
            $page=$_SESSION['page'];
        }
	}
}


// Existiert Seite oder Fehler?
if (file_exists($page.'.php')) {
	$page=$page.'.php';
}else{
	if (file_exists($page.'.html')) {
		$page=$page.'.html';
	}else{
		$error_page=$page;
		$page='error404.php';
	}
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<span style="font-family: Verdana, Arial, Helvetica, sans-serif;">
<title>DokuIT - Dokumentationsverwaltung v3</title>
</span>

<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/frames.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link rel="stylesheet" href="css/topmenu.css" type="text/css" />

<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>
<link rel="stylesheet" href="js/boxy/stylesheets/boxy.css" type="text/css" />
<script type='text/javascript' src='js/boxy/javascripts/jquery.boxy.js'></script>


<script type='text/javascript'>

function loadXMLDoc(Test,id)
{
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //alert(Test);
            var aufzurufende_id;
            aufzurufende_id = "#"+Test;
            $(aufzurufende_id).empty();
            $(aufzurufende_id).html(xmlhttp.responseText);
            //document.getElementById(Test).innerHTML = "Dies ist ein test";
            //alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET","getsinglegeraet.php?id="+id,true);
    xmlhttp.send();
}
function ClearLoad(Test)
{
    var aufzurufende_id;
    aufzurufende_id = "#"+Test;
    $(aufzurufende_id).html("");
}
function ClearAllLoad()
{
    $(".TRInfo").text(" ");
}

</script>


<script type='text/javascript'>
// Wird zum aufpoppen lassen von boxy verwendet. 
	function showboxy(myactuator,url,title,width,height) {
		mycontent='<iframe application="yes" width="' + width + '" height="' + height + '" border=0 src="' + url + '">You need a Browser which can display iframes</iframe>';
		new Boxy( mycontent, {unloadOnHide: true, draggable: true, show: true, modal: true, title: title, closeText:"<img src='syspics/close_window.png' border=0 title='Schlie�en' alt='Schlie�en'>", actuator: $('#'+myactuator)[0]});
	}
    function loadboxy() {
        alert('2');
    }
    function slider_generell() {
        $(this).toggleClass("up");
        name=$(this).attr("value");
       // $("#Buchungen .TRInfo").hide();
        if($(this).hasClass('up')) {
            $(name).show();
        }else{
            $(name).hide();
        }
        //Funktioniert nicht... wieso?
        //vll wegen. $(this)
    }
    
   
	$(document).ready(function() {
			// Erstmal alle ausblende
            // Wird beim reload der Page angewendet
	 	     $("#Buchungen .TRInfo").hide();
            // Alles was in dieser "onklick" funktion steht wird angewendet, sobald auf eins geklickt wird
			 $("#Buchungen .slider").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
               // $("#Buchungen .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }

			});
             $("#Buchungen .slider_invisible").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                //$("#Buchungen2 .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
            $("#Buchungen .slider2").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                //$("#Buchungen .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
            $("#Buchungen .TRInfoClose").click(function(){
                $(this).toggleClass("up");
				name=$(this).attr("value");
                $(name).hide();
            });
            $("#Buchungen .TRInfoCloseall").click(function(){
                $("#Buchungen .TRInfo").hide();
            });
            
            // Das gleiche wird f�r die Suchfunktion noch 2 mal gemacht, da bei der Suche es immer nur eine buchungs-id geben kann.
             // Wird bei Zug�nge.php benutzt
             $("#Buchungen2 .TRInfo").hide();
            // Alles was in dieser "onklick" funktion steht wird angewendet, sobald auf eins geklickt wird

            $("#Buchungen2 .slider3").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                //$("#Buchungen2 .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
            $("#Buchungen2 .slider_invisible").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
            $("#Buchungen2 .TRInfoClose").click(function(){
                $(this).toggleClass("up");
				name=$(this).attr("value");
                $(name).hide();
                
            });
            
            
            // Wird bei dokumente.lay.php benutzt
            $("#Buchungen3 .TRInfo").hide();

            $("#Buchungen3 .slider2").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                //$("#Buchungen3 .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
             $("#Buchungen3 .slider_invisible").click(function(){
				$(this).toggleClass("up");
				name=$(this).attr("value");
                //$("#Buchungen2 .TRInfo").hide();
                if($(this).hasClass('up')) {
					$(name).show();
				}else{
					$(name).hide();
                }
			});
            $("#Buchungen3 .TRInfoClose").click(function(){
                $(this).toggleClass("up");
				name=$(this).attr("value");
                $(name).hide();
            });

	});

</script>

<script language="JavaScript" type="text/javascript">
    <!--
    var activex = new ActiveXObject("wscript.shell");
    //-->
</script>
</head>

<body style="overflow:hidden;">

<div id="frame_left">
<div class="content_area">
<!-- Hiermit wird die Anzeige des linken Frames mit der Auflistung aller Kunden bewirkt -->
<? include('kunden.php'); ?>
</div>
</div>

<!-- Leiste ganz oben -->
<div id="frame_top">
<div class="content_area">
<table width="100%" height="30" border="0" align="center">
<tr>
	<td valign="middle" style="padding-top:6px;padding-left:10px;">
		<span style="font-size:16pt; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold; color:#FFFFFF;">
			DokuIT v3.4
		</span>
	</td>
	<td width="200" align="right" style="vertical-align: middle;text-align:right; padding-right:10px;">
        <a onclick='activex.run("F:/Fernwartung/TV_Start/tv_starter.exe");' style="text-align:right;color:#FFFFFF; font-weight:bold; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:10pt;vertical-align: middle;" href="#">
            Teamviewer
       </a> 
	</td>
	
    <td width="50" align="left" style="vertical-align: middle;" >
        <a href="index.php?page=verwaltung&device_type=10" target="_self" style="color:#FFFFFF; font-weight:bold; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:10pt;vertical-align: middle;">
            Verwaltung
        </a>
    </td>
    <td width="130" style="vertical-align: middle;" >
        <div style="float:right; ">
            <form method="post" action="index.php?page=suche&suche=uhdsrv&device_type=42">
                <input name="suchfeld" type='text' size="10" maxlength="30">
                <input type="image" src="syspics/search.png" title="Suchen" alt="Absenden" style="width:20px;height:20px;border:none">
            </form>
        </div>
	</td>
    
</tr>
</table>
</div>
</div>


<div id="frame_topnav">
<div class="content_area">
<? include('topmenu.php'); ?>
</div>
</div>


<div id="frame_bottom">
<div class="content_area">
</div>
</div>


<div id="frame_main"  style="overflow-y:scroll;padding-left:4px;">
<div class="content_area">
<?
require($page);
?>
</div>
</div>

<!-- overlayed element -->
<div class="modal" id="overlay" >
	<div class="contentWrap"></div>
	<p>
		<button class="close"> Abbruch </button>
	</p>
</div>

</body>
</html>

<?
session_write_close();
//ob_end_flush();
?>