<?php

require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "editProduct") {
    $idproduct_refunds = $_GET['idproduct_refunds'];
    $idUnit = $_GET['idUnit'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price_all = $_GET['total_price_all'];
    $idorder = $_GET['idorder'];
    // $total_price = $_GET['total_price'];

    $idproductE = EditsProductRefunds($idproduct_refunds, $idUnit, $AmountProduct, $price);
    $Edit = editTotal_order($idorder, $total_price_all);
    echo "1";
}
