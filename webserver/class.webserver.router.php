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

require __DIR__ . '/../includes/class.friendlist.php';

class router_webserver {
	
	public $username;

	function __construct($username){
		
		$this->username = $username;

	}

	public function setKey($IDKey, $NicknameKey){

		$this->IDkey = $IDKey == null ? "userID" : $IDKey;
		$this->Nicknamekey = $NicknameKey == null ? "userNickname" : $NicknameKey;

	}

	public function execute(){

		$friendlist = new GameletAPI_friendlist($this->username);
		$friendlist->setKey($this->IDkey, $this->Nicknamekey);
		$friendlist->execute();

		if ($friendlist->error !== false) {

			$this->result = $friendlist->error;
			
		} else {
			$this->result = $friendlist->getFriendListArray;
		}

	}

	public function compile($datatype, $callback){

		switch (strtolower($datatype)) {
		    case "json":
		    	header('Content-Type: application/json;charset=utf-8');
		        $content = $this->_compileJSON();
		        break;
		    case "jsonp":
		    	header('Content-Type: application/json;charset=utf-8');
		        $content = $this->_compileJSONP($callback);
		        break;
		   	case "xml":
		   		header("content-type:text/xml;charset=utf-8");
		        $content = $this->_compileXML();
		        break;
		    case "csv":
		   		// header("content-type:text/csv;charset=utf-8");
		    	header("content-type:text/plain;charset=utf-8");
		        $content = $this->_compileCSV();
		        break;
		    case "txt":
		    	header("Content-Type: text/plain;charset=utf-8");
		    	$content = $this->_compileTXT();
		    	break;
		    default:
		    	header('Content-Type: application/json;charset=utf-8');
		    	$content = $this->_compileJSON();
		    	break;
		}

		$this->compiledContent = $content;
	}

	private function _compileJSONP($callback){
		return $callback . '(' . $this->_compileJSON() . ')';
	}
	private function _compileJSON(){
		return json_encode($this->result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	private function _compileXML(){
		
		// $xml = new SimpleXMLElement('<friendlist/>');
		// array_walk_recursive($this->result, array($xml, 'addChild'));
		// return $xml->asXML();
		$string = '<?xml version="1.0"?>' . "\r\n";
		$string .= '<friendlist>' . "\r\n";
		foreach ($this->result as $array) {
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
		foreach ($this->result as $array) {
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
		foreach ($this->result as $array) {
			$string .= "\r\n\r\n";
			$string .= $this->IDkey . ": " . $array[$this->IDkey] . "\r\n";
			$string .= $this->Nicknamekey. ": " . $array[$this->Nicknamekey];
		}
		return $string;
	}
}










 ?>