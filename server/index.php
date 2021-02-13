
<?php

	require_once("database.php");
	$dbHost = "localHost";
	$dbName = "travellid19";
	$dbUsr = "root";
	$dbPassword = "";
	$db = new database($dbHost, $dbName, $dbUsr, $dbPassword, "utf8");
	$connection = $db->connect();
	$db->actualize();

    $url = $_SERVER["REQUEST_URI"];
	$splitted_url_1 = explode('/', $url);
	$queries = explode('?', $splitted_url_1[5]);
	$iso = $queries[0];
	
	
	$table_name=$iso."_COM";
	$query="IF OBJECT_ID(".'"'.$table_name.'"'.") IS NULL			
			CREATE TABLE ".'"'.$table_name.'"'."(
			[id] [int],
			[username] [varchar](20),
			[comment][varchar](500),
			[date][DATE],
			[likes][int]		
			)
			END";
	mysqli_query($connection, $query);
	if(len($queries)>1){
		$idd = $queries[1];
		$username = $queries[2];
		$comment = $queries[3];
		$date=date("Y")."-".date("m")."-".date("d");
		$like = $queries[4];

		if($like==FALSE){ 	#insert comment
			$query="insert into ".'"'.$table_name.'"'." values (".$idd.", 
																".'"'.$username.'"'.",
																".'"'.$comment.'"'.",
																".'"'.$date.'"'.",
																0 )";
			
		}

		else{				#like given, no comment written
			$query="UPDATE ".'"'.$table_name.'"'." SET likes = likes + 1 where id=".$idd;

		}
		mysqli_query($connection, $query);

	}
	echo($query);
	
	$covid_info = load_covid_info($connection,$iso);
	$json_result = json_encode($covid_info);
	echo($json_result);


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
