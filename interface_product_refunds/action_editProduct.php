<?php

require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();
$z = 1;
if ($_GET['p'] == "addProduct") {
    $idorder = $_GET['idorder'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $total_price_all = $_GET['total_price_all'];
    $idproduct = addProductRefunds($idorder, $idUnit, $AmountProduct, $price);
    $Edit = editTotal_order($idorder, $total_price_all);
    header("location: ../edit_product_refunds.php");
    echo "1";
}
?>