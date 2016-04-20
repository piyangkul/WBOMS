<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idorder_product_refunds = $_GET['idorder'];
//echo $idproduct;
$chkDel = chkDelete($idorder_product_refunds);
$status = $chkDel['status_product_refund'];
echo $status;
if ($status === 'returned') {
    header("location: ../product_refunds.php?p=product&action=delErrorStatus");
} else {
    $delProduct_refunds = deleteProduct_Refunds_Order($idorder_product_refunds);

    $delOrder = deleteOrderProduct_Refunds($idorder_product_refunds);
    if ($delOrder) {
        header("location: ../product_refunds.php?p=product_refunds&action=delCompleted");
    } else {
        header("location: ../product_refunds.php?p=product_refunds&action=delCompleted");
        echo"Error1";
        header("location: ../product_refunds.php?p=product_refunds&action=delError");
    }
} 


