@echo off

del output.*
php friendlist.php -h
php friendlist.php -u jamiephan -o output.xml
start "" notepad.exe output.xml
php friendlist.php -u xexex -o output.json
start "" notepad.exe output.json
php friendlist.php -u qoop12 -o output.php
start "" notepad.exe output.php
php friendlist.php -u lovemelody01 -o output.txt
start "" notepad.exe output.txt
php friendlist.php -u haska -o output.csv
start "" notepad.exe output.csv
php friendlist.php -u a840513 -o output.asdasd
start "" notepad.exe output.asdasd