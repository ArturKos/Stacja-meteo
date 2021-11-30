<?php
include('config.php');
$w_api_key = $_GET['api_key'];
$table = $_GET['station_id'];
$tin = $_GET['tIN'];
$hin = $_GET['hIN'];
$tout = $_GET['tOUT'];
$hout = $_GET['hOUT'];

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($w_api_key == $write_api_key ) {

	//w tym miejscu przygotowanie JSON i zapisanie do pliku
	$date = date('Y-m-d H:i:s', time());
	$array = array('time' => $date,'tIN' => $tin,'hIN' => $hin,'tOUT' => $tout, 'hOut' => $hout);
	$fp = fopen('readmeteo.json', 'w');
	fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));
	fclose($fp);

  //wysłanie zapytania do bazy danych - zapisujemy dane otrzymane z ESP8266
	$result = mysqli_query($conn, "INSERT INTO $table(temperatureIN, humidityIN, temperatureOUT, humidityOUT) VALUES ($tin, $hin, $tout, $hout)");
	if ($result === false){
		echo "ERR";
		$conn -> close();
	}
	else {
		echo "OK";
		$conn -> close();
	}
} else {
echo "Niepoprawny API-KEY";
}
?>
