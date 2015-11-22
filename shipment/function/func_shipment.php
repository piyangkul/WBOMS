<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getShipment() {
    $conn = dbconnect();
    $SQLCommand = "";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "p1" => $p1,
                "p2" => $p2,
                "p3" => $p3
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function add($p1, $p2, $p3) {
    $conn = dbconnect();
    $SQLCommand = "";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "p1" => $p1,
                "p2" => $p2,
                "p3" => $p3
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}
