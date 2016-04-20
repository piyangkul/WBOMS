<?php

session_start();
require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idproduct = $_GET['q'];
    $idshop = $_SESSION['idshopP'];
    $row = hisDiff($idproduct, $idshop);
    $price_diff = $row['price_difference'];

    if (isset($price_diff)) {
        echo $price_diff;
    } else {
        $getDiffProduct = getDiffProduct($idproduct);
        $diffProduct = $getDiffProduct['difference_amount_product'];
        echo $diffProduct;
    }
}
?>
