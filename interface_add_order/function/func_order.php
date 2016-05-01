<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getOrder() {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idorder_p,code_order_p,shop.idshop,shop.name_shop,date_order_p,time_order_p,detail_order_p,factory.difference_amount_factory,COUNT(product_order.idproduct_order) AS count_product ,SUM(product_order.price_product_order*product_order.amount_product_order) AS price_product_order,concat(concat(`region`.`code_region`,`province`.`code_province`),`shop`.`idshop`,code_order_p) AS code FROM order_p INNER JOIN shop ON shop.idshop = order_p.idshop INNER JOIN product_order ON order_p.idorder_p = product_order.idorder_p INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct  INNER JOIN factory ON factory.idfactory = product.idfactory INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion GROUP BY order_p.idorder_p ORDER BY date_order_p DESC, order_p.time_order_p DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getPricePercent($idorder_p) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(product_order.price_product_order*amount_product_order-((product_order.price_product_order*product_order.difference_product_order*amount_product_order)/100)) AS price_percent FROM product_order WHERE product_order.idorder_p = :idorder_p AND product_order.type_product_order = 'PERCENT'";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_p" => $idorder_p
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getPriceBath($idorder_p) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idproduct_order,product_order.price_product_order,product_order.idunit,product_order.difference_product_order,unit.idproduct,product_order.amount_product_order FROM product_order INNER JOIN unit ON product_order.idunit=unit.idunit WHERE product_order.idorder_p = :idorder_p AND product_order.type_product_order = 'BATH'";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_p" => $idorder_p
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getDiffBathactionOrder($idproduct, $idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM unit WHERE unit.idproduct = :idproduct AND unit.idunit BETWEEN 1 AND :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idunit" => $idunit
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

