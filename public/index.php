<?php
include "../src/parser.php";


$ret = shell_exec("python ../sensehatsim/sim.py");
generateJsonData($ret);
