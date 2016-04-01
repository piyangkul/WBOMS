<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';
$nameshop = $_GET['q'];
$row = getShop2($nameshop);
foreach ($row as $value) {
    $val_name_shop = $value['name_shop'];
    //$val_price = $value['price_unit'];

    echo $val_name;
}
?>