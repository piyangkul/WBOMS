<?php
require_once 'function/func_docket.php';
require_once '../interface_shop/function/func_shop.php';
require_once '../shipment/function/func_shipment.php';
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$change_date_start = date("d-m-Y", strtotime($val_date_start));
$val_date_end = $getShipment_period['date_end'];
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
$getPayByID2 = getPayByID2($idshop,$idshipment_period);
$val_price_order_total = $getPayByID2['price_order_total'];
?>
<form class="form" action="action/action_#.php?idshipment_period=<?php echo $idshipment_period; ?>&idshop=<?php echo $idshop; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ข้อมูลสินค้าที่สั่งซื้อ</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo $change_date_start; ?> ถึง <?php echo $change_date_end; ?></h4></center>
                    <center><h4 class="text text-info"><b>ร้าน : </b> <?php echo $val_name_shop; ?>&nbsp; &nbsp; &nbsp; ที่อยู่ : <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?> &nbsp; &nbsp; เบอร์โทรศัพท์ : <?php echo $val_tel_shop; ?></h4></center>
                    <center><h4 class="text text-info"><b>ยอดเงินที่เรียกเก็บ</b> <?php echo number_format($val_price_order_total, 2); ?> บาท</h4></center>
                </div>
                <div class = "row">
                    <!--<div class = "col-md-1 col-sm-1 "></div>-->
                    <div class = "col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>รายการสินค้าที่สั่งซื้อ</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                        <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                        <th rowspan="2"><div align="center">โรงงาน</div></th>
                                        <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                        <th rowspan="2"><div align="center">จำนวน</div></th> 
                                        <th rowspan="2"><div align="center">ราคาขาย/หน่วย</div></th>
                                        <th rowspan="2"><div align="center">ราคาขาย</div></th>
                                        </tr>

                                        <tr>
                                            <th><div align="center">วันที่ส่ง</div></th>
                                        <th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
                                        <th><div align="center">ค่าส่ง</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                            $getProductDocketByID = getProductDocketByID($idshop, $idshipment_period);
                                            $i = 0;
                                            $n = 0;
                                            $sum_cost = 0;
                                            $sum_price_transport = 0;
                                            foreach ($getProductDocketByID as $value) {
                                                $i++;
                                                $val_idfactory = $value['idfactory'];
                                                $val_name_factory = $value['name_factory'];
                                                $val_name_product = $value['name_product'];
                                                $val_price_unit = $value['price_unit'];
                                                $val_amount_product_order = $value['amount_product_order'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_date_transport = $value['date_transport'];
                                                $val_name_transport = $value['name_transport'];
                                                $val_volume = $value['volume'];
                                                if ($val_volume == NULL) {
                                                    $val_volume = "-";
                                                }
                                                $val_number = $value['number'];
                                                if ($val_number == NULL) {
                                                    $val_number = "-";
                                                }
                                                $val_price_transport = $value['price_transport'];
                                                $val_difference_product_order = $value['difference_product_order']; //ขายลด
                                                $val_type_product_order = $value['type_product_order'];
                                                if ($value['type_product_order'] == "PERCENT") {
                                                    $cost = $val_price_unit - (($val_difference_product_order / 100.0) * $val_price_unit);
                                                } else {
                                                    $cost = $val_price_unit - $val_difference_product_order;
                                                }
                                                $sale = $cost * $val_amount_product_order;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <?php
                                                    $test = getProductDuplicateDocketByID($idshop, $idshipment_period, $val_name_transport, $val_number, $val_volume, $val_idfactory);
                                                    if ($test > 1) {
                                                        if ($n == 0) {
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . $val_date_transport . '</td>';
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</td>';
                                                            echo "<td class=\"text-right\" style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                                                            $sum_price_transport = $sum_price_transport + $val_price_transport;
                                                        }
                                                        $n++;
                                                        if ($n == $test) {
                                                            $n = 0;
                                                        }
                                                    } else {
                                                        ?>
                                                        <td><?php echo $val_date_transport; ?></td>
                                                        <td><?php echo $val_name_transport . "/" . $val_volume . "/" . $val_number; ?></td>
                                                        <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>
                                                        <?php
                                                        $sum_price_transport = $sum_price_transport + $val_price_transport;
                                                    }
                                                    ?>
                                                    <td><?php echo $val_name_factory; ?></td>  
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                                    <td class="text-right"><?php echo number_format($cost, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($sale, 2); ?></td>
                                                    <?php $sum_cost = $sum_cost + $sale; ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div align="right">ราคาขายรวม &nbsp;&nbsp; <b><?php echo number_format($sum_cost, 2); ?></b> &nbsp;&nbsp; บาท </div>                                  
                                    <div align="right">ค่าส่งรวม &nbsp;&nbsp; <b><?php echo number_format($sum_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                                    <div align="right">ยอดเงินเรียกเก็บสุทธิ &nbsp;&nbsp; <b><?php echo number_format($sum_cost + $sum_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
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
<!--<h4 class="alert alert-danger" role="alert">1.ทำautoCompleteไม่ได้</h4>-->