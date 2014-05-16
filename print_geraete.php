<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=9">
        <!--<meta http-equiv="content-type" content="text/html; charset=utf-8">-->
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link rel="stylesheet" href="css/reset.css" type="text/css" />
        
        <script type='text/javascript'>
        // Diese Funktion lädt die spezifischen Daten einer Sache nach, und fügt dies dann in den dafür
        // vorgesehenen Platz ein.
        function loadXMLDoc(seite,jq_aufzurufende_id,id,time)
        {
            var xmlhttp;
            var timejs = new Date().getTime();
            xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function()
            {
                // Wenn die website mit ajax geladen wurde, wird diese If Anweisung ausgeführt
                // Dort wird dann der geladene Inhalt erst in das Dokument eingebaut
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var aufzurufende_id;
                    aufzurufende_id = "#"+jq_aufzurufende_id;
                    // Hier wird das Feld geleert, bevor etwas neues reingeschrieben wird. 
                    // Dies wird vor allem gemacht, um Fehler im IE vorzubeugen.
                    $(aufzurufende_id).empty();
                    // Hier wird das Feld befüllt
                    $(aufzurufende_id).html(xmlhttp.responseText);
                    //document.getElementById().innerHTML = "Dies ist ein test";
                    //alert(xmlhttp.responseText);
                }
            }
            // Der eigentliche Request.
            xmlhttp.open("GET",seite+"?id="+id+"&time="+timejs,true);
            //alert(seite+"?id="+id+"&time="+time);
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
        </script>
        
        
        
    </head>
    <body>

    <?php 
    //error_reporting(E_ALL);
    //ini_set('display_errors', TRUE);
    session_start() ;
    require_once('include/config.inc.php');
    include_once("include/mysql.class.php");
    include_once("include/template.class.php");
    include_once("include/functions.inc.php");
        $objMySQL = new MySQL();
        if (!$objMySQL->Open(DB_DATABASE, DB_SERVER, DB_USER, DB_PASSWORD)) {
           echo $objMySQL->Error();
           $objMySQL->Kill();
        }
    $objTemplate=new Template("layout/geraete_general.lay.php");
    include ("include/geraete.inc.php");


    ?>
    <br><br><br><br><br><br><br><br>
    <h2>
        <a href="index.php"><img src="syspics/back.png">Zurueck...</a>
    </h2>
    </body>
</html>