<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

$idproduct = $_GET['idproduct'];
$idshop = $_GET['idshop'];
$getTable = getTableProduct($idproduct, $idshop);

$i = 1;
foreach ($getTable as $value) {
    $val_date = $value['date_order_p'];
    $val_name_unit = $value['name_unit'];
    $val_amount_unit = $value['amount_product_order'];
    $val_price_unit = $value['price_unit'];
    $val_type_product_order = $value['type_product_order'];
    $val_difference_amount = $value['difference_amount_product'];
    $val_difference_product_order = $value['difference_product_order'];
    $total_price_per = ($val_price_unit - (($val_price_unit * $val_difference_product_order) / 100)) * $val_amount_unit;
    $total_price_bath = ($val_price_unit - $val_difference_product_order) * $val_amount_unit;
    echo "<tr><td class ='text-center'>{$i}</td>";
    echo "<td class ='text-center'>{$val_date}</td>";
    echo "<td class ='text-center'>{$val_amount_unit} {$val_name_unit}</td>";
    echo "<td class ='text-center'>{$val_price_unit}</td>";
    if ($val_type_product_order === "PERCENT") {
        echo "<td class ='text-center'>{$val_difference_amount}</td>";
        echo "<td class ='text-center'>{$val_difference_product_order} %</td>";
        echo "<td class ='text-center'>{$total_price_per} </td></tr>";
    } else {
        echo "<td class ='text-center'>-</td>";
        echo "<td class ='text-center'>{$val_difference_product_order}฿</td>";
        echo "<td class ='text-center'>{$total_price_bath} </td></tr>";
    }
    $i++;
}