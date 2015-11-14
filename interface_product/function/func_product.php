<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function addProduct($idfactory, $name_product, $detail_product, $code_product, $amount_product) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product`(`idfactory`, `name_product`, `detail_product`, `code_product`, `amount_product`) "
            . "VALUES (:idfactory, :name_product, :detail_product, :code_product, :amount_product)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":name_product" => $name_product,
                ":detail_product" => $detail_product,
                ":code_product" => $code_product,
                ":amount_product" => $amount_product
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
}

function addUnit($idproduct, $idsmall_unit, $name_unit, $price_unit, $type_unit) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `unit`(`idproduct`, `idsmall_unit`, `name_unit`, `price_unit`, `type_unit`) "
            . "VALUES (:idproduct, :idsmall_unit, :name_unit, :price_unit, :type_unit)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idsmall_unit" => $idsmall_unit,
                ":name_unit" => $name_unit,
                ":price_unit" => $price_unit,
                ":type_unit" => $type_unit
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
