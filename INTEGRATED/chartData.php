<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, pressure, temperature, humidity, reading_time FROM bme680 order by reading_time desc limit 40";

$result = $conn->query($sql);

while ($data = $result->fetch_assoc()){ //Fetch a result row as an associative array
    $sensor_data[] = $data;
}
$readings_time = array_reverse(array_column($sensor_data, 'reading_time'));
//array-reverse - Return an array with elements in reverse order
//json-encode - Returns the JSON representation of a value
//JSON_NUMERIC_CHECK - Encodes numeric strings as numbers

$pressure = array_reverse(array_column($sensor_data, 'pressure'));
$temperature = array_reverse(array_column($sensor_data, 'temperature'));
$humidity = array_reverse(array_column($sensor_data, 'humidity'));

$array = json_encode(array($pressure, $temperature, $humidity, $readings_time), JSON_NUMERIC_CHECK);
//$pressure = json_encode(array_reverse(array_column($sensor_data, 'pressure')), JSON_NUMERIC_CHECK);
echo $array;


$result->free(); //Frees the memory associated with a result
$conn->close();
?>
