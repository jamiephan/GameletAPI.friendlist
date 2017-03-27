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

// Ate too much foobar, still under construction...
require __DIR__ . '/class.webserver.router.php';

$app = new \Slim\App();

$app->get('/{username}[/{dataType}]', function ($request, $response, $args) {

	$webserver = new router_webserver($args["username"]);
	$params = $request->getQueryParams();

	$IDKey = (array_key_exists("IDKey", $params) && ? $params["IDKey"]: null);
	$NicknameKey = (array_key_exists("NicknameKey", $params) && ? $params["NicknameKey"]: null);

	$webserver->setKey($IDKey, $NicknameKey);



	// $friendlist = new GameletAPI_friendlist($args['username']);
	// $friendlist->execute();
	// $content = ($friendlist->error) ? array("error" => $friendlist->error) : $friendlist->getFriendListArray;

	// if (array_key_exists($args["dataType"])) {
	// 	# code...
	// }

	// return $response->write(json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
	
    // return $response->write(json_encode($friendlist->getFriendListArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


});
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        
        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

// Run app
$app->run();

 ?>