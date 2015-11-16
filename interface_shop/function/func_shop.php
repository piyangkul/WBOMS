<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function add_shop($name_shop, $idprovince, $tel_shop, $address_shop, $detail_shop) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO shop (name_shop,idprovince,tel_shop,address_shop,detail_shop)
                VALUE('$getName','$getIDProvince','$getTel','$getAddress','$getDetail')";

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
    $SQLCommand = "UPDATE shop SET  name_shop='$name_shop',idprovince = '$idprovince' , tel_shop='$tel_shop',address_shop='$address_shop',detail_shop='$detail_shop'
                WHERE idshop = '$idshop'";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name_shop" => $idshop,
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

function getShops() {
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

function getProvince() {
    $conn = dbconnect();
    $SQLCommand = "SELECT*FORM province";
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

