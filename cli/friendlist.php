<?php 
//   _____                      _      _            _____ _____ 
//  / ____|                    | |    | |     /\   |  __ \_   _|
// | |  __  __ _ _ __ ___   ___| | ___| |_   /  \  | |__) || |  
// | | |_ |/ _` | '_ ` _ \ / _ \ |/ _ \ __| / /\ \ |  ___/ | |  
// | |__| | (_| | | | | | |  __/ |  __/ |_ / ____ \| |    _| |_ 
//  \_____|\__,_|_| |_| |_|\___|_|\___|\__/_/    \_\_|   |_____|
//                       __      _                _ _ _     _   
//                      / _|    (_)              | | (_)   | |  
//                     | |_ _ __ _  ___ _ __   __| | |_ ___| |_ 
//                     |  _| '__| |/ _ \ '_ \ / _` | | / __| __|
//                     | | | |  | |  __/ | | | (_| | | \__ \ |_ 
//                     |_| |_|  |_|\___|_| |_|\__,_|_|_|___/\__|
//
//                   +-----------------------------------------+
//                   |               By Jamie Phan [Lovemelody]|
//                   |                https://www.jamiephan.net|
//                   |tw.gamelet.com/user.do?username=jamiephan|
//                   +-----------------------------------------+
// 
// Copyright 2017 Jamie Phan

// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

//     http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

require realpath(__DIR__ . "/class.cli.friendlist.php");

if (php_sapi_name() == 'cli') {

	require realpath(__DIR__ . '/../includes/class.friendlist.php');

	$options = getopt("u:o:h");

	$cli = new friendlist_cli();

	if (array_key_exists("h", $options) || sizeof($options) == 0) {

		$cli->showhelp();

	}

	$username = $options['u'];

	if (gettype($username) == "string") {

		$cli->username = urldecode($username);

		$cli->execute();

		if (array_key_exists("o", $options)) {

			$output = $options['o'];		

			$format = explode(".", $output);

			$format = end($format);

			$cli->outputformat = $format;

			$cli->output($output);

			if ($cli->error === false) {

				$cli->showResult();

			} else {

				die($cli->error);

			}

			exit();

		} else {

			if ($cli->error === false) {

				$cli->outputConsole();

			} else {

				die($cli->error);

			}

		}

	} else {

		$cli->showhelp();

	}

} else {

	die("This application can be only run in console environment.");

}

 ?>