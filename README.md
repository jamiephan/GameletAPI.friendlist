```
   _____                      _      _            _____ _____ 
  / ____|                    | |    | |     /\   |  __ \_   _|
 | |  __  __ _ _ __ ___   ___| | ___| |_   /  \  | |__) || |  
 | | |_ |/ _` | '_ ` _ \ / _ \ |/ _ \ __| / /\ \ |  ___/ | |  
 | |__| | (_| | | | | | |  __/ |  __/ |_ / ____ \| |    _| |_ 
  \_____|\__,_|_| |_| |_|\___|_|\___|\__/_/    \_\_|   |_____|
                       __      _                _ _ _     _   
                      / _|    (_)              | | (_)   | |  
                     | |_ _ __ _  ___ _ __   __| | |_ ___| |_ 
                     |  _| '__| |/ _ \ '_ \ / _` | | / __| __|
                     | | | |  | |  __/ | | | (_| | | \__ \ |_ 
                     |_| |_|  |_|\___|_| |_|\__,_|_|_|___/\__|
                   +-----------------------------------------+
                   |               By Jamie Phan [Lovemelody]|
                   |                https://www.jamiephan.net|
                   |tw.gamelet.com/user.do?username=jamiephan|
                   +-----------------------------------------+
 ```
# What is GameletAPI friendlist?

GameletAPI friendlist provide API to access the friend list in [Gamelet.com](http://tw.gamelet.com/games.do) with multi-threading. Also providing CLI (Command Line Interface) and Web server for users.

---
# Table of contents

- [Requirements](https://github.com/jamiephan/GameletAPI.friendlist#requirements)

- [Installation](https://github.com/jamiephan/GameletAPI.friendlist#installation)

- [Intergrate GameletAPI.friendlist to your project.](https://github.com/jamiephan/GameletAPI.friendlist#intergrate-gameletapifriendlist-to-your-project)

  - [Additionally it provides more information and settings.](https://github.com/jamiephan/GameletAPI.friendlist#additionally-it-provides-more-information-and-settings)
  
- [Using the command line tool](https://github.com/jamiephan/GameletAPI.friendlist#using-the-command-line-tool)
  
  - [Formats for CLI](https://github.com/jamiephan/GameletAPI.friendlist#formats-for-cli)

- [Using the build-in Webserver script](https://github.com/jamiephan/GameletAPI.friendlist#using-the-build-in-webserver-script)

  - [Configuration](https://github.com/jamiephan/GameletAPI.friendlist#using-the-build-in-webserver-script)
  
    - [Apache](https://github.com/jamiephan/GameletAPI.friendlist#apache-configuration)
    
    - [Nginx](https://github.com/jamiephan/GameletAPI.friendlist#nginx-configuration)
    
    - [IIS](https://github.com/jamiephan/GameletAPI.friendlist#iis)
    
    - [lighttpd (>= 1.4.24)](https://github.com/jamiephan/GameletAPI.friendlist#lighttpd--1424)
  
  - [Testing](https://github.com/jamiephan/GameletAPI.friendlist#testing)
  
  - [Webserver Parameters](https://github.com/jamiephan/GameletAPI.friendlist#webserver-parameters)
  
    - [Formats](https://github.com/jamiephan/GameletAPI.friendlist#formats)
    
    - [Query parameters](https://github.com/jamiephan/GameletAPI.friendlist#query-parameters)
  
  - [Example](https://github.com/jamiephan/GameletAPI.friendlist#example)

---
# Requirements
- PHP: `>=5.6.0`
- PHP [Composer](https://getcomposer.org/)
- Active network connection to [Gamelet](http://tw.gamelet.com/games.do).
---
# Installation
```shell
git clone https://github.com/jamiephan/GameletAPI.friendlist.git
#Download the repository from github and clone to the current directory

cd GameletAPI.friendlist
#Enter the directory for friendlist

composer install
#Install the dependencies with composer
```
---
# Intergrate GameletAPI.friendlist to your project.
You can modify the following code to meet your needs, the following is just an simple example.
```PHP
<?php

	require 'includes/class.friendlist.php';
	//Include the PHP class file, under includes/class.friendlist.php.

	$username = "jamiephan";
	//Define a username.

	$friendlist = new GameletAPI_friendlist($username);
	//Create a new object with the given username as string in constructor.

	$friendlist->execute();
	//Execute the process (Download and analyse the HTML).

	if ($friendlist->error === false) {
	//Check if there is any errors, such as non-existing username etc.

		var_dump($friendlist->getFriendListArray);
		//Dump the data.

	} else {

		echo $friendlist->error;
		//Show the error message.
	}

 ?>

```

## Additionally it provides more information and settings.

Before `$friendlist->execute()`:

- `$friendlist->setKey("userID", "userNickname")` - Allow users to set the index key for the array, the default setting are `userID` and `userNickname`. Only allow alphabetical letters.

After `$friendlist->execute()`:

- `$friendlist->username` - Returns the initial request username (This is after `urldecode()`, converting `%40` to `@`).

- `$friendlist->executeTime` - Returns the total execution time in seconds (The time that spent on downloading and analysing the HTML).

- `$friendlist->getFriendListNumber` - Returns the total amount of friend.
---
# Using the command line tool

Navigate to the command line tool folder under `cli`

`cd cli`

Enter `php friendlist.php -h` to see the command line information. 

Here is the copy from the help:

```
Usage: php friendlist.php

      -u  Specify username (ID).
      -o  Specify output file name. if not defined,
          it will print out to terminal instead.
          You can output as any file extension, but
          this program will detect the value of .php,
          .xml, .csv, .json, .txt, and output with
          their representative format automatically.
      -h  Show helps and credits.

Examples: php friendlist.php -u jamiephan -o /home/folder/list.json
          php friendlist.php -u 100000380302236%40facebook.com -o C:/folder/mylist.php
          php friendlist.php -u 100000380302236@facebook.com -o ../output.txt
          php friendlist.php -u lovemelody01 -o ../friends.xml
          php friendlist.php -h
```
## Formats for CLI:

The tool will detect the file extension you had specified and output regarding to their format. The supported list are:

- **.xml** - This will create a root element named `friendlist`. Each friend will wrap with a `friend` tag, since XML does not support arrays. [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.xml)

- **.json** - This will create a json compatable object with the friend list array. [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.json)

- **.csv** - This will create a CSV object. [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.csv)

- **.php** - This will create a PHP file with the array stored in, with the variable named `GameletAPI_friendlist`. You can dynamically include it in your projects (`include "output.php";`, assume output.php if the file name). [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.php)

- **.txt** - This will show all the information about the request, including execution time, date, number of friends etc. This format is designed for human readable and not meant to be used programatically. [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.txt)

**IMPORTANT: All other extensions will considered into `.txt` format.** [Example](https://github.com/jamiephan/GameletAPI.friendlist/blob/master/test/cli/output.rAnDomFiLe)

---

# Using the build-in Webserver script

The script had alerady configured to run as a webserver  with URL routing, do not use it under command line interface.

To start using PHP build in server command:

`php -S localhost:8080 -t webserver webserver/index.php` (`8080` is the port number, change it as you desire.)

## Configuration

As the webserver using URL routing, some confuguations must be done with specific server.

#### Apache configuration

Place a `.htaccess` file under `webserver/` with the content of:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

Make sure that the `httpd.conf` have configured `AllowOverride All` for `.htaccess` usage.

#### Nginx configuration

This config file assumes:

- domain name (`server name`): `example.com`

- PHP-FPM server port: `9000`
 
 In addition, you need to configure the path for `error_log`, `access_log`, `root`.

```
server {
    listen 80;
    server_name example.com; 
    index index.php;
    error_log /path/to/example.error.log;
    access_log /path/to/example.access.log;
    root /path/to/public;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_pass 127.0.0.1:9000;
    }
}
```

#### IIS

Create a file named `web.config` and place under `webserver/` with the content of:

```
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <rewrite>
            <rules>
                <rule name="slim" patternSyntax="Wildcard">
                    <match url="*" />
                    <conditions>
                        <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
                        <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
                    </conditions>
                    <action type="Rewrite" url="index.php" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
```

#### lighttpd (>= 1.4.24)

Configure the lighthttpd with the following code:

`url.rewrite-if-not-file = ("(.*)" => "/index.php/$0")`


## Testing

Open the webpage with the PHP engine running, assuming the host is `localhost` and the port is `8080`.

`http://localhost:8080`

You should see an error message:

```
{
    "error": "Please provide an username."
}
```
Now add a username to the query:

`http://localhost:8080/jamiephan`

If you see a list of usernames, then the server had configured properly.

## Webserver Parameters

#### Formats

As like the CLI application, the webserver also allows you to justify the output format. After `/username`, append a `/format`. Example: `http://localhost:8080/jamiephan/xml`.

The supported formats are:

- `/json`

- `/jsonp` (Please see additional info [below](https://github.com/jamiephan/GameletAPI.friendlist#query-parameters))

- `/xml`

- `/csv`

- `/txt`

All other formats (including not specify) will be considered as `/json`.

#### Query parameters

The webserver also allow query parameters, the supported params are:

- `IDKey` - Set the key for ID, default: `userID`

- `NicknameKey` - Set the key for Nickname, default: `userNickname`

- `forceDownload` - This will force the file to be downloaded from the browser. (Will keep the file extension as user specified, but will only convert `jsonp` into `json`.)

Example: `http://localhost:8080/jamiephan/json?IDKey=userID&NicknameKey=userNickname`

The sever also supports `JSONP` callback. If you chosen `/jsonp`, please also specify the callback function name.

- `callback` - Set the callback for JSONP, the default is `friendlist`;

Example: `http://localhost:8080/jamiephan/jsonp?callback=console.log`

## Example

The webserver code in this repo had been hosted in https://friendlist.jamiephan.net/. You can use it as to test out the parameters remotely, just replace `http://localhost:8080` with `https://friendlist.jamiephan.net`.

- https://friendlist.jamiephan.net/jamiephan
  - Show friends with the username `jamiephan` (Default using JSON).

- https://friendlist.jamiephan.net/100000380302236%40facebook.com/txt
  - Show friends with the username `100000380302236%40facebook.com` and output a human readable format (`txt` is not to be used programatically).

- https://friendlist.jamiephan.net/lovemelody01/xml?IDKey=ID&NicknameKey=Nickname
  - Show friends with the username `lovemelody01` and output as json with the userID key `ID` and userNickname key `Nickname`.

- https://friendlist.jamiephan.net/jamiephan/jsonp?callback=console.log

  - show friends with the username `jamiephan`, output with `JSON` and have the callback of `console.log`














