rem    _____                      _      _            _____ _____ 
rem   / ____|                    | |    | |     /\   |  __ \_   _|
rem  | |  __  __ _ _ __ ___   ___| | ___| |_   /  \  | |__) || |  
rem  | | |_ |/ _` | '_ ` _ \ / _ \ |/ _ \ __| / /\ \ |  ___/ | |  
rem  | |__| | (_| | | | | | |  __/ |  __/ |_ / ____ \| |    _| |_ 
rem   \_____|\__,_|_| |_| |_|\___|_|\___|\__/_/    \_\_|   |_____|
rem                        __      _                _ _ _     _   
rem                       / _|    (_)              | | (_)   | |  
rem                      | |_ _ __ _  ___ _ __   __| | |_ ___| |_ 
rem                      |  _| '__| |/ _ \ '_ \ / _` | | / __| __|
rem                      | | | |  | |  __/ | | | (_| | | \__ \ |_ 
rem                      |_| |_|  |_|\___|_| |_|\__,_|_|_|___/\__|
rem 
rem                    +-----------------------------------------+
rem                    |               By Jamie Phan [Lovemelody]|
rem                    |                https://www.jamiephan.net|
rem                    |tw.gamelet.com/user.do?username=jamiephan|
rem                    +-----------------------------------------+
rem  
rem  Copyright 2017 Jamie Phan

rem  Licensed under the Apache License, Version 2.0 (the "License");
rem  you may not use this file except in compliance with the License.
rem  You may obtain a copy of the License at

rem      http://www.apache.org/licenses/LICENSE-2.0

rem  Unless required by applicable law or agreed to in writing, software
rem  distributed under the License is distributed on an "AS IS" BASIS,
rem  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
rem  See the License for the specific language governing permissions and
rem  limitations under the License.

@echo off

del output.*
php ../../cli/friendlist.php -h
php ../../cli/friendlist.php -u jamiephan -o output.xml
php ../../cli/friendlist.php -u jamiephan -o output.json
php ../../cli/friendlist.php -u jamiephan -o output.php
php ../../cli/friendlist.php -u jamiephan -o output.txt
php ../../cli/friendlist.php -u jamiephan -o output.csv
php ../../cli/friendlist.php -u jamiephan -o output.rAnDomFiLe