<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idproduct_order = $_GET['idproduct_order'];
$idamount_product_order = $_POST['amount_product_order'];

$checkEdit_Amount_Product_order = editProduct_order($idproduct_order, $idamount_product_order);
if ($checkEdit_Amount_Product_order) {
    header("location: ../shipment2.php?p=idproduct_order&action=editCompleted");
} else {
    header("location: ../shipment2.php?p=idproduct_order&action=editError");
}