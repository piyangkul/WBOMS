<?php

require_once 'function/func_addorder.php';
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
    $price = $_GET['price'];
    $total = $_GET['total'];
    $type = $_GET['type'];
    $date_order = date("Y-m-d");
    $getIdOrder = getEdit_Order($idProduct_order);
    $idshop = $getIdOrder['idshop'];

    echo $type . $idshop;

    $amount = 1;
    $getDiff = getDiffBathaction($productName, $idUnit);
    foreach ($getDiff as $value) {
        $val_amount_unit = $value['amount_unit'];
        $val_price = $value['price_unit'];
        $amount = $val_amount_unit * $amount;
    }



    if ($type === "PERCENT") {
        $idproductE = EditProductOrder($idProduct_order, $idUnit, $AmountProduct, $DifferencePer, $price);
        $getproduct = getIDProduct($idUnit);
        $idproduct2 = $getproduct['idproduct'];
        $delDiff = deleteDifference($idproduct2, $idshop);
        $addDiff = addDiff_edit($idproduct2, $idshop, $type, $DifferencePer, $date_order);
        echo $idshop;
    } elseif ($type === "BATH") {
        $idproductE = EditProductOrder($idProduct_order, $idUnit, $AmountProduct, $DifferenceBath / $amount, $price);
        $getproduct = getIDProduct($idUnit);
        $idproduct2 = $getproduct['idproduct'];
        $delDiff = deleteDifference($idproduct2, $idshop);
        $addDiff = addDiff_edit($idproduct2, $idshop, $type, $DifferenceBath, $date_order);
    }
    /* echo "$DifferenceBATH";
      echo "$DifferencePer";
      echo "$type"; */
    echo "1";
}
?>