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

    $Nextid = getNextid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_next_idshipment_period = $Nextid['idshipment_period'];
    $val_next_date_end = $Nextid['date_end'];
    $date2 = str_replace('-', '/', $val_next_date_end);
    $endNextdate = date('Y-m-d', strtotime($date2 . "0 days"));
    
    $getPayDetailByID_before_idshipment_period = getPayDetailByID($idshop, $val_before_idshipment_period);
    $val_debt_before_shipment = $getPayDetailByID_before_idshipment_period['debt']; //ยอดค้างชำระ(รอบที่แล้ว)
    $price_pay = ($sum_order + $val_debt_before_shipment) - $price_product_refunds;
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
<form class="form" onsubmit="return validateMyForm();" action="action/action_addPayshop.php?idshipment_period=<?php echo $idshipment_period; ?>&idshop=<?php echo $idshop; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มการเก็บเงินร้านค้า //วันที่จ่ายเช็คตั้งแต่วันที่ของปลายรอบนี้ถึงรอบถัดไป</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>ร้าน : </b><?php echo $val_name_shop; ?> &nbsp; <b>ที่อยู่ : </b> <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินเรียกเก็บสุทธิ</b> <?php echo number_format($val_debt_before_shipment + $sum_order - $price_product_refunds, 2); ?> บาท</h4></center>
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
                                <div class="text-danger" align="right">ราคาคืนรวม &nbsp;&nbsp; <b><?php echo number_format($sum_refund, 2); ?></b> &nbsp;&nbsp; บาท </div>  
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
                    <input type="hidden" name="sum_refund" value="<?= $sum_refund ?>">
                    <input type="hidden" name="price_pay" id="price_pay" value="<?= $price_pay ?>">

                    <center><h4>ยอดเงินที่สั่งซื้อ <input type="text" class="form-control" value="<?php echo number_format($sum_order, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดค้างชำระ(จากรอบที่แล้ว) <input type="text" class="form-control" value="<?php echo number_format($val_debt_before_shipment, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินสินค้าคืนรวม <input type="text" class="form-control" value="<?php echo number_format($sum_refund, 2); ?>" readonly> </h4></center>
                    <center><h4 class="text text-danger">ยอดเงินเรียกเก็บสุทธิ <input type="text" class="form-control"  value="<?php echo number_format($price_pay, 2); ?>" readonly></h4></center>
                    <center><h4>วันที่จ่ายเงินร้านค้า <input type="date" class="form-control" id="date_pay" name="date_pay" value="<?php echo $date->format('Y-m-d'); ?>" required></h4></center>
                </div>

                <div class = "form-group col-md-4"></div>
                <div class = "form-group col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <label>ประเภทการเก็บเงิน </label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <div class="form-group alert alert-success text-center">
                                    <label class="text-primary">เลือก &nbsp; : &nbsp;&nbsp; </label>
                                    <label class="radio-inline">
                                        <input type="radio"  name="status_pay" id="select_get" value="get" required> <label>เก็บครบ</label>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status_pay" id="select_lack" value="lack"> <label>เก็บไม่ครบ</label>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status_pay" id="select_unget" value="unget"> <label>เก็บไม่ได้</label>
                                    </label>
                                </div>
                            </div>
                            <!--show_get-->
                            <div class="table-responsive" id="show_get" style="display:none;">
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCash_pay()" name="type_pay_get" id="cash_get" value="cash"> <label>เงินสด</label>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCredit_pay()" name="type_pay_get" id="credit_get" value="credit" > <label>เช็ค</label>
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
                            <!--show_lack-->
                            <div class="table-responsive" id="show_lack" style="display:none;">
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCash_pay2()" name="type_pay_lack" id="cash_lack" value="cash"> <label>เงินสด</label>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCredit_pay2()" name="type_pay_lack" id="credit_lack" value="credit" > <label>เช็ค</label>
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
                                        <input type="text" class="form-control" id="getMoney" name="getMoney" onkeyup="Debt()" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46 && event.target <= $price_pay;'>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <label>ยอดหนี้(รอเก็บครั้งต่อไป)</label>
                                        <input type="text" class="form-control" id="debt_lack" readonly>
                                        <!-- hidden เก็บเข้าdb --> <input type="hidden" id="debt_lack_hidden" name="debt_lack" readonly>
                                    </label>
                                </div>
                            </div>
                            <!--show_unget-->
                            <div class="table-responsive" id="show_unget" style="display:none;">
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <label>ยอดหนี้(รอเก็บครั้งต่อไป)</label>
                                        <input type="text" class="form-control"  value="<?php echo number_format($price_pay, 2); ?>" readonly>
                                        <input type="hidden" id="debt_unget_send"  value="<?php echo $price_pay; ?>" readonly> <!-- hidden เปลี่ยนString เป็นdouble ส่งเข้าjavaScript--> 
                                        <!-- hidden เก็บเข้าdb --> <input type="hidden" id="debt_unget_receive" name="debt_unget" readonly> 
                                    </label>
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
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#select_get").click(function () {
            $("#show_get").css("display", "block");
            $("#show_lack").css("display", "none");
            $("#show_unget").css("display", "none");
            document.getElementById("date_pay_credit2").disabled = true;
            document.getElementById("cheque_number2").disabled = true;
            document.getElementById("cheque_name_bank2").disabled = true;
            document.getElementById("cheque_branch_bank2").disabled = true;
            $("#date_pay_credit2").val('');//ล้างค่า
            $("#cheque_number2").val('');
            $("#cheque_name_bank2").val('');
            $("#cheque_branch_bank2").val('');
            $("#cash_lack").prop("checked", false);//ล้างค่าปุ่มเงินสดกับเช็ค
            $("#credit_lack").prop("checked", false);
            $("#getMoney").val('');//ล้างค่าเงินที่เก็บได้
            $("#debt_lack").val('');
            $("#debt_lack_hidden").val('');
            //required ปุ่มเงินสด เช็ค
            document.getElementById("cash_get").required = true;

            document.getElementById("cash_lack").required = false;
            document.getElementById("credit_lack").required = false;
            document.getElementById("getMoney").required = false;

//            document.getElementById("credit_get").required = true;
        });
        $("#select_lack").click(function () {
            $("#show_get").css("display", "none");
            $("#show_lack").css("display", "block");
            $("#show_unget").css("display", "none");
            document.getElementById("date_pay_credit").disabled = true;
            document.getElementById("cheque_number").disabled = true;
            document.getElementById("cheque_name_bank").disabled = true;
            document.getElementById("cheque_branch_bank").disabled = true;
            $("#date_pay_credit").val('');//ล้างค่า
            $("#cheque_number").val('');
            $("#cheque_name_bank").val('');
            $("#cheque_branch_bank").val('');
            $("#cash_get").prop("checked", false);//ล้างค่าปุ่มเงินสดกับเช็ค
            $("#credit_get").prop("checked", false);
            //required ปุ่มเงินสด เช็ค
            document.getElementById("cash_lack").required = true;
            //reqire ช่องเงินที่เก็บได้
            document.getElementById("getMoney").required = true;

            document.getElementById("cash_get").required = false;
            document.getElementById("credit_get").required = false;

        });
        $("#select_unget").click(function () {
            $("#show_get").css("display", "none");
            $("#show_lack").css("display", "none");
            $("#show_unget").css("display", "block");
            document.getElementById("date_pay_credit").disabled = true;
            document.getElementById("cheque_number").disabled = true;
            document.getElementById("cheque_name_bank").disabled = true;
            document.getElementById("cheque_branch_bank").disabled = true;
            $("#date_pay_credit").val('');//ล้างค่า
            $("#cheque_number").val('');
            $("#cheque_name_bank").val('');
            $("#cheque_branch_bank").val('');
            $("#cash_get").prop("checked", false);//ล้างค่าปุ่มเงินสดกับเช็ค
            $("#credit_get").prop("checked", false);

            document.getElementById("date_pay_credit2").disabled = true;
            document.getElementById("cheque_number2").disabled = true;
            document.getElementById("cheque_name_bank2").disabled = true;
            document.getElementById("cheque_branch_bank2").disabled = true;
            $("#date_pay_credit2").val('');//ล้างค่า
            $("#cheque_number2").val('');
            $("#cheque_name_bank2").val('');
            $("#cheque_branch_bank2").val('');
            $("#cash_lack").prop("checked", false);//ล้างค่าปุ่มเงินสดกับเช็ค
            $("#credit_lack").prop("checked", false);

            $("#getMoney").val('');//ล้างค่าเงินที่เก็บได้
            $("#debt_lack").val('');
            $("#debt_lack_hidden").val('');

            var debt_unget_send = document.getElementById("debt_unget_send").value; //ส่งค่าให้input เมื่อมีการกด เก็บไม่ได้
            //alert(debt_unget_send);
            document.getElementById("debt_unget_receive").value = debt_unget_send;

            document.getElementById("cash_get").required = false;
            document.getElementById("credit_get").required = false;
            document.getElementById("cash_lack").required = false;
            document.getElementById("credit_lack").required = false;
            document.getElementById("getMoney").required = false;
        });
        $("#credit_get").click(function () {
            document.getElementById("date_pay_credit").required = true;
            document.getElementById("cheque_number").required = true;
            document.getElementById("cheque_name_bank").required = true;
            document.getElementById("cheque_branch_bank").required = true;
        });
        $("#credit_lack").click(function () {
            document.getElementById("date_pay_credit2").required = true;
            document.getElementById("cheque_number2").required = true;
            document.getElementById("cheque_name_bank2").required = true;
            document.getElementById("cheque_branch_bank2").required = true;
            document.getElementById("getMoney").required = true;
        });

    });

    function Debt() {
        var price_pay = document.getElementById("price_pay").value;
        var getMoney = document.getElementById("getMoney").value;
        var debt = price_pay - getMoney;
        //alert(debt);
        document.getElementById("debt_lack_hidden").value = debt;
        debt = debt.toFixed(2).replace(/./g, function (c, i, a) {
            return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
        });
        document.getElementById("debt_lack").value = debt;

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

//        if ($('#credit_get').is(':checked')) {
//            document.getElementById("date_pay_credit").required = true;
//            document.getElementById("cheque_number").required = true;
//            document.getElementById("cheque_name_bank").required = true;
//            document.getElementById("cheque_branch_bank").required = true;
//        } else {
//            document.getElementById("date_pay_credit").required = false;
//        }
//        if ($('#credit_lack').is(':checked')) {
//            document.getElementById("date_pay_credit2").required = true;
//            document.getElementById("cheque_number2").required = true;
//            document.getElementById("cheque_name_bank2").required = true;
//            document.getElementById("cheque_branch_bank2").required = true;
//            document.getElementById("getMoney").required = true;
//        } else {
//            document.getElementById("date_pay_credit2").required = false;
//            // document.getElementById("cheque_number").required = false;
//        }
//        
    }

</script>

<script type="text/javascript">
    function validateMyForm()
    {
        var getMoney = Number(document.getElementById("getMoney").value);
        var price_pay = Number(document.getElementById("price_pay").value);

        if (getMoney > price_pay)
        {
            getMoney = getMoney.toFixed(2).replace(/./g, function (c, i, a) {
                return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
            });

            price_pay = price_pay.toFixed(2).replace(/./g, function (c, i, a) {
                return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
            });
            alert("คุณใส่ จำนวนเงินที่เก็บได้ " + getMoney + " มากกว่า ยอดเงินเรียกเก็บสุทธิ " + price_pay);
            return false;
        }
        //alert("validations passed");
        return true;
        
    }
</script>
<!--<h4 class="alert alert-danger" role="alert">1.จำนวนเงินที่เก็บได้//เช็คค่าไม่เกินยอดเงินเรียกเก็บสุทธิ </h4>-->