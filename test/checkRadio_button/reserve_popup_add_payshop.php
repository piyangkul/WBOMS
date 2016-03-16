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
    $price_pay = ($sum_order + $debt) - $price_product_refunds;
//    $getPayByID2 = getPayByID2($idshop, $idshipment_period);
//    $val_price_order_total = $getPayByID2['price_pay'];

    $Beforeid = getBeforeid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_before_idshipment_period = $Beforeid['idshipment_period'];

    $Nextid = getNextid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_next_idshipment_period = $Nextid['idshipment_period'];
    $val_next_date_end = $Nextid['date_end'];
    $date2 = str_replace('-', '/', $val_next_date_end);
    $endNextdate = date('Y-m-d', strtotime($date2 . "0 days"));
}
?>
<script>
    var data = JSON.stringify(<?php echo getBankShop(); ?>);//ดึงค่า
    var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
    var Arr = new Array();
    var Arr2 = new Array();
    //pushข้อมูลลงArray
    for (var i = 0; i < Obj.length; i++) {
        Arr.push(Obj[i].cheque_name_bank);
        Arr2.push(Obj[i].cheque_branch_bank);
    }
    $(function () {
        $("#cheque_name_bank").autocomplete({
            source: Arr
        });
    });
    $(function () {
        $("#cheque_branch_bank").autocomplete({
            source: Arr2
        });
    });
    $(function () {
        $("#cheque_name_bank2").autocomplete({
            source: Arr
        });
    });
    $(function () {
        $("#cheque_branch_bank2").autocomplete({
            source: Arr2
        });
    });
</script>
<h4 class="alert alert-danger" role="alert">1.เก็บได้ เก็บไม่ได้ </h4>
<form class="form" action="action/action_addPayshop.php?idshipment_period=<?php echo $idshipment_period; ?>&idshop=<?php echo $idshop; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มการเก็บเงินร้านค้า //วันที่จ่ายเช็คตั้งแต่วันที่ของปลายรอบนี้ถึงรอบถัดไป</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info">ร้าน : <?php echo $val_name_shop; ?> &nbsp; ที่อยู่ : <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินเรียกเก็บสุทธิ</b> <?php echo number_format($price_pay, 2); ?> บาท</h4></center>
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
                                    <table class="table table-striped table-bordered table-hover text-center ">
                                        <thead>
                                            <tr>
                                                <th><div align="center">ลำดับ</div></th>
                                        <th><div align="center">วันที่คืน</div></th>
                                        <th><div align="center">โรงงาน</div></th>
                                        <th><div align="center">ชื่อสินค้า</div></th>
                                        <th><div align="center">จำนวน</div></th> 
                                        <th><div align="center">ราคาคืน/หน่วย</div></th>
                                        <th><div align="center">ราคาคืน</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProductRefundByID = getProductRefundByID($idshop, $val_before_idshipment_period);
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
                                                    $cost2 = $val_price_unit - $val_price_difference;
                                                }
                                                $refund = $cost2 * $val_amount_product_refunds;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i2; ?></td>
                                                    <td><?php echo date_format($date_product_refunds, 'd-m-Y'); ?></td> 
                                                    <td><?php echo $val_name_factory; ?></td>  
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td>
                                                    <td class="text-right"><?php echo number_format($cost2, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($refund, 2); ?></td>
                                                    <?php $sum_refund = $sum_refund + $refund; ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div align="right">ราคาคืนรวม &nbsp;&nbsp; <b><?php echo number_format($sum_refund, 2); ?></b> &nbsp;&nbsp; บาท </div>  
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                $date = new DateTime('now', new DateTimeZone('Asia/Bangkok'));
                //echo $date->format('d-m-Y H:i:s');
                //$real_price_pay_factory = $price - $price_product_refund_factory; //สรุปยอดเงินที่จ่ายโรงงาน 
                ?>
                <div class="form-group col-xs-1"></div>
                <div class="form-group col-xs-5">
                    <!--ทำเพราะให้แอดค่าตัวเลขหลักพันลง-->
                    <input type="hidden" name="sum_order" value="<?= $sum_order ?>">
                    <input type="hidden" name="debt" value="<?= $debt ?>">
                    <input type="hidden" name="sum_refund" value="<?= $sum_refund ?>">
                    <input type="hidden" name="price_pay" id="price_pay" value="<?= $price_pay ?>">

                    <center><h4>ยอดเงินที่สั่งซื้อ <input type="text" class="form-control" value="<?php echo number_format($sum_order, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินหนี้ <input type="text" class="form-control" value="<?php echo number_format($debt, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินสินค้าคืนรวม <input type="text" class="form-control" value="<?php echo number_format($sum_refund, 2); ?>" readonly> </h4></center>
                    <center><h4 class="text text-danger">ยอดเงินเรียกเก็บสุทธิ <input type="text" class="form-control"  value="<?php echo number_format($price_pay, 2); ?>" readonly></h4></center>
                    <center><h4>วันที่จ่ายเงินโรงงาน <input type="date" class="form-control" id="date_pay_factory" name="date_pay_factory" value="<?php echo $date->format('Y-m-d'); ?>" required></h4></center>
                </div>

                <div class = "form-group col-md-4"></div>
                <div class = "form-group col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <label>ประเภทการเก็บเงิน </label>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#get">เก็บครบ</a></li>
                            <li><a data-toggle="tab" href="#lack">เก็บไม่ครบ</a></li>
                            <li><a data-toggle="tab" href="#unget">เก็บไม่ได้</a></li>                           
                        </ul>
                        <div class="tab-content">
                            <div id="get" class="tab-pane fade in active">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" onclick="chkCash_pay()" name="type_pay" id="cash" value="cash" checked> <label>เงินสด</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" onclick="chkCredit_pay()" name="type_pay" id="credit" value="credit" > <label>เช็ค</label>
                                                <input type="date" class="form-control" id="date_pay_credit" min="<?php echo $val_date_end; ?>" max="<?php echo $endNextdate; ?>" name="date_pay_credit" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>เลขที่เช็ค</label>
                                                <input type="text" onclick="chkCredit_pay()" class="form-control" id="cheque_number" name="cheque_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>ชื่อธนาคารของเช็ค</label>
                                                <input type="text" onclick="chkCredit_pay()" class="form-control" autocomplete=on id="cheque_name_bank" name="cheque_name_bank" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>สาขาธนาคารของเช็ค</label>
                                                <input type="text" onclick="chkCredit_pay()" class="form-control" autocomplete=on id="cheque_branch_bank" name="cheque_branch_bank" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="lack" class="tab-pane fade">
                                <div class="panel-body">
                                    <div class="table-responsive ">                                       
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" onclick="chkCash_pay2()" name="type_pay" id="cash" value="cash" checked> <label>เงินสด</label>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <input type="radio" onclick="chkCredit_pay2()" name="type_pay" id="credit" value="credit" > <label>เช็ค</label>
                                                <input type="date" class="form-control" id="date_pay_credit2" min="<?php echo $val_date_end; ?>" max="<?php echo $endNextdate; ?>" name="date_pay_credit" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>เลขที่เช็ค</label>
                                                <input type="text" onclick="chkCredit_pay2()" class="form-control" id="cheque_number2" name="cheque_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>ชื่อธนาคารของเช็ค</label>
                                                <input type="text" onclick="chkCredit_pay2()" class="form-control" autocomplete=on id="cheque_name_bank2" name="cheque_name_bank" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>สาขาธนาคารของเช็ค</label>
                                                <input type="text" onclick="chkCredit_pay2()" class="form-control" autocomplete=on id="cheque_branch_bank2" name="cheque_branch_bank" disabled>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>จำนวนเงินที่เก็บได้</label>
                                                <input type="text" class="form-control" id="getMoney" name="getMoney" onkeyup="Debt()" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46;'>
                                            </label>
                                        </div>
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>จำนวนเงินที่รอเก็บครั้งต่อไป(หนี้)</label>
                                                <input type="text" class="form-control" id="debt" name="debt" readonly>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="unget" class="tab-pane fade">
                                <div class="panel-body">
                                    <div class="table-responsive ">
                                        <div class="form-group input-group">
                                            <label class="radio-inline">
                                                <label>จำนวนเงินที่รอเก็บครั้งต่อไป(หนี้)</label>
                                                <input type="text" class="form-control" id="debt2" name="debt" value="<?php echo number_format($price_pay, 2); ?>" readonly>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="chkdateCredit()">Save changes</button>
    </div>
</form>
<script>
    function Debt() {
        var price_pay = document.getElementById("price_pay").value;
        var getMoney = document.getElementById("getMoney").value;
        var debt = price_pay - getMoney;
        //alert(debt);
        document.getElementById("debt").value = debt;
    }
    function chkCredit_pay() {
        document.getElementById("date_pay_credit").disabled = false;
        document.getElementById("cheque_number").disabled = false;
        document.getElementById("cheque_name_bank").disabled = false;
        document.getElementById("cheque_branch_bank").disabled = false;
    }
    function chkCash_pay() {
        document.getElementById("date_pay_credit").disabled = true;
        document.getElementById("cheque_number").disabled = true;
        document.getElementById("cheque_name_bank").disabled = true;
        document.getElementById("cheque_branch_bank").disabled = true;
        $("#date_pay_credit").val('');//ล้างค่า
        $("#cheque_number").val('');
        $("#cheque_name_bank").val('');
        $("#cheque_branch_bank").val('');
    }
    function chkCredit_pay2() {
        document.getElementById("date_pay_credit2").disabled = false;
        document.getElementById("cheque_number2").disabled = false;
        document.getElementById("cheque_name_bank2").disabled = false;
        document.getElementById("cheque_branch_bank2").disabled = false;
    }
    function chkCash_pay2() {
        document.getElementById("date_pay_credit2").disabled = true;
        document.getElementById("cheque_number2").disabled = true;
        document.getElementById("cheque_name_bank2").disabled = true;
        document.getElementById("cheque_branch_bank2").disabled = true;
        $("#date_pay_credit2").val('');//ล้างค่า
        $("#cheque_number2").val('');
        $("#cheque_name_bank2").val('');
        $("#cheque_branch_bank2").val('');
    }
    function chkdateCredit() {
        if ($('#credit').is(':checked')) {
            document.getElementById("date_pay_credit").required = true;
            // document.getElementById("cheque_number").required = true;
        } else {
            document.getElementById("date_pay_credit").required = false;
            // document.getElementById("cheque_number").required = false;
        }
    }

</script>