<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idorder_transport = $_GET['idorder_transport'];

$idshipment_period = $_GET['idshipment_period'];
//$getShipment_period = getShipment_periodByID($idshipment_period);
//$val_date_start = $getShipment_period['date_start'];
//$change_date_start = date("d-m-Y", strtotime($val_date_start));
//$val_date_end = $getShipment_period['date_end'];
//$change_date_end = date("d-m-Y", strtotime($val_date_end));

$idfactory = $_GET['idfactory'];
//$getFactory = getFactoryByID($idfactory);
//$val_name_factory = $getFactory['name_factory'];

$status_shipment_factory = $_GET['status_shipment'];
$price_pay_factory = $_GET['price_pay_factory'];

$check_shipment = isset($_POST['check_shipment']) ? $_POST['check_shipment'] : NULL; //ค่าที่ติ๊ก
$check_shipment_hidden = $_POST['check_shipment_hidden']; //ยังใช้ไม่ได้ ต้องไปทำarray_diffก่อน
$date_transport = $_POST['date_transport'];
$idtransport = $_POST['idtransport'];
$volume = $_POST['volume'];
$number = $_POST['number'];
$price_transport = $_POST['price_transport'];

//หาarrayที่ไม่ติ๊ก idproduct_order_hidden
$idproduct_order_hidden = ($check_shipment != NULL) ? array_diff($check_shipment_hidden, $check_shipment) : $check_shipment_hidden;

echo '<pre>';
print_r($check_shipment);
echo "check";
echo '</pre>';

echo '<pre>';
print_r($idproduct_order_hidden);
echo "uncheck";
echo '</pre>';

if ($idproduct_order_hidden != NULL) {
//***หมายเหตุ $value คือ $idproduct_order_hidden รายการสินค้าที่จะกระทำการต่างๆ
//  รายการสินค้าที่ติ๊กออก --> มันเป็นการลบข้อมูลการขนส่ง และเปลี่ยนสถานะ product order จาก check(ส่งแล้ว)เป็นuncheck(ยังไม่ส่ง) 
    foreach ($idproduct_order_hidden as $value) {
        echo $value; //idproduct_order
        $editChange_statusUncheckByID = editChange_statusUncheck($value); //ผ่าน
        $checkDelShipment = delShipment($value); //ผ่าน
    }
}
if ($check_shipment != NULL) {
//***หมายเหตุ $value คือ $check_shipment คือ $idproduct_order รายการสินค้าที่จะกระทำการต่างๆ
// รายการสินค้าที่ยังติ๊กอยู่ แล้วแก้ไขข้อมูลการส่ง --> ให้ทำการ update ข้อมูล 
    foreach ($check_shipment as $value) {
        echo $value;
        $checkEditShipment = editShipment($value, $idtransport, $date_transport, $volume, $number, $price_transport);
    }
}

if ($editChange_statusUncheckByID > 0) {
    $status1 = "complete";
    echo "รายการสินค้าที่ติ๊กออก complete";
} else if ($idproduct_order_hidden == NULL) {
    $status1 = "complete";
    echo "//ไม่มีค่าส่งมา ถือว่าเป็นจริง";
} else {
    $status1 = "error";
    echo "รายการสินค้าที่ติ๊กออก error//คิวeditChange_statusUncheckรี่ผิด";
}
if ($checkEditShipment > 0) {
    $status2 = "complete";
    echo "รายการสินค้าที่ยังติ๊กอยู่ complete";
} else if ($check_shipment == NULL) {
    $status1 = "complete";
    echo "//ไม่มีค่าส่งมา ถือว่าเป็นจริง";
} else {
    $status2 = "error";
    echo "รายการสินค้าที่ยังติ๊กอยู่ error//คิวรี่editShipmentผิด";
}
if ($status1 == "complete" || $status2 == "complete") {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price_pay_factory . "&status_shipment=" . $status_shipment_factory . "&action=EditShipmentCompleted");
} else {//ทั้งแก้ไขและลบไม่ได้
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price_pay_factory . "&status_shipment=" . $status_shipment_factory . "&action=EditShipmentError");
}

//if ($status1 == "complete" && $status2 == "complete") {
//    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $val_price . "&action=EditShipmentCompleted");
//} elseif ($status1 == "complete" && $status2 == "error") {//แก้ไขรายการที่ติ๊กไม่ได้
//    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $val_price . "&action=EditShipmentError(Edit)");
//} elseif ($status1 == "error" && $status2 == "complete") {//ลบค่ารายการขนส่งไม่ได้
//    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $val_price . "&action=EditShipmentError(Del)");
//} else {//ทั้งแก้ไขและลบไม่ได้
//    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $val_price . "&action=EditShipmentError(All)");
//}
