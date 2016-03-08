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
        $val_shipment_period_idshipment = $value['shipment_period_idshipment'];
        $val_date_start = $value['date_start'];
        $val_date_end = $value['date_end'];
        $val_date_pay_factory = $value['date_pay_factory'];
        $val_price_pay_factory = $value['price_pay_factory'];
        $val_price_product_refund_factory = $value['price_product_refund_factory'];
        $val_real_price_pay_factory = $value['real_price_pay_factory'];
        ?>
        <tr>
            <td><?php echo $val_date_start; ?></td>
            <td><?php echo $val_date_end; ?></td>
            <td><?php echo $val_date_pay_factory; ?></td>
            <td class="text-right">
                <?php echo "<a href='popup_price_payfactory.php?idshipment_period=$val_shipment_period_idshipment&idfactory=$idfactory' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_price_pay_factory, 2) . " </a>"; ?>
            </td>
            <td class="text-right">
                <?php echo "<a href='popup_price_refund_payfactory.php?idshipment_period=$val_shipment_period_idshipment&idfactory=$idfactory&price_product_refund=$val_price_product_refund_factory' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_price_product_refund_factory, 2) . " </a>"; ?>
            </td>
            <td class="text-right"><?php echo number_format($val_real_price_pay_factory, 2) ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
<script>
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal-lg').removeData('bs.modal');
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<div class="modal fade" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content -->
        </div>
    </div>
</div>