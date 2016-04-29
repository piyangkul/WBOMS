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
    $total_price_all = $_GET['total_price_all'] + ($price * $AmountProduct);
    $diff = $_GET['diff'];
    $type_factory = $_GET['type_factory'];
    $idproduct = addProductRefunds($idorder, $idUnit, $AmountProduct, $price, $type_factory, $diff);

    $Edit = editTotal_order($idorder, $total_price_all);
    //header("location: ../edit_product_refunds.php");*/
    echo "1";
}
?>