<?php
require_once dirname(__FILE__) . '/../function/func_discount_shop.php';
?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
    <thead>
        <tr>
            <th><div align="center">ลำดับ</div></th>
<th><div align="center">รหัสร้านค้า</div></th>
<th><div align="center">ร้านค้า</div></th>
<th><div align="center">ขายลด</div></th>
<th><div align="center">ราคาขาย</div></th>
<th><div align="center">วันที่อัพเดทล่าสุด</div></th>
</tr>
</thead>
<tbody>
    <?php
    $idproduct = $_GET['idproduct'];
    $getDiscountByID = getDiscountByID($idproduct);
//    print_r($getDiscountByID);
//    echo $idproduct;
    $i = 0;
    foreach ($getDiscountByID as $value) {
        $i++;
        $val_shop_code = $value['shop_code'];
        $val_name_shop = $value['name_shop'];
        $val_price_difference = $value['price_difference']; //ขายลด
        $val_type_money = $value['type_money'];
        $val_price_unit = $value['price_unit']; //ราคาเปิด
        if ($value['type_money'] == "PERCENT") {
            $cost = $val_price_unit - (($val_price_difference / 100.0) * $val_price_unit);
        } else {
            $cost = $val_price_unit - $val_price_difference;
        }
        $val_date_difference = $value['date_difference'];
//        $change_date_difference = date("d-m-Y", strtotime($val_date_difference));
        $date_difference = date_create($val_date_difference);
        $date_difference->add(new DateInterval('P543Y0M0DT0H0M0S'));
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $val_shop_code; ?></td>
            <td><?php echo $val_name_shop; ?></td>
            <td><?php echo $val_price_difference; ?><?php echo ($val_type_money == "PERCENT") ? "%" : "฿"; ?></td>
            <td class="text-right"><?php echo number_format($cost, 2); ?></td>
            <td><?php echo date_format($date_difference, 'd-m-Y'); ?></td>
        </tr>
    <?php } ?> 
</tbody>
</table>

<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>