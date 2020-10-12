<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "ajaxtest";
// REPLACE with Database user
$username = "";
// REPLACE with Database user password
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, lat, lon, reading_time FROM gps order by reading_time desc limit 1";

$result = $conn->query($sql);

$data = $result->fetch_assoc();
$sensor_data[] = $data;

//$readings_time = array_column($sensor_data, 'reading_time');//returns the values from a single column of the input, identified by the column_key

// ******* Uncomment to convert readings time array to your timezone ********
//$i = 0;
// foreach ($readings_time as $reading){
//     // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
//     $readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading +7 hours"));
//     //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
//     $i += 1;
// }

//array-reverse - Return an array with elements in reverse order
//json-encode - Returns the JSON representation of a value
//JSON_NUMERIC_CHECK - Encodes numeric strings as numbers
$readings_time = array_reverse(array_column($sensor_data, 'reading_time'));
$lat = array_reverse(array_column($sensor_data, 'lat'));
$lon = array_reverse(array_column($sensor_data, 'lon'));
//echo $lat;
$gps = json_encode(array($lat[0],$lon[0], $readings_time), JSON_NUMERIC_CHECK);
echo $gps;


$result->free(); //Frees the memory associated with a result
$conn->close();
?>

