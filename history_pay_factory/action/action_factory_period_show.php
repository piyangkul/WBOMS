<?php
require_once '../function/func_history_pay_factory.php';
require_once '../../docket/function/func_docket.php';
?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables"> 
    <thead>
        <tr>
            <th><div align="center">โรงงาน</div></th>
<th><div align="center">วันที่จ่ายเงิน</div></th>
<th><div align="center">ยอดสั่งซื้อรวม</div></th>
<th><div align="center">ยอดสินค้าคืนรวม</div></th>
<th><div align="center">ยอดจ่ายเงินสุทธิ</div></th>
</tr>
</thead>
<tbody>
    <?php
    $idshipment_period = $_GET['idshipment_period'];
    $getPayFactoryByIDperiod = getPayFactoryByIDperiod($idshipment_period);
    $i = 0;
    foreach ($getPayFactoryByIDperiod as $value) {
        $i++;
        $val_idshipment_period = $value['idshipment_period'];
        $val_idfactory = $value['idfactory'];
        $val_name_factory = $value['name_factory'];
        $val_price_pay_factory = $value['price_pay_factory'];
        $val_price_product_refund_factory = $value['price_product_refund_factory'];
        $val_real_price_pay_factory = $value['real_price_pay_factory'];
        $val_date_pay_factory = $value['date_pay_factory'];
        if ($val_date_pay_factory == "") {
            $date_pay_factory = "-";
        } else {
            $date_pay_factory = date_create($val_date_pay_factory);
            $date_pay_factory->add(new DateInterval('P543Y0M0DT0H0M0S'));
            $date_pay_factory = date_format($date_pay_factory, 'd-m-Y');
        }
        ?>
        <tr>
            <td><?php echo $val_name_factory; ?></td>
            <td><?php echo $date_pay_factory; ?></td>
            <td class="text-right"><!-- ยอดสั่งซื้อ -->
                <?php if ($val_price_pay_factory != 0) { ?>
                    <?php echo "<a href='popup_price_payfactory.php?idshipment_period=$val_idshipment_period&idfactory=$val_idfactory' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_price_pay_factory, 2) . " </a>"; ?>
                    <?php
                } else {
                    echo number_format($val_price_pay_factory, 2);
                }
                ?>
            </td>
            <td class="text-right"><!-- สินค้าคืน-->
                <?php if ($val_price_product_refund_factory != 0) { ?>
                    <?php echo "<a href='popup_price_refund_payfactory.php?idshipment_period=$val_idshipment_period&idfactory=$val_idfactory&price_product_refund=$val_price_product_refund_factory' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_price_product_refund_factory, 2) . " </a>"; ?>
                    <?php
                } else {
                    echo number_format($val_price_product_refund_factory, 2);
                }
                ?>
            </td>
            <td class="text-right"><?php echo number_format($val_real_price_pay_factory, 2) ?></td><!-- ยอดเรียกเก็บสุทธิ -->
        </tr>
<?php } ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#dataTables').dataTable({"sort": false});
    });
</script>

