<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

$idproduct_order = $_GET['idproduct_order'];

$checkDelProduct_order = delProduct_order($idproduct_order);
if ($checkDelProduct_order) {
   header("location: ../shipment.php?action=delCompleted");
} else {
   header("location: ../shipment.php?action=delError");
}