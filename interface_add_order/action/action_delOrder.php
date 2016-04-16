<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idorder = $_GET['idorder'];
//echo $idproduct;
$chkDel = chkDelete($idorder);
$status = $chkDel['status_checktransport'];
if ($status ==='check'||$status==='postpose') {
    header("location: ../order.php?p=product&action=delError");
} else {
    $delProduct_Order = deleteProduct_Order($idorder);
    echo $delProduct_Order;
    if ($delProduct_Order) {
        $delOrder = deleteOrder($idorder);
        //echo "55";
        if ($delOrder) {
            header("location: ../order.php?p=product&action=delCompleted");
        } else {
            header("location: ../order.php?p=product&action=delError");
        }
    } else {
        header("location: ../order.php?p=product&action=delError");
    }
}

