<?php
require_once 'function/func_docket.php';
require_once '../interface_shop/function/func_shop.php';
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

$idshop = $_GET['idshop'];
$getShop = getShopByID($idshop);
$val_name_shop = $getShop['name_shop'];
$val_name_region = $getShop['name_region'];
$val_name_province = $getShop['name_province'];
$val_tel_shop = $getShop['tel_shop'];
if ($val_tel_shop == NULL) {
    $val_tel_shop = "-";
}
//$getPayByID2 = getPayByID2($idshop, $idshipment_period);
//$val_price_order_total = $getPayByID2['price_order_total'];

$Beforeid = getBeforeid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
$val_before_idshipment_period = $Beforeid['idshipment_period'];
?>
<form class="form" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ข้อมูลสินค้าที่คืน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                    <center><h4 class="text text-info"><b>ร้าน : </b> <?php echo $val_name_shop; ?>&nbsp; &nbsp; &nbsp; <b>ที่อยู่ :</b> <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?> &nbsp; &nbsp; <b>เบอร์โทรศัพท์ : </b><?php echo $val_tel_shop; ?></h4></center>
                    <center><h4 class="text text-info" id="sum_refund2"></h4></center>
                </div>
                <div class = "row">
                    <!--<div class = "col-md-1 col-sm-1 "></div>-->
                    <div class = "col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>รายการสินค้าที่คืน</label>
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
                                    <div class="text-danger" align="right">ราคาคืนรวม &nbsp;&nbsp; <b><?php echo number_format($sum_refund, 2); ?></b> &nbsp;&nbsp; บาท </div>  
                                    <input type="hidden" id="sum_refund"  value="<?php echo number_format($sum_refund, 2); ?>" >      
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
    </div>
</form>
<script>
    $(document).ready(function () {

        var sum_refund = document.getElementById("sum_refund").value;
        var a = ("ราคาคืนรวม ").bold();
        var b = (" บาท").bold();
        document.getElementById("sum_refund2").innerHTML = a+sum_refund+b;
        
    });
</script>
<!--<h4 class="alert alert-danger" role="alert">1.ทำautoCompleteไม่ได้</h4>-->