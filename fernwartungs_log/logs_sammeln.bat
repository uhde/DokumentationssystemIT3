@echo off
REM Author Micha Grüninger
REM Dieses Script wird benutzt um Teamviewerlogs zentral zu sammeln
REM Script erzeugt am 23.07.2013
xcopy "%APPDATA%\Teamviewer\Connections.txt" \\uhdsrv04\webserver\dokuit3\teamviewer_log\%Username%\Connections.txt /c /r /d /y /i 
REM /c: Ignore Errors, /r copy read-only files, /d nur Dateien kopieren die neuer als im Zielordner sind
REM /y: supress confirm to overwrite, /i mann kann verzeichnisse oder wildcards benutzen 