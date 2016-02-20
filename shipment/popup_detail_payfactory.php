<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idshipment_period'])and isset($_GET['idfactory'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $change_date_start = date("d-m-Y", strtotime($val_date_start));
    $val_date_end = $getShipment_period['date_end'];
    $change_date_end = date("d-m-Y", strtotime($val_date_end));

    $idfactory = $_GET['idfactory'];
    $getFactory = getFactoryByID($idfactory);
    $val_name_factory = $getFactory['name_factory'];
    //ยอดเงินที่โรงงานเรียกเก็บ
    $price = $_GET['price'];

    $page = $_GET['page'];

    $status_shipment_factory = $_GET['status_shipment'];

    $Nextid = getNextid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_next_idshipment_period = $Nextid['idshipment_period'];
    $val_next_date_end = $Nextid['date_end'];
    $date2 = str_replace('-', '/', $val_next_date_end);
    $endNextdate = date('Y-m-d', strtotime($date2 . "0 days"));
}
?>
<?php
//ยอดเงินสินค้าคืนรวม
$price_product_refund = 0;
?>
﻿<form class="form" action="#" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดการจ่ายเงินโรงงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo $change_date_start; ?> ถึง <?php echo $change_date_end; ?></h4></center>
                    <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินที่โรงงานเรียกเก็บ</b> <?php echo number_format($price, 2, '.', ''); ?> บาท</h4></center>
                </div>
                <div class = "row">
                    <div class = "col-md-1 col-sm-1 "></div>
                    <div class = "col-md-10 col-sm-10 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>รายการสินค้าคืน</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                        <th rowspan="2"><div align="center">ชื่อร้านค้า</div></th>
                                        <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                        <th rowspan="2"><div align="center">จำนวน</div></th>
                                        <th colspan="5"><div align="center">ราคา/หน่วย</div></th>
                                        <th colspan="3"><div align="center">ราคาทั้งหมด</div></th>
                                        </tr>

                                        <tr>
                                            <th><div align="center">ราคาเปิด</div></th>
                                        <th><div align="center">ต้นทุนลด</div></th>
                                        <th><div align="center">ราคาต้นทุน</div></th>
                                        <th><div align="center">คืนลด</div></th>
                                        <th><div align="center">ราคาคืน</div></th>
                                        <th><div align="center">ราคาเปิดรวม</div></th>
                                        <th><div align="center">ราคาต้นทุนรวม</div></th>
                                        <th><div align="center">ราคาคืนรวม</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProduct_refunds = getProduct_refunds($idfactory, $idshipment_period);
                                            $i = 0;
                                            foreach ($getProduct_refunds as $value) {
                                                $i++;
                                                $val_name_shop = $value['name_shop'];
                                                $val_name_product = $value['name_product'];
                                                $val_amount_product_refunds = $value['amount_product_refunds'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_price_unit = $value['price_unit'];
                                                //ต้นทุนลด
                                                if ($value['difference_amount_product'] == null) {
                                                    $val_difference_amount = $value['difference_amount_factory'];
                                                } else {
                                                    $val_difference_amount = $value['difference_amount_product'];
                                                }
                                                $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit); //ราคาต้นทุน
                                                $val_price_difference = $value['price_difference']; //ขายลด,คืนลด
                                                $type_money = $value['type_money']; //% หรือ BATH
                                                $val_price_product_refunds = $value['price_product_refunds']; //ราคาขาย,ราคาคืน
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $val_name_shop; ?></td>
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td><!-- จำนวน-->
                                                    <td class="text-right"><?php echo number_format($val_price_unit, 2, '.', ''); ?></td><!-- ราคาเปิด-->
                                                    <td><?php echo $val_difference_amount . "%"; ?></td><!-- ต้นทุนลด-->                                      
                                                    <td class="text-right"><?php echo number_format($cost, 2, '.', ''); ?></td><!-- ราคาต้นทุน-->
                                                    <td><?php echo $val_price_difference; ?><?php echo ($type_money == "PERCENT") ? "%" : "฿"; ?></td><!-- คืนลด -->
                                                    <td><?php echo number_format($val_price_product_refunds, 2, '.', ''); ?></td><!-- ราคาคืน-->
                                                    <td><?php echo number_format($val_price_unit * $val_amount_product_refunds, 2, '.', ''); ?></td>
                                                    <td><?php echo number_format($cost * $val_amount_product_refunds, 2, '.', ''); ?></td>
                                                    <td><?php echo number_format($val_price_product_refunds * $val_amount_product_refunds, 2, '.', ''); ?></td>
                                                    <?php $price_product_refund = $price_product_refund + $val_price_product_refunds * $val_amount_product_refunds; ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                $getPayFactory = getPayFactory($idfactory, $idshipment_period);
                $val_date_pay_factory = $getPayFactory['date_pay_factory'];
                $val_type_pay_factory = $getPayFactory['type_pay_factory'];
                if ($val_type_pay_factory == "cash") {
                    
                } else {
                    
                }
                $val_date_pay_factory_credit = $getPayFactory['date_pay_factory_credit'];
                //$date = new DateTime('now', new DateTimeZone('Asia/Bangkok'));
                //echo $date->format('d-m-Y H:i:s');
                $real_price_pay_factory = $price - $price_product_refund; //สรุปยอดเงินที่จ่ายโรงงาน 
                ?>
                <div class="form-group col-xs-1"></div>
                <div class="form-group col-xs-5">
                    <center><h4>ยอดเงินที่โรงงานเรียกเก็บ <input type="text" class="form-control" value="<?php echo number_format($price, 2, '.', ''); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินสินค้าคืนรวม <input type="text" class="form-control" name="price_product_refund" value="<?php echo number_format($price_product_refund, 2, '.', ''); ?>" readonly> </h4></center>
                    <center><h4 class="text text-danger">สรุปยอดเงินที่จ่ายโรงงาน <input type="text" class="form-control" name="real_price_pay_factory" value="<?php echo number_format($real_price_pay_factory, 2, '.', ''); ?>" readonly></h4></center>
                    <center><h4>วันที่จ่ายเงินโรงงาน <input type="date" class="form-control" id="date_pay_factory" name="date_pay_factory" value="<?php echo $val_date_pay_factory; ?>" readonly></h4></center>
                </div>

                <div class = "form-group col-md-4"></div>
                <div class = "form-group col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <label>ประเภทการจ่ายเงิน </label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <?php if ($val_type_pay_factory == "cash") { ?>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <input type="radio" onclick="chkCash_pay_factory()" name="type_pay_factory" id="cash" value="cash" checked disabled> <label>เงินสด</label>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <input type="radio" onclick="chkCredit_pay_factory()" name="type_pay_factory" id="credit" value="credit" disabled> <label>เช็ค</label>
                                            <input type="date" class="form-control" id="date_pay_factory_credit" name="date_pay_factory_credit" value="<?php echo $val_date_pay_factory_credit; ?>" disabled>
                                        </label>
                                    </div>
                                <?php } else { ?>
                                 <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <input type="radio" onclick="chkCash_pay_factory()" name="type_pay_factory" id="cash" value="cash" disabled> <label>เงินสด</label>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <input type="radio" onclick="chkCredit_pay_factory()" name="type_pay_factory" id="credit" value="credit" checked disabled> <label>เช็ค</label>
                                            <input type="date" class="form-control" id="date_pay_factory_credit" name="date_pay_factory_credit" value="<?php echo $val_date_pay_factory_credit; ?>" disabled>
                                        </label>
                                    </div>
                                <?php } ?>


                            </div>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="submit" class="btn btn-primary" onclick="chkdateCredit()">Save changes</button>-->
    </div>
</form>
<script>
    function chkCredit_pay_factory() {
        document.getElementById("date_pay_factory_credit").disabled = false;
    }
    function chkCash_pay_factory() {
        document.getElementById("date_pay_factory_credit").disabled = true;
        $("#date_pay_factory_credit").val('');

    }
    function chkdateCredit() {
        if ($('#credit').is(':checked')) {
            document.getElementById("date_pay_factory_credit").required = true;
        } else {
            document.getElementById("date_pay_factory_credit").required = false;
        }
    }

</script>
<!--<h4 class="alert alert-danger" role="alert">1.เปลี่ยนสถานะสินค้าคืนในproduct_refund</h4>-->