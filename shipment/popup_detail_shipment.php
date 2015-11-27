<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idproduct_order'])) {
    $idproduct_order = $_GET['idproduct_order'];
    $getProduct_order = getProduct_orderByID($idproduct_order);
    $val_name_factory = $getProduct_order['name_factory'];
    $val_idorder_p = $getProduct_order['idorder_p'];
    $val_date_order_p = $getProduct_order['date_order_p'];
    $val_name_shop = $getProduct_order['name_shop'];
}
?>
﻿<form class="form" action="action/action_editProduct_order.php?idproduct_order=<?php echo $idproduct_order; ?>" method="get">
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
                            <th><div align="center">ราคาเปิดต่อหน่วย</div></th>
                            <th><div align="center">จำนวน</div></th>
                            <th><div align="center">ต้นทุนลด</div></th>
                            <th><div align="center">ราคาต้นทุน</div></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
//                        $getMembers = getMembers();
//                        $i = 0;
//                        foreach ($getMembers as $value) {
//                            $i++;
//                            $val_idmember = $value['idmember'];
//                            $val_name = $value['name'];
//                            $val_lastname = $value['lastname'];
//                            $val_username = $value['username'];
//                            
                                ?>
                                    <!--<tr>-->
        <!--                                <td><?php echo $i; ?></td>
                                        <td><?php echo $val_name; ?></td>
                                        <td><?php echo $val_lastname; ?></td>
                                        <td><?php echo $val_username; ?></td>
                                        <td><?php ?></td>
                                        <td><?php ?></td>
                                        <td><?php ?></td>-->
                                <!--</tr>-->
                                <?php // }  ?>
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
