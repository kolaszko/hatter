<?php
include "../src/parser.php";

$version = "";
if(isset($_GET["version"])){
    $version=$_GET["version"];
}

$ret = shell_exec("python ../sensehatsim/sim.py");
generateJsonData($ret, $version);
