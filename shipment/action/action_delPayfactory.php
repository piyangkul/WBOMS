<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$page = $_GET['page'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$price = $_GET['price'];
//$status_shipment_factory = $_GET['status_shipment'];

$getPayFactory = getPayFactory($idfactory, $idshipment_period);
$val_idpay_factory = $getPayFactory['idpay_factory'];//รับค่าidpay_factory

//ทดสอบค่า
echo '<pre>';
print_r($getPayFactory);
echo '</pre>';
echo $val_idpay_factory;

$delPayfactory = delPayfactory($val_idpay_factory);//ลบข้อมูลการจ่ายเงิน

//เริ่มต้นการเปลี่ยนสถานะใน order_transport
$getProduct_waitchangeStatusShipment = getProduct_waitchangeStatusShipment($idfactory,$idshipment_period);//ค้นหาสินค้า
$i1 = 0;
foreach ($getProduct_waitchangeStatusShipment as $value) {
    $i1++;
    $val_name_product = $value['name_product'];
    $val_idorder_transport = $value['idorder_transport'];
    echo $val_name_product;
    $editStatus_check_price = editStatus_check_price($val_idorder_transport);//เปลี่ยนสถานะรายการสินค้า
}
//สิ้นสุดการเปลี่ยนสถานะใน order_transport

//เริ่มต้นการเปลี่ยนสถานะใน product_refunds
$getProduct_waitchangeStatusRefund = getProduct_waitchangeStatusRefund($idfactory,$idshipment_period);
$i2 = 0;
foreach ($getProduct_waitchangeStatusRefund as $value) {
    $i2++;
    $val_name_product = $value['name_product'];
    $val_idproduct_refunds = $value['idproduct_refunds'];
    echo $val_name_product;
    $editStatus_unreturn = editStatus_unreturn($val_idproduct_refunds);
}
//สิ้นสุดการเปลี่ยนสถานะใน product_refunds


//updatestatusShipment
$getUpdateStatusShipmentByID = getUpdateStatusShipmentByID($idfactory, $idshipment_period);
$val_status_shipment = $getUpdateStatusShipmentByID['status_shipment'];
echo '<pre>';
echo $val_status_shipment;
echo '</pre>';


if ($page == 'shipment2') {
    if ($delPayfactory > 0) {
        header("location: ../shipment2.php?idshipment_period=$idshipment_period&action=delPayfactoryCompleted");
    } else {
        header("location: ../shipment2.php?idshipment_period=$idshipment_period&action=delPayfactoryError");
    }
} elseif ($page == 'shipment3') {
    if ($delPayfactory > 0) {
        header("location: ../add_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&price=$price&status_shipment=$val_status_shipment&action=delPayfactoryCompleted");
    } else {
        header("location: ../add_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&price=$price&status_shipment=$val_status_shipment&action=delPayfactoryError");
    }
} else {
    header("location: ../../index.php");
}