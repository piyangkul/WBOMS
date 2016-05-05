<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getShopsJSON() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_shop ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

function getShopsByID($idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_shop WHERE idshop=:idshop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//docket
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

//docket
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

//action_docket_period_show
function getRegion() {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `region` ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_docket_period_show
function getProvinceByIDRegion($idregion) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM province WHERE idregion=:idregion ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idregion" => $idregion
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_docket_period_show
function getPayByIDPeriod($idshipment_period, $idregion, $idprovince) {

    $conn = dbconnect();
    $SQLCommand = 'SELECT A.idshop,A.name_shop,province.idprovince,province.name_province,region.idregion,region.name_region,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period JOIN province ON province.idprovince=A.idprovince JOIN region ON region.idregion=province.idregion where A.idshipment_period=:idshipment_period ';
    if ($idregion != "" && $idprovince != "") {//ถ้ามี idregion และ idprovince ให้ทำ
        $SQLCommand.="AND region.idregion = :idregion AND province.idprovince = :idprovince ";
        $SQLCommand.="ORDER BY status_process IS NULL ";

        //$SQLCommand = "SELECT A.idshop,A.name_shop,province.name_province,region.name_region,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period JOIN province ON province.idprovince=A.idprovince JOIN region ON region.idregion=province.idregion where A.idshipment_period=:idshipment_period ORDER BY status_process IS NOT NULL  ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshipment_period" => $idshipment_period,
                    ":idregion" => $idregion,
                    ":idprovince" => $idprovince
                )
        );
        $resultArr = array();
        while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
            array_push($resultArr, $result);
        }
        return $resultArr;
    } elseif ($idregion != "") {//ถ้ามี idregion ให้ทำ
        $SQLCommand.="AND region.idregion = :idregion ";
        $SQLCommand.="ORDER BY status_process IS NULL ";

        //$SQLCommand = "SELECT A.idshop,A.name_shop,province.name_province,region.name_region,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period JOIN province ON province.idprovince=A.idprovince JOIN region ON region.idregion=province.idregion where A.idshipment_period=:idshipment_period ORDER BY status_process IS NOT NULL  ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshipment_period" => $idshipment_period,
                    ":idregion" => $idregion
                )
        );
        $resultArr = array();
        while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
            array_push($resultArr, $result);
        }
        return $resultArr;
    } else {
        $SQLCommand.="ORDER BY status_process IS NULL ";
        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshipment_period" => $idshipment_period,
                )
        );
        $resultArr = array();
        while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
            array_push($resultArr, $result);
        }
        return $resultArr;
    }
}

//action_docket_show
function getPayByID($idshop) {
    if ($idshop != "undefined") {

        $conn = dbconnect();
        $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period where idshop=:idshop ORDER BY A.date_start ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshop" => $idshop
                )
        );
        $resultArr = array();
        while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
            array_push($resultArr, $result);
        }
        return $resultArr;
    } else {
        return array();
    }
}

//action_docket_show
function getPayByIDcheckStatus($idshop, $idshipment_period) {
    if ($idshop != "undefined") {

        $conn = dbconnect();
        $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period where idshop=:idshop AND A.idshipment_period=:idshipment_period ORDER BY A.date_start ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshop" => $idshop,
                    ":idshipment_period" => $idshipment_period
                )
        );
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return array();
    }
}

//action_finishPayshop อัพเดทสถานะการจ่ายเงินว่าเสร็จสิ้น
function editStatus_finish_payShop($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `pay` SET `status_process`= 'finish' WHERE shop_idshop=:idshop AND idshipment_period=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

//action_unpay_shop_show
function getShop_notPay() {
    $conn = dbconnect();
    $SQLCommand = "SELECT A.idshop,A.name_shop,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period WHERE pay.date_pay IS NULL ORDER BY date_start DESC ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//docket_paper แสดงสินค้า ,action_docket_show, action_docket_period_show, action_unpay_shop_show
function getProductDocketByID($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idshop=:idshop AND view_transport_shipment.idshipment_period=:idshipment_period ORDER BY date_transport ASC ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//docket_paper แสดงสินค้าคืน ของรอบที่แล้ว , popup_product_refund
function getProductRefundByID($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_product_refunds.date_product_refunds,shipment_period.idshipment_period, shop.idshop,shop.name_shop,factory.idfactory,factory.name_factory,product.idproduct,product.name_product,unit.price_unit,unit.name_unit,product_refunds.amount_product_refunds,product.difference_amount_product,factory.difference_amount_factory,product_refunds.difference_product_refunds,difference.type_money,product_refunds.price_product_refunds 
            FROM order_product_refunds JOIN product_refunds ON order_product_refunds.idorder_product_refunds=product_refunds.order_product_refunds_idorder_product_refunds JOIN unit ON product_refunds.idunit=unit.idunit JOIN product ON product.idproduct=unit.idproduct JOIN factory ON product.idfactory=factory.idfactory JOIN difference ON product.idproduct=difference.idproduct JOIN shop ON order_product_refunds.shop_idshop=shop.idshop JOIN shipment_period ON order_product_refunds.shipment_period_idshipment_period=shipment_period.idshipment_period WHERE product_refunds.idunit=unit.idunit AND shipment_period.idshipment_period=:idshipment_period AND difference.idshop=:idshop AND shop.idshop=:idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//docket_paper ใช้หารอบเดือนที่แล้ว(สินค้าคืน)
function getBeforeid($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `shipment_period` WHERE `idshipment_period`<:idshipment_period ORDER BY `idshipment_period` DESC LIMIT 1 ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//docket_paper แสดงสินค้า mergeข้อมูลการขนส่งที่ส่งรอบเดียวกัน
function getProductDuplicateDocketByID($idshop, $idshipment_period, $name_transport, $number, $volume, $idfactory) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_product_order_shipment.idshop=:idshop AND view_transport_shipment.idshipment_period=:idshipment_period AND name_transport=:name_transport AND number=:number AND volume=:volume AND idfactory=:idfactory ORDER BY date_transport ASC ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period,
                ":name_transport" => $name_transport,
                ":volume" => $volume,
                ":number" => $number,
                ":idfactory" => $idfactory
            )
    );

    $count = $SQLPrepare->rowCount();
    return $count;
}

//action_docket_show
function getOrder_product_refundsByID($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shop_idshop,shipment_period_idshipment_period,sum(order_product_refunds.order_price_product_refunds)AS order_price_product_refunds FROM `order_product_refunds` WHERE `shop_idshop`=:idshop AND `shipment_period_idshipment_period`=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้า action_addPayshop 
function addPayshop($idshop, $idshipment_period, $price_order_total, $debt, $price_order_refund, $price_pay, $date_pay, $type_pay, $date_pay_credit, $status_pay, $cheque_number, $cheque_name_bank, $cheque_branch_bank, $status_process, $status_due) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `pay`(`idshipment_period`, `shop_idshop`, `price_pay`, `price_order_total`, `price_order_refund`, `debt`, `date_pay`, `date_pay_credit`, `type_pay`, `status_pay`, `cheque_number`, `cheque_name_bank`, `cheque_branch_bank`, `status_process`,`status_due`) "
            . "VALUES (:idshipment_period, :idshop, :price_pay, :price_order_total, :price_order_refund, :debt, :date_pay, :date_pay_credit,:type_pay ,:status_pay, :cheque_number, :cheque_name_bank, :cheque_branch_bank, :status_process, :status_due) ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period,
                ":price_order_total" => $price_order_total,
                ":debt" => $debt,
                ":price_order_refund" => $price_order_refund,
                ":price_pay" => $price_pay,
                ":date_pay" => $date_pay,
                ":type_pay" => $type_pay,
                ":date_pay_credit" => $date_pay_credit,
                ":status_pay" => $status_pay,
                ":cheque_number" => $cheque_number,
                ":cheque_name_bank" => $cheque_name_bank,
                ":cheque_branch_bank" => $cheque_branch_bank,
                ":status_process" => $status_process,
                ":status_due" => $status_due
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        echo $SQLCommand;
        return false;
    }
}

//autoComplete ชื่อธนาคาร popup_add_payshop
function getNamebank_shop() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT pay.cheque_name_bank FROM pay WHERE cheque_name_bank IS NOT NULL AND cheque_branch_bank IS NOT NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//autoComplete สาขาธนาคาร popup_add_payshop
function getBranchbank_shop() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT pay.cheque_branch_bank FROM pay WHERE cheque_name_bank IS NOT NULL AND cheque_branch_bank IS NOT NULL ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//popup_detail_payshop,action_docket_show
function getPayDetailByID($idshop, $idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `pay` JOIN shipment_period ON pay.idshipment_period=shipment_period.idshipment_period WHERE shipment_period.idshipment_period=:idshipment_period AND pay.shop_idshop=:idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshop" => $idshop,
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//ใช้หน้า action_delPayshop
function delPayshop($idshipment_period, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `pay` WHERE `idshipment_period`=:idshipment_period AND `shop_idshop`=:idshop ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period,
                ":idshop" => $idshop
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}
