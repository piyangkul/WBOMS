<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

//stat
function getIncome_Outcome() {
    $conn = dbconnect();
    $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end, SUM(pay.price_pay-pay.debt)AS income,A.outcome FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period GROUP BY A.idshipment_period ORDER BY A.date_start ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//popup_stat_income
function getIncomeBYidshipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period,pay.shop_idshop,view_shop.shop_code,view_shop.name_shop,pay.price_order_total,pay.price_order_refund,pay.price_pay,pay.debt,(price_pay-debt)AS income FROM pay JOIN shipment_period ON pay.idshipment_period=shipment_period.idshipment_period JOIN view_shop ON view_shop.idshop=pay.shop_idshop WHERE shipment_period.idshipment_period=:idshipment_period ORDER BY view_shop.idshop ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//popup_stat_outcome
function getOutcomeBYidshipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period,pay_factory.factory_idfactory,factory.code_factory,factory.name_factory,pay_factory.price_pay_factory,pay_factory.price_product_refund_factory,pay_factory.real_price_pay_factory AS outcome FROM pay_factory JOIN shipment_period ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period JOIN factory ON factory.idfactory=pay_factory.idpay_factory WHERE shipment_period.idshipment_period=:idshipment_period ORDER BY pay_factory.factory_idfactory ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
