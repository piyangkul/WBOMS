<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idproduct_order = $_GET['idproduct_order'];
$idname_factory = $_POST['name_factory'];
$idorder_p = $_POST['idorder_p'];
$date_order_p = $_POST['date_order_p'];
$name_shop = $_POST['name_shop'];

$checkEditProduct_order = editProduct_order($idproduct_order, $idname_factory, $idorder_p, $date_order_p, $name_shop);
if ($checkEditProduct_order) {
    header("location: ../shipment2.php?p=idproduct_order&action=editCompleted");
} else {
    header("location: ../shipment2.php?p=idproduct_order&action=editError");
}