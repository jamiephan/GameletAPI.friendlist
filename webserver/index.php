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

require realpath(__DIR__ . '/class.webserver.index.php');

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {

    header('Content-Type: application/json;charset=utf-8');

    $error = json_encode(array(

        "error" => "Please provide an username."

        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    die($error);
    
});

$app->get('/{username}[/{dataType}]', function ($request, $response, $args) {

	$webserver = new index_webserver($args["username"]);
	$params = $request->getQueryParams();

	$IDKey = (array_key_exists("IDKey", $params) ? $params["IDKey"]: null);
	$NicknameKey = (array_key_exists("NicknameKey", $params) ? $params["NicknameKey"]: null);

	$webserver->setKey($IDKey, $NicknameKey);

    $webserver->execute();

    if (array_key_exists("callback", $params)) {

        if (strlen($params["callback"]) > 0) {

            $callback = $params["callback"];

        } else {

            $callback = "friendlist";

        }

    } else {

        $callback = "friendlist";
    }    

    $webserver->compile((array_key_exists("dataType", $args) ? $args["dataType"] : "json"), $callback);

    header("access-control-allow-methods:GET, POST");
    header("access-control-allow-origin:*");

    die($webserver->compiledContent);


});
//Trailing slash removal
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {

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

$app->run();

 ?>