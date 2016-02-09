<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idorder = $_GET['idorder'];
//echo $idproduct;

$delProduct_Order = deleteProduct_Order($idorder);
echo $delProduct_Order;
if ($delProduct_Order) {
    $delOrder = deleteOrder($idorder);
    //echo "55";
    if ($delOrder) {
        header("location: ../order.php?p=product&action=delCompleted");
    } else {
        //echo"Error1";
        // header("location: ../order.php?p=product&action=delError");
    }
} else {
    //echo "Error2";
    // header("location: ../order.php?p=product&action=delError");
}


