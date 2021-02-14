<?php

	require_once("database.php");
	$dbHost = "localHost";
	$dbName = "travelid";
	$dbUsr = "root";
	$dbPassword = "";
	$db = new database($dbHost, $dbName, $dbUsr, $dbPassword, "utf8");
	$connection = $db->connect();
	#$db->actualize();
	$query = "show tables like ".'"'."users_register".'"';
	$result = mysqli_query($connection, $query);

	if(mysqli_num_rows($result)==0){
		$query = "CREATE TABLE users_register(			
			`username`  varchar(20) NOT NULL UNIQUE,
			`password`  varchar(20) NOT NULL,
			`email`  varchar(30) NOT NULL UNIQUE)";						
		mysqli_query($connection, $query);
	}

	$url = $_SERVER["REQUEST_URI"];
	$splitted_url_1 = explode('/', $url);
	$queries = explode('?', $splitted_url_1[5]);

	$state=$queries[0];
	$username=$queries[1];
	$pass=$queries[2];
	$logininfo=[];
	if($state=="r"){ #fix repeted user/mail
		$email=$queries[3];
		$checkquery="select * from users_register where username =".'"'.$username.'"';
		$auxdata=mysqli_fetch_row(mysqli_query($connection, $checkquery));
		
		if($auxdata!=false){
			$res="ERROR: USER ALREADY REGISTERED";
		}
		else{
			$query="insert into users_register (username, password, email) values (".'"'.$username.'"'.", ".'"'.$pass.'"'.",".'"'.$email.'")';
			mysqli_query($connection, $query);
			$res="OK: REGISTER DONE";
		}
												
	}
	else{
		$loginquery = "select password from users_register where username = ".'"'.$username.'"';
		$realpass= mysqli_fetch_row(mysqli_query($connection, $loginquery));

		if($realpass==null){
			$res = "ERROR: USER NOT REGISTERED";
		}
		elseif($pass==$realpass[0]){
			$res = "OK: LOGGED IN";
		}
		else{
			$res = "ERROR: INCORRECT PASSWORD";
		}
	}
	echo($res);

?>
