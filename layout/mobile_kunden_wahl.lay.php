!#----- Header:Begin -----#!
<!DOCTYPE html> 
<html> 
<head> 
	<title>Kundenwahl</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
</head> 
<body>
<div data-role="page" id="page1">
    <div data-theme="b" data-role="header">
        <h3>
            Kundenwahl
        </h3>
    </div>
    <div data-role="content">
        <div data-role="fieldcontain">
            <input name="" id="searchinput2" placeholder="Direktsuche" value="" type="search">
        </div>
        
        <div data-role="collapsible-set" data-theme="b" data-content-theme="b">
        
        <!--
        <ul data-role="listview" data-divider-theme="b" data-inset="true">-->
!#----- Header:End -----#!

!#----- Main:Begin -----#!
   <div data-role="collapsible" style="padding-top:4px;">
        <h3>
            {$name}
        </h3>
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
                Kategorie
            </li>
            <li data-theme="c">
                <a href="#" data-transition="slide">
                    Server
                </a>
            </li>
            <li data-theme="c">
                <a href="#" data-transition="slide">
                    Computer
                </a>
            </li>
            <li data-theme="c">
                <a href="#" data-transition="slide">
                    Netzwerk
                </a>
            </li>
            <li data-theme="c">
                <a href="#" data-transition="slide">
                    Drucker
                </a>
            </li>
            <li data-theme="c">
                <a href="#page1" data-transition="slide">
                    Zugänge
                </a>
            </li>
        </ul>
    </div>
    <!--
    <li data-theme="c">
        <a href="kunden_wahl_menue.php?kunde={$id}" >
            {$name}
        </a>
    </li>
    -->
!#----- Main:End -----#!
!#----- Footer:Begin -----#!
        </ul>
    </div>
</div>
!#----- Footer:End -----#!
<!-- Ende des Templates -->
        <div data-role="collapsible-set">
            <div data-role="collapsible">
                <h3>
                    Section Header
                </h3>
            </div>
        </div>