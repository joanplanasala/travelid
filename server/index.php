
<?php

	require_once("database.php");
	$dbHost = "localHost";
	$dbName = "travelid";
	$dbUsr = "root";
	$dbPassword = "";
	$db = new database($dbHost, $dbName, $dbUsr, $dbPassword, "utf8");
	$connection = $db->connect();
	#$db->actualize();

    $url = $_SERVER["REQUEST_URI"];
	$splitted_url_1 = explode('/', $url);
	$queries = explode('?', $splitted_url_1[5]);
	$location = $queries[0];
	$locations = [];
	$result = mysqli_query($connection,"select location FROM covid_data");
	while($row = mysqli_fetch_row($result)){			
			array_push($locations, $row[0]);
	}
	$correct_input = false;
	foreach ($locations as $value) {
		if($value == $location)
			$correct_input = True;
	}
	if($correct_input){																				
		$table_name=$location."_COM";
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
			$date=date("Y")."-".date("m")."-".date("d");
			$state = $queries[3];
			if(count($queries) > 4){
				$comment = $queries[4];
				$comment_replaced = str_replace("%20", " ", $comment);
			}

			if($state == "L"){ 	#insert comment
				$query="update ".$table_name." SET likes = likes + 1 where id=".$idd;
			}

			elseif($state == "D"){
				$query = "delete from ".$table_name." where id = ".$idd;
			}
			else{				#like given, no comment written
				
				$query="insert into ".$table_name." values (".$idd.", 
																	".'"'.$username.'"'.",
																	".'"'.$comment_replaced.'"'.",
																	".'"'.$date.'"'.",
																	0 )";

			}
			
			mysqli_query($connection, $query);
		}
		$covid_info = download_info($connection,$location, "covid_data");
		$comments = download_info($connection,$location, $table_name);
		
		
		$result_array = array($covid_info,$comments);
		$json_result = json_encode($result_array);
		echo($json_result);
	}


	function download_info($connection, $location, $tableName){
		if($tableName == "covid_data")
			$query = "select positive_rate, 
								continent,
								people_vaccinated_per_hundred,
								stringency_index,
								population_density,
								new_cases_smoothed_per_million,
								new_deaths_smoothed_per_million
								from ".strtolower($tableName)." where location=".'"'.$location.'"';
		else
			$query = "select * from ".strtolower($tableName);

		$result = mysqli_query($connection, $query);
		$colsNames = namesOfColumns($connection, $tableName);
		if($tableName == "covid_data")
			$colsNames = array("positive_rate", "continent", "people_vaccinated_per_hundred", "stringencyindex", "population_density", "main_cases_smoothed_per_million", "new_deaths_smoothed_per_million");
		
		$array_result = [];
		while($row = mysqli_fetch_row($result)){			
			$i = 0;
			foreach ($colsNames as $name) {
				$aux[$name] = $row[$i];
				$i ++;
			}
			array_push($array_result, $aux);
		}
		if($tableName != "covid_data")
			$tableName = "comments";
		return array($tableName => $array_result);
	}

	function namesOfColumns($connection, $table){
		$colsNames = [];
		$columnsQuery = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = ".'"'.$table.'"';
		$columns = mysqli_query($connection, $columnsQuery);
		foreach ($columns as $value) {
			foreach ($value as $v) {
				array_push($colsNames, $v);
			}
		}
		return $colsNames;
	}


?>
