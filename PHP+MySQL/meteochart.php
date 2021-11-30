<?php
include('config.php');
$w_api_key = $_GET['api_key'];
$table = $_GET['station_id'];
$dataPoints1 = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($w_api_key == $write_api_key ) {

	$result = mysqli_query($conn, "SELECT * FROM $table ORDER BY id ASC");
	if ($result === false){
		echo "ERR";
		$conn -> close();
	}
	else { 
	while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
    		foreach ($row as $field => $value) { // I you want you can right this line like this: foreach($row as $value) {
			switch ($field) {
    				case "temperatureIN":
        			     $tIN_y = $value;
        			     break;
                                case "temperatureOUT":
                                     $tOUT_y = $value;
                                     break;
                                case "humidityIN":
                                     $hIN_y = $value;
                                     break;
                                case "humidityOUT":
                                     $hOUT_y = $value;
                                     break;
                                case "timestamp":
                                     $time = $value;
                                     break;
				    }
        	array_push($dataPoints1, array("label" => $time, "y" => $tIN_y));
                array_push($dataPoints2, array("label" => $time, "y" => $tOUT_y));
		array_push($dataPoints3, array("label" => $time, "y" => $hIN_y));
		array_push($dataPoints4, array("label" => $time, "y" => $hOUT_y));
    		}
	}
		
		$conn -> close();
	}
};
?>
<!DOCTYPE HTML>
<html>
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", { 
	theme: "light2",
	title: {
		text: "Historia temperatur, wilgotności w domu i na zewnątrz"
	},
	subtitles: [{
		text: "temperatura w stopniach celsjusza, wilgotność w %"
	}],
	legend:{
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	toolTip: {
		shared: true
	},
	data: [{
		type: "stackedArea",
		name: "Temperatura na zewnątrz",
		showInLegend: true,
		visible: true,
		yValueFormatString: "#,##0 stopni Celsjusza",
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "stackedArea",
		name: "Temperatura w domu",
		showInLegend: true,
		visible: true,
		yValueFormatString: "#,##0 stopni Celsjusza",
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "stackedArea",
		name: "Wilgotność w domu",
		showInLegend: true,
		visible: true,
		yValueFormatString: "##,##0 ",
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "stackedArea",
		name: "Wilgotność na zewnątrz",
		showInLegend: true,
		visible: true,
		yValueFormatString: "##,##0 ",
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
	}]
});
 
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>
</head>
<body>
<?php
$w_api_key = $_GET['api_key'];
$table = $_GET['station_id'];

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($w_api_key == $write_api_key ) {

	$result = mysqli_query($conn, "SELECT * FROM $table where id = (select MAX(id) from $table)");
	if ($result === false){
		echo "ERR";
		$conn -> close();
	}
	else { echo "<div>";
	while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
    		foreach ($row as $field => $value) { // I you want you can right this line like this: foreach($row as $value) {
			switch ($field) {
    				case "temperatureIN":
        			     echo "<center><h1>Temperatura w domu</h1><h2><i class='fas fa-thermometer-half' style='color:#059e8a;'></i>  ".$value." &degC</h2></center>";
        			     break;
    				case "humidityIN":
        			     echo "<center><h1>Wilgotność w domu</h1><h2><i class='fas fa-tint' style='color:#00add6;'></i>  ".$value." %</h2></center>";
        			     break;
    				case "temperatureOUT":
        			     echo "<center><h1>Temperatura na zewnątrz</h1><h2><i class='fas fa-thermometer-half' style='color:#059e8a;'></i>  ".$value." &degC</h2></center>";
        			     break;
                                case "humidityOUT":
                                     echo "<center><h1>Wilgotność na zewnątrz</h1><h2><i class='fas fa-tint' style='color:#00add6;'></i>  ".$value." %</h2></center>";
                                     break;
                                case "timestamp":
                                     echo "<center><h1>Data i godzina pomiaru</h1><h2><i class='fas fa-clock'></i> ".$value."</h2></center>";
                                     break;
				    }
    		}
	}
                echo "</div>";
		$conn -> close();
	}
} else {
echo "Niepoprawny API-KEY";
}
?>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 
