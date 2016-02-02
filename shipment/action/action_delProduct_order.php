<!-- Link จากหน้า add_shipment3.php -->
<?php
require_once dirname(__FILE__) . '/../function/func_shipment.php';

$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$change_date_start = date("d-m-Y", strtotime($val_date_start));
$val_date_end = $getShipment_period['date_end'];
$change_date_end = date("d-m-Y", strtotime($val_date_end));

$idfactory = $_GET['idfactory'];
$getFactory = getFactoryByID($idfactory);
$val_name_factory = $getFactory['name_factory'];

$checkDelProduct_order = delProduct_order($idproduct_order);
if ($checkDelProduct_order) {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&action=delProduct_orderCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&action=delProduct_orderError");
}
