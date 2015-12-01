<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function addProduct($idfactory, $name_product, $detail_product, $code_product, $difference_amount_product) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product`(`idfactory`, `name_product`, `detail_product`, `code_product`, `difference_amount_product`) "
            . "VALUES (:idfactory, :name_product, :detail_product, :code_product, :difference_amount_product )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":name_product" => $name_product,
                ":detail_product" => $detail_product,
                ":code_product" => $code_product,
                ":difference_amount_product" => $difference_amount_product
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
}

function addUnit($idproduct, $idunit_big, $amount_unit, $name_unit, $price_unit, $type_unit) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `unit`(`idproduct`, `idunit_big`, `name_unit`, `price_unit`, `type_unit`, `amount_unit`) "
            . "VALUES (:idproduct, :idunit_big, :name_unit, :price_unit, :type_unit, :amount_unit)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idunit_big" => $idunit_big,
                ":name_unit" => $name_unit,
                ":price_unit" => $price_unit,
                ":type_unit" => $type_unit,
                ":amount_unit" => $amount_unit
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function getProducts() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
            . "`product_code`, "
            . "`idfactory`, "
            . "`name_product`, "
            . "`detail_product`, "
            . "`code_product`, "
            . "`difference_amount_product`,"
            . "`difference_amount_factory`, "
            . "`name_factory`, "
            . "`idunit`, "
            . "`name`, "
            . "`idunit_big`, "
            . "`name_big`,"
            . "price_unit "
            . "FROM `view_product`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductDetail($idproduct) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
            . "concat(`project`.`factory`.`code_factory`,`project`.`product`.`idproduct`) AS `product_code`,"
            . "`product`.`idfactory`, "
            . "`factory`.`name_factory`, "
            . "`name_product`, "
            . "`detail_product`, "
            . "`code_product`, "
            . "`difference_amount_product` "
            . "FROM `product` LEFT JOIN `factory` ON `factory`.`idfactory`=`product`.`idfactory` "
            . "WHERE `idproduct`=:idproduct";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getProductUnit($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
            . "`product_code`, "
            . "`idfactory`, "
            . "`name_product`, "
            . "`detail_product`, "
            . "`code_product`, "
            . "`difference_amount_product`, "
            . "`difference_amount_factory`, "
            . "`name_factory`, "
            . "`idunit`, "
            . "`name`, "
            . "`idunit_big`, "
            . "`name_big`, "
            . "`price_unit`, "
            . "`amount_unit`, "
            . "`type_unit` "
            . "FROM `view_product` "
            . "WHERE `idproduct`=:idproduct";
//    echo $SQLCommand;
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

function getProductUnitByID($idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
            . "`idunit`, "
            . "`name`, "
            . "`idunit_big`, "
            . "`name_big`, "
            . "`price_unit`, "
            . "`amount_unit`, "
            . "`type_unit` "
            . "FROM `view_product` "
            . "WHERE `idunit`=:idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function deleteProduct($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `product` WHERE `idproduct`=:idproduct";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function deleteProductUnit($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `unit` WHERE `idproduct`=:idproduct";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function checkcode($code_product) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `product` WHERE `code_product`LIKE :code_product ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":code_product" => $code_product
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}
