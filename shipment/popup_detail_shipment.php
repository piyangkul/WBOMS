<?php
require_once 'function/func_shipment.php';
?>
<?php
$idorder_p = $_GET['idorder_p'];
$idproduct_order = $_GET['idproduct_order'];
$getProduct_order = getProduct_orderByID($idproduct_order);
$val_name_factory = $getProduct_order['name_factory'];
$val_idorder_p = $getProduct_order['idorder_p'];
$val_date_order_p = $getProduct_order['date_order_p'];
$val_name_shop = $getProduct_order['name_shop'];
?>
﻿<form class="form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดสินค้าตามบิลขนส่ง</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_factory">จากโรงงาน</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <input type="text" class="form-control" id="name_factory" name="name_factory" value="<?php echo $val_name_factory; ?>"disabled="">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="idorder_p">จากเลขที่บิลสั่งซื้อ</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                        <input type="text" class="form-control" id="idorder_p" name="idorder_p" value="<?php echo $val_idorder_p; ?>"disabled="">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_order_p">วันที่สั่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        <input type="date" class="form-control" id="date_order_p" name="date_order_p" value="<?php echo $val_date_order_p; ?>"disabled="" >
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_shop">ชื่อร้านค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <input type="text" class="form-control" id="name_shop" name="name_shop" value="<?php echo $val_name_shop; ?>"disabled="" >
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
                    <label>ตารางรายการสินค้าจากบิลสั่งซื้อ</label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><div align="center">ลำดับ</div></th>
                            <th><div align="center">ชื่อสินค้า</div></th>
                            <th><div align="center">ราคาเปิด</div></th>
                            <th><div align="center">จำนวน</div></th>
                            <th><div align="center">ต้นทุนลด</div></th>
                            <th><div align="center">ราคาต้นทุน</div></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getProductDetail_shipment = getProductDetail_shipment($idorder_p);
                                $i = 0;
                                foreach ($getProductDetail_shipment as $value) {
                                    $i++;
                                    $val_name_product = $value['name_product'];
                                    $val_name_unit = $value['name_unit'];
                                    $val_price_unit = $value['price_unit'];
                                    if ($value['difference_amount_product'] == null) {
                                        $val_difference_amount = $value['difference_amount_factory'];
                                    } else {
                                        $val_difference_amount = $value['difference_amount_product'];
                                    }
                                    $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit);                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $val_name_product; ?></td>
                                        <td class="text-right"><?php echo number_format($val_price_unit, 2, '.', ''); ?></td>
                                        <td><?php echo '1' + $val_name_unit; ?></td>
                                        <td><?php echo $val_difference_amount . "%"; ?></td>
                                        <td class="text-right"><?php echo number_format($cost, 2, '.', '') ?></td>
                                    </tr>
<?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
