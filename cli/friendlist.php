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
error_reporting(0);
require __DIR__ . "/class.cli.friendlist.php";
if (php_sapi_name() == 'cli') {
	require __DIR__ . '/../includes/class.friendlist.php';;
	$options = getopt("u:o:h");
	$cli = new friendlist_cli();
	if (array_key_exists("h", $options) || sizeof($options) == 0) {
		$cli->showhelp();
	}
	$username = $options['u'];
	$output = $options['o'];
	if (gettype($username) == "string" && gettype($output) == "string") {
		$cli->username = urldecode($username);
		$cli->execute();
		$format = explode(".", $output);
		$format = end($format);
		$cli->outputformat = $format;
		$cli->output($output);
		if ($cli->error === false) {
			echo " ___ _   _  ___ ___ ___  ___ ___   _"                           . "\r\n";
			echo "/ __| | | |/ __/ __/ _ \/ __/ __| | |"                          . "\r\n";
			echo "\__ \ |_| | (_| (_|  __/\__ \__ \ |_|"                          . "\r\n";
			echo "|___/\__,_|\___\___\___||___/___/ (_)"                          . "\r\n";
			echo                                                                    "\r\n";
			echo "The friend list had been successfully created!"                 . "\r\n";
			echo                                                                    "\r\n";
			echo "Request username: "    . "\t" . $cli->username                  . "\r\n";
			echo "Number of friend(s): " . "\t" . $cli->listNumber                . "\r\n";
			echo "Output file path: "    . "\t" . realpath($cli->path)            . "\r\n";
			echo "Output file format: "  . "\t" . strtoupper($cli->outputformat)  . "\r\n";
			echo "Execution time: "      . "\t" . $cli->executeTime . " seconds"  . "\r\n";
			echo                                                                    "\r\n";
			echo "Thank you for using this program! --Jamie Phan [Lovemelody]"    . "\r\n";
		} else {
			die($cli->error);
		}
		exit();
	} else {
		$cli->showhelp();
	}
} else {
	die("This application can be only run in console environment.");
}
 ?>