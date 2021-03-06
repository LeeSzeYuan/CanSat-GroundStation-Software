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
if (isset($_GET["angX"]) && isset($_GET["angY"]) && isset($_GET["angZ"]) && isset($_GET["accX"]) && isset($_GET["accY"]) && isset($_GET["accZ"])) {
    $angX = test_input($_GET["angX"]);
    $angY = test_input($_GET["angY"]);
    $angZ = test_input($_GET["angZ"]);
    $accX = test_input($_GET["accX"]);
    $accY = test_input($_GET["accY"]);
    $accZ = test_input($_GET["accZ"]);

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {//Returns a string description of the last connect error
        die("Connection failed: " . $conn->connect_error);
    } 

    // Fire SQL query to insert data in weather
    $sql = "INSERT INTO gyro (angX, angY, angZ, accX, accY, accZ)
    VALUES ('" . $angX . "', '" . $angY . "', '" . $angZ . "', '" . $accX . "', '" . $accY . "', '" . $accZ . "')";

//http://192.168.0.154/SATELLITE/API/GYROpost.php?angX=1&angY=2&angZ=3&accX=1&accY=2&accZ=3

    // Check for succesfull execution of query
    if ($conn->query($sql) === TRUE) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "New record of GYRO is created successfully";

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
