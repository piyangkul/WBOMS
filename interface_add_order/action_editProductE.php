<?php

require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idProduct_order = $_GET['idproduct_order'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $difference = $_GET['difference'];
    $DifferencePer = $_GET['DifferencePer'];
    $DifferenceBath = $_GET['DifferenceBath'];
    $total_price = $_GET['total_price'];
    $total = $_GET['total'];
    // $type = $_GET['type'];
    $idproductE = EditProductOrder($idProduct_order, $idUnit, $AmountProduct, $DifferencePer, $total_price);

    /* echo "$DifferenceBATH";
      echo "$DifferencePer";
      echo "$type"; */
    echo "1";
}
?>