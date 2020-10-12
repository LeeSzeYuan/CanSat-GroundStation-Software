<?php
/****************************************************/
/************** Created by : Vivek Gupta ************/
/***************     www.vsgupta.in     *************/
/***************     www.iotmonk.com     *************/
/****************************************************/ 
$servername = "localhost";

// REPLACE with your Database name
$dbname = "";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

$response = array();

// Check if we got the field from the user
if (isset($_GET["temperature"]) && isset($_GET["humidity"]) && isset($_GET["pressure"]) && isset($_GET["gas"]) && isset($_GET["altitude"])) {
    $pressure = test_input($_GET["pressure"]);
    $temperature = test_input($_GET["temperature"]);
    $humidity = test_input($_GET["humidity"]);
    $gas = test_input($_GET["gas"]);
    $altitude = test_input($_GET["altitude"]);

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {//Returns a string description of the last connect error
        die("Connection failed: " . $conn->connect_error);
    } 

    // Fire SQL query to insert data in weather
    $sql = "INSERT INTO bme680 (pressure, temperature, humidity, gas, altitude)
    VALUES ('" . $pressure . "', '" . $temperature . "', '" . $humidity . "', '" . $gas . "', '" . $altitude . "')";

//http://192.168.0.154/SATELLITE/API/BMEpost.php?temperature=1&humidity=2&pressure=3&gas=4&altitude=5

    // Check for succesfull execution of query
    if ($conn->query($sql) === TRUE) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "New record of BME680 is created successfully";

        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Error: " . $sql . "<br>" . $conn->error;

        // Show JSON response
        echo json_encode($response);
    }

    $conn->close();
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);//Un-quotes a quoted string
    $data = htmlspecialchars($data);//Convert special characters to HTML entities
    return $data;
}
?>
