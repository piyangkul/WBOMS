<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getShopsJSON() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_shop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//action_docket_show
function getPayByID($idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM pay JOIN shipment_period ON shipment_period.idshipment_period=pay.idshipment_period WHERE pay.shop_idshop=:idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//docket_paper แสดงสินค้า
function getProductDocketByID($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idshop=:idshop AND view_transport_shipment.idshipment_period=:idshipment_period ORDER BY date_transport ASC ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//docket_paper แสดงสินค้า mergeข้อมูลการขนส่งที่ส่งรอบเดียวกัน
function getProductDuplicateDocketByID($idshop, $idshipment_period, $name_transport, $number, $volume, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idshop=:idshop AND view_transport_shipment.idshipment_period=:idshipment_period AND name_transport=:name_transport AND number=:number AND volume=:volume AND idfactory=:idfactory ORDER BY date_transport ASC ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period,
                ":name_transport" => $name_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":idfactory" => $idfactory
            )
    );

    $count = $SQLPrepare->rowCount();
    return $count;
}

//popup_order_docket
function getPayByID2($idshop,$idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `pay` WHERE `idshipment_period`=:idshipment_period AND `shop_idshop`=:idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}