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
    $val_price_unit = number_format($value['price_unit'], 2);
    $val_type_product_order = $value['type_product_order'];
    $val_difference_amount = number_format($value['difference_amount_product'], 2);
    $val_difference_product_order = number_format($value['difference_product_order'], 2);
    $total_price_per = number_format(($val_price_unit - (($val_price_unit * $val_difference_product_order) / 100)) * $val_amount_unit, 2);
    $total_price_bath = number_format(($val_price_unit - $val_difference_product_order) * $val_amount_unit, 2);
    echo "<tr><td class ='text-center'>{$i}</td>";
    echo "<td class ='text-center'>{$val_date}</td>";
    echo "<td class ='text-center'>{$val_amount_unit} {$val_name_unit}</td>";
    echo "<td class ='text-right'>{$val_price_unit}</td>";
    if ($val_type_product_order === "PERCENT") {
        echo "<td class ='text-center'>{$val_difference_amount}%</td>";
        echo "<td class ='text-center'>{$val_difference_product_order}%</td>";
        echo "<td class ='text-right'>{$total_price_per} </td></tr>";
    } else {
        echo "<td class ='text-center'>-</td>";
        echo "<td class ='text-center'>{$val_difference_product_order} ฿</td>";
        echo "<td class ='text-right'>{$total_price_bath} </td></tr>";
    }
    $i++;
}