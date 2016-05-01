<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';

$idunitNew = $_GET['idunitNew'];
$idunitOld = $_GET['idunitOld'];
$idproduct = $_GET['idproduct'];

$amount = $_GET['amount'];
//$amountUnitNew = $amount;
if ($idunitOld < $idunitNew) {
    $getAmountNew = getUnitNew($idproduct, $idunitNew, $idunitOld);

    foreach ($getAmountNew as $value) {
        $val_amount_unit = $value['amount_unit'];
        $val_price = $value['price_unit'];
        $amount = $val_amount_unit * $amount;
    }
    echo $amount;
} elseif ($idunitOld > $idunitNew) {
    $getAmountNew = getUnitNewDESC($idproduct, $idunitOld, $idunitNew);

    foreach ($getAmountNew as $value) {
        $val_amount_unit = $value['amount_unit'];
        $val_price = $value['price_unit'];
        $amount = $amount / $val_amount_unit;
    }
    echo $amount;
} elseif ($idunitOld == $idunitNew) {
    echo $amount;
}
?>

