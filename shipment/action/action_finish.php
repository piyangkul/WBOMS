<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$price = $_GET['price'];
//ตรวจสอบค่าที่รับ
echo $idshipment_period;
echo $idfactory;
echo $price;

$getProduct_waitchangeStatus = getProduct_waitchangeStatus($idfactory,$idshipment_period);//เปลี่ยนสถานะรายการสินค้า
$i = 0;
foreach ($getProduct_waitchangeStatus as $value) {
    $i++;
    $val_name_product = $value['name_product'];
    $val_idorder_transport = $value['idorder_transport'];
    echo $val_name_product;
    $editStatus_finish = editStatus_finish($val_idorder_transport);
}
if ($editStatus_finish > 0) {
    header("location: ../shipment2.php?idshipment_period=$idshipment_period&idfactory=$idfactory&action=finishCompleted");
} else {
    header("location: ../shipment2.php?idshipment_period=$idshipment_period&idfactory=$idfactory&action=finishError");
}