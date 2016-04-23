<?php

session_start();
if ($_GET['p'] == "delUnit") {
    $idunit = $_GET['idunit'];
    unset($_SESSION["unit"][$idunit]);
    $_SESSION["countUnit"] -=1;
    if ($idunit == 1) {
        unset($_SESSION["countUnit"]);
    }
    echo "1";
}

