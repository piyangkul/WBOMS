<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idshipment_period'])and isset($_GET['idfactory'])) {
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
//ยอดเงินสินค้าคืนรวมแยกตามโรงงาน
$price_product_refund_factory = 0;
?>
<script>
    var data_bank = JSON.stringify(<?php echo getNamebank(); ?>);//ดึงค่า
    var Obj_bank = JSON.parse(data_bank);//Objตามจำนวนข้อมูล   
    var Arr_bank = new Array();
     //pushข้อมูลลงArray
    for (var i = 0; i < Obj_bank.length; i++) {
        Arr_bank.push(Obj_bank[i].cheque_name_bank + "");
        console.log(Arr_bank);
    }
    $(function () {
        $("#cheque_name_bank").autocomplete({
            source: Arr_bank
        });
    });
    
    var data_branch = JSON.stringify(<?php echo getBranchbank(); ?>);//ดึงค่า
    var Obj_branch = JSON.parse(data_branch);//Objตามจำนวนข้อมูล 
    var Arr_branch = new Array();
    //pushข้อมูลลงArray
    for (var i2 = 0; i2 < Obj_branch.length; i2++) {
        Arr_branch.push(Obj_branch[i2].cheque_branch_bank + "");
        console.log(Arr_branch);
    }
    $(function () {
        $("#cheque_branch_bank").autocomplete({
            source: Arr_branch
        });
    });
</script>
<form class="form" action="action/action_addPayfactory.php?page=<?php echo $page; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มการจ่ายเงินโรงงาน</h4>
    </div>
    <div class="row">
        <!--<div class="alert alert-danger" role="alert">1.เช็คราคาสุทธิ </div>-->
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดสั่งซื้อรวม(สั่งซื้อ+ค่าขนส่ง)</b> <?php echo number_format($price, 2); ?> บาท</h4></center>
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
                                        <th><div align="center">คืนลด%</div></th>
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
                                                $val_price_product_refunds = $value['price_product_refunds']; //ราคาคืน/หน่วย
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $val_name_shop; ?></td>
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td><!-- จำนวน-->
                                                    <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td><!-- ราคาเปิด-->
                                                        
                                                        <?php if ($type_money == "PERCENT") { ?><!-- คืนลด%--> 
                                                        <td><?php echo number_format($val_difference_amount, 2) . "%"; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo "-"; ?></td>
                                                    <?php } ?>
                                                        
                                                    <td class="text-right"><?php echo number_format($cost, 2); ?></td><!-- ราคาคืน-->
    <!--                                                    <td><?php //echo number_format($val_price_difference, 2);   ?><?php //echo ($type_money == "PERCENT") ? "%" : "฿";   ?></td> คืนลด 
                                                    <td class="text-right"><?php //echo number_format($val_price_product_refunds, 2);   ?></td> ราคาคืนต่อหน่วย-->
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
                $date = new DateTime('now', new DateTimeZone('Asia/Bangkok'));
                //echo $date->format('d-m-Y H:i:s');
                $real_price_pay_factory = $price - $price_product_refund_factory; //สรุปยอดเงินที่จ่ายโรงงาน 
                ?>
                <div class="form-group col-xs-1"></div>
                <div class="form-group col-xs-5">
                    <!--ทำเพราะให้แอดค่าตัวเลขหลักพันลง-->
                    <input type="hidden" name="price_pay_factory" value="<?= $price ?>">
                    <input type="hidden" name="price_product_refund_factory" value="<?= $price_product_refund_factory ?>">
                    <input type="hidden" name="real_price_pay_factory" value="<?= $real_price_pay_factory ?>">

                    <center><h4>ยอดสั่งซื้อรวม(สั่งซื้อ+ค่าขนส่ง) <input type="text" class="form-control" value="<?php echo number_format($price, 2); ?>" readonly> </h4></center>
                    <center><h4>ยอดเงินสินค้าคืนรวม <input type="text" class="form-control" value="<?php echo number_format($price_product_refund_factory, 2); ?>" readonly> </h4></center>
                    <center><h4 class="text text-danger">สรุปยอดเงินที่จ่ายโรงงาน <input type="text" class="form-control" value="<?php echo number_format($real_price_pay_factory, 2); ?>" readonly></h4></center>
                    <center><h4>วันที่จ่ายเงินโรงงาน <input type="date" class="form-control" id="date_pay_factory" name="date_pay_factory" value="<?php echo $date->format('Y-m-d'); ?>" required></h4></center>
                </div>

                <div class = "form-group col-md-4"></div>
                <div class = "form-group col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <label>ประเภทการจ่ายเงิน </label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCash_pay_factory()" name="type_pay_factory" id="cash" value="cash" checked> <label>เงินสด</label>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <input type="radio" onclick="chkCredit_pay_factory()" name="type_pay_factory" id="credit" value="credit" > <label>เช็ค</label>
                                        <input type="date" class="form-control" id="date_pay_factory_credit" min="<?php echo $val_date_end; ?>" max="<?php echo $endNextdate; ?>" name="date_pay_factory_credit" disabled>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <label>เลขที่เช็ค</label>
                                        <input type="text" onclick="chkCredit_pay_factory()" class="form-control" id="cheque_number" name="cheque_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' disabled>
                                    </label>
                                </div>
                                <div class="form-group input-group ui-front">
                                    <label class="radio-inline">
                                        <label>ชื่อธนาคารของเช็ค</label>
                                        <input type="text" onclick="chkCredit_pay_factory()" class="form-control" autocomplete=on id="cheque_name_bank" name="cheque_name_bank" disabled>
                                    </label>
                                </div>
                                <div class="form-group input-group">
                                    <label class="radio-inline">
                                        <label>สาขาธนาคารของเช็ค</label>
                                        <input type="text" onclick="chkCredit_pay_factory()" class="form-control" autocomplete=on id="cheque_branch_bank" name="cheque_branch_bank" disabled>
                                    </label>
                                </div>
                            </div>
                            <label class="text-danger">* วันที่จ่ายเช็ค </label>
                            <label class="text-danger">เริ่มตั้งแต่วันที่สิ้นสุดของรอบนี้ ถึงวันที่สิ้นสุดรอบถัดไป</label> 
                            <label class="text-danger">แต่ถ้าไม่มีรอบถัดไประบบจะบังคับให้เป็นวันที่ปัจจุบัน(วันนี้)</label>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="chkdateCredit()">Save changes</button>
    </div>
</form>
<script>
    function chkCredit_pay_factory() {
        document.getElementById("date_pay_factory_credit").disabled = false;
        document.getElementById("cheque_number").disabled = false;
        document.getElementById("cheque_name_bank").disabled = false;
        document.getElementById("cheque_branch_bank").disabled = false;
    }
    function chkCash_pay_factory() {
        document.getElementById("date_pay_factory_credit").disabled = true;
        document.getElementById("cheque_number").disabled = true;
        document.getElementById("cheque_name_bank").disabled = true;
        document.getElementById("cheque_branch_bank").disabled = true;
        $("#date_pay_factory_credit").val('');//ล้างค่า
        $("#cheque_number").val('');
        $("#cheque_name_bank").val('');
        $("#cheque_branch_bank").val('');

    }
    function chkdateCredit() {
        if ($('#credit').is(':checked')) {
            document.getElementById("date_pay_factory_credit").required = true;
            document.getElementById("cheque_number").required = true;
            document.getElementById("cheque_name_bank").required = true;
            document.getElementById("cheque_branch_bank").required = true;
            // document.getElementById("cheque_number").required = true;
        } else {
            document.getElementById("date_pay_factory_credit").required = false;
            // document.getElementById("cheque_number").required = false;
        }
    }

</script>
<!--<h4 class="alert alert-danger" role="alert">1.เปลี่ยนสถานะสินค้าคืนในproduct_refund</h4>-->
<!--โค้ดใส่ได้เฉพาะตัวเลขเท่านั้น    onkeypress='return event.charCode >= 48 && event.charCode <= 57;'-->