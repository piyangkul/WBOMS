<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getShop() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idshop,name_shop, tel_shop , address_shop ,detail_shop, name_province,name_region FROM shop INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON region.idregion = province.idregion ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getFactory() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idfactory`, "
            . "`code_factory`, "
            . "`name_factory`, "
            . "`tel_factory`, "
            . "`address_factory`, "
            . "`contact_factory`, "
            . "`difference_amount_factory`, "
            . "`detail_factory` FROM `factory` "
            . "ORDER BY name_factory;";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
function getDifference($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idfactory,code_factory,name_factory, tel_factory, address_factory, contact_factory, difference_amount_factory, detail_factory FROM factory WHERE idfactory = {$id} ORDER BY name_factory;";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProduct($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idproduct,idfactory,name_product FROM `product` WHERE idfactory = {$id} ORDER BY name_product";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getUnit($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,idunit,name_unit,price_unit,type_unit,idproduct FROM `unit` WHERE type_unit = 'PRIMARY' AND idproduct = {$id}";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getUnit_cal() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit FROM unit WHERE idunit = 2";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //return $SQLCommand;
    //$resultArr = array();
    if ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        //array_push($resultArr, $result);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
        //return "dfsdf";
    }
    //echo asd;
    return "{}";
}

function getUnit_cals($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit FROM unit WHERE idunit = {$id}";
    //echo $SQLCommand;
    //return $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getUnits($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit FROM unit WHERE idunit = :id";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //return $SQLCommand;
    //$resultArr = array();
    if ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        //array_push($resultArr, $result);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
        //return "dfsdf";
    }
    //echo asd;
    return "{}";
}

function addOrder($code_order, $idshop, $date_order, $time_order,$detail_order){
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `order_p`(code_order_p,idshop,date_order_p,time_order_p,detail_order_p) "
            . "VALUES (:code_order, :idshop, :date_order, :time_order,:detail_order )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":code_order" => $code_order,
                ":idshop" => $idshop,
                ":date_order" => $date_order,
                ":time_order" => $time_order,
                ":detail_order" => $detail_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
    
}
function addProductOrder($idunit,$idorder_p,$amount_product_order,$difference_product_order,$type_product_order){
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product_order`(idunit,idorder_p,amount_product_order,difference_product_order,type_product_order) "
            . "VALUES (:idunit, :idorder_p, :amount_product_order, :difference_product_order,:type_product_order )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit,
                ":idorder_p" => $idorder_p,
                ":amount_product_order" => $amount_product_order,
                ":difference_product_order" => $difference_product_order,
                ":type_product_order" => $type_product_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
    
}

?>
