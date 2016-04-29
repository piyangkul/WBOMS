<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

session_start();


echo "<pre>";
print_r($_POST);
//print_r($_SESSION);
echo "</pre>";
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add product มาหน้านี้ 
//$productCode = $_POST['productCode'];
$idorder = $_GET['idorder'];
$date_product_refunds = $_POST['date_order'];
$detail_product_refunds = $_POST['detail_order'];
$total_price_all = 0;

$total = str_replace(",","",$_POST['total_price_all']);
$total_price_all += $total;

//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
//$products = $_SESSION["editproductR"];

$editOrder = editOrderRefunds($idorder, $date_product_refunds, $detail_product_refunds,$total_price_all); //idproductของระบบ
header("location: ../product_refunds.php?p=product_refunds&action=editCompleted");
