<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getCostProductByID($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idproduct`,`idunit_big`,`name`,`price_unit`,`difference_amount_product` FROM `view_product` WHERE `idproduct`= :idproduct ";
 
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getDiscountByID($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT iddifference,product.name_product,concat(region.code_region,province.code_province,shop.idshop) AS code_shop,difference.date_difference,shop.name_shop,difference.price_difference,difference.type_money,unit.idunit,product.idproduct,MAX(unit.price_unit) AS price_unit FROM `difference` INNER JOIN shop ON difference.idshop = shop.idshop INNER JOIN product ON difference.idproduct = product.idproduct INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion INNER JOIN unit ON difference.idproduct = unit.idproduct WHERE difference.idproduct = :idproduct GROUP BY product.idproduct,shop.idshop";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductByName($name_product) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_product` WHERE `idunit_big` IS NULL AND (`product_code` LIKE :name_product OR `name_product` LIKE :name_product)  ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_product" => "%".$name_product."%"
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductByName_JSON() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_product` WHERE `idunit_big` IS NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}