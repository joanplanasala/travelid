<?php

	require_once("database.php");
	$dbHost = "localHost";
	$dbName = "travelid";
	$dbUsr = "root";
	$dbPassword = "";
	$db = new database($dbHost, $dbName, $dbUsr, $dbPassword, "utf8");
	$connection = $db->connect();
	#$db->actualize();

	//users table register initialisation
	$query = "show tables like ".'"'."users_easy_register".'"';
	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result)==0){
		$query = "CREATE TABLE users_easy_register(			
			`username`  varchar(20) NOT NULL UNIQUE,
			`password`  varchar(20) NOT NULL)";
								
		mysqli_query($connection, $query);
	}

	$url = $_SERVER["REQUEST_URI"];
	$splitted_url_1 = explode('/', $url);
	$queries = explode('?', $splitted_url_1[5]);

	
	$username=$queries[0];
	$pass=$queries[1];
	$state = $queries[2];
	
	$res = null;
	$usernames = [];
	if($state == "REG"){
		$result = mysqli_query($connection,"select username from users_easy_register");
		while($row = mysqli_fetch_row($result)){			
				array_push($usernames, $row[0]);
		}
		$user_registered = false;
		foreach ($usernames as $value) {
			if($value == $username)
				$user_registered = True;
		}
		if ($user_registered) {
			$res = "ERROR";
		}
		else{
			$query="insert into users_easy_register (username, password) values (".'"'.$username.'"'.", ".'"'.$pass.'")';
		mysqli_query($connection, $query);
		$res = $username;
		}
	}
	elseif ($state == "LOG") {
		$loginquery = "select password from users_easy_register where username = ".'"'.$username.'"';
		$realpass= mysqli_fetch_row(mysqli_query($connection, $loginquery));
		if($pass==$realpass[0]){
			$res = $username;
		}
		else{
			$res = "ERROR";
		}
	}
	echo(json_encode(array($res)));

?>
