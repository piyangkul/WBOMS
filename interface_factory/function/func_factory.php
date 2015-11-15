<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function addProduct($idfactory, $name_product, $detail_product, $code_product, $difference_amount_product) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product`(`idfactory`, `name_product`, `detail_product`, `code_product`, `difference_amount_product`) "
            . "VALUES (:idfactory, :name_product, :detail_product, :code_product, :amount_product)";

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

function addFactory($name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `factory`(`name_factory`, `tel_factory`, `address_factory`, `contact_factory`, `difference_amount_factory`, `detail_factory`) "
            . "VALUES (:name_factory, :tel_factory, :address_factory, :contact_factory, :difference_amount_factory, :detail_factory)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_factory" => $name_factory,
                ":tel_factory" => $tel_factory,
                ":address_factory" => $address_factory,
                ":code_product" => $code_product,
                ":difference_amount_product" => $difference_amount_product,
                ":detail_factory" => $detail_factory
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
}

function getProducts() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
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

function getProduct_detail_1($idproduct) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
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
            . "FROM `view_product`"
            . "WHERE `idproduct`=:idproduct";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getFactorys() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idfactory`, "
            . "`name_factory`, "
            . "`tel_factory`, "
            . "`address_factory`, "
            . "`contact_factory`, "
            . "`difference_amount_factory`, "
            . "`detail_factory` FROM `factory` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
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
