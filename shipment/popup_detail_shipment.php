<?php
require_once 'function/func_shipment.php';
?>
<?php
//$idorder_p = $_GET['idorder_p'];
//$idproduct_order = $_GET['idproduct_order'];
//$getProduct_order = getProduct_orderByID($idproduct_order);
//$val_name_factory = $getProduct_order['name_factory'];
//$val_idorder_p = $getProduct_order['idorder_p'];
//$val_date_order_p = $getProduct_order['date_order_p'];
//$val_name_shop = $getProduct_order['name_shop'];
$status_shipment = $_GET['status_shipment'];
$idorder_transport = $_GET['idorder_transport'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$idtransport = $_GET['idtransport'];
$volume = $_GET['volume'];
$number = $_GET['number'];
$price_transport = $_GET['price_transport'];
$price = $_GET['price'];

$getShipmentDetailByID = getShipmentDetailByID($idorder_transport, $idshipment_period, $idfactory);
$val_date_transport = $getShipmentDetailByID['date_transport'];
$val_name_transport = $getShipmentDetailByID['name_transport'];
$val_volume = $getShipmentDetailByID['volume'];
$val_number = $getShipmentDetailByID['number'];
$val_price_transport = $getShipmentDetailByID['price_transport'];
?>
﻿<form class="form" action="action/action_status_check_price.php?idorder_transport=<?php echo $idorder_transport; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดสินค้าตามบิลขนส่ง</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
<!--                <div class="alert alert-danger" role="alert">
                    1.กดได้อันเดียว
                    2.กรณี2สินค้าส่งพร้อมกัน ให้แสดงข้อมูลสินค้ามาทั้ง2อย่างไม่ได้ (ตารางรายการสินค้าจากบิลขนส่ง)
                </div>-->
                <div class="form-group col-xs-12">
                    <label for="date_transport">วันที่ส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_transport" value="<?php echo $val_date_transport; ?>" disabled/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อบริษัทขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="text" class="form-control" name="name_transport" value="<?php echo $val_name_transport; ?>" disabled/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="volume" value="<?php echo $val_volume; ?>" disabled/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="number" value="<?php echo $val_number; ?>" disabled/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="price_transport">ค่าส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar" ></i></span>
                        <input type="text" class="form-control" id="price_transport" name ="price_transport" value="<?php echo $val_price_transport; ?>" disabled/>
                        <span class="input-group-addon">.00</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--ตารางรายการสินค้า -->
    <div class = "row">
        <div class = "col-md-1 col-sm-1 "></div>
        <div class = "col-md-10 col-sm-10 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label>ตารางรายการสินค้าจากบิลขนส่ง</label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                            <thead>
<!--                                <tr>
                                    <th><div align="center">ลำดับ</div></th>
                            <th><div align="center">ชื่อสินค้า</div></th>
                            <th><div align="center">ราคาเปิด</div></th>
                            <th><div align="center">จำนวน</div></th>
                            <th><div align="center">ต้นทุนลด</div></th>
                            <th><div align="center">ราคาต้นทุน</div></th>
                            </tr>-->
                                <tr>
                                    <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                            <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                            <th rowspan="2"><div align="center">จำนวน</div></th>
                            <th colspan="5"><div align="center">ราคา/หน่วย</div></th>
                            <th colspan="3"><div align="center">ราคาทั้งหมด</div></th>
                            </tr>

                            <tr>
                                <th><div align="center">ราคาเปิด</div></th>
                            <th><div align="center">ต้นทุนลด</div></th>
                            <th><div align="center">ราคาต้นทุน</div></th>
                            <th><div align="center">ขายลด</div></th>
                            <th><div align="center">ราคาขาย</div></th>
                            <th><div align="center">ราคาเปิดรวม</div></th>
                            <th><div align="center">ราคาต้นทุนรวม</div></th>
                            <th><div align="center">ราคาขายรวม</div></th>
                            </tr>

                            </thead>
                            <tbody>
                                <?php
                                $sum_sale_transport = 0;
                                $getProductDetail_shipment = getProductDetail_shipment($idshipment_period, $idfactory, $idtransport, $volume, $number, $price_transport);
                                $i = 0;
                                foreach ($getProductDetail_shipment as $value) {
                                    $i++;
                                    $val_name_product = $value['name_product'];
                                    $val_amount_product_order = $value['amount_product_order'];
                                    $val_name_unit = $value['name_unit'];
                                    $val_price_unit = $value['price_unit']; //ราคาเปิด

                                    if ($value['difference_amount_product'] == null) {
                                        $val_difference_amount = $value['difference_amount_factory'];
                                    } else {
                                        $val_difference_amount = $value['difference_amount_product'];
                                    }
                                    $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit);

                                    $val_difference_product_order = $value['difference_product_order']; //ขายลด
                                    $val_type_product_order = $value['type_product_order'];
                                    if ($value['type_product_order'] == "PERCENT") {
                                        $cost2 = $val_price_unit - (($val_difference_product_order / 100.0) * $val_price_unit);
                                    } else {
                                        $cost2 = $val_price_unit - $val_difference_product_order;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $val_name_product; ?></td>
                                        <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td><!-- จำนวน-->
                                        <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td><!-- ราคาเปิด-->
                                        <td><?php echo $val_difference_amount . "%"; ?></td><!-- ต้นทุนลด-->                                      
                                        <td class="text-right"><?php echo number_format($cost, 2) ?></td><!-- ราคาต้นทุน-->
                                        <td><?php echo $val_difference_product_order; ?><?php echo ($val_type_product_order == "PERCENT") ? "%" : "฿"; ?></td>
                                        <td class="text-right"><?php echo number_format($cost2, 2); ?></td> <!-- ราคาขาย -->
                                        <td class="text-right"><?php echo number_format($val_price_unit * $val_amount_product_order, 2); ?></td>
                                        <td class="text-right"><?php echo number_format($cost * $val_amount_product_order, 2); ?></td> <!-- ราคาต้นทุนรวม--> 
                                        <td class="text-right"><?php echo number_format($cost2 * $val_amount_product_order, 2); ?></td> <!-- ราคาขายรวม--> 
                                        <?php $sum_sale_transport = $sum_sale_transport + $cost * $val_amount_product_order; ?>
                                    </tr>
                                <?php } ?>
                        </table>
                    </div>
                    <div class="col-md-6 col-md-offset-6">ยอดเงินสินค้าที่สั่งซื้อของบิล &nbsp;&nbsp; <b><?php echo number_format($sum_sale_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                    <div class="col-md-6 col-md-offset-6">ยอดเงินที่ต้องจ่ายโรงงานของบิล &nbsp;&nbsp; <b><?php echo number_format($sum_sale_transport+$val_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if ($status_shipment == 'add_shipment') { ?> <!-- สถานะรอเพิ่มข้อมูลการส่ง Lv1 --> 
            <button type="submit" name="sumbit" class="btn btn-primary" >Confirm</button>
        <?php } else {
            ?>
            <button type = "submit" name = "sumbit" class = "btn btn-primary" disabled>Confirm</button>
            <br><?php echo '<center><h4 class="text-danger">ไม่สามารถกดConfirmได้ เนื่องจากคุณทำการตรวจสอบไปแล้ว</h4></center>'; ?><!-- สถานะรอตรวจสอบยอดบิล Lv2 -->
         
 <?php }
        ?>
    </div>
</form>
<!-- เปลี่ยนสถานะ -->
<!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<?php //if ($status_shipment == 'add_shipment') { ?>  สถานะรอเพิ่มข้อมูลการส่ง Lv1  
            <button type="submit" name="sumbit" class="btn btn-primary" >Confirm</button>
<?php
// } elseif ($status_shipment == NULL) {
//            echo 'คุณไม่สามารถตรวจสอบได้ เนื่องจากคุณยังอยู่ในสถานะ1';
//            
?>
            <button type = "submit" name = "sumbit" class = "btn btn-primary" disabled>Confirm</button>
<?php
//} else {
//            
?>
<?php // echo 'คุณไม่สามารถตรวจสอบได้ เนื่องจากคุณทำการตรวจสอบไปแล้ว';  ?>
            <button type = "submit" name = "sumbit" class = "btn btn-primary" disabled>Confirm</button>
<?php
//}
//        
?>
    </div>-->