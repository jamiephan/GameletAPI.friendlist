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
require realpath(__DIR__ . '/../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class friendlist extends GameletAPI {

	public $username;

	public $executeTime = null;

	public $userIDKey = "userID";

	public $userNicknameKey = "userNickname";

	public $error = false;

	function __construct($username)	{

		if (gettype($username) == "string") {

			$this->username = urldecode($username);

			//Convert %40 to @

		} else {

			$this->error = "Username must be a string.";

		}

	}

	public function execute() {

		if ($this->error !== false) {
			return false;
		}

		if (!$this->_isUserExist()) {
				
			$this->error = "Username ".$this->username." does not exist.";

		} else {

			//Derp...I hate sort()
			$time_start = microtime(true);

			$arr = $this->_analyzer($this->_getFriendListPageNumber());

			usort($arr, function($first, $second){

				return strcmp($first[$this->userIDKey], $second[$this->userIDKey]);

			});

			$time_end = microtime(true);

			$this->executeTime = $time_end - $time_start;
			$this->getFriendListArray = $arr;
			$this->getFriendListNumber = sizeof($arr);
		}

	}

	public function setKey($ID = "userID", $Nickname = "userNickname"){

		if (preg_match("/^[a-zA-Z]+$/", $ID) && preg_match("/^[a-zA-Z]+$/", $Nickname)) {
			
				$this->userIDKey = $ID;
				$this->userNicknameKey = $Nickname;

		} else {

			$this->error = "Both key must be a string.";
		}

	}

	private function _getFriendListPageNumber(){

		$content = $this->cachedHTML;

		phpQuery::newDocument($content);

		$tmp = pq(".pageNavigation:contains('>>')")->attr("href");

		if ($tmp == "") {

			$tmp = 1;

		} else {

			$tmp = (int)str_replace("/friends.do?page=", "", explode("&", $tmp)[0]);

		}

		return array($tmp, $content);

	}

	private function _analyzer($arr){

		$pageNumber = $arr[0];
		$cachedContent = $arr[1];

		if ($pageNumber == 1) {

			 return $this->_dataGenerator($cachedContent);

		} else {

			$GLOBALS['list'] = array($this->_dataGenerator($cachedContent));

			$client = new Client();

			$requests = function ($total) {

			    for ($i = 2; $i < $total + 1; $i++) {

			    	$url = "http://tw.gamelet.com/friends.do?page=".$i."&username=".$this->username;
			        yield new Request('GET', $url);
			    }
			};

			$pool = new Pool($client, $requests($pageNumber), [
			    'concurrency' => $pageNumber,
			    'fulfilled' => function ($response, $index) {
			    	$html = $response->getBody()->getContents();

			    	$GLOBALS['list'][] = ($this->_dataGenerator($html));

			    },
			    'rejected' => function ($reason, $index) {

			    	die($reason . " -Error index: " . $index);
			 
			    },
			]);

			$promise = $pool->promise();
			$promise->wait();

			return call_user_func_array('array_merge', $GLOBALS['list']);
		}


	}

	private function _dataGenerator($content){

		$arr = array();

		$pq = phpQuery::newDocument($content);

		foreach(pq('.mediumUserBlock') as $o) { 

			$userID = urldecode(str_replace("//tw.gamelet.com/user.do?username=", "", pq($o)->find('a')->attr("href")));

			$userNickname = pq($o)->find(".axa")->text();

			// $arr[] = array($userID, $userNickname);

			$arr[] = array(
					$this->userIDKey => $userID,
					$this->userNicknameKey => $userNickname
				);
		}
		return $arr;
	}


	private function _isUserExist(){

		$ch = curl_init("http://tw.gamelet.com/friends.do?page=1&username=" . $this->username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		$content = curl_exec($ch);
		curl_close($ch);

		//Gamelet BUG: If user does not exist, the server will return a blank HTML with 200 OK response.

		if (!($content == "")) {
			$this->cachedHTML = $content;
			//Save the cache!
		}
		return !($content == "");

	}
}

 ?>
