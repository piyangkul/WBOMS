<?php

require_once dirname(__FILE__) . '/function/func_product.php';
session_start();

//session_destroy();
if ($_GET['p'] == "editUnit") {
    $idUnit = $_GET['idUnit'];
    $unitName = $_GET['NameUnit'];
    $AmountPerUnit = $_GET['AmountPerUnit'];
    $price = $_GET['price'];
    $type = $_GET['type'];
    $numUnit = $_GET['numUnit'];
    $idUnitSmall = $_GET['idUnitBig'];
    $getCalUnitBig = getCalUnitBig($idUnitSmall);
    $price_small = $getCalUnitBig['price_unit'];

    $idUnitEdit = EditUnitE($idUnit, $unitName, $AmountPerUnit, $price, $type);

    for ($x = 1; $x < $numUnit; $x++) {
        $getCalUnit = getCalUnit($idUnitSmall);
        $val_idUnitSmall = $getCalUnit['idunit'];
        $idUnitSmall = $val_idUnitSmall;
        $val_amount = $getCalUnit['amount_unit'];

        $cal = $price_small / $val_amount;
        $calEdit = EditCalUnit($idUnitSmall, $val_amount, $cal);
        /*  $getPrice = getCalUnit($idUnitSmall);
          $val_price = $getPrice['price_unit']; */
        $price_small = $cal;
    }
    echo "1";
}
?>