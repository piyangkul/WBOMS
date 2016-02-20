<?php
require_once dirname(__FILE__) . '/../function/func_history_pay_factory.php';
?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
    <thead>
        <tr>
            <th><div align="center">วันที่เริ่มรอบ</div></th>
<th><div align="center">วันที่สิ้นสุดรอบ</div></th>
<th><div align="center">วันที่จ่ายเงิน</div></th>
<th><div align="center">ยอดเรียกเก็บ</div></th>
<th><div align="center">ยอดสินค้าคืนรวม</div></th>
<th><div align="center">ยอดจ่ายเงินสุทธิ</div></th>
</tr>
</thead>
<tbody>
    <?php
//    echo $getPayFactoryByID;
    $idfactory = $_GET['idfactory'];
    $getPayFactoryByID = getPayFactoryByID($idfactory);
//    echo "<pre>";
//    print_r($getPayFactoryByID);
//    echo "</pre>";
    $i = 0;
    foreach ($getPayFactoryByID as $value) {
        $i++;
        $val_date_start = $value['date_start'];
        $val_date_end = $value['date_end'];
        $val_date_pay_factory = $value['date_pay_factory'];
        $val_price_pay_factory = $value['price_pay_factory'];
        $val_price_product_refund = $value['price_product_refund'];
        $val_real_price_pay_factory = $value['real_price_pay_factory'];
        ?>
        <tr>
            <td><?php echo $val_date_start; ?></td>
            <td><?php echo $val_date_end; ?></td>
            <td><?php echo $val_date_pay_factory; ?></td>
            <td class="text-right"><?php echo number_format($val_price_pay_factory, 2, '.', ''); ?></td>
            <td class="text-right"><?php echo number_format($val_price_product_refund, 2, '.', '') ?></td>
            <td class="text-right"><?php echo number_format($val_real_price_pay_factory, 2, '.', '') ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>