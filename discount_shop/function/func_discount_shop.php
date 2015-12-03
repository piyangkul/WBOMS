<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getCostProductByID($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idproduct`,`idunit_big`,`name`,`price_unit`,`difference_amount_product`,`difference_amount_factory` FROM `view_product` WHERE `idproduct`= :idproduct ";
 
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
    $SQLCommand = "SELECT * FROM view_getDiscountByID WHERE `idproduct`= :idproduct ";

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
