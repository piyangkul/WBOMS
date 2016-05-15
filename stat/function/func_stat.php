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
    } elseif ($month_end == 4) {
        $month_end = '04';
    } elseif ($month_end == 5) {
        $month_end = '05';
    } elseif ($month_end == 6) {
        $month_end = '06';
    } elseif ($month_end == 7) {
        $month_end = '07';
    } elseif ($month_end == 8) {
        $month_end = '08';
    } elseif ($month_end == 9) {
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

//chart
function getIncome_Outcome_JSON($month_start, $year_start, $month_end, $year_end) {
    $resultArr = getIncome_Outcome($month_start, $year_start, $month_end, $year_end);
    return json_encode($resultArr, JSON_NUMERIC_CHECK); //, JSON_UNESCAPED_UNICODE);
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
    $SQLCommand = "SELECT shipment_period.idshipment_period,pay_factory.factory_idfactory,factory.code_factory,factory.name_factory,pay_factory.price_pay_factory,pay_factory.price_product_refund_factory,pay_factory.real_price_pay_factory AS outcome 
FROM pay_factory JOIN factory ON factory.idfactory=pay_factory.factory_idfactory JOIN shipment_period ON shipment_period.idshipment_period=pay_factory.shipment_period_idshipment WHERE shipment_period.idshipment_period=:idshipment_period ORDER BY pay_factory.factory_idfactory ";

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

//chart
function getsum_sale($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(sale) AS sum_sale FROM
(SELECT ((order_shipment.price_unit-((order_shipment.difference_amount_product/100)*order_shipment.price_unit))*order_shipment.amount_product_order) AS sale,
order_shipment.price_unit,order_shipment.difference_amount_product,order_shipment.amount_product_order FROM(SELECT order_transport.idorder_transport,order_transport.idtransport,order_transport.volume,order_transport.number,order_transport.price_transport,order_transport.status_shipment,product.name_product,product_order.amount_product_order,unit.name_unit,unit.price_unit,product.difference_amount_product,product_order.difference_product_order,product_order.type_product_order FROM transport JOIN order_transport ON transport.idtransport=order_transport.idtransport JOIN shipment_period ON order_transport.shipment_period_idshipment_period=shipment_period.idshipment_period JOIN product_order ON order_transport.product_order_idproduct_order=product_order.idproduct_order JOIN unit ON product_order.idunit=unit.idunit JOIN product ON unit.idproduct=product.idproduct JOIN factory ON product.idfactory=factory.idfactory WHERE shipment_period.idshipment_period=:idshipment_period ) AS order_shipment ) AS sale ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_sale'];
}

//chart
function getPrice_transport($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(price_transport) AS sum_price_transport
FROM(SELECT shipment_period.idshipment_period,factory.idfactory,factory.name_factory,product.name_product,product_order.amount_product_order,order_transport.price_transport 
 FROM shipment_period JOIN order_transport ON shipment_period.idshipment_period = order_transport.shipment_period_idshipment_period 
 JOIN product_order ON order_transport.product_order_idproduct_order = product_order.idproduct_order 
 JOIN unit ON product_order.idunit = unit.idunit 
 JOIN product ON product.idproduct = unit.idproduct JOIN factory ON factory.idfactory=product.idfactory 
 WHERE shipment_period.idshipment_period = :idshipment_period  GROUP BY order_transport.idtransport,order_transport.date_transport,order_transport.volume,order_transport.number) AS tab ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_price_transport'];
}

//chart
function getsum_refund($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(refund)AS sum_refund FROM 
(SELECT ((refund_shipment.price_unit-((refund_shipment.difference_amount_product/100)*refund_shipment.price_unit))*refund_shipment.amount_product_refunds) AS refund
FROM(SELECT shipment_period.idshipment_period, shop.idshop,shop.name_shop,factory.idfactory,factory.name_factory,product.idproduct,product.name_product,unit.price_unit,unit.name_unit,product_refunds.amount_product_refunds,product.difference_amount_product,factory.difference_amount_factory,difference.price_difference,difference.type_money,product_refunds.price_product_refunds FROM order_product_refunds JOIN product_refunds ON order_product_refunds.idorder_product_refunds=product_refunds.order_product_refunds_idorder_product_refunds JOIN unit ON product_refunds.idunit=unit.idunit JOIN product ON product.idproduct=unit.idproduct JOIN factory ON product.idfactory=factory.idfactory JOIN difference ON product.idproduct=difference.idproduct JOIN shop ON order_product_refunds.shop_idshop=shop.idshop JOIN shipment_period ON order_product_refunds.shipment_period_idshipment_period=shipment_period.idshipment_period WHERE product_refunds.idunit=unit.idunit AND difference.idshop=shop.idshop  AND shipment_period.idshipment_period=:idshipment_period) AS refund_shipment)AS refund ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_refund'];
}

//chart
function getIncome_Outcome_total($getIncome_Outcome) {
    $arrAll = array();
    foreach ($getIncome_Outcome as $value) {
        $_idshipment_period = $value['idshipment_period'];

        $getsum_refund = getsum_refund($_idshipment_period);
        $getPrice_transport = getPrice_transport($_idshipment_period);
        $getsum_sale = getsum_sale($_idshipment_period);

        $getsum_sale_income = getsum_sale_income($_idshipment_period);
        $getdebt = getdebt($_idshipment_period);
        $getsum_sale_income_Last = getsum_sale_income_Last($_idshipment_period);
        $getPrice_transport_Last = getPrice_transport_Last($_idshipment_period);
        $getsum_refund_income = getsum_refund_income($_idshipment_period);

        $all_outcome = $getsum_sale + $getPrice_transport - $getsum_refund;
        $all_income = $getsum_sale_income + $getPrice_transport + $getdebt + $getsum_sale_income_Last + $getPrice_transport_Last - $getsum_refund_income; //$getsum_sale_income + $getPrice_transport + $getdebt + $getsum_sale_income_Last + $getPrice_transport_Last - $getsum_refund_income

        $arrRes = array(
            "idshipment_period" => $_idshipment_period,
            "date_start" => $value['date_start'],
            "date_end" => $value['date_end'],
            "income" => $value['income'],
            "outcome" => $value['outcome'],
            "all_outcome" => $all_outcome,
            "all_income" => $all_income
        );
        array_push($arrAll, $arrRes);
    }
    return $arrAll;
}

//chart
function getIncome_Outcome_total_JSON($getIncome_Outcome) {
    $arrAll = getIncome_Outcome_total($getIncome_Outcome);
    return json_encode($arrAll, JSON_NUMERIC_CHECK); //, JSON_UNESCAPED_UNICODE);
}

//chart
function getsum_sale_income($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(sale) AS sum_sale FROM
(SELECT IF(product_docket.type_product_order='PERCENT',((product_docket.price_unit-((product_docket.difference_product_order/100)*product_docket.price_unit))*product_docket.amount_product_order),(product_docket.price_unit+product_docket.difference_product_order)* product_docket.amount_product_order) AS sale,product_docket.idshop,
product_docket.price_unit,product_docket.difference_product_order,product_docket.amount_product_order,product_docket.type_product_order FROM
(SELECT view_product_order_shipment.idshop,view_product_order_shipment.name_product,view_product_order_shipment.amount_product_order,view_product_order_shipment.name_unit,view_product_order_shipment.price_unit,view_product_order_shipment.difference_product_order,view_product_order_shipment.type_product_order FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_transport_shipment.idshipment_period=:idshipment_period )AS product_docket)AS sale ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_sale'];
}

//chart
function getdebt($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(debt)AS debt FROM `pay` JOIN shipment_period ON pay.idshipment_period=shipment_period.idshipment_period WHERE shipment_period.idshipment_period=:idshipment_period-1 ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['debt'];
}

//chart
function getsum_sale_income_Last($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(sale) AS sum_sale FROM
(SELECT AA.sale,AA.price_unit,AA.difference_product_order,AA.amount_product_order,AA.type_product_order FROM
(SELECT IF(product_docket.type_product_order='PERCENT', ((product_docket.price_unit-((product_docket.difference_product_order/100)*product_docket.price_unit))*product_docket.amount_product_order),(product_docket.price_unit+product_docket.difference_product_order)* product_docket.amount_product_order) AS sale,product_docket.idshop, product_docket.price_unit,product_docket.difference_product_order,product_docket.amount_product_order,product_docket.type_product_order FROM 
 (SELECT view_product_order_shipment.idshop,view_product_order_shipment.name_product,view_product_order_shipment.amount_product_order,view_product_order_shipment.name_unit,view_product_order_shipment.price_unit,view_product_order_shipment.difference_product_order,view_product_order_shipment.type_product_order 
 FROM view_product_order_shipment LEFT JOIN view_transport_shipment ON view_product_order_shipment.idproduct_order = view_transport_shipment.product_order_idproduct_order WHERE view_transport_shipment.idshipment_period=:idshipment_period-1)AS product_docket)AS AA
 JOIN 
(SELECT A.idshop,A.name_shop,province.idprovince,province.name_province,region.idregion,region.name_region,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period JOIN province ON province.idprovince=A.idprovince JOIN region ON region.idregion=province.idregion where A.idshipment_period=:idshipment_period-1 AND pay.date_pay IS NULL )AS BB
ON AA.idshop=BB.idshop)AS sale ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_sale'];
}

//chart
function getPrice_transport_Last($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT SUM(all_transport.price_transport) AS sum_price_transport FROM
(SELECT AA.price_transport FROM(SELECT all_transport.idshipment_period,all_transport.idshop,all_transport.idfactory,all_transport.name_factory,all_transport.name_product,all_transport.amount_product_order,all_transport.price_transport
FROM(SELECT shipment_period.idshipment_period,shop.idshop,factory.idfactory,factory.name_factory,product.name_product,product_order.amount_product_order,order_transport.price_transport FROM shipment_period JOIN order_transport ON shipment_period.idshipment_period = order_transport.shipment_period_idshipment_period 
 JOIN product_order ON order_transport.product_order_idproduct_order = product_order.idproduct_order 
JOIN order_p ON product_order.idorder_p= order_p.idorder_p 
JOIN shop ON order_p.idshop=shop.idshop
 JOIN unit ON product_order.idunit = unit.idunit 
 JOIN product ON product.idproduct = unit.idproduct JOIN factory ON factory.idfactory=product.idfactory 
 WHERE shipment_period.idshipment_period =:idshipment_period-1  GROUP BY order_transport.idtransport,order_transport.date_transport,order_transport.volume,order_transport.number) AS all_transport )AS AA
JOIN 
(SELECT A.idshop,A.name_shop,province.idprovince,province.name_province,region.idregion,region.name_region,A.idshipment_period,A.date_start,A.date_end,pay.date_pay,pay.debt,pay.price_pay,pay.status_pay,pay.status_process FROM (SELECT shop.idshop,shop.name_shop,shop.idprovince,shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end FROM shop,shipment_period) AS A left JOIN pay on A.idshop=pay.shop_idshop and A.idshipment_period=pay.idshipment_period JOIN province ON province.idprovince=A.idprovince JOIN region ON region.idregion=province.idregion where A.idshipment_period=:idshipment_period-1 AND pay.date_pay IS NULL )AS BB
ON AA.idshop=BB.idshop)AS all_transport ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_price_transport'];
}

//chart
function getsum_refund_income($idshipment_period) {
    $conn = dbconnect();
    $SQLCommand = "SELECT sum(order_product_refunds.order_price_product_refunds)AS sum_refund FROM `order_product_refunds` WHERE `shipment_period_idshipment_period`=:idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idshipment_period" => $idshipment_period
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result['sum_refund'];
}
