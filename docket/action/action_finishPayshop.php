<?php

require_once dirname(__FILE__) . '/../function/func_docket.php';

echo '<pre>';
print_r($_POST);
print_r($_GET);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$idshop = $_GET['idshop'];
//echo $idshipment_period;
//echo $idshop;

$editStatus_finish_payShop = editStatus_finish_payShop($idshop, $idshipment_period);
if ($editStatus_finish_payShop) {
     header("location: ../docket.php?idshop=$idshop&action=finishPayshopCompleted");
} else {
     header("location: ../docket.php?idshop=$idshop&action=finishPayshopError");
}
