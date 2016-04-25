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

function getFactory() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idfactory,name_factory,code_factory FROM factory";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr);//, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//ใช้หน้าpopup_price_payfactory
function getPricePayFactory($idfactory,$idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `pay_factory` WHERE factory_idfactory=:idfactory AND shipment_period_idshipment=:idshipment_period";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
            ":idfactory" => $idfactory,
            ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}


function getProductDetail_payFactory($idshipment_period, $idfactory) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT order_transport.idorder_transport,order_transport.date_transport,order_transport.idtransport,transport.name_transport,order_transport.volume,order_transport.number,order_transport.price_transport,order_p.idorder_p,order_p.date_order_p,shop.name_shop,product_order.idproduct_order,product.idproduct,product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order "
            . " FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN order_p ON product_order.idorder_p=order_p.idorder_p JOIN shop ON order_p.idshop=shop.idshop JOIN unit ON product_order.idunit=unit.idunit  JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory ORDER BY date_transport ";
    //echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory              
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}