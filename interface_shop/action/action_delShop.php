<?php

require_once dirname(__FILE__) . '/../function/func_shop.php';

$idshop = $_GET['idshop'];

$checkDel = delShop($idshop);
if ($checkDel) {
   header("location: ../membership.php?action=delCompleted");
} else {
   header("location: ../membership.php?action=delError");
}