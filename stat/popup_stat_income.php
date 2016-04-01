<?php
require_once 'function/func_stat.php';
//require_once '../docket/function/func_docket.php';
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
?>
<form class="form" action="" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ตารางข้อมูลการเก็บเงินร้านค้าแยกตามรอบ </h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>

                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
                    <thead>
                        <tr>
                            <th><div align="center">ลำดับ</div></th>
                    <th><div align="center">รหัสร้านค้า</div></th>
                    <th><div align="center">ชื่อร้านค้า</div></th>
                    <th><div align="center">ยอดเงินที่สั่งซื้อ</div></th>
                    <th><div align="center">ยอดเงินสินค้าคืน</div></th><!-- จากorder product refund-->
                    <th><div align="center">ยอดเงินเก็บเงินสุทธิ</div></th><!--ยอดเก็บเงินสุทธิ-->
                    <th><div align="center">ยอดเงินที่เก็บได้(รายได้)</div></th>
                    <th><div align="center">ยอดหนี้</div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getIncomeBYidshipment = getIncomeBYidshipment($idshipment_period);
                        $i = 0;
                        $sum_income = 0;
                        foreach ($getIncomeBYidshipment as $value) {
                            $i++;
                            $shop_idshop = $value['shop_idshop'];
                            $shop_code = $value['shop_code'];
                            $val_name_shop = $value['name_shop'];
                            $val_price_order_total = $value['price_order_total'];
                            $val_price_order_refund = $value['price_order_refund'];
                            $val_price_pay = $value['price_pay'];
                            $val_income = $value['income'];
                            $val_debt = $value['debt'];
                            $sum_income = $sum_income + $val_income;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $shop_code; ?></td>
                                <td><?php echo $val_name_shop; ?></td>
                                <td class="text-right"><!-- ยอดเงินที่สั่งซื้อ -->
                                    <?php echo number_format($val_price_order_total, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดเงินสินค้าคืน-->
                                    <?php echo number_format($val_price_order_refund, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดเงินเก็บเงินสุทธิ -->
                                    <?php echo number_format($val_price_pay, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดเงินที่เก็บได้ -->
                                    <?php echo number_format($val_income, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดหนี้ -->
                                    <?php echo number_format($val_debt, 2); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="text-danger" align="right">รายได้รวม &nbsp;&nbsp; <b><?php echo number_format($sum_income, 2); ?></b> &nbsp;&nbsp; บาท </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
<!--<div class="alert alert-danger" role="alert">ยังไม่ได้แก้ sql </div>-->