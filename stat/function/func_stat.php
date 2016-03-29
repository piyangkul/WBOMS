<?php
require_once dirname(__FILE__) . '/../../config/connect.php';

function getIncome_Outcome() {
    $conn = dbconnect();
    $SQLCommand = "SELECT A.idshipment_period,A.date_start,A.date_end, SUM(pay.price_pay)AS income,A.outcome FROM (SELECT shipment_period.idshipment_period,shipment_period.date_start,shipment_period.date_end ,SUM(real_price_pay_factory)AS outcome FROM `shipment_period` LEFT JOIN pay_factory ON pay_factory.shipment_period_idshipment=shipment_period.idshipment_period GROUP BY shipment_period.idshipment_period )AS A LEFT JOIN pay ON pay.idshipment_period = A.idshipment_period GROUP BY A.idshipment_period ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}