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

function generateJsonData($data, $version)
{
    $data_decoded = json_decode($data);
    $arr = arrayOfMembers();
    $time = time();
    $readings = array();
    if ($version == "v2") {
        foreach ($data_decoded as $sensor => $data) {
            $base_id = $data->id;
            foreach($data->values as $counter => $val)
            {
                $read = prepareSingleReadingV2($val, $counter, $base_id, $arr, $time);
                array_push($readings, $read);
            }
            
        }
        $json_data = json_encode($readings);
        echo $json_data;

    } else {
        foreach ($data_decoded as $sensor => $data) {

            $read = prepareSingleReading($data, $arr, $time);
            array_push($readings, $read);
        }
        $json_data = json_encode($readings);
        echo $json_data;
    }
}

function prepareValues($values, $members, $idBase)
{
    $singleValues = array();
    for ($i = 0; $i < count($values); $i++) {
        $value["id"] = sprintf("%s_%d", $idBase, $i);
        $value["name"] = $members[$i];
        $value["value"] = $values[$i];
        array_push($singleValues, $value);
    }
    return $singleValues;
}

function prepareSingleReading($jsonReading, $members, $timestamp)
{
    $reading["name"] = $members[$jsonReading->id]["name"];
    $reading["unit"] = $members[$jsonReading->id]["unit"];
    $reading["description"] = $members[$jsonReading->id]["description"];
    $reading["id"] = $jsonReading->id;
    $reading["values"] = prepareValues($jsonReading->values, $members[$jsonReading->id]["valueNames"], $reading["id"]);
    $reading["timestamp"] = $timestamp;
    return $reading;
}

function prepareSingleReadingV2($value, $counter, $baseId, $members, $timestamp)
{
    $reading["id"] = sprintf("%s_%d",$baseId, $counter);
    $reading["value"] = $value;
    $reading["name"] = sprintf("%s %s", $members[$baseId]["name"], $members[$baseId]["valueNames"][$counter]);
    $reading["unit"] = $members[$baseId]["unit"];
    $reading["description"] = $members[$baseId]["description"];
    $reading['timestamp'] = $timestamp;
    return $reading;
}
