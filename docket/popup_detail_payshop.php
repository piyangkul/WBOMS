<?php
require_once '../shipment/function/func_shipment.php';
require_once 'function/func_docket.php';
require_once '../interface_shop/function/func_shop.php';
?>
<?php
if (isset($_GET['idshipment_period'])and isset($_GET['idshop'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $date_start = date_create($val_date_start);
    $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
    $change_date_start = date("d-m-Y", strtotime($val_date_start));
    $val_date_end = $getShipment_period['date_end'];
    $date_end = date_create($val_date_end);
    $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
    $change_date_end = date("d-m-Y", strtotime($val_date_end));

    $idshop = $_GET['idshop'];
    $getShop = getShopByID($idshop);
    $val_name_shop = $getShop['name_shop'];
    $val_name_region = $getShop['name_region'];
    $val_name_province = $getShop['name_province'];
    $val_tel_shop = $getShop['tel_shop'];
    if ($val_tel_shop == NULL) {
        $val_tel_shop = "-";
    }

    $sum_order = $_GET['sum_order'];
    $debt = $_GET['debt'];
    $price_product_refunds = $_GET['price_product_refunds'];

//    $getPayByID2 = getPayByID2($idshop, $idshipment_period);
//    $val_price_order_total = $getPayByID2['price_pay'];

    $Beforeid = getBeforeid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_before_idshipment_period = $Beforeid['idshipment_period'];

    $getPayDetailByID = getPayDetailByID($idshop, $idshipment_period);
    $val_price_pay = $getPayDetailByID['price_pay'];
    $val_price_order_total = $getPayDetailByID['price_order_total'];
    $val_price_order_refund = $getPayDetailByID['price_order_refund'];
    $val_debt = $getPayDetailByID['debt'];
    $val_date_pay = $getPayDetailByID['date_pay'];
    $date_pay = date_create($val_date_pay);
    $date_pay->add(new DateInterval('P543Y0M0DT0H0M0S'));

    $val_date_pay_credit = $getPayDetailByID['date_pay_credit'];
    $date_pay_credit = date_create($val_date_pay_credit);
    $date_pay_credit->add(new DateInterval('P543Y0M0DT0H0M0S'));

    $val_type_pay = $getPayDetailByID['type_pay'];
    $val_status_pay = $getPayDetailByID['status_pay'];
    $val_cheque_number = $getPayDetailByID['cheque_number'];
    $val_cheque_name_bank = $getPayDetailByID['cheque_name_bank'];
    $val_cheque_branch_bank = $getPayDetailByID['cheque_branch_bank'];
    $val_status_due = $getPayDetailByID['status_due'];
    if ($val_status_due == "on") {
        $val_status_due = "เช็คจ่ายตรงเวลา";
    } else {
        $val_status_due = "เช็คจ่ายเกินเวลา";
    }

    $getPayDetailByID_before_idshipment_period = getPayDetailByID($idshop, $val_before_idshipment_period);
    $val_debt_before_shipment = $getPayDetailByID_before_idshipment_period['debt']; //ยอดค้างชำระ(รอบที่แล้ว)
    $price_pay = ($sum_order + $val_debt_before_shipment) - $price_product_refunds;
}
?>
<form class="form" action="#" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดการเก็บเงินร้านค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>ร้าน : </b> <?php echo $val_name_shop; ?> &nbsp; <b> ที่อยู่ : </b><?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?> &nbsp; &nbsp;<b>เบอร์โทรศัพท์ : </b><?php echo $val_tel_shop; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินเรียกเก็บสุทธิ</b> <?php echo number_format($price_pay, 2); ?> บาท</h4></center>
                </div>
                <div class = "row">
                    <div class = "col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>รายการสินค้าคืน</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center ">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                        <th rowspan="2"><div align="center">วันที่คืน</div></th>
                                        <th rowspan="2"><div align="center">โรงงาน</div></th>
                                        <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                        <th rowspan="2"><div align="center">จำนวน</div></th> 
                                        <th colspan="3"><div align="center">ราคาคืน/หน่วย</div></th>
                                        <th colspan="2"><div align="center">ราคาคืน</div></th>
                                        </tr>
                                        <tr>
                                            <th><div align="center">ราคาเปิด</div></th>
                                        <th><div align="center">คืนลด</div></th>
                                        <th><div align="center">ราคาคืน</div></th>
                                        <th><div align="center">ราคาเปิดรวม</div></th>
                                        <th><div align="center">ราคาคืนรวม</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProductRefundByID = getProductRefundByID($idshop, $idshipment_period);
                                            $i2 = 0;
                                            $refund = 0;
                                            $sum_refund = 0;
                                            foreach ($getProductRefundByID as $value) {
                                                $i2++;
                                                $val_idfactory = $value['idfactory'];
                                                $val_name_factory = $value['name_factory'];
                                                $val_name_product = $value['name_product'];
                                                $val_price_unit = $value['price_unit'];
                                                $val_amount_product_refunds = $value['amount_product_refunds'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_date_product_refunds = $value['date_product_refunds'];
                                                $date_product_refunds = date_create($val_date_product_refunds);
                                                $date_product_refunds->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                $val_price_difference = $value['price_difference']; //ขายลด
                                                $val_type_money = $value['type_money'];
                                                if ($value['type_money'] == "PERCENT") {
                                                    $cost2 = $val_price_unit - (($val_price_difference / 100.0) * $val_price_unit);
                                                } else {
                                                    $cost2 = $val_price_unit + $val_price_difference;
                                                }
                                                $refund = $cost2 * $val_amount_product_refunds;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i2; ?></td>
                                                    <td><?php echo date_format($date_product_refunds, 'd-m-Y'); ?></td> 
                                                    <td><?php echo $val_name_factory; ?></td>  
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td>
                                                    <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td><!-- ราคาเปิด -->
                                                    <?php if ($val_type_money == "PERCENT") { ?>
                                                        <td><?php echo number_format($val_price_difference, 2) . "%"; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo number_format($val_price_difference, 2) . "฿"; ?></td>
                                                    <?php } ?>
                                                    <td class="text-right"><?php echo number_format($cost2, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($val_price_unit * $val_amount_product_refunds, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($refund, 2); ?></td>
                                                    <?php $sum_refund = $sum_refund + $refund; ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-danger" align="right">ราคาคืนรวม &nbsp;&nbsp; <b><?php echo number_format($sum_refund, 2); ?></b> &nbsp;&nbsp; บาท </div>  
                            </div>
                        </div>
                    </div>
                </div>               
                <div class="form-group col-xs-1"></div>
                <div class="form-group col-xs-5">
                    <center><h4>ยอดเงินที่สั่งซื้อ <input type="text" class="form-control" value="<?php echo number_format($sum_order, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดค้างชำระ(จากรอบที่แล้ว) <input type="text" class="form-control" value="<?php echo number_format($val_debt_before_shipment, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินสินค้าคืนรวม <input type="text" class="form-control" value="<?php echo number_format($sum_refund, 2); ?>" readonly> </h4></center>
                    <center><h4 class="text text-danger">ยอดเงินเรียกเก็บสุทธิ <input type="text" class="form-control"  value="<?php echo number_format($price_pay, 2); ?>" readonly></h4></center>
                    <center><h4>วันที่จ่ายเงินร้านค้า <input type="date" class="form-control" id="date_pay" name="date_pay" value="<?php echo $date_pay->format('Y-m-d'); ?>" readonly></h4></center>
                </div>
                <div class = "form-group col-md-4"></div>
                <div class = "form-group col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <label>ประเภทการเก็บเงิน </label>
                        </div>
                        <div class="panel-body">
                            <?php if ($val_status_pay == "get") { ?>
                                <!--show_get-->
                                <div class="table-responsive ">
                                    <div class="form-group alert alert-success text-center">
                                        <!--<label class="text-primary">เลือก &nbsp; : &nbsp;&nbsp; </label>-->
                                        <label class="radio-inline">
                                            <input type="radio"  name="status_pay" id="select_get" value="get" checked disabled> <label>เก็บครบ</label>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status_pay" id="select_lack" value="lack" disabled> <label>เก็บไม่ครบ</label>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status_pay" id="select_unget" value="unget" disabled> <label>เก็บไม่ได้</label>
                                        </label>
                                    </div>
                                </div>
                                <?php if ($val_type_pay == "cash") { ?>
                                    <div class="table-responsive" id="show_get">
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio"  name="type_pay_get" id="cash_get" value="cash" checked disabled> <label>เงินสด</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="type_pay_get" id="credit_get" value="credit" disabled> <label>เช็ค</label>

                                            </label>
                                        </div>
                                    <?php } elseif ($val_type_pay == "credit") { ?>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="type_pay_get" id="cash_get" value="cash" disabled> <label>เงินสด</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="type_pay_get" id="credit_get" value="credit" checked disabled> <label>เช็ค</label>
                                                <input type="date" class="form-control" id="date_pay_credit" name="date_pay_credit" value="<?php echo $date_pay_credit->format('Y-m-d'); ?>" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>เลขที่เช็ค</label>
                                                <input type="text" class="form-control" id="cheque_number" name="cheque_number" value="<?php echo $val_cheque_number; ?>" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>ชื่อธนาคารของเช็ค</label>
                                                <input type="text" class="form-control" id="cheque_name_bank" name="cheque_name_bank" value="<?php echo $val_cheque_name_bank; ?>" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>สาขาธนาคารของเช็ค</label>
                                                <input type="text" class="form-control" id="cheque_branch_bank" name="cheque_branch_bank" value="<?php echo $val_cheque_branch_bank; ?>" disabled>
                                            </label>
                                        </div>
                                        <?php if ($val_status_due == "เช็คจ่ายตรงเวลา") { ?>
                                            <div class="form-group alert alert-success text-center text-danger">
                                                <h4><?php echo $val_status_due; ?> </h4>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group alert alert-danger text-center text-danger">
                                                <h4><?php echo $val_status_due; ?> </h4>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($val_status_pay == "lack") { ?>
                                <!--show_lack-->
                                <div class="table-responsive ">
                                    <div class="form-group alert alert-success text-center">
                                        <!--<label class="text-primary">เลือก &nbsp; : &nbsp;&nbsp; </label>-->
                                        <label class="radio-inline">
                                            <input type="radio"  name="status_pay" id="select_get" value="get" disabled> <label>เก็บครบ</label>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status_pay" id="select_lack" value="lack" checked disabled> <label>เก็บไม่ครบ</label>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status_pay" id="select_unget" value="unget" disabled> <label>เก็บไม่ได้</label>
                                        </label>
                                    </div>
                                </div>
                                <?php if ($val_type_pay == "cash") { ?>
                                    <div class="table-responsive" id="show_lack">
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="type_pay_lack" id="cash_lack" value="cash" checked disabled> <label>เงินสด</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="type_pay_lack" id="credit_lack" value="credit" disabled> <label>เช็ค</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>จำนวนเงินที่เก็บได้</label>
                                                <input type="text" class="form-control" id="getMoney" name="getMoney" value="<?php echo number_format($val_price_pay - $val_debt, 2); ?>" disabled>
                                            </label>
                                        </div>
                                    <?php } elseif ($val_type_pay == "credit") { ?>
                                        <div class="table-responsive" >
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="type_pay_lack" id="cash_lack" value="cash" disabled> <label>เงินสด</label>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="type_pay_lack" id="credit_lack" value="credit" checked disabled> <label>เช็ค</label>
                                                    <input type="date" class="form-control" id="date_pay_credit2" name="date_pay_credit" value="<?php echo $date_pay_credit->format('Y-m-d'); ?>" disabled>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <label>เลขที่เช็ค</label>
                                                    <input type="text" class="form-control" id="cheque_number2" value="<?php echo $val_cheque_number; ?>" name="cheque_number" disabled>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <label>ชื่อธนาคารของเช็ค</label>
                                                    <input type="text" class="form-control" id="cheque_name_bank2" value="<?php echo $val_cheque_name_bank; ?>" name="cheque_name_bank" disabled>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <label>สาขาธนาคารของเช็ค</label>
                                                    <input type="text" class="form-control" id="cheque_branch_bank2" value="<?php echo $val_cheque_branch_bank; ?>" name="cheque_branch_bank" disabled>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <label>จำนวนเงินที่เก็บได้</label>
                                                    <input type="text" class="form-control" id="getMoney" name="getMoney" value="<?php echo number_format($val_price_pay - $val_debt, 2); ?>" disabled>
                                                </label>
                                            </div>
                                            <div class="form-group input-group">
                                                <label class="radio-inline">
                                                    <label>ยอดหนี้(รอเก็บครั้งต่อไป)</label>
                                                    <input type="text" class="form-control" id="debt_lack" value="<?php echo number_format($val_debt, 2); ?>" disabled>
                                                </label>
                                            </div>
                                            <?php if ($val_status_due == "เช็คจ่ายตรงเวลา") { ?>
                                                <div class="form-group alert alert-success text-center text-danger">
                                                    <h4><?php echo $val_status_due; ?> </h4>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group alert alert-danger text-center text-danger">
                                                    <h4><?php echo $val_status_due; ?> </h4>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($val_status_pay == "unget") { ?>
                                    <!--show_unget-->
                                    <div class="table-responsive">
                                        <div class="form-group alert alert-success text-center">
                                            <!--<label class="text-primary">เลือก &nbsp; : &nbsp;&nbsp; </label>-->
                                            <label class="radio-inline">
                                                <input type="radio"  name="status_pay" id="select_get" value="get" disabled> <label>เก็บครบ</label>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status_pay" id="select_lack" value="lack" disabled> <label>เก็บไม่ครบ</label>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status_pay" id="select_unget" value="unget" checked disabled> <label>เก็บไม่ได้</label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="show_unget">
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>ยอดหนี้(รอเก็บครั้งต่อไป)</label>
                                                <input type="text" class="form-control"  value="<?php echo number_format($val_debt, 2); ?>" readonly>
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
</form>