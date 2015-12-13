<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];

$checkEditShipment_Period = editShipment_period($idshipment_period, $date_start, $date_end);
if ($checkEditShipment_Period) {
    header("location: ../shipment1.php?action=editPeriodCompleted");
} else {
    header("location: ../shipment1.php?action=editPeriodError");
}