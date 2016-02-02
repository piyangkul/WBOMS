<?php

require_once dirname(__FILE__) . '/../function/func_discount_shop.php';

$idproduct = $_GET['idproduct'];

$getCostProductByID = getCostProductByID($idproduct);
//print_r($getCostProductByID);

//echo $getCostProductByID['difference_amount_factory'];
?>
<table class="table table-striped table-bordered table-hover text-center">
    <thead>
        <tr>
            <th><div align="center">จำนวน</div></th>
<th><div align="center">ราคาเปิด</div></th>
<th><div align="center">ต้นทุนลด</div></th>
<th><div align="center">ราคาต้นทุน</div></th>
</tr>
</thead>
<tbody>
    <?php
//    echo $getCostProductByID;
        $val_name = $getCostProductByID['name'];
        $val_price_unit = $getCostProductByID['price_unit'];
        if ($getCostProductByID['difference_amount_product'] == null) {
            $val_difference_amount = $getCostProductByID['difference_amount_factory'];
        } else {
            $val_difference_amount = $getCostProductByID['difference_amount_product'];
        }
        $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit);
        ?>
        <tr>
            <td>1<?php echo $val_name; ?></td>
            <td class="text-right"><?php echo number_format($val_price_unit, 2, '.', ''); ?></td>
            <td><?php echo $val_difference_amount . "%"; ?></td>
            <td class="text-right"><?php echo number_format($cost, 2, '.', '') ?></td>
        </tr>

</tbody>
</table>
