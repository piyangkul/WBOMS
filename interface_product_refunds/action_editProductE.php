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
    $diff = $_GET['diff'];
    $idProduct = $_GET['idproduct'];
    $amount = 1;
    $idunit = $products[$i]['idUnit'];
    $getDiff = getDiffBathaction($idProduct, $idUnit);
    foreach ($getDiff as $value) {
        $val_amount_unit = $value['amount_unit'];
        $val_price = $value['price_unit'];
        $amount = $val_amount_unit * $amount;
    }



    $idproductE = EditsProductRefunds($idproduct_refunds, $idUnit, $AmountProduct, $price, $diff / $amount);
    $Edit = editTotal_order($idorder, $total_price_all);
    echo "1";
}
