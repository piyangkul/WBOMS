<?php

require_once dirname(__FILE__) . '/../function/func_product.php';

$idproduct = $_GET['idproduct'];
//echo $idproduct;

$delUnit = deleteProductUnit($idproduct);
if ($delUnit) {
    $delProduct = deleteProduct($idproduct);
    if ($delProduct) {
//        echo "OK";
    header("location: ../product.php?p=product&action=delProductCompleted");
    } else {
//        echo "Error1";
    header("location: ../product.php?p=product&action=delProductError");
    }
} else {
//    echo "Error2";
    header("location: ../product.php?p=product&action=delProductdError");
}


