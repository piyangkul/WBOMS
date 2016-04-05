<?php

require_once dirname(__FILE__) . '/../function/func_product.php';

session_start();
echo "<pre>";
print_r($_POST);
//print_r($_SESSION);
echo "</pre>";

$idproduct = $_GET['idproduct']; //รับพารามิเตอร์
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add product มาหน้านี้ 
$name_product = $_POST['productName'];
$idfactory = $_POST['factoryid'];
$detail_product = $_POST['porductDetail'];
$difference_amount_product = $_POST['difference_amount'];
$bigestPriceResult = $_POST['bigestPriceResult'];

$checkEditProduct = editProduct($idproduct, $idfactory, $name_product, $detail_product, $difference_amount_product);
if ($checkEditProduct) {
    header("location: ../product.php?action=editProductCompleted");
} else {
    header("location: ../product.php?action=editProductError");
}
?>