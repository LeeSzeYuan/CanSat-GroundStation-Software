<?php
    $servername = "localhost";

    // REPLACE with your Database name
    $dbname = "";
    // REPLACE with Database user
    $username = "root";
    // REPLACE with Database user password
    $password = "";
    
    function getLastReadings() {
        global $servername, $username, $password, $dbname;
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT id, percent, reading_time FROM battery order by reading_time desc limit 1" ;
        if ($result = $conn->query($sql)) {
            return $result->fetch_assoc();
        }
        else {
            return false;
        }
        $conn->close();
    }

    $last_reading = getLastReadings();
    $last_reading_energy = $last_reading["percent"];
    $last_reading_time = $last_reading["reading_time"];

    $array = json_encode(array($last_reading_energy, $last_reading_time), JSON_NUMERIC_CHECK);

    echo $array;
?>
