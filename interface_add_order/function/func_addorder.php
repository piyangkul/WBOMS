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

function getShop2() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM shop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
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

function getFactory2($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idfactory,code_factory,name_factory,tel_factory,address_factory,contact_factory,difference_amount_factory,detail_factory FROM `factory` WHERE idfactory = {$id} ORDER BY name_factory;";
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

function getProduct4() {
    $conn = dbconnect();
    //$SQLCommand = "SELECT idproduct,idfactory,name_product FROM `product` WHERE idfactory = {$id} ORDER BY name_product";
    $SQLCommand = "SELECT idproduct,product.idfactory,name_product,name_factory,difference_amount_factory,factory.type_factory FROM `product`  INNER JOIN factory ON factory.idfactory = product.idfactory";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
}

function getProduct2($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idproduct,idfactory,name_product FROM `product` WHERE idproduct = {$id} ORDER BY name_product";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProduct3() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idproduct,idfactory,name_product FROM `product`";
    //$SQLCommand = "SELECT idshop,name_shop FROM shop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
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

function getUnit2($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,idunit,name_unit,price_unit,type_unit,idproduct FROM `unit` WHERE type_unit = 'PRIMARY' AND idunit = {$id}";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getUnit3($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,factory.difference_amount_factory,unit.price_unit,type_unit,unit.idproduct,factory.name_factory,name_product,product.idfactory FROM `unit` INNER JOIN product ON product.idproduct=unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE type_unit = 'PRIMARY' AND idunit = :id ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUnit_cal() {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit FROM unit WHERE idunit = 2";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //return $SQLCommand;
    //$resultArr = array();
    if ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        return json_encode($result, JSON_UNESCAPED_UNICODE);
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

function addOrder($code_order, $idshop, $date_order, $time_order, $detail_order) {
    $conn = dbconnect();
    $date = str_replace('-', '/', $date_order);
    $Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    //$val_date; //คือวันที่ที่จะแก้ไข
    //$Nextdate; //คือวันที่ที่จะลงdbคือถูกแปลงแล้ว
    $SQLCommand = "INSERT INTO `order_p`(code_order_p,idshop,date_order_p,time_order_p,detail_order_p) "
            . "VALUES (:code_order, :idshop, :date_order, :time_order,:detail_order )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":code_order" => $code_order,
                ":idshop" => $idshop,
                ":date_order" => $Nextdate,
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

function addProductOrder($idunit, $idorder_p, $amount_product_order, $difference_product_order, $type_product_order, $price) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product_order`(idunit,idorder_p,amount_product_order,difference_product_order,type_product_order,price_product_order) "
            . "VALUES (:idunit, :idorder_p, :amount_product_order, :difference_product_order,:type_product_order,:price )";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit,
                ":idorder_p" => $idorder_p,
                ":amount_product_order" => $amount_product_order,
                ":difference_product_order" => $difference_product_order,
                ":type_product_order" => $type_product_order,
                ":price" => $price
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
//        echo $SQLCommand;
        return false;
    }
}

//Edit Order

function getOrderEdit($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idorder_p,code_order_p,shop.idshop,shop.name_shop,date_order_p,time_order_p,detail_order_p,COUNT(product_order.idproduct_order) AS count_product FROM order_p INNER JOIN shop ON shop.idshop = order_p.idshop INNER JOIN product_order ON order_p.idorder_p = product_order.idorder_p WHERE order_p.idorder_p = {$id} GROUP BY order_p.idorder_p ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getProductOrder($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idproduct_order,product_order.idorder_p,product.name_product,unit.name_unit,factory.name_factory,factory.difference_amount_factory,product_order.amount_product_order,product_order.difference_product_order,product_order.type_product_order,unit.price_unit,product_order.status_checktransport FROM product_order INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE product_order.idorder_p = {$id}";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //$resultArr = array();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function EditOrder($idorder, $code_order, $date_order, $time_order, $detail_order) {
    $conn = dbconnect();
    $date = str_replace('-', '/', $date_order);
    $Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    $SQLCommand = "UPDATE `order_p` SET code_order_p = :code_order,date_order_p = :date_order,time_order_p= :time_order,detail_order_p = :detail_order "
            . "WHERE idorder_p = :idorder";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder" => $idorder,
                ":code_order" => $code_order,
                ":date_order" => $Nextdate,
                ":time_order" => $time_order,
                ":detail_order" => $detail_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function edit_product_order($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idproduct_order,factory.difference_amount_factory,factory.difference_amount_factory,unit.price_unit,unit.idproduct,unit.idunit,product_order.idorder_p,product.name_product,unit.name_unit,factory.name_factory,factory.difference_amount_factory,product_order.amount_product_order,product_order.difference_product_order,product_order.type_product_order,unit.price_unit,product_order.status_checktransport FROM product_order INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE product_order.idproduct_order = :id";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function EditProductOrder($idproduct_order, $idunit, $amount_product_order, $difference_product_order, $price_product_order) {
    $conn = dbconnect();
    //$date = str_replace('-', '/', $date_order);
    //$Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    $SQLCommand = "UPDATE `product_order` SET idunit = :idunit,amount_product_order = :amount_product_order,difference_product_order= :difference_product_order,price_product_order = :price_product_order "
            . "WHERE idproduct_order = :idproduct_order";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order,
                ":idunit" => $idunit,
                ":amount_product_order" => $amount_product_order,
                ":difference_product_order" => $difference_product_order,
                ":price_product_order" => $price_product_order
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function edit_unit($id,$idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit FROM unit WHERE idproduct = :id AND idunit != :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id,
                ":idunit" => $idunit
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductOrder_del($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idproduct_order,product_order.idorder_p,product.name_product,unit.name_unit,factory.name_factory,factory.difference_amount_factory,product_order.amount_product_order,product_order.difference_product_order,product_order.type_product_order,unit.price_unit,product_order.status_checktransport FROM product_order INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE product_order.idproduct_order = {$id}";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function deleteProductOrder($id) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM product_order WHERE idproduct_order =:id";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//Delete Order

function deleteProduct_Order($idorder) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM product_order WHERE idorder_p=:idorder";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder" => $idorder
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function deleteOrder($idorder) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM order_p WHERE idorder_p =:idorder";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder" => $idorder
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//ajax
function getFactory_ajax($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idproduct,product.idfactory,factory.name_factory,name_product FROM `product` INNER JOIN factory ON product.idfactory = factory.idfactory WHERE idproduct = {$id} ORDER BY name_product";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
    

?>
