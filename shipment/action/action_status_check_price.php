<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idorder_transport = $_GET['idorder_transport'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];

$editStatus_check_price = editStatus_check_price($idorder_transport);
if (editStatus_check_price) {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&idorder_transport=" . $idorder_transport . "&action=editStatus_check_priceCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&idorder_transport=" . $idorder_transport . "&action=editStatus_check_priceError");
}