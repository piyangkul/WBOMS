<?php
require_once dirname(__FILE__) . '/../function/func_shipment.php';
$idfactory = $_GET['idfactory'];
$date_transport = $_GET['date_transport'];
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover text-center " id="dataTables">
        <thead>
            <tr>
                <th  valign="middle"><div align="center">เลือก</div></th>
        <th><div align="center">วันที่สั่ง</div></th>
        <th><div align="center">ร้านค้า</div></th>
        <th><div align="center">ชื่อสินค้า</div></th>
        <th><div align="center">ราคาเปิดต่อหน่วย</div></th>
        <th><div align="center">จำนวน</div></th>
        </tr>
        </thead>
        <tbody>
            <?php
            //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
            $getShipmentsByID = getProduct_order_shipmentByID($idfactory);
            $i = 0;
            foreach ($getShipmentsByID as $value) {
                $i++;
                $val_idproduct_order = $value['idproduct_order'];
                $val_date_order_p = $value['date_order_p'];
                $date_order_p = date_create($val_date_order_p);
                $date_order_p->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_name_shop = $value['name_shop'];
                $val_name_product = $value['name_product'];
                $val_price_unit = $value['price_unit'];
                $val_amount_product_order = $value['amount_product_order'];
                $val_name_unit = $value['name_unit'];
                ?>
                <tr>

                    <?php if ($date_transport >= $val_date_order_p) { ?>
                        <td><input type="checkbox" name="check_shipment[]" id="check_shipment_<?php echo $i; ?>" value="<?php echo $val_idproduct_order; ?>" onclick="chkCount('<?php echo $i; ?>')"></td>
                    <?php } else { ?>
                        <td><input type="checkbox" name="check_shipment[]" id="check_shipment_<?php echo $i; ?>" value="<?php echo $val_idproduct_order; ?>" onclick="chkCount('<?php echo $i; ?>')" disabled></td>
                        <?php } ?>
                    <td><?php echo date_format($date_order_p, 'd-m-Y'); ?></td>
                    <td><?php echo $val_name_shop; ?></td>
                    <td><?php echo $val_name_product; ?></td>
                    <td><?php echo $val_price_unit; ?></td>
                    <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                </tr>
            <?php } ?> 
        </tbody>
    </table>
</div>
<!--<script>
    $(document).ready(function () {
        $('#dataTables').dataTable({"sort": false});
    });
</script>-->