<?php
require_once 'function/func_shipment.php';
?>
<?php
$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$getProduct_order = getProduct_orderByID($idproduct_order);
$val_name_product = $getProduct_order['name_product'];
$val_amount_product_order = $getProduct_order['amount_product_order'];
$val_name_unit = $getProduct_order['name_unit'];
$val_idunit = $getProduct_order['idunit'];
$val_idproduct = $getProduct_order['idproduct'];
//    echo $idshipment_period;

$price = $_GET['price'];
$status_shipment_factory = $_GET['status_shipment'];
?>
﻿<form class="form" action="action/action_edit_amount_product_order.php?idproduct_order=<?php echo $idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขจำนวนสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_product">ชื่อสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                        <input type="text" class="form-control" id="name_product" name="name_product" value="<?php echo $val_name_product; ?>" disabled>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="amount_product_order">จำนวน</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"></i></span>
                        <input type="text" class="form-control" id="amount_product_order" name="amount_product_order" value="<?php echo $val_amount_product_order; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_unit">หน่วยสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <select class="form-control" id="name_unit" name="name_unit" required >
                            <option selected value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option>
                            <?php
                            $getUnit = getUnit($val_idproduct,$val_idunit);
                            foreach ($getUnit as $value) {
                                $val_idunit = $value['idunit'];
                                $val_name_unit = $value['name_unit'];
                                ?>
                                <option value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option><?php
                            }
                            ?>
           
                            <?php ?>
                        </select>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>