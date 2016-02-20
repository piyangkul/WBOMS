<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];


$Shipment_period = addShipment_period($date_start, $date_end);
$editStatus_checkTransport_Postpone = editStatus_checkTransport_Postpone();

if ($Shipment_period > 0) {
    header("location: ../shipment1.php?action=addPeriodCompleted");
} else {
    header("location: ../shipment1.php?action=addPeriodError");
}
