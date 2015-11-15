<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function addFactory($name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `factory`(`name_factory`, `tel_factory`, `address_factory`, `contact_factory`, `difference_amount_factory`, `detail_factory`) "
            . "VALUES (:name_factory, :tel_factory, :address_factory, :contact_factory, :difference_amount_factory, :detail_factory)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_factory" => $name_factory,
                ":tel_factory" => $tel_factory,
                ":address_factory" => $address_factory,
                ":contact_factory" => $contact_factory,
                ":difference_amount_factory" => $difference_amount_factory,
                ":detail_factory" => $detail_factory
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
}

function getFactorys() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idfactory`, "
            . "`name_factory`, "
            . "`tel_factory`, "
            . "`address_factory`, "
            . "`contact_factory`, "
            . "`difference_amount_factory`, "
            . "`detail_factory` FROM `factory` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getFactoryByID($idfactory){
    $conn = dbconnect();
    $SQLCommand = "SELECT `idfactory`, "
            . "`name_factory`, "
            . "`tel_factory`, "
            . "`address_factory`, "
            . "`contact_factory`, "
            . "`difference_amount_factory`, "
            . "`detail_factory` FROM `factory`"
            . "WHERE `idfactory`=:idfactory ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function editFactory($name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `factory` SET "
            . "`name_factory`=:name_factory,"
            . "`tel_factory`=:tel_factory,"
            . "`address_factory`=:address_factory,"
            . "`contact_factory`=:contact_factory,"
            . "`difference_amount_factory`=:difference_amount_factory,"
            . "`detail_factory`=:detail_factory "
            . "WHERE `idfactory`=:idfactory";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_factory" => $name_factory,
                ":tel_factory" => $tel_factory,
                ":address_factory" => $address_factory,
                ":contact_factory" => $contact_factory,
                ":difference_amount_factory" => $difference_amount_factory,
                ":detail_factory" => $detail_factory,
                ":idfactory" => $idfactory
            )
    );
    
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
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
