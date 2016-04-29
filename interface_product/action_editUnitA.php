<?php

require_once dirname(__FILE__) . '/function/func_product.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addUnit") {
    $idproduct = $_GET['idproduct'];
    // $idUnit = $_GET['idUnit'];
    $idUnitBig = $_GET['idUnitBig'];
    $unitName = $_GET['NameUnit'];
    $AmountPerUnit = $_GET['AmountPerUnit'];
    $price = $_GET['price'];
    $type = $_GET['type'];

    $idUnitEdit = EditUnitAdd($idproduct, $idUnitBig, $unitName, $price, $type, $AmountPerUnit);

    header("location: edit_product.php?idproduct=" + $idproduct);
    echo "1";
}
?>