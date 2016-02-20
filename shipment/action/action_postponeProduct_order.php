<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];

$price = $_GET['price'];
$status_shipment_factory = $_GET['status_shipment'];

$editStatus_checkTransport = editStatus_checkTransport($idproduct_order);
if ($editStatus_checkTransport) {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=PostponeCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=PostponeError");
}
