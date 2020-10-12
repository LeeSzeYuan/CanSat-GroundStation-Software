<?php
$servername = "localhost";

// REPLACE with your Database name
$dbname = "ajaxtest";
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

$sql = "SELECT id, angX, angY, angZ, accX, accY, accZ, reading_time FROM gyro ORDER BY id DESC limit 1";

$result = $conn->query($sql);

$data = $result->fetch_assoc();
//echo $data['lat']+0;
$sensor_data[] = $data;

//array-reverse - Return an array with elements in reverse order
//json-encode - Returns the JSON representation of a value
//JSON_NUMERIC_CHECK - Encodes numeric strings as numbers
$angX = array_reverse(array_column($sensor_data, 'angX'));
$angY = array_reverse(array_column($sensor_data, 'angY'));
$angZ = array_reverse(array_column($sensor_data, 'angZ'));
$accX = array_reverse(array_column($sensor_data, 'accX'));
$accY = array_reverse(array_column($sensor_data, 'accY'));
$accZ = array_reverse(array_column($sensor_data, 'accZ'));
$readings_time = array_reverse(array_column($sensor_data, 'reading_time'));

$anime = json_encode(array($angX[0], $angY[0], $angZ[0], $accX[0], $accY[0], $accZ[0], $readings_time), JSON_NUMERIC_CHECK);
echo $anime; 

$result->free(); //Frees the memory associated with a result
$conn->close();
?>