<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

echo "<pre>";
print_r($_POST);
print_r($_GET);
//echo $_POST['check_shipment'][0];
echo "<pre>";

$idproduct_order = $_POST['check_shipment'];
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$change_date_start = date("d-m-Y", strtotime($val_date_start));
$val_date_end = $getShipment_period['date_end'];
$change_date_end = date("d-m-Y", strtotime($val_date_end));

$idfactory = $_GET['idfactory'];
$getFactory = getFactoryByID($idfactory);
$val_name_factory = $getFactory['name_factory'];

$check_shipment = $_POST['check_shipment'];
$idtransport = $_POST['idtransport'];
$date_transport = $_POST['date_transport'];
$volume = $_POST['volume'];
$number = $_POST['number'];
$price_transport = $_POST['price_transport'];

foreach ($idproduct_order as $value) {
    $editChange_statusByID = editChange_status($value, $check_shipment);
    $shipmentByID = addShipment($idorder_transport, $value, $idshipment_period, $idtransport, $date_transport, $volume, $number, $price_transport);
}
//$shipmentByID = addShipment($idorder_transport, $idproduct_order, $idshipment_period, $idtransport, $date_transport, $volume, $number, $price_transport);
//print_r($shipmentByID);
//$editChange_statusByID = editChange_status($idproduct_order);
if ($shipmentByID) {
        header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&action=addShipmentCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&action=addShipmentError");
}
