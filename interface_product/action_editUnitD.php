<?php

require_once dirname(__FILE__) . '/function/func_product.php';
session_start();

$idUnit = $_GET['idunit'];
$get_countUnit = GetcountProductOrder($idUnit);
$countUnit = $get_countUnit['countUnit'];

if ($countUnit >= 1) {
    echo "2";
} else {
    $delUnit = deleteUnit($idUnit);
    echo "1";
}
