<?php
require_once 'function/func_history_pay_factory.php';
require_once '../shipment/function/func_shipment.php';
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$date_start = date_create($val_date_start);
$date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
$val_date_end = $getShipment_period['date_end'];
$date_end = date_create($val_date_end);
$date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));

$idfactory = $_GET['idfactory'];
$getFactory = getFactoryByID($idfactory);
$val_name_factory = $getFactory['name_factory'];

$price_product_refund = $_GET['price_product_refund'];
//$getPricePayFactory = getPricePayFactory($idfactory, $idshipment_period);
//$val_price_pay_factory = $getPricePayFactory['price_pay_factory'];
//$val_shipment_period_idshipment = $getPricePayFactory['shipment_period_idshipment'];
?>
<?php
//ยอดเงินสินค้าคืนรวม
$price_product_refund_factory = 0;
?>
﻿<form class="form" action="#" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดข้อมูลสินค้าคืน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">

                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินสินค้าคืนรวม</b> <?php echo number_format($price_product_refund, 2); ?> บาท</h4></center>
                </div>
                <div class = "row">
                    <!--<div class = "col-md-1 col-sm-1 "></div>-->
                    <div class = "col-md-12 col-sm-12 ">
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
                                        <th colspan="3"><div align="center">ราคา/หน่วย</div></th>
                                        <th colspan="2"><div align="center">ราคาทั้งหมด</div></th>
                                        </tr>

                                        <tr>
                                            <th><div align="center">ราคาเปิด</div></th>
                                        <th><div align="center">คืนลด</div></th>
                                        <th><div align="center">ราคาคืน</div></th>
<!--                                        <th><div align="center">คืนลด</div></th>
                                        <th><div align="center">ราคาคืน</div></th>-->
                                        <th><div align="center">ราคาเปิดรวม</div></th>
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
                                                $val_amount_product_refunds = $value['amount_product_refunds']; //จำนวนที่คืน
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
                                                $val_price_product_refunds = $value['price_product_refunds']; //ราคาคืนที่คูณจำนวนแล้ว
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $val_name_shop; ?></td>
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td><!-- จำนวน-->
                                                    <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td><!-- ราคาเปิด-->
                                                    
                                                    <?php if ($type_money == "PERCENT") { ?><!-- คืนนลด--> 
                                                        <td><?php echo number_format($val_difference_amount, 2) . "%"; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo "สุทธิ"; ?></td>
                                                    <?php } ?>  
                                                    
                                                    <td class="text-right"><?php echo number_format($cost, 2); ?></td><!-- ราคาคืน-->
    <!--                                                    <td><?php //echo number_format($val_price_difference, 2);  ?><?php //echo ($type_money == "PERCENT") ? "%" : "฿";  ?></td> คืนลด 
                                                    <td class="text-right"><?php //echo number_format($val_price_product_refunds, 2);  ?></td> ราคาคืนต่อหน่วย-->
                                                    <td class="text-right"><?php echo number_format($val_price_unit * $val_amount_product_refunds, 2); ?></td><!-- ราคาเปิดรวม-->
                                                    <td class="text-right"><?php echo number_format($val_amount_product_refunds * $cost, 2); ?></td><!-- ราคาคืนรวม-->
                                                    <?php $price_product_refund_factory = $price_product_refund_factory + ($val_amount_product_refunds * $cost); ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-8 col-md-offset-8">ยอดเงินสินค้าคืนรวม &nbsp;&nbsp; <b><?php echo number_format($price_product_refund_factory, 2); ?></b> &nbsp;&nbsp; บาท </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                $getPayFactory = getPayFactory($idfactory, $idshipment_period);
                $val_price_pay_factory = $getPayFactory['price_pay_factory'];
                $val_price_product_refund_factory = $getPayFactory['price_product_refund_factory'];
                $val_real_price_pay_factory = $getPayFactory['real_price_pay_factory'];
                $val_date_pay_factory = $getPayFactory['date_pay_factory'];
                $date_pay_factory = date_create($val_date_pay_factory);
                $date_pay_factory->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_type_pay_factory = $getPayFactory['type_pay_factory'];
                $val_date_pay_factory_credit = $getPayFactory['date_pay_factory_credit'];
                $date_pay_factory_credit = date_create($val_date_pay_factory_credit);
                $date_pay_factory_credit->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_cheque_number = $getPayFactory['cheque_number'];
                $val_cheque_name_bank = $getPayFactory['cheque_name_bank'];
                $val_cheque_branch_bank = $getPayFactory['cheque_branch_bank'];
                ?>
                <div class="form-group col-xs-1"></div>
                <div class="form-group col-xs-5">
                    <center><h4>วันที่จ่ายเงินโรงงาน <input type="date" class="form-control" id="date_pay_factory" name="date_pay_factory" value="<?php echo date_format($date_pay_factory, 'Y-m-d'); ?>" readonly></h4></center>
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
                                            <input type="date" class="form-control" id="date_pay_factory_credit" name="date_pay_factory_credit" value="<?php echo date_format($date_pay_factory_credit, 'Y-m-d'); ?>" disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>เลขที่เช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_number" value="<?php echo $val_cheque_number; ?>" name="cheque_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>ชื่อธนาคารของเช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_name_bank" value="<?php echo $val_cheque_name_bank; ?>" name="cheque_name_bank" disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>สาขาธนาคารของเช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_branch_bank" value="<?php echo $val_cheque_branch_bank; ?>" name="cheque_branch_bank" disabled>
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
                                            <input type="date" class="form-control" id="date_pay_factory_credit" name="date_pay_factory_credit" value="<?php echo date_format($date_pay_factory_credit, 'Y-m-d'); ?>" disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>เลขที่เช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_number" value="<?php echo $val_cheque_number; ?>" name="cheque_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>ชื่อธนาคารของเช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_name_bank" value="<?php echo $val_cheque_name_bank; ?>" name="cheque_name_bank" disabled>
                                        </label>
                                    </div>
                                    <div class="form-group input-group">
                                        <label class="radio-inline">
                                            <label>สาขาธนาคารของเช็ค</label>
                                            <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_branch_bank" value="<?php echo $val_cheque_branch_bank; ?>" name="cheque_branch_bank" disabled>
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