<?php

require_once dirname(__FILE__) . '/../function/func_product.php';
if ($_GET['q'] > 0) {
    $idunit = $_GET['q'];

    $row = ajax_priceUnit($idunit);
    $val_idunit = $row['idunit'];
    //$val_idfactory = $value['idfactory'];
    $val_price_unit = $row['price_unit'];
    echo $val_price_unit;
}
?>
