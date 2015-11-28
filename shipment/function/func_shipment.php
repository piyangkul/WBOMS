<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getShipments() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_shipment`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProduct_orderByID($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_shipmentbyid`"
            . "WHERE `idproduct_order`=:idproduct_order ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function delProduct_order($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `product_order` WHERE `idproduct_order`=:idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function addShipment($idtransport ,$date_transport, $volume, $number, $price_transport) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `order_transport`(`idtransport`, `date_transport`, `volume`, `number`, `price_transport`) "
            . "VALUES (:idtransport, :date_transport, :volume, :number, :price_transport)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idtransport" => $idtransport,
                ":date_transport" => $date_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":price_transport" => $price_transport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}
//ยังไม่เสร็จ
function editProduct_order($idproduct_order, $idamount_product_order) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `amount_product_order`=:amount_product_order "
            . "WHERE `idproduct_order`=:idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order,
                ":amount_product_order" => $idamount_product_order
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
