<?php

require_once dirname(__FILE__) . '/../function/func_docket.php';

echo '<pre>';
print_r($_POST);
print_r($_GET);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$idshop = $_GET['idshop'];
//กลุ่มhidden
$price_order_total = $_POST['sum_order']; //ยอดเงินที่สั่งซื้อ
$price_order_refund = $_POST['sum_refund']; //ยอดเงินสินค้าคืนรวม
$price_pay = $_POST['price_pay']; //ยอดเงินเรียกเก็บสุทธิ
//ประเภทการจ่ายเงิน
$date_pay = $_POST['date_pay']; //วันที่จ่ายเงิน
$type_pay_get = $_POST['type_pay_get']; //ประเภทการจ่ายเงิน
$type_pay_lack = $_POST['type_pay_lack'];
if ($type_pay_get != NULL){
    $type_pay = $type_pay_get;
}  else {
    $type_pay = $type_pay_lack;
}
$date_pay_credit = $_POST['date_pay_credit']; //วันที่เช็ค
$cheque_number = $_POST['cheque_number'];
$cheque_name_bank = $_POST['cheque_name_bank'];
$cheque_branch_bank = $_POST['cheque_branch_bank'];
$status_pay = $_POST['status_pay'];

$debt_lack = $_POST['debt_lack']; //ยอดเงินหนี้
$debt_unget = $_POST['debt_unget'];
if ($debt_lack != NULL) {
    $debt = $debt_lack;
} else {
    $debt = $debt_unget;
}

$status_process = "add";

$Payshop = addPayshop($idshop, $idshipment_period, $price_order_total, $debt, $price_order_refund, $price_pay, $date_pay, $type_pay, $date_pay_credit, $status_pay, $cheque_number, $cheque_name_bank, $cheque_branch_bank, $status_process);
if ($Payshop > 0) {
    header("location: ../docket.php?idshop=$idshop&action=addPayshopCompleted");
} else {
    header("location: ../docket.php?idshop=$idshop&action=addPayshopError");
}