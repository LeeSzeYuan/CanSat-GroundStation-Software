<?php
    include_once('database.php');
    // if (isset($_GET["readingsCount"])){
    //   $data = $_GET["readingsCount"];
    //   $data = trim($data);
    //   $data = stripslashes($data);
    //   $data = htmlspecialchars($data);
    //   $readings_count = $_GET["readingsCount"];
    //   if ($readings_count == ''){
    //     $readings_count = 20;
    //   }
    // }
    $last_reading = getLastReadings();
    $last_reading_temp = $last_reading["temperature"];
    $last_reading_humi = $last_reading["humidity"];
    $last_reading_pres = $last_reading["pressure"];
    $last_reading_gas = $last_reading["gas"];
    $last_reading_alti = $last_reading["altitude"];
    $last_reading_time = $last_reading["reading_time"];

    $min_temp = minReading('temperature');
    $max_temp = maxReading('temperature');
    $avg_temp = avgReading('temperature');

    $min_humi = minReading('humidity');
    $max_humi = maxReading('humidity');
    $avg_humi = avgReading('humidity');

    $min_pres = minReading('pressure');
    $max_pres = maxReading('pressure');
    $avg_pres = avgReading('pressure');

    $min_gas = minReading('gas');
    $max_gas = maxReading('gas');
    $avg_gas = avgReading('gas');

    $min_alti = minReading('altitude');
    $max_alti = maxReading('altitude');
    $avg_alti = avgReading('altitude');

    $info = array("min_temp"=>$min_temp, "max_temp"=>$max_temp, "avg_temp"=>$avg_temp,"min_humi"=>$min_humi, "max_humi"=>$max_humi, "avg_humi"=>$avg_humi, "min_pres"=>$min_pres, "max_pres"=>$max_pres, "avg_pres"=>$avg_pres, "min_gas"=>$min_gas, "max_gas"=>$max_gas, "avg_gas"=>$avg_gas, "min_alti"=>$min_alti, "max_alti"=>$max_alti, "avg_alti"=>$avg_alti, "last_reading_temp"=>$last_reading_temp, "last_reading_humi"=>$last_reading_humi, "last_reading_pres"=>$last_reading_pres, "last_reading_gas"=>$last_reading_gas, "last_reading_alti"=>$last_reading_alti, "last_reading_time"=>$last_reading_time);

    $info = json_encode($info);
    echo $info;
?>

