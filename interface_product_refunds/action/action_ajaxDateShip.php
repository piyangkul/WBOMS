<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] === "chk") {
    $idshipment = $_GET['idshipment'];
    $chkDate = chkDateShipment($idshipment);
    $date_start = $chkDate['date_start'];
    $date_end = $chkDate['date_end'];
    $getCount = chkOrder($date_start, $date_end);
    $countId = $getCount['countOrder'];
//echo $countId;

    if ($countId > 0) {
        echo "1";
    } else {
        echo "2";
    }
} elseif ($_GET['q'] === "min") {
    $idshipment = $_GET['idshipment'];
    $chkDate = chkDateShipment($idshipment);
    $date_start = $chkDate['date_start'];
    echo $date_start;
} elseif ($_GET['q'] === "max") {
    $idshipment = $_GET['idshipment'];
    $chkDate = chkDateShipment($idshipment);
    $date_end = $chkDate['date_end'];
    echo $date_end;
}