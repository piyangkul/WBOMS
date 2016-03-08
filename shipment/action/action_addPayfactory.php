<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

echo '<pre>';
print_r($_POST);
print_r($_GET);
echo '</pre>';

$page = $_GET['page'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$price_pay_factory = $_POST['price_pay_factory']; //ยอดเงินที่โรงงานเรียกเก็บ 

$price_product_refund_factory = $_POST['price_product_refund_factory']; //ยอดเงินสินค้าคืนรวม 
$real_price_pay_factory = $_POST['real_price_pay_factory']; //สรุปยอดเงินที่จ่ายโรงงาน 
$date_pay_factory = $_POST['date_pay_factory']; //วันที่จ่ายเงินโรงงาน 
$type_pay_factory = $_POST['type_pay_factory']; //ประเภทการจ่ายเงิน
$date_pay_factory_credit = $_POST['date_pay_factory_credit']; //วันที่เช็ค
$cheque_number = $_POST['cheque_number']; 
$cheque_name_bank = $_POST['cheque_name_bank']; 
$cheque_branch_bank = $_POST['cheque_branch_bank']; 

/////if(!isset($date_pay_factory_credit)){//ไม่โดนตั้งค่า
//    $date_pay_factory_credit = NULL;
//}
//echo $page;
//echo $price_pay_factory;///

$status_shipment_factory = $_GET['status_shipment'];
//$price_pay_factory = $_GET['price_pay_factory'];

$Payfactory = addPayfactory($idfactory, $idshipment_period, $price_pay_factory, $price_product_refund_factory, $real_price_pay_factory, $type_pay_factory, $date_pay_factory, $date_pay_factory_credit, $cheque_number, $cheque_name_bank, $cheque_branch_bank);

//เริ่มต้นการเปลี่ยนสถานะใน order_transport เป็นจ่ายเงินโรงงานแล้ว (pay)
$getProduct_waitchangeStatusShipment = getProduct_waitchangeStatusShipment($idfactory,$idshipment_period);
$i1 = 0;
foreach ($getProduct_waitchangeStatusShipment as $value) {
    $i1++;
    $val_name_product = $value['name_product'];
    $val_idorder_transport = $value['idorder_transport'];
    echo $val_name_product;
    $editStatus_pay = editStatus_pay($val_idorder_transport);
}
//สิ้นสุดการเปลี่ยนสถานะใน order_transport

//เริ่มต้นการเปลี่ยนสถานะใน product_refunds เป็นคืนสินค้าโรงงานแล้ว (returned)
$getProduct_waitchangeStatusRefund = getProduct_waitchangeStatusRefund($idfactory,$idshipment_period);
$i2 = 0;
foreach ($getProduct_waitchangeStatusRefund as $value) {
    $i2++;
    $val_name_product = $value['name_product'];
    $val_idproduct_refunds = $value['idproduct_refunds'];
    echo $val_name_product;
    $editStatus_returned = editStatus_returned($val_idproduct_refunds);
}
//สิ้นสุดการเปลี่ยนสถานะใน product_refunds

//getStatusShipment ที่ถูกอัพเดทไป
$getUpdateStatusShipmentByID = getUpdateStatusShipmentByID($idfactory, $idshipment_period);
$val_status_shipment = $getUpdateStatusShipmentByID['status_shipment'];
echo '<pre>';
echo $val_status_shipment;
echo '</pre>';

if ($page == 'shipment2') {
    if ($Payfactory > 0) {
        header("location: ../shipment2.php?idshipment_period=$idshipment_period&action=addPayfactoryCompleted");
    } else {
        header("location: ../shipment2.php?idshipment_period=$idshipment_period&action=addPayfactoryError");
    }
} elseif ($page == 'shipment3') {
    if ($Payfactory > 0) {
        header("location: ../add_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&price=$price_pay_factory&status_shipment=$val_status_shipment&action=addPayfactoryCompleted"); 
    } else {
        header("location: ../add_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&price=$price_pay_factory&status_shipment=$val_status_shipment&action=addPayfactoryError");
    }
} else {
    header("location: ../../index.php");
}



    