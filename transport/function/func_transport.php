<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function checkDuplicateTranport($name_transport,$address_transport) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `transport` WHERE `name_transport`LIKE :name_transport AND `address_transport` LIKE :address_transport ";

    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_transport" => $name_transport,
                ":address_transport" => $address_transport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return 1;
    } else {
        return 0;
    }
}

function getTransports() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idtransport`,"
            . " `code_transport`, "
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
            . " `code_transport`, "
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

function editTransport($code_transport, $name_transport, $tel_transport, $address_transport, $idtransport) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `transport` SET "
            . "`code_transport`=:code_transport,"
            . "`name_transport`=:name_transport,"
            . "`tel_transport`=:tel_transport,"
            . "`address_transport`=:address_transport "
            . "WHERE `idtransport`=:idtransport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":code_transport" => $code_transport,
                ":name_transport" => $name_transport,
                ":tel_transport" => $tel_transport,
                ":address_transport" => $address_transport,
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

function addTransport($code_transport,$name_transport, $tel_transport, $address_transport) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `transport`(`code_transport`, `name_transport`, `tel_transport`, `address_transport`) "
            . "VALUES (:code_transport, :name_transport, :tel_transport, :address_transport)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":code_transport" => $code_transport,
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