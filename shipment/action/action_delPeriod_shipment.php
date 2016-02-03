<!-- Link จากหน้า shipment1.php -->
<?php
require_once dirname(__FILE__) . '/../function/func_shipment.php';

$idshipment_period = $_GET['idshipment_period'];

$checkDelPeriod_shipment = delPeriod_shipment($idshipment_period);
if ($checkDelPeriod_shipment) {
    header("location: ../shipment1.php?action=delPeriodCompleted");
} else {
    header("location: ../shipment1.php?action=delPeriodError");
}
