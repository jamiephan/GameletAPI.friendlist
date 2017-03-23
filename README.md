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
# GameletAPI friendlist
Provide API to access the friend list in Gamelet with multi-threading, In addition to providing CLI (Command Line Interface) and Web server.

## Requirements
- PHP: `>=5.6.0`
- `Composer`
- Active network connection (Firewall etc)

## Installation
```shell
git clone https://github.com/jamiephan/GameletAPI.friendlist.git
#Download the  repository from github

cd GameletAPI.friendlist
#Enter the directory

composer install
#Install the dependencies
```

## Intergration to your project
Create a simple PHP script with the following code
```PHP
<?php

	require 'path/to/GameletAPI.friendlist/includes/class.friendlist.php';
	//Include the PHP class file, in /includes/class.friendlist.php.

	$username = "jamiephan";
	//Define a username.

	$friendlist = new GameletAPI_friendlist($username);
	//Create a new object with the given username variable.

	$friendlist->execute();
	//Execute the extraction.

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

#### Additionally it provides more information and settings.

Before `$friendlist->execute()`:

- `$friendlist->setKey("userID", "userNickname")` - Allow users to set the index key for the array, the default setting are `userID` and `userNickname`.

After `$friendlist->execute()`:

- `$friendlist->executeTime` - Returns the total execution time in seconds.

- `$friendlist->getFriendListNumber` - Returns the total amount of friend (using `sizeof()`)


## Using the command line tool

Navigate to the command line tool location

`cd cli`

Enter `php friendlist.php -h` to see the command line information. Here is the copy:

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

The tool will detect the file extension you had input and output with the correct format. the supported list are:

- **.xml** - This will create a root element named `friendlist` and a secondary element `friend`.

- **.json** - This will create a json compatable object with the friend list array.

- **.csv** - This will create a CSV object with the friend list array.

- **.php** - This will create a PHP file with the array stored in, with the variable named `GameletAPI_friendlist`.

- **.txt** - This will show all the information about the request, including execution time, date, number of friends etc. This format is designed for human readable.

**All other extensions will considered into `.txt` format.**

## Using the webserver

# !STILL UNDER DEVELOPMENT!





















