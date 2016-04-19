<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function checkDuplicateProduct($name_product, $idfactory) {
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

function addProduct($idfactory, $name_product, $detail_product, $difference_amount_product) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product`(`idfactory`, `name_product`, `detail_product`, `difference_amount_product`) "
            . "VALUES (:idfactory, :name_product, :detail_product, :difference_amount_product )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":name_product" => $name_product,
                ":detail_product" => $detail_product,
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

function checkcode($productCode) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `product` WHERE `productCode`LIKE :productCode ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":productCode" => $productCode
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function editProduct($idproduct, $idfactory, $name_product, $detail_product, $difference_amount_product) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product` SET `idproduct`=:idproduct ,`idfactory`=:idfactory,`name_product`=:name_product,`detail_product`=:detail_product,`difference_amount_product`=:difference_amount_product "
            . "WHERE `idproduct`=:idproduct";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idfactory" => $idfactory,
                ":name_product" => $name_product,
                ":detail_product" => $detail_product,
                ":difference_amount_product" => $difference_amount_product
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
//        echo $SQLCommand;
        return false;
    }
}

function editUnit($idunit, $idunit_big, $idproduct, $name_unit, $price_unit, $type_unit, $amount_unit) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `unit` SET `idunit`=:idunit,`idunit_big`=:idunit_big,`idproduct`=:idproduct,`name_unit`=:name_unit,`price_unit`=:price_unit,`type_unit`=:type_unit,`amount_unit`=:amount_unit "
            . "WHERE `idproduct`=:idproduct";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit,
                ":idunit_big" => $idunit_big,
                ":idproduct" => $idproduct,
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

function getFactory2() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idfactory,name_factory FROM factory";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

function getProductBigUnit($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT unit.idunit,unit.idunit_big,unit.idproduct,name_unit,product.name_product,price_unit,type_unit,unit.amount_unit FROM unit INNER JOIN product ON unit.idproduct = product.idproduct WHERE unit.idproduct = :idproduct AND idunit_big = 0";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function EditUnitE($idunit, $name_unit, $amount_unit, $price_unit, $type_unit) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `unit` SET `name_unit`=:name_unit,`price_unit`=:price_unit,`type_unit`=:type_unit,`amount_unit`=:amount_unit "
            . "WHERE `idunit`=:idunit";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit,
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

function EditCalUnit($idunit, $amount_unit, $price_unit) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `unit` SET `price_unit`=:price_unit,`amount_unit`=:amount_unit "
            . "WHERE `idunit`=:idunit";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit,
                ":price_unit" => $price_unit,
                ":amount_unit" => $amount_unit
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function countUnit($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT COUNT(idproduct) AS numunit FROM `unit` WHERE idproduct = :idproduct";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getCalUnit($idunit_big) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,idunit_big,amount_unit,price_unit FROM `unit` WHERE idunit_big = :idunit_big";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit_big" => $idunit_big
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUnitAdd($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,idproduct,price_unit FROM unit WHERE idproduct= :idproduct";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function ajax_priceUnit($idUnit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,price_unit FROM `unit` WHERE idunit = :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idUnit
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function EditUnitAdd($idproduct, $idunit_big, $name_unit, $price_unit, $type, $amount_unit) {
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

function getCalUnitBig($idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,idunit_big,amount_unit,price_unit FROM `unit` WHERE idunit = :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function GetcountProductOrder($idUnit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idunit,COUNT(product_order.idunit) AS countUnit FROM product_order WHERE product_order.idunit = :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idUnit
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function deleteUnit($idUnit) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `unit` WHERE `idunit`=:idunit";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idUnit
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}
