<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

//stat_shop_bill
function getYaer() {
    $conn = dbconnect();
    $SQLCommand = "SELECT YEAR(`date_pay`)AS IDyear,YEAR(`date_pay`)AS A_D,YEAR(`date_pay`)+543 AS B_E FROM pay GROUP BY YEAR(`date_pay`) ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return json_encode($resultArr); //, JSON_UNESCAPED_UNICODE);
    //return "{}";
}

//action_stat_shop_show
function getPayNameShop($year_pay) {
    $conn = dbconnect();
    $SQLCommand = "SELECT view_shop.idshop,view_shop.shop_code,view_shop.name_shop FROM pay JOIN view_shop ON pay.shop_idshop=view_shop.idshop WHERE YEAR(`date_pay`)=:year_pay GROUP BY `shop_idshop` ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_pay" => $year_pay
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//action_stat_shop_show
function getStatus_pay_GET($year_pay, $status_pay, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT YEAR(`date_pay`),view_shop.idshop,view_shop.shop_code,view_shop.name_shop,SUM(`type_pay`='cash')AS get_cash,SUM(`status_due`='on')AS get_on,SUM(`status_due`='over')AS get_over FROM pay JOIN view_shop ON pay.shop_idshop=view_shop.idshop WHERE YEAR(`date_pay`)=:year_pay AND `status_pay`=:status_pay AND pay.shop_idshop=:idshop GROUP BY `shop_idshop` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_pay" => $year_pay,
                ":status_pay" => $status_pay,
                ":idshop" => $idshop
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//action_stat_shop_show
function getStatus_pay_LACK($year_pay, $status_pay, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT YEAR(`date_pay`),view_shop.idshop,view_shop.shop_code,view_shop.name_shop,SUM(`type_pay`='cash')AS lack_cash,SUM(`status_due`='on')AS lack_on,SUM(`status_due`='over')AS lack_over FROM pay JOIN view_shop ON pay.shop_idshop=view_shop.idshop WHERE YEAR(`date_pay`)=:year_pay AND `status_pay`=:status_pay AND pay.shop_idshop=:idshop GROUP BY `shop_idshop` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_pay" => $year_pay,
                ":status_pay" => $status_pay,
                ":idshop" => $idshop
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//action_stat_shop_show
function getStatus_pay_UNGET($year_pay, $status_pay, $idshop) {
    $conn = dbconnect();
    $SQLCommand = "SELECT YEAR(`date_pay`),view_shop.idshop,view_shop.shop_code,view_shop.name_shop,SUM(`status_pay`='unget')AS unget FROM pay JOIN view_shop ON pay.shop_idshop=view_shop.idshop WHERE YEAR(`date_pay`)=:year_pay AND `status_pay`=:status_pay AND pay.shop_idshop=:idshop GROUP BY `shop_idshop` ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_pay" => $year_pay,
                ":status_pay" => $status_pay,
                ":idshop" => $idshop
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//popup_unget
function getPay_unget($idshop,$status_pay) {
    if ($idshop != "undefined") {

        $conn = dbconnect();
        $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period where idshop=:idshop AND status_pay=:status_pay ORDER BY `date_pay` ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshop" => $idshop,
                    ":status_pay" => $status_pay
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

//popup_lack_over และ on
function getPay_lack($idshop,$status_pay,$status_due) {
    if ($idshop != "undefined") {

        $conn = dbconnect();
        $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period where idshop=:idshop AND status_pay=:status_pay AND status_due=:status_due ORDER BY `date_pay` ";

        $SQLPrepare = $conn->prepare($SQLCommand);
        $SQLPrepare->execute(
                array(
                    ":idshop" => $idshop,
                    ":status_pay" => $status_pay,
                    ":status_due" => $status_due
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
