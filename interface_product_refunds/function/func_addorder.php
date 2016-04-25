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
    $SQLCommand = "SELECT shop.idshop,province.idprovince,name_shop,tel_shop,detail_shop,address_shop,concat(region.code_region,province.code_province,shop.idshop) AS code_shop FROM shop INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion";
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
    $SQLCommand = "SELECT * FROM view_product GROUP BY name_product";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr);
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
    $SQLCommand = "SELECT idunit,idunit,name_unit,price_unit,type_unit,idproduct FROM `unit` WHERE idproduct = {$id}";
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
    $SQLCommand = "SELECT idunit,idunit,name_unit,price_unit,type_unit,idproduct FROM `unit` WHERE idunit = {$id}";
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
    $SQLCommand = "SELECT idunit,name_unit,price_unit,type_unit,unit.idproduct,factory.name_factory,name_product,factory.idfactory,factory.type_factory FROM `unit` INNER JOIN product ON product.idproduct=unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE idunit = :id ";
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
    $SQLCommand = "SELECT product_order.idproduct_order,factory.difference_amount_factory,unit.idproduct,unit.idunit,product_order.idorder_p,product.name_product,unit.name_unit,factory.name_factory,factory.difference_amount_factory,product_order.amount_product_order,product_order.difference_product_order,product_order.type_product_order,unit.price_unit,product_order.status_checktransport FROM product_order INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE product_order.idproduct_order = :id";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function EditProductOrder($idproduct_order, $idunit, $amount_product_order, $difference_product_order, $type_product_order, $price_product_order) {
    $conn = dbconnect();
    //$date = str_replace('-', '/', $date_order);
    //$Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    $SQLCommand = "UPDATE `product_order` SET idunit = :idunit,amount_product_order = :amount_product_order,difference_product_order= :difference_product_order,type_product_order = :type_product_order,price_product_order = :price_product_order "
            . "WHERE idproduct_order = :idproduct_order";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order,
                ":idunit" => $idunit,
                ":amount_product_order" => $amount_product_order,
                ":difference_product_order" => $difference_product_order,
                ":type_product_order" => $type_product_order,
                ":price_product_order" => $price_product_order
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function edit_unit($id, $idunit) {
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

//เพิ่มสินค้าคืน
function addProductRefunds($idorder_product_refunds, $idunit, $amount_product_refunds, $price_product_refunds, $type_product_refunds, $difference_product_refunds) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `product_refunds`(order_product_refunds_idorder_product_refunds,idunit,amount_product_refunds,price_product_refunds,type_product_refunds,difference_product_refunds) "
            . "VALUES (:idorder_product_refunds,:idunit,:amount_product_refunds,:price_product_refunds,:type_product_refunds,:difference_product_refunds)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_product_refunds" => $idorder_product_refunds,
                ":idunit" => $idunit,
                ":amount_product_refunds" => $amount_product_refunds,
                ":price_product_refunds" => $price_product_refunds,
                ":type_product_refunds" => $type_product_refunds,
                ":difference_product_refunds" => $difference_product_refunds
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function addOrderProductRefunds($idshop, $date_order, $detail_order, $price_product_refunds, $idshipment) {
    $conn = dbconnect();
    $date = str_replace('-', '/', $date_order);
    $Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    //$val_date; //คือวันที่ที่จะแก้ไข
    //$Nextdate; //คือวันที่ที่จะลงdbคือถูกแปลงแล้ว
    $SQLCommand = "INSERT INTO `order_product_refunds`(shop_idshop,date_product_refunds,detail_product_refunds,order_price_product_refunds,shipment_period_idshipment_period) "
            . "VALUES (:idshop, :date_order,:detail_order,:price_product_refunds,:idshipment )";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":date_order" => $Nextdate,
                ":detail_order" => $detail_order,
                ":price_product_refunds" => $price_product_refunds,
                ":idshipment" => $idshipment
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function getEditProductRefunds($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_product_refunds.idorder_product_refunds,order_product_refunds.shipment_period_idshipment_period,shop_idshop,shop.idshop AS idshop,shop.name_shop,detail_product_refunds,date_product_refunds,price_product_refunds,COUNT(product_refunds.idproduct_refunds) AS idproduct_refunds,concat(region.code_region,province.code_province,shop.idshop) AS code_shop FROM `order_product_refunds` INNER JOIN shop ON shop.idshop=order_product_refunds.shop_idshop INNER JOIN product_refunds ON product_refunds.order_product_refunds_idorder_product_refunds = order_product_refunds.idorder_product_refunds INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion WHERE order_product_refunds.idorder_product_refunds = :id GROUP BY order_product_refunds.idorder_product_refunds ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getProductRefunds($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_refunds.idproduct_refunds,product_refunds.amount_product_refunds,product_refunds.idunit,unit.name_unit,price_product_refunds,product_refunds.amount_product_refunds,factory.name_factory,product.name_product,product_refunds.status_product_refund,factory.type_factory,product_refunds.type_product_refunds,product_refunds.difference_product_refunds FROM product_refunds INNER JOIN unit ON unit.idunit = product_refunds.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE order_product_refunds_idorder_product_refunds = :id ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );
    //$resultArr = array();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductRefunds_total($id, $idproduct_refunds) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_refunds.idproduct_refunds,product_refunds.amount_product_refunds,product_refunds.idunit,unit.name_unit,price_product_refunds,product_refunds.amount_product_refunds,factory.name_factory,product.name_product,product_refunds.status_product_refund FROM product_refunds INNER JOIN unit ON unit.idunit = product_refunds.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE product_refunds.order_product_refunds_idorder_product_refunds = :id AND idproduct_refunds != :idproduct_refunds";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id,
                ":idproduct_refunds" => $idproduct_refunds
            )
    );
    //$resultArr = array();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function EditProductRefunds($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT product_refunds.idproduct_refunds,product_refunds.amount_product_refunds,product_refunds.idunit,unit.name_unit,price_product_refunds,product_refunds.amount_product_refunds,factory.name_factory,product.name_product,product_refunds.status_product_refund FROM product_refunds INNER JOIN unit ON unit.idunit = product_refunds.idunit INNER JOIN product ON product.idproduct = unit.idproduct INNER JOIN factory ON factory.idfactory = product.idfactory WHERE idproduct_refunds = :id ";
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

function Gettotal_Order_Del($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idorder_product_refunds,order_price_product_refunds FROM order_product_refunds WHERE idorder_product_refunds = :id";
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

function EditsProductRefunds($idproduct_refunds, $idunit, $amount_product_refunds, $price) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_refunds` SET idunit = :idunit,amount_product_refunds = :amount_product_refunds,price_product_refunds = :price "
            . "WHERE idproduct_refunds = :idproduct_refunds";
    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_refunds" => $idproduct_refunds,
                ":idunit" => $idunit,
                ":amount_product_refunds" => $amount_product_refunds,
                ":price" => $price,
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function deleteProduct_Refunds($idproduct_refunds) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM product_refunds WHERE idproduct_refunds=:idproduct_refunds ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_refunds" => $idproduct_refunds
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function deleteProduct_Refunds_Order($idorder_product_refunds) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM product_refunds WHERE order_product_refunds_idorder_product_refunds =:idorder_product_refunds";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_product_refunds" => $idorder_product_refunds
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function deleteOrderProduct_Refunds($idproduct_refunds) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM order_product_refunds WHERE idorder_product_refunds=:idproduct_refunds ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_refunds" => $idproduct_refunds
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function chkDelete($idorder_product_refunds) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM product_refunds WHERE product_refunds.order_product_refunds_idorder_product_refunds = :idorder_product_refunds AND product_refunds.status_product_refund = 'returned'";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_product_refunds" => $idorder_product_refunds
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function editOrderRefunds($idorder_product_refunds, $date_product_refunds, $detail_product_refunds, $total_price_all) {
    $conn = dbconnect();
    $date = str_replace('-', '/', $date_product_refunds);
    $Nextdate = date('Y-m-d', strtotime($date . "0 days"));
    $SQLCommand = "UPDATE `order_product_refunds` SET date_product_refunds = :date_product_refunds,detail_product_refunds = :detail_product_refunds ,order_price_product_refunds = :total_price_all "
            . "WHERE idorder_product_refunds = :idorder_product_refunds";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_product_refunds" => $idorder_product_refunds,
                ":date_product_refunds" => $Nextdate,
                ":detail_product_refunds" => $detail_product_refunds,
                ":total_price_all" => $total_price_all
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function editTotal_order($idorder_product_refunds, $total_price_product_refunds) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE order_product_refunds SET order_price_product_refunds = :total_price_product_refunds WHERE idorder_product_refunds = :idorder_product_refunds";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_product_refunds" => $idorder_product_refunds,
                ":total_price_product_refunds" => $total_price_product_refunds
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function get_edit_product_refunds($id) {
    $conn = dbconnect();
    $SQLCommand = "SELECT idproduct_refunds,idunit,amount_product_refunds,price_product_refunds FROM product_refunds WHERE idproduct_refunds = :id";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function hisDiff($id, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT difference.iddifference,difference.idproduct,difference.idshop,difference.price_difference FROM `difference` WHERE idproduct = :id AND idshop = :idshop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":id" => $id,
                ":idshop" => $idshop
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getDateShipment() {
    $conn = dbconnect();
    $SQLCommand = "SELECT MAX(idshipment_period) AS idshipment_period,MAX(date_end) AS date_end FROM shipment_period";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getShipment() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period` ORDER BY date_start DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getEditShipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period` WHERE idshipment_period = :idshipment_period";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function chkDateShipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT date_start,date_end FROM shipment_period WHERE idshipment_period = :idshipment_period";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function chkOrder($date_start, $date_end) {
    $conn = dbconnect();
    $SQLCommand = "SELECT COUNT(idorder_p) AS countOrder FROM `order_p` WHERE order_p.date_order_p BETWEEN :date_start AND :date_end";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":date_start" => $date_start,
                ":date_end" => $date_end
    ));
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getShopAdd($idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shop.name_shop,concat(region.code_region, province.code_province,shop.idshop) AS code_shop FROM `shop` INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion WHERE shop.idshop = :idshop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getDiffProduct($idprodcut) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM product WHERE idproduct = :idproduct ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idprodcut
            )
    );
    //$resultArr = array();
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function chkAddPR($idorder){
    $conn = dbconnect();
    $SQLCommand = "SELECT order_product_refunds.idorder_product_refunds,product_refunds.status_product_refund FROM order_product_refunds INNER JOIN product_refunds ON order_product_refunds.idorder_product_refunds = product_refunds.order_product_refunds_idorder_product_refunds WHERE order_product_refunds.idorder_product_refunds = :idorder AND product_refunds.status_product_refund = 'returned' GROUP BY product_refunds.status_product_refund";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder" => $idorder
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

?>
