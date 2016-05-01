<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

//ใช้หน้าshipment1
function getShipment_period() {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period, `date_start`, `date_end`, count_finish, (SELECT COUNT(idfactory) FROM factory) AS Total2, (Total - count_finish) AS count_notFinish FROM (SELECT `idshipment_period`, SUM(CASE WHEN status_shipment LIKE 'finish' THEN 1 ELSE 0 END) AS count_finish, (SELECT COUNT(idfactory) FROM factory) AS Total FROM `view_getfactorybyidshipment_period` GROUP BY idshipment_period) AS A RIGHT JOIN shipment_period ON A.idshipment_period=shipment_period.idshipment_period ";
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

//ใช้กับ action_addPeriod_shipment(Shipment1)
function editStatus_checkTransport_Postpone() {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `status_checktransport` = 'uncheck' WHERE `status_checktransport`='postpone' ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
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
    $SQLCommand = "SELECT `idshipment_period`, `date_start`, `date_end` FROM `shipment_period` WHERE `idshipment_period`=:idshipment_period";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );

    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้าpopup_edit_period_shipment เอาค่าถัดไป
function getNextid($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period` WHERE `idshipment_period`>:idshipment_period ORDER BY `idshipment_period` ASC LIMIT 1 ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้า shipment1
function getLastidShipment() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period` ORDER BY `idshipment_period` DESC LIMIT 1 ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้าpopup_edit_period_shipment
function editShipment_period($idshipment_period, $date_start, $date_end) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `shipment_period` SET `date_start`=:date_start,`date_end`=:date_end WHERE `idshipment_period`=:idshipment_period";

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

//หน้าshipment2 ดึงค่าขนส่งแยกตามshipment และโรงงาน
function getPrice_transportByshipment_period($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT tab.idshipment_period,tab.idfactory,tab.name_factory,tab.name_product,tab.amount_product_order,tab.price_transport,SUM(price_transport) AS sum_price_transport
FROM(SELECT shipment_period.idshipment_period,factory.idfactory,factory.name_factory,product.name_product,product_order.amount_product_order,order_transport.price_transport 
 FROM shipment_period JOIN order_transport ON shipment_period.idshipment_period = order_transport.shipment_period_idshipment_period 
 JOIN product_order ON order_transport.product_order_idproduct_order = product_order.idproduct_order 
 JOIN unit ON product_order.idunit = unit.idunit 
 JOIN product ON product.idproduct = unit.idproduct JOIN factory ON factory.idfactory=product.idfactory 
 WHERE shipment_period.idshipment_period = :idshipment_period AND factory.idfactory=:idfactory GROUP BY order_transport.idtransport,order_transport.date_transport,order_transport.volume,order_transport.number) AS tab ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result;
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

//หน้าshipment1 นับจำนวนโรงงานที่ยังทำไม่เสร็จ
function get_numFactory_notFinish($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A RIGHT JOIN ((SELECT idfactory,name_factory FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ) UNION (SELECT factory.idfactory,factory.name_factory FROM factory JOIN product ON factory.idfactory=product.idfactory JOIN unit ON unit.idproduct=product.idproduct JOIN product_order ON product_order.idunit=unit.idunit WHERE status_checktransport = 'uncheck' )) AS B ON A.idfactory = B.idfactory WHERE status_shipment NOT LIKE 'finish' OR status_shipment IS NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    return $SQLPrepare->rowCount();
}

//หน้าshipment1 นับจำนวนโรงงานทั้งหมด
function get_numAllFactory_shipment1($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A 
RIGHT JOIN ((SELECT idfactory,name_factory FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ) UNION (SELECT factory.idfactory,factory.name_factory FROM factory JOIN product ON factory.idfactory=product.idfactory JOIN unit ON unit.idproduct=product.idproduct JOIN product_order ON product_order.idunit=unit.idunit WHERE status_checktransport = 'uncheck' )) AS B ON A.idfactory = B.idfactory ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    return $SQLPrepare->rowCount();
}

//ใช้หน้าadd_shipment3 --> ยอดเงินที่โรงงานเรียกเก็บ 
function getPriceFactoryByIDshipment_period($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period`=:idshipment_period AND `idfactory`=:idfactory";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return false;
    }
}

//หน้าshipment2 แสดงโรงงานที่มีการสั่งซื้อ
function getFactoryByIDshipment_period4($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A 
RIGHT JOIN ((SELECT idfactory,name_factory FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ) UNION (SELECT factory.idfactory,factory.name_factory FROM factory JOIN product ON factory.idfactory=product.idfactory JOIN unit ON unit.idproduct=product.idproduct JOIN product_order ON product_order.idunit=unit.idunit WHERE status_checktransport = 'uncheck' )) AS B ON A.idfactory = B.idfactory ORDER BY A.idfactory ";
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

//หน้าshipment2 แสดงโรงงานที่มีการสั่งซื้อ
function getFactoryByIDshipment_period5($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT A.status_shipment,A.idshipment_period,B.idfactory,B.name_factory,A.CountCheck,A.price,A.amount_product_order,A.difference_amount_product,A.date_start,A.date_end FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A RIGHT JOIN ((SELECT idfactory,name_factory FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ) UNION (SELECT factory.idfactory,factory.name_factory FROM factory JOIN product ON factory.idfactory=product.idfactory JOIN unit ON unit.idproduct=product.idproduct JOIN product_order ON product_order.idunit=unit.idunit WHERE status_checktransport = 'uncheck' )) AS B ON A.idfactory = B.idfactory ORDER BY A.idfactory ";
//    SELECT * FROM
//(SELECT A.status_shipment,A.idshipment_period,B.idfactory,B.name_factory,A.CountCheck,A.price,A.amount_product_order,A.difference_amount_product,A.date_start,A.date_end FROM (SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period )AS A RIGHT JOIN ((SELECT idfactory,name_factory FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ) UNION (SELECT factory.idfactory,factory.name_factory FROM factory JOIN product ON factory.idfactory=product.idfactory JOIN unit ON unit.idproduct=product.idproduct JOIN product_order ON product_order.idunit=unit.idunit WHERE status_checktransport = 'uncheck' )) AS B ON A.idfactory = B.idfactory ORDER BY A.idfactory )AS yes LEFT JOIN 
//(SELECT S1.idfactory, S1.CountSumProduct_order-S2.CountSendProduct_order AS count_left FROM(SELECT factory.idfactory,factory.name_factory,CountSumProduct_order FROM(SELECT COUNT(`idproduct_order`) AS `CountSumProduct_order`,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory) AS S1 INNER JOIN(SELECT factory.idfactory,factory.name_factory,CountSendProduct_order FROM(SELECT COUNT(`idproduct_order`) AS `CountSendProduct_order` ,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE product_order.status_checktransport LIKE 'check' OR product_order.status_checktransport LIKE 'postpone' GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory )AS S2 ON S1.idfactory = S2.idfactory)AS Alll 
//ON yes.idfactory = Alll.idfactory 
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

//หน้าshipment2 แสดงโรงงานที่มีการสั่งซื้อ
function getFactoryByIDshipment_period3($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `view_getfactorybyidshipment_period` WHERE `idshipment_period` = :idshipment_period ";
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

//แก้หน้าshipment2 ver_old
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

//จำนวนรายการที่สั่งคงค้าง หน้าshipment2_ver_old (getCountSumProduct_order-getCountSendProduct_order)
function getCountLeftProduct_order() {
    $conn = dbconnect();
    $SQLCommand = "SELECT S1.idfactory, S1.CountSumProduct_order-S2.CountSendProduct_order AS count_left FROM(SELECT factory.idfactory,factory.name_factory,CountSumProduct_order FROM(SELECT COUNT(`idproduct_order`) AS `CountSumProduct_order`,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory) AS S1 INNER JOIN(SELECT factory.idfactory,factory.name_factory,CountSendProduct_order FROM(SELECT COUNT(`idproduct_order`) AS `CountSendProduct_order` ,factory.idfactory,factory.name_factory FROM product_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE product_order.status_checktransport LIKE 'check' OR product_order.status_checktransport LIKE 'postpone' GROUP BY factory.idfactory) AS A RIGHT JOIN factory ON A.idfactory = factory.idfactory )AS S2 ON S1.idfactory = S2.idfactory";
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

//ใช้กับ action_postponeProduct_order(Shipment3)
function editStatus_checkTransport($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET status_checktransport='postpone' WHERE `idproduct_order`=:idproduct_order";

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

//ใช้หน้าadd_shipment3 --> ตารางรายการสินค้าที่รอเพิ่มการส่ง
function getShipmentByID_notSend($idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND view_transport_shipment.idshipment_period IS NULL ORDER BY date_order_p,name_shop ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//นับจำนวนคงค้าง shipment2
function getShipmentByID_notSendRowcount($idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND view_transport_shipment.idshipment_period IS NULL  ORDER BY date_order_p ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory
            )
    );
    $count = $SQLPrepare->rowCount();
    return $count;
}

//ใช้หน้าadd_shipment3 --> รวมทั้งสั่งและส่ง
function getShipmentByID($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND (view_transport_shipment.idshipment_period = :idshipment_period "
            . "OR view_transport_shipment.idshipment_period IS NULL ) ORDER BY date_transport,idtransport,volume,number  "; 
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

//ใช้หน้าadd_shipment3 --> ตารางรายการสินค้าที่เพิ่มการส่งแล้ว
function getShipmentByID_send($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory AND view_transport_shipment.idshipment_period = :idshipment_period ORDER BY date_transport,idtransport,volume,number ";
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

//ใช้หน้าadd_shipment3 mergeข้อมูลการขนส่งที่ส่งรอบเดียวกัน
function getShipmentDuplicateByID($idfactory, $idshipment_period, $name_transport, $number, $volume) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory AND name_transport=:name_transport AND number=:number AND volume=:volume "
            . "AND (view_transport_shipment.idshipment_period = :idshipment_period "
            . "OR view_transport_shipment.idshipment_period IS NULL )";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory,
                ":name_transport" => $name_transport,
                ":volume" => $volume,
                ":number" => $number
            )
    );
    $count = $SQLPrepare->rowCount();
    return $count;
}

//ใช้หน้าadd_shipment3
function getUpdateStatusShipmentByID($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idfactory = :idfactory AND view_transport_shipment.idshipment_period = :idshipment_period ";
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

function getCountshipment_perroidByID($idfactory, $idshipment_period) {
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
function getDetailShipmentByID($idfactory, $idshipment_period) {
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
            . "WHERE product_order.status_checktransport LIKE 'uncheck' AND factory.idfactory = :idfactory  ORDER BY date_order_p,name_shop ";
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

//ใช้หน้า popup_add_shipment3-->action_addShipment เพื่อเรียกค่า ยอดเงินที่โรงงานเรียกเก็บ,add_shipment3 เรียกค่าการจ่ายเงินโรงาน
function getPrice_pay_factory($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_getfactorybyidshipment_period WHERE idshipment_period = :idshipment_period AND idfactory = :idfactory";
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

//add_shipment3 เช็คว่าconfirmครบทุกรายการหรือยัง
function Check_confirmDetail($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idfactory = :idfactory AND (view_transport_shipment.idshipment_period = :idshipment_period OR view_transport_shipment.idshipment_period IS NULL ) ORDER BY date_order_p ";
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

//add_shipment3 เช็คว่าconfirmครบทุกรายการหรือยัง
function Check_confirm($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment JOIN view_transport_shipment "
            . "ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order "
            . "WHERE view_product_order_shipment.idfactory = :idfactory "
            . "AND (view_transport_shipment.idshipment_period = :idshipment_period "
            . "OR view_transport_shipment.idshipment_period IS NULL ) ORDER BY date_order_p ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory
            )
    );

    $count = $SQLPrepare->rowCount();
    return $count;
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
function editChange_status($idproduct_order, $array) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `status_checktransport`= 'check' WHERE `idproduct_order` = :idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    foreach ($array as $key => $value) {
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
function addShipment($idorder_transport, $product_order_idproduct_order, $shipment_period_idshipment_period, $idtransport, $date_transport, $volume, $number, $price_transport) {
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
        echo $SQLCommand;
        return false;
    }
}

//popup_edit_shipment3 ตารางรายการสินค้าที่สั่ง
function getProductDetail_shipmentEdit($idshipment_period, $idfactory, $idtransport, $date_transport, $volume, $number, $price_transport) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT product_order.idproduct_order,order_p.date_order_p,shop.name_shop, order_transport.idtransport,order_transport.volume,order_transport.number,order_transport.price_transport,product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN order_p ON order_p.idorder_p=product_order.idorder_p JOIN shop ON order_p.idshop=shop.idshop JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory "
            . "WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory AND order_transport.idtransport=:idtransport AND order_transport.date_transport=:date_transport AND order_transport.volume=:volume AND order_transport.number=:number AND order_transport.price_transport=:price_transport ";
    //echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory,
                //":idorder_transport" => $idorder_transport,
                ":idtransport" => $idtransport,
                ":date_transport" => $date_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":price_transport" => $price_transport
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
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
function getShipmentDetailByID($idorder_transport, $idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT transport.idtransport,transport.code_transport,order_transport.date_transport,transport.name_transport,order_transport.volume,order_transport.number,order_transport.price_transport "
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
//    echo $SQLCommand;
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    //print_r($result);
    return $result;
}

//popup_detail_shipment ส่วนล่าง ตารางรายการสินค้าจากบิลขนส่ง 
function getProductDetail_shipment($idshipment_period, $idfactory, $idtransport, $volume, $number, $price_transport) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "SELECT order_transport.idorder_transport,order_transport.idtransport,order_transport.volume,order_transport.number,order_transport.price_transport,order_transport.status_shipment,product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order "
            . "FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory "
            . "WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory AND order_transport.idtransport=:idtransport AND order_transport.volume=:volume AND order_transport.number=:number AND order_transport.price_transport=:price_transport ";
    //echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idfactory" => $idfactory,
                //":idorder_transport" => $idorder_transport,
                ":idtransport" => $idtransport,
                ":volume" => $volume,
                ":number" => $number,
                ":price_transport" => $price_transport
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//shipment2,3 แสดงราคาที่สั่ซื้อ
function getPrice_orderProductshipment($idshipment_period, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_transport.idorder_transport,order_transport.idtransport,order_transport.volume,order_transport.number,order_transport.price_transport,order_transport.status_shipment,product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE shipment_period.idshipment_period=:idshipment_period AND factory.idfactory=:idfactory ";
    //echo $SQLCommand;
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

//popup_detail_shipment Confirmเปลี่ยนสถานะ และ action_delPayfactory อัพเดทสถานะสินค้าว่ายังไม่จ่าย
function editStatus_check_price($idorder_transport) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `order_transport` SET `status_shipment`= 'check_price' WHERE `idorder_transport`= :idorder_transport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_transport" => $idorder_transport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//action_finish อัพเดทสถานะสินค้าว่าเสร็จสิ้น
function editStatus_finish($idorder_transport) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `order_transport` SET `status_shipment`= 'finish' WHERE `idorder_transport`= :idorder_transport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_transport" => $idorder_transport
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//autoComplete ชื่อธนาคาร popup_add_payfactory
function getNamebank() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT pay_factory.cheque_name_bank FROM `pay_factory` WHERE cheque_name_bank IS NOT NULL AND cheque_branch_bank IS NOT NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//autoComplete สาขาธนาคาร popup_add_payfactory
function getBranchbank() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT pay_factory.cheque_branch_bank FROM `pay_factory` WHERE cheque_name_bank IS NOT NULL AND cheque_branch_bank IS NOT NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//popup_add_payfactory ตารางรายการสินค้าคืน
function getProduct_refunds($idfactory, $idshipment_period) {
    $conn = dbconnect();
//    $SQLCommand = "SELECT shipment_period.idshipment_period, shop.idshop,shop.name_shop,factory.idfactory,factory.name_factory,product.idproduct,product.name_product,unit.price_unit,unit.name_unit,product_refunds.amount_product_refunds,product.difference_amount_product,factory.difference_amount_factory,difference.price_difference,difference.type_money,order_product_refunds.total_price_product_refunds,(product_refunds.amount_product_refunds*order_product_refunds.total_price_product_refunds) AS total_product_refund "
//            . "FROM order_product_refunds JOIN product_refunds ON order_product_refunds.idorder_product_refunds=product_refunds.order_product_refunds_idorder_product_refunds JOIN product ON product_refunds.product_idproduct=product.idproduct JOIN factory ON factory.idfactory=product.idfactory JOIN unit ON product.idproduct=unit.idproduct JOIN difference ON product.idproduct=difference.idproduct JOIN shop ON order_product_refunds.shop_idshop=shop.idshop JOIN shipment_period ON order_product_refunds.shipment_period_idshipment_period=shipment_period.idshipment_period "
//            . "WHERE product_refunds.idunit_product_refund=unit.idunit AND difference.idshop=shop.idshop AND factory.idfactory=:idfactory AND shipment_period.idshipment_period=:idshipment_period";
    $SQLCommand = "SELECT shipment_period.idshipment_period, shop.idshop,shop.name_shop,factory.idfactory,factory.name_factory,product.idproduct,product.name_product,unit.price_unit,unit.name_unit,product_refunds.amount_product_refunds,product.difference_amount_product,factory.difference_amount_factory,difference.price_difference,difference.type_money,product_refunds.price_product_refunds FROM order_product_refunds JOIN product_refunds ON order_product_refunds.idorder_product_refunds=product_refunds.order_product_refunds_idorder_product_refunds JOIN unit ON product_refunds.idunit=unit.idunit JOIN product ON product.idproduct=unit.idproduct JOIN factory ON product.idfactory=factory.idfactory JOIN difference ON product.idproduct=difference.idproduct JOIN shop ON order_product_refunds.shop_idshop=shop.idshop JOIN shipment_period ON order_product_refunds.shipment_period_idshipment_period=shipment_period.idshipment_period WHERE product_refunds.idunit=unit.idunit AND difference.idshop=shop.idshop AND factory.idfactory=:idfactory AND shipment_period.idshipment_period=:idshipment_period ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้า action_addPayfactory
function addPayfactory($idfactory, $idshipment_period, $price_pay_factory, $price_product_refund_factory, $real_price_pay_factory, $type_pay_factory, $date_pay_factory, $date_pay_factory_credit, $cheque_number, $cheque_name_bank, $cheque_branch_bank) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `pay_factory`(`factory_idfactory`, `shipment_period_idshipment`, `price_pay_factory`, `price_product_refund_factory`, `real_price_pay_factory`, `type_pay_factory`, `date_pay_factory`, `date_pay_factory_credit`, `cheque_number`, `cheque_name_bank`, `cheque_branch_bank`) "
            . "VALUES (:idfactory, :idshipment_period, :price_pay_factory, :price_product_refund_factory, :real_price_pay_factory, :type_pay_factory, :date_pay_factory, :date_pay_factory_credit, :cheque_number, :cheque_name_bank, :cheque_branch_bank) ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":idshipment_period" => $idshipment_period,
                ":price_pay_factory" => $price_pay_factory,
                ":price_product_refund_factory" => $price_product_refund_factory,
                ":real_price_pay_factory" => $real_price_pay_factory,
                ":type_pay_factory" => $type_pay_factory,
                ":date_pay_factory" => $date_pay_factory,
                ":date_pay_factory_credit" => $date_pay_factory_credit,
                ":cheque_number" => $cheque_number,
                ":cheque_name_bank" => $cheque_name_bank,
                ":cheque_branch_bank" => $cheque_branch_bank
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        echo $SQLCommand;
        return false;
    }
}

//action_addPayfactory[popup_add_payfactory] ค้นหาสินค้าที่รอการอัพเดทสถานะคืนแล้ว
function getProduct_waitchangeStatusRefund($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM shipment_period JOIN order_product_refunds ON shipment_period.idshipment_period=order_product_refunds.shipment_period_idshipment_period "
            . "JOIN product_refunds ON order_product_refunds.idorder_product_refunds=product_refunds.order_product_refunds_idorder_product_refunds JOIN product ON product_refunds.product_idproduct=product.idproduct JOIN factory ON factory.idfactory=product.idfactory "
            . "WHERE factory.idfactory=:idfactory  AND shipment_period.idshipment_period=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_addPayfactory[popup_add_payfactory]อัพเดทสถานะสินค้าว่าจ่ายแล้ว ต่อจากgetProduct_waitchangeStatusRefund
function editStatus_unreturn($idproduct_refunds) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_refunds` SET `status_product_refund`= 'unreturn' WHERE idproduct_refunds =:idproduct_refunds ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_refunds" => $idproduct_refunds
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_addPayfactory[popup_add_payfactory]อัพเดทสถานะสินค้าว่าจ่ายแล้ว ต่อจากgetProduct_waitchangeStatusShipment
function editStatus_returned($idproduct_refunds) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_refunds` SET `status_product_refund`= 'returned' WHERE idproduct_refunds =:idproduct_refunds ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_refunds" => $idproduct_refunds
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_addPayfactory[popup_add_payfactory] ค้นหาสินค้าที่รอการอัพเดทสถานะว่าจ่ายแล้ว
function getProduct_waitchangeStatusShipment($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_transport.idorder_transport, shipment_period.idshipment_period,product_order.idproduct_order,factory.idfactory,product.idproduct, product.name_product,unit.price_unit,product_order.amount_product_order,order_transport.status_shipment FROM order_transport JOIN shipment_period ON shipment_period.idshipment_period=order_transport.shipment_period_idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON unit.idunit=product_order.idunit JOIN product ON product.idproduct=unit.idproduct JOIN factory ON factory.idfactory=product.idfactory WHERE factory.idfactory=:idfactory AND shipment_period.idshipment_period=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_addPayfactory[popup_add_payfactory]อัพเดทสถานะสินค้าว่าจ่ายแล้ว ต่อจากgetProduct_waitchangeStatusShipment
function editStatus_pay($idorder_transport) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `order_transport` SET `status_shipment`= 'pay' WHERE idorder_transport=:idorder_transport";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idorder_transport" => $idorder_transport
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

////popup_delPayfactory อัพเดทสถานะสินค้าว่ายังไม่จ่าย ต่อจากgetProduct_waitchangeStatus
//function editStatus_check_price($idorder_transport) {
//    $conn = dbconnect();
//    $SQLCommand = "UPDATE `order_transport` SET `status_shipment`= 'check_price' WHERE idorder_transport=:idorder_transport";
//
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":idorder_transport" => $idorder_transport
//            )
//    );
//    $resultArr = array();
//    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
//        array_push($resultArr, $result);
//    }
//    return $resultArr;
//}
//ใช้หน้า action_delPayfactory 
function delPayfactory($idpay_factory) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `pay_factory` WHERE idpay_factory=:idpay_factory";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idpay_factory" => $idpay_factory
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้า action_editShipment (รายการสินค้าที่ติ๊กออก)
function delShipment($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `order_transport` WHERE `product_order_idproduct_order`=:idproduct_order ";

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

//ใช้หน้า action_editShipment (รายการสินค้าที่ติ๊กออก)
function editChange_statusUncheck($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `status_checktransport`= 'uncheck' WHERE `idproduct_order` = :idproduct_order";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//ใช้หน้า action_edit_shipment3 (รายการสินค้าที่ยังติ๊กอยู่)
function editShipment($product_order_idproduct_order, $idtransport, $date_transport, $volume, $number, $price_transport) {//รับค่าpara
    $conn = dbconnect();
    $SQLCommand = "UPDATE `order_transport` SET `idtransport`=:idtransport,`date_transport`=:date_transport,`volume`=:volume,`number`=:number,`price_transport`=:price_transport "
            . "WHERE `product_order_idproduct_order`=:product_order_idproduct_order ";
    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                //":idorder_transport" => $idorder_transport,
                ":product_order_idproduct_order" => $product_order_idproduct_order,
                //":shipment_period_idshipment_period" => $shipment_period_idshipment_period,
                ":idtransport" => $idtransport,
                ":date_transport" => $date_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":price_transport" => $price_transport
            )
    );
    if ($SQLPrepare) {
        return TRUE;
    } else {
        return false;
    }
}

//ใช้หน้า popup_edit_payfactory 
function getPayFactory($idfactory, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `pay_factory` WHERE `factory_idfactory`=:idfactory AND `shipment_period_idshipment`=:idshipment_period";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idfactory" => $idfactory,
                ":idshipment_period" => $idshipment_period
            )
    );
//    echo $SQLCommand;
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    //print_r($result);
    return $result;
}

function getUnit($idproduct,$idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `unit` WHERE idproduct = :idproduct AND idunit != :idunit AND type_unit='PRIMARY' ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idunit" => $idunit
    ));
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}


function editProduct_order($idproduct_order, $idamount_product_order, $idunit, $price_product_order) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `amount_product_order`=:amount_product_order,idunit = :idunit,price_product_order = :price_product_order "
            . "WHERE `idproduct_order`=:idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order,
                ":amount_product_order" => $idamount_product_order,
                ":idunit" => $idunit,
                ":price_product_order" => $price_product_order
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//autocomplete --> popup_add_shipment3, popup_edit_shipment3
function getTransport() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM transport ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}





//action edit_amount_product_order
function getProductOrderOld($idproduct_order) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idshop,product_order.idunit,product.idproduct,product.idfactory,product_order.amount_product_order,product_order.type_product_order,product_order.difference_product_order,unit.price_unit,product_order.price_product_order,product.difference_amount_product FROM product_order INNER JOIN order_p ON product_order.idorder_p = order_p.idorder_p INNER JOIN unit ON product_order.idunit=unit.idunit INNER JOIN  product ON unit.idproduct = product.idproduct WHERE product_order.idproduct_order =:idproduct_order";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct_order" => $idproduct_order
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUnitNew($idproduct, $idunitNew, $idunitOld) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM unit WHERE unit.idproduct = :idproduct AND unit.idunit BETWEEN :idunitOld AND :idunitNew";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idunitNew" => $idunitNew,
                ":idunitOld" => $idunitOld
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getUnitCal($idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `unit` WHERE unit.idunit = :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getedit_price_unit($idunit) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM unit WHERE unit.idunit = :idunit";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idunit" => $idunit
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getUnitNewDESC($idproduct, $idunitNew, $idunitOld) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM unit WHERE unit.idproduct = :idproduct AND unit.idunit BETWEEN :idunitOld AND :idunitNew ORDER BY idunit DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct,
                ":idunitNew" => $idunitNew,
                ":idunitOld" => $idunitOld
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}



////ยังไม่เสร็จเปลี่ยนหน่วยไม่ได้
//function editProduct_order($idproduct_order, $idamount_product_order) {
//    $conn = dbconnect();
//    $SQLCommand = "UPDATE `product_order` SET `amount_product_order`=:amount_product_order "
//            . "WHERE `idproduct_order`=:idproduct_order";
//
//    $SQLPrepare = $conn->prepare($SQLCommand);
//    $SQLPrepare->execute(
//            array(
//                ":idproduct_order" => $idproduct_order,
//                ":amount_product_order" => $idamount_product_order
//            )
//    );
//
//    if ($SQLPrepare->rowCount() > 0) {
//        return TRUE;
//    } else {
//        return false;
//    }
//}

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

function searchArr($array, $key, $value) {
    foreach ($array as $key_ => $value_) {
        if ($value_[$key] == $value) {
            return $key_;
        }
    }
    return FALSE;
}
