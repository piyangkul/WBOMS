<?php
require_once dirname(__FILE__) . '/../function/func_product.php';

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




?>

