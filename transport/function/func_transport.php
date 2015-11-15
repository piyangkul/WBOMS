<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getTransports() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idtransport`, "
            . "`name_transport`, "
            . "`tel_transport`, "
            . "`address_transport` "
            . "FROM `transport`";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getTransportByID($idtransport) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idtransport`, "
            . "`name_transport`, "
            . "`tel_transport`, "
            . "`address_transport` "
            . "FROM `transport`"
            . "WHERE `idtransport`=:idtransport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idtransport" => $idtransport
            )
    );

  $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function editTransport($name_transport, $tel_transport, $address_transport, $idtransport) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `transport` SET "
            . "`name_transport`=:name_transport,"
            . "`tel_transport`=:tel_transport,"
            . "`address_transport`=:address_transport "
            . "WHERE `idtransport`=:idtransport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_transport" => $name_transport,
                ":tel_transport" => $tel_transport,
                ":name_transport" => $address_transport,
                ":idtransport" => $idtransport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function delTransport($idtransport) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `transport` WHERE `idtransport`=:idtransport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idtransport" => $idtransport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function addTransport($name_transport, $tel_transport, $address_transport) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `transport`(`name_transport`, `tel_transport`, `address_transport`) "
            . "VALUES (:name_transport, :tel_transport, :address_transport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_transport" => $name_transport,
                ":tel_transport" => $tel_transport,
                ":address_transport" => $address_transport
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