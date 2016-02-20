<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getPayFactoryByID($idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `pay_factory`JOIN shipment_period ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period WHERE factory_idfactory=:idfactory ";
 
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getFactoryByName($name_factory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `factory` WHERE (factory.code_factory LIKE :name_factory OR factory.name_factory LIKE :name_factory) ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_factory" => "%".$name_factory."%"
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}