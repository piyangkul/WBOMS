<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idorder_transport = $_GET['idorder_transport'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$price = $_GET['price'];

$editStatus_check_price = editStatus_check_price($idorder_transport);

$getUpdateStatusShipmentByID = getUpdateStatusShipmentByID($idfactory, $idshipment_period);
$val_status_shipment = $getUpdateStatusShipmentByID['status_shipment'];
echo '<pre>';
echo $val_status_shipment;
echo '</pre>';

if (editStatus_check_price) {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&idorder_transport=" . $idorder_transport . "&price=" . $price . "&status_shipment=" . $val_status_shipment  . "&action=editStatus_check_priceCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&idorder_transport=" . $idorder_transport . "&price=" . $price . "&status_shipment=" . $val_status_shipment  . "&action=editStatus_check_priceError");
}