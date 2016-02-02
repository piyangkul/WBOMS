<?php

require_once dirname(__FILE__) . '/../../config/connect.php';
//ยังไม่เสร็จ
function checkDuplicateShop($name_product, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_product` WHERE `name_product`LIKE :name_product AND `idfactory` LIKE :idfactory ";
//$SQLCommand = "SELECT name_product FROM view_product WHERE `name_product`=:name_product AND `name_factory`=:name_factory ";
    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_product" => $name_product,
                ":idfactory" => $idfactory
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return 1;
    } else {
        return 0;
    }
}

function addShop($name_shop, $idprovince, $tel_shop, $address_shop, $detail_shop) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO shop (name_shop,idprovince,tel_shop,address_shop,detail_shop)
                VALUE(:name_shop,:province,:tel_shop,:address_shop,:detail_shop)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_shop" => $name_shop,
                ":province" => $idprovince,
                ":tel_shop" => $tel_shop,
                ":address_shop" => $address_shop,
                ":detail_shop" => $detail_shop
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function editShop($name_shop, $idprovince, $tel_shop, $address_shop, $detail_shop, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE shop SET  name_shop= :name_shop,idprovince = :idprovince , tel_shop= :tel_shop ,address_shop= :address_shop ,detail_shop= :detail_shop
                WHERE idshop = :idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":name_shop" => $name_shop,
                ":idprovince" => $idprovince,
                ":tel_shop" => $tel_shop,
                ":address_shop" => $address_shop,
                ":detail_shop" => $detail_shop
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function delShop($idshop) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `shop` WHERE idshop = :idshop";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ไม่ใช้แล้ว
function getShops2() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idshop,name_shop, tel_shop , address_shop ,detail_shop, name_province,name_region FROM shop INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON region.idregion = province.idregion ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getShops() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idshop`, `idprovince`, `name_province`, `name_region`, `name_shop`, `tel_shop`, `detail_shop`, `address_shop`, `shop_code` FROM `view_shop` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getShopByID($idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idshop`, `idprovince`, `name_province`, `name_region`, `name_shop`, `tel_shop`, `detail_shop`, `address_shop`, `shop_code` FROM `view_shop` WHERE idshop = :idshop";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ไม่ใช้แล้ว
function getShopByID2($idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idshop,name_shop, tel_shop , address_shop ,detail_shop, name_province,name_region,shop.idprovince AS idprovince_s,province.name_province AS name_province_s FROM shop INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON region.idregion = province.idregion WHERE idshop = :idshop";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getProvince() {
    $conn = dbconnect();
    $SQLCommand = "SELECT*FROM province";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
?>

