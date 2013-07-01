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
<!-- Home -->
    <div data-role="page" id="page1">
        <div data-theme="a" data-role="header">
            <h3>
                Kundenwahl
            </h3>
        </div>
        <div data-role="content">
            <div data-role="fieldcontain">
                <input name="" id="searchinput2" placeholder="" value="" type="search">
            </div>
            <ul data-role="listview" data-divider-theme="b" data-inset="true">
                <li data-role="list-divider" role="heading">
                    Divider
                </li>
                <li data-theme="c">
                    <a href="#" data-transition="slide">
                        Button
                    </a>
                </li>
                <li data-theme="c">
                    <a href="#page1" data-transition="slide">
                        Button
                    </a>
                </li>
                <li data-theme="c">
                    <a href="#page1" data-transition="slide">
                        Button
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>