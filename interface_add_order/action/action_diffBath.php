<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idunit = $_GET['q'];

$getidProduct = getProductdiffBath($idunit);
$idproduct = $getidProduct['idproduct'];
$amount = 1;

$getDiff = getDiffBathaction($idproduct, $idunit);
foreach ($getDiff as $value) {
    $val_amount_unit = $value['amount_unit'];
    $val_price = $value['price_unit'];
    $amount = $val_amount_unit * $amount;
}
echo $amount;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

