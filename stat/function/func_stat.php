<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

//action_stat_show
function getIncome_Outcome($month_start, $year_start, $month_end, $year_end) {
    if ($month_start == 1) {
        $month_start = '01';
    } elseif ($month_start == 2) {
        $month_start = '02';
    } elseif ($month_start == 3) {
        $month_start = '03';
    } elseif ($month_start == 4) {
        $month_start = '04';
    } elseif ($month_start == 5) {
        $month_start = '05';
    } elseif ($month_start == 6) {
        $month_start = '06';
    } elseif ($month_start == 7) {
        $month_start = '07';
    } elseif ($month_start == 8) {
        $month_start = '08';
    } elseif ($month_start == 9) {
        $month_start = '09';
    }
    if ($month_end == 1) {
        $month_end = '01';
    } elseif ($month_end == 2) {
        $month_end = '02';
    } elseif ($month_end == 3) {
        $month_end = '03';
    }elseif ($month_end == 4) {
        $month_end = '04';
    }elseif ($month_end == 5) {
        $month_end = '05';
    }elseif ($month_end == 6) {
        $month_end = '06';
    }elseif ($month_end == 7) {
        $month_end = '07';
    }elseif ($month_end == 8) {
        $month_end = '08';
    }elseif ($month_end == 9) {
        $month_end = '09';
    }
    $conn = dbconnect();
    $SQLCommand = "SELECT search_start.idshipment_period,search_start.date_start,search_start.date_end,search_start.income,search_start.outcome "
            . "FROM (SELECT A.idshipment_period,A.date_start,A.date_end, SUM(pay.price_pay-pay.debt)AS income,A.outcome FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period WHERE A.date_start>= STR_TO_DATE(CONCAT('" . $year_start . "', '" . $month_start . "', '01'), '%Y%m%d') GROUP BY A.idshipment_period ORDER BY A.date_start )AS search_start "
            . "JOIN (SELECT A.idshipment_period,A.date_start,A.date_end, SUM(pay.price_pay-pay.debt)AS income,A.outcome FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period WHERE A.date_end <= STR_TO_DATE(CONCAT('" . $year_end . "', '" . $month_end . "', '31'), '%Y%m%d') GROUP BY A.idshipment_period ORDER BY A.date_start )AS search_end "
            . "ON search_start.idshipment_period=search_end.idshipment_period ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
//            array(
//                ":month_start" => $month_start,
//                ":year_start" => $year_start,
//                ":month_end" => $month_end,
//                ":year_end" => $year_end
//            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//popup_stat_income
function getIncomeBYidshipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period,pay.shop_idshop,view_shop.shop_code,view_shop.name_shop,pay.price_order_total,pay.price_order_refund,pay.price_pay,pay.debt,(price_pay-debt)AS income FROM pay JOIN shipment_period ON pay.idshipment_period=shipment_period.idshipment_period JOIN view_shop ON view_shop.idshop=pay.shop_idshop WHERE shipment_period.idshipment_period=:idshipment_period ORDER BY view_shop.idshop ";
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

//popup_stat_outcome
function getOutcomeBYidshipment($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT shipment_period.idshipment_period,pay_factory.factory_idfactory,factory.code_factory,factory.name_factory,pay_factory.price_pay_factory,pay_factory.price_product_refund_factory,pay_factory.real_price_pay_factory AS outcome FROM pay_factory JOIN shipment_period ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period JOIN factory ON factory.idfactory=pay_factory.idpay_factory WHERE shipment_period.idshipment_period=:idshipment_period ORDER BY pay_factory.factory_idfactory ";

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

//stat_search_year_start
function getYear_start() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT YEAR(A.date_start)AS A_D_start,(YEAR(A.date_start)+543)AS B_E_start FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period GROUP BY A.idshipment_period ORDER BY A.date_start ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//stat_search_month_start
function getMonth_start() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT MONTH(A.date_start)AS month_start FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period GROUP BY A.idshipment_period ORDER BY A.date_start ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//stat_search_year_end
function getYear_end($year_start) {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT YEAR(A.date_end)AS A_D_end,(YEAR(A.date_end)+543)AS B_E_end FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period WHERE YEAR(A.date_end)>=:year_start GROUP BY A.idshipment_period ORDER BY A.date_end ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_start" => $year_start
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//stat_search_year_end
function getYear_end_December($year_start) {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT YEAR(A.date_end)AS A_D_end,(YEAR(A.date_end)+543)AS B_E_end FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period WHERE YEAR(A.date_end)>:year_start GROUP BY A.idshipment_period ORDER BY A.date_end ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":year_start" => $year_start
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//stat_search_month_end
function getMonth_end($month_start) {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT MONTH(A.date_end)AS month_end FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period WHERE MONTH(A.date_end)>:month_start GROUP BY A.idshipment_period ORDER BY A.date_end ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":month_start" => $month_start
            )
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

//stat_search_month_end
function getMonth_endThisYear() {
    $conn = dbconnect();
    $SQLCommand = "SELECT DISTINCT MONTH(A.date_end)AS month_end FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period GROUP BY A.idshipment_period ORDER BY A.date_end ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
