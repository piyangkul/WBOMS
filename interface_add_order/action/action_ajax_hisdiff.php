<?php

session_start();
require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idproduct = $_GET['q'];
    $idshop = $_SESSION['idshop'];
    $row = hisDiff($idproduct, $idshop);
    $price_diff = $row['price_difference'];
    echo $price_diff;
}
?>
