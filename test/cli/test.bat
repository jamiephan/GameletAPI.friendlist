 rem   _____                      _      _            _____ _____ 
 rem  / ____|                    | |    | |     /\   |  __ \_   _|
 rem | |  __  __ _ _ __ ___   ___| | ___| |_   /  \  | |__) || |  
 rem | | |_ |/ _` | '_ ` _ \ / _ \ |/ _ \ __| / /\ \ |  ___/ | |  
 rem | |__| | (_| | | | | | |  __/ |  __/ |_ / ____ \| |    _| |_ 
 rem  \_____|\__,_|_| |_| |_|\___|_|\___|\__/_/    \_\_|   |_____|
 rem                       __      _                _ _ _     _   
 rem                      / _|    (_)              | | (_)   | |  
 rem                     | |_ _ __ _  ___ _ __   __| | |_ ___| |_ 
 rem                     |  _| '__| |/ _ \ '_ \ / _` | | / __| __|
 rem                     | | | |  | |  __/ | | | (_| | | \__ \ |_ 
 rem                     |_| |_|  |_|\___|_| |_|\__,_|_|_|___/\__|

 rem                   +-----------------------------------------+
 rem                   |               By Jamie Phan [Lovemelody]|
 rem                   |                https://www.jamiephan.net|
 rem                   |tw.gamelet.com/user.do?username=jamiephan|
 rem                   +-----------------------------------------+
@echo off

del output.*
php ../../cli/friendlist.php -h
php ../../cli/friendlist.php -u jamiephan -o output.xml
php ../../cli/friendlist.php -u jamiephan -o output.json
php ../../cli/friendlist.php -u jamiephan -o output.php
php ../../cli/friendlist.php -u jamiephan -o output.txt
php ../../cli/friendlist.php -u jamiephan -o output.csv
php ../../cli/friendlist.php -u jamiephan -o output.rAnDomFiLe