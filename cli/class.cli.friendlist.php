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
class friendlist_cli{
	public $username = null;
	public $error = true;
	public function showhelp(){
		echo "  _____                      _      _            _____ _____ "       . "\r\n";
		echo " / ____|                    | |    | |     /\   |  __ \_   _|"       . "\r\n";
		echo "| |  __  __ _ _ __ ___   ___| | ___| |_   /  \  | |__) || |  "       . "\r\n";
		echo "| | |_ |/ _` | '_ ` _ \ / _ \ |/ _ \ __| / /\ \ |  ___/ | |  "       . "\r\n";
		echo "| |__| | (_| | | | | | |  __/ |  __/ |_ / ____ \| |    _| |_ "       . "\r\n";
		echo " \_____|\__,_|_| |_| |_|\___|_|\___|\__/_/    \_\_|   |_____|"       . "\r\n";
		echo "                      __      _                _ _ _     _   "       . "\r\n";
		echo "                     / _|    (_)              | | (_)   | |  "       . "\r\n";
		echo "                    | |_ _ __ _  ___ _ __   __| | |_ ___| |_ "       . "\r\n";
		echo "                    |  _| '__| |/ _ \ '_ \ / _` | | / __| __|"       . "\r\n";
		echo "                    | | | |  | |  __/ | | | (_| | | \__ \ |_ "       . "\r\n";
		echo "                    |_| |_|  |_|\___|_| |_|\__,_|_|_|___/\__|"       . "\r\n";
		echo                                                                         "\r\n";
		echo "                  +-----------------------------------------+"       . "\r\n";
		echo "                  |               By Jamie Phan [Lovemelody]|"       . "\r\n";
		echo "                  |                https://www.jamiephan.net|"       . "\r\n";
		echo "                  |tw.gamelet.com/user.do?username=jamiephan|"       . "\r\n";
		echo "                  +-----------------------------------------+"       . "\r\n";
		echo                                                                         "\r\n";
		echo "Usage: php friendlist.php" 									       . "\r\n";
		echo                                                                         "\r\n";
		echo "      -u  Specify username (ID)."							           . "\r\n";
		echo "      -o  Specify output file name. if not defined, " 		       . "\r\n";
		echo "          it will print out to terminal instead." 			       . "\r\n";
		echo "          You can output as any file extension, but" 		           . "\r\n";
		echo "          this program will detect the value of .php," 	           . "\r\n";
		echo "          .xml, .csv, .json, .txt, and output with" 	               . "\r\n";
		echo "          their representative format automatically."                . "\r\n";
		echo "      -h  Show helps and credits." 							       . "\r\n";
		echo 																	     "\r\n";
		echo "Examples: php friendlist.php -u jamiephan -o /home/folder/list.json" . "\r\n";
		echo "          php friendlist.php -u 100000380302236%40facebook.com -o C:/folder/mylist.php"   . "\r\n";
		echo "          php friendlist.php -u 100000380302236@facebook.com -o ../output.txt"          . "\r\n";
		echo "          php friendlist.php -u lovemelody01 -o ../friends.xml"         . "\r\n";
		echo "          php friendlist.php -h" . "\r\n";
		die();
	}
	public function execute(){
		$friendlist = new GameletAPI_friendlist($this->username);
		$friendlist->execute();
		if ($friendlist->error !== false) {
			die($friendlist->error);
		}
		$this->listArr = $friendlist->getFriendListArray;
		$this->executeTime = $friendlist->executeTime;
		$this->listNumber = $friendlist->getFriendListNumber;
		$this->IDkey = $friendlist->userIDKey;
		$this->Nicknamekey = $friendlist->userNicknameKey;
	}
	public function output($path){
		$format = explode(".", $path);
		$format = strtolower(end($format));
		$this->outputformat = $format;
		$this->path = $path;
		$fileStream = fopen($path, 'w') or die("Error: The path for " . $path . " is not accessable.");
		$content = $this->compile();
		if (file_put_contents($path, $content)) { 
		  $this->error = false;
		} else { 
		  $this->error =  "Error: Failed to save the file to " . $path . ".";
		} 
		fclose($fileStream);
	}
	public function compile(){
		$content = "";
		switch ($this->outputformat) {
		    case "json":
		        $content = $this->_compileJSON();
		        break;
		    case "php":
		        $content = $this->_compilePHP();
		        break;
		   	case "xml":
		        $content = $this->_compileXML();
		        break;
		    case "csv":
		        $content = $this->_compileCSV();
		        break;
		    case "txt":
		    	$content = $this->_compileTXT();
		    	break;
		    default:
		    	//TODO: Change this something else >.>
		    	$content = $this->_compileTXT();
		    	$this->outputformat = "txt";
		    	break;
		}	
		return $content;
	}
	private function _compileJSON(){
		return json_encode($this->listArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	private function _compilePHP(){
		$string = "<?php"."\r\n";
		$string .= "\t\$GameletAPI_friendlist = array(" . "\r\n";
		foreach ($this->listArr as $array) {
			# "userID" => 
			$string .= "\t\t" . 'array(' . "\r\n";
			$string .= "\t\t\t" . '"' . $this->IDkey . '" => "' . $array[$this->IDkey] . '",' . "\r\n";
			$string .= "\t\t\t" . '"' . $this->Nicknamekey . '" =>"' . $array[$this->Nicknamekey] . '"' . "\r\n";
			$string .= "\t\t" . '),' . "\r\n";
		}
		$string .= "\t);" . "\r\n";
		$string .= "?>"."\r\n";
		return $string;
	}
	private function _compileXML(){
		// $xml = new SimpleXMLElement('<friendlist/>');
		// array_walk_recursive($this->listArr, array($xml, 'addChild'));
		// return $xml->asXML();
		$string = '<?xml version="1.0"?>' . "\r\n";
		$string .= '<friendlist>' . "\r\n";
		foreach ($this->listArr as $array) {
			$string .= "\t".'<friend>' . "\r\n";
				$string .= "\t\t".'<'.$this->IDkey.'>' . "\r\n";
					$string .= "\t\t\t".$array[$this->IDkey] . "\r\n";
				$string .= "\t\t".'</'.$this->IDkey.'>' . "\r\n";
				$string .= "\t\t".'<'.$this->Nicknamekey.'>' . "\r\n";
					$string .= "\t\t\t".$array[$this->Nicknamekey] . "\r\n";
				$string .= "\t\t".'</'.$this->Nicknamekey.'>' . "\r\n";
			$string .= "\t".'</friend>' . "\r\n";
		}
		$string .= '</friendlist>';
		return $string;
	}
	private function _compileCSV(){
		$string = "";
		foreach ($this->listArr as $array) {
			$string .= $array[$this->IDkey] . "," .$array[$this->Nicknamekey] . "\r\n";
		}
		return $string;
	}
	private function _compileTXT(){
		$string = "Friend list for " . $this->username . " (http://tw.gamelet.com/user.do?username=" . $this->username  . ")";
		$string .= "\r\n\r\n";
		date_default_timezone_set(date_default_timezone_get());
		$date = new Datetime();
    	$date = $date->format('l jS \of F Y h:i:s A');
		$string .= "Generated date: " . $date ."\r\n";
		$string .= "Execution time: " . $this->executeTime ." seconds\r\n";
		$string .= "Total number of friends: " . $this->listNumber ."\r\n";
		foreach ($this->listArr as $array) {
			$string .= "\r\n\r\n";
			$string .= $this->IDkey . ": " . $array[$this->IDkey] . "\r\n";
			$string .= $this->Nicknamekey. ": " . $array[$this->Nicknamekey];
		}
		return $string;
	}
}

?>