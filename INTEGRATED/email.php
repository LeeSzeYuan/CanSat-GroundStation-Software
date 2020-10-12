<?php
$servername = "localhost";

$dbname = "ajaxtest";
$username = "";
$password = "";

if (isset($_GET["email"])) {
    $to_email = test_input($_GET["email"]);
} else {
    $to_email = "lsyuan1029@gmail.com";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, pressure, temperature, humidity, gas, altitude, reading_time FROM bme680 order by reading_time desc limit 1" ;
$sql2 = "SELECT id, angX, angY, angZ, accX, accY, accZ, reading_time FROM gyro ORDER BY id DESC limit 1";
$sql3 = "SELECT id, lat, lon, reading_time FROM gps order by reading_time desc limit 1";
$sql4 = "SELECT id, percent, reading_time FROM battery order by reading_time desc limit 1" ;

if ($result = $conn->query($sql)) {
    $last_reading = $result->fetch_assoc();
    $last_reading_temp = $last_reading["temperature"];
    $last_reading_humi = $last_reading["humidity"];
    $last_reading_pres = $last_reading["pressure"];
    $last_reading_gas = $last_reading["gas"];
    $last_reading_alti = $last_reading["altitude"];
    $last_reading_time = $last_reading["reading_time"];
    $result->free();
}
else {
    echo "Failed to get BME680 DATA";
}

if ($result = $conn->query($sql2)){
    $gyro = $result->fetch_assoc();
    $angX = $gyro["angX"];
    $angY = $gyro["angY"];
    $angZ = $gyro["angZ"];
    $accX = $gyro["accX"];
    $accY = $gyro["accY"];
    $accZ = $gyro["accZ"];
    $result->free();
}else {
    echo "Failed to get GYRO DATA";
}

if ($result = $conn->query($sql3)){
    $gps = $result->fetch_assoc();
    $lat = $gps["lat"];
    $lon = $gps["lon"];
    $result->free();
}else {
    echo "Failed to get GPS DATA";
}

if ($result = $conn->query($sql4)){
    $bat = $result->fetch_assoc();
    $percent = $bat["percent"];
    $result->free();
}else {
    echo "Failed to get Battery DATA";
}



$conn->close();

$subject = "Satellite Report";

$body = "
Time: $last_reading_time \n
Battery: $percent %\n\n
BME680 \n
Temperature: $last_reading_temp °C\n
Humdity: $last_reading_humi %\n
Pressure $last_reading_pres hpa\n
Gas: $last_reading_gas kOhms\n
Altitude: $last_reading_alti m\n\n
GYRO \n
AngX: $angX °\n
AngY: $angY °\n
AngZ: $angZ °\n
AccX: $accX \n
AccY: $accY \n
AccZ: $accZ \n\n
GPS \n
Latitude: $lat °\n
Longitude: $lon °\n\n
";


$headers = "From: lsyuan1029@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

json_encode("Email sent successfully");
?>
