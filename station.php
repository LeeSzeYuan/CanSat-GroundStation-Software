<?php
    include_once('database.php');

    $last_reading = getLastReadings();
    $last_reading_energy = $last_reading["percent"];
    $last_reading_time = $last_reading["reading_time"];

    $array = json_encode(array($last_reading_energy, $last_reading_time), JSON_NUMERIC_CHECK);

    echo $array;
?>
