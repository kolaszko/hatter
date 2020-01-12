<?php

function arrayOfMembers()
{
    return array(
        "gyro" => array(
            "description" => "Gyroscope data.",
            "name" => "Gyroscope",
            "unit" => "deg/s",
            "valueNames" => array("x", "y", "z")
        ),
        "acc" => array(
            "description" => "Accelerometer data.",
            "name" => "Accelerometer",
            "unit" => "mm/s",
            "valueNames" => array("x", "y", "z")
        ),
        "comp" => array(
            "description" => "Magnetometer data.",
            "name" => "Compass",
            "unit" => "uT",
            "valueNames" => array("x", "y", "z")
        ),
        "humidity" => array(
            "description" => "Humidity sensor data.",
            "name" => "Humidity",
            "unit" => "%",
            "valueNames" => array("")
        ),
        "temp" => array(
            "description" => "Temperature sensor data.",
            "name" => "Temperature",
            "unit" => "deg of Celsius",
            "valueNames" => array("")
        ),
        "pressure" => array(
            "description" => "Pressure sensor data.",
            "name" => "Gyroscope",
            "unit" => "mbar",
            "valueNames" => array("")
        ),
    );
}

// $globalTable = arrayOfMembers();

function generateJsonData($data)
{
    $data_decoded = json_decode($data);
    $arr = arrayOfMembers();
    $time = time();
    $readings = array();
    foreach ($data_decoded as $sensor => $data) {

        $read = prepareSingleReading($data, $arr, $time);
        array_push($readings, $read);
    }
    $json_data = json_encode($readings);
    echo $json_data;
}

function prepareSingleValue($values, $members, $idBase)
{   
    $singleValues = array();
    for($i=0; $i < count($values); $i++){
        $value['id'] = sprintf('%s_%d', $idBase, $i);
        $value['name'] = $members[$i];
        $value['value'] = $values[$i];
        array_push($singleValues, $value);
    }
    return $singleValues;
}

function prepareSingleReading($jsonReading, $arrayOfMembers, $timestamp)
{
    $reading["name"] = $arrayOfMembers[$jsonReading->id]["name"];
    $reading['unit'] = $arrayOfMembers[$jsonReading->id]['unit'];
    $reading['description'] = $arrayOfMembers[$jsonReading->id]['description'];
    $reading['id'] = $jsonReading->id;
    $reading['values'] = prepareSingleValue($jsonReading->values, $arrayOfMembers[$jsonReading->id]['valueNames'], $reading['id']);
    $reading['timestamp'] = $timestamp;
    return $reading;
}
