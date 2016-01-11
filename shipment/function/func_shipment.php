<?php

require_once dirname(__FILE__) . '/../../config/connect.php';
 
//ใช้หน้าshipment1
function getShipment_period() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
//ใช้หน้าshipment1
function addShipment_period($date_start, $date_end) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `shipment_period`(`date_start`, `date_end`) "
            . "VALUES (:date_start, :date_end)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":date_start" => $date_start,
                ":date_end" => $date_end
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        echo $SQLCommand;
        return false;
    }
}

//เช็คปุ่มแก้ไขรอบการส่ง หน้าshipment1 
function getCountCheckByIDshipment_period($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period, shipment_period.date_start,shipment_period.date_end ,order_transport.idorder_transport FROM shipment_period LEFT JOIN order_transport ON shipment_period.idshipment_period = order_transport.shipment_period_idshipment_period WHERE `idshipment_period` = :idshipment_period  ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้า action_delPeriod_shipment ลิ้งจาก shipment1
function delPeriod_shipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `shipment_period` WHERE `idshipment_period`=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้าpopup_shipment1
function getNextStartShipment_Period() {
   $conn = dbconnect();
    $SQLCommand = "SELECT date_add(MAX(shipment_period.date_end),interval 1 day)AS NextStartPeriod FROM `shipment_period`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

 //ใช้หน้าpopup_shipment1 ,shipment2-3
function getShipment_periodByID($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idshipment_period`, `date_start`, `date_end` FROM `shipment_period`"
            . "WHERE `idshipment_period`=:idshipment_period";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );

  $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้าpopup_shipment1
function editShipment_period($idshipment_period, $date_start, $date_end) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `shipment_period` SET `date_start`=:date_start,`date_end`=:date_end "
            . "WHERE `idshipment_period`=:idshipment_period";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":date_start" => $date_start,
                ":date_end" => $date_end
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้าshipment2 verเก่า
function getFactoryByIDshipment_period($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_getFactoryByIDshipment_period` WHERE `idshipment_period`=:idshipment_period OR `idshipment_period` IS NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//แก้หน้าshipment2 verใหม่
function getFactoryByIDshipment_period2($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//จำนวนรายการที่สั่งคงค้าง หน้าshipment2 (จากproduct_orderของทุกรง.ของทุกรอบการส่ง)
function getCountSumProduct_order() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM(SELECT COUNT(`idproduct_order`) AS `CountSumProduct_order`,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//จำนวนรายการที่สั่งคงค้าง หน้าshipment2 (จากproduct_orderของทุกรง.ที่ถูกส่งแล้ว)
function getCountSendProduct_order() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM(SELECT COUNT(`idproduct_order`) AS `CountSendProduct_order` ,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE product_order.status_checktransport LIKE 'check' GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้าshipment3 แสดงชื่อโรงงาน
function getFactoryByID($idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idfactory`, `name_factory`, `code_factory` FROM `factory`"
            . "WHERE `idfactory`=:idfactory";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory
            )
    );

  $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}
//ไม่ใช้ อยู่ฝั่งซ้ายของshipment3 
function getProduct_order_shipments() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_product_order_shipment`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ไม่ใช้ อยู่ฝั่งขวาของshipment3 
function getTransport_shipment() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_transport_shipment`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้าadd_shipment3
function getShipmentByID($idfactory,$idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND (view_transport_shipment.idshipment_period = :idshipment_period "
            . "OR view_transport_shipment.idshipment_period IS NULL )";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getCountshipment_perroidByID($idfactory,$idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT factory.name_factory,shipment_period.idshipment_period, COUNT(idorder_transport) AS count_idorder_transport "
            . "FROM order_transport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory "
            . "WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );
  $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}
        
//ใช้หน้าdetail_shipment3
function getDetailShipmentByID($idfactory,$idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND view_transport_shipment.idshipment_period = :idshipment_period ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้าpopup_add_shipment3
function getProduct_order_shipmentByID($idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT factory.name_factory, product.idproduct,product_order.idproduct_order,order_p.date_order_p,product_order.amount_product_order,unit.price_unit,shop.name_shop,product.name_product,unit.name_unit,product_order.status_checktransport "
            . "FROM product JOIN unit ON product.idproduct = unit.idproduct JOIN product_order ON product_order.idunit = unit.idunit JOIN order_p ON order_p.idorder_p = product_order.idorder_p JOIN shop ON shop.idshop = order_p.idshop JOIN factory ON factory.idfactory = product.idfactory "
            . "WHERE product_order.status_checktransport LIKE 'uncheck' AND factory.idfactory = :idfactory ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
               // ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้า action_delProduct_order ลิ้งจาก popup_add_shipment3
function delProduct_order($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `product_order` WHERE `idproduct_order`=:idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้า action_addShipment ลิ้งจาก popup_add_shipment3
function editChange_status($idproduct_order,$array) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `status_checktransport`= 'check' WHERE `idproduct_order` = :idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    foreach ($array as $key=>$value) {
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $value
            )
    );
}
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้า action_addShipment
function addShipment($idorder_transport,$product_order_idproduct_order,$shipment_period_idshipment_period,$idtransport ,$date_transport, $volume, $number, $price_transport) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `order_transport`(`idorder_transport`, `product_order_idproduct_order`, `shipment_period_idshipment_period`,`idtransport`, `date_transport`, `volume`, `number`, `price_transport`) "
            . "VALUES (:idorder_transport,:product_order_idproduct_order,:shipment_period_idshipment_period,:idtransport, :date_transport, :volume, :number, :price_transport)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_transport" => $idorder_transport,
                ":product_order_idproduct_order" => $product_order_idproduct_order,
                ":shipment_period_idshipment_period" => $shipment_period_idshipment_period,
                ":idtransport" => $idtransport,
                ":date_transport" => $date_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":price_transport" => $price_transport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

//ใช้หน้า popup_edit_amount_product_order และ เวอร์ชั่นเก่าpopup_detail_shipment ส่วนบน
function getProduct_orderByID($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_getProduct_orderByID` WHERE `idproduct_order`=:idproduct_order ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}
//ไม่ใช้ popup_detail_shipment ส่วนตารางรายการสินค้าจากบิลสั่งซื้อ 
function getProductDetail_shipment_old($idorder_p) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_getproduct_orderbyid WHERE `idorder_p`=:idorder_p";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_p" => $idorder_p
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//popup_detail_shipment ส่วนบน ข้อมูลขนส่ง
function getShipmentDetailByID($idshipment_period,$idfactory,$idorder_transport) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_transport.date_transport,transport.name_transport,order_transport.volume,order_transport.number,order_transport.price_transport "
            . "FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory "
            . "WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory AND order_transport.idorder_transport=:idorder_transport ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory,
                ":idorder_transport" => $idorder_transport
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//popup_detail_shipment ส่วนล่าง ตารางรายการสินค้าจากบิลขนส่ง 
function getProductDetail_shipment($idshipment_period,$idfactory,$idorder_transport) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order "
            . "FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory "
            . "WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory AND order_transport.idorder_transport=:idorder_transport ";
//    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory,
                ":idorder_transport" => $idorder_transport
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}


//ยังไม่เสร็จ
function editProduct_order($idproduct_order, $idamount_product_order) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `amount_product_order`=:amount_product_order "
            . "WHERE `idproduct_order`=:idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order,
                ":amount_product_order" => $idamount_product_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}


//
//function add($p1, $p2, $p3) {
//    $conn = dbconnect();
//    $SQLCommand = "";
//
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                "p1" => $p1,
//                "p2" => $p2,
//                "p3" => $p3
//            )
//    );
//
//    if ($SQLPrepare->rowCount() > 0) {
//        return $conn->lastInsertId();
//    } else {
//        return false;
//    }
//}
