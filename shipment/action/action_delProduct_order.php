<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

$idproduct_order = $_GET['idproduct_order'];

$checkDelProduct_order = delProduct_order($idproduct_order);
if ($checkDelProduct_order) {
   header("location: ../shipment2.php?action=delCompleted");
} else {
   header("location: ../shipment2.php?action=delError");
}

//จะต้องรับ และ ส่ง factoryName และ monthly
//ไม่รู้ว่าทำไมลบไม่ผ่าน