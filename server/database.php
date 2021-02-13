<?php

class database{

		public $dbHost;
		public $dbName;
		public $dbUser;
		public $dbPassword;
		public $charCode;
		public $connection;

		//object constructor:

		function __construct($dbHost, $dbName, $dbUser, $dbPassword, $charCode){
			$this->dbHost = $dbHost;
			$this->dbName = $dbName;
			$this->dbUser = $dbUser;
			$this->dbPassword = $dbPassword;
			$this->charCode = $charCode;
		}

		//funció encarregada d'inciar la conexió amb la base de dades i retorna la connexio.
		function connect(){
			$this->connection=mysqli_connect($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
			if(mysqli_connect_errno()){
				echo "ERROR: failed while connecting to the database.";
				exit();
			}
			mysqli_select_db($this->connection, $this->dbName) or die ("ERROR: couldn't find the database.");
			mysqli_set_charset($this->connection, $this->charCode);
			return $this->connection;	
		}

		function actualize(){
			$context = stream_context_create(array('http' => array('timeout' => 5)));
			$url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/latest/owid-covid-latest.csv";
			$codigo = file_get_contents($url, 0, $context);

			$doc = new DOMDocument();
			$doc->loadHTML($codigo);

			$p = $doc->getElementsByTagName("p");
			$data = "";
			foreach ($p as $text) {
				$data .= $text->nodeValue;
			}
			self::createCSV($data);

		}
		
		function createCSV($text){
			$fh = fopen("travelid/travelid/server/covid_data.csv", 'w+') or die("ERROR: couldn't create the file.");
  			fwrite($fh, $text) or die("ERROR: unable to write the file.");
  			self::importCSV($fh);

		}
		
		function importCSV($fh){
			$i = 0;
			$sql_values = "";
			while(($data = fgets($fh)) != FALSE){
				if($i != 0){
					$data_array = explode(',', $data);
					$j = 0;
					foreach ($data_array as $value) {
						if(j != len($data_array))
							$sql_values .= '"'. $value .'",';
						else
							$sql_values .= '"'. $value .'"';
					}
					$sqlInsert = "insert into `covid_data_1` values (". $sql_values .")";
					mysqli_query($this->$connection, $sqlInsert);
				}
			$i ++;
			}

		}
		

		//funcio per tancar la connexio amb la db
		function disconnect(){
			mysqli_close($this->connection);
		}
}

?>