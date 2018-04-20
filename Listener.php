
<html>
  <head>
       <title>Форма и progressive enhancement</title>
	   	<meta charset="UTF-8">

	</head>
<?php

	class Inizialization {
		//static public $db;
		public $fromLocation;
		public $toLocation;
		static public $con;
		
		
		//public function __get($id){
		//	return($this->$id);
		//}
		function __construct( $fromLocation, $toLocation ){
			$this->fromLocation = $fromLocation;
			$this->toLocation = $toLocation;
			self::$con = Connection::get_instance()->dbh;
			
			$this->set_fromLocation( $this->fromLocation );
			$this->set_toLocation( $this->toLocation );			
		}
				
		public function set_fromLocation( $fromLocation ){
			//если логин введен, то обрабатываем, чтобы теги и скрипты не работали, мало ли что люди могут ввести
			$this->fromLocation = stripslashes($fromLocation);
			$this->fromLocation = htmlspecialchars($this->fromLocation);
			
			//удаляем лишние пробелы
			$this->fromLocation = trim($this->fromLocation);
		}
		
		public function set_toLocation( $toLocation ){
			//если логин введен, то обрабатываем, чтобы теги и скрипты не работали, мало ли что люди могут ввести
			$this->toLocation = stripslashes($toLocation);
			$this->toLocation = htmlspecialchars($this->toLocation);
			
			//удаляем лишние пробелы
			$this->toLocation = trim($this->toLocation);
		}
		public function set_id( $id_from_class ){
			$this->id =  $id_from_class;
		}
				
		public function get_toLocation( ){
			return ($this->toLocation);
		}
		
		
		public function get_fromLocation( ){
			return ($this->fromLocation);
		}
		
		
		static public function get_all_station(){
		$records = [];
		$res = self::$con->query("SELECT number FROM number_train");
		while ($row = $res->fetch(PDO::FETCH_ASSOC)){
			$records[] = $row;
		}
	 	return $records;
		}
		
		
		static public function find_station( $numb_train, $to, $from ){
		//print($from);
		//print($to);
		//echo"$numb_train";
		$records = [];
		$res = self::$con->query("SELECT rou.id, st.station FROM routes rou
			inner join all_station st on st.id=rou.id_station
			inner join number_train num on num.id=rou.id_number_train 
			where num.number=$numb_train and ( station='".$from."' or station='".$to."' )"
		);
		
		//where num.number=$numb_train and (station='Kharkiv' or station='Zaporozhie')
		//where num.number=$numb_train and (station=$from or station=$to)
		//where num.number=$numb_train and (station='Kharkiv' or station='Zaporozhie')"
		while ($row = $res->fetch(PDO::FETCH_ASSOC)){
			$records[] = $row;
		}
	 	return $records;
		} 
		
	}
?>




	<body>
		<?php
		require_once 'connection.php';	
		if (isset($_POST['from']) && isset($_POST['to'] )) { 
			$obj_class_Connection =  new Inizialization( $_POST['from'],  $_POST['to'] );
		}
		
		//$obj_class_Connection->connect();
		//print($obj_class_Connection->get_toLocation());
		//print($obj_class_Connection->get_fromLocation());
		$toLocation = $obj_class_Connection->get_toLocation(); 
		$fromLocation = $obj_class_Connection->get_fromLocation();
		
		$numbers_train = $obj_class_Connection->get_all_station();
		//print_r($numbers_train);
		
		
		for ($i = 0; $i < 3; $i++ ){
			$res1 = $obj_class_Connection->find_station($numbers_train[$i]['number'], $toLocation, $fromLocation );
			//print_r($res1);
			$cou=count($res1);
			//echo"$cou";
			if ( $cou == 2 ){
				print_r($numbers_train[$i]['number']);
				print_r($res1);
			}
		}	
		?>
			
			
		
		
    </body>


</html>


