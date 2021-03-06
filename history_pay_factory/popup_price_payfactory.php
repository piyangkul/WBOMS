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

$getPricePayFactory = getPricePayFactory($idfactory, $idshipment_period);
$val_price_pay_factory = $getPricePayFactory['price_pay_factory'];
$val_shipment_period_idshipment = $getPricePayFactory['shipment_period_idshipment'];
?>
﻿<form class="form" action="#" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดข้อมูลการสั่งซื้อ</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">

                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดสั่งซื้อรวม(สั่งซื้อ+ค่าขนส่ง)</b> <?php echo number_format($val_price_pay_factory, 2); ?> บาท</h4></center>
                </div>
                <div class = "row">
                    <!--<div class = "col-md-1 col-sm-1 "></div>-->
                    <div class = "col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>ตารางรายการสินค้าที่สั่งซื้อ</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                        <th rowspan="2"><div align="center">วันที่สั่ง</div></th>
                                        <th rowspan="2"><div align="center">ร้านค้า</div></th>
                                        <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                        <th rowspan="2"><div align="center">ราคาเปิดต่อหน่วย</div></th>
                                        <th rowspan="2"><div align="center">ต้นทุนลด%</div></th>
                                        <th rowspan="2"><div align="center">ราคาต้นทุน</div></th>
                                        <th rowspan="2"><div align="center">จำนวน</div></th>
                                        <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                        <th rowspan="2"><div align="center">รวม</div></th>
                                        </tr>
                                        <tr>
                                            <th><div align="center">วันที่ส่ง</div></th>
                                        <th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
                                        <th><div align="center">ค่าส่ง</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProductDetail_payFactory = getProductDetail_payFactory($idshipment_period, $idfactory);
                                            $i = 0;
                                            $n = 0;
                                            $sum_transport = 0;
                                            foreach ($getProductDetail_payFactory as $value) {
                                                $i++;
                                                $val_idorder_p = $value['idorder_p'];
                                                $val_idproduct = $value['idproduct'];
                                                $val_idproduct_order = $value['idproduct_order'];
                                                $val_idorder_transport = $value['idorder_transport'];
                                                $val_date_order_p = $value['date_order_p'];
                                                $date_order_p = date_create($val_date_order_p);
                                                $date_order_p->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                $val_name_shop = $value['name_shop'];
                                                $val_name_product = $value['name_product'];
                                                $val_price_unit = $value['price_unit'];
                                                $val_amount_product_order = $value['amount_product_order'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_difference_amount_product = $value['difference_amount_product'];
                                                $val_type_product_order = $value['type_product_order'];
                                                //$val_confirm_status_shipment = $value['status_shipment'];
                                                $val_idtransport = $value['idtransport'];

                                                $val_date_transport = $value['date_transport'];
                                                $date_transport = date_create($val_date_transport);
                                                $date_transport->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                if ($date_transport == NULL) {
                                                    $date_transport = "-";
                                                }
                                                $val_name_transport = $value['name_transport'];
                                                if ($val_name_transport == NULL) {
                                                    $val_name_transport = "-";
                                                }
                                                $val_volume = $value['volume'];
                                                if ($val_volume == NULL) {
                                                    $val_volume = "-";
                                                }
                                                $val_number = $value['number'];
                                                if ($val_number == NULL) {
                                                    $val_number = "-";
                                                }
                                                $val_price_transport = $value['price_transport'];
//                                                    if ($val_price_transport == NULL) {
//                                                        $val_price_transport = "-";
//                                                    }
                                                $cost = $val_price_unit - (($val_difference_amount_product / 100.0) * $val_price_unit);
                                                $total = $cost * $val_amount_product_order;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo date_format($date_order_p, 'd-m-Y'); ?></td>
                                                    <td><?php echo $val_name_shop; ?></td>
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td>
                                                    <?php if ($val_type_product_order == "PERCENT") { ?>
                                                        <td><?php echo number_format($val_difference_amount_product, 2) . "%"; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo "-"; ?></td>
                                                    <?php } ?>
                                                    <td class="text-right"><?php echo number_format($cost, 2); ?></td><!-- ราคาต้นทุน-->
                                                    <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>

                                                    <?php
                                                    $ShipmentDuplicate = getShipmentDuplicateByID($idfactory, $idshipment_period, $val_name_transport, $val_number, $val_volume);
                                                    if ($ShipmentDuplicate > 1) {//ถ้าการส่ง1ครั้ง มีหลายรายการสั่ง
                                                        if ($n == 0) {
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" >' . date_format($date_transport, 'd-m-Y') . '</td>';
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" >' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</td>';
                                                            echo "<td class='text-right' style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                                                            echo "<td class='text-right' style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" valign="middle">' . number_format($total * $ShipmentDuplicate, 2) . '</td>';
                                                        }
                                                        $n++;
                                                        if ($n == $ShipmentDuplicate) {
                                                            $n = 0;
                                                        }
                                                    } else {//ถ้าการส่ง1ครั้ง มี1รายการสั่ง
                                                        ?>
                                                        <td><?php echo date_format($date_transport, 'd-m-Y'); ?></td>
                                                        <td><?php
                                                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                                                            ?> </td>
                                                        <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>
                                                        <td class="text-right"><?php echo number_format($total, 2); ?></td>
                                                    <?php }
                                                    ?>

                                                    <?php $getPrice_transportByshipment_period = getPrice_transportByshipment_period($idshipment_period, $idfactory); ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php //$total_transport = $val_price_pay_factory - $sum_transport;    ?>
                                </div>
                                <div class="col-md-8 col-md-offset-8">ยอดเงินรวมสินค้าที่สั่งซื้อ &nbsp;&nbsp; <b><?php echo number_format($val_price_pay_factory - $getPrice_transportByshipment_period['sum_price_transport'], 2); ?></b> &nbsp;&nbsp; บาท </div>
                                <div class="col-md-8 col-md-offset-8">ยอดเงินรวมค่าขนส่ง &nbsp;&nbsp; <b><?php echo number_format($getPrice_transportByshipment_period['sum_price_transport'], 2); ?></b> &nbsp;&nbsp; บาท </div>
                                <div class="col-md-8 col-md-offset-8">ยอดเงินสั่งซื้อรวม(สั่งซื้อ+ค่าขนส่ง) &nbsp;&nbsp; <b><?php echo number_format($val_price_pay_factory, 2); ?></b> &nbsp;&nbsp; บาท </div>
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