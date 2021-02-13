
<?php

	require_once("database.php");
	$dbHost = "localHost";
	$dbName = "travellid19";
	$dbUsr = "root";
	$dbPassword = "";
	$db = new database($dbHost, $dbName, $dbUsr, $dbPassword, "utf8");
	$connection = $db->connect();
	#$db->actualize();

    $url = $_SERVER["REQUEST_URI"];
	$splitted_url_1 = explode('/', $url);
	$queries = explode('?', $splitted_url_1[5]);
	$iso = $queries[0];

	$table_name=$iso."_COM";
	$result = mysqli_query($connection, "show tables like".'"'.$table_name.'"');
	if(mysqli_num_rows($result)==0){
		$query = "CREATE TABLE ".$table_name."(
			`id` int,
			`username` varchar(20),
			`comment` varchar(500),
			`date` DATE,
			`likes` int)";
		mysqli_query($connection, $query);
	}

	if(count($queries)>1){
		$idd = $queries[1];
		$username = $queries[2];
		$comment = $queries[3];
		$comment_replaced = str_replace("%20", " ", $comment);
		$date=date("Y")."-".date("m")."-".date("d");
		$like = $queries[4];

		if($like != "L"){ 	#insert comment
			$query="insert into ".$table_name." values (".$idd.", 
																".'"'.$username.'"'.",
																".'"'.$comment_replaced.'"'.",
																".'"'.$date.'"'.",
																0 )";
			echo($query);
			
		}

		else{				#like given, no comment written
			$query="update ".'"'.$table_name.'"'." SET likes = likes + 1 where id=".$idd;

		}

		echo("hola");
		mysqli_query($connection, $query);
	}
	
	$covid_info = load_covid_info($connection,$iso);
	$json_result = json_encode($covid_info);
	#echo($json_result);


	function load_covid_info($connection, $iso){
		$query = "select * from `covid_data_1` where iso_code= ".'"'.$iso.'"';
		$result = mysqli_fetch_row(mysqli_query($connection, $query));
		$colsNames = namesOfColumns($connection);
		$array_result = [];
		$i = 0;
		foreach ($colsNames as $name) {
			$aux[$name] = $result[$i];
			$i ++;
		}
		array_push($array_result, array("covid_info" => $aux));
		return $array_result;
	}

	function namesOfColumns($connection){
		$colsNames = [];
		$columnsQuery = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = ".'"'."covid_data_1".'"';
		$columns = mysqli_query($connection, $columnsQuery);
		foreach ($columns as $value) {
			foreach ($value as $v) {
				array_push($colsNames, $v);
			}
		}
		return $colsNames;
	}


?>
