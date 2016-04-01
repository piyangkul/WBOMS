<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idorder = $_GET['idorder'];
//echo $idproduct;

$delProduct_Order = deleteOrderProduct_Refunds($idorder);
echo $delProduct_Order;
if ($delProduct_Order) {
    $delOrder = deleteOrder($idorder);
    //echo "55";
    if ($delOrder) {
        header("location: ../product_refunds.php?p=product&action=delCompleted");
    } else {
        header("location: ../product_refunds.php?p=product&action=delCompleted");
        //echo"Error1";
        // header("location: ../order.php?p=product&action=delError");
    }
} else {
    header("location: ../product_refunds.php?p=product&action=delCompleted");
    //echo "Error2";
    // header("location: ../order.php?p=product&action=delError");
}


